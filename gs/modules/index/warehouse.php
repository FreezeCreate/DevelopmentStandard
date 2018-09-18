<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class warehouse extends IndexController {
    
    function ruku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_ruku');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>14));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            if($status==1){
                $con .= ' and b.status = 0';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (b.number like "%'.$name.'%" or b.name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a right outer join '.DB_NAME.'_ruku as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function rukuInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 14);
        $result = $this->result;
        if($result){
            $result['children'] = spClass('m_ruku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function addRuku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_ruku');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($result){
            $result['children'] = spClass('m_ruku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }
    }
    
    function saveRuku(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_ruku');
        $data['name'] = htmlspecialchars($this->spArgs('pname'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $id = (int)htmlentities($this->spArgs('id'));
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $num = $this->spArgs('num');
        $supplier = $this->spArgs('supplier');
        $explain = $this->spArgs('explain');
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if(empty($name[0])||empty($num[0])){
            $this->msg_json(0, '请确认信息完整');
        }
        foreach($name as $k=>$v){
            if($v&&$num[$k]){
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'format' => $format[$k],
                    'num' => $num[$k],
                    'supplier' => $supplier[$k],
                    'explain' => $explain[$k],
                );
            }
        }
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在');
            }
            if($re['status']>2){
                $this->msg_json(0, '该信息不可编辑');
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                spClass('m_ruku_produce')->updateAll(array('pid'=>$id),$chanpin);
                $this->sendUpcoming(14, $id, '【'.$data['name'].'】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if($ad){
                foreach($chanpin as $k=>$v){
                    $chanpin[$k]['pid'] = $ad;
                }
                spClass('m_ruku_produce')->updateAll(array('pid'=>$ad),$chanpin);
                $this->sendUpcoming(14, $ad, '【'.$data['name'].'】');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }
    
    function clruku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_clruku');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>14));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            if($status==1){
                $con .= ' and b.status = 0';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (b.number like "%'.$name.'%" or b.name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a right outer join '.DB_NAME.'_clruku as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function clrukuInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 18);
        $result = $this->result;
        if($result){
            $result['children'] = spClass('m_clruku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function addClruku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_clruku');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($result){
            $result['children'] = spClass('m_clruku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }
    }
    
    function saveClruku(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_clruku');
        $data['name'] = htmlspecialchars($this->spArgs('pname'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $id = (int)htmlentities($this->spArgs('id'));
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $num = $this->spArgs('num');
        $supplier = $this->spArgs('supplier');
        $explain = $this->spArgs('explain');
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if(empty($name[0])||empty($num[0])){
            $this->msg_json(0, '请确认信息完整');
        }
        foreach($name as $k=>$v){
            if($v&&$num[$k]){
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'format' => $format[$k],
                    'num' => $num[$k],
                    'supplier' => $supplier[$k],
                    'explain' => $explain[$k],
                );
            }
        }
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在');
            }
            if($re['status']>2){
                $this->msg_json(0, '该信息不可编辑');
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                spClass('m_clruku_produce')->updateAll(array('pid'=>$id),$chanpin);
                $this->sendUpcoming(18, $id, '【'.$data['name'].'】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if($ad){
                foreach($chanpin as $k=>$v){
                    $chanpin[$k]['pid'] = $ad;
                }
                spClass('m_clruku_produce')->updateAll(array('pid'=>$ad),$chanpin);
                $this->sendUpcoming(18, $ad, '【'.$data['name'].'】');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }
    
    function chuku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_chuku');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>17));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            if($status==1){
                $con .= ' and b.status = 0';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (b.number like "%'.$name.'%" or b.name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a right outer join '.DB_NAME.'_chuku as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function chukuInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 17);
        $result = $this->result;
        if($result){
            $result['children'] = spClass('m_chuku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function addChuku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_chuku');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($result){
            $result['children'] = spClass('m_chuku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }
    }
    
    function saveChuku(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_chuku');
        $data['name'] = htmlspecialchars($this->spArgs('pname'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $id = (int)htmlentities($this->spArgs('id'));
        $project = $this->spArgs('project');
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $num = $this->spArgs('num');
        $supplier = $this->spArgs('supplier');
        $explain = $this->spArgs('explain');
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if(empty($name[0])||empty($num[0])){
            $this->msg_json(0, '请确认信息完整');
        }
        foreach($name as $k=>$v){
            if($v&&$num[$k]){
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'project' => $project[$k],
                    'format' => $format[$k],
                    'num' => $num[$k],
                    'supplier' => $supplier[$k],
                    'explain' => $explain[$k],
                );
            }
        }
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在');
            }
            if($re['status']>2){
                $this->msg_json(0, '该信息不可编辑');
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                spClass('m_chuku_produce')->updateAll(array('pid'=>$id),$chanpin);
                $this->sendUpcoming(17, $id, '【'.$data['name'].'】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if($ad){
                foreach($chanpin as $k=>$v){
                    $chanpin[$k]['pid'] = $ad;
                }
                spClass('m_chuku_produce')->updateAll(array('pid'=>$ad),$chanpin);
                $this->sendUpcoming(17, $ad, '【'.$data['name'].'】');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }
    
    
    function clchuku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_clchuku');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>19));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            if($status==1){
                $con .= ' and b.status = 0';
            }else{
                $con .= ' and b.status = '.$status;
            }
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $con .= ' and (b.number like "%'.$name.'%" or b.name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from '.DB_NAME.'_orders as a right outer join '.DB_NAME.'_clchuku as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function clchukuInfo(){
        $id = (int)htmlentities($this->spArgs('id'));
        $this->findCheck($id, 19);
        $result = $this->result;
        if($result){
            $result['children'] = spClass('m_clchuku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }else{
            $this->error('信息不存在');
        }
    }
    
    function addClchuku(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_clchuku');
        $id = (int)htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($result){
            $result['children'] = spClass('m_clchuku_produce')->findAll(array('pid'=>$id));
            $this->result = $result;
        }
    }
    
    function saveClchuku(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_clchuku');
        $data['name'] = htmlspecialchars($this->spArgs('pname'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $id = (int)htmlentities($this->spArgs('id'));
        $project = $this->spArgs('project');
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $num = $this->spArgs('num');
        $supplier = $this->spArgs('supplier');
        $explain = $this->spArgs('explain');
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if(empty($name[0])||empty($num[0])){
            $this->msg_json(0, '请确认信息完整');
        }
        foreach($name as $k=>$v){
            if($v&&$num[$k]){
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'project' => $project[$k],
                    'format' => $format[$k],
                    'num' => $num[$k],
                    'supplier' => $supplier[$k],
                    'explain' => $explain[$k],
                );
            }
        }
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0));
            if(empty($re)){
                $this->msg_json(0, '信息不存在');
            }
            if($re['status']>2){
                $this->msg_json(0, '该信息不可编辑');
            }
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                spClass('m_clchuku_produce')->updateAll(array('pid'=>$id),$chanpin);
                $this->sendUpcoming(19, $id, '【'.$data['name'].'】'.$data['number']);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if($ad){
                foreach($chanpin as $k=>$v){
                    $chanpin[$k]['pid'] = $ad;
                }
                spClass('m_clchuku_produce')->updateAll(array('pid'=>$ad),$chanpin);
                $this->sendUpcoming(19, $ad, '【'.$data['name'].'】');
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }
    
    

}
