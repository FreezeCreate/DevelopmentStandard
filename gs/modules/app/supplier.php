<?php

class supplier extends AppController
{
    public $pass_info  = '审核通过';
    public $pass_exit  = '驳回';
    public $pass_final = '终审通过';
    /**
     * 供应商列表
     */
    function index()
    {
        $admin        = $this->islogin();
        
        $model = spClass('m_supplier');
        $con = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $year         = urldecode(htmlspecialchars($this->spArgs('year')));
        $month        = urldecode(htmlspecialchars($this->spArgs('month')));
        $day          = urldecode(htmlspecialchars($this->spArgs('day')));
        
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        if (!empty($searchname)) {
            $con .= ' and concat(company,address,name,phone) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        if(!empty($status)){
            $con .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (company like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        if (empty($year)){
            $con .= '';
        }elseif (!empty($year) && empty($month)){
            $con .= ' and (optdt like "%'.$year.'%")';
            $page_con['year'] = $year;
        }elseif (!empty($year) && !empty($month) && empty($day)){
            $con .= ' and (optdt like "%'.$year.'-'.$month.'%")';
            $page_con['year'] = $year.'-'.$month;
        }else {
            $con .= ' and (optdt like "%'.$year.'-'.$month.'-'.$day.'%")';
            $page_con['year'] = $year.'-'.$month.'-'.$day;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
            
    }
    
    /**
     * 删除供应商
     */
    function delSupplier()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_supplier', $id);
    }
    
    /**
     * 供应商审核
     */
    function supplierCheck()
    {
        $admin = $this->islogin();
        $model = spClass('m_supplier');
        $id    = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'checkstatus' => '审核状态',
//             'checkinfo'   => '',

//             'cgst'         => '',
//             'cgname'       => '',
//             'zjst'         => '',
//             'zjname'       => '',
//             'scst'         => '',
//             'scname'       => '',
//             'offer_status' => '',
//             'stdt'         => '',
        );
        $data = $this->receiveData($arg);
        //签名图片
        $files = $this->spArgs('checkinfo');
        if ($files) $data['checkinfo'] = implode(',', $files);
        
        //更新审核数据
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('供应商不存在');
            //update status
            //Tips:TODO 前端传一个审核字段checkstatus,checkinfo,详细信息页面
            if (empty($re['cgst'])){
                $data['cgst']    = $data['checkstatus'];
                $data['cgname']  = $data['checkinfo'];
                $data['checkid'] = $re['checkid'].$admin['id'].',';
            }elseif (!empty($re['cgst']) && empty($re['zjst'])){
                $data['zjst']    = $data['checkstatus'];
                $data['zjname']  = $data['checkinfo'];
                $data['checkid'] = $re['checkid'].$admin['id'].',';
            }elseif (!empty($re['zjst']) && empty($re['scst'])){
                $data['scst']    = $data['checkstatus'];
                $data['scname']  = $data['checkinfo'];
                $data['checkid'] = $re['checkid'].$admin['id'].',';
            }elseif (!empty($re['scst']) && empty($re['offer_status'])){
                $data['offer_status'] = $data['checkstatus'];
                $data['checkid']      = $re['checkid'].$admin['id'].',';
                $data['status']       = 2;  //当终审后不能提交
            }
            if ($data['checkstatus'] == 2) $data['status'] = 2; //当驳回后不能提交
            
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $this->returnSuccess('成功');
            $this->returnError('失败');
        }
    }
    
    /**
     * 供应商详细
     * TODO 根据三个签名的正确与否来返回是否需要审核或者：审核评定结论未最后依据
     * 当任何一个状态为2时则驳回，不显示审核信息
     */
    function supplierInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_supplier');
        $m_user  = spClass('m_admin');
        $id      = (int)htmlentities($this->spArgs('id'));
        $results = $model->find(array('id'=>$id, 'del' => 0, 'cid' => $admin['cid']));
        
        $result['checkstatus'] = 0;
        if (empty($results['cgst']) || empty($results['zjst']) || empty($results['scst'])){
            $result['checkstatus'] = 1;
        }elseif (empty($results['offer_status'])){
            $result['checkstatus'] = 2;
        }else {
            $result['checkstatus'] = 4; //为4时不显示审核表单
        }
        
        //不合格,不做审核
        if ($results['cgst'] == 2 || $results['zjst'] == 2 || $results['scst'] == 2){
            $result['checkstatus'] = 4;
        }
        
