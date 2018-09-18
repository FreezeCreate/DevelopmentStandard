<?php

class invoice extends AppController
{
    
    /**
     * 采购单列表
     */
    function index()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
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
            $sql     = 'select * from '.DB_NAME.'_invoice where UNIX_TIMESTAMP(buydate)<'.strtotime($data['buydate']).' and status=3 and cid='.$admin['cid'].' limit 1';
            $results = spClass('m_invoice')->findSql($sql);
            
            //库房数量
            $room    = spClass('m_goods_order')->find('id='.$data['invoice_id']);
            $result['room']    = $room;
            $result['results'] = $results[0];
            $this->returnSuccess('成功', $result);
        }
        $this->returnError('失败');

    }
    
    
}

