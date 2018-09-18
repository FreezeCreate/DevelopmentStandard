<?php

class devicedesccheck extends AppController
{
    
    /**
     * 验收报告列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname      = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_devicedesc_check');
        if (!empty($searchname)) {
            $con .= ' and concat(name,checkname) like "%' . $searchname . '%"';
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
     * 删除验收报告报告
     */
    function delDeviceDesc()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_devicedesc_check', $id);
    }
    
    /**
     * 验收报告报告详情
     */
    function deviceDescCheckInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_devicedesc_check');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加验收报告报告
     */
    function saveDeviceDescCheck()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_devicedesc_check');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'name'      => '标题',
            'content'   => '内容',
            'checkid'   => '汇报报告id',
            'checkname' => '汇报报告内容',
            'status'    => '验收状态',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('验收报告不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

