<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class sell extends IndexController {
    
    function orders(){
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
            $where .= ' and (cname like "%'.$name.'%" or name like "%'.$name.'%")';
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
    
    function delOrders(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_orders');
        $id = (int)htmlentities($this->spArgs('id'));
        $re = $model->find(array('id'=>$id,'del'=>0));
        if(empty($re)){
            $this->msg_json(0, '数据不存在');
        }
        $del = $model->update(array('id'=>$id),array('del'=>1,'optid'=>$admin['id'],'optname'=>$admin['name'],'optdt'=>date('Y-m-d H:i:s')));
        if($del){
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
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
        if(empty($data['name'])){
            $this->msg_json(0, '请填写订单名称');
        }
        if(empty($data['cid'])){
            $this->msg_json(0, '请选择客户');
        }
        if(empty($data['uid'])){
            $this->msg_json(0, '请选择业务员');
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
                 'cid'=>$admin['cid'],
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
    
    function contract(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_contract');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            if($status==2){
                $con .= ' and b.status in(0,2)';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (number like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a left outer join '.DB_NAME.'_contract as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function contractInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 3);
    }
    
    function editContract(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_contract');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        $this->project = spClass('m_project')->findAll();
        if($result){
            $ids = empty($result['files'])?'0':$result['files'];
            $result['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
            $result['children'] = spClass('m_quo_project')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            //新增逻辑
            $sql = 'select oid from '.DB_NAME.'_contract where del=0 and cid='.$admin['cid'].' group by oid';
            $exist_orders = $model->findSql($sql);
            foreach ($exist_orders as $k => $v){
                if (empty($v['oid'])) continue;
                if ($k + 1 == count($exist_orders)){
                    $o_id .= $v['oid'];
                    continue;
                }
                $o_id .= $v['oid'].',';
            }
            //订单选择
            if (empty($o_id)){
                $all_orders = array();
            }else {
                $o_sql      = 'select id,name from '.DB_NAME.'_orders where del=0 and comid='.$admin['cid'].' and id not in ('.$o_id.')';
                $all_orders = spClass('m_orders')->findSql($o_sql);
            }
            $this->all_orders = $all_orders;
//             $this->error('信息不存在');
        }
    }
    
    function saveContract(){
        $admin = $this->get_ajax_menu();
        //订单选择处理
        $oid = htmlspecialchars($this->spArgs('oid'));
        if (!empty($oid)) $data['oid'] = $oid;
        $model = spClass('m_contract');
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['cname'] = htmlspecialchars($this->spArgs('cname'));
        $data['startdt'] = htmlspecialchars($this->spArgs('startdt'));
        $data['enddt'] = htmlspecialchars($this->spArgs('enddt'));
        $data['uid'] = htmlspecialchars($this->spArgs('uid'));
        $data['phone'] = htmlspecialchars($this->spArgs('phone'));
        $data['money'] = htmlspecialchars($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $data['content'] = $data['explain'];
        $id = (int)htmlentities($this->spArgs('id'));
        $files = $this->spArgs('files');
        if($files){
            $data['files'] = implode(',', $files);
        }
        $sum = $model->findCount('number like "%C'.date('Ymd').'%"');
        $sum = $sum<9?'0'.($sum+1):($sum+1);
        $data['number'] = 'C'.date('Ymd').$sum;
        $data['adddt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $data['cid'] = $admin['cid'];
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在');
            }
            if($re['status']>=3){
                $this->msg_json(0, '该合同已审核，不可操作');
            }
            if(!empty($re['number'])){
                unset($data['number']);
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $this->sendUpcoming(3, $id, '【'.$data['name'].'】合同');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $up = $model->create($data);
            $this->msg_json(1, '操作成功');
            
//             $this->msg_json(0, '操作失败1');
        }
        
    }
    
    function fankui(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_fankui');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>28));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    

}
