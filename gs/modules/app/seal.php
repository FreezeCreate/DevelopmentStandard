<?php

class seal extends AppController
{
    
    /**
     * 印章列表
     */
    function sealLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_seal');
        if (!empty($searchname)) {
            $con .= ' and concat(name,type,uname) like "%' . $searchname . '%"';
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
     * 删除印章
     */
    function delSeal()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_seal', $id);
    }
    
    /**
     * 印章详情
     */
    function sealInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_seal');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加印章
     */
    function saveSeal()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_seal');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'name'    => '印章名称',
            'type'    => '印章类型',
            'uid'     => '保管人',
            'uname'   => '保管人',
            'explain' => '',    //说明
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        $files = $this->spArgs('files');
        if ($files) $data['files'] = implode(',', $files);  //图片
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('印章不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

