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
        
        $arg = array(
            'goods_id'   => '入库产品id',
            'goods_name' => '入库产品',
            'dt'         => '入库日期',
            'ru_num'     => '数量',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['status']    = 1;
        $m_goods           = spClass('m_goods_order');
        $goods_info        = $m_goods->find('id='.$data['goods_id']);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('不存在');
            
            //库存表更新数量
            if ($data['ru_num'] > $re['ru_num']){
                $data['order_num'] = $goods_info['order_num'] + ($data['ru_num'] - $re['ru_num']);//重写的update所需数据
            }else {
                $data['order_num'] = $goods_info['order_num'] - ($re['ru_num'] - $data['ru_num']);
            }
            
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $data['order_num'] = $goods_info['order_num'] + $data['ru_num'];
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 14, $up, '入库【'.$data['goods_name'].'】 数量'.$data['ru_num']);
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
        
        $arg = array(
            'goods_id'   => '出库产品id',
            'goods_name' => '入库产品',
            'dt'         => '入库日期',
            'chu_num'    => '数量',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $m_goods           = spClass('m_goods_order');
        $goods_info        = $m_goods->find('id='.$data['goods_id']);
        $data['status']    = 1;
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('不存在');
            
            //库存表更新数量
//             if ($data['chu_num'] > $re['chu_num']){
//                 $data['order_num'] = $goods_info['order_num'] - ($data['chu_num'] - $re['chu_num']);//重写的update所需数据
//             }else {
//                 $data['order_num'] = $goods_info['order_num'] + ($re['chu_num'] - $data['chu_num']);
//             }
            
            $up = $model->update(array('id'=>$id),$data);   //重写更新
            if ($up) $up = $re['id'];
        }else{
//             $data['order_num'] = $goods_info['order_num'] - $data['chu_num'];//重写的create所需数据
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 17, $up, '出库【'.$data['goods_name'].'】 数量'.$data['chu_num']);
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
    
    
    
    
}
