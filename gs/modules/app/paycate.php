<?php

class paycate extends AppController
{
    
    /**
     * 用款类型列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_paycate');
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
     * 删除用款类型
     */
    function delPayCate()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_paycate', $id);
    }
    
    /**
     * 用款类型详情
     */
    function payCateInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_paycate');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加用款类型
     */
    function savePayCate()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_paycate');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'catename' => '类型名称',
            'catedesc' => '',
            'paydid'   => '',
            'paydname' => '',
            'quota'    => '',
        );
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('分类不存在');
            
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

