<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class process extends IndexController {
    /*     * *****
     * 流程设置
     * ***** */

    function setting() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $results = $m_flow_set->findAll();
        $this->results = $results;
    }

    function saveCourse() {
        $admin = $this->get_ajax_menu();
        $data['sid'] = (int) htmlspecialchars($this->spArgs('sid'));
        $data['pid'] = (int) htmlspecialchars($this->spArgs('pid'));
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['checktype'] = htmlspecialchars($this->spArgs('checktype'));
        $data['courseact'] = htmlspecialchars($this->spArgs('courseact'));
        $m_flow_course = spClass('m_flow_course');
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写步骤名称');
        }
        if (empty($data['checktype'])) {
            $this->msg_json(0, '请选择审核对象');
        } else if ($data['checktype'] == 'rank') {
            $data['checktypename'] = trim(htmlspecialchars($this->spArgs('checktypename')));
            if (!empty($data['checktypename'])) {
                $position = spClass('m_position')->find(array('name' => $data['checktypename']));
                if ($position) {
                    $data['checktypeid'] = $position['id'];
                } else {
                    $data['checktypeid'] = spClass('m_position')->create(array('name' => $data['checktypename']));
                }
            } else {
                $this->msg_json(0, '请选择审核职位');
            }
        } else if ($data['checktype'] == 'admin') {
            $data['checktypeid'] = trim(htmlspecialchars($this->spArgs('uid')));
            $cadmin = spClass('m_admin')->find(array('id' => $data['checktypeid']));
            if ($cadmin) {
                $data['checktypename'] = $cadmin['name'];
            } else {
                $this->msg_json(0, '请选择审核人');
            }
        } else {
            $data['checktypeid'] = '';
            $data['checktypename'] = '';
        }
        $data['opttime'] = time();
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        if (empty($id)) {
            if (empty($data['sid'])) {
                $this->msg_json(0, '未找到模块ID，请刷新重试');
            }
            $ad = $m_flow_course->create($data);
            if ($ad) {
                $data['id'] = $ad;
                $this->msg_json(1, '新增成功', $data);
            } else {
                $this->msg_json(0, '新增失败');
            }
        } else {
            unset($data['sid']);
            unset($data['pid']);
            $re = $m_flow_course->find(array('id' => $id));
            if ($re) {
                $up = $m_flow_course->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $id;
                    $this->msg_json(2, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '数据有误，修改失败');
            }
        }
    }

    function getCourse() {
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $id = (int) $this->spArgs('id');
        $m_flow_course = spClass('m_flow_course');
        $m_flow_set = spClass('m_flow_set');
        $re = $m_flow_set->find(array('id' => $id));
        if ($re) {
            $results = $m_flow_course->ress($id);
            $results = empty($results) ? array() : $results;
            $this->msg_json(1, '获取成功', $results, $re['id'] . '.' . $re['name']);
        } else {
            $this->msg_json(0, '获取失败');
        }
    }

    function delCourse() {
        $admin = $this->get_ajax_menu();
        $m_flow_course = spClass('m_flow_course');
        $id = (int) $this->spArgs('id');
        $re = $m_flow_course->find(array('id' => $id));
        if ($re) {
            $del = $m_flow_course->delete(array('id' => $id));
            if ($del) {
                $m_flow_course->update(array('pid' => $id), array('pid' => $re['pid'], 'level' => $re['level']));
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        }
    }

    /*     * ******
     * 流程申请
     * ******* */

    function apply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $re = $m_flow_set->findAll('hide = 0');
        foreach ($re as $k => $v) {
            $results[$v['type']][] = $v;
        }
        $this->results = $results;
    }
    
    /*     * ******
     * 流程待办
     * ******* */

    function upcoming() {
        $result = $this->get_menu();
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
    
    /*     * ******
     * 我的申请
     * ******* */

    function myapply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int)htmlspecialchars($this->spArgs('sid'));
        $type = (int)htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['type']][] = $v;
        }
        $this->set = $set;
        $con = 'del = 0 and uid = '.$admin['id'];
        if($type==1){
            $con .= ' and status > 2 and nowcheckid = 0';
            $page_con['type'] = 1;
        }
        if($type==2){
            $con .= ' and status = 2';
            $page_con['type'] = 2;
        }
        if($sid){
            $con .= ' and modelid = '.$sid;
            $page_con['sid'] = $sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
            $page_con['applydt'] = $applydt;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_flow_bill->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function void(){
        $admin = $this->get_ajax_menu();
        $m_flow_bill = spClass('m_flow_bill');
        $id = (int)  htmlentities($this->spArgs('id'));
        $bill = $m_flow_bill->find(array('id'=>$id));
        if($bill){
            $this->flowVoid($bill['table'], $bill['tid'],$admin);
        }else{
            $this->msg_json(0, '信息有误');
        }
        
    }
    
    function del(){
        $admin = $this->get_ajax_menu();
        $m_flow_bill = spClass('m_flow_bill');
        $id = (int)  htmlentities($this->spArgs('id'));
        $bill = $m_flow_bill->find(array('id'=>$id));
        if($bill){
            $this->flowDel($bill['table'], $bill['tid'],$admin);
        }else{
            $this->msg_json(0, '信息有误');
        }
    }

}
