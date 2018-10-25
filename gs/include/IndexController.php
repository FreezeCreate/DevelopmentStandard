<?php

/**
 * 前端基础类
 *
 * @author Administrator
 */
class IndexController extends spController {

    public $num = 20;

    function __construct() {
        parent::__construct();
        GLOBAL $__controller, $__action;
        $this->c = $__controller;
        $this->a = $__action;
        import('Common.php'); //载入公共方法
        //是否从地址栏直接填写token
//         if (!strpos($_SERVER['HTTP_REFERER'], 'token')) $this->msg_json('非法调用');
        
        if ($this->a == 'qrimg'){
            continue;
            if (!$_SESSION['admin'] && $this->a != 'login') {
                header('Location:' . spUrl('main', 'login'));
            }
        }
        
        $this->page_con = array(); //默认的分页+条件 为空
    }
    
    /**
     * 发送消息提醒入库
     */
    function sendMsgNotice($mid, $tid, $summary, $type = 1)
    {
        $m_set      = spClass('m_flow_set');
        $model      = spClass('m_flow_todos');
        $m_admin    = spClass('m_admin');
        $model_data = $m_set->find('id='.$mid.'');
        $admin      = $m_admin->find(array('id' => $_SESSION['admin']['id']));
        
        $data = array(
            'modelid'   => $mid,
            'modelname' => $model_data['name'],
            'table'     => $model_data['table'],
            'tid'       => $tid,
            'uid'       => $admin['id'],
            'adddt'     => date('Y-m-d H:i:s'),
            'title'     => $summary,
            'type'      => $type,    //当为审核流程时type=1、为通知公告时type=2
        );
        $model->create($data);
        
        //jpush的两端提醒处理
//         $this->jpushSendMsg($data['modelname'], $summary);
    }

