<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class project extends AppController {

    function addRoom() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $arg = array(
            'id' => '',
            'type' => '物业类型',
            'typech' => '',
            'title' => '标题',
            'name' => '项目名称',
            'address' => '地址',
            'lng' => '',
            'lat' => '',
            'content' => '项目描述',
            'money' => '售价（万元）',
            'acreage' => '面积（平米）',
            'price' => '单价（元/平米）',
            'floor' => '',
            'sumfloor' => '',
            'face' => '',
            'decoration' => '',
            'images' => '图片',
            'video' => '',
            'room' => '',
            'hall' => '',
            'bath' => '',
            'building' => '',
            'unit' => '',
            'number' => '',
            'year' => '',
            'label' => '',
            'takelook' => '',
            'brokerage' => '',
            'bbday' => '',
            'dkday' => '',
            'developer' => '',
            'property' => '',
            'sales' => '',
            'opening' => '',
            'hand' => '',
            'buildtype' => '',
            'volume' => '',
            'green' => '',
            'hushu' => '',
            'space' => '',
            'propertycost' => '',
            'propertycom' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $images = explode(',', trim($data['images'], ','));
        foreach ($images as $k => $v) {
            $images[$k] = Common::copy_upload($v, 'room/' . date('Ymd'));
        }
        $data['image'] = $images[0];
        $data['images'] = implode(',', $images);
        $data['is_auth'] = 0;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $user['cid']), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $this->returnSuccess('修改成功');
            } else {
                $this->returnError('修改失败');
            }
        } else {
            $data['is_shelves'] = 1;
            $data['cid'] = $user['cid'];
            $data['uname'] = $user['name'];
            $data['uphone'] = $user['phone'];
            $ad = $model->create($data);
            if ($ad) {
                $this->returnSuccess('添加成功');
            } else {
                $this->returnError('添加失败');
            }
        }
    }

    function mylst() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $con = 'del = 0 and cid = ' . $user['cid'];
        $level = (int) htmlspecialchars($this->spArgs('level'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($level)) {
            $con .= ' and level = ' . $level;
        }
        if (!empty($name)) {
            $con .= ' and (title like "%' . $name . '%" or name like "%' . $name . '%" or name like "%' . $name . '%" or label like "%' . $name . '%")';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,title,type,acreage,image,address,price,money,brokerage,brokeragehide,takelook,takelookhide');
        foreach ($results as $k => $v) {
            $results[$k]['image'] = URL . $v['image'];
            $results[$k]['reportsum'] = spClass('m_room_report')->findCount('del = 0 and rid = ' . $v['id']);
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function lst() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $con = 'del = 0 and is_auth = 1 and is_shelves = 1';
        $area = urldecode(htmlspecialchars($this->spArgs('area')));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $round = urldecode(htmlspecialchars($this->spArgs('round'))) * 1000;
        $price = urldecode(htmlspecialchars($this->spArgs('price')));
        $money = urldecode(htmlspecialchars($this->spArgs('money')));
        $acreage = urldecode(htmlspecialchars($this->spArgs('acreage')));
        $type = urldecode(htmlspecialchars($this->spArgs('type')));
        $room = urldecode(htmlspecialchars($this->spArgs('room')));
        if (!empty($name)) {
            $con .= ' and (title like "%' . $name . '%" or name like "%' . $name . '%" or name like "%' . $name . '%" or label like "%' . $name . '%")';
        }
        if (!empty($area)) {
            $con .= ' and address like "%' . $area . '%"';
        }
        if (!empty($room)) {
            if ($room >= 5) {
                $con .= ' and room >= 5';
            } else {
                $con .= ' and room = ' . $room;
            }
        }
        if (!empty($type)) {
            $type = trim($type, ',');
            $type = explode(',', $type);
            $ty = '';
            foreach ($type as $v) {
                $ty .= '"' . $v . '",';
            }
            $ty = trim($ty, ',');
            $con .= ' and (type in (' . $ty . ') or typech in (' . $ty . '))';
        }
        if (!empty($round)) {
            $lng = htmlentities($this->spArgs('lng'));
            $lat = htmlentities($this->spArgs('lat'));
            if (empty($lng) || empty($lat)) {
                $this->returnError('当前位置经纬度不详');
            }
            $con .= ' and lat > ' . $lat . '-1 and lat < ' . $lat . '+1 and lng > ' . $lng . '-1 and lng < ' . $lng . '+1 and ((ACOS(SIN((' . $lat . ' * 3.1415) / 180 ) *SIN((lat * 3.1415) / 180 ) +COS((' . $lat . ' * 3.1415) / 180 ) * COS((lat * 3.1415) / 180 ) *COS((' . $lng . '* 3.1415) / 180 - (lng * 3.1415) / 180 ) ) * 6380)*1000) <= ' . $round;
        }
        if (!empty($price)) {
            $price = explode('-', $price);
            $price[0] = $price[0] * 1;
            $price[1] = $price[1] * 1;
            if (!empty($price[0])) {
                $con .= ' and price >= ' . $price[0];
            }
            if (!empty($price[1])) {
                $con .= ' and price <= ' . $price[1];
            }
        }
        if (!empty($money)) {
            $money = explode('-', $money);
            $money[0] = $money[0] * 1;
            $money[1] = $money[1] * 1;
            if (!empty($money[0])) {
                $con .= ' and money >= ' . $money[0];
            }
            if (!empty($money[1])) {
                $con .= ' and money <= ' . $money[1];
            }
        }
        if (!empty($acreage)) {
            $acreage = explode('-', $acreage);
            $acreage[0] = $acreage[0] * 1;
            $acreage[1] = $acreage[1] * 1;
            if (!empty($acreage[0])) {
                $con .= ' and acreage >= ' . $acreage[0];
            }
            if (!empty($acreage[1])) {
                $con .= ' and acreage <= ' . $acreage[1];
            }
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,title,type,acreage,image,address,price,money,brokerage,brokeragehide,takelook,takelookhide');
        foreach ($results as $k => $v) {
            $results[$k]['image'] = URL . $v['image'];
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function recommend() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $con = 'del = 0 and is_auth = 1 and is_shelves = 1 and is_recommend = 1';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'views desc', 'id,title,type,acreage,image,address,price,money,brokerage,brokeragehide,takelook,takelookhide');
        foreach ($results as $k => $v) {
            $results[$k]['image'] = URL . $v['image'];
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function editroom() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'del' => 0));
        if (empty($result)) {
            $this->returnError('该项目不存在');
        }
        $result['images'] = explode(',', $result['images']);
        foreach ($result['images'] as $k => $v) {
            $result['images'][$k] = $v;
        }
        $result['video'] = empty($result['video']) ? '' : $result['video'];
        $this->returnSuccess('成功', $result);
    }

    function roominfo() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $id = htmlentities($this->spArgs('id'));
        $type = htmlentities($this->spArgs('type'));
        if ($type == 1) {
            $result = $model->find(array('id' => $id, 'del' => 0));
        } else {
            $result = $model->find(array('id' => $id, 'del' => 0, 'is_auth' => 1, 'is_shelves' => 1));
        }
        if (empty($result)) {
            $this->returnError('该项目不存在');
        }
        $result['images'] = explode(',', $result['images']);
        foreach ($result['images'] as $k => $v) {
            $result['images'][$k] = URL . $v;
        }
        $result['video'] = empty($result['video']) ? '' : URL . $result['video'];
        $this->returnSuccess('成功', $result);
    }

    function addreport() {
        $user = $this->islogin();
        $proid = htmlentities($this->spArgs('proid'));
        $custid = htmlentities($this->spArgs('custid'));
        $model = spClass('m_room_report');
        $m_room = spClass('m_room');
        $m_customer = spClass('m_customer');
        $room = $m_room->find(array('id' => $proid, 'is_auth' => 1, 'is_shelves' => 1));
        if (empty($room)) {
            $this->returnError('项目信息有误');
        }
        $customer = $m_customer->find(array('id' => $custid, 'nowuid' => $user['id'], 'err' => 0, 'del' => 0));
        if (empty($customer)) {
            $this->returnError('客户信息有误');
        }
        $data['rid'] = $room['id'];
        $data['rname'] = $room['title'];
        $data['address'] = $room['address'];
        $data['uid'] = $user['id'];
        $data['uname'] = $user['name'];
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['ucid'] = $user['cid'];
        $data['ucompany'] = $user['cname'];
        $data['adddt'] = time();
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['expired'] = time() + 86400 * $room['bbday'];
        $data['ckientid'] = $customer['id'];
        $data['ckientname'] = $customer['name'];
        $data['ckientsex'] = $customer['sex'];
        $data['status'] = 1;
        $data['is_new'] = 1;
        $data['del'] = 0;
        $ad = $model->create($data);
        if ($ad) {
            $this->returnSuccess('报备成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function report() {
        $user = $this->islogin();
        $rid = (int) htmlentities($this->spArgs('rid'));
        $status = htmlentities($this->spArgs('status'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $model = spClass('m_room_report');
        $con = 'del = 0';
        if ($rid) {
            $con .= ' and rid = ' . $rid;
        } else {
            $con .= ' and uid = ' . $user['id'];
        }
        if ($name) {
            $con .= ' and (rname like "%' . $name . '%" or ckientname like "%' . $name . '%" or uname like "%' . $name . '%" or ucompany like "%' . $name . '%")';
        }
        if ($status || $status === 0) {
            $con .= ' and status = ' . $status;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'is_new desc,optdt desc');
        foreach ($results as $k => $v) {
            $results[$k]['st'] = $GLOBALS['report_st'][$v['status']];
            $results[$k]['adddt'] = date('Y-m-d', $v['adddt']);
            $results[$k]['is_new'] = $v['is_new'] == 1 && $user['id'] !== $v['optid'] ? 1 : 0;
        };
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function reportinfo() {
        $user = $this->islogin();
        $model = spClass('m_room_report');
        $m_log = spClass('m_room_report_log');
        $id = htmlentities($this->spArgs('proid'));
        $result = $model->find(array('id' => $id, 'del' => 0));
        if (empty($result)) {
            $this->returnError('信息不存在或已删除');
        }
        if ($user['id'] !== $result['optid'] && $result['is_new'] == 1) {
            $model->update(array('id' => $id), array('is_new' => 0));
        }
        $room = spClass('m_room')->find(array('id' => $result['rid']));
        if ($room) {
            $result['image'] = empty($room['image']) ? '' : URL . $room['image'];
            $result['price'] = $room['price'] * 1;
            $result['address'] = $room['address'];
            $result['lng'] = $room['lng'];
            $result['lat'] = $room['lat'];
        }
        $result['ckientphone'] = $user['id'] === $result['uid'] ? $result['ckientphone'] : '保密';
        $result['adddt'] = date('Y-m-d', $result['adddt']);
        $result['expired'] = empty($result['expired']) ? '' : date('Y-m-d H:i:s', $result['expired']);
        $result['st'] = $GLOBALS['report_st'][$result['status']];
        $log = $m_log->findAll('rid = ' . $id);
        if (!empty($log)) {
            $result['log'] = $log;
        }
        $this->returnSuccess('成功', $result);
    }

    function addfollow() {
        $user = $this->islogin();
        $id = htmlentities($this->spArgs('id'));
        $explain = htmlspecialchars($this->spArgs('explain'));
        $model = spClass('m_room_report');
        $m_log = spClass('m_room_report_log');
        $re = $model->find(array('id' => $id, 'del' => 0));
        if (empty($re)) {
            $this->returnError('数据有误');
        }
        $ad = $m_log->create(array('rid' => $id, 'optid' => $user['id'], 'optname' => $user['name'], 'status' => 9, 'optdt' => date('Y-m-d H:i:s'), 'opt' => '跟进', 'explain' => $explain));
        if($ad){
            $this->returnSuccess('成功');
        }else{
            $this->returnError('网络错误', 404);
        }
    }

    function checkreport() {
        $user = $this->islogin();
        $id = htmlentities($this->spArgs('id'));
        $explain = htmlspecialchars($this->spArgs('explain'));
        $status = htmlentities($this->spArgs('status'));
        $model = spClass('m_room_report');
        $m_log = spClass('m_room_report_log');
        $re = $model->find(array('id' => $id, 'del' => 0));
        if (empty($re)) {
            $this->returnError('数据有误');
        }
        if (!isset($status)) {
            $this->returnError('请选择处理状态');
        }
        $room = spClass('m_room')->find(array('id' => $re['rid']));
        if ($re['status'] >= 3 && $status == 3) {
            $ad = $m_log->create(array('rid' => $id, 'optid' => $user['id'], 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s'), 'opt' => '继续带看', 'explain' => $explain));
            if ($ad) {
                $this->returnSuccess('成功');
            } else {
                $this->returnError('网络错误', 404);
            }
        } else {
            if ($status == 2) {
                $expired = time() + 86400 * $room['dkday'];
            } else {
                $expired = '';
            }
            $up = $model->update(array('id' => $id), array('status' => $status, 'expired' => $expired, 'is_new' => 1, 'optid' => $user['id'], 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s')));
            if ($up) {
                spClass('m_customer')->update(array('id' => $re['ckientid']), array('status' => $status, 'statext' => $GLOBALS['report_st'][$status]));
                $m_log->create(array('rid' => $id, 'optid' => $user['id'], 'optname' => $user['name'], 'status' => $status, 'optdt' => date('Y-m-d H:i:s'), 'opt' => $GLOBALS['report_st'][$status], 'explain' => $explain));
                $this->returnSuccess('成功');
            } else {
                $this->returnError('网络错误', 404);
            }
        }
    }

    function adddk() {
        $user = $this->islogin();
        $id = htmlentities($this->spArgs('id'));
        $uid = htmlentities($this->spArgs('uid'));
        $model = spClass('m_room_report');
        $us = spClass('m_user')->find(array('id' => $uid, 'cid' => $user['cid']));
        if (empty($us)) {
            $this->returnError('请选择人员');
        }
        $re = $model->find(array('id' => $id), '', 'id,ckientid');
        if (empty($re)) {
            $this->returnError('报备信息有误');
        }
        $data['puid'] = $us['id'];
        $data['puname'] = $us['name'];
        $data['status'] = 3;
        $data['expired'] = 0;
        $data['explain'] = '';
        $data['is_new'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $up = $model->update(array('id' => $id), $data);
        if ($up) {
            spClass('m_customer')->update(array('id' => $re['ckientid']), array('status' => 3, 'statext' => '带看成功'));
            spClass('m_room_report_log')->create(array('rid' => $id, 'optid' => $user['id'], 'status' => 3, 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s'), 'opt' => $GLOBALS['report_st'][3], 'explain' => $data['explain']));
            $this->returnSuccess('成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function savecustract() {
        $user = $this->islogin();
        $arg = array(
            'id' => '',
            'rid' => '报备信息',
            'money' => '合同金额',
            'moneys' => '佣金',
            'explain' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $rid = htmlentities($this->spArgs('rid'));
        $model = spClass('m_custract');
        $report = spClass('m_room_report')->find(array('id' => $rid));
        $data['uid'] = $report['uid'];
        $data['uname'] = $report['uname'];
        $data['number'] = date('YmdHis') . rand(100, 999);
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['optname'] = $user['uname'];
        $data['applydt'] = date('Y-m-d');
        $data['startdt'] = date('Y-m-d');
        $data['enddt'] = date('Y-m-d');
        $data['custid'] = $report['ckientid'];
        $data['custname'] = $report['ckientname'];
        $data['roomid'] = $report['rid'];
        $data['roomname'] = $report['rname'];
        $data['saleid'] = $data['rid'];
        $data['signdt'] = date('Y-m-d');
        $data['createid'] = $user['id'];
        $data['createname'] = $user['name'];
        $data['cid'] = $report['ucid'];
        $data['pcid'] = $user['cid'];
        $re = $model->find(array('saleid' => $data['saleid']));
        if (!empty($re)) {
            $this->returnError('该合同已添加，请勿重复添加');
        }
        $ad = $model->create($data);
        if ($ad) {
            $up = spClass('m_room_report')->update(array('id' => $report['id']), array('status' => 6, 'is_new' => 1, 'optid' => $user['id'], 'optname' => $user['name'], 'optid' => date('Y-m-d H:i:s')));
            if ($up) {
                spClass('m_customer')->update(array('id' => $report['ckientid']), array('status' => 6, 'statext' => '签约客户'));
                spClass('m_room_report_log')->create(array('rid' => $report['rid'], 'optid' => $user['id'], 'status' => 6, 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s'), 'opt' => $GLOBALS['report_st'][6], 'explain' => $data['explain']));
                $this->returnSuccess('成功');
            } else {
                $this->returnError('网络错误', 404);
            }
        } else {
            $this->returnError('网络错误', 404);
        }
    }

}

?>
