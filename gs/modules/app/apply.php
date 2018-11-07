<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class apply extends AppController {
    
    /**
     * 采购单详情
     */
    function Invoice()
    {
        $admin        = $this->islogin();
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 7);
    }
    
    /**
     * 退货单详情
     */
    function Regoods()
    {
        $admin        = $this->islogin();
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 45);
    }
    
    //审核处理
    function saveCheck() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_course = spClass('m_flow_course');
        $id = (int) htmlentities($this->spArgs('id'));
        $bill = $m_flow_bill->find(array('id' => $id));
        if (empty($bill)) {
            $this->returnError('信息有误');
        }
        $nowcheck = explode(',', $bill['nowcheckid']);
        if (!in_array($user['id'], $nowcheck)) {
            $this->returnError('您没有审核权限');
        }
        $model = spClass('m_' . $bill['table']);
        $re = $model->find(array('id' => $bill['tid'], 'del' => 0));
        if (empty($re)) {
            $this->returnError('审核信息有误');
        }
        $status = (int) htmlentities($this->spArgs('status'));
        $checksm = htmlspecialchars($this->spArgs('checksm'));
        if (empty($status)) {
            $this->returnError('请选择处理动作');
        }
        $data = array('optid' => $user['id'], 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s'), 'status' => $status);
        $files = $this->spArgs('files');
        $files = empty($files) ? '' : implode(',', $files);
        $up = $model->update(array('id' => $re['id']), $data);
        
        if ($up) {
            $data_bill = array('optid' => $user['id'], 'optname' => $user['name'], 'optdt' => date('Y-m-d H:i:s'), 'status' => $status, 'checksm' => $checksm);
            $pcourse = $m_flow_course->find(array('id' => $bill['cid']), '', 'id,name,courseact');
            $pcourse['courseact'] = explode(',', $pcourse['courseact']);
            $act = array(2 => '驳回', 3 => '通过');
            foreach ($pcourse['courseact'] as $k => $v) {
                $courseact = explode('|', $v);
                $act[$courseact[1]] = $courseact[0];
            }
            if ($status > 2) {
                $course = $m_flow_course->find(array('pid' => $pcourse['id']), '', 'id,name,checktype,checktypeid');
                if ($course) {
//                     $applyadmin = spClass('m_user')->find(array('id' => $bill['uid']), '', 'id,name,cid');
                    $applyadmin = spClass('m_admin')->find(array('id' => $bill['uid']), '', 'id,name,cid'); //TODO 改装admin
                    
                    $chuser = $this->findcheckUser($course['checktype'], $course['checktypeid'], $applyadmin);
                    $data_bill['cid'] = $course['id'];
                    $data_bill['cname'] = $course['name'];
                    $chuserid = trim($chuser['nowcheckid'], ',');
                    if (empty($chuserid)) {
                        $data_bill['nowcheckid'] = '';
                        $data_bill['nowcheckname'] = '';
                        $data_bill['status'] = -1;
                        $data_bill['statustext'] = '[' . $course['name'] . ']未找到审核人';
                    } else {
                        $data_bill['nowcheckid'] = $chuser['nowcheckid'];
                        $data_bill['nowcheckname'] = $chuser['nowcheckname'];
                        $data_bill['statustext'] = '待' . $data_bill['nowcheckname'] . '处理';
                    }
                } else {
                    $this->sendRemind($bill['modelid'], $bill['tid'], $bill['uid'], '申请已处理完成');
                    $data_bill['cid'] = 0;
                    $data_bill['cname'] = '';
                    $data_bill['statustext'] = $act[$status];
                    $data_bill['nowcheckid'] = 0;
                    $data_bill['nowcheckname'] = '';
                }
            } else {
                $this->sendRemind($bill['modelid'], $bill['tid'], $bill['uid'], '申请未通过');
                $data_bill['statustext'] = $act[$status];
                $data_bill['nowcheckid'] = 0;
                $data_bill['nowcheckname'] = '';
            }
            $data_bill['allcheckid'] = $bill['allcheckid'] . $user['id'] . ',';
            $m_flow_bill->update(array('id' => $id), $data_bill);
            $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => $status, 'statusname' => $act[$status], 'name' => $pcourse['name'], 'courseid' => $pcourse['id'], 'optdt' => date('Y-m-d H:i:s'), 'explain' => $checksm, 'ip' => Common::getIp(), 'checkname' => $user['name'], 'checkid' => $user['id'], 'mid' => $bill['modelid'], 'files' => $files);
            spClass('m_flow_log')->create($data_log);
            $this->returnSuccess('处理成功');
        } else {
            $this->returnError('操作失败');
        }
    }
    
