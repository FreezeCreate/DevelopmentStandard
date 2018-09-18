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
        $this->delCommon('m_inven', $id);
    }
    
    /**
     * 盘点详情
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
     * 盘点积压列表
     */
    function waitLst()
    {
        $admin      = $this->islogin();
        $con        = 'del = 0 and cid = ' . $admin['cid'];
        $order_name = urldecode(htmlspecialchars($this->spArgs('order_name')));   //商品名查找
        $model      = spClass('m_goods_order');
        
        //找出超出积压时间的商品
        $sql        = 'select inven_num from '.DB_NAME.'_inven where cid='.$admin['cid'].' and del=0 group by inven_num';
        $res_id     = spClass('m_inven')->findSql($sql);
        
        $last_data = [];
        foreach ($res_id as $_v){
            $last_data[] = spClass('m_inven')->find('inven_num='.$_v['inven_num'], 'inven_date desc', 'inven_num,inven_date');
        }
        if (!empty($order_name)) {
            $con .= ' and (order_name = "' . $order_name . '")';
            $page_con['order_name'] = $order_name;
        }
//         $sql2 = 'select *from '.DB_NAME.'_goods_order where id in (1,2)';
//         $asd = $model->findSql($sql2);
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    
    
    
}

