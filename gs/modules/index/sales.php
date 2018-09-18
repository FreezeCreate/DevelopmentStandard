<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class sales extends IndexController {
    
    
    /*     * *******
     * 工作日报
     */
    function daily() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_daily');
        $m_admin = spClass('m_admin');
        $type = (int) htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $con = 'a.del = 0';
        if($name){
            $con .= ' and content like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        if(!empty($start)){
            $con .= ' and date >= '.date('Ymd',  strtotime($start));
            $page_con['start'] = $start;
        }
        if(!empty($end)){
            $con .= ' and date <= '.date('Ymd',  strtotime($end));
            $page_con['end'] = $end;
        }
        $uid = (int)htmlentities($this->spArgs('uid'));
        if(!empty($uid)){
            $con .= ' and a.uid ='.$uid;
            $page_con['uid'] = $uid;
        }
        switch ($type) {
            case 1:
                $con .= ' and a.uid = '.$admin['id'];
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and b.uid = ' . $admin['id'];
                $page_con['type'] = 2;
                break;
            default:
                $con .= ' and a.uid = '.$admin['id'];
                $page_con['type'] = 1;
                break;
        }
        $sql = 'select a.*,b.isread,b.readdt from yld_daily as a left outer join yld_flow_todos as b on (a.id = b.tid and b.modelid = 1 and b.uid = '.$admin['id'].') where (' . $con . ') order by a.updt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
        
        $admins = $m_admin->findAll('pid = '.$admin['id'],'','id,name');
        $this->admins = $admins;


        $time = date('Hi',time());
        if($time > $GLOBALS['DAILY_TIME'][3] && $time < $GLOBALS['DAILY_TIME'][4]){
            $this->stype = 1;
        }else{
            $this->stype = 0;
        }

    }

    function dailyAll() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_daily');
        $m_admin = spClass('m_admin');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $con = 'del = 0';
        if($name){
            $con .= ' and uname like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        if(!empty($start)){
            $con .= ' and date >= '.date('Ymd',  strtotime($start));
            $page_con['start'] = $start;
        }
        if(!empty($end)){
            $con .= ' and date <= '.date('Ymd',  strtotime($end));
            $page_con['end'] = $end;
        }
        $dep = urldecode(htmlspecialchars($this->spArgs('dep')));
        if(!empty($dep)){
            $deps = $m_admin->findAll('departmentname = "'.$dep.'"',null,'id');
            $uids[] = 0;
            foreach ($deps as $key => $value) {
                $uids[] = $value['id'];
            }
            $uids = implode(',',$uids);
            $con .= ' and uid in('.$uids.')';
            $page_con['dep'] = $dep;
        }
        $uid = (int)htmlentities($this->spArgs('uid'));
        if(!empty($uid)){
            $con .= ' and uid ='.$uid;
            $page_con['uid'] = $uid;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'updt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
        
        $tmp = $model->findAll('del = 0 ',null,'uid');
        $uids = array();
        $uids[] = 0;
        foreach($tmp as $k => $v){
            $uids[] = $v['uid'];
        }
        $uids = implode(',', $uids);
        $admins = $m_admin->findAll('id in('.$uids.')');
        
        $dep = array();
        foreach($admins as $k => $v){
            if(!in_array($v['departmentname'],$dep)){
                $dep[] = $v['departmentname'];
            }
        }
        $this->dep = $dep;
        $this->admins = $admins;
    }
    
    function findWorkplan(){
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $admin = $this->get_ajax_menu();
        $model = spClass('m_work_plan');
        $date = htmlentities($this->spArgs('date',date('Y-m-d')));
        $type = htmlentities($this->spArgs('type','month'));
        $uid = htmlentities($this->spArgs('uid',$admin['id']));
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
        
    }
    
    function myWorkplan(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_customer');
        $con = 'del = 0 and uid = '.$admin['id'];
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
        $this->page_con = $page_con;
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


    function findType(){
        $admin = $_SESSION['admin'];
        if(empty($admin)){
            $this->msg_json(0,'');
        }
        $type = $this->spArgs('type');
        
        if($type == '周报'){
            $year = date("Y");
            $month = date("m");
            $day = date('w');
            $nowMonthDay = date("t");
            $firstday = date('d') - $day;
            if(substr($firstday,0,1) == "-"){
              $firstMonth = $month - 1;
              $lastMonthDay =date("t",$firstMonth);
              $firstday = $lastMonthDay -substr($firstday,1);
              $time_1 = $year."-".$firstMonth."-".($firstday+1);
            }else{
              $time_1 = $year."-".$month."-".($firstday+1);
            }


             $lastday = date('d') + (7 - $day);
             if($lastday >$nowMonthDay){
              $lastday = $lastday - $nowMonthDay;
              $lastMonth = $month + 1;
              $time_2 =$year."-".$lastMonth."-".$lastday;
             }else{
              $time_2 =$year."-".$month."-".$lastday;
             }

            $where = 'select sum(yjphone) as yjphone,sum(yjyixiang) as yjyixiang,sum(phone) as phone,sum(yixiang) as yixiang from yld_daily where uid ='.$admin['id'].' and date >="'.$time_1.'" and date <="'.$time_2.'"';
       
        }else if($type == '月报'){
             $year = date("Y");
             $month = date("m");
             $allday = date("t");
             $time_1 =$year."-".$month."-1";
             $time_2 =$year."-".$month."-".$allday;


            $where = 'select sum(yjphone) as yjphone,sum(yjyixiang) as yjyixiang,sum(phone) as phone,sum(yixiang) as yixiang from yld_daily where uid ='.$admin['id'].' and date >="'.$time_1.'" and date <="'.$time_2.'"';
        }else if($type == '年报'){
            $year = date("Y");
             $time_1 =$year."-1-1";
             $time_2 =$year."-12-30";
            $where = 'select sum(yjphone) as yjphone,sum(yjyixiang) as yjyixiang,sum(phone) as phone,sum(yixiang) as yixiang from yld_daily where uid ='.$admin['id'].' and date >="'.$time_1.'" and date <="'.$time_2.'"';
        }

        $m_daily = spClass('m_daily');
        $result = $m_daily->findSql($where);
        $result = $result[0];
        $result['start'] = $time_1;
        $result['end'] = $time_2;
        $this->msg_json(0,'',$result);
    }
    
    //销售助手
    function aidelist(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $model = spClass('m_sales_aide');
        $con = 'del = 0';
        $name = htmlspecialchars($this->spArgs('name'));
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc');
          $this->results = $results;
          $this->pager = $model->spPager()->getPager();
          $this->page_con = $page_con;
    }
    
    function aide(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $model = spClass('m_sales_aide');
        $con = 'del = 0';
        $name = htmlspecialchars($this->spArgs('name'));
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc');
          $this->results = $results;
          $this->pager = $model->spPager()->getPager();
          $this->page_con = $page_con;
    }
    
    function aideinfo(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $model = spClass('m_sales_aide');
        $con = 'del = 0';
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'del'=>0));
        $this->result = $result;
    }
    
    function addaide(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $model = spClass('m_sales_aide');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'del'=>0));
        if($result){
            $this->result = $result;
        }
    }
    
    function saveAide(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_sales_aide');
        $id = (int)htmlentities($this->spArgs('id'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        if(empty($data['title'])){
            $this->msg_json(0, '标题不能为空');
        }
        if(empty($data['content'])){
            $this->msg_json(0, '内容不能为空');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d');
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在，请刷新重试');
            }
            $ad = $model->update(array('id'=>$id),$data);
        }else{
            $ad = $model->create($data);
        }
        if($ad){
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
        }
    }

}
