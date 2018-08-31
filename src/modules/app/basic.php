<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class basic extends AppController {

    function data() {
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

    function regCompanyRead() {
        $user = $this->islogin();
        spClass('m_reg_company')->update(array('uid' => $user['id']), array('is_read' => 1));
    }

    function findAddress() {
        $model = spClass('m_pca');
        $pid = (int) htmlentities($this->spArgs('pid'));
        $level = (int) htmlentities($this->spArgs('level'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if ($pid) {
            $con = 'pid = ' . $pid;
        } else if(!empty ($level)){
            $con = 'level = '.$level;
        }else{
            $con = 'pid = 0';
        }
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
        }
        $results = $model->findAll($con, '', 'aid,name,level');
        exit(json_encode(array('data' => $results)));
    }

    function findUserinfo() {
        $token = htmlentities($this->spArgs('token'));
        $m_user = spClass('m_user');
        $m_company = spClass('m_company');
        if (empty($token)) {
            $this->returnError('请先登录', 6);
        }
        $result = $m_user->find(array('login' => $token), '');
        if ($result) {
            $apply = spClass('m_reg_company')->find('is_read = 0 and uid = ' . $result['id'], 'applydt desc', 'cname,dname,pname,applydt,status,`explain`,checkdt');
            $result['apply'] = $apply;
            $result['head'] = URL . $result['head'];
            $result['idcard'] = URL . $result['idcard'];
            $company = $m_company->find(array('id' => $result['cid']), '', 'company,logo,status');
            $result['companylogo'] = empty($company['logo']) ? '' : URL . $company['logo'];
            $result['company'] = $company['company'];
            $this->returnSuccess('成功', $result);
        } else {
            $this->returnError('已在其他设备登录，请重新登录', 7);
        }
    }

    /*     * ****************
     * 获取员工列表
     * **************** */

    function findUsers() {
        $user = $this->islogin();
        $m_department = spClass('m_department');
        $level = htmlentities($this->spArgs('level'));
        $name = htmlspecialchars($this->spArgs('name'));
        $m_user = spClass('m_user');
        if(empty($level)){
            $results = $m_department->findAll(array('pid' => $user['cid']), '', 'id,name,pid');
            foreach ($results as $k1 => $v1) {
                $results[$k1]['name'] = $v1['name'];
                $results[$k1]['children'] = $m_user->findAll(array('did' => $v1['id']), '', 'id,name,dname,pname,cname');
            }
        }else{
            $results = $m_user->findAll(array('cid' => $user['cid']), '', 'id,name,dname,pname,cname');
        }
        $this->returnSuccess('成功', array('data' => $results));
    }

    /*     * ****************
     * 获取公司列表
     * **************** */

    function findCompany() {
        $model = spClass('m_company');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if ($name) {
            $con .= ' and (companyinfo like "%' . $name . '%" or company like "%' . $name . '%")';
        }
        $results = $model->findAll($con, '', 'id,companyinfo,company');
        $this->returnSuccess('成功', array('data' => $results));
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function findDepartment() {
        $model = spClass('m_department');
        $token = htmlentities($this->spArgs('token'));
        $cid = (int) htmlentities($this->spArgs('cid'));
        if ($token) {
            $user = spClass('m_user')->find(array('login' => $token));
            $cid = (int) $user['cid'];
        }
        $con = 'del = 0 and pid = ' . $cid;
        $results = $model->findAll($con, '', 'id,name');
        $this->returnSuccess('成功', array('data' => $results));
    }

    /*     * ****************
     * 获取职位列表
     * **************** */

    function findPosition() {
        $model = spClass('m_position');
        $con = 'del = 0';
        $results = $model->findAll($con, '', 'id,name');
        $this->returnSuccess('成功', array('data' => $results));
    }
    
    function findSuperiors(){
        $user = $this->islogin();
        $model = spClass('m_user');
        $results = $model->findSuperior($user['superior'],2);
        $this->returnSuccess('成功', array('data' => $results));
    }
    
    function findSubordinate(){
        $user = $this->islogin();
        $model = spClass('m_user');
        $results = $model->findSubordinate($user['id'],2);
        $this->returnSuccess('成功', array('data' => $results));
    }

    //打卡
    function dkgps() {
        $user = $this->islogin();
        $results = spClass('m_kqdkjl')->findAll('uid = ' . $user['id'], 'dkdt desc', 'id,dkdt,address,lat,lng', 10);
        $this->returnSuccess('成功', array('results' => $results));
    }

    function saveDkgps() {
        $user = $this->islogin();
        $ip = Common::getIp();
        $sip = substr($ip, 0, 7);
        $company = spClass('m_company')->find(array('id' => $user['cid']), '', 'dkIP');
        if (!empty($company['dkIP']) && strpos($company['dkIP'], $sip) === false) {
            $this->returnError('打卡ip段跟公司ip不符');
        }
        $data['lng'] = htmlentities($this->spArgs('lng')); //经度
        $data['lat'] = htmlentities($this->spArgs('lat')); //纬度
        $data['address'] = htmlspecialchars($this->spArgs('address'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
//        $images = trim(htmlspecialchars($this->spArgs('images')),',');
//        $images = explode(',', $images);
//        foreach ($images as $v) {
//            $image[] = Common::copy_upload($v, 'kaoqin/' . date('Y-m-d'));
//            $mximg = $this->getmximg($v, 'mx');
//            Common::copy_upload($mximg, 'kaoqin/' . date('Y-m-d'));
//        }
//        $data['images'] = implode(',', $image);
        $data['dkdt'] = date('Y-m-d H:i:s');
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['type'] = 5;
        $data['ip'] = $ip;
        $data['uid'] = $user['id'];
        $data['cid'] = $user['cid'];
        $ad = spClass('m_kqdkjl')->create($data);
        if ($ad) {
            Common::kqanay($user['id'], date('Y-m-d'), $user['cid']);
            $this->returnSuccess('打卡成功');
        } else {
            $this->returnError('打卡失败');
        }
    }


}

?>
