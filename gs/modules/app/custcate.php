<?php

class custcate extends AppController
{
    
    /**
     * 客户分类列表
     */
    function index()
    {
        $admin    = $this->islogin();
        $con      = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model    = spClass('m_cust_cate');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = array(
                'id'          => $v['id'],
                'catename'    => $v['catename'],
                'catedesc'    => $v['catedesc'],
                'applyid'     => $v['applyid'],
                'applyname'   => $v['applyname'],
                'applydt'     => $v['applydt'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除客户分类
     */
    function delCustCate()
    {
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_cust_cate')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    /**
     * 客户分类详情
     */
    function custCateInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_cust_cate');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加客户分类
     */
    function saveCustCate()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_cust_cate');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'catename'   => '客户类型',
            'catedesc'   => '',
            'cateability'=> '',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['applyid']   = $admin['id'];
        $data['applyname'] = $admin['name'];
        $data['applydt']   = date('Y-m-d H:i:s');
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0, 'cid' => $admin['cid']));
            if(empty($re)) $this->returnError('分类不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

