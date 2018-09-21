<?php

class relation extends AppController
{
    
    /**
     * 员工关系管理列表
     */
    function relationLst()
    {
        $admin      = $this->islogin();
        $con        = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model      = spClass('m_relation');
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
     * 员工关系管理删除
     */
    function delRelation()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_relation', $id);
    }
    
    /**
     * 员工关系管理详情
     */
    function relationInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_relation');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加员工关系管理
     */
    function saveRelation()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_relation');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'userid'     => '员工',
            'username'   => '员工',
            'title'      => '标题',
            'redesc'     => '',   //内容
            'noticetime' => '重要日子提醒时间',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('该员工关系管理不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

