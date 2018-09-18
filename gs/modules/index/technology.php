<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class technology extends IndexController {
    
    function quotation(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_quotation');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            if($status==2){
                $con .= ' and b.status in(0,2)';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (number like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a left outer join '.DB_NAME.'_quotation as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function quotationInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 2);
        $result = $this->result;
        
        if($result){
            $result['children'] = spClass('m_quo_project')->findAll(array('pid'=>$id));
            foreach($result['children'] as $k=>$v){
                $result['children'][$k]['children'] = spClass('m_pro_mater')->findAll(array('pid'=>$v['qid']));
            }
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function editQuotation(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_quotation');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        $this->project = spClass('m_project')->findAll();
        if($result){
            $ids = empty($result['files'])?'0':$result['files'];
            $result['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
            $result['children'] = spClass('m_quo_project')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function saveQuotation(){
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['contact'] = htmlspecialchars($this->spArgs('contact'));
        $data['tel'] = htmlspecialchars($this->spArgs('tel'));
        $data['fax'] = htmlspecialchars($this->spArgs('fax'));
        $data['pname'] = htmlspecialchars($this->spArgs('pname'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $id = (int)htmlentities($this->spArgs('id'));
        $mid = $this->spArgs('mid');
        $mprice = $this->spArgs('mprice');
        $mnum = $this->spArgs('mnum');
        $files = $this->spArgs('files');
        $data['files'] = empty($files)?'':implode(',', $files);
        $m_quotation = spClass('m_quotation');
        $m_quo_project = spClass('m_quo_project');
        $m_project = spClass('m_project');
        if(empty($data['number'])){
            $this->msg_json(0, '请输入文件编号');
        }
        if(empty($data['name'])){
            $this->msg_json(0, '请输入工程名称');
        }
        if(empty($mid)){
            $this->msg_json(0, '请选择报价信息');
        }
        $project = $m_project->findAll('id in('.implode(',', $mid).')');
        $data['money'] = 0;
        foreach($project as $k=>$v){
            $project[$k]['num'] = $mnum[$v['id']];
            $project[$k]['price'] = $mprice[$v['id']];
            $project[$k]['qid'] = $v['id'];
            $project[$k]['pid'] = $id;
            $project[$k]['money'] = $mnum[$v['id']]*$mprice[$v['id']];
            $data['money'] += $mnum[$v['id']]*$mprice[$v['id']];
            unset($project[$k]['id']);
        }
        $data['uid'] = $admin['id'];
        $data['uname'] = $admin['name'];
        $data['unumber'] = $admin['number'];
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['date'] = date('Y-m-d');
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if($id){
            $re = $m_quotation->find(array('id'=>$id));
            if(empty($re)){
                $this->msg_json(0, '数据不存在');
            }
            if($re['status']>2){
                $this->msg_json(0, '该报价单已通过审核，不可编辑');
            }
            $up = $m_quotation->update(array('id'=>$id),$data);
            if($up){
                $m_quo_project->updateAll(array('pid'=>$id),$project);
                $this->sendUpcoming(2, $id, '【'.$data['name'].'】报价单');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $data['cid'] = $admin['cid'];
            $ad = $m_quotation->create($data);
            if($ad){
                foreach($project as $k=>$v){
                    $project[$k]['pid'] = $ad;
                }
                $m_quo_project->createAll($project);
                $this->sendUpcoming(2, $id, '【'.$data['name'].'】报价单');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }
    
    //导入报价单
    function importExcel() {
        $admin = $this->get_ajax_menu();
        $m_quotation = spClass('m_quotation');
        $m_quo_project = spClass('m_quo_project');
        $id = (int)htmlentities($this->spArgs('id'));
        $re = $m_quotation->find(array('id'=>$id));
        if(empty($re)){
            $this->msg_json(0, '数据有误');
        }
        $filename = APP_PATH . '/tmp/' . $this->spArgs('filename');
        header("Content-Type:text/html;charset=utf-8");
        require_once 'PHPExcel/IOFactory.php';
        //部分加载
//        $fileType = PHPExcel_IOFactory::identify($filename);
//        $objReader = PHPExcel_IOFactory::createReader($fileType);
//        $sheetName = array("Worksheet 2");
//        $objReader->setLoadSheetsOnly($sheetName);
//        $objPHPExcel = $objReader->load($filename);
        //全部加载  
        $objPHPExcel = PHPExcel_IOFactory::load($filename); //加载文件  
        //全部读取 
        $sheetCount = $objPHPExcel->getSheetCount();
        for ($i = 0; $i < $sheetCount; $i++) {
            $data = $objPHPExcel->getSheet($i)->toArray(); //读取数据到数组
            $data_q['title'] = $data[0][0];
            $data_q['number'] = $data[1][0];
            $data_q['name'] = $data[2][2];
            $data_q['contact'] = $data[3][2];
            $data_q['tel'] = $data[4][2];
            $data_q['fax'] = $data[5][2];
            $data_q['pname'] = $data[6][0];
            $data_q['explain'] = $data[9][2];
            $data_q['uid'] = $admin['id'];
            $data_q['uname'] = $data[3][6];
            $data_q['unumber'] = $data[4][6];
            $data_q['money'] = $data[7][6];
            $data_q['optid'] = $admin['id'];
            $data_q['optname'] = $admin['name'];
            $data_q['date'] = $data[5][6];
            $data_q['optdt'] = date('Y-m-d H:i:s');
            $data_q['status'] = 1;
            if(empty($data_q['title'])){
                $this->msg_json(0, '请填写报价单标题');
            }
            if(empty($data_q['number'])){
                $this->msg_json(0, '请填写表格编号');
            }
            if(empty($data_q['name'])){
                $this->msg_json(0, '请填写工程名称');
            }
            foreach ($data as $k => $v) {
                if($k>10){
                    if (!empty($v[0]) && !empty($v[1])&& !empty($v[2])&& empty($v[3])&& empty($v[4])&& empty($v[5])) {
                        $pk = $v[0];
                        $data_p[$pk]['pid'] = $id;
                        $data_p[$pk]['name'] = $v[1];
                        $data_p[$pk]['format'] = $v[2];
                    }else if($v[1]=='成套价'&& !empty($v[4])&& !empty($v[5])){
                        $data_p[$pk]['unit'] = $v[3];
                        $data_p[$pk]['num'] = $v[4];
                        $data_p[$pk]['price'] = $v[5];
                        $data_p[$pk]['money'] = $v[4]*$v[5];
                        $money += $v[4]*$v[5];
                        unset($pk);
                    }else if(!empty($v[1]) && !empty($v[4])&& !empty($v[5])){
                        $data_p[$pk]['children'][] = array(
                            'name' => $v[1],
                            'format' => $v[2],
                            'unit' => $v[3],
                            'num' => $v[4],
                            'price' => $v[5],
                            'money' => $v[4]*$v[5],
                        );
                        $data_q[$pk]['total'] += $v[4]*$v[5];
                    }
                }
            }
            $data_q['money'] = $money;
            $up = $m_quotation->update(array('id'=>$id),$data_q);
            if($up){
                $this->getQuoPro($id, $data_p);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        unlink($filename);
    }
    
    function getQuoPro($pid,$data=array()){
        $m_quo_project = spClass('m_quo_project');
        $m_project = spClass('m_project');
        $m_pro_mater = spClass('m_pro_mater');
        foreach($data as $k=>$v){
            $ad = $m_project->create(array('name'=>$v['name'],'format'=>$v['format'],'unit'=>$v['unit'],'price'=>$v['price'],'total'=>$v['total'],'del'=>1));
            foreach($v['children'] as $k1=>$v1){
                $v1['pid'] = $ad;
                $m_pro_mater->create($v1);
            }
            $data_q[$k] = array('qid'=>$ad,'pid'=>$pid,'name'=>$v['name'],'format'=>$v['format'],'unit'=>$v['unit'],'num'=>$v['num'],'money'=>$v['money'],'price'=>$v['price'],'total'=>$v['total']);
        }
        $m_quo_project->updateAll(array('pid'=>$pid),$data_q);
    }
    
    //生产设备保养记录
    function sbbyjl(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_sbbyjl');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>34));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or title like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    //自制图纸记录
    function zztz(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_zztz');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function saveZztz(){
        $admin = $this->get_ajax_menu();
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['num'] = htmlspecialchars($this->spArgs('num'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['ffdep'] = htmlspecialchars($this->spArgs('ffdep'));
        $data['qianshou'] = htmlspecialchars($this->spArgs('qianshou'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_zztz');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请输入顾客/工程名称');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    //生产设备维修计划
    function sbwxjh(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_sbwxjh');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>36));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or title like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    //报损单
    function bsd(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_bsd');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>37));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or title like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

}
