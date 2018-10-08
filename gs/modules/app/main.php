<?php

/**
 * Description of main
 *
 * @author IndexController
 */
class main extends AppController {

    function index() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
    }
    
    /**
     * 超全局变量参数
     */
    function data() 
    {
        $type = htmlentities($this->spArgs('type'));
        $result = $GLOBALS[$type];
        foreach ($result as $k => $v) {
            if (is_array($v)) {
                $ch = array();
                foreach($v['children'] as $k1=>$v1){
                    if(is_array($v1)){
                        $ch[] = array(
                            'id' => $k1,
                            'name' => $v1['name'],
                        );
                    }else{
                        $ch[] = array(
                            'id' => $k1,
                            'name' => $v1,
                        );
                    }
                }
                $results[] = array(
                    'id' => $k,
                    'name' => $v['name'],
                    'children' => $ch,
                );
            } else {
                $results[] = array(
                    'id' => $k,
                    'name' => $v,
                );
            }
        }
        exit(json_encode(array('data' => $results)));
    }
    
    /**
     * 付款方式接口
     */
    function payType()
    {
        $admin   = $this->islogin();
        $results = spClass('m_account')->findAll('', 'id asc');
        foreach ($results as $k => $v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 收付款账户信息列表
     */
    function accountLst()
    {
        $admin   = $this->islogin();
        $results = spClass('m_account')->findAll('', 'date desc');
        foreach ($results as $k => $v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /*
     * 部门列表接口
     */
    function departmentLst()
    {
        $admin   = $this->islogin();
        $results = spClass('m_department')->findAll('', 'id desc');
        foreach ($results as $k => $v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 用户列表接口
     */
    function userLst()
    {
        $admin   = $this->islogin();
        $results = spClass('m_admin')->findAll('', 'id asc', 'id,name');
        foreach ($results as $k => $v){
            $result['results'][] = array('id' => $v['id'], 'username' => $v['name']);
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 客户潜在类型
     */
    function custType()
    {
        $this->islogin();
        $result['results'] =  array(1 => '潜在客户', 2 => '用户', 3 => '已放弃');
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 客户来源
     */
    function custSource()
    {
        $this->islogin();
        $result['results'] =  array(1 => '网上开拓', 2 => '电话开拓', 3 => '线下开拓', 4 => '主动来访');
        $this->returnSuccess('成功', $result);
    }
    /*
     * 客户行业类型-已废弃
     */
    function custJob()
    {
        $this->islogin();
        $result['results'] =  array(
            1 => "电气",
            2 => "机械",
            4 => "互联网",
            5 => "餐饮",
            6 => "医疗",
            7 => "建筑",
            8 => "交通",
            9 => "物资",
            10 => "办公",
            11 => "体育",
            12 => "旅游",
            13 => "水利",
        );
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 客户跟进状态
     */
    function flowType()
    {
        $this->islogin();
        $result['results'] = array(1 => '未跟进', 2 => '正在跟进', 3 => '完成签约');
        $this->returnSuccess('成功', $result);
    }
    

//     function login() {
//         $username = htmlspecialchars($this->spArgs('username'));
//         $password = htmlspecialchars($this->spArgs('password'));
//         $code = htmlspecialchars($this->spArgs('code'));
//         if (isset($_SESSION['admin'])) {
//             header('Location:' . spUrl('main', 'index'));
//         }
//         if ($_POST) {
//             $ip = Common::getIp();
//             $data = array(
//                 'ip' => $ip,
//                 'time' => date('Y-m-d H:i:s'),
//             );
//             if (!empty($username) && !empty($password)) {
//                 $_COOKIE['admin']['username'] = $username;
//                 $model_admin = spClass('m_admin');
//                 $result = $model_admin->find(array('username' => $username, 'status' => 1));
//                 if ($result['password'] == md5(md5($password))) {
//                     $_SESSION['admin'] = $result;
//                     unset($_SESSION['code']);
//                     $data['name'] = $result['name'];
//                     $data['remark'] = '登录成功';
//                     spClass('m_login')->create($data);
//                     $this->msg_json(1, '登录成功');
//                 } else {
//                     $data['name'] = $result['name'];
//                     $data['remark'] = '登录失败：' . $username;
//                     spClass('m_login')->create($data);
//                     $this->msg_json(0, '用户名或者密码错误');
//                 }
//             }
//         }
//     }

    function login() {
        $username = htmlspecialchars($this->spArgs('username'));
        $password = htmlspecialchars($this->spArgs('password'));
        
        if ($_POST) {
            $ip = Common::getIp();
            $data = array(
                'ip' => $ip,
                'time' => date('Y-m-d H:i:s'),
            );
            if (!empty($username) && !empty($password)) {
                $_COOKIE['admin']['username'] = $username;
                $result = spClass('m_admin')->find(array('username' => $username, 'status' => 1));    //查询
                if ($result['password'] == md5(md5($password))) {
//                     setcookie("admin",serialize($result),time()+15*24*3600);
//                     setcookie("token",$result['login']);
                    $data['name'] = $result['name'];
                    $data['remark'] = '登录成功';
                    spClass('m_login')->create($data);
                    $this->msg_json(1, '登录成功', $result['login'], '', $result['login']);
                    
                } else {
                    $data['name'] = $result['name'];
                    $data['remark'] = '登录失败：' . $username;
                    spClass('m_login')->create($data);
                    $this->msg_json(0, '用户名或者密码错误');
                }
            }
        }
    }
    
    /**
     * 导航列表home1_12 home1-12
     * @param unknown $oid
     */
    function menuLst($oid)
    {
        //TODO 导航栏的权限判断
        $oid = htmlspecialchars($this->spArgs('oid'));
        if (empty($oid)) $oid = 0;
        $result['results'] = spClass('m_auth')->findAll('oid='.$oid.' and hide = 0 and pid = 0','sort');
        foreach($result['results'] as $k=>$v){
            $result['results'][$k]['children'] = spClass('m_auth')->findAll('oid='.$oid.' and hide = 0 and pid = '.$v['id'],'sort');
        }
        
        $this->returnSuccess(1, $result);
    }
    
    function editMyinfo() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $data['phone'] = htmlspecialchars($this->spArgs('phone'));
        $data['trumpet'] = htmlspecialchars($this->spArgs('trumpet'));
        $data['idCard'] = htmlspecialchars($this->spArgs('idCard'));
        $data['birthday'] = htmlspecialchars($this->spArgs('birthday'));
        $data['email'] = htmlspecialchars($this->spArgs('email'));
        $data['QQ'] = htmlspecialchars($this->spArgs('QQ'));
        if (empty($data['phone'])) {
            $this->msg_json(0, '手机号不能为空');
        }
        $up = $m_admin->update(array('id' => $admin['id']), $data);
        if ($up) {
            $this->msg_json(1, '修改成功');
        } else {
            $this->msg_json(0, '修改失败');
        }
    }

    function logout() {
        unset($_SESSION['admin']);
        $this->success('退出成功', spUrl('main', 'login'));
    }

    function edit_password() {
        $admin = $this->get_ajax_menu();
        $password = $this->spArgs('password');
        $new_password = $this->spArgs('new_password');
        $confirm_password = $this->spArgs('confirm_password');
        if (empty($password)) {
            $this->msg_json(0, "原密码不能为空！");
        }
        if (empty($new_password)) {
            $this->msg_json(0, "新密码不能为空！");
        }
        if ($new_password != $confirm_password) {
            $this->msg_json(0, "两次密码输入不一致");
        }
        $model = spClass("m_admin");
        $con = array("id" => $admin["id"]);
        $re = $model->find($con);
        if ($re) {
            if ($re["password"] != md5(md5($password))) {
                $this->msg_json(0, "原密码错误！");
            }
        }
        $data = array('password' => md5(md5($new_password)));
        $r = $model->update($con, $data);
        if ($r) {
            $this->msg_json(1, '修改成功，下次请用新密码登录');
        } else {
            $this->msg_json(0, '修改失败');
        }
    }

    /*     * **************
     * 下载文件
     * ************** */

    function download() {
        $m_file = spClass('m_file');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_file->find(array('id' => $id));
        $filename = APP_PATH . $result['filepath'];
        $file = fopen($filename, "r");
        ob_get_clean();
        ob_clean();
        header("Content-Type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . filesize($filename));
        header("Content-Disposition: attachment; filename=" . $result['filename']);
        echo fread($file, filesize($filename));
        fclose($file);
    }

    /*     * ****************
     * 获取员工列表
     * **************** */

    function getUsers() 
    {
        $user = $this->islogin();
        $m_department = spClass('m_department');
        $m_user = spClass('m_admin');
        $results = $m_department->findAll(array('pid' => $user['cid']), '', 'id,name,pid');
        foreach ($results as $k1 => $v1) {
            $results[$k1]['name'] = $v1['name'];
            $results[$k1]['children'] = $m_user->findAll(array('did' => $v1['id'], 'hide' => 0), '', 'id,name,dname,pname,cname');
        }
        $this->returnSuccess('成功', $results);
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function getDepartment() {
        $admin = $this->get_ajax_menu();
        $m_company = spClass('m_company');
        $m_department = spClass('m_department');
        if ($admin['id'] == 1) {
            $company = $m_company->findAll();
            foreach ($company as $v) {
                $re = $m_department->findAll(array('pid' => $v['id']), '', 'id,name');
                foreach ($re as $v1) {
                    $results[] = array(
                        'id' => $v1['id'],
                        'name' => '【' . $v['name'] . '】' . $v1['name'],
                    );
                }
            }
        } else {
            $results = $m_department->findAll(array('pid' => $admin['cid']), '', 'id,name');
        }
        $this->msg_json(1, '获取成功', $results);
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function findCompany() {
        $admin = $this->get_ajax_menu();
        $m_company = spClass('m_company');
        $company = $m_company->findAll();
        $this->msg_json(1, '获取成功', $company);
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function findDepartment() {
        $admin = $this->get_ajax_menu();
        $m_department = spClass('m_department');
        $id = (int) htmlentities($this->spArgs('id'));
        $results = $m_department->findAll(array('pid' => $id));
        $this->msg_json(1, '获取成功', $results);
    }

    function findPonsenel() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $id = (int) htmlentities($this->spArgs('id'));
        $results = $m_admin->findAll(array('did' => $id));
        $this->msg_json(1, '获取成功', $results);
    }

    /*     * ****************
     * 获取职位列表
     * **************** */

    function getPosition() {
        $admin = $this->get_ajax_menu();
        $m_position = spClass('m_position');
        $results = $m_position->findAll('', '', 'id,name');
        $this->msg_json(1, '获取成功', $results);
    }

    function findCustomer() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $con = 'del = 0';
        if ($id) {
            $con .= ' and uid = ' . $id;
        }
        $results = spClass('m_customer')->findAll($con);
        foreach ($results as $k => $v) {
            $results[$k]['name'] = $v['company'];
        }
        $this->msg_json(1, '获取成功', $results);
    }

    function gettotal() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $m_admin->update(array('id' => $admin['id']), array('lastonline' => date('Y-m-d H:i:s'))); //最后在线时间
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_todos = spClass('m_flow_todos');
        $newbill = $m_flow_bill->findAll('del = 0 and nowcheckid like "%,' . $admin['id'] . ',%"');
        $todos = $m_flow_todos->findAll('uid = ' . $admin['id'] . ' and isread = 0');
        $infor = spClass('m_infor')->findAll('receid = "" and del = 0 and cid = '.$admin['cid'], 'date desc,id desc', 'id,title,type,date', 5);
        $infor = empty($infor) ? array() : $infor;
        $orders = spClass('m_orders')->findAll('del = 0 and comid = '.$admin['cid'], 'adddt desc,id desc', 'id,number,name,money,cname,date', 5);
        $infor = empty($infor) ? array() : $infor;
        $total['upcoming'] = count($newbill);
        $total['todos'] = count($todos);
        $content = array();
        foreach ($newbill as $v) {
            if (!in_array('u' . $v['id'], $_SESSION['Popu'])) {
                $content[] = array('id' => $v['id'], 'title' => $v['modelname'], 'content' => $v['summary'], 'href' => spUrl('process', 'upcoming'), 'Popu' => 'u' . $v['id']);
            }
        }
        foreach ($todos as $v) {
            if (!in_array('r' . $v['id'], $_SESSION['Popu'])) {
                $content[] = array('id' => $v['id'], 'title' => $v['modelname'], 'content' => $v['title'], 'href' => spUrl('person', 'remind'), 'Popu' => 'r' . $v['id']);
            }
        }
        echo json_encode(array("total" => $total, 'content' => $content, 'infor' => $infor, 'newbill' => $newbill, 'orders' => $orders));
        foreach ($content as $v) {
            $_SESSION['Popu'][] = $v['Popu'];
        }
        exit;
    }
    

}

?>
