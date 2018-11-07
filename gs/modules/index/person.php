<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class person extends IndexController {
    
    
    /*     * ******
     * 流程待办
     * ******* */

    function upcoming() {
        $result = $this->get_menu();
        //拿到token
        $this->token = $result['admin']['login'];
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int)htmlspecialchars($this->spArgs('sid'));
        $type = (int)htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['type']][] = $v;
        }
        $this->set = $set;
        if($type==1){
            $con = 'del = 0 and allcheckid like "%,'.$admin['id'].',%"';
            $page_con['type'] = $type;
        }else{
            $con = 'del = 0 and nowcheckid like "%,'.$admin['id'].',%"';
        }
        if($sid){
            $con .= ' and modelid = '.$sid;
            $page_con['sid'] = $sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
            $page_con['applydt'] = $applydt;
        }
        if($name){
            $con .= ' and (uname like "%'.$name.'%" or udeptname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_flow_bill->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    /*************
     * 消息提醒
     */
    function remind(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_todos = spClass('m_flow_todos');
        $type = (int)htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'senddt < '.time().' and uid = '.$admin['id'];
        $con .= ' and cid='.$admin['cid'].'';
        switch ($type) {
            case 1:
                $con .= ' and isread = 0';
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and isread = 1';
                $page_con['type'] = 2;
                break;
            default:
                break;
        }
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $m_flow_todos->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'adddt desc,id desc');
        $this->results = $results;
        $this->pager = $m_flow_todos->spPager()->getPager();
        $this->page_con = $page_con;
    }
    

    /*     * *******
     * 通知公告
     */
    function infor() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_infor = spClass('m_infor');
        $type = (int) htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'a.del = 0 and a.cid = '.$admin['cid'];
        if($name){
            $con .= ' and a.title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        switch ($type) {
            case 1:
                $con .= ' and (b.uid = '.$admin['id'].' or a.optid = ' . $admin['id'] . ')';
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and a.optid = ' . $admin['id'];
                $page_con['type'] = 2;
                break;
            case 3:
                $con .= ' and b.uid = '.$admin['id'].' and isread = 0';
                $page_con['type'] = 3;
                break;
            default:
                $con .= ' and (b.uid = '.$admin['id'].' or a.optid = ' . $admin['id'] . ')';
                $page_con['type'] = 1;
                break;
        }
        $sql = 'select a.*,b.isread,b.readdt from '.DB_NAME.'_infor as a left outer join '.DB_NAME.'_flow_todos as b on (a.id = b.tid and b.modelid = 1 and b.uid = '.$admin['id'].') where (' . $con . ') order by a.date desc';
        $results = $m_infor->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $m_infor->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delInfor(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $model = spClass('m_infor');
        $m_flow_todos = spClass('m_flow_todos');
        $m_flow_log = spClass('m_flow_log');
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
        if (empty($re)) {
            $this->msg_json(0, '信息不存在');
        }
        $up = $model->update(array('id' => $id), array('del' => 1));
        if ($up) {
            $m_flow_todos->delete(array('table' => 'infor', 'tid' => $id), array('nowcheckid' => 0, 'nowcheckname' => '', 'del' => 1));
            $data_log = array('table' => 'infor', 'tid' => $id, 'status' => 0, 'statusname' => '删除', 'name' => '已删除', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '已删除', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id']);
            $m_flow_log->create($data_log);
            $this->msg_json(1, '操作成功',$id);
        } else {
            $this->msg_json(0, '操作失败');
        }
    }


    /*     * *******
     * 任务
     */
    function work() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id'=>9));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach($st as $k=>$v){
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $model = spClass('m_work');
        $type = (int) htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        switch ($type) {
            case 1:
                $con .= ' and uid = '.$admin['id'];
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and distid = ' . $admin['id'];
                $page_con['type'] = 2;
                break;
            case 3:
                $con .= ' and distid = ' . $admin['id'].' and status = 1';
                $page_con['type'] = 3;
                break;
            default:
                $con .= ' and uid = '.$admin['id'];
                $page_con['type'] = 1;
                break;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function voidWork(){
        $user = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowVoid('work', $id,$user);
        
    }
    
    function delWork(){
        $user = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowDel('work', $id,$user);
    }


    function ourpayroll(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $m_payroll = spClass('m_payroll');
        $month = (int)$this->spArgs('month');
        if(!empty($month)){
            $con['month'] = $month;
        }
        $con['uid'] = $admin['id'];
        $payroll = $m_payroll->findAll($con,'month asc');
        $this->payroll = $payroll;
    }
    
    
    function findWorkplan(){
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $admin = $this->get_ajax_menu();
        $model = spClass('m_work_plan');
        $date = htmlentities($this->spArgs('date',date('Y-m-d')));
        $type = htmlentities($this->spArgs('type','month'));
        $uid = (int)htmlentities($this->spArgs('uid'));
        $uid = empty($uid)?$admin['id']:$uid;
        $con = 'uid = '.$uid;
        if($type==='month'){
            $time = strtotime($date);
            $start = date('Ym01',$time);
            $end = date('Ymt',$time);
            $con .= ' and stdt <= '.$end.' and enddt >= '.$start;
        }else if($type==='week'){
            $time = strtotime($date);
            $start = date('Ymd',$time);
            $end = date('Ymd',$time+86400*7);
            $con .= ' and stdt <= '.$end.' and enddt >= '.$start;
        }else if($type==='day'){
            $time = strtotime($date);
            $start = date('Ymd',$time);
            $con .= ' and stdt <= '.$start.' and enddt >= '.$start;
        }
        $result = $model->findAll($con);
        foreach($result as $k=>$v){
            $st = strtotime($v['stdt']);
            $en = strtotime($v['enddt']);
            $j = ($en-$st)/86400;
            for($i=0;$i<=$j;$i++){
                $time = $st+86400*$i;
                $tmp[date('Y-m-d',$time)][] = array(
                    'id' => $v['id'],
                    'month' => date('Y-m',$time),
                    'year' => date('Y',$time),
                    'month' => date('m',$time)*1,
                    'day' => date('d',$time)*1,
                    'start' => $v['start'],
                    'end' => $v['end'],
                    'title' => $v['title'],
                    'level' => $v['level'],
                    'fankui' => json_decode($v['fankui']),
                );
            }
        }
        foreach($tmp as $k=>$v){
            $results[] = array(
                'date' => $k,
                'result' => $v,
            );
        }
        echo json_encode($results);
                exit();
    }
    
    function savePlan(){
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $admin = $this->get_ajax_menu();
        $model = spClass('m_work_plan');
        $date = htmlentities($this->spArgs('date',date('Y-m-d')));
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $title = htmlspecialchars($this->spArgs('title'));
        $level = htmlentities($this->spArgs('level'));
        $data['uid'] = $admin['id'];
        $data['uname'] = $admin['name'];
        $data['stdt'] = $date;
        $data['enddt'] = $date;
        $data['start'] = $start;
        $data['end'] = empty($end)?$start:$end;
        $data['title'] = $title;
        $data['level'] = $level;
        $data['adddt'] = date('Y-m-d H:i:s');
        if(empty($data['stdt'])){
            $this->msg_json(0, '请选择日期');
        }
        if(empty($data['start'])){
            $this->msg_json(0, '请填写开始时间');
        }
        if(empty($data['title'])){
            $this->msg_json(0, '请填写计划内容');
        }
        $ad = $model->create($data);
        if($ad){
            $data['id'] = $ad;
            $this->msg_json(1, '操作成功',$data);
        }else{
            $this->msg_json(0, '操作失败');
        }
    }
    
    function saveFankui(){
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $model = spClass('m_work_plan');
        $id = (int)htmlentities($this->spArgs('id'));
        $content = htmlspecialchars($this->spArgs('fankui'));
        $re = $model->find(array('id'=>$id));
        if(empty($content)){
            $this->msg_json(0, '请填写反馈信息');
        }
        if(empty($re)){
            $this->msg_json(0, '数据有误');
        }
        $fankui = empty($re['fankui'])?array():json_decode($re['fankui'],true);
        $fankui[] = array(
            'dt' => date('Y-m-d H:i:s'),
            'content' => $content,
        );
        $fankui = json_encode($fankui);
        $up = $model->update(array('id'=>$id),array('fankui'=>$fankui));
        if($up){
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
        }
    }
    
    function userPlan(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $uid = htmlentities($this->spArgs('uid'));
        $this->uid = $uid;
    }
    
    function myWorkplan(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        /*$model = spClass('m_customer');
        $con = 'del = 0 and uid = '.$uid;
        $order = 'adddt desc';
        $status = (int)  htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $con .= ' and status = '.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (name like "%'.$name.'%" or linkname like "%'.$name.'%" or unitname like "%'.$name.'%" or optname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;*/
    }
    
    function mySubordinate(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_admin');
        $con = 'pid = '.$admin['id'];
        $order = 'id desc';
        $status = (int)  htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $con .= ' and status = '.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (name like "%'.$name.'%" or phone like "%'.$name.'%" or email like "%'.$name.'%" or QQ like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function subWordplan(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_admin = spClass('m_admin');
        $model = spClass('m_work_plan');
        $con = 'pid = '.$admin['id'];
        $admins = $m_admin->findAll('pid = '.$admin['id']);
        foreach($admins as $v){
            $aids[] = $v['id'];
        }
        $adis = empty($aids)?0:implode(',', $aids);
        $con = 'uid in ('.$adis.')';
        $order = 'stdt desc';
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($start)){
            $con .= ' and stdt >= '.date('Ymd',  strtotime($start));
            $page_con['start'] = $start;
        }
        if(!empty($end)){
            $con .= ' and stdt <= '.date('Ymd',  strtotime($end));
            $page_con['end'] = $end;
        }
        if(!empty($name)){
            $con .= ' and (uname like "%'.$name.'%" or title like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        foreach($results as $k=>$v){
            $fankui = empty($v['fankui'])?array():  json_decode($v['fankui'],true);
            $results[$k]['fankui'] = '';
            foreach($fankui as $k1=>$v1){
                $results[$k]['fankui'] .= $v1['content'].'<br/>';
            }
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function wordPlans(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_work_plan');
        $con = '1 = 1';
        $order = 'stdt desc';
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($start)){
            $con .= ' and stdt >= '.date('Ymd',  strtotime($start));
            $page_con['start'] = $start;
        }
        if(!empty($end)){
            $con .= ' and stdt <= '.date('Ymd',  strtotime($end));
            $page_con['end'] = $end;
        }
        if(!empty($name)){
            $con .= ' and (uname like "%'.$name.'%" or title like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        foreach($results as $k=>$v){
            $fankui = empty($v['fankui'])?array():  json_decode($v['fankui'],true);
            $results[$k]['fankui'] = '';
            foreach($fankui as $k1=>$v1){
                $results[$k]['fankui'] .= $v1['content'].'<br/>';
            }
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

}
