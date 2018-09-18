<?php

class custpaymon extends AppController
{

    /**
     * 新增付款表信息 (Tips:选择客户数据是调用custmang/addmang接口)
     * TODO API文档的编写和auth表的编写
     * 
     */
    function saveCustPayMon()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_custpay_mon');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'custumid'     => '客户id',
            'custname'     => '客户名称',
            'contractid'   => '',   //合同id，当不为合同时不填写
            'contractname' => '',   //合同名称
            'paymoney'     => '',
            'adddt'        => '付款单申请日期',
            'record'       => '款项情况',
            'files'        => '',
            'paytypeid'    => '付款方式',
            'paytype'      => '付款方式',
            'saleid'       => '销售人员',
            'salename'     => '销售人员',
            'monstatus'    => '',   //1为结清；2为未结清
            'content'      => '',   //备注
            'checkstatus'  => '',   //1合同收款2其他收款
            'otherstatus'  => '',
            'cateid'       => '支出分类',
            'did'          => '部门',
            'dname'        => '部门',
        );
        $data = $this->receiveData($arg);
        
        $files = $this->spArgs('files');
        if($files) $data['files'] = implode(',', $files);
        $sum   = $model->findCount('paynumber like "%M'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        
        $data['paynumber']  = 'M'.date('Ymd').$sum;    //p=>pay
        $data['adddt']   = date('Y-m-d H:i:s');
        $data['cid']     = $admin['cid'];
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        $data['status']  = 1;
        
        if($id){
            $data['status']  = $this->spArgs('status');   //1为结清；2为未结清
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
//             if($re['monstatus'] == 1) $this->returnError('该款项已结清，不需要再操作');
            if(!empty($re['paynumber'])) unset($data['paynumber']);
            $up = $model->update(array('id'=>$id),$data);
        }else{
//             $data['monstatus']  = 2;   //1为结清；2为未结清
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
            $this->returnSuccess('成功');
        } 
        $this->returnError('失败');
    }
    
    /**
     * 付款记录列表
     */
    function custPayMonLst()
    {
        $admin     = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        
        $m_cust_pay = spClass('m_custpay_mon');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and otherstatus=1';
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
     * 付款记录详情
     */
    function custPayMonInfo()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 48);
//         $admin      = $this->islogin();
//         $model      = spClass('m_custpay_mon');
//         $id         = htmlspecialchars($this->spArgs('id'));
//         //check params
//         if (empty($id)) $this->returnError('id不存在');
//         $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
//         if (empty($results)) $this->returnError('id非法');
//         //合同详情
//         if (!empty($results['contractid'])){
//             $result['contract'] = spClass('m_contract')->find('id='.$results['contractid'].' and cid='.$admin['cid'].' and del=0');
//         }
//         $result['results'] = $results;
//         $this->returnSuccess('成功', $result);
    }
    
    
    //del custpay info
    function delCustPayMon()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_custpay_mon', $id);
    }
    
    /**
     * 以下为其他支出模块
     */
    
    /*
     *其他支出列表 
     */
    function otherPayLst()
    {
        $admin     = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        
        $m_cust_pay = spClass('m_custpay_mon');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and otherstatus=2';    //其他支出check
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
     * 其他支出详情
     */
    function otherPayInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_custpay_mon');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid'].' and otherstatus=2 and del=0');   //其他类型check
        if (empty($results)) $this->returnError('id非法');
        //合同详情
        if (!empty($results['contractid'])){
            $result['contract'] = spClass('m_contract')->find('id='.$results['contractid'].' and cid='.$admin['cid'].' and del=0');
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 其他支出删除
     */
    function delOtherPay()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custpay_mon')->update(array('id' => $id, 'cid' => $admin['cid'], 'otherstatus' => 2), array('del' => 1)); //otherstatus=2
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /*
     * 应付款 明细列表 monstatus=2(未结清)
     */
    function payChaseLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $searchdt   = urldecode(htmlspecialchars($this->spArgs('searchdt')));   //现在按照具体时间查找 //查询时间范围查询
        $m_cust_pay = spClass('m_custpay_mon');
        
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
     * 应付款详情 monstatus=2
     */
    function payChaseInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_custpay_mon');
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
     * 应付款删除 monstatus=2
     */
    function delPayChase()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custpay_mon')->update(array('id' => $id, 'cid' => $admin['cid'], 'monstatus' => 2), array('del' => 1)); //otherstatus=2
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
    
    
}

