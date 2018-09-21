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
        $searchname   = urldecode(htmlspecialchars($this->spArgs('searchname')));
        
        $model        = spClass('m_inven');
        
        if (!empty($inven_house_name)) {
            $con .= ' and concat(inven_house_name,inven_name,inven_getlose,salename,inven_date) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
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
     * 删除盘点
     */
    function delInven()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'inven'),array('del' => 1));
        $this->delCommon('m_inven', $id);
    }
    
    /**
     * 盘点详情 审核详情TODO
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
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'inven_house_id'   => '仓库',
            'inven_house_name' => '仓库',
            'inven_num'        => '商品',
            'inven_name'       => '商品',
            'inven_model'      => '型号',
            'inven_many'       => '单位',
            'inven_status'     => '盈亏状态',
            'inven_getlose'    => '盈亏记录',
            'saleid'           => '盘点人',
            'salename'         => '盘点人',
            'inven_date'       => '盘点时间',
        );
        $data              = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['status']    = 1;
        $data['order_num'] = $data['inven_num'];    //goods_order所需数据
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('盘点不存在');
            
            $up = $model->update(array('id'=>$id, 'cid' => $admin['cid']),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 积压-即最后一次出库时间+积压时间<现在的时间
     * 积压时间
     */
    function waitLst()
    {
        $admin      = $this->islogin();
        $con        = 'del = 0 and cid = ' . $admin['cid'];
        $order_name = urldecode(htmlspecialchars($this->spArgs('order_name')));   //商品名查找
        $model      = spClass('m_goods_order');
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
        foreach ($res_id as $_v){
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
    
    
    
    
}

