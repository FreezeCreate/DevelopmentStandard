<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class orders extends IndexController {
    
    function index(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_orders');
        $where = 'del = 0 and comid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (company like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'adddt desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function findCust(){
        $id = (int)htmlentities($this->spArgs('id'));
        $result = spClass('m_customer')->find(array('id'=>$id),'','id,name,phone,address');
        if($result){
            $this->msg_json(1, '成功',$result);
        }else{
            $this->msg_json(0, '暂无数据');
        }
    }
    
    function addOrders(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        
    }
    
    function ordersInfo(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_orders');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'comid'=>$admin['cid']));
        if($result){
            $ids = empty($result['files'])?'0':$result['files'];
            $result['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function saveOrders(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_orders');
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['cname'] = htmlspecialchars($this->spArgs('cname'));
        $data['cid'] = htmlspecialchars($this->spArgs('cid'));
        $data['uname'] = htmlspecialchars($this->spArgs('uname'));
        $data['uid'] = htmlspecialchars($this->spArgs('uid'));
        $data['phone'] = htmlspecialchars($this->spArgs('phone'));
        $data['address'] = htmlspecialchars($this->spArgs('address'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $files = $this->spArgs('files');
        if($files){
            $data['files'] = implode(',', $files);
        }
        $sum = $model->findCount('number like "%'.date('Ymd').'%"');
        $sum = $sum<9?'0'.($sum+1):($sum+1);
        $data['number'] = date('Ymd').$sum;
        $data['adddt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $data['comid'] = $admin['cid'];
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['date'] = date('Y-m-d');
        $ad = $model->create($data);
        if($ad){
            $quodata = array(
                'oid' => $ad,
                'status' => 0,
                'contact' => $data['cname'],
                'tel' => $data['phone'],
            );
            spClass('m_quotation')->create($quodata);
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
        }
    }

}
