<?php

class salegoal extends AppController
{
    
    /**
     * 我的业绩-管理员
     */
    function mysaleAdmin()
    {
        $admin      = $this->islogin();
        $signdt     = urldecode(htmlspecialchars($this->spArgs('signdt')));
        $m_contract = spClass('m_contract');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($signdt)) {
            $con .= ' and (signdt like "%' . $signdt . '%")';
            $page_con['signdt'] = $signdt;
        }
        
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        if (!empty($searchname)) {
            $con .= ' and concat(number,name,adddt,cname,money,startdt,enddt,signdt,salename) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'adddt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        $m_cust_pay = spClass('m_custpay')->findAll('saleid='.$admin['id'].' and cid='.$admin['cid']);
        $mon_num = 0;
        foreach($results as $k=>$v){
            foreach ($m_cust_pay as $pay){
                if ($v['id'] == $pay['contractid']){
                    $mon_num = $pay['getmoney'] + $mon_num;
                }
            }
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'optname'  => $v['optname'],  //目标制定人
                'factpay'  => $mon_num, //实际付款
                'name'     => $v['name'],
                'phone'    => $v['phone'],
                'signdt'   => $v['signdt'],
                'salename' => $v['salename'],
            );
            $mon_num = 0;
        }
        
//         $result['sales']   = spClass('m_admin')->findAll('', 'id desc', 'id,username');   //销售人员渲染
//         $result['sales']   = array_values($result['sales']);
//         $result['status']  = array(1,2,3);  //合同状态
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 我的业绩-普通用户(TODO 是否需要重构我的下级的业绩 根据导航无需TODO)
     */
    function mysaleUser()
    {
        $admin      = $this->islogin();
        $signdt     = urldecode(htmlspecialchars($this->spArgs('signdt')));
        $m_contract = spClass('m_contract');
        
        //where和分页where
        $con    = 'del = 0 and saleid='.$admin['id'].' and cid = ' . $admin['cid'];
        if (!empty($signdt)) {
            $con .= ' and (signdt like "%' . $signdt . '%")';
            $page_con['signdt'] = $signdt;
        }
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        if (!empty($searchname)) {
            $con .= ' and concat(number,name,adddt,cname,money,startdt,enddt,signdt,salename) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'adddt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        $m_cust_pay = spClass('m_custpay')->findAll('saleid='.$admin['id'].' and cid='.$admin['cid']);
        $mon_num = 0;
        foreach($results as $k=>$v){
            foreach ($m_cust_pay as $pay){
                if ($v['id'] == $pay['contractid']){
                    $mon_num = $pay['getmoney'] + $mon_num;
                }
            }
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'optname'  => $v['optname'],  //目标制定人
                'factpay'  => $mon_num, //实际付款
                'name'     => $v['name'],
                'phone'    => $v['phone'],
                'signdt'   => $v['signdt'],
                'salename' => $v['salename'],
            );
            $mon_num = 0;
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 我的业绩详情
     */
    function mysaleInfo()
    {
        $admin      = $this->islogin();
//         $model      = spClass('m_sale_goal');
        $m_contract = spClass('m_contract');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /*
     * 下级用户数据
     */
    function sUser()
    {
        $admin = $this->islogin();
        $result['results'] = spClass('m_admin')->findAll('sid='.$admin['id']);
        $result['results'] = array_values($result['results']);
        foreach ($result['results'] as $_k => $_v){
            $result['results'][$_k] = array(
                'id'       => $_v['id'],
                'username' => $_v['username'],
            );
        }
        if (!empty($result)) $this->returnSuccess('成功', $result);
        $this->returnError('失败');
    }
    
    /**
     * 新增销售目标
     */
    function saveGoal()
    {
        $admin          = $this->islogin();
        $model          = spClass('m_sale_goal');
        $id             = (int)htmlentities($this->spArgs('id'));
        //查看是否存在下级,存在则可以选择给别人制定目标
        $my_emp         = spClass('m_admin')->findAll('sid='.$admin['id']);
        if (!empty($my_emp)){   //存在下级
            $saleid     = '销售人员id';
            $salename   = '销售姓名';
            $saledname  = '所在部门';
        }else {
            $saleid     = '';
            $salename   = '';
            $saledname  = '';
        }
        
        $arg = array(
            'saleid'    => $saleid,
            'salename'  => $salename,
            'fid'       => '',
            'goaltitle' => '销售目标标题',
            'info'      => '',
            'goalstatus'=> '',
            'salenum'   => '销售单目标',
            'salemoney' => '销售金额目标',
        );
        $data = $this->receiveData($arg);
        
        if (empty($my_emp)){    //没有下级则是自己为自己添加目标
            $data['saleid']    = $admin['id'];
            $data['salename']  = $admin['username'];
            $data['saledname'] = $admin['dname'];
        }
        
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];  //既是操作人，也是制定人
        $data['optname']   = $admin['name'];//既是操作人，也是制定人
        $data['optdt']     = date('Y-m-d H:i:s');
        if($id){    //销售目标没有更新
//             $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
//             if(empty($re)) $this->returnError('信息不存在');
//             if($re['goalstatus'] == 1) $this->returnError('该目标已完成，不需要再操作');
//             $up = $model->update(array('id'=>$id),$data);
        }else{
            if (empty($data['goalstatus'])) $data['goalstatus'] = 2;    //1已完成2未完成
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 销售目标详情
     */
    function goalInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_sale_goal');
        $m_contract = spClass('m_contract');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        
        $contract   = $m_contract->findAll('saleid='.$results['saleid'].' and del=0 and cid='.$admin['cid'].'', '', '');
        $sum = 0;
        foreach ($contract as $_k => $_v){
            if (substr($results['goaldt'], 0, 7) != substr($_v['signdt'], 0, 7)){
                unset($contract[$_k]);
                continue;
            }
            $sum = $sum + $_v['money'];
            $contract[$_k]['month'] = substr($_v['signdt'], 5, 2);
            
            //对历史销售完成情况的统计 TODO not todo渲染合同数据即可，无需其他
        }
        
        
        $result['results']  = $results;
        $result['contract'] = array_values($contract);
        $result['sum']      = $sum; //实际销售金额
        $result['goal_mon'] = $results['salemoney'];    //目标金额
        $result['well_mon'] = $results['salemoney'] - $sum; //未达到金额
        $result['per']      = $sum/$result['goal_mon']; //达到率
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除销售目标没有删除
     */
//     function delGoal()
//     {
//         $admin = $this->islogin();
//         $id    = htmlspecialchars($this->spArgs('id'));
//         //查看是否是我的目标或者我
//         $res   = spClass('m_sale_goal')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
//         if ($res){
//             $this->returnSuccess('成功');
//         }else {
//             $this->returnError('失败');
//         }
//     }
    
    
    /**
     * 销售目标列表-管理员
     */
    function goalLstAdmin()
    {
        $admin     = $this->islogin();
        //where和分页where
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $this->commonGoal($con);
    }
    /**
     * 销售目标列表-普通用户(我的和我的下级销售列表)
     */
    function goalLstUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
//         $sdata  = spClass('m_admin')->findAll('sid='.$admin['id'], '', 'id');
        
//         if (!empty($sdata)){
//             foreach ($sdata as $_k => $_v){
//                 $allid .= $_v['id'].',';
//             }
//             $allid = substr($allid, 0, strlen($allid) - 1);
//             $allid = $allid.','.$admin['id'];
//             $con .= ' and saleid in ('.$allid.')';
//         }else {
//             $con   .= ' and saleid='.$admin['id'];
//         }
        
        $this->commonGoal($con);
    }
    
    /**
     * 查看下级销售目标-列表
     */
    function goalLstSon()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $sdata  = spClass('m_admin')->findAll('sid='.$admin['id'], '', 'id');
        
        if (!empty($sdata)){
            foreach ($sdata as $_k => $_v){
                $allid .= $_v['id'].',';
            }
            $allid = substr($allid, 0, strlen($allid) - 1);
            $con .= ' and saleid in ('.$allid.')';
        }else {
            $con   .= ' and saleid='.$admin['id'];
        }
        $this->commonGoal($con);
    }
    
    /**
     * 列表公共方法
     * @param unknown $con
     */
    function commonGoal($con)
    {
        if (empty($con)) $this->returnError('非法输入');
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model      = spClass('m_sale_goal');
        if (!empty($searchname)) {
            $con   .= ' and concat(salenum,salemoney,salename,saledname,goaltitle) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        $sum = 0;
        foreach($results as $k=>$v){
            $now_time = substr($v['goaldt'], 0, 7);
            $contract = spClass('m_contract')->findAll('signdt like "%'.$now_time.'%"');
            foreach ($contract as $_k => $_v){
                $sum = $sum + $_v['money'];
            }
            $per = $sum/$v['salemoney'];
            $result['results'][$k] = array(
                'id'          => $v['id'],
                'saleid'      => $v['saleid'],
                'salename'    => $v['salename'],
                'saledname'   => $v['saledname'],
                'goaldt'      => $v['goaldt'],
                'goaltitle'   => $v['goaltitle'],
                'goalstatus'  => $v['goalstatus'],
                'per'         => $per,  //计划完成度
            );
            $sum = 0;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 销售目标统计
     */
    function goalCount()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        
        $saledname = urldecode(htmlspecialchars($this->spArgs('saledname')));
        $optdt     = urldecode(htmlspecialchars($this->spArgs('optdt')));
        $salename  = urldecode(htmlspecialchars($this->spArgs('salename')));
        $model     = spClass('m_sale_goal');
        $optdt     = substr($optdt, 0, -3);
        
        if (!empty($saledname)) {
            $con .= ' and (saledname="'.$saledname.'")';
            $page_con['saledname'] = $saledname;
        }
        if (!empty($salename)) {
            $con .= ' and (salename="'.$salename.'")';
            $page_con['salename'] = $salename;
        }
        if (!empty($optdt)) {
            $con .= ' and (optdt like "%' . $optdt . '%")';
            $page_con['optdt'] = $optdt;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = array(
                'id'          => $v['id'],
                'saleid'      => $v['saleid'],
                'salename'    => $v['salename'],
                'saledname'   => $v['saledname'],
                'optdt'       => $v['optdt'],
                'goaltitle'   => $v['goaltitle'],
                'goalstatus'  => $v['goalstatus'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    
    
    
}

