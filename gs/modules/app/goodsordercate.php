<?php

class goodsordercate extends AppController
{
    
    /**
     * 商品类别列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_goods_order_cate');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
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
     * 删除商品类别
     */
    function delGoodsOrderCate()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_goods_order_cate', $id);
    }
    
    /**
     * 商品类别详情
     */
    function goodsOrderCateInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_goods_order_cate');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加商品类别
     */
    function saveGoodsOrderCate()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_goods_order_cate');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'catename' => '类型名称',
            'catedesc' => '',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('分类不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

