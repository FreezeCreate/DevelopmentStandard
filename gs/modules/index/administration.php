<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class administration extends IndexController {

    public function failed() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_failed');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>16));
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
            $where .= ' and (number like "%'.$name.'%" or dname like "%'.$name.'%")';
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
    
    function addFailed(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_failed');
        $id = (int)htmlentities($this->spArgs('id'));
        $dep = spClass('m_department')->findAll();
        $this->dep = $dep;
        if($id){
            $result = $model->find(array('id'=>$id));
            $this->result = $result;
        }
        
    }
    
    function failedInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 16);
        
    }
    
    function saveFailed(){
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dname'] = htmlspecialchars($this->spArgs('dname'));
        $data['address'] = htmlspecialchars($this->spArgs('address'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['miaoshu'] = htmlspecialchars($this->spArgs('miaoshu'));
        $data['tiaokuan'] = htmlspecialchars($this->spArgs('tiaokuan'));
        $data['chengdu'] = htmlspecialchars($this->spArgs('chengdu'));
        $data['uname'] = htmlspecialchars($this->spArgs('uname'));
        $id = (int)htmlentities($this->spArgs('id'));
        $model = spClass('m_failed');
        if(empty($data['number'])){
            $this->msg_json(0, '请输入文件编号');
        }
        if(empty($data['dname'])){
            $this->msg_json(0, '请选择受审部门');
        }
        if(empty($data['miaoshu'])){
            $this->msg_json(0, '请填写不合格事实描述');
        }
        if(empty($data['chengdu'])){
            $this->msg_json(0, '请选择不合格程度');
        }
        if(empty($data['uname'])){
            $this->msg_json(0, '审核员请上传签名');
        }
        $data['uid'] = $admin['id'];
        $data['cid'] = $admin['cid'];
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '数据有误，请刷新重试');
            }
            if($re['status']>2){
                $this->msg_json(0, '不可编辑');
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $this->sendUpcoming(16, $id, '【不合格报告】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $ad = $model->create($data);
            if($ad){
                $this->sendUpcoming(16, $ad, '【不合格报告】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    //内部检查表
    function nsjc(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_nsjc');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>20));
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
            $where .= ' and (number like "%'.$name.'%")';
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
    
    //内部审核计划
    function nbshjh(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_nbshjh');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>20));
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
            $where .= ' and (number like "%'.$name.'%")';
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
    
    //内部审核总结报告
    function nbshzj(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_nbshzj');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>22));
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
    
    //文件清单
    function wjqd(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_wjqd');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>23));
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
    
    //文件分发记录
    function wjff(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_wjff');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>24));
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
    
    //文件修订申请单
    function wjxdsq(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_wjxdsq');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>25));
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
            $where .= ' and (number like "%'.$name.'%" or wname like "%'.$name.'%")';
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
    
    //表单领用记录
    function bdly(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_bdly');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>26));
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
    
    //表单领用记录
    function wlwj(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_wlwj');
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
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function saveWlwj(){
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['laiyuan'] = htmlspecialchars($this->spArgs('laiyuan'));
        $data['gddt'] = htmlspecialchars($this->spArgs('gddt'));
        $data['jsdep'] = htmlspecialchars($this->spArgs('jsdep'));
        $data['ffdep'] = htmlspecialchars($this->spArgs('ffdep'));
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_wlwj');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请输入文件名称');
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
    
    //表单领用记录
    function ndpxjh(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_ndpxjh');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>30));
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
    
    //表单领用记录
    function pxjl(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_pxjl');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>31));
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
    
    //表单领用记录
    function ndnsjh(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_ndnsjh');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>32));
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
            $where .= ' and number like "%'.$name.'%"';
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
    
    //表单领用记录
    function hzcp(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_hzcp');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>33));
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
