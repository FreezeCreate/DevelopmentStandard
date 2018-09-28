<?php

class custpay extends AppController
{

    /**
     * 新增收款表信息 (Tips:选择客户数据是调用custmang/addmang接口)
     */
    function saveCustPay()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_custpay');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
//             'custumid'     => '',   //客户id
            'contractid'   => '',   //合同id
            'contractname' => '',   //合同名称
            'getmoney'     => '',
            'adddt'        => '收款单申请日期',
            'record'       => '',
            'files'        => '',
            'paytypeid'    => '收款方式',
            'paytype'      => '收款方式',
            'saleid'       => '销售人员',
            'salename'     => '销售人员',
            'monstatus'    => '结款状态',   //1为结清；2为未结清
            'content'      => '',   //备注
            'otherstatus'  => '',   //1、收款2、其他收款    付款表存在此数据，该表字段冗余
            'checkstatus'  => '',   //1、合同收款2、其他收款
        );
        $data = $this->receiveData($arg);
        //客户id和名称的新增
        $contract_data = spClass('m_contract')->find('id='.$data['contractid'].' and del=0 and cid='.$admin['cid'].'');
        if (empty($contract_data)) $this->returnError('合同数据有误!');
        $data['custumid'] = $contract_data['custid'];
        $cust_data = spClass('m_custmang')->find('id='.$contract_data['custid'].' and del=0 and cid='.$admin['cid'].'');
        if (empty($cust_data)) $this->returnError('用户数据有误!');
        $data['custname'] = $cust_data['cust_name'];
        
        $files = $this->spArgs('files');
        if($files) $data['files'] = implode(',', $files);
        $sum   = $model->findCount('paynumber like "%P'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        
        $data['paynumber']  = 'P'.date('Ymd').$sum;    //p=>pay
        $data['adddt']   = date('Y-m-d H:i:s');
        $data['cid']     = $admin['cid'];
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if($id){
            $data['status']  = $this->spArgs('status');   //1为结清；2为未结清
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
//             if($re['monstatus'] == 1) $this->returnError('该款项已结清，不需要再操作');
            if(!empty($re['paynumber'])) unset($data['paynumber']);
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
//             $data['monstatus']  = 2;   //1为结清；2为未结清
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 收款记录列表
     */
    function custPayLst()
    {
        $admin     = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        
        $m_contract = spClass('m_contract');
        $m_cust_pay = spClass('m_custpay');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=1';
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_cust_pay->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_cust_pay->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 回款管理列表
     */
    function remonmang()
    {
        //合同信息+未收款信息
        $admin      = $this->islogin();
        $m_contract = spClass('m_contract');
        $m_custpay  = spClass('m_custpay');
        $salename   = urldecode(htmlspecialchars($this->spArgs('salename')));    //客户名称
        $number     = urldecode(htmlspecialchars($this->spArgs('number')));    //合同编号
        
        //按照客户姓名 + 合同编号搜索
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($cust_name)) {
            $con .= ' and (salename like "%' . $salename . '%")';
            $page_con['salename'] = $salename;
        }
        if (!empty($number)) {
            $con .= ' and (number like "%' . $number . '%")';
            $page_con['number'] = $number;
        }
        
        $sale    = spClass('m_admin')->findAll('', 'id desc', 'id,username');
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        $last_pay = $get_money = 0;
        foreach($results as $k=>$v){
            //余款数额
            $cust_pay  = $m_custpay->findAll('contractid='.$v['id']);
            foreach ($cust_pay as $cust_v){
                $last_pay  = $cust_v['getmoney'] + $last_pay;
            }
            
            $result['results'][$k] = array(
                'id'        => $v['id'],
                'number'    => $v['number'],
                'name'      => $v['name'],
                'salename'  => $v['salename'],
                'money'     => $v['money'],
                'factmoney' => $last_pay,
                'nothave'   => $v['money'] - $last_pay,
                'signdt'    => $v['signdt'],
                'startdt'   => $v['startdt'],
                'enddt'     => $v['enddt'],
                'explain'   => $v['explain'],
                'explain'   => $v['explain'],
                'status'    => $v['status'],
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    //del custpay info
    function delCustPay()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custpay')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    
    /**
     * 回款详情页
     */
    function remonmangInfo()
    {
        //合同信息+未收款信息
        $admin      = $this->islogin();
        $m_contract = spClass('m_contract');
        $m_custpay  = spClass('m_custpay');
        
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid']);
        $pay_res    = $m_custpay->findAll('contractid='.$id.' and cid='.$admin['cid']);
        
        if (empty($results)) $this->returnError('id非法');
        $result['contract'] = $results;
        $result['custpay']  = $pay_res;
        
        $this->returnSuccess('成功', $result);
        
    }
    
    
    /*
     * 以下为财务管理模块
     */
    
    
    /**
     * 其他收入列表
     */
    function otherGetLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        $m_cust_pay = spClass('m_custpay');
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=2';    //otherstatus=2未其他收入
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_cust_pay->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_cust_pay->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $this->returnSuccess('成功', $result);
    }
    /**
     * 其他收入详情
     */
    function otherGetInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_custpay');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid'].' and checkstatus=2 and del=0');   //otherstatus类型判断
        if (empty($results)) $this->returnError('id非法');
        //合同详情
        if (!empty($results['contractid'])){
            $result['contract'] = spClass('m_contract')->find('id='.$results['contractid'].' and cid='.$admin['cid'].' and del=0');
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    /**
     * 其他收入删除
     */
    function delOtherGet()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custpay')->update(array('id' => $id, 'cid' => $admin['cid'], 'checkstatus' => 2), array('del' => 1)); //otherstatus=2
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    
    
    
    /*
     * 应收款 明细列表 monstatus=2(未结清)
     */
    function getChaseLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $searchdt   = urldecode(htmlspecialchars($this->spArgs('searchdt')));   //现在按照具体时间查找 //查询时间范围查询
        $m_cust_pay = spClass('m_custpay');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and monstatus=2';
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        if (!empty($searchdt)){
            $con .= ' and adddt like "%' . $searchdt . '%"';
            $page_con['searchdt'] = $searchdt;
        }
        
        $results = $m_cust_pay->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_cust_pay->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 应收款详情 monstatus=2
     */
    function getChaseInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_custpay');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid'].' and monstatus=2 and del=0');
        if (empty($results)) $this->returnError('id非法');
        //合同详情
        if (!empty($results['contractid'])){
            $result['contract'] = spClass('m_contract')->find('id='.$results['contractid'].' and cid='.$admin['cid'].' and del=0');
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 应收款删除 monstatus=2
     */
    function delGetChase()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custpay')->update(array('id' => $id, 'cid' => $admin['cid'], 'monstatus' => 2), array('del' => 1)); //otherstatus=2
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
}

