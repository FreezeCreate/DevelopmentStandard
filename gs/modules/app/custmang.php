<?php

class custmang extends AppController
{
    /**
     * 仓库管理模块：
     * 采购单 invoice 退货 regoods
     * 盘点 inven 报亏损报溢出
     * 库房 stock_room=>库房产品表 order_goods
     * 设备表 device => 设备分类表 device_cate =>设备检修等信息表 device_desc devicedesc_check(验收报告表)
     * ruku + chuku表
     * 
     * 
     * 财务管理模块：
     *  收付款管理：
     * 
     * 
     * 我的客户，潜在客户 TO DO 按照公司网站的来做 已完成
     * 
     * 企业办公管理
     * //奖罚表 ：yld_manageuser 财务管理->奖罚管理
     * //员工关系和重要日子 ：yld_relation
     * 沟通和分析员工记录表：yld_talkrecord
     * 薪酬设定表：yld_salarystand
     * 标※：公司培训计划的增删改查和审核：(yld_trainplan未建表) 培训材料和总结也在该表中 需要培训流程（审核多流程）
     * 行政管理表(公司活动)：(yld_activity建表) + 活动类型(Sealapl表，印章表)+印章类型
     * 考勤管理：(yld_attendance未建表) TODO not (参照lejubang考勤管理)
     * 会议管理：yld_meeting TODO not
     * 预警设置：(yld_warnoa未建表)
     * 通知类型
     * OA参数设置
     * 通知公告 TODO not info
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 工作台 TODO(Tips:所有功能完成后，按需渲染工作台数据)
     * 
     * TO DO 已完成
     * 合同详情里需要显示回款列表信息
     * TO DO 已完成
     * 固资设备报告需要审核
     * TO DO 已完成 
     * 供应商审核
     * 
     * 
     */
    
