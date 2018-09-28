<?php

class devicedesc extends AppController
{
    
    /**
     * 固资设备报告列表
     */
    function index()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname'))); //按照计划标题查询
        $model     = spClass('m_device_desc');
        if (!empty($searchname)) {
            $con .= ' and concat(devicename,devicecatename,descname) like "%' . $searchname . '%"';
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
     * 删除固资设备报告
     */
    function delDeviceDesc()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_device_desc', $id);
    }
    
    /**
     * 固资设备报告详情
     */
    function deviceDescInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_device_desc');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 添加固资设备报告
     */
    function saveDeviceDesc()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_device_desc');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'type'           => '报告表种类',
            'deviceid'       => '固资设备id',
            'devicename'     => '固资设备名称',
//             'devicecateid'   => '设备分类id',
//             'devicecatename' => '设备分类名称',
            'descname'       => '标题',
            'content'        => '内容',
        );
        
        $data = $this->receiveData($arg);
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['status']    = 1;
        
        $device_data = spClass('m_device_desc')->find('id='.$data['deviceid']);
        $data['devicecateid'] = $device_data['device_cateid'];
        $data['devicename']   = $device_data['device_catename'];
        
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('固资设备报告不存在');
            $up = $model->update(array('id'=>$id),$data);
            if ($up) $up = $re['id'];
        }else{
            $up = $model->create($data);
        }
        
        if($up){
            $this->sendUpcoming($admin, 49, $up, '【'.$data['descname'].'】固资设备报告');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    
    
}

