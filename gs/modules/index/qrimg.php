<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class qrimg extends IndexController
{
    /**
     * qrimg页面的方法
     */
    function index()
    {
        $id = $this->spArgs('id');
        if (empty($id)) $this->msg_json(1, '非法参数');
        
        $result = spClass('m_equipment')->find(array('id' => $id));
        if (empty($result)) $this->msg_json(1, '设备不存在');
        
        if (!empty($result['files'])) {
            $m_file = spClass('m_file');
            $files  = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename,filepath');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        $this->equip_files = $result['files'];
//         $files       = urldecode($this->spArgs('file'));
//         $names       = urldecode($this->spArgs('file_name'));
//         $this->title = urldecode($this->spArgs('cname'));
//         $this->files = array_filter(explode('&', $files));
//         $this->names = array_filter(explode('&', $names));
    }

}
