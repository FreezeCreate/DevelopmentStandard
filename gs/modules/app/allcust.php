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
        $con   .= ' and flowid=2';
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
        $admin['cust_mang'] = spClass('m_custmang')->findAll();
        $searchname          = urldecode(htmlspecialchars($this->spArgs('searchname')));

        $m_cust = spClass('m_custmang');
        
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
        $sale    = spClass('m_admin')->findAll('', 'id desc', 'id,username');
        
        $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
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
            $salename = spClass('m_admin')->find('id='.$v['saleid'], '', 'id,username');
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
                'flowid'     => $v['flowid'],
                'salename'   => $salename['username'],
                'record_status'  => $v['record_status'],    //跟进情况
                'record_addtime' => $v['record_addtime'],    //最新跟进时间
                'record_explain' => $v['record_explain'],    //最新跟进时间
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
}

