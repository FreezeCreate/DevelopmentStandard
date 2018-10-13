<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class warehouse extends AppController 
{
    
    /**
     * 入库列表
     */
    function ruku(){
        $admin = $this->islogin();
        $model = spClass('m_ruku');
        $con = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('goods_name')));
        $st = spClass('m_flow_set')->find(array('id'=>14));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        if (!empty($searchname)) {
            $con .= ' and concat(dt,goods_name,ru_num) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $result['status'] = $statustxt;
        $this->returnSuccess('成功', $result);
        
    }
    
    /**
     * 入库详情
     */
    function rukuInfo(){
        $this->islogin();
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 14);
    }
    
    /**
     * 
     */
//     function addRuku(){
//         $admin = $this->islogin();
//         $model = spClass('m_ruku');
//         $id = (int)htmlentities($this->spArgs('id'));
//         $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
//         $this->returnSuccess('成功', $result);
//     }
    
    /**
     * 入库新增
     */
    function saveRuku()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_ruku');
        $id              = (int)htmlentities($this->spArgs('id'));
        $m_inout         = spClass('m_stock_inout');
        $m_room          = spClass('m_stock_room');
        $m_goods         = spClass('m_goods');
        $m_order         = spClass('m_goods_order');
        
        $arg = array(
//             'goods_id'   => '入库产品id',
//             'goods_name' => '入库产品',
            'dt'         => '入库日期',
            'contnet'    => '', //备注详细内容
//             'ru_num'     => '数量',
        );
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $data['status']    = 1;
            $up = $model->create($data);
            //副表数据新增
            if ($up){
                foreach ($_REQUEST['list'] as $k => $v){
                    $goods_name = $m_goods->find('id='.$v['goods_id'].'', '', 'id,order_name,cateid,catename,order_spec,order_unit,order_explain');
                    $v['goods_name'] = $goods_name['order_name'];
                    $room       = $m_room->find('id='.$v['room_id'].'', '', 'id,room_name');
                    $v['room_name'] = $room['room_name'];
                    $v['optid']     = $admin['id'];
                    $v['optname']   = $admin['name'];
                    $v['optdt']     = date('Y-m-d H:i:s');
                    $v['cid']       = $admin['cid'];
                    $v['invoice_id']= $up;
                    $v['status']    = 1;
                    //附表新增数据
                    $m_inout->create($v);
                    //采购对库存表的影响
                    $order_data = $m_order->find('goods_id='.$goods_name['id'].' and stock_id='.$room['id'].' and del=0 and cid='.$admin['cid'].'');
                    if (empty($order_data)){
                        //新增库存数据
                        $o_data['cateid'] = $goods_name['cateid'];
                        $o_data['goods_id'] = $goods_name['id'];
                        $o_data['order_name'] = $goods_name['order_name'];
                        $o_data['order_spec'] = $goods_name['order_spec'];
                        $o_data['order_unit'] = $goods_name['order_unit'];
                        $o_data['order_explain'] = $goods_name['order_explain'];
                        $o_data['stock_id'] = $v['room_id'];
                        $o_data['stock_name'] = $room['room_name'];
                        $o_data['order_num'] = $v['goods_num'];
                        
                        $m_order->create($data);
                    }else {
                        //更新库存数据
                        $o_data['order_num'] = $order_data['order_num'] + $v['goods_num'];
                        $m_order->update(array('id' => $order_data), array('order_num' => $o_data['order_num']));
                    }
                    $o_data = array();  //置空数据
                }
            }
        }
        
        if($up){
            $this->sendUpcoming($admin, 14, $up, '入库单');
            $this->returnSuccess('成功');
        } 
        $this->returnError('失败');
    }
    
    /**
     * 入库删除
     */
    function delRuku()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'ruku'),array('del' => 1));
        $this->delCommon('m_ruku', $id);
    }
    
    /**
     * 出库列表
     */
    function chuku(){
        $admin = $this->islogin();
        $model = spClass('m_chuku');
        $con = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('goods_name')));
        $st = spClass('m_flow_set')->find(array('id'=>17));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        if(!empty($name)){
            $con .= ' and (goods_name like "%'.$name.'%")';
            $page_con['goods_name'] = $name;
        }
        
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        if (!empty($searchname)) {
            $con .= ' and concat(dt,goods_name,chu_num) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $result['status'] = $statustxt;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 出库详细
     */
    function chukuInfo(){
        $this->islogin();
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 17);
    }
    
