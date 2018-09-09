
<?php

/**
 * Description of message
 * 基本信息设置
 * @author IndexController
 */
class message extends IndexController {

    //权限管理
    public function role() {
        $user = $this->islogin();
        $m_auth = spClass("m_auth");
        $m_role = spClass("m_role");
        $name = $this->spArgs("name");
        $con = 'cid = '.$user['cid'];
        if ($name) {
            $con .= " and name like '%" . $name . "%'";
            $page_con['name'] = $name;
        }
        //查询角色列表
        $re_role = $m_role->findAll($con);
        //查询管理员对应的权限
        foreach ($re_role as $k => $v) {
            $tmp_promission = json_decode($v['promission'], true);
            foreach ($tmp_promission as $kk => $vv) {
                $tmp_auth = $m_auth->find("id=" . $vv);
                $re_role[$k]['auth'].=$tmp_auth['title'] . ",";
            }
        }
        $this->role = $re_role;
        $this->page_con = $page_con;
    }

    public function addRole() {
        $user = $this->islogin();
        //查找一级菜单
        $m_auth = spClass("m_auth");
        $con = 'del = 0';
        $results = $m_auth->getMenu(1,$con, 'sort asc');
        $this->results = $results;
    }

    public function editRole() {
        $user = $this->islogin();
        $id = $this->spArgs("id");
        $m_role = spClass("m_role");
        $re_role = $m_role->find("id=" . $id);
        $re_role['promission'] = json_decode($re_role['promission'], true);

//        dump($re_role);die;
        $this->result = $re_role;
        $this->id = $id;
        //查找一级菜单
        $m_auth = spClass("m_auth");
        $con = 'del = 0';
        $results = $m_auth->getMenu(1,$con, 'sort asc');
        $this->results = $results;
    }

    public function saveRole() {
        $user = $this->islogin();
        $m_role = spClass("m_role");
        $post = $this->spArgs();
        $id = $post['id'];
        $arr_auth = $post['auth'];
        if ($id == 0) {
            if (!$post['name']) {
                $this->msg_json(0, "角色名称必填！");
            } elseif (!$post['auth']) {
                $this->msg_json(0, "至少选择一个权限！");
            } else {
                $according = $m_role->find("name='" . $post['name'] . "'");
                if ($according) {
                    $this->msg_json(0, "已经存在该角色名称！");
                } else {
                    $create['cid'] = $user['cid'];
                    $create['name'] = $post['name'];
                    $create['promission'] = json_encode($arr_auth);
                    $re = $m_role->create($create);
                }
            }
        } else {
            $re = $m_role->find(array('id'=>$id,'cid'=>$user['cid']));
            if(empty($re)){
                $this->msg_json(0, '信息有误');
            }
            if (!$post['name']) {
                $this->msg_json(0, "角色名称必填！");
            } elseif (!$post['auth']) {
                $this->msg_json(0, "至少选择一个权限！");
            } else {
                $update['name'] = $post['name'];
                $update['promission'] = json_encode($arr_auth);
                $re = $m_role->update('id=' . $id, $update);
            }
        }
        if ($re) {
            $this->msg_json(1, "操作成功！");
        } else {
            $this->msg_json(0, "操作失败！");
        }
        $this->msg_json(1, $post);
    }

    public function delRole() {
        $user = $this->islogin();
        $id = $this->spArgs('id');
        $m_role = spClass("m_role");
        $m_user = spClass("m_user");
        $role = $m_role->find("id=" . $id.' and cid = '.$user['cid']);
        if ($role) {
            $a = null;
            $user = $m_user->findAll("cid = ".$user['cid']." and id!=" . $user['id'], null, 'role');
            foreach ($user as $k => $v) {
                $tmp = json_decode($v['role']);
                foreach ($tmp as $kk => $vv) {
                    if ($vv == $id) {
                        $a.="a";
                    }
                }
            }
        }
        if ($a != null) {
            $this->msg_json(0, "该角色已经被分配，不能删除！");
        } else {
            $re = $m_role->delete('id=' . $id);
            if ($re) {
                $this->msg_json(1, "操作成功！");
            } else {
                $this->msg_json(0, "操作失败！");
            }
        }
    }

    /*     * *****
     * 部门管理
     * ***** */

    function department() {
        $user = $this->islogin();
        $name = trim(htmlspecialchars($this->spArgs('name')));
        $m_department = spClass('m_department');
        $con = 'pid = ' . $user['cid'];
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $m_department->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'sort asc');
        $this->results = $results;
        $this->pager = $m_department->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveDepartment() {
        $user = $this->islogin();
        $m_department = spClass('m_department');
        $m_user = spClass('m_user');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['department'] = htmlspecialchars($this->spArgs('department'));
        $data['number'] = trim(htmlspecialchars($this->spArgs('number')));
        $data['pid'] = trim(htmlspecialchars($this->spArgs('pid')));
        $data['phone'] = trim(htmlspecialchars($this->spArgs('phone')));
        $data['fax'] = trim(htmlspecialchars($this->spArgs('fax')));
        $data['remark'] = trim(htmlspecialchars($this->spArgs('remark')));
        $data['sort'] = (int) htmlspecialchars($this->spArgs('sort'));
        $data['principalid'] = (int) htmlspecialchars($this->spArgs('uid'));
        if(!empty($data['principalid'])){
            $user = $m_user->find(array('id'=>$data['principalid']),'','id,name');
        }
        $data['principalname'] = $user['name'];
        $data['sort'] = empty($data['sort']) ? 100 : $data['sort'];
        if (empty($data['department'])) {
            $this->msg_json(0, '请填写部门名称');
        }
        if (empty($data['pid'])) {
            $this->msg_json(0, '请选择所属公司');
        }
        if ($id) {
            $user = $this->get_ajax_menu($this->spArgs('c'), 'editDepartment');
            $re = $m_department->find(array('id' => $id));
            if ($re) {
                $up = $m_department->update(array('id' => $id), $data);
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
            $user = $this->get_ajax_menu($this->spArgs('c'), 'addDepartment');
            $re = $m_department->find(array('department' => $data['department'], 'pid' => $data['pid']));
            if ($re) {
                $this->msg_json(0, '该部门已添加');
            } else {
                $ad = $m_department->create($data);
                if ($ad) {
                    $this->msg_json(1, '添加成功');
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delDepartment() {
        $user = $this->islogin();
        $m_department = spClass('m_department');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $re = $m_department->find(array('id' => $id));
        if ($re) {
            $del = $m_department->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }

    //设置基本信息
    function setmessage() {
        
    }

}
