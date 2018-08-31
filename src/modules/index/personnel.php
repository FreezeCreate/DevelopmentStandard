
<?php

/**
 * Description of personnel
 * 人员管理
 * @author IndexController
 */
class personnel extends IndexController {

    //员工档案
    function archives() {
        $user = $this->islogin();
        $model = spClass('m_user');
        $did = (int)htmlentities($this->spArgs('did'));
        $name = htmlspecialchars($this->spArgs('name'));
        $con = 'cid = '.$user['cid'];
        if($did){
            $con .= ' and did = '.$did;
            $page_con['did'] = $did;
        }
        if(!empty($name)){
            $con .= ' and name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
        $department = spClass('m_department')->findAll('del = 0 and pid = '.$user['cid']);
        $this->department = $department;
    }

    //员工合同
    function contract() {
        $user = $this->islogin();
        $model = spClass('m_userract');
        $type = urldecode(htmlspecialchars($this->spArgs('type')));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'cid = '.$user['cid'];
        if(!empty($type)){
            $con .= ' and httype like "%'.$type.'%"';
            $page_con['type'] = $type;
        }
        if(!empty($name)){
            $con .= ' and uname like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //入职审核
    function entrycheck() {
        $user = $this->islogin();
        $model = spClass('m_reg_company');
        $type = htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'b.cid = '.$user['cid'];
        if($type==1){
            $con .= ' and b.status > 1';
            $page_con['type'] = $type;
        }else if($type==2){
            $con .= ' and b.status = 1';
            $page_con['type'] = $type;
        }
        if($name){
            $con .= ' and (a.name like "%'.$name.'%" or b.dname like "%'.$name.'%" or b.pname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.name,b.id,b.dname,b.pname,b.applydt,b.status from '.DB_NAME.'_user as a right outer join '.DB_NAME.'_reg_company as b on a.id = b.uid where ' . $con . ' order by b.applydt desc,b.id desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        foreach($results as $k=>$v){
            switch ($v['status']) {
                case 1:
                    $results[$k]['stname'] = '待审核';
                    break;
                case 2:
                    $results[$k]['stname'] = '已通过';
                    break;
                case 3:
                    $results[$k]['stname'] = '未通过';
                    break;
                default:
                    break;
            }
            $results[$k]['applydt'] = date('Y-m-d',  strtotime($v['applydt']));
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //转正申请
    function regular() {
        $user = $this->islogin();
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
        $con = 'del = 0 and cid = '.$user['cid'];
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //离职申请
    function quit() {
        $user = $this->islogin();
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
        $con = 'del = 0 and cid = '.$user['cid'];
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //人事调动
    function transfer() {
        $user = $this->islogin();
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
        $con = 'del = 0 and cid = '.$user['cid'];
        if ($name) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

}