//     function findCheck($id, $mid) {
//         $user = $this->islogin();
//         $m_file = spClass('m_file');
//         $m_flow_set = spClass('m_flow_set');
//         $m_flow_bill = spClass('m_flow_bill');
//         $m_flow_log = spClass('m_flow_log');
//         $m_flow_course = spClass('m_flow_course');
//         $set = $m_flow_set->find(array('id' => $mid));
//         if (empty($set)) {
//             $this->returnError('数据有误');
//         }
//         $log = $m_flow_log->findAll(array('table' => $set['table'], 'tid' => $id),'','id,statusname,checkname,optdt,`explain`');
//         foreach ($log as $k => $v) {
//             if (!empty($v['files'])) {
//                 $files = $m_file->findAll('id in (' . $v['files'] . ')', '', 'id,filename');
//                 $log[$k]['files'] = $files;
//             } else {
//                 $log[$k]['files'] = array();
//             }
//         }
//         $model = spClass('m_' . $set['table']);
//         $result = $model->find(array('id' => $id, 'cid' => $user['cid']));
//         if (empty($result)) {
//             $this->returnError('数据不存在或已删除');
//         }
//         $result['log'] = $log;
//         if (!empty($result['files'])) {
//             $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
//             $result['files'] = $files;
//         } else {
//             $result['files'] = array();
//         }
//         if (!empty($result['images'])) {
//             $result['images'] = explode(',', $result['images']);
//         }
//         $bill = $m_flow_bill->find(array('modelid' => $mid, 'tid' => $id));
// //         dump($bill);die;
//         if ($bill) {
//             $result['st'] = $bill['statustext'];
//             $result['billid'] = $bill['id'];
//             $result['billcid'] = $bill['cid'];
//             $course = $m_flow_course->find(array('id' => $bill['cid']),'','id,name,checktypename,courseact');
//             $bill['nowcheckid'] = trim($bill['nowcheckid'], ',');
//             $bill['nowcheckid'] = explode(',', $bill['nowcheckid']);
//             if (in_array($user['id'], $bill['nowcheckid'])) {
//                 $course['courseact'] = empty($course['courseact']) ? array('通过|3|green', '驳回|2|red') : explode(',', $course['courseact']);
//                 foreach ($course['courseact'] as $k => $v) {
//                     $course['courseact'][$k] = explode('|', $v);
//                 }
//                 $result['course'] = $course;
//             }
//         }
//         $this->returnSuccess('成功', $result);
//     }
    
    function findRemind($id, $mid) {
        $re = $this->get_menu();
        $admin = $re['admin'];
        $this->admin = $admin;
        $m_file = spClass('m_file');
        $m_flow_set = spClass('m_flow_set');
        $m_flow_log = spClass('m_flow_log');
        $m_flow_todos = spClass('m_flow_todos');
        $set = $m_flow_set->find(array('id' => $mid));
        if (empty($set)) {
            $this->error('数据有误');
        }
        $todos = $m_flow_todos->find(array('modelid' => $mid, 'tid' => $id, 'uid' => $admin['id']), '', 'id,isread');
        if ($todos['isread'] == 0) {
            $m_flow_todos->update(array('id' => $todos['id']), array('isread' => 1, 'readdt' => date('Y-m-d H:i:s')));
        }
        $this->log = $m_flow_log->findAll(array('table' => $set['table'], 'tid' => $id));
        $model = spClass('m_' . $set['table']);
        $result = $model->find(array('id' => $id));
        if (!empty($result['files'])) {
            $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        if (!empty($result['images'])) {
            $result['images'] = explode(',', $result['images']);
        }
        $result['isread'] = $m_flow_todos->findCount(array('modelid' => $mid, 'tid' => $id, 'isread' => 1));
        $result['noread'] = $m_flow_todos->findCount(array('modelid' => $mid, 'tid' => $id, 'isread' => 0));
        $this->result = $result;
    }
    
    /**     * ****
     * 通知公告
     * ***** */
    function Infor() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findRemind($id, $mid);
    }
    
    /**     * ****
     * 工作日报
     * ***** */
    function Daily() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 8);
    }
    
    /**     * ****
     * 任务
     * ***** */
    function Work() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 9);
    }
    
    /**     * ****
     * 请假
     * ***** */
    function Kqinfo() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 10);
    }
    
    /*     * **外出** */
    
    function Kqgoout() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 28);
    }
    
    /**     * ****
     * 打卡异常
     * ***** */
    function Kqerr() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 11);
    }
    
    /**     * ****
     * 报销申请
     * ***** */
    function Fininform() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    /**     * ****
     * 用款申请
     * ***** */
    function Finfunds() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    /**     * ****
     * 收款记录
     * ***** */
    function Finreceipt() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    /**     * ****
     * 办公用品申请
     * ***** */
    function Officeapl() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 7);
    }
    
    /**     * ****
     * 转正申请
     * ***** */
    function Hrpositive() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 12);
    }
    
    /**     * ****
     * 离职申请
     * ***** */
    function Hrredund() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 13);
    }
    
    /**     * ****
     * 人事调动
     * ***** */
    function Hrtransfer() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 14);
    }
    
    /**     * ****
     * 奖惩处罚
     * ***** */
    function Reward() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    /**     * ****
     * 销售机会
     * ***** */
    function Sales() {
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $model = spClass('m_custsale');
        $m_cust_log = spClass('m_cust_log');
        $result = $model->find(array('id' => $id));
        $this->log = $m_cust_log->findAll(array('tid' => $id, 'table' => 'custsale'), 'dt asc');
        if ($result['files']) {
            $result['files'] = spClass('m_file')->findAll('id in(' . $result['files'] . ')', '', 'id,filename');
        }
        $this->result = $result;
    }
    
    /*     * *更改客户状态* */
    
    function upCustomer() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $bid = (int) htmlentities($this->spArgs('bid'));
        $model = spClass('m_customer');
        $con['id'] = $id;
        $con['uid'] = $admin['id'];
        $tmp = $model->find($con);
        if ($tmp) {
            $data['status'] = $bid;
            $up = $model->update($con, $data);
            if ($bid == 2) {
                $m_custsale = spClass('m_custsale');
                $data = array();
                $data['custid'] = $id;
                $data['uid'] = $admin['id'];
                $data['custname'] = $tmp['name'];
                $data['optname'] = $admin['name'];
                $data['optdt'] = date('Y-m-d H:i:s', time());
                $data['status'] = 1;
                $data['adddt'] = date('Y-m-d H:i:s', time());
                
                $ly = $tmp['laiyuan'];
                $ty = $tmp['type'];
                $data['number'] = 'C' . $ty . 'S' . $ly . date('YmdHis');
                $add = $m_custsale->create($data);
                if ($add) {
                    $this->msg_json(1, '转入跟进客户,请去完善项目信息');
                } else {
                    $this->msg_json(0, '转入失败');
                }
            }
            if ($bid == 3) {
                
            }
        } else {
            $this->msg_json(0, '未找到客户信息', $con);
        }
    }
    
    function Custract() {
        $id = (int) htmlentities($this->spArgs('id'));
        $m_custract = spClass('m_custract');
        $result = $m_custract->find('id=' . $id);
        $this->result = $result;
        
        if ($result) {
            $m_custract_bill = spClass('m_custract_bill');
            $cbill = $m_custract_bill->findAll('cid=' . $result['id']);
            $this->cbill = $cbill;
            
            $uid = (int) $result['uid'];
            $admin = spClass('m_admin')->find('id=' . $uid, null, 'id,name');
            $this->admin = $admin;
            
            
            if (!empty($result['files'])) {
                $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
                $result['files'] = $files;
            } else {
                $result['files'] = array();
            }
        }
    }
    
    function CustractApply() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
        $m_custractapply = spClass('m_custractapply');
        $apply = $m_custractapply->find('id=' . $id);
        if ($apply) {
            $m_custsale = spClass('m_custsale');
            $m_admin = spClass('m_admin');
            $this->sale = $m_custsale->find('id=' . $apply['saleid']);
            $this->ygong = $m_admin->find('id=' . $apply['uid']);
        }
    }
    
    /*     * **活动管理** */
    
    function Activity() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    function wActivity() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    function Conference() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    function Conference_z() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    function Quota() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $model = spClass('m_quota');
        $id = $this->spArgs('id');
        if (!empty($id)) {
            $con['id'] = $id;
            $result = $model->find($con);
            $result['assigns'] = json_decode($result['assigns'], true);
            $aids = array();
            foreach ($result['assigns'] as $k => $v) {
                $aids[] = $k;
                $result['assigns'][$k]['ymoney'] = 0;
            }
            $aids = implode(',', $aids);
            
            
            
            $m_admin = spClass('m_admin');
            $con2['departmentid'] = $re['admin']['departmentid'];
            $admins = $m_admin->findAll($con2, null, 'id,name');
            $this->depnames = $admins;
            
            $m_custract_bill = spClass('m_custract_bill');
            $time = $result['month'] . '01';
            $time2 = ($result['month'] + 1) . '01';
            $where = ' adddt >= ' . $time . ' and adddt <' . $time2 . ' and uid in(' . $aids . ')';
            $bill = $m_custract_bill->findAll($where);
            
            foreach ($bill as $k => $v) {
                $result['assigns'][$v['uid']]['ymoney'] += $v['money'];
                $data['wmoney'] += $v['money'];
            }
            $data['assigns'] = json_encode($result['assigns']);
            $up = $model->update($con, $data);
            $this->result = $result;
        } else {
            echo '信息错误请关闭';
        }
    }
    
    function Culsys() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, $mid);
    }
    
    function Train() {
        $id = (int) htmlentities($this->spArgs('id'));
        $m_train = spCLass('m_train');
        $con['id'] = $id;
        $train = $m_train->find($con);
        
        
        if (empty($train)) {
            $this->error('信息错误');
        } else {
            
            if (!empty($result['files'])) {
                $m_file = spClass('m_file');
                $files = $m_file->findAll('id in(' . $result['files'] . ')');
                $result['files'] = $files;
            }
            $this->result = $train;
        }
    }
    


}