//     function addChuku(){
//         $result = $this->get_menu();
//         $this->menu = $result['menu'];
//         $admin = $result['admin'];
//         $model = spClass('m_chuku');
//         $id = (int)htmlentities($this->spArgs('id'));
//         $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
//         if($result){
//             $result['children'] = spClass('m_chuku_produce')->findAll(array('pid'=>$id));
//             $this->result = $result;
//         }
//     }
    
    /**
     * 出库新增
     */
    function saveChuku(){
        $admin           = $this->islogin();
        $model           = spClass('m_chuku');
        $id              = (int)htmlentities($this->spArgs('id'));
        $m_inout = spClass('m_stock_inout');
        $m_room  = spClass('m_stock_room');
        $m_order  = spClass('m_goods_order');
        $m_goods           = spClass('m_goods');
        
        
        $arg = array(
//             'goods_id'   => '出库产品id',
//             'goods_name' => '入库产品',
            'dt'         => '出库日期',
//             'chu_num'    => '数量',
            'content'      => '',   //备注详细内容
            
        );
        $data = $this->receiveData($arg);
        
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);   //重写更新
            if ($up) $up = $re['id'];
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $data['status']    = 1;
//             $data['order_num'] = $goods_info['order_num'] - $data['chu_num'];//重写的create所需数据
            $up = $model->create($data);
            //副表数据新增
            if ($up){
                foreach ($_REQUEST['list'] as $k => $v){
                    $goods_name = $m_goods->find('id='.$v['goods_id'].'', '', 'id,order_name,cateid,catename,order_spec,order_unit,order_explain');
                    $v['goods_name'] = $goods_name['order_name'];
                    $room       = $m_room->find('id='.$v['room_id'].'', '', 'id,room_name');
                    $v['room_name'] = $room['room_name'];
                    $v['optid']     = $admin['id'];
                    $v['optname']   = $admin['name'];
                    $v['optdt']     = date('Y-m-d H:i:s');
                    $v['cid']       = $admin['cid'];
                    $v['invoice_id']= $up;
                    $v['status']    = 1;
                    //附表新增数据
                    $m_inout->create($v);
                    //采购对库存表的影响
                    $order_data = $m_order->find('goods_id='.$goods_name['id'].' and stock_id='.$room['id'].' and del=0 and cid='.$admin['cid'].'');
                    if (empty($order_data)){
                        //新增库存数据
                        $o_data['cateid'] = $goods_name['cateid'];
                        $o_data['goods_id'] = $goods_name['id'];
                        $o_data['order_name'] = $goods_name['order_name'];
                        $o_data['order_spec'] = $goods_name['order_spec'];
                        $o_data['order_unit'] = $goods_name['order_unit'];
                        $o_data['order_explain'] = $goods_name['order_explain'];
                        $o_data['stock_id'] = $v['room_id'];
                        $o_data['stock_name'] = $room['room_name'];
                        $o_data['order_num'] = $v['goods_num'];
                        
                        $m_order->create($data);
                    }else {
                        //更新库存数据
                        $o_data['order_num'] = $order_data['order_num'] - $v['goods_num'];
                        $m_order->update(array('id' => $order_data), array('order_num' => $o_data['order_num']));
                    }
                    $o_data = array();  //置空数据
                }
            }
        }
        
        if($up){
            //对商品表的最后出库时间更新
            $goods_arr = $model->find('id='.$up, '', 'goods_id');
            spClass('m_goods_order')->update(array('id' => $goods_arr['goods_id']), array('nextchuku' => $data['dt']));
            $this->sendUpcoming($admin, 17, $up, '出库单');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
        
    }
    
    /**
     * 出库删除
     */
    function delChuku()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'chuku'),array('del' => 1));
        $this->delCommon('m_chuku', $id);
    }
    
    
    /**
     * 入出库的商品列表单
     */
    function rukuGoodsLst()
    {
        $admin     = $this->islogin();
        $id        = (int)htmlentities($this->spArgs('id'));
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $con      .= ' and status=3 and stock_id='.$id.'';
        $model     = spClass('m_stock_inout');
        $result    = $model->findAll($con);
        
        $this->returnSuccess('成功', $result);
    }
    
    function chukuGoodsLst()
    {
        $admin     = $this->islogin();
        $id        = (int)htmlentities($this->spArgs('id'));
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $con      .= ' and status=4 and stock_id='.$id.'';
        $model     = spClass('m_stock_inout');
        $result    = $model->findAll($con);
        
        $this->returnSuccess('成功', $result);
    }
    
    
    
}
