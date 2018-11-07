<?php

class pxjl extends AppController
{
    
    /**
     * 培训列表
     */
    function pxjlLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname= urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_pxjl');
        if (!empty($searchname)) {
            $con .= ' and concat(title,number,depname,username,date,enddate,lector,theme,) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'id desc,optdt desc');  //根据部门排序
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除培训
     */
    function delPxjl()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_pxjl', $id);
    }
    
    /**
     * 培训详情
     */
    function pxjlInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_pxjl');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid'].' and del=0');
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加培训
     */
    function savePxjl()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_pxjl');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'title'    => '标题',
            'depid'    => '部门', //部门id
            'depname'  => '部门', //部门名称
            'userid'   => '', //用户id
            'username' => '', //用户名称
            'date'     => '培训开始日期', //用户名称
            'enddate'  => '培训结束日期', //用户名称
            'lector'   => '', //讲师
            'theme'    => '', //主题
            'zongjie'  => '', //总结
            'pstatus'  => '', //培训状态1、入职培训2、进阶培训
        );
        $data = $this->receiveData($arg);
        
        $files = $this->spArgs('files');
        if ($files) $data['files'] = implode(',', $files);
        
        $sum   = $model->findCount('number like "%T'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        $data['number']  = 'T'.date('Ymd').$sum;
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('培训不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $data['status']    = 1;
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 31, $up, '【'.$data['title'].'】培训管理');
            
            $this->sendMsgNotice($admin, 31, $up, '【'.$data['title'].'】培训管理');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    
    
}

