
<?php

/**
 * Description of process
 * 流程管理
 * @author IndexController
 */
class process extends IndexController {

    //流程申请
    function processreques() {
        
    }

    //我的申请
    function myreques() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int) htmlspecialchars($this->spArgs('sid'));
        $type = (int) htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['type']][] = $v;
        }
        $this->set = $set;
        $con = 'del = 0 and uid = ' . $user['id'] . ' and comid = ' . $user['cid'];
        if ($type == 1) {
            $con .= ' and status > 2 and nowcheckid = 0';
            $page_con['type'] = 1;
        }
        if ($type == 2) {
            $con .= ' and status = 2';
            $page_con['type'] = 2;
        }
        if ($sid) {
            $con .= ' and modelid = ' . $sid;
            $page_con['sid'] = $sid;
        }
        if ($applydt) {
            $con .= ' and applydt = "' . $applydt . '"';
            $page_con['applydt'] = $applydt;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_flow_bill->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //待办、处理
    function waitfor() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set = spClass('m_flow_set');
        $sid = (int) htmlspecialchars($this->spArgs('sid'));
        $type = (int) htmlspecialchars($this->spArgs('type'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['type']][] = $v;
        }
        $this->set = $set;
        $con = 'del = 0 and comid = '.$user['cid'];
        if ($type == 1) {
            $con .= ' and allcheckid like "%,' . $user['id'] . ',%"';
            $page_con['type'] = $type;
        } else {
            $con .= ' and nowcheckid like "%,' . $user['id'] . ',%"';
        }
        if ($sid) {
            $con .= ' and modelid = ' . $sid;
            $page_con['sid'] = $sid;
        }
        if ($applydt) {
            $con .= ' and applydt = "' . $applydt . '"';
            $page_con['applydt'] = $applydt;
        }
        if ($name) {
            $con .= ' and (uname like "%' . $name . '%" or dname like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $m_flow_bill->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_flow_bill->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //流程设置
    function processet() {
        $user = $this->islogin();
        $m_flow_set = spClass('m_flow_set');
        $results = $m_flow_set->findAll();
        $this->results = $results;
    }
    
    function saveCourse() {
        $user = $this->islogin();
        $data['sid'] = (int) htmlspecialchars($this->spArgs('sid'));
        $data['pid'] = (int) htmlspecialchars($this->spArgs('pid'));
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['checktype'] = htmlspecialchars($this->spArgs('checktype'));
        $data['courseact'] = htmlspecialchars($this->spArgs('courseact'));
        $m_flow_course = spClass('m_flow_course');
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写步骤名称');
        }
        if (empty($data['checktype'])) {
            $this->msg_json(0, '请选择审核对象');
        } else if ($data['checktype'] == 'rank') {
            $data['checktypename'] = trim(htmlspecialchars($this->spArgs('checktypename')));
            if (!empty($data['checktypename'])) {
                $position = spClass('m_position')->find(array('name' => $data['checktypename']));
                if ($position) {
                    $data['checktypeid'] = $position['id'];
                } else {
                    $data['checktypeid'] = spClass('m_position')->create(array('name' => $data['checktypename']));
                }
            } else {
                $this->msg_json(0, '请选择审核职位');
            }
        } else if ($data['checktype'] == 'user') {
            $data['checktypeid'] = trim(htmlspecialchars($this->spArgs('uid')));
            $cuser = spClass('m_user')->find(array('id' => $data['checktypeid']));
            if ($cuser) {
                $data['checktypename'] = $cuser['name'];
            } else {
                $this->msg_json(0, '请选择审核人');
            }
        } else {
            $data['checktypeid'] = '';
            $data['checktypename'] = '';
        }
        $data['opttime'] = time();
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        if (empty($id)) {
            if (empty($data['sid'])) {
                $this->msg_json(0, '未找到模块ID，请刷新重试');
            }
            //$ad = $m_flow_course->create($data);
            if ($ad) {
                $data['id'] = $ad;
                $this->msg_json(1, '新增成功', $data);
            } else {
                $this->msg_json(0, '新增失败');
            }
        } else {
            unset($data['sid']);
            unset($data['pid']);
            $re = $m_flow_course->find(array('id' => $id,'cid'=>$user['cid']));
            if ($re) {
                $up = $m_flow_course->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $id;
                    $this->msg_json(2, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '数据有误，修改失败');
            }
        }
    }

    function getCourse() {
        $user = $this->islogin();
        $id = (int) $this->spArgs('id');
        $m_flow_course = spClass('m_flow_course');
        $m_flow_set = spClass('m_flow_set');
        $re = $m_flow_set->find(array('id' => $id));
        if ($re) {
            $results = $m_flow_course->ress($user['cid'],$id);
            $results = empty($results) ? array() : $results;
            $this->msg_json(1, '获取成功', $results, $re['id'] . '.' . $re['name']);
        } else {
            $this->msg_json(0, '获取失败');
        }
    }

    //流程设置弹窗
    function procealert() {
        
    }

    //我的申请 删除
    function del()
    {
        //params check
        $id  = (int) htmlspecialchars($this->spArgs('id'));
        $mid = (int) htmlspecialchars($this->spArgs('mid'));
        if(!is_numeric($id) || !is_numeric($mid)) $this->msg_json(0, '分配id必须为数字');

        //数据表del置1 flow_bill关联表del置1
        $table_data = spClass('m_flow_set')->find(array('id' => $mid));
        $model_name = 'm_'.$table_data['table'];

        $del_id  = spClass($model_name)->find(array('id' => $id), '', 'id');
        if($del_id){
            spClass($model_name)->update(array('id' => $id), array('del' => 1));
            spClass('m_flow_bill')->update(array('tid' => $id, 'modelid' => $mid), array('del' => 1));
        }
    }

}
