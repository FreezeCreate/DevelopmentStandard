<?php

class talkrecord extends AppController
{
    
    /**
     * 员工心态列表
     */
    function talkRcordLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_talkrecord');
        if (!empty($searchname)) {
            $con .= ' and concat(username,analysis) like "%' . $searchname . '%"';
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
     * 删除员工心态
     */
    function delTalkRecord()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_talkrecord', $id);
    }
    
    /**
     * 员工心态详情
     */
    function talkRecordInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_talkrecord');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加员工心态
     */
    function saveTalkRecord()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_talkrecord');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'userid'   => '员工',
            'username' => '员工',
            'analysis' => '心态分析',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('员工心态不存在');
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

