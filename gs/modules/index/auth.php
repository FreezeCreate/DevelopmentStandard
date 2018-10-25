<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class auth extends IndexController {
    /*     * *****
     * 流程设置
     * ***** */

    function setting() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $results = $m_flow_set->findAll();
        $this->results = $results;
    }

    function saveCourse() {
        $admin = $this->get_ajax_menu();
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
        } else if ($data['checktype'] == 'admin') {
            $data['checktypeid'] = trim(htmlspecialchars($this->spArgs('uid')));
            $cadmin = spClass('m_admin')->find(array('id' => $data['checktypeid']));
            if ($cadmin) {
                $data['checktypename'] = $cadmin['name'];
            } else {
                $this->msg_json(0, '请选择审核人');
            }
        } else {
            $data['checktypeid'] = '';
            $data['checktypename'] = '';
        }
        $data['opttime'] = time();
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        if (empty($id)) {
            if (empty($data['sid'])) {
                $this->msg_json(0, '未找到模块ID，请刷新重试');
            }
            $ad = $m_flow_course->create($data);
            if ($ad) {
                $data['id'] = $ad;
                $this->msg_json(1, '新增成功', $data);
            } else {
                $this->msg_json(0, '新增失败');
            }
        } else {
            unset($data['sid']);
            unset($data['pid']);
            $re = $m_flow_course->find(array('id' => $id));
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
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Max-Age: 1000');
        $id = (int) $this->spArgs('id');
        $m_flow_course = spClass('m_flow_course');
        $m_flow_set = spClass('m_flow_set');
        $re = $m_flow_set->find(array('id' => $id));
        if ($re) {
            $results = $m_flow_course->ress($id);
            $results = empty($results) ? array() : $results;
            $this->msg_json(1, '获取成功', $results, $re['id'] . '.' . $re['name']);
        } else {
            $this->msg_json(0, '获取失败');
        }
    }

    function delCourse() {
        $admin = $this->get_ajax_menu();
        $m_flow_course = spClass('m_flow_course');
        $id = (int) $this->spArgs('id');
        $re = $m_flow_course->find(array('id' => $id));
        if ($re) {
            $del = $m_flow_course->delete(array('id' => $id));
            if ($del) {
                $m_flow_course->update(array('pid' => $id), array('pid' => $re['pid'], 'level' => $re['level']));
                $this->msg_json(1, '删除成功');
            } else {
                $this->msg_json(0, '删除失败');
            }
        }
    }

    /**
     * TODO 员工关系的提醒
     */
    function personnel() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $did = (int) htmlspecialchars($this->spArgs('did'));
        $number = urldecode(trim(htmlspecialchars($this->spArgs('number'))));
        $name = urldecode(trim(htmlspecialchars($this->spArgs('name'))));
        $m_admin = spClass('m_admin');
        $m_department = spClass('m_department');
        //员工关系内容
        $m_relation = spClass('m_relation');
        
        $m_position = spClass('m_position');
        $con = 'del = 0 and cid = ' . $admin['cid'];
        $department = $m_department->findAll('pid = ' . $admin['cid'], 'sort asc');
        foreach ($department as $k => $v) {
            $dresults[$v['id']] = $v['name'];
        }
        if (!empty($did)) {
            $con .= ' and did = ' . $did;
            $page_con['did'] = $did;
        }
        if (!empty($name)) {
            $con .= ' and (name like "%' . $name . '%" or pname like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $this->dresults = $dresults;
        $results = $m_admin->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'number asc');
        foreach ($results as $_k => $_v){
            $re_data = $m_relation->find('`table` like "%admin%" and tid='.$_v['id'].' and UNIX_TIMESTAMP(noticetime)<'.(time() + 24*60*60).' and UNIX_TIMESTAMP(noticetime)>'.(time() - 24*60*60).'');
            if (empty($re_data)){
                $rela_data[] = [];
                continue;
            }else {
                $rela_data[$re_data['tid']] = $re_data;
                continue;
            }
        }
        $this->re_data = $rela_data;
        $this->results = $results;
        $this->pager = $m_admin->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function addPersonnel() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $m_admin = spClass('m_admin');
        $result = $m_admin->find(array('id' => $id, 'del' => 0));
        if ($result) {
            $result['role'] = empty($result['role']) ? array(0) : json_decode($result['role'], true);
            $this->result = $result;
        }
        $role = spClass('m_role')->findAll('shopid = ' . $admin['cid'], '', 'id,name');
        $this->role = $role;
    }

    function personnelInfo() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $m_admin = spClass('m_admin');
        $result = $m_admin->find(array('id' => $id, 'del' => 0));
        if ($result) {
            $result['role'] = empty($result['role']) ? array(0) : json_decode($result['role'], true);
            $this->result = $result;
        }
        $role = spClass('m_role')->findAll('shopid = ' . $admin['cid'], '', 'id,name');
        $this->role = $role;
    }

    function savePersonnel() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
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
        $data['did'] = (int) htmlspecialchars($this->spArgs('did'));
        $data['dir'] = (int) htmlspecialchars($this->spArgs('dir'));
        $data['sid'] = (int) htmlspecialchars($this->spArgs('sid'));
        $data['sname'] = (int) htmlspecialchars($this->spArgs('sname'));
        $data['pname'] = trim(htmlspecialchars($this->spArgs('pname')));
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
        if (empty($data['did'])) {
            $this->msg_json(0, '请选择部门');
        } else {
            $department = $m_department->find(array('id' => $data['did']), '', 'id,name,pid');
            $data['dname'] = $department['name'];
            $company = spClass('m_company')->find(array('id' => $department['pid']));
            $data['cid'] = $company['id'];
            $data['cname'] = $company['name'];
        }
        if (empty($data['dir'])) {
            $this->msg_json(0, '请选择员工状态');
        }
        if (empty($data['workdate'])) {
            $this->msg_json(0, '请选择入职日期');
        }
        if (!empty($data['pname'])) {
            $position = $m_position->find(array('name' => $data['pname']), '', 'id,name');
            if (empty($position)) {
                $ad = $m_position->create(array('name' => $data['pname']));
                $data['pid'] = $ad;
            } else {
                $data['pid'] = $position['id'];
                $data['pname'] = $position['name'];
            }
        }
        if ($admin['id'] > 1) {
            $data['cid'] = $admin['cid'];
            $data['cname'] = $admin['cname'];
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
            $re = $m_admin->find('username = "' . $data['username'] . '" or (number = "' . $data['number'] . '" and cid = '.$data['cid'].')');
            if ($re) {
                $this->msg_json(0, '登录名或编号重复');
            } else {
                $ad = $m_admin->create($data);
                if ($ad) {
                    $data['id'] = $ad;
                    $data['number'] = empty($data['number']) ? '' : $data['number'];
                    $data['birthday'] = empty($data['birthday']) ? '' : $data['birthday'];
                    $data['pid'] = empty($data['positionid']) ? '' : $data['pid'];
                    $data['pname'] = empty($data['positionname']) ? '' : $data['pname'];
                    $data['email'] = empty($data['email']) ? '' : $data['email'];
                    $data['positivedt'] = empty($data['positivedt']) ? '' : $data['positivedt'];
                    $this->msg_json(1, '添加成功', $data);
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        }
    }

    function delPersonnel() {
        $admin = $this->get_ajax_menu($this->c, 'personnel');
        $model = spClass('m_admin');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'del' => 0));
        if (empty($result)) {
            $this->msg_json(0, '数据不存在');
        }
        $del = $model->update(array('id' => $id), array('del' => 1));
        if ($del) {
            $this->msg_json(1, '删除成功');
        } else {
            $this->msg_json(0, '操作失败');
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
        if ($admin['id'] != 1) {
            $con .= ' and shopid = ' . $admin['cid'];
        }
        if ($username) {
            $con .= " and name like '%" . $username . "%'";
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
        $this->results = $re_role;
    }

    public function addRole() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        //查找一级菜单
        $m_auth = spClass("m_auth");
        $con = 'del = 0';
        $results = $m_auth->getMenu($con, 'sort asc');
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
        if ($admin['id'] > 1) {
            $con .= ' and branch = 1';
        }
        $results = $m_auth->getMenu($con, 'sort asc');
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
                $according = $m_role->find("name='" . $post['name'] . "' and shopid = ".$admin['cid']);
                if ($according) {
                    $this->msg_json(0, "已经存在该角色名称！");
                } else {
                    $create['shopid'] = $admin['cid'];
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
    
    /*     * *****
     * 菜单管理
     * ***** */
    
    function menu() 
    {
//        $result = $this->get_menu();
//        $this->menu = $result['menu'];
//        $admin = $result['admin'];
//        $this->admin = $admin;
        $oid = htmlentities($this->spArgs('oid',0));
        $m_auth = spClass('m_auth');
        $page_con['oid'] = $oid;
        $results = $m_auth->getMenu('hide = 0 and del = 0 and oid = '.$oid, 'sort asc','id,title,control,way,pid,sort,branch,img');
        $this->results = $results;
        $this->page_con = $page_con;
    }

    function saveMenu() {
        $m_auth = spClass('m_auth');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['control'] = trim(htmlspecialchars($this->spArgs('control')));
        $data['way'] = trim(htmlspecialchars($this->spArgs('way')));
        $data['pid'] = trim(htmlspecialchars($this->spArgs('pid')));
        $data['oid'] = (int) htmlspecialchars($this->spArgs('oid'));
        $data['img'] = htmlspecialchars($this->spArgs('img'));
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
            $re = $m_auth->find(array('title' => $data['title'], 'pid' => $data['pid'],'oid'=>$data['oid']));
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
    

}
