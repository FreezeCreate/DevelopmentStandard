<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class basic extends IndexController {
    
    function supplier(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_supplier');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (company like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function supplierInfo(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_supplier');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $id = (int)$this->spArgs('id');
        $result = $model->find(array('id'=>$id));
        
        $this->result = $result;
    }
    
    function addSupplier(){
        if($_POST){
            $admin = $this->get_ajax_menu();
            $model = spClass('m_supplier');
            $data = $this->spArgs();
            unset($data['id']);
            if(empty($data['company'])){
                $this->msg_json(0, '请输入供应商名称');
            }
            if(empty($data['name'])){
                $this->msg_json(0, '请输入联系人');
            }
            if(empty($data['phone'])){
                $this->msg_json(0, '请输入联系电话');
            }
            if(empty($data['goodstype'])){
                $this->msg_json(0, '请输入供货类别');
            }
            $re = $model->find(array('company'=>$data['company'],'cid'=>$admin['cid']));
            if($re){
                $this->msg_json(0, '该供应商已添加');
            }
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if($ad){
                $this->msg_json(1, '添加成功');
            }else{
                $this->msg_json(0, '添加失败');
            }
        }else{
            $result = $this->get_menu();
            $this->menu = $result['menu'];
            $admin = $result['admin'];
        }

    }
    
    function delSupplier(){
        $admin = $this->get_ajax_menu();
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_supplier');
        $re = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($re){
            $up = $model->update(array('id'=>$id),array('del'=>1,'optid'=>$admin['id'],'optname'=>$admin['name'],'optdt'=>date('Y-m-d H:i:s')));
            if($up){
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '数据不存在');
        }
    }
    
    function delCustomer(){
        $admin = $this->get_ajax_menu();
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_customer');
        $re = $model->find(array('id'=>$id,'cid'=>$admin['cid']));
        if($re){
            $up = $model->update(array('id'=>$id),array('del'=>1,'optid'=>$admin['id'],'optname'=>$admin['name'],'optdt'=>date('Y-m-d H:i:s')));
            if($up){
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '数据不存在');
        }
    }
    
    function customer(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_customer');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;

    }
    
    function customerInfo(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_customer');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $id = (int)$this->spArgs('id');
        $result = $model->find(array('id'=>$id));
        
        $this->result = $result;
    }
    
    function addCustomer(){
        if($_POST){
            $admin = $this->get_ajax_menu();
            $model = spClass('m_customer');
            $data = $this->spArgs();
            $id = $data['id'];
            unset($data['id']);
            if(empty($data['company'])){
                $this->msg_json(0, '请输入顾客名称');
            }
            if(empty($data['name'])){
                $this->msg_json(0, '请输入负责人');
            }
            if(empty($data['address'])){
                $this->msg_json(0, '请输入地区');
            }
            if(empty($data['goodstype'])){
                $this->msg_json(0, '请输入供货类别');
            }
            $data['uid'] = $admin['id'];
            $data['cid'] = $admin['cid'];
            $data['uname'] = $admin['name'];
            $re = $model->find('name = "'.$data['name'].'" or phone = "'.$data['phone'].'" or company = "'.$data['company'].'"');
            if($re){
                $this->msg_json(0, '该顾客已添加');
            }
            $ad = $model->create($data);
            if($ad){
                $this->msg_json(1, '添加成功');
            }else{
                $this->msg_json(0, '添加失败');
            }
        }else{
            $result = $this->get_menu();
            $this->menu = $result['menu'];
            $admin = $result['admin'];
        }

    }
    
    function company() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $m_company = spClass('m_company');
        $m_department = spClass('m_department');
        $con = $admin['id']==1?'':'id = '.$admin['cid'];
        $results = $m_company->findAll($con);
        foreach ($results as $k => $v) {
            $results[$k]['children'] = $m_department->findAll('pid = ' . $v['id']);
        }
        $this->results = $results;
    }

    function finddemp() {
        $admin = $this->get_ajax_menu($this->c, 'demp');
        $type = htmlentities($this->spArgs('type'));
        $type = $type == 'demp' ? 'department' : $type;
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_' . $type);
        $re = $model->find(array('id' => $id));
        $this->msg_json(1, '操作成功', $re);
    }

    function deldemp() {
        $admin = $this->get_ajax_menu($this->c, 'demp');
        $type = htmlentities($this->spArgs('type'));
        $type = $type == 'demp' ? 'department' : $type;
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_' . $type);
        if($type=='company'){
            spClass('m_department')->delete(array('pid'=>$id));
            spClass('m_admin')->delete(array('cid'=>$id));
        }else if($type=='department'){
            spClass('m_admin')->delete(array('did'=>$id));
        }
        $re = $model->delete(array('id' => $id));
        $this->msg_json(1, '操作成功', $re);
    }

    function saveCompany() {
        $admin = $this->get_ajax_menu($this->c, 'demp');
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['phone'] = htmlspecialchars($this->spArgs('phone'));
        $data['email'] = htmlspecialchars($this->spArgs('email'));
        $data['fax'] = htmlspecialchars($this->spArgs('fax'));
        $data['logo'] = htmlspecialchars($this->spArgs('logo'));
        $data['color'] = htmlspecialchars($this->spArgs('color'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_company');
        if (empty($data['logo'])) {
            $this->msg_json(0, '公司logo不能为空');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '名称不能为空');
        }
        $re = $model->find(array('id' => $id));
        if ($re) {
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $re = $model->find(array('name' => $data[['name']]));
            if ($re) {
                $this->msg_json(0, '该公司名已添加');
            }
            $ad = $model->create($data);
            if ($ad) {
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function saveDemp() {
        $admin = $this->get_ajax_menu($this->c, 'demp');
        $model = spClass('m_department');
        $m_admin = spClass('m_admin');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['pid'] = trim(htmlspecialchars($this->spArgs('pid')));
        $data['phone'] = trim(htmlspecialchars($this->spArgs('phone')));
        $data['fax'] = trim(htmlspecialchars($this->spArgs('fax')));
        $data['explain'] = trim(htmlspecialchars($this->spArgs('explain')));
        $data['sort'] = (int) htmlspecialchars($this->spArgs('sort'));
        $data['principalid'] = (int) htmlspecialchars($this->spArgs('uid'));
        if (!empty($data['principalid'])) {
            $user = $m_admin->find(array('id' => $data['principalid']), '', 'id,name');
        }
        $data['principalname'] = empty($user['name'])?'':$user['name'];
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写部门名称');
        }
        if (empty($data['pid'])) {
            $this->msg_json(0, '请选择所属公司');
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if ($re) {
                $up = $model->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $re['id'];
                    $this->msg_json(2, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            $re = $model->find(array('name' => $data['name'], 'pid' => $data['pid']));
            if ($re) {
                $this->msg_json(0, '该部门已添加');
            } else {
                $ad = $model->create($data);
                if ($ad) {
                    $this->msg_json(1, '添加成功');
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }
    
    function mater(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $number = trim(htmlspecialchars($this->spArgs('number')));
        $name = urldecode(trim(htmlspecialchars($this->spArgs('name'))));
        $m_material = spClass('m_material');
        $con = 'del = 0';
        if (!empty($number)) {
            $con .= ' and number like "%' . $number . '%"';
            $page_con['number'] = $number;
        }
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        if ($this->spArgs('daochu') == 1) {
            $results = $m_material->findAll($con, 'sort asc,number asc');
            $title = array('编号', '名称', '型号规格', '单位', '单价');
            $indexKey = array('number', 'name', 'format', 'unit', 'price');
            Common::exportExcel($title, $results, $indexKey, '元器件' . date('md'));
            exit();
        }
        $results = $m_material->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'sort asc,number asc');
        $this->results = $results;
        $this->pager = $m_material->spPager()->getPager();
        $this->page_con = $page_con;
        
    }
    
    function findMater(){
        $admin = $this->get_ajax_menu($this->c,'demp');
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_material');
        $re = $model->find(array('id'=>$id));
        $this->msg_json(1, '操作成功',$re);
    }
    
    function delMater(){
        $admin = $this->get_ajax_menu($this->c,'demp');
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_material');
        $re = $model->delete(array('id'=>$id));
        $this->msg_json(1, '操作成功',$re);
    }
    
    function saveMater(){
        $admin = $this->get_ajax_menu($this->c,'mater');
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['unit'] = htmlspecialchars($this->spArgs('unit'));
        $data['price'] = htmlspecialchars($this->spArgs('price'));
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_material');
        if(empty($data['name'])){
            $this->msg_json(0, '名称不能为空');
        }
        $re = $model->find(array('id'=>$id));
        if($re){
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $re = $model->find(array('name'=>$data[['name']]));
            if($re){
                $this->msg_json(0, '该元器件已添加');
            }
            $ad = $model->create($data);
            if($ad){
                $this->msg_json(1, '添加成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
    }
    //导入元器件
    function importExcel() {
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
        $m = 0;
        $n = 0;
        $e = 0;
        for ($i = 0; $i < $sheetCount; $i++) {
            $data = $objPHPExcel->getSheet($i)->toArray(); //读取数据到数组
            foreach ($data as $k => $v) {
                if ($k > 0) {
                    if (!empty($v[0]) && !empty($v[1])) {
                        $data_mater['number'] = $v[0];
                        $data_mater['name'] = $v[1];
                        $data_mater['format'] = $v[2];
                        $data_mater['supplier'] = $v[3];
                        $data_mater['unit'] = $v[4];
                        $data_mater['price'] = $v[5];
                        $re = spClass('m_material')->find(array('number' => $data_mater['number']));
                        if ($re) {
                            $ad = spClass('m_material')->update(array('id' => $re['id']), $data_mater);
                            $m++;
                        } else {
                            $ad = spClass('m_material')->create($data_mater);
                            if ($ad) {
                                $n++;
                            } else {
                                $e++;
                            }
                        }
                    }else {
                        $e++;
                    }
                }
            }
        }
        unlink($filename);
        $sum = $m + $n + $e;
        $this->msg_json(1, '操作完成，共' . $sum . '条数据，' . $m . '条重复，' . $n . '条添加成功，' . $e . '条添加失败。');
    }

    function project(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_project');
        $con = 'del = 0';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $con .= ' and (format like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function editproject(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_project');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id));
        $result['mater'] = spClass('m_pro_mater')->findAll(array('pid'=>$id));
        $this->result = $result;
        $mater = spClass('m_material')->findAll('del = 0','number');
        $this->mater = $mater;
    }
    
    function delProject(){
        $admin = $this->get_ajax_menu();
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_project');
        $re = $model->find(array('id'=>$id));
        if($re){
            $del = $model->update(array('id'=>$id),array('del'=>1));
            if($del){
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $this->msg_json(0, '数据不存在');
        }
    }

    function projectInfo(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_project');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id'=>$id));
        $result['mater'] = spClass('m_pro_mater')->findAll(array('pid'=>$id));
        $this->result = $result;
    }
    
    function saveProject(){
        $admin = $this->get_ajax_menu();
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['unit'] = htmlspecialchars($this->spArgs('unit'));
        $data['price'] = htmlspecialchars($this->spArgs('price'));
        $id = (int)htmlentities($this->spArgs('id'));
        $mid = $this->spArgs('mid');
        $mprice = $this->spArgs('mprice');
        $mnum = $this->spArgs('mnum');
        $m_project = spClass('m_project');
        $m_pro_mater = spClass('m_pro_mater');
        $m_material = spClass('m_material');
        if(empty($data['name'])){
            $this->msg_json(0, '请输入名称');
        }
        if(empty($mid)){
            $this->msg_json(0, '请选择所需元件');
        }
        $mater = $m_material->findAll('del = 0 and id in('.implode(',', $mid).')');
        $data['total'] = 0;
        foreach($mater as $k=>$v){
            $mater[$k]['num'] = $mnum[$v['id']];
            $mater[$k]['price'] = $mprice[$v['id']];
            $mater[$k]['mid'] = $v['id'];
            $mater[$k]['pid'] = $id;
            $mater[$k]['money'] = $mnum[$v['id']]*$mprice[$v['id']];
            $data['total'] += $mnum[$v['id']]*$mprice[$v['id']];
            unset($mater[$k]['id']);
        }
        if($id){
            $re = $m_project->find(array('id'=>$id));
            if(empty($re)){
                $this->msg_json(0, '数据不存在');
            }
            $up = $m_project->update(array('id'=>$id),$data);
            if($up){
                $m_pro_mater->updateAll(array('pid'=>$id),$mater);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }else{
            $ad = $m_project->create($data);
            if($ad){
                foreach($mater as $k=>$v){
                    $mater[$k]['pid'] = $ad;
                }
                $m_pro_mater->createAll($mater);
                $this->msg_json(1, '操作成功');
            }else{
                $this->msg_json(0, '操作失败');
            }
        }
        
    }

}