    /**
     * 我的-潜在客户
     */
    function latentUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=1';
        $this->addmang($con);
    }
    /**
     * 我的-跟进客户
     */
    function flowUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=2';
        $this->addmang($con);
    }
    /**
     * 我的-签约客户
     */
    function signUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=3';
        $this->addmang($con);
    }
    
    /**
     * custmang list page
     * 列表公共方法
     * @param unknown $con
     */
    function addmang($con)
    {
        if (empty($con)) $this->returnError('非法输入');
//         $admin              = $this->get_ajax_menu();   //admin data
//         $admin['cust_mang'] = spClass('m_custmang')->findAll();  //TODO 先不删除该数据
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_admin    = spClass('m_admin');
        $m_cust     = spClass('m_custmang');
        $m_record   = spClass('m_cust_record');
        
        if (!empty($searchname)) {
            $con .= ' and concat(cust_name,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        //pagenum
        //         $results        = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
//         $this->results  = $results;
//         $this->pager    = $m_cust->spPager()->getPager();
//         $this->page_con = $page_con;
        $sale    = spClass('m_admin')->findAll('', 'id desc', 'id,username');
        $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'noticetime desc,birth desc');
        $pager   = $m_cust->spPager()->getPager();
//         $page    = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['pager'] = $pager;
        
        foreach ($results as $_k => $_v){
            $record = $m_record->findSql('select addtime,status,`explain` from '.DB_NAME.'_cust_record where fid='.$_v['id'].' order by id desc limit 1');
            if ($record){
                $results[$_k]['record_addtime'] = $record[0]['addtime'];
                $results[$_k]['record_status']  = $record[0]['status'];
                $results[$_k]['record_explain'] = $record[0]['explain'];
            }else {
                $results[$_k]['record_addtime'] = '';
                $results[$_k]['record_status']  = '';
                $results[$_k]['record_explain'] = '';
            }
        }
        
        foreach($results as $k=>$v){
            $notic = '';
            $salename = $m_admin->find('id='.$v['saleid'], '', 'id,username');
            if (strtotime($v['noticetime']) - time() < 86400 && strtotime($v['noticetime']) - time() > 0){  //提前一天
                $notic = $v['noticecontent'];
            }
            if (strtotime($v['birth']) - time() < 86400 && strtotime($v['birth']) - time() > 0){  //提前一天
                $notic = $v['noticecontent'];
            }
            
            if (strtotime($v['noticetime']) - time() > -86400 && strtotime($v['noticetime']) - time() < 0){  //延后一天
                $notic = $v['noticecontent'];
            }
            if (strtotime($v['birth']) - time() > -86400 && strtotime($v['birth']) - time() < 0){  //延后一天
                $notic = $v['noticecontent'];
            }
            
            $result['results'][$k] = array(
                'id'         => $v['id'],
                'type'       => $v['type'],
                'cust_name'  => $v['cust_name'],
                'custdname'  => $v['custdname'],
                'phone'      => $v['phone'],
                'sex'        => $v['sex'],
                'age'        => $v['age'],
                'address'    => $v['address'],
                'noticetime' => $v['noticetime'],
                'noticecontent' => $notic,
                'flowid'     => $v['flowid'],
                'salename'   => $salename['username'],
                'record_status'  => $v['record_status'],  //跟进状态
                'record_addtime' => $v['record_addtime'], //跟进时间
                'record_explain' => $v['record_explain'], //跟进内容
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    //del custmang
    function delCustmang()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custmang')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    //custmang detail 详细
    function custInfo()
    {
        //check
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        if (empty($id)) $this->returnError('id不存在');
        //select data
        $data = 'id,type,cust_name,custdname,custcname,phone,address,retime,noticetime,birth,charact,comment,forecast,goal,edu,info';
//         $result['results'] = spClass('m_custmang')->find('id='.$id, '', $data);
        $result['results'] = spClass('m_custmang')->find('id='.$id.' and cid='.$admin['cid'], '', $data);
        
        if (empty($result['results'])) $this->returnError('失败');
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * update/add cust mang
     * 更新/添加用户管理
     */
    function saveCustmang()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_custmang');
        
        $arg = array(
            'id'         => '',
            'type'       => '客户从业类型',
            'sex'        => '性别',
            'age'        => '年龄',
            'cust_name'  => '客户名称',
            'custdname'  => '',
            'custcname'  => '客户公司',
            'phone'      => '客户手机', //客户手机，不能为空
            'telephone'  => '',       //客户电话，可以为空
            'source'     => '客户来源', //来源,$GLOBALS
            'email'      => '',
            'address'    => '',
            'retime'     => '',
            'noticetime' => '',
            'birth'      => '',
            'charact'    => '',
            'comment'    => '',
            'forecast'   => '',
            'goal'       => '',
            'edu'        => '',
            'info'       => '',
            'saleid'     => '',
            'pid'        => '',
            'pname'      => '',
            'flowid'     => '', //跟进状态
        );
        
        $data = $this->receiveData($arg);
        $data['status'] = 1;
        $id = (int) $data['id'];
        unset($data['id']);
        
        if ($id) {
//             $data['flowid'] = htmlspecialchars($this->spArgs('flowid'));    //跟进状态
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re)) $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['applyid']   = $admin['id'];
            $data['applyname'] = $admin['username'];
            $data['applydt']   = date('Y-m-d H:i:s');
            $data['cid']       = $admin['cid'];
            $data['flowid']    = 1;
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * return JSON
     * 客户跟进+状态的列表
     * 
     */
//     function flowLst()
//     {
//         $admin = $this->islogin();
//         $searchname          = urldecode(htmlspecialchars($this->spArgs('searchname')));
        
//         $m_cust   = spClass('m_custmang');
//         $m_record = spClass('m_cust_record');
        
//         //where和分页where
//         $con    = 'del = 0 and cid = ' . $admin['cid']. ' and flowid<3';
//         if (!empty($searchname)) {
//             $con .= ' and concat(cust_name,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
//             $page_con['searchname'] = $searchname;
//         }
        
//         $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
//         $pager   = $m_cust->spPager()->getPager();
//         $result['pager'] = $pager;
        
//         foreach ($results as $_k => $_v){
//             $record = $m_record->findSql('select addtime,status from '.DB_NAME.'_cust_record where fid='.$_v['id'].' order by id desc limit 1');
//             if ($record){
//                 $results[$_k]['record_addtime'] = $record[0]['addtime'];
//                 $results[$_k]['record_status']  = $record[0]['status'];
//             }else {
//                 $results[$_k]['record_addtime'] = '';
//                 $results[$_k]['record_status']  = '';
//             }
//         }
        
//         foreach($results as $k=>$v){
//             $result['results'][$k] = array(
//                 'id'             => $v['id'],
//                 'custcname'      => $v['custcname'],
//                 'cust_name'      => $v['cust_name'],
//                 'record_status'  => $v['record_status'],    //跟进情况
//                 'record_addtime' => $v['record_addtime'],    //最新跟进时间
//                 'phone'          => $v['phone'],
//                 'address'        => $v['address'],
//             );
//         }
        
//         $this->returnSuccess('成功', $result);
//     }
    
    /**
     * 客户跟进管理详情
     * 客户管理信息 && 客户回访记录
     * cust info && cust record list
     * 返回连表数据
     */
    function flowcust()
    {
        $admin         = $this->islogin();
        $m_record      = spClass('m_cust_record');
        $m_mang        = spClass('m_custmang');
        $m_contract    = spClass('m_contract');
        
        $f_id    = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($f_id)) $this->returnError('id不存在');
        $f_result = $m_mang->find('id='.$f_id.' and cid='.$admin['cid']);
        $c_result = $m_record->findAll('fid='.$f_id.' and cid='.$admin['cid'], 'id desc', 'addtime,`explain`');
        if (empty($f_result)) $this->returnError('id非法');
        
        $t_result = $m_contract->findAll('custid='.$f_id);
        $results['t_result'] = $t_result;
        $results['f_result'] = $f_result;
        $results['c_result'] = $c_result;
        $this->returnSuccess('成功', $results);
//         $res = $m_mang->findSql("select a.*,b.flowname,b.addtime,b.explain from yld_custmang as a,yld_cust_record as b where a.id = b.fid");
    }
    
    /**
     * add record
     * 增加回访记录
     */
    function addCustRecord()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_cust_record');
        $f_id    = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($f_id)) $this->returnError('id不存在');
        $id_exist = spClass('m_custmang')->find('id='.$f_id.' and cid='.$admin['cid'], '', 'id');
        if (empty($id_exist)) $this->returnError('id非法');
        
        $arg = array(
            'addtime'   => '添加时间',
            'explain'   => '描述情况',
        );
        $data = $this->receiveData($arg);
        
        $data['applyid']   = $admin['id'];
        $data['applyname'] = $admin['username'];
        $data['applydt']   = date('Y-m-d H:i:s');
        $data['cid']       = $admin['cid'];
        $data['fid']       = $f_id;
        $data['ip']        = $_SERVER['REMOTE_ADDR'];
        
        //当回访客户时，flowID为2
        spClass('m_custmang')->update(array('id' => $f_id, 'del' => 0, 'cid' => $admin['id']), array('flowid' => 2));
        
        $res = $model->create($data);
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    /*
     * 签约客户详情
     */
//     function finishCustInfo()
//     {
//         $admin      = $this->islogin();
//         $m_contract = spClass('m_custmang');
//         $id         = htmlspecialchars($this->spArgs('id'));
//         //check params
//         if (empty($id)) $this->returnError('id不存在');
//         $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid'].' and flowid=3');
//         if (empty($results)) $this->returnError('id非法');
//         $result['results'] = $results;
        
//         $this->returnSuccess('成功', $result);
//     }
    
    /*
     * 审核通过的我的合同申请
     * 用于新增合同的渲染
     */
    function applyCheckLst()
    {
        $admin   = $this->islogin();
        $results = spClass('m_contract_apply')->findAll('status=3 and del=0 and cid='.$admin['id'].' and applyid='.$admin['id'].'');
        foreach($results as $k=>$v){
            
            $result['results'][$k] = array(
                'apply_id'             => $v['id'],
                'apply_contractname'   => $v['contractname'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同签订 更新 & 增加
     */
    function saveContract()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_contract');
        $id              = (int)htmlentities($this->spArgs('id'));
        $applyid         = (int)htmlentities($this->spArgs('apply_id'));
        
        $arg = array(
            'money'   => '合同金额',
            'signdt'  => '',
            'phone'   => '',
            'adddt'   => '',
            'explain' => '',
            'startdt' => '',
            'enddt'   => '',
            'content' => '',
        );
        $data = $this->receiveData($arg);
        
        //从申请表过来的数据
        $apply_data = spClass('m_contract_apply')->find('id='.$applyid);
        if (!$apply_data) $this->returnError('合同申请不存在');
        $data['name'] = $apply_data['contractname'];
        $data['cname'] = $apply_data['applycname']; //客户名称
        $data['salename'] = $apply_data['applyname'];
        $data['saleid'] = $apply_data['applyid'];
        $data['custid'] = $apply_data['custid'];    //客户id
        $data['files'] = $apply_data['files'];  //文件资料
//         $files = $this->spArgs('files');
//         if ($files) $data['files'] = implode(',', $files);
        
        $files = $this->spArgs('files');
        if($files) $data['files'] = implode(',', $files);
        $sum   = $model->findCount('number like "%C'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        
        //更新客户的签约状态
        spClass('m_custmang')->update(array('id'=>$data['custid'],'cid'=>$admin['cid']),array('flowid' => 3));
        
        $data['number']  = 'C'.date('Ymd').$sum;
        $data['adddt']   = date('Y-m-d H:i:s');
        $data['status']  = 1;
        $data['cid']     = $admin['cid'];
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if($id){
            $re = $model->find(array('id'=>$id.' and cid='.$admin['cid'],'del'=>0));
            if(empty($re)) $this->returnError('信息不存在');
            if($re['status']>=3) $this->returnError('该合同已审核，不可操作');
            if(!empty($re['number'])) unset($data['number']);
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $ad = $re['id'];
            }
        }else{
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($admin, 3, $ad, '【'.$data['name'].'】合同');
//             $this->sendUpcoming(7, $ad, $data['uname'] . '申请领用[' . $data['gname'] . ']');
            $this->returnSuccess('成功');
        } else {
            $this->returnError('失败');
        }

    }
    
    /*
     * 合同列表
     */
    function contractLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $distance   = urldecode(htmlspecialchars($this->spArgs('distance')));
        $m_contract = spClass('m_contract');
        $m_custpay  = spClass('m_custpay');
        
//         $con = 'select * from '.DB_NAME.'_contract where ';
        //where和分页where
        $con    .= 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(number,name,adddt,cname,money,startdt,enddt,signdt,salename) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($distance)) {
            if ($distance == 1){    //未生效 签约时间未到
                $con .= ' and UNIX_TIMESTAMP(startdt)>'.time().'';
                $page_con['distance'] = $distance;
            }elseif ($distance == 2){   //已生效
                $con .= ' and UNIX_TIMESTAMP(startdt)<'.time().' and UNIX_TIMESTAMP(enddt)>'.time().'';
                $page_con['distance'] = $distance;
            }elseif ($distance == 3){   //已过期
                $con .= ' and UNIX_TIMESTAMP(enddt)<'.time().'';
                $page_con['distance'] = $distance;
            }
        }
        
        //统计总金额数据
        $re_all  = $m_contract->findAll('del=0 and cid='.$admin['cid'], 'id desc', 'money'); //总金额
        $pay_all = $m_custpay->findAll('del=0 and cid='.$admin['cid'], 'id desc', 'getmoney');    //总已收款
        $sum_all = $sum_pay = $con_pay = 0;
        foreach ($re_all as $re_v){
            $sum_all = $sum_all + $re_v['money'];
        }
        foreach ($pay_all as $pay_v){
            $sum_pay = $sum_pay + $pay_v['getmoney'];
        }
//         $a = $m_contract->findSql('select * from '.DB_NAME.'_contract where UNIX_TIMESTAMP(enddt)>'.time().'','adddt desc,id desc');
//         dump($a);die;
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'adddt desc,id desc');
//         dump($m_contract->dumpSql());die;
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
            $cust_res = $m_custpay->findAll('contractid='.$v['id'].' and del=0 and cid='.$admin['cid'].'');
            if (!empty($cust_res)){
                foreach ($cust_res as $cust_v){
                    $con_pay = $con_pay + $cust_v['getmoney'];
                }
            }else {
                $con_pay = 0;
            }
            $result['results'][$k]['con_pay']  = $con_pay;
            $result['results'][$k]['con_will'] = $v['money'] - $con_pay;
            $con_pay = 0;
        }
        
        $result['sum_all'] = $sum_all;//合同总金额
        $result['sum_pay'] = $sum_pay;//总已收款
        $result['sum_not'] = $sum_all - $sum_pay;//总未收款
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同详情
     */
    function contractInfo()
    {
        $admin      = $this->islogin();
        $m_contract = spClass('m_contract');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        $result['custpay'] = spClass('m_custpay')->findAll('contractid='.$id.' and del=0 and cid='.$admin['cid'].'');
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除合同
     */
    function delContract()
    {
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_contract')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'contract'),array('del' => 1));
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }

    /**
     * 新增合同申请
     */
    function saveContractApply()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_contract_apply');
        $id              = (int)htmlentities($this->spArgs('id'));
        $arg = array(
            'custid'          => '客户id',
            'applyname'       => '申请人(销售人员)',
            'contractname'    => '申请合同名称',
            'contractdesc'    => '合同对方简介',
            'contractcontent' => '合同内容',
//             'applydname'      => '申请部门',
            'suggest'         => '审核意见',
            'applyid'         => '申请人',
            'applydt'         => '申请日期',
        );
        $data = $this->receiveData($arg);
        
        $data['adddt']      = date('Y-m-d H:i:s');
        $data['status']     = 1;
        $data['cid']        = $admin['cid'];
        $data['optid']      = $admin['id'];
//         $data['applydname'] = $admin['dname'];
        $data['optname']    = $admin['name'];
        $data['optdt']      = date('Y-m-d H:i:s');
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            if($re['status']>=3) $this->returnError('该合同申请已审核，不可操作');
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $ad = $re['id'];
            }
        }else{
            $ad = $model->create($data);
            $id = $ad;
        }
        if ($ad) {
            $this->sendUpcoming($admin, 43, $id, '【'.$data['contractname'].'】合同申请');
            $this->returnSuccess('成功');
        } else {
            $this->returnError('失败');
        }
    }
    
    /**
     * 合同申请详情
     */
    function applyContractInfo()
    {
        $admin = $this->islogin();
        $id    = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 43);
    }
    
    /**
     * 合同申请列表(当前用户)
     */
    function applyContractLst()
    {
        $admin         = $this->islogin();
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_contract    = spClass('m_contract_apply');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and applyid='.$admin['id'];
        if (!empty($searchname)) {
            $con .= ' and concat(applyname,contractname,contractdesc,applydt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $result['sales']   = spClass('m_admin')->findAll('', 'id desc', 'id,username');   //销售人员渲染
        $result['sales']   = array_values($result['sales']);
        $result['status']  = array(1,2,3);  //合同状态
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同申请列表(管理员)
     */
    function applyContractAll()
    {
        $admin         = $this->islogin();
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_contract    = spClass('m_contract_apply');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(applyname,contractname,contractdesc,applydname,applydt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $result['sales']   = spClass('m_admin')->findAll('', 'id desc', 'id,username');   //销售人员渲染
        $result['sales']   = array_values($result['sales']);
        $result['status']  = array(1,2,3);  //合同状态
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同申请删除
     */
    function applyContractDel()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $admin = $this->islogin();
        $data = spClass('m_contract_apply')->find('id='.$id);
        if ($data['applyid'] != $admin['id']) $this->returnError('该用户未申请该合同!');
        
        $res   = spClass('m_contract_apply')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res) $this->returnSuccess('成功');;
        $this->returnError('失败');
    }
    
    
    
    
    
    /**
     * -----------------------------------财务管理模块---------------------------------
     */
    
    /*
     * 项目对账单+收款记录信息
     * 搜索参数和前端对接
     * TIps:循环合同，选择一个合同查看其数据
     */
    function projectBill()
    {
        $admin         = $this->islogin();
        $id            = (int)htmlspecialchars($this->spArgs('id'));
        $m_contract    = spClass('m_contract');
        $result['results']       = $m_contract->find('id='.$id.' and del=0 and cid='.$admin['cid']);    //合同数据
        $result['paymon']        = spClass('m_custpay')->findAll('contractid='.$result['results']['id']);   //付款数据
        $will = 0;
        foreach ($result['paymon'] as $k => $v){
            $will = $will + $v['getmoney'];
        }
        $result['balance'] = $result['results']['money'] - $will;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 其他收支明细列表
     * 即checkstatus=2
     */
    function otherBillLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $searchdt   = urldecode(htmlspecialchars($this->spArgs('searchdt')));   //现在按照具体时间查找 //查询时间范围查询
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=2';
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
        }
        if (!empty($searchdt)){
            $con .= ' and adddt like "%' . $searchdt . '%"';
        }
        
        $result['pay'] = spClass('m_custpay_mon')->findAll($con);
        $result['get'] = spClass('m_custpay')->findAll($con);
        
        $this->returnSuccess('成功', $result);
    }
    
    
    
    
}

