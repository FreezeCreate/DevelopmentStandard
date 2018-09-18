<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class administrator extends IndexController {

    public function index() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $admin_name = $this->spArgs('admin');
        $this->admin_name = $admin_name;
        $con = '1 = 1';
        if(!empty($admin['shopid'])){
            $con .= ' and shopid = '.$admin['shopid'];
        }
        if ($admin_name) {
            $con .= " and username like '%" . $admin_name . "%'";
        }
        $m_user = spClass("m_user");
        $m_role = spClass('m_role');
        $admin = $m_user->findAll($con);
        foreach ($admin as $k => $v) {
            if ($v['role']) {
                $tmp_role = json_decode($v['role']);
//                unset($admin[$k]['admin']);
                foreach ($tmp_role as $vv) {
                    if ($vv) {
                        $tmp_role_name = $m_role->find("id=" . $vv);
                        $admin[$k]['admin'].=$tmp_role_name['name'] . ",";
                    }
                }
            }
        }
        print_r($admin);
        $this->admin = $admin;
    }


    public function save() {
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

    public function editRole() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
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
        if($admin['shopid']>0){
            $con .= ' and branch = 1';
        }
        $results = $m_auth->getMenu($con,'sort asc');
        $this->results = $results;
    }

    public function delete() {
        $id = $this->spArgs('id');
        $m_role = spClass("m_role");
        $m_user = spClass("m_user");
        $role = $m_role->find("id=" . $id);
        if ($role) {
            $a = null;
            $admin = $m_user->findAll("1=1 and id!=" . $_SESSION['admin']['id'], null, 'role');
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
//                $rr[]=$m_user->update("id=".$v['id'],'role='.json_encode($tmp));
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

    public function add() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        //查询所有角色
        $m_role = spClass("m_role");
        $role = $m_role->findAll("1=1");
        $this->result = $role;
    }

    public function edit() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $id = $this->spArgs("id");
        if ($id == 1 || $id == $_SESSION['admin']['id']) {
            $this->error("你没有此权限！", spUrl("main", "index"));
        }
        $this->id = $id;
        $m_role = spClass("m_role");
        $m_user = spClass("m_user");
        $admin = $m_user->find("id=" . $id);
        $admin['role'] = json_decode($admin['role'], true);
        $this->results = $admin;
        //查询所有角色
        $m_role = spClass("m_role");
        $role = $m_role->findAll("1=1");
        $this->result = $role;
    }

    public function save_auth() {
        $post = $this->spArgs();
        $m_user = spClass("m_user");
        $username = $post['username'];
        $password = $post['password'];
        $auth_arr = $this->spArgs('auth');
        $confirm_password = $post['confirm_password'];
        $id = $this->spArgs("id");
        if (!$username) {
            $this->msg_json(0, "用户名不能为空！");
        }
        if ($id == 0) {
            if (!$password) {
                $this->msg_json(0, "密码不能为空！");
            } elseif (!$confirm_password) {
                $this->msg_json(0, "确认密码不能为空！");
            } elseif ($password != $confirm_password) {
                $this->msg_json(0, "两次密码不一样！");
            } else {
                $unique = $m_user->find("username=" . "'" . $username . "'");
                if ($unique) {
                    $this->msg_json(0, "已经存在该管理员！请重新输入。。。");
                } else {
                    $create['role'] = json_encode($auth_arr);
                    $create['username'] = $username;
                    $create['password'] = md5(md5($password));
//                    dump($create);die;
                    $re = $m_user->create($create);
                }
            }
        } else {
            $update['username'] = $username;
            if ($password == $confirm_password && $password != null) {
                $update['password'] = md5(md5("'" . $password . "'"));
            }
            $update['role'] = json_encode($auth_arr);
            $re = $m_user->update("id=" . $id, $update);
        }
        if ($re) {
            $this->msg_json(1, "操作成功！");
        } else {
            $this->msg_json(0, "操作失败！");
        }
    }

    public function del_auth() {
        $id = $this->spArgs("id");
        $m_user = spClass("m_user");
        $m_role = spClass("m_role");
        $a = null;
        $b = null;
        if ($id != 1 && $id != $_SESSION['admin']['id']) {
            $admin = $m_user->find("id=" . $id);
            $admin_role = json_decode($admin['role']);
            $role_all = $m_user->findAll("1=1 and id!=" . $id, null, 'role');
            foreach ($role_all as $k => $v) {
                $tmp = json_decode($v['role']);
                foreach ($tmp as $kk => $vv) {
                    $a[] = $vv;
                }
            }
            foreach ($admin_role as $k1 => $v1) {
                if (!in_array($v1, $a)) {
                    $b[] = $v1;
                }
            }
            if ($b != null) {
                foreach ($b as $k => $v) {
                    $m_role->delete("id=" . $v);
                }
            }
            $re = $m_user->delete("id=" . $id);
            if ($re) {
                $this->msg_json(1, "删除成功！");
            } else {
                $this->msg_json(0, "操作有误！");
            }
        } else {
            $this->msg_json(0, '您无此权限！');
        }
    }

}
