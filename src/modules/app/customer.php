<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class customer extends AppController {

    function index() {
        $user = $this->islogin();
        $m_customer = spClass('m_customer');
        $m_custract = spClass('m_custract');
        $m_room_report = spClass('m_room_report');
        $m_room_report_log = spClass('m_room_report_log');
        $result['todayadd'] = $m_customer->findCount('createid = '.$user['id'].' and cid = '.$user['cid'].' and del = 0 and createdt >= '.date('Ymd000000'));
        $todaydk = $m_room_report_log->findSql('select count(*) as sum from '.DB_NAME.'_room_report as a left outer join '.DB_NAME.'_room_report_log as b on a.id = b.rid where a.uid = '.$user['id'].' and a.ucid = '.$user['cid'].' and b.opt = "带看成功" and b.optdt >= '.date('Ymd000000'));
        $result['todaydk'] = $todaydk[0]['sum'];
        $todaycj = $m_custract->findSql('select count(*) as sum,sum(money) as money from '.DB_NAME.'_custract where uid = '.$user['id'].' and cid = '.$user['cid'].' and signdt >= '.date('Ymd'));
        $result['todaycj'] = $todaycj[0]['sum'];
        $sumcj = $m_custract->findSql('select count(*) as sum,sum(money) as money from '.DB_NAME.'_custract where uid = '.$user['id'].' and cid = '.$user['cid'].' and signdt >= '.date('Ymd'));
        $result['sumcj'] = $sumcj[0]['sum'];
        $result['sumcjmoney'] = $sumcj[0]['money']*1;
        $sumdk = $m_room_report_log->findSql('select count(*) as sum from '.DB_NAME.'_room_report as a left outer join '.DB_NAME.'_room_report_log as b on a.id = b.rid where a.uid = '.$user['id'].' and a.ucid = '.$user['cid'].' and b.opt = "带看成功"');
        $result['sumdk'] = $sumdk[0]['sum'];
        $result['sumadd'] = $m_customer->findCount('createid = '.$user['id'].' and cid = '.$user['cid']);
        $this->returnSuccess('成功',$result);
    }

    function findmycust() {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and err = 0 and cid = ' . $user['cid'] . ' and nowuid = ' . $user['id'];
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
        }
        //$con = 'del = 0 and err = 0 and cid = ' . $user['cid'];
        $results = $model->findAll($con, '', 'id,name,phone');
        $this->returnSuccess('成功', array('results' => $results));
    }

    //我的客户
    function mycustomer() {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $con = 'del = 0 and nowuid = ' . $user['id'] . ' and cid = ' . $user['cid'];
        $rname = htmlspecialchars($this->spArgs('rname'));
        $time = (int) htmlentities($this->spArgs('time'));
        $start = htmlentities($this->spArgs('start'));
        $err = (int) htmlentities($this->spArgs('err'));
        $end = htmlentities($this->spArgs('end'));
        $status = urldecode(htmlspecialchars($this->spArgs('status')));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $model->findCustomer($rname, $user['id'], $user['cid'], $time, $start,$end, $status,$err, $name, 'optdt desc', 'id,name,statext,createdt,optdt,is_new,err', $this->spArgs('page', 1));
        if (empty($re['results'])) {
            $this->returnError('暂无数据');
        }
        $page = $re['pager']['current_page'] == $re['pager']['last_page'] ? '0' : $re['pager']['next_page'];
        $result['page'] = $page;
        foreach ($re['results'] as $k => $v) {
            $result['results'][$k] = array(
                'id' => $v['id'],
                'name' => $v['name'],
                'statext' => $v['statext'],
                'is_new' => $v['optid']!=$user['id']?$v['is_new']:0,
                'dt' => date('Y.m.d', strtotime($v['optdt'])),
                'err' => $v['err'],
            );
            if ((time() - 7 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '一周内';
            } else if ((time() - 10 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '10天内';
            } else if ((time() - 15 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '15天内';
            } else if ((time() - 30 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '30天内';
            }
        }
        $this->returnSuccess('成功', $result);
    }

    //下属客户
    function underling() {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $con = 'del = 0 and cid = ' . $user['cid'];
        $rname = htmlspecialchars($this->spArgs('rname'));
        $uid = htmlentities($this->spArgs('uid'));
        $time = (int) htmlentities($this->spArgs('time'));
        $err = (int) htmlentities($this->spArgs('err'));
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $status = urldecode(htmlspecialchars($this->spArgs('status')));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($rname)) {
            $con .= ' and intention like "%' . $rname . '%"';
        }
        if (!empty($uid)||$uid==='0') {
            $con .= ' and nowuid = ' . $uid;
        }
        if (!empty($time)) {
            $t = date('YmdHis', strtotime('-' . $time . 'day'));
            $con .= ' and createdt > ' . $t;
        }
        if (!empty($start)) {
            $t = date('YmdHis', strtotime($start));
            $con .= ' and createdt >= ' . $t;
        }
        if (!empty($end)) {
            $t = date('YmdHis', strtotime($end));
            $con .= ' and createdt <= ' . $t;
        }
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
        }
        if (!empty($status)) {
            $con .= ' and statext = "' . $status . '"';
        }
        if (!empty($err)) {
            $e = $err == 1 ? 1 : 0;
            $con .= ' and err = ' . $e;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,nowuname,name,statext,createdt,optdt,is_new,err');
        $pager = $model->spPager()->getPager();
        if (empty($results)) {
            $this->returnError('暂无数据');
        }
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        foreach ($results as $k => $v) {
            $result['results'][$k] = array(
                'id' => $v['id'],
                'nowuname' => $v['nowuname'],
                'name' => $v['name'],
                'statext' => $v['statext'],
                'is_new' => $v['is_new'],
                'dt' => date('Y.m.d', strtotime($v['optdt'])),
                'err' => $v['err'],
            );
            if ((time() - 7 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '一周内';
            } else if ((time() - 10 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '10天内';
            } else if ((time() - 15 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '15天内';
            } else if ((time() - 30 * 86400) <= (strtotime($v['createdt']))) {
                $result['results'][$k]['time'] = '30天内';
            }
        }
        $this->returnSuccess('成功', $result);
    }

    function addCustomer() {
        $arg = array(
            'name' => '姓名',
            'phone' => '电话',
            'sex' => '',
            'age' => '',
            'way' => '',
            'type' => '',
            'acreage' => '',
            'budget' => '',
            'total' => '',
            'intention' => '',
            'explain' => '',
            'copyfor' => '抄送人',
            'id' => '',
        );
        $data = $this->receiveData($arg);
        $this->saveCustomer($data);
    }

    function editCustomer() {
        $arg = array(
            'nowuid' => '',
            'way' => '',
            'type' => '',
            'acreage' => '',
            'budget' => '',
            'total' => '',
            'id' => '客户id',
        );
        $data = $this->receiveData($arg);
        $this->saveCustomer($data);
    }

    function saveCustomer($data) {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $id = (int) $data['id'];
        unset($data['id']);
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['is_new'] = 1;
        if ($id) {
            unset($data['name']);
            unset($data['phone']);
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $user['cid']));
            if (empty($re)) {
                $this->returnError('数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->returnSuccess('成功');
            } else {
                $this->returnError('失败', 404);
            }
        } else {
            $re = $model->find(array('del' => 0, 'phone' => $data['phone'], 'cid' => $user['cid']), '', 'id');
            if ($re) {
                $this->returnError('该手机号已录入', 2);
            }
            $data['nowuid'] = $user['id'];
            $data['nowuname'] = $user['name'];
            $data['createid'] = $user['id'];
            $data['createname'] = $user['name'];
            $data['createdt'] = date('Y-m-d H:i:s');
            $data['cid'] = $user['cid'];
            $data['status'] = '';
            $data['statext'] = '潜在客户';
            $data['copyfor'] = ',' . $data['copyfor'] . ',';
            $ad = $model->create($data);
            if ($ad) {
                $this->returnSuccess('成功');
            } else {
                $this->returnError('失败', 404);
            }
        }
    }

    //客户详情
    function custinfo() {
        $user = $this->islogin();
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_customer');
        $result = $model->find(array('id' => $id, 'del' => 0, 'cid' => $user['cid']));
        if ($result) {
            if ($result['nowuid'] != $user['id']) {
                $result['phone'] = '保密';
            }
            if ((time() - 7 * 86400) <= (strtotime($result['createdt']))) {
                $time = '一周内,';
            } else if ((time() - 10 * 86400) <= (strtotime($result['createdt']))) {
                $time = '10天内,';
            } else if ((time() - 15 * 86400) <= (strtotime($result['createdt']))) {
                $time = '15天内,';
            } else if ((time() - 30 * 86400) <= (strtotime($result['createdt']))) {
                $time = '30天内,';
            }
            $result['label'] = empty($time)?'':$time;
            $result['label'] .= $result['statext'].',';
            $result['label'] .= $result['err']==0?'正常':'异常';
            $report = spClass('m_room_report')->findAll(array('ckientid'=>$id,'ucid'=>$user['cid']),'optdt desc','id,rname,status');
            if($result['is_new']==1&&$user['optid']!=$user['id']){
                $model->update(array('id'=>$id),array('is_new'=>0));
            }
            foreach($report as $k=>$v){
                $report[$k]['stname'] = $GLOBALS['report_st'][$v['status']];
            }
            if(!empty($report)){
                $result['report'] = empty($report)?'':$report;
            }
            $this->returnSuccess('成功', $result);
        } else {
            $this->returnError('数据不存在');
        }
    }

    function publicity() {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $start = urldecode(htmlspecialchars($this->spArgs('start')));
        $end = urldecode(htmlspecialchars($this->spArgs('end')));
        $con = 'nowuid = 0 and err = 0 and cid = ' . $user['cid'];
        if ($name) {
            $con .= ' and name like "%' . $name . '%"';
        }
        if ($start) {
            $con .= ' and createdt >= ' . date('YmdHis', strtotime($start));
        }
        if ($end) {
            $con .= ' and createdt <= ' . date('YmdHis', strtotime($end));
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,name,intention,createdt');
        foreach ($results as $k => $v) {
            $results[$k]['date'] = date('Y.m.d', strtotime($v['createdt']));
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function grab() {
        $user = $this->islogin();
        $model = spClass('m_customer');
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $model->find('(nowuid = 0 or status = 0) and err = 0 and cid = ' . $user['cid'] . ' and id = ' . $id);
        if (empty($re)) {
            $this->returnError('信息不存在或已被其他员工抢到');
        }
        $up = $model->update(array('id' => $id), array('nowuid' => $user['id'],'nowuname'=>$user['name'], 'optid' => $user['id'], 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s')));
        if ($up) {
            spClass('m_cust_log')->create(array('tid' => $id, 'table' => 'customer', 'explain' => '抢单成功', 'dt' => date('Y-m-d H:i:s'), 'optid' => $user['id'], 'optname' => $user['name'], 'stname' => '抢单'));
            $this->returnSuccess('抢单成功', $re);
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function addfollow() {
        $user = $this->islogin();
        $model = spClass('m_cust_log');
        $id = (int) htmlentities($this->spArgs('id'));
        $explain = urldecode(htmlspecialchars($this->spArgs('explain')));
        $re = spClass('m_customer')->find(array('id' => $id, 'del' => 0), '', 'id');
        if (empty($re)) {
            $this->returnError('客户信息不存在');
        }
        if (empty($explain)) {
            $this->returnError('请填写跟进情况');
        }
        $data['tid'] = $id;
        $data['table'] = 'customer';
        $data['explain'] = $explain;
        $data['dt'] = date('Y-m-d H:i:s');
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['stname'] = '跟进';
        $ad = $model->create($data);
        if ($ad) {
            $this->returnSuccess('成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function followlst() {
        $user = $this->islogin();
        $model = spClass('m_cust_log');
        $id = (int) htmlentities($this->spArgs('id'));
        $con = '`table` = "customer" and tid = ' . $id;
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'dt desc');
        foreach ($results as $k => $v) {
            $results[$k]['optdt'] = date('Y-m-d', strtotime($v['optdt']));
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function performance() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $m_custract = spClass('m_custract');
        $type = htmlentities($this->spArgs('type'));
        $con = 'del = 0 and cid = ' . $user['cid'];
        $users = $m_user->findAll(array('cid' => $user['cid']), 'entrydt desc', 'id,name,head');
        if ($type == 1) {
            $con .= ' and signdt >= ' . date('Y0101');
        } else if ($type == 2) {
            $con .= ' and signdt >= ' . date('Ym01');
        } else if ($type == 3) {
            $con .= ' and signdt = ' . date('Ymd');
        }
        $custract = $m_custract->findAll($con, '', 'id,uid,money,moneys');
        foreach ($custract as $k => $v) {
            $money[$v['uid']]['money'] += $v['money']*1;
            $money[$v['uid']]['moneys'] += $v['moneys']*1;
        }
        foreach ($users as $k => $v) {
            $users[$k]['money'] = $money[$v['id']]['money'] * 1;
            $users[$k]['moneys'] = $money[$v['id']]['moneys'] * 1;
        }
        foreach ($users as $key => $val) {
            $tmp[$key] = $val['money'];
        }
        array_multisort($tmp, SORT_DESC, $users);
        foreach ($users as $k => $v) {
            $users[$k]['sort'] = $k + 1;
            $users[$k]['head'] = URL . $users[$k]['head'];
            if ($v['id'] == $user['id']) {
                $result['our'] = $users[$k];
            }
        }
        $result['results'] = $users;
        $this->returnSuccess('成功', $result);
    }

    function ourperformance() {
        $user = $this->islogin();
        $m_custract = spClass('m_custract');
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = ' . $user['cid'] . ' and uid = ' . $user['id'];
        if ($start) {
            $con .= ' and signdt >= ' . date('Ymd', strtotime($start));
        }
        if ($end) {
            $con .= ' and signdt <= ' . date('Ymd', strtotime($end));
        }
        if (!empty($name)) {
            $con .= ' and roomname like "%' . $name . '%"';
        }
        $sum = $m_custract->find($con, '', 'count(id) as sum,sum(money) as money,sum(moneys) as moneys');
        $sum['money'] = empty($sum['money'])?'0':$sum['money']*1;
        $sum['moneys'] = empty($sum['moneys'])?'0':$sum['moneys']*1;
        $result['sum'] = $sum;
        $results = $m_custract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'signdt desc');
        foreach ($results as $k => $v) {
            $results[$k]['date'] = date('Y.m.d', strtotime($v['createdt']));
            $room = spClass('m_room')->find(array('id'=>$v['roomid']),'','id,image,price,address,lng,lat');
            $results[$k]['image'] = URL.$room['image'];
            $results[$k]['price'] = $room['price']*1;
            $results[$k]['lng'] = $room['lng'];
            $results[$k]['lat'] = $room['lat'];
            $results[$k]['address'] = $room['address'];
        }
        if(!empty($results)){
            $result['results'] = $results;
        }
        $pager = $m_custract->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    

}

?>
