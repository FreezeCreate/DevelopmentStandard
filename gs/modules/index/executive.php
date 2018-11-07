<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class executive extends IndexController {
    /*     * *****
     * 印章管理
     * ***** */

    function sealLst() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_seal = spClass('m_seal');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_seal->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_seal->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function delSeal() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'seal';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }

    function sealApply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 5));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_seal = spClass('m_seal');
        $seals = $m_seal->findAll('del = 0 and shopid = ' . $admin['shopid']);
        $this->seals = $seals;
        $m_sealapl = spClass('m_sealapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $sealid = urldecode(htmlspecialchars($this->spArgs('sealid')));
        if ($sealid) {
            $con .= ' and sealid = "' . $sealid . '"';
            $page_con['sealid'] = $sealid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_sealapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_sealapl->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function voidSealapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowVoid('sealapl', $id, $admin);
    }

    function delSealapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowDel('sealapl', $id, $admin);
    }

    //收发文管理
    function file() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $m_file = spClass('m_filesr');
        $con = '(authtype = 1 or (authtype = 2 and authid = '.$admin['shopid'].') or (authtype = 3 and authid = '.$admin['departmentid'].') or(authtype = 4 and authid = '.$admin['id'].')) and del = 0';
        if($name){
            $con .= ' and name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $m_file->spLinker()->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc');

        $this->results = $results;
        $this->pager = $m_file->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function findFile() {
        $id = (int) htmlentities($this->spArgs('id'));
        $result = spClass('m_filesr')->spLinker()->find(array('id' => $id));
        if ($result) {
            $this->msg_json(1, '获取成功', $result);
        } else {
            $this->msg_json(0, '信息有误');
        }
    }

    function saveFile() {
        $admin = $this->get_ajax_menu();
        $m_file = spClass('m_file');
        $m_filesr = spClass('m_filesr');
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['authtype'] = htmlspecialchars($this->spArgs('authtype'));
        $data['file'] = htmlspecialchars($this->spArgs('file'));
        $id = (int) htmlentities($this->spArgs('id'));
        switch ($data['authtype']) {
            case 1:
                $data['authid'] = 0;
                break;
            case 2:
                $data['authid'] = $admin['shopid'];
                break;
            case 3:
                $data['authid'] = $admin['departmentid'];
                break;
            case 4:
                $data['authid'] = $admin['id'];
                break;
            default:
                $this->msg_json(0, '请选择查看权限');
                break;
        }
        if (empty($data['name'])) {
            $file = $m_file->find(array('id' => $data['file']), '', 'filename');
            $data['name'] = $file['filename'];
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $m_filesr->find(array('id' => $id, 'del' => 0),'','id,optid');
            if (empty($re)) {
                $this->msg_json(0, '修改的信息有误');
            }
            if($re['optid']!=$admin['id']){
                $this->msg_json(0, '您不能修改该文件');
            }
            $up = $m_filesr->update(array('id' => $re['id']), $data);
            if ($up) {
                $this->msg_json(1, '更新成功');
            } else {
                $this->msg_json(0, '更新失败');
            }
        } else {
            $ad = $m_filesr->create($data);
            if ($ad) {
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        }
    }

    function delFile() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $re = spClass('m_filesr')->find(array('id' => $id, 'del' => 0),'','id,optid');
        if ($re) {
            if ($re['optid'] == $admin['id']) {
                $del = spClass('m_filesr')->update(array('id' => $re['id']), array('optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'del' => 1));
                if ($del) {
                    $this->msg_json(1, '删除成功');
                } else {
                    $this->msg_json(0, '删除失败');
                }
            } else {
                $this->msg_json(0, '您不能删除该文件');
            }
        } else {
            $this->msg_json(0, '您要删除的内容不存在');
        }
    }

    //证件管理
    function paperwork() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_paperwork = spClass('m_paperwork');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_paperwork->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_paperwork->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delPaperwork() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'paperwork';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }
    
    function paperworkApply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 5));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_paperwork = spClass('m_paperwork');
        $paperworks = $m_paperwork->findAll('del = 0 and shopid = ' . $admin['shopid']);
        $this->paperworks = $paperworks;
        $m_paperworkapl = spClass('m_paperworkapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $gid = urldecode(htmlspecialchars($this->spArgs('gid')));
        if ($gid) {
            $con .= ' and gid = "' . $gid . '"';
            $page_con['gid'] = $gid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_paperworkapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_paperworkapl->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function voidPaperworkapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowVoid('paperworkapl', $id, $admin);
    }

    function delPaperworkapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowDel('paperworkapl', $id, $admin);
    }

    //办公用品管理
    function office() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_office= spClass('m_office');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_office->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_office->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delOffice() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'office';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }
    
    function officeApply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 7));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_office = spClass('m_office');
        $offices = $m_office->findAll('del = 0 and shopid = ' . $admin['shopid']);
        $this->offices = $offices;
        $m_officeapl = spClass('m_officeapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $gid = urldecode(htmlspecialchars($this->spArgs('gid')));
        if ($gid) {
            $con .= ' and gid = "' . $gid . '"';
            $page_con['gid'] = $gid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_officeapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_officeapl->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function voidOfficeapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowVoid('officeapl', $id, $admin);
    }

    function delOfficeapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowDel('officeapl', $id, $admin);
    }

    //物料用品管理
    function materiel() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_office= spClass('m_materiel');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_office->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_office->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delMateriel() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'office';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }
    
    function materielApply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 26));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_office = spClass('m_materiel');
        $offices = $m_office->findAll('del = 0 and shopid = ' . $admin['shopid']);
        $this->offices = $offices;
        $m_officeapl = spClass('m_materielapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $gid = urldecode(htmlspecialchars($this->spArgs('gid')));
        if ($gid) {
            $con .= ' and gid = "' . $gid . '"';
            $page_con['gid'] = $gid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_officeapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_officeapl->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //车辆列表
    function carLst() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_carms= spClass('m_carms');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_carms->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_carms->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delCarms() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'carms';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }

    //车辆申请
    function carper() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 19));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_carms = spClass('m_carms');
        $carms = $m_carms->findAll('status = 1 and del = 0 and shopid = ' . $admin['shopid']);
        $this->carms = $carms;
        $m_carmsapl = spClass('m_carmsapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $gid = urldecode(htmlspecialchars($this->spArgs('gid')));
        if ($gid) {
            $con .= ' and gid = "' . $gid . '"';
            $page_con['gid'] = $gid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_carmsapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_carmsapl->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function voidCarmsapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowVoid('carmsapl', $id, $admin);
    }

    function delCarmsapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowDel('carmsapl', $id, $admin);
    }


    //个人办公用品管理
    function myoffice() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_office= spClass('m_myoffice');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $results = $m_office->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con);
        $this->results = $results;
        $this->pager = $m_office->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    function delmyOffice() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $cause = trim(htmlspecialchars($this->spArgs('cause')));
        $table = 'myoffice';
        $model = spClass('m_'.$table);
        $m_flow_bill = spClass('m_flow_bill');
        if (empty($cause)) {
            $this->msg_json(0, '请填写删除原因');
        }
        $re = $model->find(array('id' => $id, 'del' => 0), '', 'id,name');
        if ($re) {
            $del = $model->update(array('id' => $id), array('del' => 1));
            if ($del) {
                $m_flow_bill->update(array('table'=>$table,'tid'=>$id),array('del'=>1));
                $data = array('table' => $table, 'optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'mid' => $id, 'cause' => $cause, 'title' => empty($re['title'])?$re['name']:$re['title']);
                spClass('m_delete_log')->create($data);
                $this->msg_json(1, '删除成功', $id);
            } else {
                $this->msg_json(0, '删除失败');
            }
        } else {
            $this->msg_json(0, '数据不存在或已删除');
        }
    }
    
    function myofficeApply() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id' => 30));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_office = spClass('m_myoffice');
        $offices = $m_office->findAll('del = 0 and shopid = ' . $admin['shopid']);
        $this->offices = $offices;
        $m_officeapl = spClass('m_myofficeapl');
        $con = 'del = 0 and shopid = ' . $admin['shopid'];
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $gid = urldecode(htmlspecialchars($this->spArgs('gid')));
        if ($gid) {
            $con .= ' and gid = "' . $gid . '"';
            $page_con['gid'] = $gid;
        }
        if ($uname) {
            $con .= ' and uname like "%' . $uname . '%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_officeapl->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_officeapl->spPager()->getPager();
        $this->page_con = $page_con;
    
    }

    function voidmyOfficeapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowVoid('myofficeapl', $id, $admin);
    }

    function guihmyOfficeapl(){
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $m_myofficeapl = spClass('m_myofficeapl');
        $con['id'] = $id;
        $myo = $m_myofficeapl->find($con);
        if($myo['status'] == 4){
            $data['status'] = 5;
            $up = $m_myofficeapl->update($con,$data);
            if($up){
                $this->msg_json(1,'');
            }else{
                $this->msg_json(0,'更新失败');
            }
        }else{
            $this->msg_json(0,'状态已不能更新');
        }
    }


    function wfmyOfficeapl(){
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $m_myofficeapl = spClass('m_myofficeapl');
        $con['id'] = $id;
        $myo = $m_myofficeapl->find($con);
        if($myo['status'] == 4){
            $data['status'] = 6;
            $up = $m_myofficeapl->update($con,$data);
            if($up){
                $m_welfare_fund = spClass('m_welfare_fund');
                $data2['uid'] = $myo['uid'];
                $data2['money'] = $myo['money'];
                $data2['type'] = '2';
                $data2['content'] = '申请'.$myo['gname'].'无法归还';
                $data2['addtime'] = date('Y-m-d H:i:s',time());
                $add2 = $m_welfare_fund->create($add2);
                $this->msg_json(1,'');
            }else{
                $this->msg_json(0,'更新失败');
            }
        }else{
            $this->msg_json(0,'状态已不能更新');
        }
    }




    function delmyOfficeapl() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $this->flowDel('myofficeapl', $id, $admin);
    }



    /****客户签约合同管理*******/
    function custract(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;

        $model = spClass('m_custract');
        $where = ' 1=1 ';

        $status = (int)htmlentities($this->spArgs('status'));
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }

        $uid = (int)htmlentities($this->spArgs('uid'));
        if(!empty($uid)){
            $where .= ' and uid = '.$uid;
            $page_con['uid'] = $uid;
        }

        $number = htmlspecialchars($this->spArgs('number'));
        if(!empty($number)){
            $where .= ' and number like "%'.$number.'%"';
            $page_con['number'] = $number;
        }

        $comer = htmlspecialchars($this->spArgs('comer'));
        if(!empty($comer)){
            $where .= ' and custid ='.$comer;
            $page_con['comer'] = $comer;
        }

        $results = $model->spPager($this->spArgs("page", 1), 30)->findAll($where,'id desc');

        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;



        $tmps = array();
        $tmps[] = 0;
        foreach($results as $k => $v){
            $tmps[] = $v['uid'];
        }

        $tmps = implode(',', $tmps);
        $m_admin = spClass('m_admin');
        $admins = $m_admin->findAll('id in('.$tmps.')');
        $this->admins = $admins;
    }

    function custractApply(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_custractapply');
        $results = $model->findAll($where,'id desc');
        if($results){
            $uids = array();
            $saleid = array();
            foreach($results as $k => $v){
                $uids[] = $v['uid'];
                $saleids[] = $v['saleid'];
            }
            $m_custsale = spClass('m_custsale');
            $m_admin = spClass('m_admin');
            if($uids){
                $uids = implode(',',$uids);
                $admins = $m_admin->findAll('id in('.$uids.')',null,'id,name');
                $this->admins = $admins;
            }   
            if($saleids){
                $saleids = implode(',',$saleids);
                $custsale = $m_custsale->findAll('id in('.$saleids.')',null,'id,custname,number,money');
                $this->custsale = $custsale; 
            }
           // print_r($results);die;
            $this->results = $results;
        }
        $this->page_con = $page_con;


    }
}
