<?php

class goods extends AppController
{
    
    /**
     * 商品列表
     */
    function index()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $order_name   = urldecode(htmlspecialchars($this->spArgs('order_name'))); //按照计划标题查询
        $model        = spClass('m_goods');
        $year         = urldecode(htmlspecialchars($this->spArgs('year')));
        $month        = urldecode(htmlspecialchars($this->spArgs('month')));
        $day          = urldecode(htmlspecialchars($this->spArgs('day')));
        
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
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 商品和分类单选框接口
     */
    function cateForGoods()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_goods');
        $m_cate  = spClass('m_goods_order_cate');
        $cate = $m_cate->findAll('cid='.$admin['cid'].' and del=0');
        foreach ($cate as $k => $v) {
            $results[$k]['name'] = $v['catename'];
            $results[$k]['children'] = $model->findAll('cid='.$admin['cid'].' and del=0 and cateid='.$v['id'].'', '', 'id,order_name');
            foreach ($results[$k]['children'] as $_k => $_v){
                $results[$k]['children'][$_k]['name'] = $results[$k]['children'][$_k]['order_name'];
                unset($results[$k]['children'][$_k]['order_name']);
            }
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除商品
     */
    function delGoodsOrder()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_goods', $id);
    }
    
    /**
     * 商品详情
     */
    function goodsOrderInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加商品
     */
    function saveGoodsOrder()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_goods');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'cateid'        => '商品分类',
            'order_name'    => '',  //商品名称
            'order_spec'    => '',  //规格
            'order_unit'    => '',  //单位
            'order_num'     => '',  //商品数量
            'order_explain' => '',  //备注
            'updatetime'    => '',  //积压时间
        );
        $data = $this->receiveData($arg);
        $cate_data = spClass('m_goods_order_cate')->find('id='.$data['cateid'].' and del=0 and cid='.$admin['cid'].'');
        $this->emptyNotice($cate_data, '类别不存在或已删除');
        $data['catename'] = $cate_data['catename'];
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('商品不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

