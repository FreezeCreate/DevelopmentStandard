<?php

class manageuser extends AppController
{
    
    /**
     * 奖罚管理列表
     */
    function manageUserLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_manageuser');
        if (!empty($searchname)) {
            $con .= ' and concat(dealname,dealcontent) like "%' . $searchname . '%"';
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
     * 奖罚管理删除
     */
    function delmanageUser()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_manageuser', $id);
    }
    
    /**
     * 奖罚管理详情
     */
    function manageUserInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_manageuser');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加奖罚管理
     */
    function saveManageUser()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_manageuser');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'dealid'   => '操作人',
            'dealname' => '操作人',
            'type'     => '奖罚类型',
            'salary'   => '',   //奖罚金额
            'dealdate' => '处理日期',
            'dealcontent' => '',    //处理内容
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('该管理不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

