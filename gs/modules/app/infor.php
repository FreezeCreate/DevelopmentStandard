<?php

class infor extends AppController
{
    
    /**
     * 通知公告列表
     */
    function inforLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_infor');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'date desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除通知公告
     */
    function delInfor()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_infor', $id);
    }
    
    /**
     * 通知公告详情
     */
    function inforInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_infor');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加通知公告
     */
    function saveInfor()
    {
        $admin            = $this->islogin();
        $data['title']    = htmlspecialchars($this->spArgs('title'));
        $data['receid']   = trim(htmlspecialchars($this->spArgs('receid')), ',');
        $data['recename'] = trim(htmlspecialchars($this->spArgs('recename')), ',');
        $data['adddt']    = trim(htmlspecialchars($this->spArgs('adddt')), ',');
        $data['content']  = htmlspecialchars($this->spArgs('content'));
        $m_infor          = spClass('m_infor');
        
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['date']      = date('Y-m-d H:i:s');
        
        $up = $m_infor->create($data,$admin);
        
        //TODO 发送给接收人
        
        if ($up){
            $this->sendMsgNotice($admin, 1, $up, '【通知公告】'.$data['title'].'', 2);
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    
    
}

