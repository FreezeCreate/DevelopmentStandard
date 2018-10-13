<?php

class service extends AppController 
{

    /**
     * 设备新增&修改
     * TODO 文档的编写
     * TODO 费用报销的删除在支出表中有
     * 
     */
    function saveEquipment() 
    {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        
        $args  = array(
            'number'  => '设备编号',
            'custid'  => '客户',
            'name'    => '设备名称',
            'format'  => '规格型号',
            'day'     => '',
            'address' => '',
            'explain' => '',
            'id'      => '',
        );
        $data = $this->receiveData($args);
        $id   = $data['id'];
        unset($data['id']);
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        
        if (empty($id)) {
            $data['cid'] = $admin['cid'];
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            $this->emptyNotice($cust, '请选择客户');
            //客户数据录入
            $data['custname']  = $cust['cust_name'];
            $data['custphone'] = $cust['phone'];
            $ad = $model->create($data);
            if ($ad) $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            $this->emptyNotice($re, '数据有误，修改失败');
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            $this->emptyNotice($cust, '请选择客户');
            //客户数据录入
            $data['custname']  = $cust['cust_name'];
            $data['custphone'] = $cust['phone'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
        }
    }
    
    /**
     * 设备管理(列表)
     */
    function equipLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $con   = 'del=0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(number,custname,name) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 维修单新增&修改 即客户上报
     */
    function saveService() 
    {
        $admin = $this->islogin();
        $args = array(
//             'number'  => '设备编号',
            'type'    => '',
            'explain' => '',
            'id'      => '',
            'workid'  => '',
            'workname'=> '',
            'eid'     => '设备',
            'handletime' => '',
        );
        $data = $this->receiveData($args);
        
        //设备数据新增
        $id   = $data['id'];
        unset($data['id']);
        $m_equipment     = spClass('m_equipment');
        $model           = spClass('m_equipment_service');
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if (empty($data['handletime'])) $data['handletime'] = date('Y-m-d H:i:s');  //处理时间
        
        if (empty($id)) {
            //设备最后一次保养时间的更新
            $m_equipment->update(array('id' => $data['eid'], 'del' => 0, 'cid' => $admin['cid']), array('lasttime' => date('Y-m-d')));
            
            $equipment = $m_equipment->find(array('id' => $data['eid'], 'cid' => $admin['cid']));
            if (empty($equipment)) $this->returnError('设备不存在，请检查设备编号是否正确');
            $ad = $model->create($data);
            if ($ad) $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('id' => $id));
            if (empty($re)) $this->returnError('数据有误，修改失败');
            $data = $this->checkUpdateArr($re, $data);
            
            $up = $model->update(array('id' => $id), $data);
            if ($up) $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
        }
    }
    
    /**
     * 维修单列表
     * 需要做多个搜索：维修、保养
     */
    function serviceLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_equipment_service');
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $type  = urldecode(htmlspecialchars($this->spArgs('type')));
        
