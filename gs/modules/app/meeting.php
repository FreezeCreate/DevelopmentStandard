<?php

class meeting extends AppController
{
    
    /**
     * 会议列表
     */
    function meetingLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_meeting');
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
     * 删除会议
     */
    function delMeeting()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_meeting', $id);
    }
    
    /**
     * 会议详情
     */
    function meetingInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_meeting');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加会议
     */
    function saveMeeting()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_meeting');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'recordid'   => '会议纪要人',
            'recordname' => '会议纪要人',
            'title'      => '主题',
            'meetperson' => '参会人',
            'meetdesc'   => '会议内容',   //会议内容
            'startdt'    => '开始时间',
            'enddt'      => '结束时间',
        );
        $data = $this->receiveData($arg);
        
        $files = $this->spArgs('files');    //文件处理
        if ($files) $data['files'] = implode(',', $files);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('会议不存在');
            
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

