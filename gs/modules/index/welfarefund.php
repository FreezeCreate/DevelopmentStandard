<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class welfarefund extends IndexController {
    
    function donate(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_fund_donation');
        $sql = 'select sum(money) as money from '.DB_NAME.'_fund_donation';
        $sum = $model->findSql($sql);
        $sql = 'select sum(money) as money from '.DB_NAME.'_fund_pay';
        $sum2 = $model->findSql($sql);
        $this->sum = array('money'=>$sum[0]['money'],'pay'=>$sum2[0]['money']);
        $order = 'adddt desc';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $con = 'uname like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $m_fund_obj = spClass('m_fund_obj');
        $objs = $m_fund_obj->findAll('del = 0');
        $this->objs = $objs;
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function saveDonate(){
        $admin = $this->get_ajax_menu();
        $data['uid'] = (int)$this->spArgs('uid');
        $data['money'] = htmlentities($this->spArgs('money'))*1;
        $data['objid'] = (int)$this->spArgs('objid');
        if(empty($data['money'])){
            $this->msg_json(0, '请填写捐赠金额');
        }
        $user = spClass('m_admin')->find(array('id'=>$data['uid']),'','id,name');
        if(empty($user)){
            $this->msg_json(0, '请选择捐赠人');
        }
        $obj = spClass('m_fund_obj')->find(array('id'=>$data['objid']),'','id,name');
        if(empty($obj)){
            $this->msg_json(0, '请选择捐赠对象');
        }
        $data['uname'] = $user['name'];
        $data['lava'] = $data['money'];
        $data['objname'] = $obj['name'];
        $data['adddt'] = date('Y-m-d H:i:s');
        $ad = spClass('m_fund_donation')->create($data);
        if($ad){
            spClass('m_fund_obj')->incrField(array('id'=>$data['objid']),'money',$data['money']);
            $data['id'] = $ad;
            $this->msg_json(1, '操作成功',$data);
        }else{
            $this->msg_json(0, '操作失败');
        }
    }
    
    function pay(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_fund_pay');
        $sql = 'select sum(money) as money from '.DB_NAME.'_fund_pay';
        $sum = $model->findSql($sql);
        $this->sum = $sum[0];
        $order = 'adddt desc';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $con = 'name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $objs = spClass('m_fund_obj')->findAll('del = 0');
        $this->objs = $objs;
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function savePay(){
        $admin = $this->get_ajax_menu();
        $data['money'] = htmlentities($this->spArgs('money'))*1;
        $data['oid'] = (int)$this->spArgs('objid');
        if(empty($data['money'])){
            $this->msg_json(0, '请填写支出金额');
        }
        $obj = spClass('m_fund_obj')->find(array('id'=>$data['oid']),'','id,name,`explain`');
        if(empty($obj)){
            $this->msg_json(0, '请选择支出对象');
        }
        $data['name'] = $obj['name'];
        $data['explain'] = $obj['explain'];
        $data['adddt'] = date('Y-m-d H:i:s');
        $ad = spClass('m_fund_pay')->create($data);
        if($ad){
            spClass('m_fund_obj')->decrField(array('id'=>$data['objid']),'pay',$data['money']);
            $data['id'] = $ad;
            $this->msg_json(1, '操作成功',$data);
        }else{
            $this->msg_json(0, '操作失败');
        }
    }
    
    function donationObj(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $con = 'name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $model = spClass('m_fund_obj');
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function saveDonation(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_fund_obj');
        $data['name'] = $this->spArgs('name');
        $data['type'] = $this->spArgs('type');
        $data['explain'] = $this->spArgs('explain');
        if(empty($data['name'])){
            $this->msg_json(0, '请填写捐赠对象名称');
        }
        if(empty($data['type'])){
            $this->msg_json(0, '请选择类型');
        }
        $data['money'] = 0;
        $data['pay'] = 0;
        $ad = $model->create($data);
        if($ad){
            $this->msg_json(1, '添加成功');
        }else{
            $this->msg_json(0, '添加失败');
        }
    }
    
    function deldonation(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_fund_obj');
        $id = (int)$this->spArgs('id');
        $re = $model->find(array('id'=>$id));
        if(empty($re)){
            $this->msg_json(0, '数据不存在');
        }
        $up = $model->update(array('id'=>$id),array('del'=>1));
        if($up){
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
        }
    }

}
