
<?php
//查看控制器
/**
 * Description of apply
 * 展示类弹窗
 * @author IndexController
 */
class apply extends IndexController {

    //审核处理
    function saveCheck() {
        $user = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_course = spClass('m_flow_course');
        $id = (int) htmlentities($this->spArgs('id'));
        $bill = $m_flow_bill->find(array('id' => $id));
        if (empty($bill)) {
            $this->msg_json(0, '信息有误');
        }
        $nowcheck = explode(',', $bill['nowcheckid']);
        if (!in_array($user['id'], $nowcheck)) {
            $this->msg_json(0, '您没有审核权限');
        }
        $model = spClass('m_' . $bill['table']);
        $re = $model->find(array('id' => $bill['tid'], 'del' => 0));
        if (empty($re)) {
            $this->msg_json(0, '审核信息有误');
        }
        $status = (int) htmlentities($this->spArgs('status'));
        $checksm = htmlspecialchars($this->spArgs('checksm'));
        if (empty($status)) {
            $this->msg_json(0, '请选择处理动作');
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
                    $applyuser = spClass('m_user')->find(array('id' => $bill['uid']), '', 'id,name,shopid');
                    $chuser = $this->findcheckUser($course['checktype'], $course['checktypeid'], $applyuser);
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
                    if ($bill['table'] == 'daily') {
                        $m_user = spClass('m_user');
                        $receuser = $m_user->find(array('status' => 1, 'id' => $re['uid']));
                        $receuser = $m_user->findAll(array('status' => 1, 'id' => $receuser['pid']));
                        $this->sendRemind(8, $re['id'], $receuser, '[' . $re['uname'] . ']' . $re['date'] . $re['type']);
                    }

                    $data_bill['cid'] = 0;
                    $data_bill['cname'] = '';
                    $data_bill['statustext'] = $act[$status];
                    $data_bill['nowcheckid'] = 0;
                    $data_bill['nowcheckname'] = '';
                }
            } else {
                $this->sendRemind($bill['modelid'], $bill['tid'], $bill['uid'], '申请未通过');
                $data_bill['cid'] = 0;
                $data_bill['cname'] = '';
                $data_bill['statustext'] = $act[$status];
                $data_bill['nowcheckid'] = ',' . $bill['optid'] . ',';
                $data_bill['nowcheckname'] = $bill['optname'];
            }
            $data_bill['allcheckid'] = $bill['allcheckid'] . $user['id'] . ',';
            $m_flow_bill->update(array('id' => $id), $data_bill);
            $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => $status, 'statusname' => $act[$status], 'name' => $pcourse['name'], 'courseid' => $pcourse['id'], 'optdt' => date('Y-m-d H:i:s'), 'explain' => $checksm, 'ip' => Common::getIp(), 'checkname' => $user['name'], 'checkid' => $user['id'], 'mid' => $bill['modelid'], 'files' => $files);
            spClass('m_flow_log')->create($data_log);
            $this->msg_json(1, '处理成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }
    //待办事项
    function findCheck($id, $mid) {
        $user = $this->islogin();
        $m_file = spClass('m_file');
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_log = spClass('m_flow_log');
        $m_flow_course = spClass('m_flow_course');
        $bill = $m_flow_bill->find(array('modelid' => $mid, 'tid' => $id,'comid'=>$user['cid']));
        if (empty($bill)) {
            $this->error('数据有误');
        }
        $log = $m_flow_log->findAll(array('table' => $bill['table'], 'tid' => $bill['tid']));
        foreach ($log as $k => $v) {
            if (!empty($v['files'])) {
                $files = $m_file->findAll('id in (' . $v['files'] . ')', '', 'id,filename');
                $log[$k]['files'] = $files;
            } else {
                $log[$k]['files'] = array();
            }
        }
        $this->log = $log;
        $model = spClass('m_' . $bill['table']);
        $result = $model->find(array('id' => $bill['tid']));
        $course = $m_flow_course->find(array('id' => $bill['cid'],'cid'=>$user['cid']));
        if (!empty($result['files'])) {
            $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        if (!empty($result['images'])) {
            $result['images'] = explode(',', $result['images']);
        }

        $this->result = $result;
        $bill['nowcheckid'] = trim($bill['nowcheckid'], ',');
        $bill['nowcheckid'] = explode(',', $bill['nowcheckid']);
        $this->bill = $bill;
        $course['courseact'] = empty($course['courseact']) ? array('通过|3|green', '驳回|2|red') : explode(',', $course['courseact']);
        foreach ($course['courseact'] as $k => $v) {
            $course['courseact'][$k] = explode('|', $v);
        }
        $this->course = $course;
    }

    //新消息
    function findRemind($id, $mid) {
        $user = $this->islogin();
        $m_file = spClass('m_file');
        $m_flow_set = spClass('m_flow_set');
        $m_flow_log = spClass('m_flow_log');
        $m_flow_todos = spClass('m_flow_todos');
        $set = $m_flow_set->find(array('id' => $mid));
        if (empty($set)) {
            $this->error('数据有误');
        }
        $todos = $m_flow_todos->find(array('modelid' => $mid, 'tid' => $id, 'uid' => $user['id']), '', 'id,isread');
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
     * 通知公告 详情
     * ***** */
    function Infor() {
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findRemind($id, $mid);
    }

    //任务管理 详情
    function Work() {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 9);
//        $this->findRemind($id, 9);
    }

    //人事调动 详情
    function Hrtransfer()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 14);
    }


    //打卡异常 详情
    function Kqerr()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 11);
    }

    //请假条 详情
    function Kqinfo()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 10);
    }

    //离职申请 详情
    function Hrredund()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 13);
    }

    //转正申请 详情
    function Hrpositive()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 12);
    }

    //办公用品申请 详情
    function Officeapl()
    {
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 7);
    }



    //查看大图
    function img() {
        
    }

    //查看地图
    function map() {
        
    }

    //我的申请详情
    function myprocescont() {
        
    }

    //日报详情
    function datworkcont() {
        
    }

    //员工详情
    function personelcont() {
        
    }

    //员工审核详情
    function checkcont() {
        
    }


    //离职申请详情
    function leavecont() {
        
    }

    //人事调动详情
    function transcont() {
        
    }

    //看房记录详情
    function lookcont() {
        
    }

    //待办事项详情
    function waitforcont() {
        
    }

    //合同详情
    function personnelcont() {
        
    }

}
