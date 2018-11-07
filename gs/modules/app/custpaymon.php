<?php

class custpaymon extends AppController
{

    /**
     * TODO当monstatus为3时是app报销
     * 
     */
    function saveCustPayMon()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_custpay_mon');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'custumid'     => '',   //供应商id
            'custname'     => '',   //供应商名称
            'contractid'   => '',   //合同id，当不为合同时不填写
            'contractname' => '',   //合同名称
            'payall'       => '',   //总额
            'paymoney'     => '',   //已付
            'adddt'        => '付款单申请日期',
            'record'       => '款项情况',
            'files'        => '',
            'paytypeid'    => '付款方式',
            'paytype'      => '付款方式',
            'saleid'       => '付款人员',
            'salename'     => '付款人员',
            'monstatus'    => '结清状态',   //1为结清；2为未结清
            'content'      => '',   //备注
            'checkstatus'  => '',   //1付款给供应商2其他报销
            'cateid'       => '用款分类',   //费用科目
        );
        $data = $this->receiveData($arg);
        
        $files = $this->spArgs('files');
        if($files) $data['files'] = $files;
        $sum   = $model->findCount('paynumber like "%M'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        $user  = spClass('m_admin')->find('id='.$data['saleid']);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            if(!empty($re['paynumber'])) unset($data['paynumber']);
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['did']     = $user['did'];
            $data['dname']   = $user['dname'];
            $data['paynumber']  = 'M'.date('Ymd').$sum;    //p=>pay
            $data['adddt']   = date('Y-m-d H:i:s');
            $data['cid']     = $admin['cid'];
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['status']  = 1;
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
            
            $this->sendMsgNotice($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
            $this->returnSuccess('成功');
        } 
        $this->returnError('失败');
    }
    
    /**
     * 费用报销新增
     */
    function saveCustPayMonApp()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_expend');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'paymoney'     => '金额',
            'cateid'       => '用款类别',
            'adddt'        => '付款单申请日期',
            'content'      => '',   //说明
        );
        $data              = $this->receiveData($arg);
        $pay_cate = spClass('m_paycate')->find('id='.$data['cateid'].' and del=0 and cid='.$admin['cid'].'');
        $this->emptyNotice($pay_cate, '分类类别不存在');
        $data['catename'] = $pay_cate['catename'];
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['cid']        = $admin['cid'];
            $data['optid']      = $admin['id'];
            $data['optname']    = $admin['name'];
            $data['optdt']      = date('Y-m-d H:i:s');
            $data['status']     = 1;
            $data['saleid']     = $admin['id']; //报销人
            $data['salename']   = $admin['name'];
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 51, $up, '【'.$data['catename'].'】报销单');
            
            $this->sendMsgNotice($admin, 51, $up, '【'.$data['catename'].'】报销单');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    /**
     * app付款单新增
     */
    function saveCustPayMonApp1()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_custpay_mon');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'paymoney'     => '金额',
            'cateid'       => '用款类别',
            'adddt'        => '付款单申请日期',
            'content'      => '',   //说明
        );
        $data               = $this->receiveData($arg);
        $sum                = $model->findCount('paynumber like "%M'.date('Ymd').'%"');
        $sum                = $sum<9?'0'.($sum+1):($sum+1);
        
        $data['did']        = $admin['did'];
        $data['dname']      = $admin['dname'];
        $data['paynumber']  = 'M'.date('Ymd').$sum;
        $data['optdt']      = date('Y-m-d H:i:s');
        $data['cid']        = $admin['cid'];
        $data['optid']      = $admin['id'];
        $data['optname']    = $admin['name'];
        $data['optdt']      = date('Y-m-d H:i:s');
        $data['status']     = 1;
        $data['saleid']     = $admin['id']; //报销人
        $data['salename']   = $admin['name'];
        
        $data['monstatus']  = 3;    //当为3时是app报销
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            if(!empty($re['paynumber'])) unset($data['paynumber']);
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
            
            $this->sendMsgNotice($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    function sqlRun()
    {
//         dump(spClass('m_auth')->findAll(array('oid' => 1, 'hide' => 0), 'id asc'));
        
//         $sql = "INSERT INTO `yld_auth` (`id`, `title`, `control`, `way`, `pid`, `hide`, `sort`, `branch`, `user`, `del`, `img`, `oid`) VALUES
// ('', '我的客户', 'custmang', '', '0', '0', '1', '0', 'NULL', '0', '70', '1')";
//         spClass('m_auth')->runSql($sql);
        
//         dump(spClass('m_purchase_caigou')->findAll(''));die;
//         $data = [
//             'title' => '例行检验参数',
//             'control' => 'quality',
//             'way' => 'dyctparm',
//             'pid' => '7',
//             'sort' => '100',
            
//         ];
//         spClass('m_auth')->create($data);
//         spClass('m_auth')->deleteByPk(416);
//         spClass('m_auth')->deleteByPk(415);
//         spClass('m_auth')->deleteByPk(392);

//         spClass('m_dyjy')->runSql('ALTER TABLE  `yld_dyjy` ADD  `dytype` TINYINT( 1 ) NOT NULL');
//         $this->returnSuccess(1, $result);
    }
    
    /**
     * 付款记录列表
     */
    function custPayMonLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        
        $m_cust_pay = spClass('m_custpay_mon');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=1 and monstatus<>3';
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        //开始时间和结束时间查询
        $start      = htmlspecialchars($this->spArgs('start'));
        $end        = htmlspecialchars($this->spArgs('end'));
        if (!empty($start)){
            $con .= ' and optdt>"'.$start.'"';
        }
        if (!empty($end)){
            $con .= ' and optdt<"'.$end.'"';
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
     *其他支出新增 无审核
     */
    function saveOtherPay()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_custpay_mon');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'custname'     => '',   //供应商名称
            'payall'       => '',   //总额
            'paymoney'     => '',   //已付
            'adddt'        => '付款单申请日期',
            'record'       => '款项情况',
            'files'        => '',
            'paytypeid'    => '付款方式',
            'paytype'      => '付款方式',
            'saleid'       => '付款人员',
            'salename'     => '付款人员',
//             'monstatus'    => '结清状态',   //1为结清；2为未结清
            'content'      => '',   //备注
//             'checkstatus'  => '',   //1付款给供应商2其他报销
            'cateid'       => '用款分类',   //费用科目
        );
        $data = $this->receiveData($arg);
        $data['checkstatus'] = 2;   //1付款给供应商2其他报销
        $data['monstatus']   = 1;   //默认其他支出已结清
        $files = $this->spArgs('files');
        if($files) $data['files'] = implode(',', $files);
        $sum   = $model->findCount('paynumber like "%M'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        
        $user  = spClass('m_admin')->find('id='.$data['saleid']);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            if(!empty($re['paynumber'])) unset($data['paynumber']);
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['did']     = $user['did'];
            $data['dname']   = $user['dname'];
            $data['paynumber']  = 'M'.date('Ymd').$sum;    //p=>pay
            $data['adddt']   = date('Y-m-d H:i:s');
            $data['cid']     = $admin['cid'];
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['status']  = 3;
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        //无审核
//         if($up){
//             $this->sendUpcoming($admin, 48, $up, '【'.$data['paynumber'].'】付款单');
//             $this->returnSuccess('成功');
//         }
        $this->returnError('失败');
    }
    
    /**
     * 其他支出列表
     */
    function otherPayLst()
    {
        $admin     = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));    //客户名称
        
        $m_cust_pay = spClass('m_custpay_mon');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=2';    //其他支出check
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        //开始时间和结束时间查询
        $start      = htmlspecialchars($this->spArgs('start'));
        $end        = htmlspecialchars($this->spArgs('end'));
        if (!empty($start)){
            $con .= ' and optdt>"'.$start.'"';
        }
        if (!empty($end)){
            $con .= ' and optdt<"'.$end.'"';
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
        $results    = $model->find('id='.$id.' and cid='.$admin['cid'].' and checkstatus=2 and del=0');   //其他类型check
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
        $res = spClass('m_custpay_mon')->update(array('id' => $id, 'cid' => $admin['cid'], 'checkstatus' => 2), array('del' => 1)); //otherstatus=2
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
            $con .= ' and concat(paynumber,custname,contractname,adddt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($searchdt)){
            $con .= ' and adddt like "%' . $searchdt . '%"';
            $page_con['searchdt'] = $searchdt;
        }
        //开始时间和结束时间查询
        $start      = htmlspecialchars($this->spArgs('start'));
        $end        = htmlspecialchars($this->spArgs('end'));
        if (!empty($start)){
            $con .= ' and optdt>"'.$start.'"';
        }
        if (!empty($end)){
            $con .= ' and optdt<"'.$end.'"';
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
        
        //files处理
        if (!empty($results['files'])){
            $re_file = explode(',', $results['files']);
            foreach ($re_file as $k => $v){
                $reak[] = spClass('m_file')->find(array('id' => $v));
            }
        }
        $results['files']  = $reak;
        
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
        $res = spClass('m_custpay_mon')->update(array('id' => $id, 'cid' => $admin['cid'], 'monstatus' => 2), array('del' => 1));
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
    
    
}

