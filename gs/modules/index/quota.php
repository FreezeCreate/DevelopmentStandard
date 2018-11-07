<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class quota extends IndexController {
    /*     * ***公司活动管理*** */

    function department() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_quota');

        $where = 'deid = ' . $admin['departmentid'];
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'month desc');
        foreach ($results as $k => $v) {
            $results[$k]['assigns'] = json_decode($v['assigns'], true);
        }

        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

        $con2['departmentid'] = $admin['departmentid'];
        $m_admin = spClass('m_admin');
        $admins = $m_admin->findAll($con2, null, 'id,name');
        $this->depnames = $admins;
    }

    function usquotas() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_quotas');
        $results = $model->findAll(array('uid'=>$admin['id']),'month desc');
        $this->results = $results;
    }

    function allquotas() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_quotas');
        $month = (int)htmlentities($this->spArgs('month',date('Ym')));
        $type = (int)htmlentities($this->spArgs('type',1));
        $page_con['month'] = $month;
        $page_con['type'] = $type;
        $con = 'month = '.$month;
        $results = $model->findAll($con,'month desc');
        if($type==1){
            foreach($results as $v){
                $re[$v['did']]['month'] = $v['month'];
                $re[$v['did']]['uname'] = $v['dname'];
                $re[$v['did']]['qiandan'] += $v['qiandan'];
                $re[$v['did']]['money'] = $v['money'];
                $re[$v['did']]['huikuan'] = $v['huikuan'];
                $re[$v['did']]['wmoney'] = $v['wmoney'];
                $re[$v['did']]['whuikuan'] = $v['whuikuan'];
            }
        }else{
            $re = $results;
        }
        $this->results = $re;
        $this->page_con = $page_con;
    }
    
    function saveQuotas(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_quotas');
        $month = htmlentities($this->spArgs('month'));
        $data['qiandan'] = (int)htmlentities($this->spArgs('qiandan'));
        $data['money'] = (int)htmlentities($this->spArgs('money'));
        $data['huikuan'] = (int)htmlentities($this->spArgs('huikuan'));
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        $re = $model->find(array('uid'=>$admin['id'],'month'=>$month));
        if($re){
            $this->msg_json(0, '该月目标已设置，不可更改');
        }
        if(empty($data['money'])||empty($data['huikuan'])){
            $this->msg_json(0, '目标业绩为空');
        }
        $data['month'] = $month;
        $data['uid'] = $admin['id'];
        $data['uname'] = $admin['name'];
        $data['did'] = $admin['departmentid'];
        $data['dname'] = $admin['departmentname'];
        $data['cid'] = $admin['shopid'];
        $data['cname'] = $admin['shopname'];
        $data['adddt'] = date('Y-m-d H:i:s');
        $ad = $model->create($data);
        if($ad){
            $this->msg_json(1, '操作成功');
        }else{
            $this->msg_json(0, '操作失败');
        }
    }

    /*     * ********个人绩效管理************ */

    function myquota() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_custract_bill');
        $where = 'uid = ' . $admin['id'];
        $stime = htmlspecialchars($this->spArgs('stime'));
        $etime = htmlspecialchars($this->spArgs('etime'));
        if (!empty($stime)) {
            $where .= ' and adddt >="' . $stime . '"';
            $page_con['stime'] = $stime;
        }
        if (!empty($etime)) {
            $where .= ' and adddt <="' . $etime . '"';
            $page_con['etime'] = $etime;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'adddt desc');
        $cids = array();
        if (!empty($results)) {
            foreach ($results as $k => $v) {
                $cids[] = $v['cid'];
            }
            $cids = implode(',', $cids);
            $m_custract = spClass('m_custract');
            $custract = $m_custract->findAll('id in(' . $cids . ')');
            foreach($custract as $v){
                $custracts[$v['id']] = $v;
            }
            $this->custract = $custracts;
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function quotas() {
        $re = $this->get_menu();
        $admin = $re['admin'];
        $t = htmlentities($this->spArgs('t','tm'));
        $type = htmlentities($this->spArgs('type','comp'));
        $page_con['t'] = $t;
        $page_con['type'] = $type;
        $time = Common::getsedt($t);
        $stdt = date('Ymd',$time['start']);
        $edt = date('Ymd',$time['end']);
        $result = spClass('m_custract_bill')->findAll('adddt >= '.$stdt.' and adddt <='.$edt);
        $mubiao = spClass('m_quotas')->findAll('month = '.date('Ym',$time['start']),'','id,uid,uname,did,dname,cid,cname,money,huikuan');
        foreach($mubiao as $k=>$v){
            $mubiao[$k]['money'] = $v['huikuan'];
        }
        $results = array();
        if($type=='person'){
            foreach($result as $k=>$v){
                $tmp[$v['uid']]['id'] = $v['uid'];
                $tmp[$v['uid']]['name'] = $v['usname'];
                $tmp[$v['uid']]['money'] += $v['money'];
            }
            foreach($mubiao as $k1=>$v1){
                $tmp[$v1['uid']]['id'] = $v1['uid'];
                $tmp[$v1['uid']]['name'] = $v1['uname'];
                $tmp[$v1['uid']]['mubiao'] += $v1['money'];
            }
        }else if($type=='dept'){
            foreach($result as $k=>$v){
                $tmp[$v['did']]['name'] = $v['dname'];
                $tmp[$v['did']]['money'] += $v['money'];
            }
            foreach($mubiao as $k1=>$v1){
                $tmp[$v1['did']]['name'] = $v1['dname'];
                $tmp[$v1['did']]['mubiao'] += $v1['money'];
            }
        }else if($type=='comp'){
            foreach($result as $k=>$v){
                $tmp[$v['comid']]['name'] = $v['comname'];
                $tmp[$v['comid']]['money'] += $v['money'];
            }
            foreach($mubiao as $k1=>$v1){
                $tmp[$v1['did']]['name'] = $v1['cname'];
                $tmp[$v1['cid']]['mubiao'] += $v1['money'];
            }
        }
        array_multisort($tmp, 'SORT_DESC', 'money');
        $maxexpe = 0;
        $maxsucc = 0;
        foreach($tmp as $k=>$v){
            $expe = $v['mubiao'];
            if($expe>$maxexpe){
                $maxexpe = $expe;
            }
            if($v['money']>$maxsucc){
                $maxsucc = $v['money'];
            }
            $results[] = array(
                'expe' => $expe,
                'succ' => $v['money'],
                'name' => $v['name'],
            );
        }
        $this->results = array('maxexpe'=>$maxexpe,'maxsucc'=>$maxsucc,'results'=>$results);
        $this->page_con = $page_con;
    }

}
