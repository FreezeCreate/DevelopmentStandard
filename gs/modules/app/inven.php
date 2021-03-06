<?php

class inven extends AppController
{
    
    /**
     * 盘点列表
     */
    function index()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $model        = spClass('m_goods_order');
        $m_goods      = spClass('m_goods');
        
        $stock_id     = htmlentities($this->spArgs('stock_id')); //库房id
        $cateid       = htmlentities($this->spArgs('cateid'));   //商品类别id
//         $inven_status = htmlentities($this->spArgs('inven_status'));   //报损报溢出状态
        
        if (!empty($stock_id)) {
            $con .= ' and stock_id='.$stock_id.'';
            $page_con['stock_id'] = $stock_id;
        }
        if (!empty($cateid)) {
            $con .= ' and cateid='.$cateid.'';
            $page_con['cateid'] = $cateid;
        }
//         if (!empty($inven_status)){
//             $con .= ' and inven_status='.$inven_status.'';
//             $page_con['inven_status'] = $inven_status;
//         }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k => $v){
            //商品的积压和出库时间显示
            $goods = $m_goods->find(array('id' => $v['goods_id']), '', 'id,nextchuku,updatetime');
            $v['nextchuku']  = $goods['nextchuku'];
            $v['updatetime'] = $goods['updatetime'];
            
            $result['results'][$k] = $v;
            if ($results[$k]['nextchuku'] == '0000-00-00 00:00:00') $result['results'][$k]['nextchuku'] = '无';
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除盘点
     */
    function delInven()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'inven'),array('del' => 1));
        $this->delCommon('m_inven', $id);
    }
    
    /**
     * 盘点详情 审核详情TO DO
     * 按照线上来做
     */
    function invenInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_inven');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加盘点 
     */
    function saveInven()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_inven');
        
        $arg = array(
            'inven_house_id'   => '仓库',
            'inven_house_name' => '仓库',
            'inven_num'        => '商品', //id
            'inven_name'       => '商品',
            'inven_model'      => '',   //型号
            'inven_many'       => '',   //单位
            'room_num'         => '盘点库存',   //盘点库存
            'old_num'          => '系统库存',   //系统库存
            'saleid'           => '盘点人',
            'salename'         => '盘点人',
            'inven_date'       => '盘点时间',
        );
        $data              = $this->receiveData($arg);
        //报损报溢出状态 盈亏状态
        
        if ($data['room_num'] > $data['old_num']){  
            $data['inven_status'] = 2;
        }else {
            $data['inven_status'] = 1;
        }
        $data['inven_getlose'] = $data['room_num'] - $data['old_num'];  //盈亏记录
        
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['status']    = 1;
//         $data['order_num'] = $data['inven_num'];    //goods_order所需数据
        
        $up = $model->create($data);
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
//     function 
    
    /**
     * 积压-即最后一次出库时间+积压时间<现在的时间
     * 积压时间
     */
    function waitLst()
    {
        $admin      = $this->islogin();
        $con        = 'del = 0 and cid = ' . $admin['cid'];
        $order_name = urldecode(htmlspecialchars($this->spArgs('order_name')));   //商品名查找
        $model      = spClass('m_goods');
        $m_inven    = spClass('m_inven');
        $con       .= ' and '.time().'-UNIX_TIMESTAMP(nextchuku)>updatetime*60*60*24';
//         $real_sql = 'select a.updatetime,b.*,MAX(b.inven_date) from '.DB_NAME.'_goods_order as a,'.DB_NAME.'_inven as b where a.cid='.$admin['cid'].' and a.del=0 and b.cid='.$admin['cid'].' and b.del=0 and a.id=b.inven_num and '.time().'-UNIX_TIMESTAMP(b.inven_date)>a.updatetime*60*60*24 group by b.inven_num order by b.inven_date desc';
//         $sql    = 'select * from '.DB_NAME.'_goods_order where '.time().'-UNIX_TIMESTAMP(nextchuku)>updatetime*60*60*24';
//         $a = $model->findSql($sql);
//         dump($a);die;
        //找出超出积压时间的商品
        $sql        = 'select inven_num,inven_date from '.DB_NAME.'_inven where cid='.$admin['cid'].' and del=0 group by inven_num';
        $res_id     = $m_inven->findSql($sql);
        
        $last_data  = [];
        foreach ($res_id as $_k => $_v){
            $w8_sto      = time() - strtotime($_v['inven_date']);
            $w8_time     = round($w8_sto/60/60/24);   //计算真实积压天数
            $last_data[] = $model->find('cid='.$admin['cid'].' and del=0 and id='.$_v['inven_num'].' and updatetime<'.$w8_time.'');
        }
        if (!empty($order_name)) {
            $con .= ' and (order_name = "' . $order_name . '")';
            $page_con['order_name'] = $order_name;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 盘点里的库房商品列表
     */
    function invenGoodsLst()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_order');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->findAll('stock_id='.$id.' and cid='.$admin['cid']);
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 库房盘点
     */
    function saveInvenLst()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_inven');
        $m_order         = spClass('m_goods_order');
        $m_goods         = spClass('m_goods');
        
//         $arg = array(
//             'id'   => '库存id',
//             'room_num' => '盘点库存',
//         );
        
        foreach ($_REQUEST['list'] as $k => $data){
            $order_data = $m_order->find('id='.$data['id'].'');
            $goods_data = $m_goods->find('id='.$order_data['goods_id'].'');
            
            $data['inven_house_id'] = $order_data['stock_id'];
            $data['inven_house_name'] = $order_data['stock_name'];
            $data['inven_num'] = $order_data['goods_id'];
            $data['inven_name'] = $goods_data['order_name'];   //商品名称
            $data['inven_model'] = $goods_data['order_spec'];  //规格型号
            $data['inven_many'] = $goods_data['order_unit'];   //单位
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['saleid'] = $admin['id'];
            $data['salename'] = $admin['name'];
            $data['cid'] = $admin['cid'];
            $data['inven_date'] = date('Y-m-d H:i:s');
            $data['status'] = 3;
            $data['room_num'] = $data['room_num'];  //盘点库存
            $data['old_num'] = $order_data['order_num'];    //系统库存
            
            if ($data['room_num'] > $data['old_num']){
                $data['inven_status'] = 2;
            }else {
                $data['inven_status'] = 1;
            }
            $data['inven_getlose'] = $data['room_num'] - $data['old_num'];  //盈亏记录
            unset($data['id']);
            $up = $model->create($data);    //盘点单的录入
            $m_order->update(array('id' => $data['id']), array('order_num' => $data['room_num']));
        }
        $this->returnSuccess('成功');
    }
    
    
}

