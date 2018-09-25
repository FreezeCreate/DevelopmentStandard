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
        $searchname   = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model        = spClass('m_regoods');
        $m_goods      = spClass('m_goods_order');
        if (!empty($searchname)) {
            $con .= ' and concat(renum,invoice_num,renumber,remoney,recompany,addname) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $goods = $m_goods->find('id='.$v['invoice_id']);
//             dump($goods);die;
            $result['results'][$k] = $v;
            $result['results'][$k]['goods_name'] = $goods['order_name'];
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

