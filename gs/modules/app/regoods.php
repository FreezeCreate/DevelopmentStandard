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
    
    /**
     * 点击采购单显示多条商品列表
     */
    function reGoodsLst()
    {
        $admin     = $this->islogin();
        $id        = (int)htmlentities($this->spArgs('id'));
        $con       = 'del=0 and cid = ' . $admin['cid'];
        $con      .= ' and status=2 and invoice_id='.$id.'';
        $model     = spClass('m_purchase_caigou_mater');
        $result['results']     = $model->findAll($con);
        
        foreach($result['results'] as $k=>$v){
            $result['results'][$k] = $v;
            $result['results'][$k]['goods_name'] = $v['name'];
            $result['results'][$k]['content']    = $v['explain'];
            $result['results'][$k]['goods_unit'] = $v['format'];
            $result['results'][$k]['goods_num']  = $v['num'];
        }
        $this->returnSuccess('成功', $result);
    }
    
}

