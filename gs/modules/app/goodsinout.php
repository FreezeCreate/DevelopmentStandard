<?php

class goodsinout extends AppController
{
    
    /**
     * 该笔进退货单的列表(根据id)
     */
    function inOutLst()
    {
        $admin        = $this->islogin();
        $con          = 'del = 0 and cid = ' . $admin['cid'];
        $model        = spClass('m_goods_inout');
        $id           = htmlspecialchars($this->spArgs('id'));
        
        $results = $model->findAll('invoice_id='.$id.' and del=0 and cid='.$admin['cid'].'');
        $this->emptyNotice($results, '该数据不存在');
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    
    /**
     * 详情
     */
    function inOutInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_inout');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        $this->emptyNotice($id, 'id不存在');
        $results    = $model->find('id='.$id.' and del=0 and cid='.$admin['cid']);
        $this->emptyNotice($results, 'id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加进退货单的单个商品记录
     */
    function saveGoodsInOut()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_goods_inout');
        $id              = (int)htmlentities($this->spArgs('id'));
        $m_goods         = spClass('m_goods_order');
        
        //status=1 采购单 status=2 退货单
        $arg = array(
            'invoice_id'    => '单号id',  //采购单或者进货单id,由status来判断是什么类型的单
            'goods_id'      => '商品',
//             'goods_name'    => '商品',
            'goods_unit'    => '单位',
            'room_id'       => '库房',
            'goods_num'     => '数量',
            'goods_price'   => '单价',
            'discount'      => '',  //折扣率
            'discountprice' => '',  //折扣额
            'buyprice'      => '购货金额',
            'content'       => '',  //备注
            'status'        => '',
        );
        
        $data = $this->receiveData($arg);
        //goods_name新增
        $goods_name = $m_goods->find('id='.$data['goods_id'].' and del=0 and cid='.$admin['cid'].'', '', 'order_name');
        if (empty($goods_name)) $this->returnError('该商品不存在');
        $data['goods_name'] = $goods_name['order_name'];
        
        if($id){
            $re   = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            $up   = $model->update(array('id'=>$id),$data);
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

