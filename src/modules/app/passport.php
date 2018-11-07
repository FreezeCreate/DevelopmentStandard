<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class passport extends AppController {

    function getSessionId() {
        exit(session_id());
    }

    function nowVersion() {
        $version = htmlentities($this->spArgs('version'));
        if ($version == $GLOBALS['VERSION']['num']) {
            $this->returnError('当前版本已是最新版本', 2);
        } else {
            $this->returnSuccess('检测到新版本', $GLOBALS['VERSION']);
        }
    }

    function login() {
        $arg = array(
            'username' => '用户名',
            'password' => '密码',
            'ua' => '',
        );
        $data = $this->receiveData($arg);
        $username = $data['username'];
        $password = $data['password'];
        $UA = $data['ua'];
        $model = spClass('m_user');
        $result = $model->find('username = "'.$username.'" or phone = "'.$username.'"');
        if (empty($result)) {
            $this->returnError('用户不存在', 2);
        }
        if ($result['status'] != 1) {
            $this->returnError('抱歉，您的账号已被限制登录，如有疑问请联系管理员', 3);
        }
        $ip = Common::getIp();
        if ($result['password'] == md5(md5($password))) {
            $login = md5(time().$result['password'] . $result['id']);
            $model->update(array('id' => $result['id']), array('login' => $login, 'lastonline' => date('Y-m-d H:i:s'), 'lastUA' => $UA, 'lastIP' => $ip));
            $data['name'] = $result['name'];
            $data['remark'] = '登录成功';
            $data['ip'] = $ip;
            $data['time'] = date('Y-m-d H:i:s');
            $data['username'] = $username;
            $data['password'] = substr($password, 0, 3) . '******';
            $data['status'] = 1;
            spClass('m_login')->create($data);
            $apply = spClass('m_reg_company')->find('is_read = 0 and del = 0 and uid = '.$result['id'],'applydt desc','cname,dname,pname,applydt,status,`explain`,checkdt');
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

    function regCompany() {
//        $this->logResult("post:".json_encode($_POST)."\n get:".json_encode($_GET)."\n files:".json_encode($_FILES));
        $ip = Common::getIp();
        $arg = array(
            'companyinfo' => '公司全称',
            'company' => '公司简称',
            'name' => '法人姓名',
            'logo' => '公司logo',
            'idcard' => '法人身份证图片',
            'idcardnumber' => '法人身份证号',
            'licensenumber' => '统一社会信用代码',
            'license' => '营业执照图片',
            'username' => '用户名',
            'password' => '登录密码',
            'confirm_password' => '确认密码',
            'phone' => '手机号',
            'code' => '',
            'province' => '地区',
            'city' => '地区',
            'area' => '地区',
            'address' => '',
            'ua' => '',
        );
        $data = $this->receiveData($arg);
        $UA = $data['ua'];
        $m_user = spClass('m_user');
        $m_company = spClass('m_company');
        if(!preg_match("/^[a-zA-Z0-9]+$/",$data['username'])){
            $this->returnError('用户名只能输入英文和数字');
        }
        if (strlen($data['username']) < 8 || strlen($data['username']) > 15) {
            $this->returnError('请输入8-15位用户名', strlen($data['username']));
        }
        if (strlen($data['password']) < 6 || strlen($data['password']) > 12) {
            $this->returnError('请输入6-12位密码', 2);
        }
        $re = $m_user->find(array('username' => $data['username']));
        if (!empty($re)) {
            $this->returnError('用户名已存在', 3);
        }
        $data_u['username'] = $data['username'];
        if ($data['password'] === $data['confirm_password']) {
            $data_u['password'] = md5(md5($data['password']));
        } else {
            $this->returnError('两次密码不一致', 2);
        }
        $this->get_sms($data['phone'], $data['code']);
        $data['logo'] = Common::base64_image_content($data['logo'], 'logo/' . date('Ymd'));
        $data['idcard'] = Common::base64_image_content($data['idcard'], 'logo/' . date('Ymd'));
        $data['license'] = Common::base64_image_content($data['license'], 'logo/' . date('Ymd'));
        $data['status'] = 1;
        $com = $m_company->find(array('company' => $data['company']));
        if ($com) {
            $this->returnError('该公司已注册', 3);
        }
        $cid = $m_company->create($data);
        $did = spClass('m_department')->create(array('name'=>'管理员','pid'=>$cid));
        $data_u['login'] = md5(time().$data['password'] . $data['username']);
        $data_u['cid'] = $cid;
        $data_u['did'] = $did;
        $data_u['dname'] = '管理员';
        $data_u['pid'] = '1';
        $data_u['pname'] = '管理员';
        $data_u['cname'] = $data['company'];
        $data_u['status'] = 1;
        $data_u['lastonline'] = date('Y-m-d H:i:s');
        $data_u['lastUA'] = $UA;
        $data_u['lastip'] = $ip;
        $data_u['name'] = $data['name'];
        $data_u['head'] = '/source/index/images/head.png';
        $data_u['phone'] = $data['phone'];
        $data_u['idcard'] = $data['idcard'];
        $data_u['idcardnumber'] = $data['idcardnumber'];
        $data_u['is_company'] = 1;
        $data_u['phone'] = $data['phone'];
        $data_u['dir'] = 2;
        $data_u['is_auth'] = 1;
        $data_u['regdt'] = date('Y-m-d H:i:s');
        $data_u['regip'] = $ip;
        $data_u['entrydt'] = date('Y-m-d');
        $data_u['positivedt'] = date('Y-m-d');
        $data_u['regUA'] = $UA;
        if ($cid) {
            $ad = $m_user->create($data_u);
            if ($ad) {
                $data_u['id'] = $ad;
                Common::getBasic($data_u);
                $this->returnSuccess('注册成功', array('token' => $data_u['login']));
            } else {
                $m_company->delete(array('id' => $cid));
                $this->returnError('注册失败', 404);
            }
        } else {
            $this->returnError('操作失败', 404);
        }
    }

    function regPerson() {
        $ip = Common::getIp();
        $arg = array(
            'name' => '姓名',
            'idcard' => '身份证图片',
            'idcardnumber' => '身份证号',
            'username' => '用户名',
            'password' => '登录密码',
            'confirm_password' => '确认密码',
            'phone' => '手机号',
            'code' => '',
            'ua' => '',
        );
        $data = $this->receiveData($arg);
        $UA = $data['ua'];
        $m_user = spClass('m_user');
        if(!preg_match("/^[a-zA-Z0-9]+$/",$data['username'])){
            $this->returnError('用户名只能输入英文和数字');
        }
        if (strlen($data['username']) < 8 || strlen($data['username']) > 15) {
            $this->returnError('请输入8-15位用户名', 2);
        }
        if (strlen($data['password']) < 6 || strlen($data['password']) > 12) {
            $this->returnError('请输入6-12位密码', 2);
        }
        $re = $m_user->find(array('username' => $data['username']));
        if (!empty($re)) {
            $this->returnError('用户名已存在', 3);
        }
        if ($data['password'] === $data['confirm_password']) {
            $data['password'] = md5(md5($data['password']));
        } else {
            $this->returnError('两次密码不一致', 2);
        }
        $this->get_sms($data['phone'], $data['code']);
        $data['idcard'] = Common::base64_image_content($data['idcard'], 'logo/' . date('Ymd'));
        $data['status'] = 1;
        $data['login'] = md5(time().$data['password'] . $data['username']);
        $data['head'] = '/source/index/images/head.png';
        $data['status'] = 1;
        $data['lastonline'] = date('Y-m-d H:i:s');
        $data['lastUA'] = $UA;
        $data['lastip'] = $ip;
        $data['is_company'] = 0;
        $data['dir'] = 2;
        $data['is_auth'] = 1;
        $data['regdt'] = date('Y-m-d H:i:s');
        $data['regip'] = $ip;
        $data['regUA'] = $UA;
        $ad = $m_user->create($data);
        if ($ad) {
            $this->returnSuccess('注册成功', array('token' => $data['login']));
        } else {
            $this->returnError('注册失败', 404);
        }
    }
    
    function boundCompany(){
        $user = $this->islogin();
        if(empty($user)){
            $this->returnError('请先登录',4);
        }
        if($user['cid']){
            $this->returnError('您已绑定公司，不可重复提交');
        }
        $cid = (int)htmlentities($this->spArgs('cid'));
        $did = (int)htmlentities($this->spArgs('did'));
        $pid = (int)htmlentities($this->spArgs('pid'));
        $model = spClass('m_reg_company');
        $company = spClass('m_company')->find(array('id'=>$cid),'id,company');
        $department = spClass('m_department')->find(array('id'=>$did),'id,name');
        $position = spClass('m_position')->find(array('id'=>$pid),'id,name');
        if(empty($company)){
            $this->returnError('请选择公司');
        }
        if(empty($department)){
            $this->returnError('请选择部门');
        }
        if(empty($position)){
            $this->returnError('请选择职位');
        }
        $re = $model->find(array('uid'=>$user['id'],'status'=>1));
        if($re){
            $this->returnError('您已提交过申请，请勿重复提交',5);
        }
        $data = array(
            'uid' => $user['id'],
            'cid' => $company['id'],
            'cname' => $company['company'],
            'did' => $department['id'],
            'dname' => $department['name'],
            'pid' => $position['id'],
            'pname' => $position['name'],
            'applydt' => date('Y-m-d H:i:s'),
            'status' => 1,
        );
        $ad = $model->create($data);
        if($ad){
            $this->returnSuccess('申请成功，管理员审核过后可进入系统操作',$data);
        }else{
            $this->returnError('操作失败',404);
        }
    }

    /**
     * 发送短信验证码
     * */
    function do_sms() {
        $phone = htmlspecialchars($this->spArgs("phone"));
        if (!preg_match("/1[0-9]{10}$/", $phone)) {
            $this->returnError("手机号码格式错误", 2);
        }
        $m_user = spClass('m_user');
        $con['phone'] = $phone;
        $re = $m_user->find($con);
        if ($re) {
            $this->returnError('您的手机号已经注册过了');
        } else {
            $yzm = rand(1000, 9999);
            $yzm = 1234;
            $_SESSION['yanzheng']['phone'] = $phone;
            $_SESSION['yanzheng']['yzm'] = $yzm;
            $content = '您的短信验证码是：' . $yzm;
            //$result = Common::sendSMS($phone, $content);
            $this->returnSuccess('短信已发送', array('yzm' => $yzm,'result'=>$result));
        }
    }

    /**
     * 检查用户验证码
     */
    function get_sms($phone, $yanzheng) {
        if ($phone == $_SESSION['yanzheng']['phone'] && $yanzheng == $_SESSION['yanzheng']['yzm']) {
            
        } else {
            //$this->returnError('验证码错误', 2);
        }
    }

    /**
     * 检查用户名
     * @param unknown_type $username
     */
    function checkusername($username) {
        $rules = "/(?!^\\d+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{3,20}/";
        if (!preg_match($rules, $username)) {
            $this->msg_json(0, "用户名格式错误，由3~20位的字母数字组成！");
        }
        $m_user = spClass("m_user");
        if ($m_user->find(array("username" => $username))) {
            $this->msg_json(0, "用户名已被使用，请换一个再试！");
        }
    }

    /**
     * 检查手机号码
     * @param unknown_type $phone
     */
    function checkphone($phone) {
        if (!preg_match("/1[0-9]{10}$/", $phone)) {
            $this->msg_json(0, "手机号码格式错误！");
        }
        $m_user = spClass("m_user");
        $re = $m_user->find(array("phone" => $phone));
        if ($re) {
            $this->msg_json(0, "手机号码已被使用，请换一个再试！");
        }
    }

    /**
     * 检查密码
     * @param unknown_type $password
     * @param unknown_type $confirm_password
     */
    function checkpassword($password, $confirm_password) {
        if (empty($password)) {
            $this->msg_json(0, "密码不能为空！");
        }
        if ($password != $confirm_password) {
            $this->msg_json(0, "两次输入的密码不一致！");
        }
    }

    function randomkeys($length) {
        $pattern = '1234567890'; //字符池
        for ($i = 0; $i < $length; $i++) {
            $key.=$pattern{mt_rand(0, 9)}; //生成php随机数
        }
        return $key;
    }

}

?>
