<?php

class talkrecordana extends AppController
{
    
    
    /**
     * 沟通记录详情
     */
    function talkRecordAnaInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_talkrecord_ana');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->findAll('tkid='.$id.' and cid='.$admin['cid'].' and del=0');
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加沟通记录
     */
    function saveTalkRecordAna()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_talkrecord_ana');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'tkid'      => '心态分析',
            'userid'    => '员工',
            'anarecord' => '沟通记录',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('沟通记录不存在');
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

