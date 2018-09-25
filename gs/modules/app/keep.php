<?php

class keep extends AppController {

    function saveEquipment() {
        $admin = $this->islogin();
        $args = array(
            'number' => '设备编号',
            'custid' => '客户',
            'name' => '设备名称',
            'format' => '规格型号',
            'day' => '',
            'address' => '',
            'explain' => '',
            'id' => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $model = spClass('m_equipment');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($id)) {
            $data['cid'] = $admin['cid'];
            $cust = spClass('m_customer')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            if (empty($cust)) {
                $this->returnError('请选择客户');
            }
            $data['custname'] = $cust['name'];
            $data['custphone'] = $cust['phone'];
            $ad = $model->create($data);
            if ($ad) {
                $this->returnSuccess('添加成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            if (empty($re)) {
                $this->returnError('数据有误，修改失败');
            }
            $cust = spClass('m_customer')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            if (empty($cust)) {
                $this->returnError('请选择客户');
            }
            $data['custname'] = $cust['name'];
            $data['custphone'] = $cust['phone'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->returnSuccess('修改成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        }
    }

//    
//     function saveService(){
//        $admin = $this->islogin();
//        $args = array(
//            'number' => '设备编号',
//            'type' => '服务类型',
//            'explain' => '',
//            'id' => '',
//        );
//        $data = $this->receiveData($args);
//        $id = $data['id'];
//        unset($data['id']);
//        $m_equipment = spClass('m_equipment');
//        $model = spClass('m_equipment_service');
//        $data['optid'] = $admin['id'];
//        $data['optname'] = $admin['name'];
//        $data['optdt'] = date('Y-m-d H:i:s');
//        if(empty($id)){
//            $equipment = $m_equipment->find(array('number'=>$data['number'],'cid'=>$admin['cid']));
//            if(empty($equipment)){
//                $this->returnError('设备不存在，请检查设备编号是否正确');
//            }
//            $ad = $model->create($data);
//            if($ad){
//                $this->returnSuccess('添加成功');
//            }else{
//                $this->returnError('网络错误，请稍后重试');
//            }
//        }else{
//            $re = $model->find(array('cid'=>$admin['cid'],'id'=>$id));
//            if(empty($re)){
//                $this->returnError('数据有误，修改失败');
//            }
//            $equipment = $m_equipment->find(array('number'=>$data['number'],'cid'=>$admin['cid']));
//            if(empty($equipment)){
//                $this->returnError('设备不存在，请检查设备编号是否正确');
//            }
//            $up = $model->update(array('id'=>$id),$data);
//            if($up){
//                $this->returnSuccess('修改成功');
//            }else{
//                $this->returnError('网络错误，请稍后重试');
//            }
//        }
//    }

    function saveService() {
        $admin = $this->islogin();
        $args = array(
            'number' => '设备编号',
            'type' => '',
            'explain' => '',
            'id' => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $m_equipment = spClass('m_equipment');
        $model = spClass('m_equipment_service');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($id)) {
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) {
                $this->returnError('设备不存在，请检查设备编号是否正确');
            }
            $ad = $model->create($data);
            if ($ad) {
                $this->returnSuccess('添加成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            if (empty($re)) {
                $this->returnError('数据有误，修改失败');
            }
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) {
                $this->returnError('设备不存在，请检查设备编号是否正确');
            }
            $data['eid'] = $equipment['id'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->returnSuccess('修改成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        }
    }

    function findEquipment() {
        $admin = $this->islogin();
        $number = htmlentities($this->spArgs('number'));
        $m_equipment = spClass('m_equipment');
        $equipment = $m_equipment->find(array('number' => $number, 'cid' => $admin['cid']), '', 'id,number,custname,custphone,name,format,day,address');
        if (empty($equipment)) {
            $this->returnError('设备信息不存在');
        }
        $this->returnSuccess('成功', $equipment);
    }

    function myCust() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = ' . $admin['cid'] . ' and saleid = ' . $admin['id'];
        if($name){
            $con .= ' and cust_name like "%'.$name.'%"';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, '', 'id,cust_name,phone');
        if (empty($results)) {
            $this->returnError('暂无数据');
        }
        foreach ($results as $k => $v) {
            $results[$k]['name'] = $v['cust_name'];
        }
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * update/add cust mang
     * 更新/添加用户管理
     */
    function saveCust() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $arg = array(
            'id' => '',
            'sex' => '性别',
            'age' => '年龄',
            'cust_name' => '客户姓名',
            'custcname' => '客户公司',
            'phone' => '客户手机', //客户手机，不能为空
            'address' => '',
            'info' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re))
                $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['status'] = 1;
            $data['applyid'] = $admin['id'];
            $data['applyname'] = $admin['username'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $admin['cid'];
            $data['flowid'] = 1;
            $up = $model->create($data);
        }
        if ($up)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    function custInfo() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) {
            $this->returnError('暂无数据');
        }
        $this->returnSuccess('成功', $result);
    }

    function custEquipment() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $id = htmlentities($this->spArgs('id'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and custid = ' . $id . ' and cid = ' . $admin['cid'];
        if($name){
            $con .= ' and number like "%'.$name.'%"';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,name,number,address');
        if (empty($results)) {
            $this->returnError('暂无数据');
        }
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    function equipmentInfo() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) {
            $this->returnError('数据不存在或已删除');
        }
        $service = $m_equipment_service->findAll('eid = ' . $id);
        if (!empty($service)) {
            $result['service'] = $service;
        }
        $this->returnSuccess('成功', $result);
    }

    function service() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        
    }

}
