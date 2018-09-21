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
        $model = spClass('m_admin');
        $result = $model->find('username = "' . $username . '" or phone = "' . $username . '"');
        if (empty($result)) {
            $this->returnError('用户不存在', 2);
        }
        if ($result['status'] != 1) {
            $this->returnError('抱歉，您的账号已被限制登录，如有疑问请联系管理员', 3);
        }
        $ip = Common::getIp();
        if ($result['password'] == md5(md5($password))) {
            $login = md5(time() . $result['password'] . $result['id']);
            $model->update(array('id' => $result['id']), array('lastonline' => date('Y-m-d H:i:s'), 'lastUA' => $UA, 'lastIP' => $ip));
            $data['name'] = $result['name'];
            $data['remark'] = '登录成功';
            $data['ip'] = $ip;
            $data['time'] = date('Y-m-d H:i:s');
            $data['username'] = $username;
            $data['password'] = substr($password, 0, 3) . '******';
            $data['status'] = 1;
            spClass('m_login')->create($data);
            $this->returnSuccess('登录成功', array('token'=>$result['login']));
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
    
}

?>
