<?php

class allcust extends AppController
{
    
    /**
     * 所有-潜在客户
     */
    function allLatentUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and flowid=1';
        $this->addmang($con);
    }
    /**
     * 所有-跟进客户
     */
    function allFlowUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and flowid=2';
        $this->addmang($con);
    }
    /**
     * 所有-签约客户
     */
    function allSignUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and flowid=3';
        $this->addmang($con);
    }
    
    /**
     * 合同选择所有用户方法
     */
    function chooseUser()
    {
        $admin   = $this->islogin();
        $con     = 'del = 0 and cid = ' . $admin['cid'];
        $result['results'] = spClass('m_custmang')->findAll('del=0 and cid='.$admin['cid'].'', 'id desc', 'id,cust_name');
        if (empty($result['results'])) $this->returnError('失败');
        $this->returnSuccess('失败', $result);
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
        $admin['cust_mang']  = spClass('m_custmang')->findAll();
        $searchname          = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_admin             = spClass('m_admin');
        $m_cate              = spClass('m_cust_cate');
        $m_cust              = spClass('m_custmang');
        
        if (!empty($searchname)) {
            $con .= ' and concat(cust_name,type,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
//             $con .= ' and (cust_name like "%' . $cust_name . '%")';
            $page_con['searchname'] = $searchname;
        }
        
        //pagenum
        //         $results        = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
//         $this->results  = $results;
//         $this->pager    = $m_cust->spPager()->getPager();
//         $this->page_con = $page_con;
        
        $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'noticetime desc,birth desc');
        $pager   = $m_cust->spPager()->getPager();
//         $page    = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['pager'] = $pager;
        
        foreach ($results as $_k => $_v){
            $record = spClass('m_cust_record')->findSql('select addtime,status,`explain` from '.DB_NAME.'_cust_record where fid='.$_v['id'].' order by id desc limit 1');
            if ($record){
                $results[$_k]['record_addtime'] = $record[0]['addtime'];
                $results[$_k]['record_status']  = $record[0]['status'];
                $results[$_k]['record_explain']  = $record[0]['explain'];
            }else {
                $results[$_k]['record_addtime'] = '';
                $results[$_k]['record_status']  = '';
                $results[$_k]['record_explain']  = '';
            }
        }
        
        foreach($results as $k=>$v){
//             $result['results'][$k] = $v;    //TODO 渲染所有数据 + 重写api文档 + 重构postman数据
            $notic = '';
            $salename = $m_admin->find('id='.$v['saleid'], '', 'id,name');
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
            $cust_cate = $m_cate->find('id='.$v['type'], '', 'catename');
            
            $result['results'][$k] = array(
                'id'         => $v['id'],
                'cust_name'  => $v['cust_name'],
                'custdname'  => $v['custdname'],
                'phone'      => $v['phone'],
                'sex'        => $v['sex'],
                'age'        => $v['age'],
                'address'    => $v['address'],
                'noticetime' => $v['noticetime'],
                'noticecontent' => $notic,
                'flowid'     => $v['flowid'],
                'salename'   => $salename['name'],
                'record_status'  => $v['record_status'],    //跟进情况
                'record_addtime' => $v['record_addtime'],    //最新跟进时间
                'record_explain' => $v['record_explain'],    //最新跟进时间
                'cust_cate'  => $cust_cate['catename'], //列表显示客户类型
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
}

