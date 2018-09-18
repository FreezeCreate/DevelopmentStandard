<?php

class stockroom extends AppController
{
    
    /**
     * 库房列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_stock_room');
        if (!empty($searchname)) {
            $con .= ' and concat(room_name,room_desc) like "%' . $searchname . '%"';
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
     * 删除库房
     */
    function delStockRoom()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_stock_room', $id);
    }
    
    /**
     * 库房详情
     */
    function stockRoomInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_stock_room');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加库房
     */
    function saveStockRoom()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_stock_room');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'room_name' => '库房名称',
            'room_desc' => '',
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('库房不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    
}