        $con   = 'del=0';
        if (!empty($searchname)) {
            $con .= ' and concat(workname,explain,type,handletime) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($type)){
            $con .= ' and type like "%' . $type . '%"';
            $page_con['type'] = $type;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach ($results as $k => $v){
            $equip = spClass('m_equipment')->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'', '', 'name');
            $results[$k]['equip_name'] = $equip['name'];
        }
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单详情
     */
    function serviceInfo()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_equipment_service');
        $m_log  = spClass('m_equipment_service_log');
        $id     = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'del' => 0));
        $this->emptyNotice($result, '数据不存在或已删除');
        
        $equip_name = spClass('m_equipment')->find('id='.$result['eid'].'', '', 'name');
        $result['equip_name'] = $equip_name['name'];
        $log = $m_log->findAll('esid = ' . $id);
        if (!empty($log)) $result['log'] = $log;
        $this->returnSuccess('成功', $result);
    }
    

    /**
     * 我的客户，用于新增设备时选择
     */
    function myCust() 
    {
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
     * 设备详情
     */
    function equipmentInfo() 
    {
        $admin  = $this->islogin();
        $model  = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        $id     = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        $this->emptyNotice($result, '数据不存在或已删除');
        
        $service = $m_equipment_service->findAll('eid = ' . $id);
        if (!empty($service)) $result['service'] = $service;
        $this->returnSuccess('成功', $result);
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
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
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
        $model      = spClass('m_expend');
        $m_user     = spClass('m_admin');
        
        //where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) $con .= ' and concat(paymoney,adddt) like "%' . $searchname . '%"';
        if (!empty($status)){
            if ($status != 3){
                $con .= ' and status<>3';
            }else {
                $con .= ' and status='.$status.'';
            }
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $str_status = '未报销';
            if ($v['status'] == 3) $str_status = '已报销';
            
            $result['results'][$k] = array(
                'id'        => $v['id'],
                'username'  => $v['salename'],
                'paymoney'  => $v['paymoney'],
                'adddt'     => $v['adddt'],
                'catename'  => $v['catename'],
                'content'   => $v['content'],
                'status'    => $str_status,    //文档申明判断报销状态：不为3的都是未报销
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
        $model   = spClass('m_expend');
        $id      = htmlentities($this->spArgs('id'));
        $result  = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
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
        if ($results['status'] == 3){
            $results['status'] = '已报销';
        }else {
            $results['status'] = '未报销';
        }
        
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
        
        $results = $model->findAll($con, 'id asc', 'id,name,pname');
        if (empty($results)) $this->returnError('暂无数据');
        
        $result['results'] = array_values($results);
        $this->returnSuccess('成功', $result);
    }
    
    
    /**
     * 维修单管理
     * 所有列表status=未处理； status=2 已处理；
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
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $equip = $m_equip->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'');
            
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $equip['custname'],
                'name'     => $equip['name'],
                'number'   => $equip['number'],
                'status'   => (int)$v['status'], //app端判断类型来选择红点
                'address'  => $equip['address'],
                'see'      => $equip['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单管理
     */
    function myServiceMangLst()
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
        if (!empty($admin['role'])) $con .= ' and workid='.$admin['id'].''; //根据auth的判断，暂时这样处理 TODO
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $equip = $m_equip->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'');
            
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $equip['custname'],
                'name'     => $equip['name'],
                'number'   => $equip['number'],
                'status'   => (int)$v['status'],
                'address'  => $equip['address'],
                'see'      => $v['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    
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
        $con   = 'del=0 and cid='.$admin['cid'].'';
        if($name) $con .= ' and title like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
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
     * 知识库分类新增
     */
    function saveLiveCate()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon_cate');
        $arg   = array(
            'catename' => '标题',
            'catedesc'  => '',
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
     * 知识库分类列表
     */
    function liveCateLst()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_livecon_cate');
        $m_live = spClass('m_livecon');
        $con    = 'del=0 and cid='.$admin['cid'].'';
        $name   = urldecode(htmlspecialchars($this->spArgs('name')));
        if($name) $con .= ' and catename like "%'.$name.'%"';    //where like
        
        $results = $model->findAll($con, 'optdt desc', 'id,catename,catedesc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $result['results'] = $results;
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
    
    
    
    
    /**
     * 所有删除
     */
    
    /**
     * 设备删除
     */
    function delEquipment()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_equipment', $id);
    }
    
    /**
     * 维修单删除
     */
    function delService()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_equipment_service')->update(array('id' => $id), array('del' => 1));
        if ($res) $this->returnSuccess('成功');;
        $this->returnError('失败');
    }
    
    /**
     * 维修单记录删除
     */
    function delServiceLog()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_equipment_service_log')->update(array('id' => $id), array('del' => 1));
        if ($res) $this->returnSuccess('成功');;
        $this->returnError('失败');
    }
    
    /**
     * 知识库类型删除
     */
    function delLiveCate()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_livecon_cate', $id);
    }
    
    /**
     * 知识库删除
     */
    function delLiveCon()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_livecon', $id);
    }
    
    /**
     * 费用报销删除
     */
    function delPayMon()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_expend')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }

}
