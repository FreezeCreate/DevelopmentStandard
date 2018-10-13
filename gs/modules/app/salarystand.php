<?php

class salarystand extends AppController
{
    
    /**
     * 薪资标准列表
     * 没有员工的排前,即部门在前
     */
    function salaryStandLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname= urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_salarystand');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'admid asc');  //根据部门排序
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除薪资标准
     */
    function delSalaryStand()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_salarystand', $id);
    }
    
    /**
     * 薪资标准详情
     */
    function salaryStandInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_salarystand');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加薪资标准
     */
    function saveSalaryStand()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_salarystand');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'depid'   => '', //部门id
            'depname' => '', //部门名称
            'admid'   => '', //用户id
            'admname' => '', //用户名称
            'salary'  => '', //金额标准
            'stdesc'  => '', //描述
        );
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('薪资标准不存在');
            
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

