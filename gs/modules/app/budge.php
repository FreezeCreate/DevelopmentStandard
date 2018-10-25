<?php

class budge extends AppController
{
    
    /**
     * 预算分类列表
     */
    function index()
    {
        $admin    = $this->islogin();
        $con      = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model    = spClass('m_budge');
        if (!empty($searchname)) {
            $con .= ' and concat(budge_name,dname) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k => $v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /*
     * 预算预警
     */
//     function budgeNotice()
//     {
//         $admin    = $this->islogin();
//         $con      = 'del = 0 and cid = ' . $admin['cid'];
//         $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
//         $model    = spClass('m_budge');
//         $m_mon    = spClass('m_custpay_mon');
//         if (!empty($searchname)) {
//             $con .= ' and concat(budge_name,dname) like "%' . $searchname . '%"';
//             $page_con['searchname'] = $searchname;
//         }
        
//         $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
//         $pager   = $model->spPager()->getPager();
//         $result['pager'] = $pager;
//         $sum = $sum_c = $sum_d = $sum_p = $sum_dp = 0;
//         foreach($results as $k => $v){
//             $limit_time = substr($v['budge_time'], 0, 7);
//             $pay        = $m_mon->findAll('del=0 and cid='.$admin['cid'].' and status=3 and did='.$v['did'].' and adddt like "%'.$limit_time.'%"', '', 'paymoney');   //当月消费情况
//             $pay_check  = $m_mon->findAll('del=0 and cid='.$admin['cid'].' and status=1 and did='.$v['did'].' and adddt like "%'.$limit_time.'%"', '', 'paymoney');   //审核状态的消费
            
//             foreach ($pay as $_k => $_v){
//                 $sum = $sum + $_v['paymoney'];
//             }
//             foreach ($pay_check as $_ck => $_cv){
//                 $sum_c = $sum_c + $_cv['paymoney'];
//             }
            
//             $result['results'][$k] = $v;
//             $result['results'][$k]['realmoney'] = $sum;
            
//             //部门和公司统计
//             $all_depart = $model->findAll('del=0 and cid='.$admin['cid'].' and did='.$v['did'].'', '', 'id,budge_money');
//             $pay_depart = $m_mon->findAll('del=0 and cid='.$admin['cid'].' and status=1 and did='.$admin['did'].'', '', 'paymoney');   //部门预警
//             foreach ($all_depart as $__v){
//                 $sum_p = $sum_p + $__v['budge_money'];  //部门预算总价
//             }
//             foreach ($pay_depart as $p__v){
//                 $sum_dp = $sum_dp + $p__v['paymoney'];  //部门实付总价
//             }
//             if ($sum_p < $sum_dp){
//                 $result['results'][$k]['de_notice'] = '部门预警';
//             }else {
//                 $result['results'][$k]['de_notice'] = '';
//             }
            
//             if ($sum/$result['results'][$k]['budge_money'] > $result['results'][$k]['budge_prev']){
//                 $result['results'][$k]['budge_prev'] = '事前预警';
//             }
//             if ($sum/$result['results'][$k]['budge_money'] > $result['results'][$k]['budge_beyond']){
//                 $result['results'][$k]['budge_beyond'] = '超额预警';
//             }
//             if ($sum_c/$result['results'][$k]['budge_money'] > $result['results'][$k]['budge_prev']){
//                 $result['results'][$k]['budge_check'] = '审核预警';
//             }
            
//             $sum    = 0;
//             $sum_c  = 0;
//             $sum_d  = 0;
//             $sum_p  = 0;
//             $sum_dp = 0;
//         }
//         $this->returnSuccess('成功', $result);
//     }
    
    function budgeNotice()
    {
        $admin    = $this->islogin();
        $con      = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model    = spClass('m_budge');
        $m_mon    = spClass('m_custpay_mon');
        if (!empty($searchname)) {
            $con .= ' and concat(budge_name,dname) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        $sum = $sum_p = $sum_dp = 0;
        foreach($results as $k => $v){
            //对原来的月份日期做兼容
            if (strlen($v['budge_time']) > 8){
                $limit_time = substr($v['budge_time'], 0, 7);
            }else {
                $limit_time = $v['budge_time'];
            }
            
            $pay = $m_mon->findAll('del=0 and cid='.$admin['cid'].' and status=3 and did='.$v['did'].' and UNIX_TIMESTAMP(adddt)>'.strtotime(date($limit_time)).' and UNIX_TIMESTAMP(adddt)<'.(strtotime(date($limit_time)) + cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'))*24*60*60).'', '');   //当月消费情况
            foreach ($pay as $_k => $_v){
                $sum = $sum + $_v['payall'];    //实际总支出
            }
            //预算金额，实用金额，占用百分比 前端显示TODO
            $result['results'][$k] = $v;
            $result['results'][$k]['realmoney'] = $sum;
            $sum    = 0;
        }
        $this->returnSuccess('成功', $result);
    }
    
    
    /**
     * 删除预算分类
     */
    function budgeDel()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_budge', $id);
    }
    
    /**
     * 预算分类详情
     */
    function budgeInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_budge');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加预算分类
     */
    function saveBudge()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_budge');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'budge_name'   => '预算名称',
            'budge_status' => '预算状态',
            'budge_money'  => '预算金额',
//             'budge_prev'   => '事前控制',
//             'budge_beyond' => '超额控制',
//             'budge_check'  => '审核控制',
            'budge_control'=> '预算控制',
            'budge_desc'   => '',  //预算描述
            'did'          => '预算部门',
            'dname'        => '预算部门',
            'budge_time'   => '预算时间',
        );
        
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0, 'cid' => $admin['cid']));
            if(empty($re)) $this->returnError('分类不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['cid']     = $admin['cid'];
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
}

