<?php

/**
 * Description of main
 *
 * @author IndexController
 */
class personnel extends AppController {
    
    //考勤查看
    function punchLst() {
        $user = $this->islogin();
        $model = spClass('m_kqdkjl');
        $start = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'a.cid = ' . $user['cid'];
        if ($start) {
            $con .= ' and a.dkdt >= ' . date('Ymd', strtotime($start));
            $page_con['start'] = $start;
        }
        if ($end) {
            $con .= ' and dkdt <= ' . date('Ymd', strtotime($end));
            $page_con['end'] = $end;
        }
        if ($name) {
            $con .= ' and (b.dname like "%' . $name . '%" or b.name like "%' . $name . '%" or b.pname like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.id,a.dkdt,a.type,a.optdt,b.name from '.DB_NAME.'_kqdkjl as a left outer join '.DB_NAME.'_user as b on a.uid = b.id where (' . $con . ') order by dkdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    
    /*     * ******
     * 流程待办
     * ******* */

    function upcoming() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int)htmlspecialchars($this->spArgs('sid'));
        $type = (int)htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['id']] = $v;
        }
        $con = 'del = 0 and comid = '.$user['cid'];
        if($type==1){
            $con .= ' and allcheckid like "%,'.$user['id'].',%"';
        }else if($type==2){
            $con .= ' and nowcheckid like "%,'.$user['id'].',%"';
        }else{
            $con .= ' and (nowcheckid like "%,'.$user['id'].',%" or allcheckid like "%,'.$user['id'].',%")';
        }
        if($sid){
            $con .= ' and modelid = '.$sid;
            $page_con['sid'] = $sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
            $page_con['applydt'] = $applydt;
        }
        if($name){
            $con .= ' and (uname like "%'.$name.'%" or dname like "%'.$name.'%" or summary like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
//        echo $m_flow_bill->dumpSql();
        foreach($results as $k=>$v){
            $results[$k] = array(
                'id' => $v['id'],
                'title' => $set[$v['modelid']]['name'],
                'model' => $set[$v['modelid']]['model'],
                'tid' => $v['tid'],
                'uname' => $v['uname'],
                'applydt' => $v['applydt'],
                'explain' => $v['summary'],
                'st' => $v['statustext'],
                'billcid' => $v['cid'],
            );
        }
        $result['results'] = $results;
        $pager = $m_flow_bill->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
     /*************
     * 消息提醒
     */
    function remind(){
        $user = $this->islogin();
        $m_flow_todos = spClass('m_flow_todos');
        $type = (int)htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'uid = '.$user['id'].' and cid = '.$user['cid'];
        switch ($type) {
            case 1:
                $con .= ' and isread = 0';
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and isread = 1';
                $page_con['type'] = 2;
                break;
            default:
                break;
        }
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $m_flow_todos->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'isread asc,adddt desc,id desc','id,modelid,model,modelname,tid,adddt,isread,title');
        $result['results'] = $results;
        $pager = $m_flow_todos->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    /*     * ******
     * 我的申请
     * ******* */

    function myapply() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int)htmlspecialchars($this->spArgs('sid'));
        $type = (int)htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['id']] = $v;
        }
        $con = 'del = 0 and uid = '.$user['id'].' and comid = '.$user['cid'];
        if($type==1){
            $con .= ' and status > 2 and nowcheckid = 0';
            $page_con['type'] = 1;
        }
        if($type==2){
            $con .= ' and status = 2';
            $page_con['type'] = 2;
        }
        if($sid){
            $con .= ' and modelid = '.$sid;
            $page_con['sid'] = $sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
            $page_con['applydt'] = $applydt;
        }
        if($name){
            $con .= ' and (uname like "%'.$name.'%" or dname like "%'.$name.'%" or summary like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        foreach($results as $k=>$v){
            $results[$k] = array(
                'id' => $v['id'],
                'title' => $set[$v['modelid']]['name'],
                'model' => $set[$v['modelid']]['model'],
                'tid' => $v['tid'],
                'uname' => $v['uname'],
                'applydt' => $v['applydt'],
                'explain' => $v['summary'],
                'st' => $v['statustext'],
                'billcid' => $v['cid'],
            );
        }
        $result['results'] = $results;
        $pager = $m_flow_bill->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function users() {
        $user = $this->islogin();
        $name = urldecode(trim(htmlspecialchars($this->spArgs('name'))));
        $did = (int)htmlspecialchars($this->spArgs('did'));
        $model = spClass('m_user');
        $con = 'cid = '.$user['cid'];
        if (!empty($name)) {
            $con .= ' and (name like "%' . $name . '%" or phone like "%' . $name . '%")';
        }
        if (!empty($did)) {
            $con .= ' and did = '.$did;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'entrydt asc','id,name,dname,pname,entrydt');
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function daily() {
        $user = $this->islogin();
        $name = urldecode(trim(htmlspecialchars($this->spArgs('name'))));
        $type = urldecode(htmlspecialchars($this->spArgs('type','日报')));
        $model = spClass('m_daily');
        $con = 'cid = '.$user['cid'];
        if (!empty($name)) {
            $con .= ' and uname like "%' . $name . '%"';
        }
        if (!empty($type)) {
            $con .= ' and type = "'.$type.'"';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'date desc','id,date,uname,content,type');
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    function userinfo(){
        $user = $this->islogin();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $id = empty($id)?$user['id']:$id;
        $model = spClass('m_user');
        $result = $model->find(array('id'=>$id,'cid'=>$user['cid']),'','id,name,sex,head,phone,idcardnumber,cname,dname,pname,sname,entrydt,positivedt,dir');
        if(empty($result)){
            $this->returnError('信息有误');
        }
        $result['head'] = URL.$result['head'];
        $result['dir'] = $GLOBALS['USER_DIR'][$result['dir']];
        $this->returnSuccess('成功',$result);
    }
    
    function person(){
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int)htmlspecialchars($this->spArgs('sid',12));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['id']] = $v;
        }
        $con = 'del = 0 and comid = '.$user['cid'];
        if($sid){
            $con .= ' and modelid = '.$sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
        }
        if($name){
            $con .= ' and (uname like "%'.$name.'%" or dname like "%'.$name.'%" or summary like "%'.$name.'%")';
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        foreach($results as $k=>$v){
            $results[$k] = array(
                'id' => $v['id'],
                'title' => $set[$v['modelid']]['name'],
                'model' => $set[$v['modelid']]['model'],
                'tid' => $v['tid'],
                'uname' => $v['uname'],
                'dname' => $v['dname'],
                'applydt' => $v['applydt'],
                'explain' => $v['summary'],
                'st' => $v['statustext'],
                'billcid' => $v['cid'],
            );
        }
        $result['results'] = $results;
        $pager = $m_flow_bill->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    function entry(){
        $user = $this->islogin(26);
        $model = spClass('m_reg_company');
        $type = htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'b.cid = '.$user['cid'];
        if($type==1){
            $con .= ' and b.status > 1';
        }else if($type==2){
            $con .= ' and b.status = 1';
        }
        if($name){
            $con .= ' and (a.name like "%'.$name.'%" or b.dname like "%'.$name.'%" or b.pname like "%'.$name.'%")';
        }
        $sql = 'select a.name,b.id,b.dname,b.pname,b.applydt,b.status from '.DB_NAME.'_user as a right outer join '.DB_NAME.'_reg_company as b on a.id = b.uid where ' . $con . ' order by b.applydt desc,b.id desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        foreach($results as $k=>$v){
            $results[$k]['applydt'] = date('Y-m-d',  strtotime($v['applydt']));
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }
    
    function entryinfo(){
        $user = $this->islogin(26);
        $model = spClass('m_reg_company');
        $id = (int)htmlentities($this->spArgs('id'));
        $con = 'b.id = '.$id.' and b.cid = '.$user['cid'];
        $sql = 'select a.name,a.phone,a.idcard,a.idcardnumber,b.id,b.dname,b.pname,b.applydt from '.DB_NAME.'_user as a right outer join '.DB_NAME.'_reg_company as b on a.id = b.uid where ' . $con . ' order by b.applydt desc,b.id desc';
        $results = $model->findSql($sql);
        $result = $results[0];
        if(empty($result)){
            $this->returnError('数据有误',$id);
        }
        $result['idcard'] = URL.$result['idcard'];
        $this->returnSuccess('成功', $result);
    }
    
    function checkentry(){
        $user = $this->islogin(26);
        $model = spClass('m_reg_company');
        $id = (int)htmlentities($this->spArgs('id'));
        $status = (int)htmlentities($this->spArgs('status'));
        $explain = htmlspecialchars($this->spArgs('explain'));
        $re = $model->find(array('id'=>$id,'cid'=>$user['cid'],'status'=>1));
        if(empty($re)){
            $this->returnError('信息不存在或已审核');
        }
        if($status==2 && empty($explain)){
            $this->returnError('请填写不通过原因');
        }else if($status==3){
            $data['explain'] = '审核通过';
        }else{
            $this->returnError('请选择审核状态');
        }
        $data['status'] = $status;
        $data['explain'] = $explain;
        $data['checkid'] = $user['id'];
        $data['checkname'] = $user['name'];
        $data['checkdt'] = date('Y-m-d H:i:s');
        $up = $model->update(array('id'=>$id),$data);
        if($up){
            if($status==3){
                spClass('m_user')->update(array('id'=>$user['id']),array('cid'=>$re['cid'],'cname'=>$re['cname'],'did'=>$re['did'],'dname'=>$re['dname'],'pid'=>$re['pid'],'pname'=>$re['pname'],'entrydt'=>date('Y-m-d')));
            }
            $this->returnSuccess('操作成功');
        }else{
            $this->returnError('网络错误',404);
        }
    }
    
    function addinfo(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $m_admin = spClass('m_admin');
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_admin->find(array('id' => $id));
        if($result){
            $result['role'] = empty($result['role']) ? array(0) : json_decode($result['role'], true);
        }
        $result['department'] = spClass('m_department')->findAll('pid = '.$admin['shopid']);
        $result['position'] = $m_position->findAll();
        $this->result = $result;
        if ($admin['shopid'] == 1) {
        } else {
            $con = 'shopid = ' . $admin['shopid'];
        }
        $role = spClass('m_role')->findAll($con, '', 'id,name');
        $this->role = $role;
    }
    
    function uinfo(){
        $re = $this->get_menu();
        $admin = $re['admin'];
        $m_admin = spClass('m_admin');
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_admin->find(array('id' => $id));
        if($result){
            $result['role'] = empty($result['role']) ? array(0) : json_decode($result['role'], true);
        }
        $this->result = $result;
        if ($admin['shopid'] == 1) {
        } else {
            $con = 'shopid = ' . $admin['shopid'];
        }
        $role = spClass('m_role')->findAll($con, '', 'id,name');
        $this->role = $role;
    }

    function editUserinfo() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_admin->find(array('id' => $id));
        $result['role'] = empty($result['role']) ? array(0) : json_decode($result['role'], true);
        $result['position'] = $m_position->findAll(array('departmentid' => $result['departmentid']));
        if ($result) {
            $this->msg_json(1, '获取成功', $result);
        } else {
            $this->msg_json(0, '数据不存在，请刷新页面重试');
        }
    }

    function saveUserinfo() {
        $m_admin = spClass('m_admin');
        $m_shop = spClass('m_shop');
        $m_department = spClass('m_department');
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = trim(htmlspecialchars($this->spArgs('name')));
        $data['number'] = trim(htmlspecialchars($this->spArgs('number')));
        $data['username'] = trim(htmlspecialchars($this->spArgs('username')));
        $data['sex'] = trim(htmlspecialchars($this->spArgs('sex')));
        $password = trim(htmlspecialchars($this->spArgs('password')));
        $data['status'] = $this->spArgs('status') == 1 ? 1 : 0;
        $data['phone'] = trim(htmlspecialchars($this->spArgs('phone')));
        $data['trumpet'] = trim(htmlspecialchars($this->spArgs('trumpet')));
        $data['idCard'] = trim(htmlspecialchars($this->spArgs('idCard')));
        $data['birthday'] = trim(htmlspecialchars($this->spArgs('birthday')));
        $data['departmentid'] = (int) htmlspecialchars($this->spArgs('departmentid'));
        $data['positionid'] = trim(htmlspecialchars($this->spArgs('positionid')));
        $data['dir'] = (int) htmlspecialchars($this->spArgs('dir'));
        $data['pid'] = (int) htmlspecialchars($this->spArgs('uid'));
        $data['pname'] = trim(htmlspecialchars($this->spArgs('uname')));
        $data['workdate'] = trim(htmlspecialchars($this->spArgs('workdate')));
        $data['positivedt'] = trim(htmlspecialchars($this->spArgs('positivedt')));
        $data['departure'] = trim(htmlspecialchars($this->spArgs('departure')));
        $data['email'] = trim(htmlspecialchars($this->spArgs('email')));
        $data['QQ'] = trim(htmlspecialchars($this->spArgs('QQ')));
        $data['role'] = $this->spArgs('role');
        foreach ($data as $k => $v) {
            if (empty($v)) {
                unset($data[$k]);
            }
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写姓名');
        }
        if (empty($data['username'])) {
            $this->msg_json(0, '请填写登录名');
        }
        if (empty($data['phone'])) {
            $this->msg_json(0, '请填写手机号');
        }
        if (empty($data['departmentid'])) {
            $this->msg_json(0, '请选择部门');
        } else {
            $department = $m_department->find(array('id' => $data['departmentid']), '', 'id,department,pid');
            $shop = $m_shop->find(array('id' => $department['pid']), '', 'id,shopname');
            $data['shopid'] = $shop['id'];
            $data['shopname'] = $shop['shopname'];
            $data['departmentname'] = $department['department'];
        }
        if (empty($data['dir'])) {
            $this->msg_json(0, '请选择员工状态');
        }
        if (empty($data['workdate'])) {
            $this->msg_json(0, '请选择入职日期');
        }
        $position = $m_position->find(array('id' => $data['positionid']), '', 'id,name');
        if (empty($position)) {
            $this->msg_json(0, '请选择职位');
        } else {
            $data['positionname'] = $position['name'];
        }
        if (!empty($data['role'])) {
            $data['role'] = json_encode($data['role']);
        } else {
            $data['role'] = '';
        }
        if ($id) {
            if (!empty($password)) {
                $data['password'] = md5(md5($password));
            }
            $admin = $this->get_ajax_menu('personnel', 'editUserinfo');
            $re = $m_admin->find(array('id' => $id));
            if ($re) {
                $up = $m_admin->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $re['id'];
                    $this->msg_json(1, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            if (empty($password)) {
                $data['password'] = md5(md5('123456'));
            } else {
                $data['password'] = md5(md5($password));
            }
            $admin = $this->get_ajax_menu('personnel', 'addUserinfo');
            $re = $m_admin->find('username = "' . $data['username'] . '" or number = "' . $data['number'] . '"');
            if ($re) {
                $this->msg_json(0, '登录名或编号重复');
            } else {
                $ad = $m_admin->create($data);
                if ($ad) {
                    $data['id'] = $ad;
                    $data['number'] = empty($data['number']) ? '' : $data['number'];
                    $data['birthday'] = empty($data['birthday']) ? '' : $data['birthday'];
                    $data['positionid'] = empty($data['positionid']) ? '' : $data['positionid'];
                    $data['positionname'] = empty($data['positionname']) ? '' : $data['positionname'];
                    $data['email'] = empty($data['email']) ? '' : $data['email'];
                    $data['positivedt'] = empty($data['positivedt']) ? '' : $data['positivedt'];
                    $this->msg_json(1, '添加成功', $data);
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delUserinfo() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $id = (int) htmlspecialchars($this->spArgs('id'));

        $re = $m_admin->find(array('id' => $id));
        if ($re) {
            if ($id == 1) {
                $this->msg_json(0, '该用户不可删除');
            }
            $del = $m_admin->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }

    //导入员工资料
    function userExcel() {
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
        $c = 0;
        $e = 0;
        for ($i = 0; $i < $sheetCount; $i++) {
            $data = $objPHPExcel->getSheet($i)->toArray(); //读取数据到数组
            foreach ($data as $k => $v) {
                if ($k > 0) {
                    if (!empty($v[0]) && !empty($v[1]) && !empty($v[2]) && !empty($v[6]) && !empty($v[10]) && !empty($v[11]) && !empty($v[13]) && !empty($v[14])) {
                        $shop = spClass('m_shop')->find(array('shopname' => $v[10]), '', 'id,shopname');
                        if ($shop) {
                            $department = spClass('m_department')->find(array('department' => $v[11], 'pid' => $shop['id']), '', 'id,department');
                        }
                        if (!empty($shop) && !empty($department)) {
                            $data['shopid'] = $shop['id'];
                            $data['shopname'] = $shop['shopname'];
                            $data['departmentid'] = $department['id'];
                            $data['departmentname'] = $department['department'];
                            $position = spClass('m_position')->find(array('name' => $v[12]));
                            if (!empty($position)) {
                                $data['positionid'] = $position['id'];
                                $data['positionname'] = $position['name'];
                            }
                            $data['number'] = $v[0];
                            $data['name'] = $v[1];
                            $data['username'] = $v[2];
                            $data['password'] = empty($v[3]) ? md5(md5('123456')) : md5(md5($v[3]));
                            $data['sex'] = $v[4] == '男' ? '男' : '女';
                            $data['status'] = $v[5] == 1 ? 1 : 0;
                            $data['phone'] = $v[6];
                            $data['trumpet'] = $v[7];
                            $data['idCard'] = $v[8];
                            if (!empty($v[9])) {
                                $data['birthday'] = $v[9];
                            } else {
                                unset($data['birthday']);
                            }
                            if (!empty($v[15])) {
                                $data['positivedt'] = $v[15];
                            } else {
                                unset($data['positivedt']);
                            }
                            if (!empty($v[16])) {
                                $data['departure'] = $v[16];
                            } else {
                                unset($data['departure']);
                            }
                            $data['workdate'] = $v[14];
                            $data['dir'] = $v[13];
                            $data['email'] = $v[17];
                            $data['QQ'] = $v[18];
                            if (!empty($v[19])) {
                                $role = explode(',', $v[19]);
                                $data['role'] = json_encode($role);
                            } else {
                                unset($data['role']);
                            }
                            $re = spClass('m_admin')->find(array('number' => $data['number']), '', 'id');
                            $re1 = spClass('m_admin')->find(array('username' => $data['username']), '', 'id');
                            if ($re) {
                                if ($re['id'] == $re1['id'] || empty($re1)) {
                                    $up = spClass('m_admin')->update(array('id' => $re['id']), $data);
                                    if ($up) {
                                        $m++;
                                    } else {
                                        $e++;
                                    }
                                } else {
                                    $c++;
                                }
                            } else {
                                if ($re1) {
                                    $c++;
                                } else {
                                    $ad = spClass('m_admin')->create($data);
                                    if ($ad) {
                                        $n++;
                                    } else {
                                        $e++;
                                    }
                                }
                            }
                        } else {
                            $e++;
                        }
                    } elseif (empty($v[0]) && empty($v[1]) && empty($v[2]) && empty($v[3]) && empty($v[4]) && empty($v[5]) && empty($v[6]) && empty($v[7]) && empty($v[8]) && empty($v[9]) && empty($v[10]) && empty($v[11]) && empty($v[12]) && empty($v[13]) && empty($v[14]) && empty($v[15]) && empty($v[16]) && empty($v[17]) && empty($v[18]) && empty($v[19])) {
                        
                    } else {
                        $e++;
                    }
                }
            }
        }
        unlink($filename);
        $sum = $m + $c + $n + $e;
        $this->msg_json(1, '操作完成，共' . $sum . '条数据，' . $m . '条数据更新成功，' . $c . '条登录名重复，' . $n . '条添加成功，' . $e . '条添加失败。');
        //逐行读取  
//        foreach ($objPHPExcel->getWorkSheetIterator() as $sheet) {
//            foreach ($sheet->getRowIterator() as $row) {
//                if ($row->getRowIndex() < 2)
//                    continue; //忽略第一行  
//                foreach ($row->getCellIterator() as $cell) {
//                    $data = $cell->getValue();
//                    echo $data . ' ';
//                }
//                echo '<br/>';
//            }
//            echo '<br/><hr/>';
//        }
    }

    /*     * *********
     * 合同管理start
     */

    function contract() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_shop = spClass('m_shop');
        $m_contract = spClass('m_contract');
        $status = (int) htmlspecialchars($this->spArgs('status'));
        $cid = (int) htmlspecialchars($this->spArgs('cid'));
        $name = urldecode(trim(htmlspecialchars($this->spArgs('name'))));
        $uname = urldecode(trim(htmlspecialchars($this->spArgs('uname'))));
        if ($admin['shopid'] == 1) {
            $company = $m_shop->findAll();
            $con = '1 = 1';
        } else {
            $company = $m_shop->findAll(array('id' => $admin['shopid']));
            $con = 'cid = ' . $admin['shopid'];
        }
        $this->company = $company;
        if ($cid) {
            $con .= ' and cid = ' . $cid;
            $page_con['cid'] = $cid;
        }
        if ($status) {
            $con .= ' and status = ' . $status;
            $page_con['status'] = $status;
        }
        if ($name) {
            $con .= ' and name like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'id desc');
        foreach ($results as $k => $v) {
            $start = strtotime($v['start']);
            $end = strtotime($v['end']);
            $closure = strtotime($v['closure']);
            if ($start > time()) {
                $m_contract->updateField(array('id' => $v['id']), 'status', 1);
                $results[$k]['status'] = 1;
            } else if ((($end > time() && empty($closure)) || (!empty($closure) && $closure > time()))) {
                $m_contract->updateField(array('id' => $v['id']), 'status', 2);
                $results[$k]['status'] = 2;
            } else if (($end <= time() || (!empty($closure) && $closure <= time()))) {
                $m_contract->updateField(array('id' => $v['id']), 'status', 3);
                $results[$k]['status'] = 3;
            }
        }
        $this->results = $results;
        $this->pager = $m_contract->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function editContract() {
        $m_contract = spClass('m_contract');
        $m_file = spClass('m_file');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_contract->find(array('id' => $id));
        if (!empty($result['files'])) {
            $result['filesname'] = $m_file->findAll('id in(' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = json_encode(explode(',', $result['files']));
        } else {
            $result['filesname'] = array();
        }
        if ($result) {
            $this->msg_json(1, '获取成功', $result);
        } else {
            $this->msg_json(0, '数据不存在，请刷新页面重试');
        }
    }

    function saveContract() {
        $m_admin = spClass('m_admin');
        $m_shop = spClass('m_shop');
        $m_contract = spClass('m_contract');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['uid'] = (int) htmlspecialchars($this->spArgs('uid'));
        $data['cid'] = (int) htmlspecialchars($this->spArgs('cid'));
        $data['name'] = trim(htmlspecialchars($this->spArgs('name')));
        $data['type'] = trim(htmlspecialchars($this->spArgs('type')));
        $data['start'] = trim(htmlspecialchars($this->spArgs('start')));
        $data['end'] = trim(htmlspecialchars($this->spArgs('end')));
        $data['closure'] = trim(htmlspecialchars($this->spArgs('closure')));
        $data['explains'] = trim(htmlspecialchars($this->spArgs('explains')));
        $files = $this->spArgs('files');
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写合同名称');
        }
        $user = $m_admin->find(array('id' => $data['uid']), '', 'id,name');
        if (empty($user)) {
            $this->msg_json(0, '请选择签署人');
        } else {
            $data['uname'] = $user['name'];
        }
        if (empty($data['cid'])) {
            $this->msg_json(0, '请选择签署单位');
        } else {
            $shop = $m_shop->find(array('id' => $data['cid']), '', 'id,shopname');
            $data['company'] = $shop['shopname'];
        }
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择合同类型');
        }
        if (empty($data['start'])) {
            $this->msg_json(0, '请选择开始时间');
        }
        if (empty($data['end'])) {
            $this->msg_json(0, '请选择结束时间');
        }
        if ($data['end'] < $data['start']) {
            $this->msg_json(0, '结束时间不能小于开始时间');
        }
        if (!empty($files)) {
            $data['files'] = implode(',', json_decode($files));
        } else {
            $data['files'] = '';
        }
        if (empty($data['closure'])) {
            unset($data['closure']);
        } else if ($data['closure'] < $data['start'] || $data['closure'] > $data['end']) {
            $this->msg_json(0, '提前结束时间不能小于开始时间或大于结束时间');
        }
        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        $closure = strtotime($data['closure']);
        if ($start > time()) {
            $data['status'] = 1;
        } else if (($end > time() && empty($closure)) || (!empty($closure) && $closure > time())) {
            $data['status'] = 2;
        } else if ($end <= time() || (!empty($closure) && $closure <= time())) {
            $data['status'] = 3;
        }
        if ($id) {
            $admin = $this->get_ajax_menu('personnel', 'editContract');
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['time'] = time();
            $re = $m_contract->find(array('id' => $id));
            if ($re) {
                $up = $m_contract->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $re['id'];
                    $data['closure'] = empty($data['closure']) ? '' : $data['closure'];
                    $this->msg_json(2, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            $admin = $this->get_ajax_menu('personnel', 'addContract');
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['time'] = time();
            $ad = $m_contract->create($data);
            if ($ad) {
                $data['id'] = $ad;
                $data['closure'] = empty($data['closure']) ? '' : $data['closure'];
                $this->msg_json(1, '添加成功', $data);
            } else {
                $this->msg_json(0, '添加失败');
            }
        }
    }

    function delContract() {
        $admin = $this->get_ajax_menu();
        $m_contract = spClass('m_contract');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $re = $m_contract->find(array('id' => $id));
        if ($re) {
            $del = $m_contract->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }

    /*     * *******
     * 转正申请
     */

    function hrpositive() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 12));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $model = spClass('m_hrpositive');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    /*     * *******
     * 离职申请
     */

    function hrredund() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 13));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $model = spClass('m_hrredund');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    /*     * *******
     * 人事调动
     */

    function hrtransfer() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 14));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $model = spClass('m_hrtransfer');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    /*     * *******
     * 奖惩处罚
     */

    function reward() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 15));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $model = spClass('m_reward');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0';
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    /*     * ******
     * 考勤管理
     */


    function punchday() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_kqxxsj');
        $con = 'cid = ' . $admin['shopid'];
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'dt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function delPunchday() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_kqxxsj');
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $model->find(array('id' => $id));
        if ($re) {
            $del = $model->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '信息不存在');
        }
    }

    function savePunchday() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_kqxxsj');
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['cid'] = $admin['shopid'];
        $re = $model->find(array('dt' => $data['dt'], 'cid' => $admin['shopid']));
        if ($re) {
            $this->msg_json(0, '日期重复');
        }
        $ad = $model->create($data);
        if ($ad) {
            $data['id'] = $ad;
            $data['w'] = $GLOBALS['WEEK'][date('w', strtotime($data['dt']))];
            $this->msg_json(1, '操作成功', $data);
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    function punchParameter() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_kqsjgz = spClass('m_kqsjgz');
        $m_shop = spClass('m_shop');
        $m_department = spClass('m_department');
        $department = $m_department->findAll('', '', 'id,pid,department');
        $shop = $m_shop->findAll('', '', 'id,shopname');
        foreach ($shop as $k => $v) {
            $shops[$v['id']] = $v['shopname'];
        }
        $result = $m_kqsjgz->findAll('pid = 0 and did = 0', 'sort asc');
        foreach ($result as $k => $v) {
            $result[$k]['children'] = $m_kqsjgz->findAll('pid = ' . $v['id'], 'sort asc');
        }
        foreach ($department as $k => $v) {
            $results[$k]['id'] = $v['id'];
            $results[$k]['name'] = $shops[$v['pid']] . '->' . $v['department'];
            $kqsjgz = $m_kqsjgz->findAll('pid = 0 and did = ' . $v['id'], 'sort asc');
            if (empty($kqsjgz)) {
                $kqsjgz = array();
                foreach ($result as $v1) {
                    $data = array(
                        'name' => $v1['name'],
                        'sort' => $v1['sort'],
                        'stime' => $v1['stime'],
                        'etime' => $v1['etime'],
                        'qtype' => $v1['qtype'],
                        'iskq' => $v1['iskq'],
                        'isxx' => $v1['isxx'],
                        'pid' => 0,
                        'did' => $v['id'],
                    );
                    $ad = $m_kqsjgz->create($data);
                    $data['id'] = $ad;
                    $kqsjgz[] = $data;
                    foreach ($v1['children'] as $v2) {
                        $data = array(
                            'name' => $v2['name'],
                            'sort' => $v2['sort'],
                            'stime' => $v2['stime'],
                            'etime' => $v2['etime'],
                            'qtype' => $v2['qtype'],
                            'iskq' => $v2['iskq'],
                            'isxx' => $v2['isxx'],
                            'pid' => $ad,
                            'did' => $v['id'],
                        );
                        $m_kqsjgz->create($data);
                    }
                }
            }
            foreach ($kqsjgz as $k1 => $v1) {
                $kqsjgz[$k1]['children'] = $m_kqsjgz->findAll('pid = ' . $v1['id'], 'sort asc');
            }
            $results[$k]['kqsjgz'] = $kqsjgz;
        }
        $this->results = $results;
    }
    
    function savepunch(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $data['stime'] = htmlspecialchars($this->spArgs('stime'));
        $data['etime'] = htmlspecialchars($this->spArgs('etime'));
        $m_kqsjgz = spClass('m_kqsjgz');
        $up = $m_kqsjgz->update(array('id'=>$id),$data);
        if($up){
            $data['id'] = $id;
            $this->msg_json(1, '修改成功',$data);
        }else{
            $this->msg_json(0, '网络错误');
        }
    }

    function punchTotel() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_admin = spClass('m_admin');
        $m_kqanay = spClass('m_kqanay');
        $m_kqerr = spClass('m_kqerr');
        $month = $this->spArgs('month', date('Y-m'));
        $mtime = strtotime($month . '-01 00:00:01');
        $month = date('Y-m', $mtime);
        $page_con['month'] = $month;
        $name = trim(urldecode(htmlspecialchars($this->spArgs('name'))));
        $con = 'status = 1 and shopid = ' . $admin['shopid'];
        if ($name) {
            $con .= ' and (`name` like "%' . $name . '%" or `departmentname` like "%' . $name . '%" or `positionname` like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $m_admin->spPager($this->spArgs('page', 1), 20)->findAll($con, '', 'id,name,departmentname,positionname,dir');
        foreach ($results as $k => $v) {
            $cd = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "迟到"');
            $zt = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "早退"');
            $yc = $m_kqerr->findCount('uid = ' . $v['id'] . ' and date like "' . $month . '%" and status >= 4');
            $qj = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and states like "%假%"');
            $wc = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and (states like "%约见%" or states like "%外派%")');
            $ysb = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%"');
            $wdk = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "未打卡"');
            $shi = $m_kqanay->findAll('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and time > 0', '', 'dt');
            $jb = spClass('m_kqdkjb')->findCount('uid = ' . $v['id'] . ' and type = 1 and dkdt like "' . $month . '%" and (dkdt like "%21:%" or dkdt like "%22:%" or dkdt like "%23:%")');
            $r = array();
            foreach ($shi as $k1 => $v1) {
                $r[] = $v1['dt'];
            }
            $ssb = count(array_unique($r));
            $row = array('cd' => $cd, 'zt' => $zt, 'yc' => $yc, 'qj' => $qj / 2, 'ysb' => $ysb / 2, 'ssb' => $ssb, 'wdk' => $wdk,'wc'=>$wc/2,'jb'=>$jb);
            $results[$k]['kqtj'] = $row;
        }
        $this->results = $results;
        $this->pager = $m_admin->spPager()->getPager();
        $this->page_con = $page_con;
        $this->month = $month;
    }

    function kqinfo(){
        $admin = $this->get_menu();
        $month = $this->spArgs('month',date('Y-m'));
        $page_con['month'] = $month;
        $month = implode('', explode('-', $month));
        $sta = date('Y-m-d H:i:s' ,strtotime($month.'01'));
        $end = date('Y-m-d H:i:s',strtotime(($month+1).'01'));
        $where = 'applydt >="'.$sta.'" and applydt < "'.$end.'"';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $where .= ' and (uname like "%'.$name.'%" or  udeptname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $m_kqinfo = spClass('m_kqinfo');
        $kqinfo = $m_kqinfo->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where);
        $this->page_con = $page_con;
        $this->results = $kqinfo;
        $this->pager = $m_kqinfo->spPager()->getPager();

    }

    function kqgoout(){
        $admin = $this->get_menu();
        $month = $this->spArgs('month',date('Y-m'));
        $page_con['month'] = $month;
        $month = implode('', explode('-', $month));
        $sta = date('Y-m-d H:i:s' ,strtotime($month.'01'));
        $end = date('Y-m-d H:i:s',strtotime(($month+1).'01'));
        $where = 'applydt >="'.$sta.'" and applydt < "'.$end.'"';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if(!empty($name)){
            $where .= ' and (uname like "%'.$name.'%" or  udeptname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }

        $m_kqinfo = spClass('m_kqgoout');
        $kqinfo = $m_kqinfo->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where);
        $this->page_con = $page_con;
        $this->results = $kqinfo;
        $this->pager = $m_kqinfo->spPager()->getPager();

    }

    function punchMonthList(){
        $admin = $this->get_menu();
        $uid = (int)$this->spArgs('uid');
        $month = $this->spArgs('month', date('Y-m'));
        $mtime = strtotime($month . '-01 00:00:01');
        $month = date('Y-m', $mtime);

        $m_kqdkjl = spClass('m_kqdkjl');
        $where = 'uid ='.$uid.' and dkdt like "'.$month.'%"';
        $results = $m_kqdkjl->findAll($where,'dkdt asc');
        foreach($results as $k=>$v){
            $results[$k]['images'] = empty($v['images'])?array():explode(',', $v['images']);
        }
        $this->results = $results;

        $page_con['month'] = $month;
        $page_con['uid'] = $uid;
        $this->page_con = $page_con;
        $m_admin = spClass('m_admin');
        $admin = $m_admin->find('id='.$uid);
        $this->user = $admin;

        $admins = $m_admin->findAll('status = 1',null,'id,departmentname,name');
        $tmp = array();
        foreach($admins as $k => $v){
            $tmp[$v['departmentname']]['name'] = $v['departmentname'];
            $tmp[$v['departmentname']]['list'][] = $v;
        }
        $this->admins = $tmp;
    }

    function replace() {
        $admin = $this->get_ajax_menu();
        $shopid = $admin['shopid'];
        $uid = (int) htmlentities($this->spArgs('uid'));
        $month = $this->spArgs('month', date('Y-m'));
        $mtime = strtotime($month . '-01 00:00:01');
        $time = strtotime('2017-01-01 00:00:00');
        $month = date('Y-m', $mtime);
        if ($mtime < $time) {
            $this->msg_json(0, '您选择的时间过早，暂无数据分析');
        }
        $m_admin = spClass('m_admin');
        if (empty($uid)) {
            $admin = $m_admin->findAll('status = 1 and shopid = ' . $shopid);
        } else {
            $admin = $m_admin->findAll('status = 1 and shopid = ' . $shopid . ' and id = ' . $uid);
        }
        foreach ($admin as $k => $v) {
            for ($i = 1; $i <= date('t', $mtime); $i++) {
                if ($i < 10) {
                    $d = $month . '-0' . $i;
                } else {
                    $d = $month . '-' . $i;
                }
                Common::kqanay($v['id'], $d, $shopid);
            }
        }
        $this->msg_json(1, '操作完成');
    }


    function hqWayList(){
 
    $name = urldecode($this->spArgs('name'));
    if(! empty ( $_FILES [$name] ['name'] )){
        $tmp_file = $_FILES [$name] ['tmp_name'];
        $file_types = explode ( ".", $_FILES [$name] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];
         /*判别是不是.xls文件，判别是不是excel文件*/
        if(strtolower ( $file_type ) != "xlsx"){
              $this->msg_json(0,'上传文件错误');
        }
        $file_name = time() .'.'. $file_type;

        $targetFile = APP_PATH . "/tmp/" . $file_name;
        $re = move_uploaded_file($tmp_file, $targetFile);
         /*是否上传成功*/
        if(!$re){
            $this->msg_json(0,'上传失败');
        }
        $res = Common::hqdaoruRow($targetFile);
      
        if($res){
          $datas = array();
          $month = $res[0];
          $uids = array();
          foreach($res as $k => $v){
            if($k > 0){
                foreach($v as $k2 => $v2){
                    if($k2 == 0){
                        $tmp['uid'] = $v2;
                        $uids[] = $v2;
                    }else{
                        if(!empty($v2)){
                            $tmp['dkdt'] = $month[$k2].' '.$v2;
                            $datas[] = $tmp;
                        }
                    }

                }
            }
          }
          $uids = implode(',',$uids);
          $m_admin = spClass('m_admin');
          $adms = $m_admin->findAll();
          $adms2 = array();
          foreach($adms as $k => $v){
            $adms2[$v['number']] = $v;
          }
        
          $m_kqdkjl = spClass('m_kqdkjl');
          foreach($datas as $k => $v){
            $data = array();
            $data['uid'] = $adms2[$v[uid]]['id'];
            $data['dkdt'] = $v[dkdt];
            $add = $m_kqdkjl->create($data);
          }
       
          $this->msg_json(1,'导入完成');
        }else{
          
        }
      }else{
        $this->msg_json(0,'未找到上传文件');
      }
    }
}

?>