        $user = array();
        if (!empty($results['checkid'])){
            //判定几次审核，当四次时为公司合格方
            $all_id = array_filter(explode(',', $results['checkid']));
            foreach ($all_id as $_k => $_v){
                $user[] = $m_user->find('id='.$_v);
                
                if ($_k == 0) $user[$_k]['sign_pic'] = $results['cgname'];  //审核签名
                if ($_k == 1) $user[$_k]['sign_pic'] = $results['zjname'];
                if ($_k == 2) $user[$_k]['sign_pic'] = $results['scname'];
                //审核信息,userinfo
                if ($_k == 3){
                    $user[$_k]['info'] = $this->pass_final;
                }else {
                    $user[$_k]['info'] = $this->pass_info;
                    if ($_k == 0 && $results['cgst'] == 2){
                        $user[$_k]['info'] = $this->pass_exit;
                    }
                    if ($_k == 1 && $results['zjst'] == 2){
                        $user[$_k]['info'] = $this->pass_exit;
                    }
                    if ($_k == 2 && $results['scst'] == 2){
                        $user[$_k]['info'] = $this->pass_exit;
                    }
                }
            }
        }
        
        $result['results'] = $results;
        $result['user']    = $user;
        
        $this->returnSuccess('成功', $result);
        
//         $mid = (int) htmlentities($this->spArgs('mid'));
//         $id  = (int) htmlentities($this->spArgs('id'));
//         $this->findCheck($id, 15);
    }
    
    /**
     * 新增供应商
     */
    function addSupplier()
    {
//         $admin = $this->islogin();
//         $model = spClass('m_supplier');
//         $data  = $this->spArgs();
//         unset($data['id']);
//         if(empty($data['company'])){
//             $this->msg_json(0, '请输入供应商名称');
//         }
//         if(empty($data['name'])){
//             $this->msg_json(0, '请输入联系人');
//         }
//         if(empty($data['phone'])){
//             $this->msg_json(0, '请输入联系电话');
//         }
//         if(empty($data['goodstype'])){
//             $this->msg_json(0, '请输入供货类别');
//         }
//         $re = $model->find(array('company'=>$data['company'],'cid'=>$admin['cid']));
//         if($re){
//             $this->msg_json(0, '该供应商已添加');
//         }
//         $data['cid'] = $admin['cid'];
//         $ad = $model->create($data);
//         if($ad) $this->returnSuccess('成功');
//         $this->returnError('失败');
        
        
        $admin           = $this->islogin();
        $model           = spClass('m_supplier');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'company'      => '供应商名称',
            'address'      => '地区',
            'goodstype'    => '',   //供货商品类型
            'name'         => '联系人',
            'phone'        => '联系方式',
            'explain'      => '详细',
            'hfzm'         => '',
            'zlqk'         => '',
            'jgfw'         => '',
            'xgzz'         => '',
            'shxy'         => '',
            'cgst'         => '',
            'cgname'       => '',
            'zjst'         => '',
            'zjname'       => '',
            'scst'         => '',
            'scname'       => '',
            'offer_status' => '',
            'stdt'         => '',
        );
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('供应商不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $data['status']    = 1;
            $up = $model->create($data);
        }
        
        if($up){
            //在详细信息走审核流程，不在此审核
//             $this->sendUpcoming($admin, 15, $up, '【'.$data['company'].'】供应商');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    
    
    /**
     * 财务管理模块的查询数据
     */
    /*
     * 供应商列表循环，查找单一数据
     */
    function supAllInfo()
    {
        $admin         = $this->islogin();
        $id            = (int)htmlspecialchars($this->spArgs('id'));
        $m_supplier    = spClass('m_supplier');
        $result['results']       = $m_supplier->find('id='.$id.' and del=0 and cid='.$admin['cid']);
        $result['regoods']       = spClass('m_regoods')->findAll('recomid='.$id);
        $result['invoice']       = spClass('m_invoice')->findAll('buldid='.$id);
        $pay_mon = spClass('m_custpay_mon')->findAll('custumid='.$result['results']['id']);
//         $pay = 0;
//         foreach ($pay_mon as $_k => $_v){
//             $pay = $pay + $_v['paymoney'];
//         }
        
//         $result['balance'] = $pay_mon[0]['payall'] - $pay;  //未付款
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 供应商对账单列表
     */
    function suppAllLst()
    {
        $admin         = $this->islogin();
        $con           = 'a.del = 0 and a.cid = ' . $admin['cid'];
        $id            = (int)htmlspecialchars($this->spArgs('id'));
        $searchname    = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model         = spClass('m_supplier');
        
        if (!empty($searchname)) {
            $con .= ' and concat(a.company,a.address,a.goodstype,a.phone) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        $sql     = 'select a.* from '.DB_NAME.'_supplier as a,'.DB_NAME.'_custpay_mon as b where '.$con.' and b.del=0 and b.cid='.$admin['cid'].' and a.id=b.custumid group by a.id order by a.id desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    
}

