<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class organization extends IndexController {
    /*     * *****
     * 分公司管理
     * ***** */

    function branch() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $number = trim(htmlspecialchars($this->spArgs('number')));
        $shopname = trim(htmlspecialchars($this->spArgs('shopname')));
        $m_shop = spClass('m_shop');
        if ($admin['shopid'] > 1) {
            $con = 'id = ' . $admin['shopid'];
        } else {
            $con = '1 = 1';
        }
        if (!empty($number)) {
            $con .= ' and number like "%' . $number . '%"';
            $page_con['number'] = $number;
        }
        if (!empty($shopname)) {
            $con .= ' and shopname like "%' . $shopname . '%"';
            $page_con['shopname'] = $shopname;
        }
        $results = $m_shop->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'sort asc,number asc');
        $this->results = $results;
        $this->pager = $m_shop->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveBranch() {
        $m_shop = spClass('m_shop');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['shopname'] = htmlspecialchars($this->spArgs('shopname'));
        $data['number'] = trim(htmlspecialchars($this->spArgs('number')));
        $data['telphone'] = trim(htmlspecialchars($this->spArgs('telphone')));
        $data['address'] = trim(htmlspecialchars($this->spArgs('address')));
        $data['email'] = trim(htmlspecialchars($this->spArgs('email')));
        $data['fax'] = trim(htmlspecialchars($this->spArgs('fax')));
        $data['remark'] = trim(htmlspecialchars($this->spArgs('remark')));
        $data['sort'] = (int) htmlspecialchars($this->spArgs('sort'));
        $data['sort'] = empty($data['sort']) ? 100 : $data['sort'];
        if (empty($data['shopname'])) {
            $this->msg_json(0, '请填写公司名称');
        }
        if ($id) {
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'editBranch');
            $re = $m_shop->find(array('id' => $id));
            if ($re) {
                $up = $m_shop->update(array('id' => $id), $data);
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
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'addBranch');
            $re = $m_shop->find(array('shopname' => $data['shopname']));
            if ($re) {
                $this->msg_json(0, '该公司已添加');
            } else {
                $ad = $m_shop->create($data);
                if ($ad) {
                    $this->msg_json(1, '添加成功');
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delBranch() {
        $admin = $this->get_ajax_menu();
        $m_shop = spClass('m_shop');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $re = $m_shop->find(array('id' => $id));
        if ($re) {
            $del = $m_shop->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }

    /*     * *****
     * 部门管理
     * ***** */

    function department() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $pid = (int) htmlspecialchars($this->spArgs('pid'));
        $number = trim(htmlspecialchars($this->spArgs('number')));
        $department = trim(htmlspecialchars($this->spArgs('department')));
        $m_shop = spClass('m_shop');
        $m_department = spClass('m_department');
        if ($admin['shopid'] > 1) {
            $con = 'pid = ' . $admin['shopid'];
            $shop = $m_shop->findAll(array('id' => $admin['shopid']), '', 'id,shopname');
        } else {
            $shop = $m_shop->findAll('', '', 'id,shopname');
            $con = '1 = 1';
        }
        if (!empty($pid)) {
            $con .= ' and pid = ' . $pid;
            $page_con['pid'] = $pid;
        }
        foreach ($shop as $k => $v) {
            $shops[$v['id']] = $v['shopname'];
        }
        $this->shops = $shops;
        if (!empty($number)) {
            $con .= ' and number like "%' . $number . '%"';
            $page_con['number'] = $number;
        }
        if (!empty($department)) {
            $con .= ' and department like "%' . $department . '%"';
            $page_con['department'] = $department;
        }
        $results = $m_department->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'pid asc,sort asc');
        $this->results = $results;
        $this->pager = $m_department->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveDepartment() {
        $m_department = spClass('m_department');
        $m_admin = spClass('m_admin');
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
            $user = $m_admin->find(array('id'=>$data['principalid']),'','id,name');
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
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'editDepartment');
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
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'addDepartment');
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
        $admin = $this->get_ajax_menu();
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

    /*     * *****
     * 职位管理
     * ***** */

    function position() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $departmentid = (int) htmlspecialchars($this->spArgs('departmentid'));
        $number = trim(htmlspecialchars($this->spArgs('number')));
        $name = trim(htmlspecialchars($this->spArgs('name')));
        $m_shop = spClass('m_shop');
        $m_department = spClass('m_department');
        $m_position = spClass('m_position');
        if ($admin['shopid'] > 1) {
            $shop = $m_shop->findAll(array('id' => $admin['shopid']), '', 'id,shopname');
            $department = $m_department->findAll(array('pid' => $admin['shopid']));
            foreach ($department as $k => $v) {
                $dresults[$v['id']] = $v['department'];
                $ids .= $v['id'] . ',';
            }
            $con = 'departmentid in (' . $ids . '0)';
        } else {
            $shop = $m_shop->findAll('', '', 'id,shopname');
            foreach ($shop as $k => $v) {
                $shops[$v['id']] = $v['shopname'];
            }
            $department = $m_department->findAll();
            foreach ($department as $k => $v) {
                $dresults[$v['id']] = $shops[$v['pid']].'-'.$v['department'];
                $ids .= $v['id'] . ',';
            }
            $con = '1 = 1';
        }
        if (!empty($departmentid)) {
            $con .= ' and departmentid = ' . $departmentid;
            $page_con['departmentid'] = $departmentid;
        }

        $this->dresults = $dresults;
        if (!empty($number)) {
            $con .= ' and number like "%' . $number . '%"';
            $page_con['number'] = $number;
        }
        if (!empty($name)) {
            $con .= ' and name like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $m_position->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'departmentid asc,sort asc');
        $this->results = $results;
        $this->pager = $m_department->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function savePosition() {
        $m_shop = spClass('m_shop');
        $m_department = spClass('m_department');
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['number'] = trim(htmlspecialchars($this->spArgs('number')));
        $data['departmentid'] = trim(htmlspecialchars($this->spArgs('departmentid')));
        $data['remark'] = trim(htmlspecialchars($this->spArgs('remark')));
        $data['sort'] = (int) htmlspecialchars($this->spArgs('sort'));
        $data['sort'] = empty($data['sort']) ? 100 : $data['sort'];
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写职位名称');
        }
        if (empty($data['departmentid'])) {
            $this->msg_json(0, '请选择所属部门');
        }
        if ($id) {
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'editPosition');
            $re = $m_position->find(array('id' => $id));
            if ($re) {
                $up = $m_position->update(array('id' => $id), $data);
                if ($up) {
                    $data['id'] = $re['id'];
                    $department = $m_department->find(array('id'=>$data['departmentid']),'','id,pid,department');
                    $shop = $m_shop->find(array('id'=>$department['pid']),'','shopname');
                    $data['department'] = $shop['shopname'].'-'.$department['department'];
                    $this->msg_json(2, '修改成功', $data);
                } else {
                    $this->msg_json(0, '修改失败');
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'addPosition');
            $re = $m_position->find(array('name' => $data['name'], 'departmentid' => $data['departmentid']));
            if ($re) {
                $this->msg_json(0, '该职位已添加');
            } else {
                $ad = $m_position->create($data);
                if ($ad) {
                    $this->msg_json(1, '添加成功');
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delPosition() {
        $admin = $this->get_ajax_menu();
        $m_position = spClass('m_position');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $re = $m_position->find(array('id' => $id));
        if ($re) {
            $del = $m_position->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }

    /*     * *****
     * 菜单管理
     * ***** */

    function menu() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_auth = spClass('m_auth');
        $results = $m_auth->getMenu('hide = 0 and del = 0', 'sort asc','id,title,control,way,pid,sort,branch');
        $this->results = $results;
    }

    function saveMenu() {
        $m_auth = spClass('m_auth');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['control'] = trim(htmlspecialchars($this->spArgs('control')));
        $data['way'] = trim(htmlspecialchars($this->spArgs('way')));
        $data['pid'] = trim(htmlspecialchars($this->spArgs('pid')));
        $data['branch'] = (int) htmlspecialchars($this->spArgs('branch'));
        $data['sort'] = (int) htmlspecialchars($this->spArgs('sort'));
        $data['sort'] = empty($data['sort']) ? 100 : $data['sort'];
        if (empty($data['title'])) {
            $this->msg_json(0, '请填写菜单名称');
        }
        if ($id) {
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'editMenu');
            $re = $m_auth->find(array('id' => $id));
            if ($re) {
                $up = $m_auth->update(array('id' => $id), $data);
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
            $admin = $this->get_ajax_menu($this->spArgs('c'), 'addMenu');
            $re = $m_auth->find(array('title' => $data['title'], 'pid' => $data['pid']));
            if ($re) {
                $this->msg_json(0, '该菜单已添加');
            } else {
                $ad = $m_auth->create($data);
                if ($ad) {
                    $this->msg_json(1, '添加成功');
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delMenu() {
        $admin = $this->get_ajax_menu();
        $m_auth = spClass('m_auth');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $re = $m_auth->find(array('id' => $id));
        if ($re) {
            $del = $m_auth->delete(array('id' => $id));
            if ($del) {
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在');
        }
    }
    
    
    public function role() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_auth = spClass("m_auth");
        $m_role = spClass("m_role");
        $username = $this->spArgs("username");
        $this->username = $username;
        $con = '1 = 1';
        if($admin['shopid']!=1){
            $con .= ' and shopid = '.$admin['shopid'];
        }
        if ($username) {
            $con .= " and name like '%" . $username . "%'";
        }
        //查询角色列表
        $re_role = $m_role->findAll($con);
        //查询管理员对应的权限
        foreach ($re_role as $k => $v) {
            $tmp_promission = json_decode($v['promission'],true);
            foreach ($tmp_promission as $kk => $vv) {
                $tmp_auth = $m_auth->find("id=" . $vv);
                $re_role[$k]['auth'].=$tmp_auth['title'] . ",";
            }
        }
        $this->role = $re_role;
    }

    public function addRole() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        //查找一级菜单
        $m_auth = spClass("m_auth");
        $con = 'del = 0';
        if($admin['shopid']>0){
            $con .= ' and branch = 1';
        }
        $results = $m_auth->getMenu($con,'sort asc');
        $this->results = $results;
    }
    
    public function editRole() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
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
        if($admin['shopid']>1){
            $con .= ' and branch = 1';
        }
        $results = $m_auth->getMenu($con,'sort asc');
        $this->results = $results;
    }
    
    public function saveRole() {
        $admin = $this->get_ajax_menu();
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
                    $create['shopid'] = $admin['shopid'];
                    $create['name'] = $post['name'];
                    $create['promission'] = json_encode($arr_auth);
                    $re = $m_role->create($create);
                }
            }
        } else {
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
        $id = $this->spArgs('id');
        $m_role = spClass("m_role");
        $m_admin = spClass("m_admin");
        $role = $m_role->find("id=" . $id);
        if ($role) {
            $a = null;
            $admin = $m_admin->findAll("1=1 and id!=" . $_SESSION['admin']['id'], null, 'role');
            foreach ($admin as $k => $v) {
//                echo $v['role'];
                $tmp = json_decode($v['role']);
                foreach ($tmp as $kk => $vv) {
//                    $in.=','.$vv;
                    if ($vv == $id) {
                        $a.="a";
//                        echo $vv."***".$id;
//                        $this->msg_json(0,$vv."***".$id);
//                        $this->msg_json(0,"该角色已经被分配，不能删除！");
//                        unset($tmp[$kk]);
//                    }
//                        $this->msg_json(0,$vv."***".$id);
//                        echo $vv."***".$id;
//                        $re=$m_role->delete('id='.$id);
//                        if($re){
//                            $this->msg_json(1,"操作成功！");
//                        }else{
//                            $this->msg_json(0,"操作失败！");
//                        }
                    }
                }
//                dump($tmp);
//                $rr[]=$m_admin->update("id=".$v['id'],'role='.json_encode($tmp));
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

}
