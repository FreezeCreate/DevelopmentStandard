<?php

class custinfocall extends AppController
{
    
    /**
     * 客户信息提醒列表
     */
    function index()
    {
        $admin      = $this->islogin();
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_custmang = spClass('m_custmang');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(cust_name,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $sql = 'select * from '.DB_NAME.'_custmang where '.$con.' and (noticetime!=0000-00-00 or retime!=0000-00-00 or birth!=0000-00-00) order by applydt desc';
//         $res = $m_custmang->findSql($sql);
        
//         $results = $m_custmang->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        
//         $pager   = $m_custmang->spPager()->getPager();
//         $page    = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
//         $result['page'] = $page;
        
        $results = $m_custmang->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $m_custmang->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 客户信息提醒
     * TODO index方法列出了需要提醒的客户数据和id
     */
    function custNotice()
    {
        
    }
    
    
}

