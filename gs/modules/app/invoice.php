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
     * 采购单明细列表
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
        
        $con         .= ' and status=1';    //采购status=1
        $model        = spClass('m_goods_inout');
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
        
        $sql = 'select id,goods_id,goods_name,goods_unit,room_name,optdt,sum(goods_num) as all_num,sum(buyprice) as all_price from '.DB_NAME.'_goods_inout where '.$con.' group by goods_id';
        //SELECT goods_id,count(goods_num) as real_num FROM `yld_goods_inout` WHERE del=0 group by goods_id
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql,'optdt desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        //用sql代替了
//         $sum = $mon = 0;
//         foreach($results as $k=>$v){
//             $in_order = $m_invoice->findAll('invoice_id='.$v['id']);
//             foreach ($in_order as $_v){
//                 $sum = $sum + $_v['totalnum'];
//                 $mon = $_v['totalmoney'] - $_v['discount'] + $mon;
//             }
//             $result['results'][$k] = $v;
//             $result['results'][$k]['order_sum'] = $sum; //该商品采购总数量
//             $result['results'][$k]['all_money'] = $mon; //该商品采购实际总金额
            
//             $mon = 0;
//             $sum = 0;
//         }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 按商品详情 无详情，数据太多无法显示，或者列表显示 必须传goods_id
     */
    function orderInfo()
    {
        $admin      = $this->islogin();
        $m_inout    = spClass('m_goods_inout');
        $model      = spClass('m_goods');
        // 必须传goods_id
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and del=0 and cid='.$admin['cid'].'');
        if (empty($results)) $this->returnError('id非法');
        $od_result  = $m_inout->findAll('goods_id='.$id.' and del=0 and cid='.$admin['cid']);
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
        $con         .= ' and status=3';    //采购status=1
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
        
        $sql     = 'select id,buldid,optdt,buldcom,sum(totalmoney) as all_price,sum(paymoney) as pay_price from '.DB_NAME.'_invoice where '.$con.' group by buldid';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql,'optdt desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        $result['results'] = $results;
        foreach ($results as $k => $v){
            $result['results'][$k]['company'] = $model->find('id='.$v['buldid'].' and del=0 and cid='.$admin['cid'].'');
        }
        //sql已经覆盖了该功能
//         $sum = $mon = 0;
//         foreach($results as $k=>$v){
//             $in_order = $m_invoice->findAll('buldid='.$v['id']);
//             foreach ($in_order as $_v){
//                 $sum = $sum + $_v['totalnum'];
//                 $mon = $_v['totalmoney'] - $_v['discount'] + $mon;
//                 $one_proce = $_v['oneprice'];
//             }
//             $result['results'][$k] = $v;
//             $result['results'][$k]['order_sum'] = $sum; //该商品采购总数量
//             $result['results'][$k]['all_money'] = $mon; //该商品采购实际总金额
//             $result['results'][$k]['one_price'] = $one_proce; //单价
//             $one_proce = '';
//             $mon = 0;
//             $sum = 0;
//         }
        $this->returnSuccess('成功', $result);
    }
    /**
     * 按供应商详情 库存积压TO DO 商品详情
     */
    function supInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_supplier');
        $m_inout    = spClass('m_goods_inout');
        
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and del=0 and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $od_result  = spClass('m_invoice')->findAll('buldid='.$id);
        
        $sup_data = array();
        foreach ($od_result as $k => $v){
            $sup_data[] = $m_inout->find('status=1 and del=0 and cid='.$admin['cid'].' and invoice_id='.$v['id'].'');
        }
        $result['od_result'] = $sup_data;
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 点击采购单显示多条商品列表
     */
    function invoiceGoodsLst()
    {
        $admin     = $this->islogin();
        $id        = (int)htmlentities($this->spArgs('id'));
        $con       = 'del=0 and cid = ' . $admin['cid'];
        $con      .= ' and status=1 and invoice_id='.$id.'';
        $model     = spClass('m_goods_inout');
        $result['results']    = $model->findAll($con);
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 采购退货单商品详情
     */
    function invoiceGoodsInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_inout');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 采购退货单商品详情
     */
    function churuGoodsInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_stock_inout');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 采购/退货对库存的影响
     */
    function updateWare()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_inout');
        $m_order    = spClass('m_goods_order');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        $this->emptyNotice($id, 'id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        $this->emptyNotice($results, '数据不存在或已经被删除');
        
        if ($_POST){
            $arg = array(
                'id'         => '商品id',
                'goods_unit' => '',
                'goods_num'  => '',
                'content'    => '',
                'status'     => '',    //1、采购2、退货、3、入库、4、出库
            );
            $data = $this->receiveData($arg);
            $up   = $model->update(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), $data);
            if (!$up) $this->returnError('更新失败');
            
            //TODO 对库存的影响
            if ($data['status'] == 1){  //采购
                $m_thing = $m_order->find(array('goods_id' => $results['goods_id'], 'stock_id' => $results['room_id']));
                $num = $m_thing['order_num'] + ($data['goods_num'] - $results['goods_num']);
            }else { //退货
                $m_thing = $m_order->find(array('goods_id' => $results['goods_id'], 'stock_id' => $results['room_id']));
                $num = $m_thing['order_num'] - ($data['goods_num'] - $results['goods_num']);
            }
            $m_order->update(array('goods_id' => $results['goods_id'], 'stock_id' => $results['room_id']), array('order_num' => $num));    //库存的更新
            
        }
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
}

