<?php

class dailywork extends AppController
{
    
    /**
     * 我的-工作计划列表
     */
    function mydaily()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $con      .= ' and workid='.$admin['id'];
        $this->dailyCommon($con);
    }
    
    /**
     * 所有-工作计划列表
     */
    function alldaily()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $this->dailyCommon($con);
    }
    
    /*
     * 工作计划公共方法
     */
    function dailyCommon($con)
    {
        if (empty($con)) $this->returnError('非法输入');
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_work_deal');
        if (!empty($searchname)) {
            $con .= ' and concat(workname,workstart,workend,worktitle,workdname,workspeed,goal) like "%' . $searchname . '%"';
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
     * 删除工作计划
     */
    function delDailyWork()
    {
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_work_deal')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    /**
     * 工作计划详情
     */
    function dailyWorkInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_work_deal');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加工作计划
     */
    function saveDailyWork()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_work_deal');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'workid'      => '计划人',
            'workname'    => '计划人',
            'workstart'   => '开始日期',
            'workend'     => '结束日期',
            'workstatus'  => '完成度',   //1、已完成2、未完成3、未开始
            'worktitle'   => '计划标题',
            'workcontent' => '计划内容',
            'workspeed'   => '',    //计划速度
            'goal'        => '',    //计划目标
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['workdname'] = $admin['dname'];
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('分类不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