    /**
     * 返回json字符串
     * @param unknown_type $status 1成功0失败
     * @param unknown_type $msg 提示语句
     * @param unknown_type $data 数据
     * @param unknown_type $url url
     */
    public function msg_json($status, $msg, $data = '', $url = '') {
        $json_arr = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
        );
        die(json_encode($json_arr));
    }

    function msg_json_z($status, $msg, $data = array(), $url) {
        $msg = iconv("GB2312", "UTF-8//IGNORE", $msg);
        $json_arr = array(
            'status' => $err,
            'msg' => $msg,
            'data' => $data,
            'url' => $url
        );
        die(json_encode($json_arr));
    }

    function get_menu($control = '', $way = '') {
        if (empty($control)) {
            $control = $this->spArgs('c');
        }
        if (empty($way)) {
            $way = $this->spArgs('a');
        }
        $m_admin = spClass("m_admin");
        $m_auth = spClass('m_auth');
        $m_role = spClass('m_role');
        $data['control'] = $control;
        $data['way'] = $way;
        $data['del'] = 0;
        $thisauth = $m_auth->find($data);
        $id = !empty($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 0;
        $admin = $m_admin->find("id = " . $id);
        if ($admin) {
            if ($_SESSION['admin']['id'] == 1) {
                $con = 'hide = 0 and del = 0 and oid = 0';
            } else {
                $role = json_decode($admin['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    if ($re_role) {
                        $pro = json_decode($re_role['promission']);
                        $pros .= ',' . implode(',', $pro);
                    }
                }
                if (strpos($pros . ',', ',' . $thisauth['id'] . ',') !== false || empty($thisauth)) {
                    $con = 'id in (0' . $pros . ') and hide = 0 and del = 0 and oid = 0';
                    if ($admin['shopid'] > 1) {
                        $con .= ' and branch = 1';
                    }
                } else {
                    $this->error('您没有该权限');
                }
            }
            $menu = $m_auth->getMenu($con, 'sort asc');
            $result['admin'] = $admin;
            $this->menu = $menu;
            $this->admin = $admin;
            $result['menu'] = $menu;
            return $result;
        } else {
            //如果session不存在就清除cookie
            setcookie('token',$_COOKIE['token'],time()-1,'/');
            $this->jump(spUrl('main', 'login'));
        }
    }
    

    function get_ajax_menu($control = '', $way = '') {
        if (empty($control)) {
            $control = $this->spArgs('c');
        }
        if (empty($way)) {
            $way = $this->spArgs('a');
        }
        $m_admin = spClass("m_admin");
        $m_auth = spClass('m_auth');
        $m_role = spClass('m_role');
        $data['control'] = $control;
        $data['way'] = $way;
        $thisauth = $m_auth->find($data);
        $id = !empty($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 0;
        $admin = $m_admin->find("id = " . $id);
        if ($admin) {
            if ($_SESSION['admin']['id'] == 1) {
                return $admin;
            } else {
                $role = json_decode($admin['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    if ($re_role) {
                        $pro = json_decode($re_role['promission']);
                        $pros .= ',' . implode(',', $pro);
                    }
                }
                if (strpos($pros . ',', ',' . $thisauth['id'] . ',') !== false || empty($thisauth)) {
                    return $admin;
                } else {
                    $this->msg_json(0, '您没有该权限');
                }
            }
        } else {
            //如果session不存在就清除cookie
            setcookie('token',$_COOKIE['token'],time()-1,'/');
            $this->msg_json(0, '您尚未登录');
        }
    }

    function delete_data($table, $mid) {
        
    }

    function log_result($file, $text) {
        $fp = fopen($file, "a");
        flock($fp, LOCK_EX);
        fwrite($fp, $text);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    function findcheckUser($type, $id = '', $admin, $auto = array()) {
        $m_admin = spClass('m_admin');
        $m_flow_course = spClass('m_flow_course');
        if ($type == 'super') {    //直属上级
            $data['nowcheckid'] = ',' . $admin['sid'] . ',';
            $data['nowcheckname'] = $admin['sname'];
        } else if ($type == 'rank') {    //职位
            $checkusers = $m_admin->findAll(array('pid' => $id, 'cid' => $admin['cid']));
            if ($checkusers) {
                $data['nowcheckid'] = ',';
                $data['nowcheckname'] = '';
                foreach ($checkusers as $v) {
                    $data['nowcheckid'] .= $v['id'] . ',';
                    $data['nowcheckname'] .= $v['name'] . ',';
                }
                $data['nowcheckname'] = trim($data['nowcheckname'], ',');
            }
        } else if ($type == 'admin') {    //指定人员
            $checkusers = $m_admin->find(array('id' => $id));
            if ($checkusers) {
                $data['nowcheckid'] = ','.$checkusers['id'].',';
                $data['nowcheckname'] = $checkusers['name'];
            }
        } else if ($type == 'assign') {    //上级分配
            $checkusers = $m_admin->find(array('id' => $id));
            if ($checkusers) {
                $data['nowcheckid'] = ','.$checkusers['id'].',';
                $data['nowcheckname'] = $checkusers['name'];
            }
        } else if ($type == 'pub') {    //申请人
            $data['nowcheckid'] = ',' . $admin['id'] . ',';
            $data['nowcheckname'] = $admin['name'];
        } else if ($type == 'dept') {   //部门负责人
            $checkuser = spClass('m_department')->find(array('id' => $admin['departmentid']));
            $data['nowcheckid'] = ',' . $checkuser['principalid'] . ',';
            $data['nowcheckname'] = $checkuser['principalname'];
        } else if ($type == 'auto') {   //自定义
            $data['nowcheckid'] = ',' . $auto['id'] . ',';
            $data['nowcheckname'] = $auto['name'];
        }
        return $data;
    }

    function sendUpcoming($mid, $tid, $summary = '', $auto = array(),$erci = 0) {
        $m_admin = spClass('m_admin');
        $m_flow_set = spClass('m_flow_set');
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_course = spClass('m_flow_course');
        $flow = $m_flow_set->find(array('id' => $mid));
        $st = explode(',', $flow['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $model = spClass('m_' . $flow['table']);
        $re = $model->find(array('id' => $tid));
        $admin = $m_admin->find(array('id' => $_SESSION['admin']['id']));
        $course = $m_flow_course->find(array('sid' => $mid, 'pid' => 0));
        $data['number'] = $re['number'];
        $data['table'] = $flow['table'];
        $data['tid'] = $tid;
        $data['uid'] = $admin['id'];
        $data['uname'] = $admin['name'];
        $data['udeptname'] = $admin['departmentname'];
        $data['modelid'] = $mid;
        $data['modelname'] = $flow['name'];
        $data['status'] = $re['status'];
        $data['summary'] = $summary;
        $data['statustext'] = $status[$re['status']]['text'];
        $data['allcheckid'] = ',';
        $bill = $m_flow_bill->find(array('table' => $flow['table'], 'tid' => $tid), '', 'id,`table`,tid,modelid');
        if ($course) {
            $data['cid'] = $course['id'];
            $data['cname'] = $course['name'];
            $chuser = $this->findcheckUser($course['checktype'], $course['checktypeid'], $admin, $auto);
            $chuserid = trim($chuser['nowcheckid'], ',');
           
            if (empty($chuserid)) {
                $data['status'] = -1;
                $data['statustext'] = '未找到审核人';
                $model->update(array('id' => $tid), array('status' => '-1'));
            } else {
                $data['nowcheckid'] = $chuser['nowcheckid'];
                $data['nowcheckname'] = $chuser['nowcheckname'];
            }
        } else {
            $data['statustext'] = '完成';
        }
        if ($bill) {
            if(!empty($erci)){
                $data['status'] = 1;
                $data['statustext'] = '待审核';
            }
            $m_flow_bill->update(array('id' => $bill['id']), $data);
            $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => 1, 'statusname' => '编辑', 'name' => '编辑', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => $bill['modelid']);
            spClass('m_flow_log')->create($data_log);
        } else {
            $data['addtime'] = date('Y-m-d H:i:s');
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['applydt'] = date('Y-m-d');
            $ad = $m_flow_bill->create($data);
            $data_log = array('table' => $data['table'], 'tid' => $data['tid'], 'status' => 1, 'statusname' => '添加', 'name' => '添加', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => $data['modelid']);
            spClass('m_flow_log')->create($data_log);
        }
        
        //jpush的两端提醒处理
//         $this->jpushSendMsg($data['modelname'], $summary);
        
    }
    
    /**
     * jpush的两端提醒处理
     */
    function jpushSendMsg($title, $content)
    {
        require 'jpush/autoload.php';
        $client = new \JPush\Client($GLOBALS['jpush']['appKey'], $GLOBALS['jpush']['masterSecret']);
        //Android
        $client->push()
               ->setPlatform('all')
               ->addAlias('0x123')
               ->addTag(array('0x123', '0x124'))
               ->androidNotification($content, array(    //多条安卓 send
                   'title' => $title,
               ))
               ->send();
        //IOS
        $client->push()
               ->setPlatform('all')
//                ->addAlias('0x123')
//                ->addTag(array('0x123', '0x124'))
               ->iosNotification($content, array(    //多条IOS send
                   'title' => $title,
               ))
               ->send();
    }
    
    function findCheck($id, $mid) {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $m_file = spClass('m_file');
        $m_flow_set = spClass('m_flow_set');
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_log = spClass('m_flow_log');
        $m_flow_course = spClass('m_flow_course');
        $set = $m_flow_set->find(array('id'=>$mid));
        if (empty($set)) {
            $this->error('数据有误');
        }
        $log = $m_flow_log->findAll(array('table' => $set['table'], 'tid' => $id));
        foreach($log as $k=>$v){
            if (!empty($v['files'])) {
                $files = $m_file->findAll('id in (' . $v['files'] . ')', '', 'id,filename');
                $log[$k]['files'] = $files;
            } else {
                $log[$k]['files'] = array();
            }
        }
        $this->log = $log;
        $model = spClass('m_' . $set['table']);
        $result = $model->find(array('id' => $id));
        if (!empty($result['files'])) {
            $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        if (!empty($result['images'])) {
            $result['images'] = explode(',', $result['images']);
        }
        $this->result = $result;
        
        $bill = $m_flow_bill->find(array('modelid' => $mid, 'tid' => $id));
        if($bill){
            $course = $m_flow_course->find(array('id' => $bill['cid']));
            $bill['nowcheckid'] = trim($bill['nowcheckid'], ',');
            $bill['nowcheckid'] = explode(',', $bill['nowcheckid']);
            $this->bill = $bill;
            $course['courseact'] = empty($course['courseact']) ? array('通过|3|green', '驳回|2|red') : explode(',', $course['courseact']);
            foreach ($course['courseact'] as $k => $v) {
                $course['courseact'][$k] = explode('|', $v);
            }
            $this->course = $course;
        }
    }

    function sendRemind($mid, $id, $users, $title = '') {
        $m_flow_set = spClass('m_flow_set');
        $m_flow_todos = spClass('m_flow_todos');
        $flow = $m_flow_set->find(array('id' => $mid));
        if ($flow) {
            $adddt = date('YmdHis');
            foreach ($users as $v) {
                $todo = $m_flow_todos->find(array('table' => $flow['table'], 'tid' => $id, 'uid' => $v['id']), '', 'id');
                if ($todo) {
                    $m_flow_todos->update(array('id' => $todo['id']), array('title' => $title, 'adddt' => $adddt, 'isread' => 0, 'readdt' => ''));
                } else {
                    $m_flow_todos->create(array('modelid' => $flow['id'], 'modelname' => $flow['name'], 'table' => $flow['table'], 'tid' => $id, 'uid' => $v['id'], 'title' => $title, 'adddt' => $adddt));
                }
            }
            $m_flow_todos->delete('`table` = "' . $flow['table'] . '" and tid = ' . $id . ' and adddt < ' . $adddt);
            $return = array('status' => 1, 'msg' => '发送成功');
        } else {
            $return = array('status' => 0, 'msg' => '模块类型有误');
        }
        return $return;
    }

    function flowVoid($table, $id, $admin) {
        $model = spClass('m_' . $table);
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_log = spClass('m_flow_log');
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
        if (empty($re)) {
            $this->msg_json(0, '信息不存在');
        }
        $up = $model->update(array('id' => $id), array('optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'status' => 0));
        if ($up) {
            $m_flow_bill->update(array('table' => $table, 'tid' => $id), array('nowcheckid' => 0, 'nowcheckname' => '', 'status' => 0, 'statustext' => '已作废'));
            $data_log = array('table' => 'finfunds', 'tid' => $id, 'status' => 0, 'statusname' => '作废', 'name' => '已作废', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '申请人作废', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id']);
            $m_flow_log->create($data_log);
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    function flowDel($table, $id, $admin) {
        $model = spClass('m_' . $table);
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_log = spClass('m_flow_log');
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
        if (empty($re)) {
            $this->msg_json(0, '信息不存在');
        }
        $up = $model->update(array('id' => $id), array('del' => 1));
        if ($up) {
            $m_flow_bill->update(array('table' => $table, 'tid' => $id), array('nowcheckid' => 0, 'nowcheckname' => '', 'del' => 1));
            $data_log = array('table' => $table, 'tid' => $id, 'status' => 0, 'statusname' => '删除', 'name' => '已删除', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '已删除', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id']);
            $m_flow_log->create($data_log);
            $this->msg_json(1, '操作成功',$id);
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    /**
     * 	考勤分析
     * 	@param $uid 用户Id
     * 	@param $dt 分析日期
     */
    function geetdkarr($uid, $dt) {
        $m_kqdkjl = spClass('m_kqdkjl');
        return $m_kqdkjl->findAll('uid = ' . $uid . ' and dkdt like "' . $dt . '%"', 'dkdt asc');
    }

    /**
     * 	考勤分析
     * 	@param $uid 用户Id
     * 	@param $dt 分析日期
     */
    function getkqsj($uid, $dt) {
        $admin = spClass('m_admin')->find(array('id'=>$uid),'','departmentid');
        $m_kqsjgz = spClass('m_kqsjgz');
        $rows = $m_kqsjgz->findAll('pid = 0 and did = '.$admin['departmentid'], 'sort asc');
        if(empty($rows)){
            $rows = $m_kqsjgz->findAll('pid = 0 and did = 0', 'sort asc');
        }
        foreach ($rows as $k => $v) {
            $rows[$k]['children'] = $m_kqsjgz->findAll('pid = ' . $v['id'], 'sort asc');
        }
        return $rows;
    }

    /**
     * 	上班: (当前qtype==0)请假开始时间小于等于 设置正常的截止时间（取最小值）
     * 	下班: (当前qtype==1)请假截止时间大于等于 设置正常的开始时间（取最大值）
     */
    private function getstates($ztarr, $dts, $uid) {
        $m_kqinfo = spClass('m_kqinfo');
        $st1 = strtotime($dts . ' ' . $ztarr['stime']);
        $et1 = strtotime($dts . ' ' . $ztarr['etime']);
        $s = '';
        $rows = $m_kqinfo->findAll("`uid`='$uid' and `status`>=3 and `start`<='$dts 23:59:59' and `end`>='$dts 00:00:00'",'','`start`,`end`,`type`');
        foreach ($rows as $k => $rs) {
            $qst = strtotime($rs['start']);
            $qet = strtotime($rs['end']);
            if ($ztarr['qtype'] == 1) {
                if ($qet >= $st1) {
                    $s = $rs['type'];
                }
            } else {
                if ($qst <= $et1) {
                    $s = $rs['type'];
                }
            }
        }
        return $s;
    }

    /**
     *  上班: (当前qtype==0)外出开始时间小于等于 设置正常的截止时间（取最小值）
     *  下班: (当前qtype==1)外出截止时间大于等于 设置正常的开始时间（取最大值）
     */
    private function gooutstates($ztarr, $dts, $uid) {
        $m_kqgoout = spClass('m_kqgoout');
        $st1 = strtotime($dts . ' ' . $ztarr['stime']);
        $et1 = strtotime($dts . ' ' . $ztarr['etime']);
        $s = '';
        $rows = $m_kqgoout->findAll("`uid`='$uid' and `status`>=3 and `start`<='$dts 23:59:59' and `end`>='$dts 00:00:00'",'','`start`,`end`,`type`');
        foreach ($rows as $k => $rs) {
            $qst = strtotime($rs['start']);
            $qet = strtotime($rs['end']);
            if ($ztarr['qtype'] == 1) {
                if ($qet >= $st1) {
                    $s = $rs['type'];
                }
            } else {
                if ($qst <= $et1) {
                    $s = $rs['type'];
                }
            }
        }
        return $s;
    }

    function kqanaysss($uid, $dt, $kqrs, $dkarr) {
        $kqarr = $kqrs['children'];
        $state = '未打卡';
        $states = $remark = '';
        $emiao = 0;
        $tpk = -1;
        $time = '';
        $pdtime = 0;
        if ($dkarr && $kqarr) {
            foreach ($kqarr as $k => $v) {
                $stime = strtotime('' . $dt . ' ' . $v['stime'] . '');
                $etime = strtotime('' . $dt . ' ' . $v['etime'] . '');
                $qtype = $v['qtype'];
                foreach ($dkarr as $k1 => $v1) {
                    $dkdt = strtotime($v1['dkdt']);
                    if ($stime > $dkdt || $etime < $dkdt)
                        continue;
                    $time = $dkdt;
                    $state = $v['name'];
                    $tpk = $k1;
                    if ($qtype == 0)
                        break;
                }
                $pdtime = $stime;
                if ($qtype == 1)
                    $pdtime = $etime;
                if ($time != '')
                    break;
            }
        }
        if ($time != '') {
            if ($state != '正常') {
                $emiao = $pdtime - $time;
            }
        }
        $barr['state'] = $state;
        $barr['emiao'] = abs($emiao);
        if ($time != '')
            $time = date('Y-m-d H:i:s', $time);
        $barr['time'] = $time;
        $barr['states'] = $states;
        $barr['remark'] = $remark;
        if ($pdtime != 0)
            $barr['pdtime'] = date('Y-m-d H:i:s', $pdtime);
        return $barr;
    }

    /**
     * 	考勤分析
     * 	@param $uid 用户Id
     * 	@param $dt 分析日期
     */
    public function kqanay($uid, $dt, $cid) {

        $dkarr = $this->geetdkarr($uid, $dt);
        $sjarr = $this->getkqsj($uid, $dt);
        $m_kqxxsj = spClass('m_kqxxsj');
        $m_kqanay = spClass('m_kqanay');
        $dttime = strtotime($dt);
        $w = date('w', $dttime);
        $today = $m_kqxxsj->find(array('dt' => $dt, 'cid' => $cid));
            $ids = '0';
        if ($today['type'] == 1 || (empty($today) && $w >= 1 && $w <= 5)) {
            //print_r($sjarr);die;
            foreach ($sjarr as $k => $v) {
                $ztname = $v['name'];
                $arrs = $this->kqanaysss($uid, $dt, $v, $dkarr);
                $state = $arrs['state'];
                $states = $arrs['states'];
                //判断是否有请假。
                if ($state != '正常') {
                    $zcarr = array();
                    foreach ($v['children'] as $k2 => $cog2) {
                        if ($cog2['name'] == '正常')
                            $zcarr = $cog2;
                    }
                    if ($zcarr) {
                        $states = $this->getstates($zcarr, $dt, $uid);
                    }
                    if(empty($states)){
                        $states = $this->gooutstates($zcarr,$dt,$uid);
                    }
                }
                $emiao = $arrs['emiao'];
                $time = $arrs['time'];
                $arr = array(
                    'ztname' => $ztname,
                    'state' => $state,
                    'states' => $states,
                    'remark' => $arrs['remark'],
                    'uid' => $uid,
                    'dt' => $dt,
                    'sort' => $k,
                    'iswork' => 1,
                    'optdt' => date('Y-m-d H:i:s'),
                    'emiao' => $emiao
                );
                if($time){
                    $arr['time'] = $time;
                }
                $where 	= "`uid`='$uid' and `dt`='$dt' and `ztname`='$ztname'";
                $re = $m_kqanay->find($where,'','id');
                if($re){
                    $m_kqanay->update(array('id'=>$re['id']),$arr);
                    $ids .= ','.$re['id'];
                }else{
                    $id = $m_kqanay->create($arr);
                    $ids .= ','.$id;
                }
            }
        }
        $m_kqanay->delete("id not in ($ids) and `uid`='$uid' and `dt`='$dt'");
    }
    
    function get_post(){
        $data = array();
        foreach ($_POST as $key => $value) {
            if(is_array($value)){
                $data[$key] = $value;
            }else{
                $data[$key] = htmlspecialchars($value);
            }
        }
        return $data;
    }

}
?>


