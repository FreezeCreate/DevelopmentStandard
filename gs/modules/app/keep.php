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
            'number'  => '设备编号',
            'type'    => '',
            'explain' => '',
            'id'      => '',
            'workid'  => '',
            'workname'=> '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $m_equipment     = spClass('m_equipment');
        $model           = spClass('m_equipment_service');
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if (empty($id)) {
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) $this->returnError('设备不存在，请检查设备编号是否正确');
            $ad = $model->create($data);
            if ($ad) $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            if (empty($re)) $this->returnError('数据有误，修改失败');
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) $this->returnError('设备不存在，请检查设备编号是否正确');
            
            $data['eid'] = $equipment['id'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
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
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc', 'id,cust_name,phone');
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
            $data['saleid'] = $admin['id'];
            $data['applyname'] = $admin['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $admin['cid'];
            $data['flowid'] = 1;
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    function custInfo() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) $this->returnError('暂无数据');
        $this->returnSuccess('成功', $result);
    }

    /**
     * 该用户的设备
     */
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
    
    /**
     * -----------------------------维修管理模块---------------------------------------
     */
    
    
    /**
     * 我的定位考勤列表
     */
    function localLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_kqdkjl');
        $id    = $admin['id'];
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'uid = ' . $id . ' and cid = ' . $admin['cid'];
        if($name) $con .= ' and address like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,optdt,address,`explain`');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 费用报销管理
     */
    function payMonLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status     = urldecode(htmlspecialchars($this->spArgs('status')));
        $model      = spClass('m_custpay_mon');
        $m_user     = spClass('m_admin');
        
        //where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and monstatus=3';
        if (!empty($searchname)) $con .= ' and concat(paymoney,adddt) like "%' . $searchname . '%"';
        if (!empty($status)) $con .= ' and status='.$status.'';
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $str_status = '未报销';
            if ($v['status'] == 3) $str_status = '已报销';
            
            $result['results'][$k] = array(
                'id'        => $v['id'],
                'username'  => $v['salename'],
                'paymoney'  => $v['paymoney'],
                'adddt'     => $v['adddt'],
                'status'    => $v['status'],    //文档申明判断报销状态：不为3的都是未报销
                'paystatus' => $str_status,
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 费用报销详情
     */
    function payMonInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_custpay_mon');
        $id      = htmlentities($this->spArgs('id'));
        $result  = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0, 'monstatus' => 3));
        if (empty($result)) $this->returnError('数据不存在或已删除');
        
        $paycate             = spClass('m_paycate')->find('id='.$result['cateid'].' and del=0 and cid='.$admin['cid'].'');
        $results             = array();
        $results['id']       = $result['id'];
        $results['username'] = $result['salename'];
        $results['adddt']    = $result['adddt'];
        $results['catename'] = $paycate['catename'];
        $results['paymoney'] = $result['paymoney'];
        $results['status']   = $result['status'];
        $results['content']  = $result['content'];
        
        $this->returnSuccess('成功', $results);
    }
    
    /**
     * 分配人员 列表
     * 职位名称
     */
    function allotUser()
    {
        $admin = $this->islogin();
        $model = spClass('m_admin');
        $id    = $admin['id'];
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del=0 and cid = ' . $admin['cid'];
        if($name) $con .= ' and name like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'id asc', 'id,name,pname');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        $result['results'] = array_values($results);
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 所有设备管理 列表(无状态，app图需要修改)
     */
    function equipmentMang()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $model      = spClass('m_equipment');
        
        //where
        $con    = 'del = 0 and cid = ' . $admin['cid'].'';
        if (!empty($searchname)) $con .= ' and concat(custname,name,number,address) like "%' . $searchname . '%"';
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            
            $result['results'][$k] = array(
                'custname' => $v['custname'],
                'name'     => $v['name'],
                'number'   => $v['number'],
                'address'  => $v['address'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 设备详情
     */
    function equipmentAllInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_equipment');
        $id      = htmlentities($this->spArgs('id'));
        $results = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($results)) $this->returnError('数据不存在或已删除');
        
        $log = array();
        $service = spClass('m_equipment_service')->findAll('eid='.$id.' and del=0');
        foreach ($service as $k => $v){
            $log = spClass('m_equipment_service_log')->findAll('esid='.$v['id'].' and del=0');
        }
        
        $result['results'] = $results;  //设备单
        $result['service'] = $service;  //维修单
        $result['log']     = $log;      //维修记录
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单选择：我的维修单
     */
    function myServiceMangLst()
    {
        $admin  = $this->islogin();
        $workid = $admin['id'];
        $this->commonServiceLst($workid);
    }
    
    /**
     * 维修单管理
     * 所有列表status=0 未处理；status=1 待处理； status=2 已处理；
     * 即未处理为status=0，待处理为红点
     */
    function serviceMangLst()
    {
        $admin  = $this->islogin();
        $this->commonServiceLst();
    }
    
    function commonServiceLst($workid = '')
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status     = urldecode(htmlspecialchars($this->spArgs('status')));
        $model      = spClass('m_equipment_service');
        $m_equip    = spClass('m_equipment');
        
        //where
        $con    = 'del=0';
        if (!empty($searchname)) $con .= ' and concat(workname,`explain`) like "%' . $searchname . '%"';
        if (!empty($status)) $con .= ' and status='.$status.'';
        //我的列表check
        if (!empty($workid)) $con .= ' and workid='.$workid.'';
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $equip = $m_equip->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'');
            
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $equip['custname'],
                'name'     => $equip['name'],
                'number'   => $equip['number'],
                'status'   => (int)$v['status'], //app端判断类型来选择红点
                'address'  => $equip['address'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单详情+维修记录
     */
    function serviceInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_equipment_service');
        $m_log   = spClass('m_equipment_service_log');
        $id      = htmlentities($this->spArgs('id'));
        if (!is_numeric($id) || empty($id)) $this->returnError('数据非法');
        $results = $model->find(array('id' => $id, 'del' => 0));
        if (empty($results)) $this->returnError('数据不存在或已删除');
        
        $log = $m_log->findAll('esid='.$id.' and del=0');
        //处理业务
        $st = htmlentities($this->spArgs('st'));
        if (!empty($st)) $re = $model->find('id');
        
        $result['results'] = $results;  //维修单
        $result['log']     = $log;      //维修记录
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单详情-处理
     * status=0 未处理；status=1 待处理； status=2 已处理；
     */
    function serviceInfoHandle()
    {
        $admin   = $this->islogin();
        $id      = htmlentities($this->spArgs('id'));
        if (empty($id)) $this->returnError('数据非法');
        
        $model   = spClass('m_equipment_service');
        $results = $model->find(array('id' => $id, 'del' => 0));
        if (empty($results)) $this->returnError('数据不存在');
        
        $up      = $model->update(array('id' => $id, 'del' => 0), array('status' => 2));
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    /**
     * /**维修单处理 not/
     * 进程上报
     */
    function saveServiceDetail()
    {
        $admin = $this->islogin();
        $args = array(
            'esid'    => '维修单',
            'explain' => '',
            'st'      => '',
            'id'      => '',
            'optdt'   => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $m_service       = spClass('m_equipment_service');
        $model           = spClass('m_equipment_service_log');
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        if (empty($data['optdt'])) $data['optdt'] = date('Y-m-d H:i:s');
        
        $files = $this->spArgs('files');
        if($files) $data['files'] = implode(',', $files);
        
        if (empty($id)) {
            $data['st'] = 1;    //未处理
            $this->checkService($data['esid']);  //检查是否存在于checkService
            $ad = $model->create($data);
            if ($ad) $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('id' => $id));
            if (empty($re)) $this->returnError('数据有误，修改失败');
            $this->checkService($data['esid']);  //检查是否存在于checkService
            
            $up = $model->update(array('id' => $id), $data);
            if ($up) $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
        }
    }
    
    /**
     * 维修日志管理 已处理：st=已处理 未处理：st=未处理
     */
//     function serviceDetailMang()
//     {
//         $admin      = $this->islogin();
//         $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
//         $status     = urldecode(htmlspecialchars($this->spArgs('status')));
//         $m_log      = spClass('m_equipment_service_log');
//         $m_service  = spClass('m_equipment_service');
//         $m_equip    = spClass('m_equipment');
        
//         //where
//         $con    = 'del = 0';
//         if (!empty($searchname)) $con .= ' and explain like "%' . $searchname . '%"';
//         if (!empty($status)) $con .= ' and st='.$status.'';
        
//         $results = $m_log->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
//         if (empty($results)) $this->returnError('暂无数据');
        
//         $pager = $m_log->spPager()->getPager();
//         $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
//         $result['page'] = $page;
        
//         foreach($results as $k=>$v){
//             $service = $m_service->find('id='.$v['esid'].' and del=0', '', 'eid');
//             $equip   = $m_equip->find('id='.$service['eid'].' and del=0 and cid='.$admin['cid'].'');
            
//             $result['results'][$k] = array(
//                 'id'       => $v['id'],   //设备维修报告id,从列表进入详情
//                 'custname' => $equip['custname'],
//                 'name'     => $equip['name'],
//                 'number'   => $equip['number'],
//                 'address'  => $equip['address'],
//             );
//         }
//         $this->returnSuccess('成功', $result);
//     }
    
//     /**
//      * 维修单进程详情+处理：处理后st=处理,未处理st=未处理 TODO
//      */
//     function serviceDetailInfo()
//     {
//         $admin   = $this->islogin();
//         $model   = spClass('m_equipment_service_log');
//         $id      = htmlentities($this->spArgs('id'));
//         $results = $model->find(array('id' => $id, 'del' => 0));
//         if (empty($results)) $this->returnError('数据不存在或已删除');
        
//         $equip = array();
//         $service = $model->findAll('eid='.$id.' and del=0');
//         foreach ($service as $k => $v){
//             $log = spClass('m_equipment_service_log')->findAll('esid='.$v['id'].' and del=0');
//         }
        

        
//         $result['results'] = $results;  //设备单
//         $result['service'] = $service;  //维修单
//         $result['log']     = $log;      //维修记录
        
//         $this->returnSuccess('成功', $result);
//     }
    
    
    /**
     * 进程上报：添加/修改详细信息或者上传图片上报信信息，可写在维修单处理方法中
     */
    
    /**
     *  现场知识库新增
     */
    function saveLiveCon()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $arg   = array(
            'live_title' => '标题',
            'live_desc'  => '',
            'live_adddt' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re)) $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['cid']     = $admin['cid'];
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 现场知识库列表
     */
    function liveConLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        if($name) $con .= ' and title like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 现场知识库详情
     */
    function liveConInfo()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_livecon');
        $id     = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) $this->returnError('暂无数据');
        $this->returnSuccess('成功', $result);
    }
    
    
    
    /**
     * 用款类型列表
     */
    function paycate()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_paycate');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 设备维修单数据校验
     * @param string $esid
     */
    function checkService($esid)
    {
        $service = spClass('m_equipment_service')->find(array('id' => $esid));
        if (empty($service)) $this->returnError('设备维修单不存在');
    }

}
