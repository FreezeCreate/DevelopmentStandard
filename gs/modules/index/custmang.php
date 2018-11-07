<?php

class custmang extends IndexController
{
    
    
    function addmang()
    {
        $admin = $this->get_ajax_menu();
        $admin['cust_mang'] = spClass('m_custmang')->findAll();
//         $this->menu = $admin['menu'];
        $cust_name  = urldecode(htmlspecialchars($this->spArgs('cust_name')));

        $m_cust = spClass('m_custmang');
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        
        if (!empty($cust_name)) {
            $con .= ' and (cust_name like "%' . $cust_name . '%")';
            $page_con['cust_name'] = $cust_name;
        }
//         dump($con);die;
        
        $results        = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
//         dump($results);die;
        $this->results  = $results;
        $this->pager    = $m_cust->spPager()->getPager();
        $this->page_con = $page_con;
//         $this->result   = $admin;
    }
    
    function delCustmang()
    {
        
    }
    
    function custInfo()
    {
        
    }
    
}

