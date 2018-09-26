<?php

class invoice extends AppController
{
    
    /**
     * 采购单列表-申请
     */
    function invoiceApply()
    {
        $admin        = $this->islogin();
        $con          = 'del=0 and cid = ' . $admin['cid'];
        $con         .= ' and status=1';
        $this->in_common($con);
    }
    
    /**
     * 采购单列表-statu=3
     */
    function index()
    {
        $admin        = $this->islogin();
        $con          = 'del=0 and cid = ' . $admin['cid'];
        $con         .= ' and status<>1';
        $this->in_common($con);
    }
    
    /**
     * 采购列表公共方法
     * @param unknown $con
     */
    function in_common($con)
    {
        if (empty($con)) $this->returnError('非法操作');
        $invoice_name = urldecode(htmlspecialchars($this->spArgs('invoice_name'))); //按照计划标题查询
        $year         = urldecode(htmlspecialchars($this->spArgs('year')));
        $month        = urldecode(htmlspecialchars($this->spArgs('month')));
        $day          = urldecode(htmlspecialchars($this->spArgs('day')));
        
        $model        = spClass('m_invoice');
        if (!empty($invoice_name)) {
            $con .= ' and (invoice_name = "' . $invoice_name . '")';
            $page_con['invoice_name'] = $invoice_name;
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
     * 删除采购单
     */
    function delInvoice()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_invoice', $id);
    }
    
    /**
     * 最近一次采购价格(即采购成功status=3)
     * 和商品详细
     * 且只有审核人能看
     */
    function lastBuy()
    {
        $admin    = $this->islogin();
        $id       = htmlspecialchars($this->spArgs('id'));    //此次id
        $bill     = spClass('m_flow_bill')->find('`table`="invoice" and tid='.$id, '', 'allcheckid');    //拿到所有审核人id
        $check_id = $this->delSpe($bill['allcheckid']);
        
        $arr_bill = explode(',', $check_id);
        if (in_array($admin['id'], $arr_bill)){
            $data    = spClass('m_invoice')->find('id='.$id.' and cid='.$admin['cid']);
            $sql     = 'select * from '.DB_NAME.'_invoice where UNIX_TIMESTAMP(buydate)<='.strtotime($data['buydate']).' and status=3 and cid='.$admin['cid'].' limit 1';
            $results = spClass('m_invoice')->findSql($sql);
//             dump(spClass('m_invoice')->dumpSql());die;
            //库房数量
            $room    = spClass('m_goods_order')->find('id='.$data['invoice_id']);
            $result['room']    = $room;
            $result['results'] = $results[0];
            $this->returnSuccess('成功', $result);
        }
        if (empty($result['results'])) $result['results'] = '';
        $this->returnError('失败');
    }
    
    /*
     * 采购汇总，按商品
     */
    function orderLst()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $order_name   = urldecode(htmlspecialchars($this->spArgs('order_name'))); //按照计划标题查询
        $year         = urldecode(htmlspecialchars($this->spArgs('year')));
        $month        = urldecode(htmlspecialchars($this->spArgs('month')));
        $day          = urldecode(htmlspecialchars($this->spArgs('day')));
        
        $model        = spClass('m_goods_order');
        $m_invoice    = spClass('m_invoice');
        if (!empty($order_name)) {
            $con .= ' and (order_name = "' . $order_name . '")';
            $page_con['order_name'] = $order_name;
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
        
        $sum = $mon = 0;
        foreach($results as $k=>$v){
            $in_order = $m_invoice->findAll('invoice_id='.$v['id']);
            foreach ($in_order as $_v){
                $sum = $sum + $_v['totalnum'];
                $mon = $_v['totalmoney'] - $_v['discount'] + $mon;
            }
            $result['results'][$k] = $v;
            $result['results'][$k]['order_sum'] = $sum; //该商品采购总数量
            $result['results'][$k]['all_money'] = $mon; //该商品采购实际总金额
            
            $mon = 0;
            $sum = 0;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 按商品详情
     */
    function orderInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_order');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $od_result  = spClass('m_invoice')->findAll('invoice_id='.$id);
        $result['od_result'] = $od_result;
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 采购汇总，按供应商
     */
    function supLst()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $company      = urldecode(htmlspecialchars($this->spArgs('company'))); //按照计划标题查询
        $year         = urldecode(htmlspecialchars($this->spArgs('year')));
        $month        = urldecode(htmlspecialchars($this->spArgs('month')));
        $day          = urldecode(htmlspecialchars($this->spArgs('day')));
        
        $model        = spClass('m_supplier');
        $m_invoice    = spClass('m_invoice');
        if (!empty($company)) {
            $con .= ' and (company = "' . $company . '")';
            $page_con['company'] = $company;
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
        
        $sum = $mon = 0;
        foreach($results as $k=>$v){
            $in_order = $m_invoice->findAll('buldid='.$v['id']);
            foreach ($in_order as $_v){
                $sum = $sum + $_v['totalnum'];
                $mon = $_v['totalmoney'] - $_v['discount'] + $mon;
                $one_proce = $_v['oneprice'];
            }
            $result['results'][$k] = $v;
            $result['results'][$k]['order_sum'] = $sum; //该商品采购总数量
            $result['results'][$k]['all_money'] = $mon; //该商品采购实际总金额
            $result['results'][$k]['one_price'] = $one_proce; //单价
            $one_proce = '';
            $mon = 0;
            $sum = 0;
        }
        $this->returnSuccess('成功', $result);
    }
    /**
     * 按供应商详情
     */
    function supInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_supplier');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $od_result  = spClass('m_invoice')->findAll('buldid='.$id);
        $result['od_result'] = $od_result;
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    
}

