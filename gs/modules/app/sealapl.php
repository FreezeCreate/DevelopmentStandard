<?php

class sealapl extends AppController
{
    
    /**
     * 印章申请列表
     */
    function sealAplLst()
    {
        $admin    = $this->islogin();
        $con      = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model    = spClass('m_sealapl');
        if (!empty($searchname)) {
            $con .= ' and concat(uname,applydt,sealname,number) like "%' . $searchname . '%"';
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
     * 删除印章申请
     */
    function delSealApl()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_sealapl', $id);
    }
    
    /**
     * 印章申请详情
     */
    function sealAplInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_sealapl');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加印章申请
     */
    function saveSealApl()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_sealapl');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'uid'      => '印章申请人',
            'uname'    => '印章申请人',
            'applydt'  => '申请日期',
            'explain'  => '说明',
            'sealid'   => '印章id',
            'sealname' => '印章名称',
        );
        $data = $this->receiveData($arg);
        $data['isout']     = (int)htmlentities($this->spArgs('isout')); //是否外带
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $files = $this->spArgs('files');
        if ($files) $data['files'] = implode(',', $files);
        
        $data['number'] = 'S'.time().rand(0, 100);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0, 'cid' => $admin['cid']));
            if(empty($re)) $this->returnError('印章申请不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

