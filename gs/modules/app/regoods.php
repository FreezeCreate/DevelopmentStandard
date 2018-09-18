<?php

class regoods extends AppController
{
    
    /**
     * 退货单列表
     */
    function index()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $searchname        = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model        = spClass('m_regoods');
        if (!empty($searchname)) {
            $con .= ' and concat(renum,invoice_num,renumber,remoney,recompany,addname) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
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
     * 删除退货单
     */
    function delRegoods()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_regoods', $id);
    }
    
    
}

