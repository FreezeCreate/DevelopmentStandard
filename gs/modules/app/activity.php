<?php

class activity extends AppController
{
    
    /**
     * 活动列表
     */
    function activityLst()
    {
        $admin    = $this->islogin();
        $con      = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model    = spClass('m_activity');
        if (!empty($searchname)) {
            $con .= ' and concat(title,type,startdt,enddt) like "%' . $searchname . '%"';
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
     * 删除活动
     */
    function delActivity()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_activity', $id);
    }
    
    /**
     * 活动详情
     */
    function activityInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_activity');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加活动
     */
    function saveActivity()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_activity');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'title'   => '活动主题',
            'type'    => '活动类别',
            'startdt' => '开始日期',
            'enddt'   => '结束日期',
            'actwhere'=> '活动地点',
            'actneed' => '', //活动所需
            'actback' => '', //活动背景
            'actline' => '',    //活动线路说明
            'paywill' => '预算费用',
            'payfact' => '实际费用',
        );
        $data = $this->receiveData($arg);
        
        $files = $this->spArgs('files');
        if ($files) $data['files'] = implode(',', $files);
        
        if($id){
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']));
            if(empty($re)) $this->returnError('活动不存在');
            
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

