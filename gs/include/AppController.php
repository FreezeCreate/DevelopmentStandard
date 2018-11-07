<?php

/**
 * 前端基础类
 *
 * @author Administrator
 */
class AppController extends spController {

    public $num = 20;

    function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: POST,GET');
        header('Access-Control-Max-Age: 1000');
        
        GLOBAL $__controller, $__action;
        $this->c = $__controller;
        $this->a = $__action;
        import('Common.php');
        //$this->referrCheck();
//         if (!$_SESSION['admin'] && $this->a != 'login') {
//             header('Location:' . spUrl('main', 'login'));
//         }
//         if (!$_COOKIE['token'] && $this->a != 'login') {
//             header('Location:' . spUrl('main', 'login'));
//         }
        $this->page_con = array(); //默认的分页+条件 为空
    }

    /**
     * 是否从地址栏直接填写token
     */
    function referrCheck() {
        if (!strpos($_SERVER['HTTP_REFERER'], 'token'))
            $this->returnError('非法调用');
    }
    
    /**
     * 发送消息提醒入库
     */
    function sendMsgNotice($admin, $mid, $tid, $summary = '', $type = 1)
    {
        $m_set      = spClass('m_flow_set');
        $model      = spClass('m_flow_todos');
        $model_data = $m_set->find('id='.$mid.'');
        
        $bill = spClass('m_flow_bill')->find(array('tid' => $tid, 'modelid' => $mid));
        if (empty($bill['nowcheckid'])) return true;
        $arr_bill = explode(',', $bill['nowcheckid']);
        $arr_bill = array_filter($arr_bill);
        if (empty($arr_bill)) return true;
        foreach ($arr_bill as $k => $v){
            $data = array(
                'modelid'   => $mid,
                'modelname' => $model_data['name'],
                'table'     => $model_data['table'],
                'tid'       => $tid,
                'uid'       => $v['id'],
                'adddt'     => date('Y-m-d H:i:s'),
                'title'     => $summary,
                'type'      => $type,
            );
            $model->create($data);
            //消息推送
            $this->jpushSendMsg($data['modelname'], $summary, $v['id']);
        }
//         $model->createAll($data);
    }
    
    
    /**
     * 保留字段,用于app端冗余字段的清除
     * @param unknown $arr
     * @param unknown $str
     * @return unknown[]
     */
    function keepField($arr, $str)
    {
        $keep_arr = array();
        $str_arr  = explode(',', $str);
        foreach ($str_arr as $k => $v){
            if (array_key_exists($v, $arr)) $keep_arr[$v] = $arr[$v];
        }
        return $keep_arr;
    }
    
    /**
     * 设置数组里为空字符的值
     * @param unknown $arr
     * @param unknown $str
     * @return unknown
     */
    function setEmptyStr($arr, $str)
    {
        foreach ($arr as $k => $v){
            if (empty($v)) $arr[$k] = $str;
        }
        return $arr;
    }
    
    /**
     * 目录生成
     * @param string $dir
     */
    function dirCreate($dir = 'setFerre')
    {
        if (!is_dir($dir)) mkdir($dir);
    }
    
    /**
     * 新旧数组的更新(用于表更新)
     * @param unknown $old_arr
     * @param unknown $new_arr
     * @return unknown
     */
    function checkUpdateArr1($old_arr, $new_arr)
    {
        foreach ($old_arr as $k => $v){
            if (array_key_exists($k, $new_arr) && !empty($new_arr[$k])){
                $old_arr[$k] = $new_arr[$k];
            }
        }
        return $old_arr;
    }
    
    function checkUpdateArr($old_arr, $new_arr)
    {
        if (!empty($old_arr['status'])) $new_arr['status'] = $old_arr['status'];
//         $new_arr = $this->abandonField($new_arr, 'status');
//         foreach ($old_arr as $k => $v){
//             if (array_key_exists($k, $new_arr) && !empty($new_arr[$k])){
//                 $old_arr[$k] = $new_arr[$k];
//             }
//         }
        return $new_arr;
    }
    
    /**
     * 错误提示封装
     * @param unknown $data
     * @param unknown $notice_str
     */
    function emptyNotice($data, $notice_str)
    {
        if (empty($data)) $this->returnError($notice_str);
    }
    
    /**
     * 数组类的错误提示封装
     * @param unknown $arr_data
     * @param unknown $notice_str
     */
    function emptyArrNotice($arr_data, $notice_str)
    {
        $notice_str = explode(',', $notice_str);
        foreach ($arr_data as $k => $v){
            $this->emptyNotice($v, $notice_str[$k]);
        }
    }
    
    /**
     * 舍弃字段，用于app端冗余字段的清除
     * @param unknown $arr
     * @param unknown $str
     * @return unknown[]
     */
    function abandonField($arr, $str)
    {
        $str_arr = explode(',', $str);
        foreach ($str_arr as $k => $v){
            //删除该键名对应值
            if (array_key_exists($v, $arr)) unset($arr[$v]);
        }
        return $arr;
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
                $con = 'hide = 0 and del = 0';
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
                    $con = 'id in (0' . $pros . ') and hide = 0 and del = 0';
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
                $data['nowcheckid'] = ',' . $checkusers['id'] . ',';
                $data['nowcheckname'] = $checkusers['name'];
            }
        } else if ($type == 'assign') {    //上级分配
            $checkusers = $m_admin->find(array('id' => $id));
            if ($checkusers) {
                $data['nowcheckid'] = ',' . $checkusers['id'] . ',';
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

//     function sendUpcoming($mid, $tid, $summary = '', $auto = array(),$erci = 0) {
//         $m_admin = spClass('m_admin');
//         $m_flow_set = spClass('m_flow_set');
//         $m_flow_bill = spClass('m_flow_bill');
//         $m_flow_course = spClass('m_flow_course');
//         $flow = $m_flow_set->find(array('id' => $mid));
//         $st = explode(',', $flow['statusstr']);
//         $status = $GLOBALS['PRO_STATUS'];
//         foreach ($st as $k => $v) {
//             $sta = explode('|', $v);
//             $status[$sta[1]]['text'] = $sta[0];
//             $status[$sta[1]]['color'] = $sta[2];
//         }
//         $model = spClass('m_' . $flow['table']);
//         $re = $model->find(array('id' => $tid));
//         $admin = $m_admin->find(array('id' => $_SESSION['admin']['id']));
//         $course = $m_flow_course->find(array('sid' => $mid, 'pid' => 0));
//         $data['number'] = $re['number'];
//         $data['table'] = $flow['table'];
//         $data['tid'] = $tid;
//         $data['uid'] = $admin['id'];
//         $data['uname'] = $admin['name'];
//         $data['udeptname'] = $admin['departmentname'];
//         $data['modelid'] = $mid;
//         //改变TODO
//         $data['optid'] = $admin['id'];
//         $data['optname'] = $admin['name'];
//         $data['modelname'] = $flow['name'];
//         $data['status'] = $re['status'];
//         $data['summary'] = $summary;
//         $data['statustext'] = $status[$re['status']]['text'];
//         $data['allcheckid'] = ',';
//         $bill = $m_flow_bill->find(array('table' => $flow['table'], 'tid' => $tid), '', 'id,`table`,tid,modelid');
//         if ($course) {
//             $data['cid'] = $course['id'];
//             $data['cname'] = $course['name'];
//             $chuser = $this->findcheckUser($course['checktype'], $course['checktypeid'], $admin, $auto);
//             $chuserid = trim($chuser['nowcheckid'], ',');
//             if (empty($chuserid)) {
//                 $data['status'] = -1;
//                 $data['statustext'] = '未找到审核人';
//                 $model->update(array('id' => $tid), array('status' => '-1'));
//             } else {
//                 $data['nowcheckid'] = $chuser['nowcheckid'];
//                 $data['nowcheckname'] = $chuser['nowcheckname'];
//             }
//         } else {
//             $data['statustext'] = '完成';
//         }
//         if ($bill) {
//             if(!empty($erci)){
//                 $data['status'] = 1;
//                 $data['statustext'] = '待审核';
//             }
//             $m_flow_bill->update(array('id' => $bill['id']), $data);
//             $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => 1, 'statusname' => '编辑', 'name' => '编辑', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => $bill['modelid']);
//             spClass('m_flow_log')->create($data_log);
//         } else {
//             $data['addtime'] = date('Y-m-d H:i:s');
//             $data['optdt'] = date('Y-m-d H:i:s');
//             $data['applydt'] = date('Y-m-d');
//             $ad = $m_flow_bill->create($data);
//             $data_log = array('table' => $data['table'], 'tid' => $data['tid'], 'status' => 1, 'statusname' => '添加', 'name' => '添加', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => $data['modelid']);
//             spClass('m_flow_log')->create($data_log);
//         }
//     }
    function sendUpcoming($user, $mid, $tid, $summary = '', $auto = array(), $erci = 0) {
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
        $course = $m_flow_course->find(array('sid' => $mid, 'pid' => 0));
        $data['number'] = $re['number'];
        $data['table'] = $flow['table'];
        $data['tid'] = $tid;
        $data['uid'] = $user['id'];
        $data['uname'] = $user['name'];
        $data['comid'] = $user['cid'];
        $data['dname'] = $user['dname'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['applydt'] = date('Y-m-d');
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
            $chuser = $this->findcheckUser($course['checktype'], $course['checktypeid'], $user, $auto);
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
            if (!empty($erci)) {
                $data['status'] = 1;
                $data['statustext'] = '待审核';
            }
            $m_flow_bill->update(array('id' => $bill['id']), $data);
            $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => 1, 'statusname' => '编辑', 'name' => '编辑', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $user['name'], 'checkid' => $user['id'], 'mid' => $bill['modelid']);
            spClass('m_flow_log')->create($data_log);
        } else {
            $data['addtime'] = date('Y-m-d H:i:s');
            $ad = $m_flow_bill->create($data);
            $data_log = array('table' => $data['table'], 'tid' => $data['tid'], 'status' => 1, 'statusname' => '添加', 'name' => '添加', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $user['name'], 'checkid' => $user['id'], 'mid' => $data['modelid']);
            spClass('m_flow_log')->create($data_log);
        }
        
        //jpush的两端提醒处理
//         $this->jpushSendMsg($data['modelname'], $summary);
        
    }
    
    /**
     * jpush的两端提醒处理
     */
    function jpushSendMsg($title, $content, $id)
    {
        require_once 'jpush/autoload.php';
        $client = new \JPush\Client($GLOBALS['jpush']['appKey'], $GLOBALS['jpush']['masterSecret']);
        try {
            //Android
            $client->push()
            ->setPlatform('all')
            ->addAlias(array($id))
            //                ->addTag(array('guansheng1', 'guansheng2', 'guansheng3'))
            ->androidNotification($content, array(    //多条安卓 send
                'title' => $title,
            ))
            ->send();
            //IOS
            $client->push()
            ->setPlatform('all')
            ->addAlias(array($id))
            //                ->addTag(5)
            ->iosNotification($content, array(    //多条IOS send
                'title' => $title,
                'badge' => '+1',
                'sound' => 'default',
            ))
            ->send();
        }catch (Exception $e){
            //无法处理TODO 等待工单
        }
        
    }

    function findCheck($id, $mid) {
        $user = $this->islogin();
        $m_file = spClass('m_file');
        $m_flow_set = spClass('m_flow_set');
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_log = spClass('m_flow_log');
        $m_flow_course = spClass('m_flow_course');
        $set = $m_flow_set->find(array('id' => $mid));
        if (empty($set)) {
            $this->returnError('数据有误');
        }
//         $log = $m_flow_log->findAll(array('table' => $set['table'], 'tid' => $id), '', 'id,statusname,checkname,optdt,`explain`');
        
        $log = $m_flow_log->findAll(array('table' => $set['table'], 'tid' => $id), '', 'id,files,statusname,checkname,optdt,`explain`');
        foreach ($log as $k => $v) {
            if (!empty($v['files'])) {
                $files = $m_file->findAll('id in (' . $v['files'] . ')', '', 'id,filename,filepath');
                $log[$k]['files'] = $files;
            } else {
                $log[$k]['files'] = array();
            }
        }
        $model = spClass('m_' . $set['table']);
        $result = $model->find(array('id' => $id, 'cid' => $user['cid']));
        if (empty($result)) {
            $this->returnError('数据不存在或已删除');
        }
        $result['log'] = $log;
        if (!empty($result['files'])) {
            $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        if (!empty($result['images'])) {
            $result['images'] = explode(',', $result['images']);
        }
        $bill = $m_flow_bill->find(array('modelid' => $mid, 'tid' => $id));
        
        $result['bill'] = $bill;
        if ($bill) {
            $result['st'] = $bill['statustext'];
            $result['billid'] = $bill['id'];
            $result['billcid'] = $bill['cid'];
            $course = $m_flow_course->find(array('id' => $bill['cid']), '', 'id,name,checktypename,courseact');
            $bill['nowcheckid'] = trim($bill['nowcheckid'], ',');
            $bill['nowcheckid'] = explode(',', $bill['nowcheckid']);
            if (in_array($user['id'], $bill['nowcheckid'])) {
                $course['courseact'] = empty($course['courseact']) ? array('通过|3|green', '驳回|2|red') : explode(',', $course['courseact']);
                foreach ($course['courseact'] as $k => $v) {
                    $course['courseact'][$k] = explode('|', $v);
                }
                $result['course'] = $course;
            }
        }
        
        //TODO 做nowcheckid的审核权限
        if (!in_array($user['id'], $bill['nowcheckid'])){
            $result['course'] = '';
            $result['bill'] = '';
        }
        
        $this->returnSuccess('成功', $result);
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
                    $m_flow_todos->create(array('modelid' => $flow['id'], 'model' => $flow['model'], 'modelname' => $flow['name'], 'table' => $flow['table'], 'tid' => $id, 'uid' => $v['id'], 'title' => $title, 'adddt' => $adddt, 'cid' => $v['cid']));
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
            $this->msg_json(1, '操作成功', $id);
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
        $admin = spClass('m_admin')->find(array('id' => $uid), '', 'departmentid');
        $m_kqsjgz = spClass('m_kqsjgz');
        $rows = $m_kqsjgz->findAll('pid = 0 and did = ' . $admin['departmentid'], 'sort asc');
        if (empty($rows)) {
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
        $rows = $m_kqinfo->findAll("`uid`='$uid' and `status`>=3 and `start`<='$dts 23:59:59' and `end`>='$dts 00:00:00'", '', '`start`,`end`,`type`');
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
        $rows = $m_kqgoout->findAll("`uid`='$uid' and `status`>=3 and `start`<='$dts 23:59:59' and `end`>='$dts 00:00:00'", '', '`start`,`end`,`type`');
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
                    if (empty($states)) {
                        $states = $this->gooutstates($zcarr, $dt, $uid);
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
                if ($time) {
                    $arr['time'] = $time;
                }
                $where = "`uid`='$uid' and `dt`='$dt' and `ztname`='$ztname'";
                $re = $m_kqanay->find($where, '', 'id');
                if ($re) {
                    $m_kqanay->update(array('id' => $re['id']), $arr);
                    $ids .= ',' . $re['id'];
                } else {
                    $id = $m_kqanay->create($arr);
                    $ids .= ',' . $id;
                }
            }
        }
        $m_kqanay->delete("id not in ($ids) and `uid`='$uid' and `dt`='$dt'");
    }

    function get_post() {
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value;
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }
        return $data;
    }

    /**
     * 以下为接口增加方法
     */
    public static function returnSuccess($msg, $data = array(), $code = 0) {
        $ajaxData = $data;
        $ajaxData['msg'] = $msg ? $msg : '成功';
        $ajaxData['code'] = $code ? $code : 0;
        Common::ajaxReturn($ajaxData, 'json');
    }

    public static function returnError($msg, $code = 1) {
        $ajaxData['msg'] = $msg;
        $ajaxData['code'] = $code ? $code : 1;
        Common::ajaxReturn($ajaxData, 'json');
    }

    function receiveData($data) {
        $tmp = file_get_contents("php://input");
        $tmp = json_decode($tmp, true);
        foreach ($data as $k => $v) {
            $result[$k] = $tmp[$k] ? htmlspecialchars($tmp[$k]) : htmlspecialchars($this->spArgs($k));
            if (empty($result[$k]) && !empty($v)) {
                $this->returnError($v . '不能为空');
            }
        }
        return $result;
    }

    function login() {
        
    }

    function islogin($control,$way) {
        //省略index.php $control = $this->spArgs('c');
        if (empty($control)) $control = $this->c;
        if (empty($way)) $way = $this->a;
        
        $m_admin = spClass("m_admin");
        $m_auth  = spClass('m_auth');
        $m_role  = spClass('m_role');
        $data['control'] = $control;
        $data['way']     = $way;
        $thisauth        = $m_auth->find($data);   //auth鉴权
        //token验证，然后thisauth鉴权
        //1、全部使用token权限验证；2、token判断referr不是从URL直接输入,而是从login页面跳转
        //不做过期时间，当用户注册或者登陆直接判断是否存在token，存在则鉴权，不存在则生成
//         $token = '5523cbad2881cc1ea54a6b55083547c6a932eef2';
        $token = htmlentities($this->spArgs('token'));
//         if (empty($token)){   //未登录
//             $arg      = array('username' => '用户名','password' => '密码');
//             $data     = $this->receiveData($arg);
//             $username = $data['username'];
//             $password = $data['password'];
//             $user     = $m_admin->find('username = "'.$username.'" or phone = "'.$username.'"');
//             if (empty($user)) $this->returnError('用户不存在', 2);
//             if ($user['status'] != 1) $this->returnError('抱歉，您的账号已被限制登录，如有疑问请联系管理员', 3);
//             if ($user['password'] != md5(md5($password))) return $this->returnError('用户名或密码错误');
//         }else {
        //已登陆
        $user = $m_admin->find('login = "' . $token . '" and del=0');
        if (empty($user)) $this->returnError('用户不存在', 6);
//         }
        //如果苦衷不存在token，则update新增token值
//         if (empty($user['login'])) $this->setToken($user['username'], $user['password']);
        if ($user['status'] === 0) $this->returnError('不允许登陆', 6);
        if ($user) {
            if ($user['id'] == 1) {
                return $user;
            } else if(empty ($thisauth)){
                return $user;
            }else {
                $role = json_decode($user['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    //当前权限判断
                    if ($re_role) {
                        $pro = json_decode($re_role['promission'],true);
                        if (in_array($thisauth['id'], $pro)) {
                            return $user;
                        } else {
                            $this->returnError('您没有该权限');
                        }
                    }
                }
            }
        }
        //简化流程
        if (!$user) $this->returnError('错误', 6);
//         if ($user['status'] == 4) $this->returnError('已在其他设备登录，请重新登录', 4);
//         if ($user['status'] == 1) return $user;
//         $this->returnError('该账号已被限制登录，如有疑问请联系管理员', 3);
    }

    /**
     * 公共删除方法
     * @param unknown $model
     */
    function delCommon($model, $id) {
        $admin = $this->islogin();
        $res   = spClass($model)->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res) $this->returnSuccess('成功');;
        $this->returnError('失败');
    }

    /**
     * 删除字符串前后的逗号
     * @param unknown $str
     * @return string
     */
    function delSpe($str) {
        return ltrim(rtrim($str, ','), ',');
    }

    //生成不会重复的永久token
    function setToken($username, $password) {
        if (empty($username) || empty($password))
            $this->returnError('用户名或密码不存在');
        $result = spClass('m_admin')->find('username = "' . $username . '" or phone = "' . $username . '"');
        if (empty($result))
            $this->returnError('用户不存在', 2);
        if ($result['status'] != 1)
            $this->returnError('抱歉，您的账号已被限制登录，如有疑问请联系管理员', 3);
        if ($result['password'] != md5(md5($password)))
            return $this->returnError('用户名或密码错误');
        $str = md5(uniqid(md5(microtime(true) . $username . $password), true));
        spClass('m_admin')->update('id=' . $result, array('login' => sha1($str)));
//         return sha1($str);
    }

    /**
     * 生成永久token + 验证referr
     */
    function passAuth() {
        dump($this->setToken());
        die;
        $arg = array('username' => '用户名', 'password' => '密码',);
        $data = $this->receiveData($arg);
        $username = $data['username'];
        $password = $data['password'];
        $ip = Common::getIp();
        $model = spClass('m_admin');
        $result = $model->find('username = "' . $username . '" or phone = "' . $username . '"');
        if (empty($result))
            $this->returnError('用户不存在', 2);
        if ($result['status'] != 1)
            $this->returnError('抱歉，您的账号已被限制登录，如有疑问请联系管理员', 3);

        if ($result['password'] == md5(md5($password))) {
            $login = md5(time() . $result['password'] . $result['id']);
            $model->update(array('id' => $result['id']), array('login' => $login, 'lastonline' => date('Y-m-d H:i:s'), 'lastIP' => $ip));
            $data['name'] = $result['name'];
            $data['remark'] = '登录成功';
            $data['ip'] = $ip;
            $data['time'] = date('Y-m-d H:i:s');
            $data['username'] = $username;
            $data['password'] = substr($password, 0, 3) . '******';
            $data['status'] = 1;
            spClass('m_login')->create($data);
            $apply = spClass('m_reg_company')->find('is_read = 0 and del = 0 and uid = ' . $result['id'], 'applydt desc', 'cname,dname,pname,applydt,status,`explain`,checkdt');
            $apply['token'] = $login;
            $apply['cid'] = $result['cid'];
            $this->returnSuccess('登录成功', $apply);
        } else {
            $data['name'] = $result['name'];
            $data['remark'] = '密码错误';
            $data['ip'] = $ip;
            $data['time'] = date('Y-m-d H:i:s');
            $data['username'] = $username;
            $data['password'] = substr($password, 0, 3) . '******';
            $data['status'] = 1;
            spClass('m_login')->create($data);
            $this->returnError('密码错误', 3);
        }
    }

    function logResult($word = '', $filename = '') {
        $filename = empty($filename) ? 'log.txt' : $filename;
        $fp = fopen($filename, "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "\n 执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

}
?>


