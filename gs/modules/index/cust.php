<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class cust extends IndexController {
    
    function mycustomer(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_customer');
        $con = 'del = 0 and uid = '.$admin['id'].' and status = 1';
        $order = 'adddt desc';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $con .= ' and (name like "%'.$name.'%" or linkname like "%'.$name.'%" or unitname like "%'.$name.'%" or optname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function mycdcustomer(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_admin = spClass('m_admin');
        $childrens = $m_admin->findAll(array('pid'=>$admin['id']),'','id,name');
        $this->childrens = $childrens;
        $unds = array(0);
        foreach($childrens as $v){
            $unds[] = $v['id'];
        }
        $unds = implode(',', $unds);
        $model = spClass('m_customer');
        $con = 'del = 0 and uid in ('.$unds.') and uid > 0 and status = 1';
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
    
    function allocation(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_customer');
        $time = htmlentities($this->spArgs('time'));
        $con = 'del = 0 and (uid = 0 or status = 0)';
        $order = 'adddt desc';
        if($time==1){
            $day = date('YmdHis',strtotime('-3day'));
            $con .= ' and adddt >= '.$day;
            $page_con['time'] = 1;
        }else if($time == 2){
            $day = date('YmdHis',strtotime('-7day'));
            $con .= ' and adddt >= '.$day;
            $page_con['time'] = 2;
        }else if($time == 3){
            $day = date('YmdHis',strtotime('-1month'));
            $con .= ' and adddt >= '.$day;
            $page_con['time'] = 3;
        }else if($time == 4){
            $day = date('YmdHis',strtotime('-3month'));
            $con .= ' and adddt >= '.$day;
            $page_con['time'] = 4;
        }else if($time == 5){
            $day = date('YmdHis',strtotime('-3month'));
            $con .= ' and adddt <= '.$day;
            $page_con['time'] = 5;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
        
    }
    
    //放弃客户
    function giveup(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_customer');
        $id = (int)htmlentities($this->spArgs('id'));
        $user = spClass('m_admin')->findAll(array('pid'=>$admin['id']));
        $uids = array($admin['id']);
        foreach($user as $k=>$v){
            $uids[] = $v['id'];
        }
        $uids = implode(',', $uids);
        $re = $model->find('uid in ('.$uids.') and id = '.$id);
        if($re){
            $up = $model->update(array('id'=>$id),array('status'=>0,'endtime'=>0));
            if($up){
                spClass('m_cust_log')->create(array('tid'=>$id,'table'=>'customer','optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>'放弃客户','stname'=>'放弃'));
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '信息有误');
        }
    }
    
    //抢客户
    function grab(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_customer');
        $m_custsale = spClass('m_custsale');
        $id = htmlentities($this->spArgs('id'));
        $re = $model->find('del = 0 and (uid = 0 or status = 0 or uid = '.$admin['id'].') and id = '.$id);
        if($re){
            $up = $model->update(array('id'=>$id),array('uid'=>$admin['id'],'optname'=>$admin['name'],'status'=>1,'optdt'=>date('Y-m-d H:i:s'),'endtime'=>time()));
            if($up){
                spClass('m_cust_log')->create(array('tid'=>$id,'table'=>'customer','optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>'抢到客户','stname'=>'抢'));
                $m_custsale->update(array('custid'=>$re['id']),array('uid'=>$admin['id'],'optname'=>$admin['name'],'optdt'=>date('Y-m-d H:i:s')));
                $this->msg_json(1, '恭喜您，成功抢到该客户');
            }else{
                $this->msg_json(2, '网络错误，请重试');
            }
        }else{
            $this->msg_json(0, '很遗憾，没抢到！');
        }
    }
    
    function sales(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $m_customer = spClass('m_customer');
        $customer = $m_customer->findAll(array('del'=>0,'uid'=>$admin['id']));
        $this->customer = $customer;
        $m_custsale = spClass('m_custsale');
        $custid = (int)  htmlentities($this->spArgs('custid'));
        $status = (int) htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $where = 'del = 0 and uid ='.$admin['id'].' and (status= 1 or status = 2)';
        if(!empty($status)){
            $where .= ' and status = '.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (custname like "%'.$name.'%" or optname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        if(!empty($custid)){
            $where .= ' and custid ='.$custid;
            $page_con['custid'] = $custid;
        }
        $results = $m_custsale->spPager($this->spArgs("page", 1), 30)->findAll($where,'optdt desc');
        $this->results = $results;
        $this->page_con = $page_con;
        $this->pager = $m_custsale->spPager()->getPager();
    }
    
    function follow(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_customer');
        $m_custsale = spClass('m_custsale');
        $m_cust_log = spClass('m_cust_log');
        $id = (int)  htmlentities($this->spArgs('id'));
        $explain = trim(htmlspecialchars($this->spArgs('explain')));
        $next = htmlspecialchars($this->spArgs('next'));
        $time = strtotime($next);
        $re = $m_custsale->find(array('id'=>$id,'uid'=>$admin['id']));
        if($re){
            $ad = $m_cust_log->create(array('tid'=>$id,'table'=>'custsale','optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>$explain,'stname'=>'跟进'));
            if($ad){
                $m_custsale->update(array('id'=>$id),array('nextdt'=>$time));
                $model->update(array('id'=>$re['createid']),array('endtime'=>$time));
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '信息有误');
        }
    }

    function follow2(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_customer');
        $m_cust_log = spClass('m_cust_log');
        $id = (int)  htmlentities($this->spArgs('id'));
        $explain = trim(htmlspecialchars($this->spArgs('explain')));
        $next = htmlspecialchars($this->spArgs('next'));
        $time = strtotime($next);
        $re = $model->find(array('id'=>$id,'uid'=>$admin['id']));
        if($re){
            $ad = $m_cust_log->create(array('tid'=>$id,'table'=>'customer','optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>$explain,'stname'=>'跟进'));
            if($ad){
                $model->update(array('id'=>$id),array('endtime'=>$time));
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '信息有误');
        }
    }

    function mySign(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $m_customer = spClass('m_customer');
        $customer = $m_customer->findAll(array('del'=>0,'uid'=>$admin['id']));
        $this->customer = $customer;
        $m_custsale = spClass('m_custsale');
        $custid = (int)  htmlentities($this->spArgs('custid'));
        $status = (int) htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $where = 'del = 0 and uid ='.$admin['id'].' and status = 3';
      
        if(!empty($name)){
            $where .= ' and (custname like "%'.$name.'%" or optname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        if(!empty($custid)){
            $where .= ' and custid ='.$custid;
            $page_con['custid'] = $custid;
        }
        $results = $m_custsale->spPager($this->spArgs("page", 1), 30)->findAll($where,'optdt desc');
        $this->results = $results;
        $this->page_con = $page_con;
        $this->pager = $m_custsale->spPager()->getPager();
    }


    
    //下属销售机会
    function salescd(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $m_custsale = spClass('m_custsale');
        $m_admin = spClass('m_admin');
        $uid = (int)  htmlentities($this->spArgs('uid'));
        $status = (int)  htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $childrens = $m_admin->findAll(array('pid'=>$admin['id']),'','id,name');
        $this->children = $childrens;
        $unds = array(0);
        foreach($childrens as $v){
            $unds[] = $v['id'];
        }
        $unds = implode(',', $unds);
        $where = 'del = 0 and uid in ('.$unds.') and (status = 1 or status = 2)';
        if(!empty($status)){
            $where .= ' and status = '.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (custname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        if(!empty($uid)){
            $where .= ' and uid ='.$uid;
            $page_con['uid'] = $uid;
        }
        $results = $m_custsale->spPager($this->spArgs("page", 1), 30)->findAll($where,'optdt desc');
        $this->results = $results;
        $this->page_con = $page_con;
        $this->pager = $m_custsale->spPager()->getPager();
        
    }

    function mySigns(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $m_customer = spClass('m_customer');
        $customer = $m_customer->findAll(array('del'=>0,'uid'=>$admin['id']));
        $this->customer = $customer;
        $m_custsale = spClass('m_custsale');
        $custid = (int)  htmlentities($this->spArgs('custid'));
        $status = (int) htmlentities($this->spArgs('status'));
        $uid = (int) htmlentities($this->spArgs('uid'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $m_admin = spClass('m_admin');
        $childrens = $m_admin->findAll(array('pid'=>$admin['id']),'','id,name');
        $this->children = $childrens;
        $unds = array(0);
        foreach($childrens as $v){
            $unds[] = $v['id'];
        }
        $unds = implode(',', $unds);

        $where = 'del = 0 and uid in ('.$unds.')  and status = 3';
      
        if(!empty($name)){
            $where .= ' and (custname like "%'.$name.'%" or optname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        if(!empty($custid)){
            $where .= ' and custid ='.$custid;
            $page_con['custid'] = $custid;
        }

        if(!empty($uid)){
            $where .= ' and uid ='.$uid;
            $page_con['uid'] = $uid;
        }
        $results = $m_custsale->spPager($this->spArgs("page", 1), 30)->findAll($where,'optdt desc');
        $this->results = $results;
        $this->page_con = $page_con;
        $this->pager = $m_custsale->spPager()->getPager();
    }
    
    function qiandan(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $status = (int)htmlentities($this->spArgs('status'));
        $explain = htmlspecialchars($this->spArgs('explain'));
        $m_customer = spClass('m_customer');
        $m_custsale = spClass('m_custsale');
        $m_cust_log = spClass('m_cust_log');
        $result = $m_custsale->find(array('id'=>$id));
        if($result){
            if($status==2){
                $m_customer->update(array('id'=>$result['custid']),array('status'=>2));
                $m_cust_log->create(array('optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>$explain,'tid'=>$id,'table'=>'customer','stname'=>'已签单'));
                $stname = '已签单';
            }else if($status==3){
                $stname = '已丢失';
            }
            $up = $m_custsale->update(array('id'=>$id),array('status'=>$status));
            if($up){
                $m_cust_log->create(array('optid'=>$admin['id'],'optname'=>$admin['name'],'dt'=>date('Y-m-d H:i:s'),'explain'=>$explain,'tid'=>$id,'table'=>'custsale','stname'=>$stname));
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
            
        }else{
            $this->msg_json(0, '信息有误');
        }
    }
    
    function allcustomer(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_admin = spClass('m_admin');

        $model = spClass('m_customer');
        $con = 'del = 0 and uid > 0 and status = 1';
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
        
        $uid = (int)htmlentities($this->spArgs('uid'));
        if(!empty($uid)){
            $con .= ' and uid ='.$uid;
            $page_con['uid'] = $uid;
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

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,$order);
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
    
    function allsales(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_custsale');
        $m_admin = spClass('m_admin');
        $con = 'del = 0 and (status = 1 or status = 2)';
        $order = 'adddt desc';
        $status = (int)  htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $uid = (int)htmlentities($this->spArgs('uid'));
        $dep = urldecode(htmlspecialchars($this->spArgs('dep')));
        if(!empty($status)){
            $con .= ' and status = '.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and custname like "%'.$name.'%"';
            $page_con['name'] = $name;
        }

        if(!empty($uid)){
            $con .= ' and uid = '.$uid;
            $page_con['uid'] = $uid;
        }

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

        $results = $model->findAll($con,$order);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

        $m_customer = spClass('m_customer');
        $tmp = $m_customer->findAll('del = 0 ',null,'uid');
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


    function allSigns(){
        $result = $this->get_menu();
        $admin = $result['admin'];
        $m_custsale = spClass('m_custsale');
        $custid = (int)  htmlentities($this->spArgs('custid'));
        $status = (int) htmlentities($this->spArgs('status'));
        $uid = (int)htmlentities($this->spArgs('uid'));
        $dep = urldecode(htmlspecialchars($this->spArgs('dep')));
        $m_admin = spClass('m_admin');
        $childrens = $m_admin->findAll(array('pid'=>$admin['id']),'','id,name');
        $this->children = $childrens;
        $unds = array(0);
        foreach($childrens as $v){
            $unds[] = $v['id'];
        }
        $unds = implode(',', $unds);

        $where = 'del = 0  and status = 3';
      
        if(!empty($custid)){
            $where .= ' and custid ='.$custid;
            $page_con['custid'] = $custid;
        }

        if(!empty($uid)){
            $con .= ' and uid = '.$uid;
            $page_con['uid'] = $uid;
        }

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

        $results = $m_custsale->spPager($this->spArgs("page", 1), 30)->findAll($where,'optdt desc');
        $this->results = $results;
        $this->page_con = $page_con;
        $this->pager = $m_custsale->spPager()->getPager();

        $m_customer = spClass('m_customer');
        $tmp = $m_customer->findAll('del = 0 ',null,'uid');
        $uids = array();
        $uids[] = 0;
        foreach($tmp as $k => $v){
            $uids[] = $v['uid'];
        }
        $uids = implode(',', $uids);
        $m_admin = spClass('m_admin');
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

    function delCustomer(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $con['id'] = $id;
        $model = spClass('m_customer');
        $content = htmlspecialchars($this->spArgs('cause'));
        $con['uid'] = $admin['id'];
        $tmp = $model->find($con);
        if($tmp){  
            $data['del'] = 1;
            $data['delcontent'] = $content;
            $up = $model->update($con,$data);
            if($up){
                $this->msg_json(1,'删除完成');
            }else{
                $this->msg_json(0,'删除失败');
            }
        }else{
            $this->msg_json(0,' 未找到可删除客户信息');
        }
    }


    

    function delCustomers(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $con['id'] = $id;
        $model = spClass('m_customer');
        $content = htmlspecialchars($this->spArgs('cause'));
        $tmp = $model->find($con);
        if($tmp){  
            $data['del'] = 1;
            $data['delcontent'] = $content;
            $up = $model->update($con,$data);
            if($up){
                $this->msg_json(1,'删除完成');
            }else{
                $this->msg_json(0,'删除失败');
            }
        }else{
            $this->msg_json(0,' 未找到可删除客户信息');
        }
    }


    function delSales(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $con['id'] = $id;
        $model = spClass('m_custsale');
        $content = htmlspecialchars($this->spArgs('cause'));
        $con['uid'] = $admin['id'];
        $tmp = $model->find($con);
        if($tmp){  
            $data['del'] = 1;
            $data['delContent'] = $content;
            $up = $model->update($con,$data);
            if($up){
                $rt = $model->find('custid='.$tmp['custid'].' and del = 0');
                if(empty($rt)){
                    $m_customer = spClass('m_customer');
                    $ccon['id'] = $tmp['custid'];
                    $cdata['status'] = 1;
                    $up2 = $m_customer->update($ccon,$cdata);
                }
                $this->msg_json(1,'删除完成');
            }else{
                $this->msg_json(0,'删除失败');
            }
        }else{
            $this->msg_json(0,' 未找到可删除客户信息');
        }
    }


    function custract(){
        $admin = $this->get_menu();
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;

        $model = spClass('m_custract');
        $where = ' 1=1 ';

        $status = (int)htmlentities($this->spArgs('status'));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }

        $uid = (int)htmlentities($this->spArgs('uid'));
        if(!empty($uid)){
            $where .= ' and uid = '.$uid;
            $page_con['uid'] = $uid;
        }

        $number = htmlspecialchars($this->spArgs('number'));
        if(!empty($number)){
            $where .= ' and number like "%'.$number.'%"';
            $page_con['number'] = $number;
        }

        $comer = htmlspecialchars($this->spArgs('comer'));
        if(!empty($comer)){
            $where .= ' and comid ='.$comer;
            $page_con['comer'] = $comer;
        }

        $result = $model->spPager($this->spArgs("page", 1), 30)->findAll($where,'id desc');
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

        $m_customer = spClass('m_customer');
        $customer = $m_customer->findAll('status = 3');
        $this->customer = $customer;

        $tmps = array();
        $tmps[] = 0;
        foreach($customer as $k => $v){
            $tmps[] = $v['uid'];
        }

        $tmps = implode(',', $tmps);
        $m_admin = spClass('m_admin');
        $admins = $m_admin->findAll('id in('.$tmps.')');
        $this->admins = $admins;
    }
}
