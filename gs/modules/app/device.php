<?php

class device extends AppController
{
    
    /**
     * 固资设备列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_device');
        if (!empty($searchname)) {
            $con .= ' and concat(device_name,device_catename,device_info,device_lie_date) like "%' . $searchname . '%"';
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
     * 删除固资设备
     */
    function delDevice()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_device', $id);
    }
    
    /**
     * 固资设备详情
     */
    function deviceInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_device');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加固资设备
     */
    function saveDevice()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_device');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'device_name'     => '固资设备名',
            'device_cateid'   => '设备分类',
            'device_catename' => '设备分类',
            'device_info'     => '详细信息',
            'device_lie'      => '闲置',
            'device_lie_date' => '',  //闲置日期
        );
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('固资设备不存在');
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 超过闲置期设备列表
     */
    function lieDeviceLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $device_name = urldecode(htmlspecialchars($this->spArgs('device_name'))); //按照计划标题查询
        $model     = spClass('m_device');
        if (!empty($device_name)) {
            $con .= ' and (device_name = "' . $device_name . '")';
            $page_con['device_name'] = $device_name;
        }
        $sql     = 'select * from '.DB_NAME.'_device where UNIX_TIMESTAMP(device_lie_date)<'.time().' and '.$con.' order by id desc';
        
//         $con .= ' and lie_date<'.date('Y-m-d H:i:s').'';
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    
}

