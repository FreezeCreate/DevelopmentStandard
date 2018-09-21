<?php

class supplier extends AppController
{
    
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
     * 供应商详细
     */
    function supplierInfo(){
        $admin        = $this->islogin();
        
        $model = spClass('m_supplier');
        $id = (int)$this->spArgs('id');
        $result = $model->find(array('id'=>$id, 'del' => 0, 'cid' => $admin['cid']));
        $this->returnSuccess('成功', $result);
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
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['status']    = 1;
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('供应商不存在');
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 15, $up, '【'.$data['company'].'】供应商');
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
        
        $this->returnSuccess('成功', $result);
    }
    
    
}

