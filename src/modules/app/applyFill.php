<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class applyFill extends AppController {
    /*     * *****
     * 通知公告
     * ***** */

    function Infor() {
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_infor->find(array('id' => $id, 'cid' => $user['cid']));
        $this->returnSuccess('成功', $result);
    }

    function saveInfor() {
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'title' => '标题',
            'content' => '内容',
            'summary' => '简介',
            'receid' => '',
            'recename' => '',
        );
        $data = $this->receiveData($arg);
//        $m_infor->save($data,$user);
        if (empty($data['receid'])) {
            $receuser = $m_user->findAll(array('status' => 1, 'cid' => $user['cid']));
        } else {
            $receuser = $m_user->findAll('status = 1 and id in(' . $data['receid'] . ') and cid = ' . $user['cid']);
        }
        $data['zuozhe'] = $user['name'];
        $data['date'] = date('Y-m-d');
        $id = (int) $data['id'];
        unset($data['id']);
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $m_infor->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $data['status'] = 1;
            $up = $m_infor->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['optid'] = $user['id'];
            $data['cid'] = $user['cid'];
            $data['optname'] = $user['name'];
            $data['adddt'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $ad = $m_infor->create($data);
        }
        if ($ad) {
            $this->sendRemind($user, 1, $ad, $receuser, $data['title']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    function saveOfficeapl() {
        $user = $this->islogin();
        $m_officeapl = spClass('m_officeapl');
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'gname' => '物品名称',
            'num' => '数量',
            'explain' => '',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $m_officeapl->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $m_officeapl->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $m_officeapl->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 7, $ad, $data['uname'] . '申请领用[' . $data['gname'] . ']');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * ********
     * 转正申请
     */

    function saveHrpositive() {
        $user = $this->islogin();
        $model = spClass('m_hrpositive');
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'entrydt' => '入职日期',
            'positivedt' => '转正日期',
            'explain' => '转正说明',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 12, $ad, '申请' . $data['positivedt'] . '转正');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * ********
     * 离职申请
     */

    function saveHrredund() {
        $user = $this->islogin();
        $model = spClass('m_hrredund');
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'type' => '离职类型',
            'leavedt' => '离职日期',
            'entrydt' => '入职日期',
            'cause' => '离职原因',
            'explain' => '',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['position'] = $user['pname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 13, $ad, '[' . $data['type'] . '],在' . $data['leavedt'] . '离职');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * ********
     * 人事调动
     */

    function saveHrtransfer() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'type' => '调动类型',
            'tranuname' => '',
            'tranuid' => '',
            'eudeptid' => '调动后部门',
            'epositionid' => '调动后职位',
            'explain' => '',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_hrtransfer');
        $tranu = $m_user->find(array('id' => $data['tranuid']), '', 'id,name,pname,dname');
        if (empty($tranu)) {
            $this->returnError('请选择要调动人', 1);
        } else {
            $data['tranuname'] = $tranu['name'];
            $data['position'] = $tranu['pname'];
            $data['udept'] = $tranu['dname'];
        }
        $eudept = spClass('m_department')->find(array('id' => $data['eudeptid'], 'pid' => $user['cid']), '', 'id,name');
        if (empty($eudept)) {
            $this->returnError('请选择调动后部门', 1);
        } else {
            $data['eudept'] = $eudept['name'];
        }
        $epos = spClass('m_position')->find(array('id' => $data['epositionid']), '', 'id,name');
        if (empty($epos)) {
            $this->returnError('请选择调动后部门', 1);
        } else {
            $data['eposition'] = $epos['name'];
        }
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 14, $ad, '[' . $data['tranuname'] . ']【' . $data['type'] . '】：' . $data['udept'] . '→' . $data['eudept'] . ',' . $data['position'] . '→' . $data['eposition']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * *****
     * 请假
     * ***** */

    function saveKqinfo() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'type' => '请假类型',
            'start' => '开始时间',
            'end' => '截止时间',
            'explain' => '请假说明',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_kqinfo');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 10, $ad, '[' . $data['type'] . ']' . $data['start'] . '->' . $data['end']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * *****
     * 打卡异常
     * ***** */

    function saveKqerr() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'type' => '异常类型',
            'date' => '异常日期',
            'explain' => '异常说明',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_kqerr');
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 11, $ad, '[' . $data['uname'] . ']' . $data['date'] . $data['type']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * *****
     * 外出
     * ***** */

    function saveKqgoout() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $arg = array(
            'id' => '',
            'type' => '外出类型',
            'time' => '外出天数',
            'start' => '开始时间',
            'end' => '截止时间',
            'explain' => '外出说明',
            'luxian' => '',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_kqgoout');
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 28, $ad, '[' . $data['type'] . ']' . $data['start'] . '->' . $data['end']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * *****
     * 工作日报
     * ***** */

    function saveDaily() {
        $user = $this->islogin();
        $m_daily = spClass('m_daily');
        $arg = array(
            'id' => '',
            'type' => '日报类型',
            'date' => '日期',
            'content' => '内容',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $result = $m_daily->find(array('date' => $data['date'], 'uid' => $user['id'], 'type' => $data['type'], 'del' => 0)); //echo empty($result)?'1':'2';die;
        if(!empty($result)){
            $this->returnError('该'.$data['type'].'已填');
        }
        $data['uid'] = $user['id'];
        $data['uname'] = $user['name'];
        $data['cid'] = $user['cid'];
        $data['status'] = 1;
        $data['adddt'] = date('Y-m-d H:i:s');
        $ad = $m_daily->create($data);
        if ($ad) {
            //$this->sendRemind(8, $ad, $receuser, '[' . $user['name'] . ']' . $data['date'] . $data['type']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    /*     * *****
     * 任务
     * ***** */

    function Work() {
        $user = $this->islogin();
        $m_work = spClass('m_work');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_work->find(array('id' => $id));
        if (!empty($result['files'])) {
            $m_file = spClass('m_file');
            $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }
        $this->result = $result;
    }

    function saveWork() {
        $user = $this->islogin();
        $model = spClass('m_work');
        $arg = array(
            'id' => '',
            'title' => '标题',
            'content' => '任务内容',
            'start' => '开始时间',
            'end' => '结束时间',
            'distid' => '执行人',
            'distname' => '执行人',
            'files' => '',
        );
        $data = $this->receiveData($arg);
        $auto = spClass('m_user')->find(array('id' => $data['distid']), '', 'id,name');
        if ($auto) {
            $data['distname'] = $auto['name'];
        } else {
            $this->msg_json(0, '请选择任务执行人');
        }
        $data['status'] = 1;
        $data['optid'] = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) {
                $this->returnError('信息有误', 1);
            }
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['cid'] = $user['cid'];
            $data['dname'] = $user['dname'];
            $data['applydt'] = date('Y-m-d');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming($user, 9, $ad, '[' . $data['title'] . '] 分配给：' . $data['distname'], $auto);
            $this->returnSuccess('操作成功');
        } else {
            $this->returnError('操作失败');
        }
    }

    /*     * *****
     * 收款登记
     * ***** */

    function Finreceipt() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_file = spClass('m_file');
        $m_finreceipt = spClass('m_finreceipt');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_finreceipt->find(array('id' => $id));
        if ($result['files']) {
            $result['files'] = $m_file->findAll('id in(' . $result['files'] . ')');
        }
        $this->result = $result;
    }

    function saveFinreceipt() {
        $admin = $this->get_ajax_menu();
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['payer'] = htmlspecialchars($this->spArgs('payer'));
        $data['money'] = htmlspecialchars($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $data['uid'] = (int) htmlentities($this->spArgs('uid'));
        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }
        $id = (int) htmlentities($this->spArgs('id'));
        $m_finreceipt = spClass('m_finreceipt');
        if (empty($data['date'])) {
            $this->msg_json(0, '请填写日期');
        }
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择收款方式');
        }
        if (empty($data['money'])) {
            $this->msg_json(0, '请填写收款金额');
        }
        if (empty($data['payer'])) {
            $this->msg_json(0, '请填写付款方信息');
        }
        if (empty($data['uid'])) {
            $this->msg_json(0, '请选择相关人员');
        } else {
            $m_admin = spClass('m_admin');
            $adms = $m_admin->find('id=' . $data['uid']);
        }
        if ($id) {
            $re = $m_finreceipt->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->msg_json(0, '信息有误');
            }
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['udeptname'] = $adms['departmentname'];
            $data['uname'] = $adms['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $up = $m_finreceipt->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['udeptname'] = $adms['departmentname'];
            $data['uname'] = $adms['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $data['shopid'] = $admin['shopid'];
            $ad = $m_finreceipt->create($data);

            $m_money_obj = spClass('m_money_obj');
            $con2['id'] = 1;
            $add2 = $m_money_obj->incrField($con2, 'summoney', $data['money']);

            $data3['pid'] = 1;
            $data3['money'] = $data['money'];
            $data3['explain'] = $data['explain'];
            $data3['dt'] = date('Y-m-d H:i:s');
            $data3['uid'] = NULL;
            $data3['uname'] = NULL;
            $data3['type'] = 1;
            $data3['st'] = 0;
            $add3 = spClass('m_money_log')->create($data3);
        }
        if ($ad) {
            $this->sendUpcoming(20, $ad, '[' . $GLOBALS['PAY_TYPE'][$data['type']] . '] 收款：' . $data['money']);
            $this->msg_json(1, '提交成功');
        } else {
            $this->msg_json(0, '提交失败');
        }
    }

    /*     * *****
     * 费用报销
     * ***** */

    function Fininform() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_file = spClass('m_file');
        $m_fin_cate = spClass('m_fin_cate');
        $m_fininform = spClass('m_fininform');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_fininform->find(array('id' => $id));
        if ($result['files']) {
            $result['files'] = $m_file->findAll('id in(' . $result['files'] . ')');
        }
        $this->result = $result;
        $cate = $m_fin_cate->findAll(array('del' => 0, 'type' => '报销申请'));
        $this->cate = $cate;
    }

    function saveFininform() {
        $admin = $this->get_ajax_menu();
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['money'] = htmlspecialchars($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }
        $id = (int) htmlentities($this->spArgs('id'));
        $m_fininform = spClass('m_fininform');
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择报销类别');
        }
        if (empty($data['money'])) {
            $this->msg_json(0, '请填写报销金额');
        }
        if (empty($data['explain'])) {
            $this->msg_json(0, '请填写报销说明');
        }
        if ($id) {
            $re = $m_fininform->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->msg_json(0, '信息有误');
            }
            $data['status'] = 1;
            $up = $m_fininform->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $admin['id'];
            $data['uname'] = $admin['name'];
            $data['udeptname'] = $admin['departmentname'];
            $data['applydt'] = date('Y-m-d');
            $data['status'] = 1;
            $data['shopid'] = $admin['shopid'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $m_fininform->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(16, $ad, '[' . $data['type'] . '] 报销金额：' . $data['money']);
            $this->msg_json(1, '提交成功');
        } else {
            $this->msg_json(0, '提交失败');
        }
    }

    /*     * *****
     * 用款申请
     * ***** */

    function Finfunds() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_file = spClass('m_file');
        $m_fin_cate = spClass('m_fin_cate');
        $m_finfunds = spClass('m_finfunds');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_finfunds->find(array('id' => $id));
        if ($result['files']) {
            $result['files'] = $m_file->findAll('id in(' . $result['files'] . ')');
        }
        $this->result = $result;
        $cate = $m_fin_cate->findAll(array('del' => 0, 'type' => '用款申请'));
        $this->cate = $cate;
    }

    function saveFinfunds() {
        $admin = $this->get_ajax_menu();
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['money'] = htmlspecialchars($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }
        $id = (int) htmlentities($this->spArgs('id'));
        $m_finfunds = spClass('m_finfunds');
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择用款类别');
        }
        if (empty($data['money'])) {
            $this->msg_json(0, '请填写用款金额');
        }
        if (empty($data['explain'])) {
            $this->msg_json(0, '请填写用款说明');
        }
        if ($id) {
            $re = $m_finfunds->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->msg_json(0, '信息有误');
            }
            $data['status'] = 1;
            $up = $m_finfunds->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
            }
        } else {
            $data['uid'] = $admin['id'];
            $data['uname'] = $admin['name'];
            $data['udeptname'] = $admin['departmentname'];
            $data['applydt'] = date('Y-m-d');
            $data['status'] = 1;
            $data['shopid'] = $admin['shopid'];
            $data['number'] = date('YmdHis') . rand(100, 999);
            $ad = $m_finfunds->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(17, $ad, '[' . $data['type'] . '] 用款金额：' . $data['money']);
            $this->msg_json(1, '提交成功');
        } else {
            $this->msg_json(0, '提交失败');
        }
    }

    /*     * ********
     * 客户
     */

    function Customer() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_customer');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $model->find(array('id' => $id));
        if ($result['files']) {
            $result['files'] = spClass('m_file')->findAll('id in(' . $result['files'] . ')', '', 'id,filename');
        }
        $this->result = $result;
    }

    function saveCustomer() {
        $admin = $this->get_ajax_menu();
        $m_file = spClass('m_file');
        $model = spClass('m_customer');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $data['name'] = trim(htmlspecialchars($this->spArgs('name')));
        $data['laiyuan'] = trim(htmlspecialchars($this->spArgs('laiyuan')));
        $data['unitname'] = trim(htmlspecialchars($this->spArgs('unitname')));
        $data['type'] = (int) htmlspecialchars($this->spArgs('type'));
        $data['linkname'] = trim(htmlspecialchars($this->spArgs('linkname')));
        $data['position'] = trim(htmlspecialchars($this->spArgs('position')));
        $data['mobile'] = trim(htmlspecialchars($this->spArgs('mobile')));
        $data['email'] = trim(htmlspecialchars($this->spArgs('email')));
        $data['address'] = trim(htmlspecialchars($this->spArgs('address')));
        $data['routeline'] = trim(htmlspecialchars($this->spArgs('routeline')));
        $data['explain'] = trim(htmlspecialchars($this->spArgs('explain')));
        $data['isstat'] = (int) htmlspecialchars($this->spArgs('isstat'));


        $tmp_con['del'] = 0;
        if (empty($data['mobile'])) {
            $this->msg_json(0, '请输入联系手机号');
        } else {
            $tmp_con['mobile'] = $data['mobile'];
            $tmp = $model->find($tmp_con);
            if ($tmp) {
                $this->msg_json(0, '该手机号已录入进去客户系统中');
            }
        }

        if (empty($data['name'])) {
            $this->msg_json(0, '请填写客户名称');
        }
        if (empty($data['unitname'])) {
            $this->msg_json(0, '请填写客户单位');
        } else {
            $tmp_con['unitname'] = $data['unitname'];
            $tmp = $model->find($tmp_con);
            if ($tmp) {
                $this->msg_json(0, '该客户单位已录入');
            }
        }
        if (empty($data['laiyuan'])) {
            $this->msg_json(0, '请选择客户来源');
        }
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择客户类型');
        }
        if (empty($data['address'])) {
            $this->msg_json(0, '请填写地址');
        }
        if (empty($data['routeline'])) {
            $this->msg_json(0, '请确定出行路线');
        }

        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'uid' => $admin['id']), '', 'id,edit');
            if ($re) {
                if ($re['edit'] <= 0) {
                    $this->msg_json(0, '修改次数已达上限');
                }
                $data['optdt'] = date('Y-m-d H:i:s');
                $up = $model->update(array('id' => $re['id']), array('address' => $data['address'], 'edit' => 0));
                if ($up) {
                    $ad = $re['id'];
                    spClass('m_cust_log')->create(array('tid' => $ad, 'table' => 'customer', 'optid' => $admin['id'], 'optname' => $admin['name'], 'dt' => date('Y-m-d H:i:s'), 'explain' => '修改客户地址', 'stname' => '编辑'));
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            $data['status'] = 1;
            $data['uid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['createid'] = $admin['id'];
            $data['createname'] = $admin['name'];
            $data['adddt'] = date('Y-m-d H:i:s');
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['endtime'] = time();
            $data['edit'] = 1;
            $ad = $model->create($data);
            spClass('m_cust_log')->create(array('tid' => $ad, 'table' => 'customer', 'optid' => $admin['id'], 'optname' => $admin['name'], 'dt' => date('Y-m-d H:i:s'), 'explain' => '添加客户', 'stname' => '添加'));
        }
        if ($ad) {
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    /*     * *****客户合同管理****************** */

    function Custract() {
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $m_custract = spClass('m_custract');
        if ($id) {
            $result = $m_custract->find('id =' . $id);
            $m_custract_bill = spClass('m_custract_bill');
            $cbill = $m_custract_bill->findAll('cid =' . $id);
            $this->cbill = $cbill;

            $m_admin = spClass('m_admin');
            $m_customer = spClass('m_customer');

            $adm = $m_admin->find('id=' . $result['uid']);
            $this->adm = $adm;
            $this->hnumber = $result['hnumber'];
            $this->result = $result;
        } else {
            $where = 'applydt >="' . date('Y-m-d', time()) . '"';
            $tmp = $m_custract->findAll($where);
            if ($tmp) {
                $hnumber = count($tmp) + 1;
            } else {
                $hnumber = 1;
            }

            $hnumber = date('Ymd', time()) . $hnumber;
            $this->hnumber = $hnumber;
        }
    }

    function saveCustract() {
        $admin = $this->get_ajax_menu();
        $data = array();
        $m_custsale = spClass('m_custsale');
        $m_custract = spClass('m_custract');
        foreach ($_POST as $key => $value) {
            if (!is_numeric($value)) {
                $data[$key] = htmlspecialchars($value);
            } else {
                $data[$key] = $value * 1;
            }
        }
        $id = $data['id'];
        if ($id) {
            $con['id'] = (int) $id;
            $tmp = $m_custract->find($con);
            if ($tmp) {
                if (!empty($data['files'])) {
                    $data['files'] = json_encode($data['files']);
                }
                if (!empty($data['moneys'])) {
                    if (!is_numeric($data['moneys']) || $data['moneys'] < 0) {
                        $this->msg_json(0, '请填写正确合同总金额');
                    } else {
                        $tdata['money'] = $data['moneys'];
                        $tdata['ticheng'] = $data['moneys'] * $tmp['unit'];
                        unset($data['moneys']);
                    }
                    if (!empty($data['adddt1'])) {
                        $tdata['adddt'] = $data['adddt1'];
                        unset($data['adddt1']);
                    } else {
                        $tdata['adddt'] = date('Y-m-d H:i', time());
                    }
                    $tdata['uname'] = $admin['name'];
                }
                $up = $m_custract->update($con, $data);
                if ($up == false) {
                    $this->msg_json(0, '提交失败');
                } else {
                    $m_custract_bill = spClass('m_custract_bill');
                    $tdata['cid'] = $tmp['id'];
                    $tdata['uid'] = $tmp['uid'];
                    $tdata['month'] = date('Ym', strtotime($tdata['adddt']));
                    $add = $m_custract_bill->create($tdata);
                    if ($add) {
                        $this->msg_json(1, '提交成功');
                    } else {
                        $this->msg_json(0, '提交失败');
                    }
                }
            } else {
                $this->msg_json(0, '未找到合同信息');
            }
        } else {
            if (empty($data['number'])) {
                $this->msg_json(0, '请输入项目编号');
            } else {

                $con['number'] = $data['number'];
                $tmp = $m_custsale->find($con);
                if (empty($tmp)) {
                    $this->msg_json(0, '未找到该编号对应客户');
                }
                if ($tmp['status'] != 2) {
                    $this->msg_json(0, '该编号对应客户状态不可添加合同');
                }

                $tmp_con['applydt'] = date('Y-m-d', time());
                $tmp2 = $m_custract->findAll($tmp_con, null, 'id');
                if ($tmp2) {
                    $data['num'] = count($tmp2) * 1 + 1;
                } else {
                    $data['num'] = 1;
                }

                $con2['id'] = $tmp['id'];
                $con3['id'] = $tmp['custid'];
                $data['uid'] = $tmp['uid'];
                $data['custid'] = $tmp['custid'];
                $data['custname'] = $tmp['custname'];
                $data['optdt'] = date('Y-m-d H:i:s', time());
                $data['optname'] = $admin['name'];
                $data['saleid'] = $tmp['id'];
                $data['applydt'] = date('Y-m-d', time());
            }

            if (!is_numeric($data['money']) || $data['money'] < 0) {
                $this->msg_json(0, '请填写正确合同总金额');
            }

            if (!is_numeric($data['unit']) || $data['unit'] < 0) {
                $this->msg_json(0, '请填写正确提成百分比');
            } else {
                $data['unit'] = round(($data['unit'] / 100), 3);
            }

            if (!empty($data['moneys'])) {
                if (!is_numeric($data['moneys']) || $data['moneys'] < 0) {
                    $this->msg_json(0, '请填写正确合同总金额');
                } else {
                    $tdata['money'] = $data['moneys'];
                    $tdata['ticheng'] = $data['moneys'] * $data['unit'];
                    unset($data['moneys']);
                }

                if (!empty($data['adddt1'])) {
                    $tdata['adddt'] = $data['adddt1'];
                    unset($data['adddt1']);
                } else {
                    $tdata['adddt'] = date('Y-m-d H:i', time());
                }
                $tdata['uname'] = $admin['name'];
            } else {
                $tdata = array();
            }

            if (!empty($data['files'])) {
                $data['files'] = implode(',', $data['files']);
            }


            $m_custract->query('BEGIN');
            $add = $m_custract->create($data);
            $data2['htid'] = $add;
            $data2['status'] = 3;
            $up = spClass('m_custsale')->update($con2, $data2);

            $m_customer = spCLass('m_customer');
            $customer = $m_customer->find($con3);
            $data3['status'] = 3;
            $data3['htshu'] = $customer['htshu'] * 1 + 1;
            $data3['moneyz'] = $customer['moneyz'] * 1 + $data['money'] * 1;
            $up2 = $m_customer->update($con3, $data3);

            if (!empty($tdata)) {
                $m_custract_bill = spClass('m_custract_bill');
                $u = spClass('m_admin')->find(array('id' => $tmp['uid']));
                $tdata['cid'] = $add;
                $tdata['uid'] = $u['id'];
                $tdata['usname'] = $u['name'];
                $tdata['did'] = $u['departmentid'];
                $tdata['dname'] = $u['departmentname'];
                $tdata['comid'] = $u['shopid'];
                $tdata['comname'] = $u['shoname'];
                $tdata['month'] = date('Ym', strtotime($tdata['adddt']));
                $add2 = $m_custract_bill->create($tdata);
            } else {
                $add2 = true;
            }

            if ($up == false) {
                $m_custract->query('ROLLBACK');
                $this->msg_json(0, '提交失败00001');
            }
            if ($add == false) {
                $m_custract->query('ROLLBACK');
                $this->msg_json(0, '提交失败00002');
            }
            if ($up2 == false) {
                $m_custract->query('ROLLBACK');
                $this->msg_json(0, '提交失败00003');
            }
            if ($add2 == false) {
                $m_custract->query('ROLLBACK');
                $this->msg_json(0, '提交失败00004');
            }

            $m_custract->query('COMMIT');
            $this->msg_json(1, '提交成功');
        }
    }

    function CustractApply() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $m_custsale = spClass('m_custsale');
        $con['id'] = $id;
        $con['uid'] = $re['admin']['id'];
        $sale = $m_custsale->find('id=' . $id);
        if ($sale) {
            $m_custractapply = spClass('m_custractapply');
            $con2['saleid'] = $id;
            $con2['uid'] = $re['admin']['id'];
            $cApply = $m_custractapply->find($con2);
            if (!empty($cApply)) {
                $this->result = $cApply;
            }
            $this->sale = $sale;
        } else {
            $this->error('信息有误');
        }
    }

    function saveCustractApply() {
        $admin = $this->get_ajax_menu();
        //$id = (int) htmlentities($this->spArgs('id'));
        $saleid = (int) htmlentities($this->spArgs('saleid'));
        $m_custractapply = spClass('m_custractapply');
        $m_custsale = spClass('m_custsale');
        if ($id) {
            $con['id'] = $id;
            $con['uid'] = $admin['id'];
            $cust = $m_custractapply->find($con);
            if ($cust) {
                $explain = htmlspecialchars($this->spArgs('explain'));
                if (!empty($explain)) {
                    $data['explain'] = $explain;
                }
                $data['applydt'] = date('Y-m-d', time());
                $up = $m_custractapply->update($con, $data);
                if ($up) {
                    $this->sendUpcoming(32, $id, $admin['name'] . '编辑合同');
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                $this->msg_json(0, '未找到申请信息');
            }
        } else {
            $m_custsale = spClass('m_custsale');
            $con['id'] = $saleid;
            $con['uid'] = $admin['id'];
            $cust = $m_custsale->find($con);
            if ($cust['status'] == 2) {
                $data['uid'] = $admin['id'];
                $data['saleid'] = $saleid;
                $data['optdt'] = date('Y-m-d H:i:s', time());
                $data['optname'] = $admin['name'];
                $data['custid'] = $cust['custid'];
                $data['custname'] = $cust['custname'];
                $data['adddt'] = $data['applydt'] = date('Y-m-d', time());
                $data['status'] = 1;
                $up = $m_custractapply->create($data);
                if ($up) {
                    $this->sendUpcoming(32, $up, $admin['name'] . '申请领用合同');
                    $this->msg_json(1, '申请成功');
                } else {
                    $this->msg_json(0, '申请失败');
                }
            } else {
                $this->msg_json(0, '该跟进客户状态不可申请合同');
            }
        }
    }

    /*     * **活动管理** */

    function Activity() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $model = spClass('m_activity');
        $id = (int) htmlentities($this->spArgs('id'));
        if ($id) {
            $tmp = $model->find('id=' . $id);
            if (!empty($tmp['files'])) {
                $m_file = spCLass('m_file');
                $files = $m_file->findAll('id in (' . $tmp['files'] . ')', '', 'id,filename');
                $tmp['files'] = $files;
            } else {
                $tmp['files'] = array();
            }
            $this->result = $tmp;
        }
    }

    function saveActivity() {
        $admin = $this->get_ajax_menu();
        $data = array();
        $model = spClass('m_activity');
        foreach ($_POST as $k => $v) {
            if (is_numeric($v)) {
                $data[$k] = $v * 1;
            } else {
                $data[$k] = htmlspecialchars($v);
            }
        }

        if (empty($data['name'])) {
            $this->msg_json(0, '请输入本次活动名称');
        }
        if (empty($data['cate'])) {
            $this->msg_json(0, '请选择活动类别');
        }
        if (empty($data['type'])) {
            $data['type'] = 1;
        }
        if (empty($data['statdt'])) {
            $this->msg_json(0, '请选择活动开始日期');
        }
        if (empty($data['enddt'])) {
            $this->msg_json(0, '请选择活动结束日期');
        }
        if (empty($data['prepare'])) {
            $this->msg_json(0, '请填写本次活动需要准备物件');
        }
        if (empty($data['ymoney'])) {
            $this->msg_json(0, '请填写本次活动预算金额');
        }

        if (!empty($data['money']) && !is_numeric($data['money'])) {
            $this->msg_json(0, '请输入填写正确实际金额');
        }

        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }

        $id = $data['id'];
        unset($data['id']);
        if (empty($id)) {
            $data['uid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdr'] = date('Y-m-d H:i:s', time());
            $data['adddt'] = date('Y-m-d H:i:s', time());
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(33, $ad, $admin['name'] . '添加活动信息');
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        } else {
            $con['id'] = $id;
            $con['uid'] = $admin['id'];
            $tmp = $model->find($con);
            if ($tmp) {
                $data['optname'] = $admin['name'];
                $data['optdr'] = date('Y-m-d H:i:s', time());
                $up = $model->update($con, $data);
                if ($up) {
                    $this->sendUpcoming(33, $up, $admin['name'] . '编辑活动信息');
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                $this->msg_json(0, '无权修改活动信息');
            }
        }
    }

    /*     * ***公益活动*** */

    function wActivity() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $model = spClass('m_activity_w');
        $id = (int) htmlentities($this->spArgs('id'));
        if ($id) {
            $tmp = $model->find('id=' . $id);
            if (!empty($tmp['files'])) {
                $m_file = spCLass('m_file');
                $files = $m_file->findAll('id in (' . $tmp['files'] . ')', '', 'id,filename');
                $tmp['files'] = $files;
            } else {
                $tmp['files'] = array();
            }
            $this->result = $tmp;
        }
    }

    function saveWActivity() {
        $admin = $this->get_ajax_menu();
        $data = array();
        $model = spClass('m_activity_w');
        foreach ($_POST as $k => $v) {
            if (is_numeric($v)) {
                $data[$k] = $v * 1;
            } else {
                $data[$k] = htmlspecialchars($v);
            }
        }

        if (empty($data['name'])) {
            $this->msg_json(0, '请输入本次公益名称');
        }
        if (empty($data['objname'])) {
            $this->msg_json(0, '请输入本次公益对象');
        }
        if (empty($data['type'])) {
            $data['type'] = 1;
        }
        if (empty($data['statdt'])) {
            $this->msg_json(0, '请选择活动开始日期');
        }
        if (empty($data['enddt'])) {
            $this->msg_json(0, '请选择活动结束日期');
        }
        if (empty($data['prepare'])) {
            $this->msg_json(0, '请填写本次公益需要准备物件');
        }
        if (empty($data['ymoney'])) {
            $this->msg_json(0, '请填写本次公益预算金额');
        }

        if (!empty($data['money']) && !is_numeric($data['money'])) {
            $this->msg_json(0, '请输入填写正确实际金额');
        }

        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }

        $id = $data['id'];
        unset($data['id']);
        if (empty($id)) {
            $data['uid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdr'] = date('Y-m-d H:i:s', time());
            $data['adddt'] = date('Y-m-d H:i:s', time());
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(34, $ad, $admin['name'] . '添加公益信息');
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        } else {
            $con['id'] = $id;
            $con['uid'] = $admin['id'];
            $tmp = $model->find($con);
            if ($tmp) {
                $data['optname'] = $admin['name'];
                $data['optdr'] = date('Y-m-d H:i:s', time());
                $up = $model->update($con, $data);
                if ($up) {
                    $this->sendUpcoming(34, $up, $admin['name'] . '编辑公益信息');
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                $this->msg_json(0, '无权修改活动信息');
            }
        }
    }

    /*     * **会议记录*** */

    function Conference() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $m_conf_room = spClass('m_conf_room');
        $room = $m_conf_room->findAll();
        $this->room = $room;
        if ($id) {
            $model = spClass('m_conference');
            $result = $model->find('id=' . $id);
            if (!empty($result['files'])) {
                $m_file = spCLass('m_file');
                $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
                $result['files'] = $files;
            } else {
                $result['files'] = array();
            }

            $this->result = $result;
        }
    }

    function saveConference() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_conference');
        $bid = 35;
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value;
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }
        $id = (int) $data['id'];
        unset($data['id']);
        if (empty($data['statdt'])) {
            $this->msg_json(0, '请选择会议开始时间');
        }
        if (empty($data['enddt'])) {
            $this->msg_json(0, '请选择会议结束时间');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请输入会议主题');
        }
        if (empty($data['type'])) {
            $data['type'] = 1;
        }
        if ($data['type'] == 100) {
            if (empty($data['rid'])) {
                $this->msg_json(0, '请选择会议纪要人');
            }
            $bid = 36;
        } else {
            if (!empty($data['rid'])) {
                $data['rid'] = (int) $data['rid'];
            }
        }
        if (!empty($data['files'])) {
            $data['files'] = implode(',', $data['files']);
        }
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s', time());

        if (!empty($id)) {
            $con['id'] = $id;
            $tmp = $model->find($con);
            if (empty($tmp)) {
                $this->msg_json(0, '未找到信息');
            } else {
                $this->sendUpcoming($bid, $up, $admin['name'] . '编辑公益信息');
                $up = $model->update($con, $data);
                if ($up) {
                    $this->msg_json(1, '编辑成功');
                } else {
                    $this->msg_json(0, '编辑失败');
                }
            }
        } else {
            $data['uid'] = $admin['id'];
            $data['adddt'] = date('Y-m-d H:i:s', time());
            $add = $model->create($data);
            if ($add) {
                $this->sendUpcoming($bid, $add, $admin['name'] . '添加会议记录');
                $this->msg_json(1, '添加成功');
            } else {

                $this->msg_json(0, '成功失败');
            }
        }
    }

    /*     * **会议记录*** */

    function Conference_z() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $m_conf_room = spClass('m_conf_room');
        $room = $m_conf_room->findAll();
        $this->room = $room;
        if ($id) {
            $model = spClass('m_conference');
            $con['id'] = $id;
            $con['type'] = 100;
            $con['del'] = 0;
            $result = $model->find($con);
            if (!empty($result)) {
                if (!empty($result['files'])) {
                    $m_file = spCLass('m_file');
                    $files = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
                    $result['files'] = $files;
                } else {
                    $result['files'] = array();
                }
                $this->result = $result;
            } else {
                echo '未找到信息，请关闭';
            }
        }
    }

    /*     * ********案例管理************ */

    function CaseBase() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $m_casebase = spClass('m_casebase');
        $result = $m_casebase->find('id =' . $id);
        if ($result) {
            if (!empty($result['files'])) {
                $m_file = spClass('m_file');
                $files = $m_file->findAll('id in(' . $result['files'] . ')');
                $result['files'] = $files;
            }
            $this->result = $result;
        }
    }

    function saveCaseBase() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_casebase');
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value;
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }

        if (empty($data['type'])) {
            $this->msg_json(0, '请选择类别');
        }

        if (empty($data['cate'])) {
            $this->msg_json(0, '请选择类型');
        }

        if (empty($data['name'])) {
            $this->msg_json(0, '案例名称');
        }

        if (!empty($data['files'])) {
            $data['files'] = implode(',', $data['files']);
        }
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s', time());

        if (!empty($id)) {
            $con['id'] = $id;
            $tmp = $model->find($con);
            if (empty($tmp)) {
                $this->msg_json(0, '未找到信息');
            } else {
                $up = $model->update($con, $data);
                if ($up) {
                    $this->msg_json(1, '编辑成功');
                } else {
                    $this->msg_json(0, '编辑失败');
                }
            }
        } else {

            $data['adddt'] = date('Y-m-d H:i:s', time());
            $add = $model->create($data);
            if ($add) {
                $this->msg_json(1, '添加成功');
            } else {

                $this->msg_json(0, '成功失败');
            }
        }
    }

    /*     * *********培训记录********** */

    function Train() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        if ($id) {
            $m_train = spClass('m_train');
            $result = $m_train->find('id =' . $id);
            if ($result) {
                if (!empty($result['files'])) {
                    $m_file = spClass('m_file');
                    $files = $m_file->findAll('id in(' . $result['files'] . ')');
                    $result['files'] = $files;
                }
                $this->result = $result;
            }
        }

        $m_conf_room = spClass('m_conf_room');
        $room = $m_conf_room->findAll();
        $this->room = $room;
    }

    function saveTrain() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_train');
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value;
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }
        if (empty($data['mRoom'])) {
            $this->msg_json(0, '请选择会议室');
        }

        if (empty($data['rid'])) {
            $this->msg_json(0, '请选择培训师');
        } else {
            $m_admin = spClass('m_admin');
            $admin = $m_admin->find('id =' . $data['rid']);
            $data['recorder'] = $admin['name'];
        }

        if (empty($data['name'])) {
            $this->msg_json(0, '请输入培训主题');
        }

        if (empty($data['statdt'])) {
            $this->msg_json(0, '请选择培训时间');
        }

        if (empty($data['enddt'])) {
            $this->msg_json(0, '请选择培训结束时间');
        }

        if (!empty($data['files'])) {
            $data['files'] = implode(',', $data['files']);
        }

        if (empty($data['receid'])) {
            $data['participants'] = '全公司';
            $receuser = $m_admin->findAll(array('status' => 1));
        } else {
            $data['participants'] = $data['recename'];
            unset($data['recename']);
            $receuser = $m_admin->findAll('status = 1 and departmentid in(' . $data['receid'] . ')');
        }

        $data['optname'] = $admin['name'];
        $data['opdtd'] = date('Y-m-d H:i:s', time());
        $data['del'] = 0;
        $data['uid'] = $admin['id'];

        $id = $data['id'];
        unset($data['id']);
        if ($id) {
            $con['id'] = $id;
            $tmp = $model->find($con);
            if ($tmp) {
                $up = $model->update($con, $data);
                if ($up) {

                    if ($tmp['statdt'] != $data['statdt'] || $data['mRoom'] != $tmp['Room']) {
                        $data2['title'] = $tmp['name'] . '变革通知';
                        $data2['type'] = $GLOBALS['INFOR'][4];
                        $data2['content'] = $data['content'];
                        $data2['recename'] = $data['participants'];
                        $data2['receid'] = $data['receid'];
                        $data2['optid'] = $admin['id'];
                        $data2['optname'] = $admin['name'];
                        $data2['date'] = $data['statdt'];
                        $data2['adddt'] = $data['optdt'];
                        $data2['del'] = 0;
                        $data2['zuozhe'] = $admin['departmentname'];
                        $data2['status'] = 1;
                        $m_infor = spClass('m_infor');
                        $ad2 = $m_infor->create($data2);
                        if ($ad2) {
                            $this->sendRemind(1, $ad2, $receuser, $tmp['name'] . '变革通知');
                        }
                    }
                    $this->sendUpcoming(37, $up, $admin['name'] . '培训信息变更');
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                $this->msg_json(0, '未找到信息');
            }
        } else {
            $ad = $model->create($data);
            $data2['title'] = $data['name'];
            $data2['type'] = $GLOBALS['INFOR'][4];
            $data2['content'] = $data['content'];
            $data2['recename'] = $data['participants'];
            $data2['receid'] = $data['receid'];
            $data2['optid'] = $admin['id'];
            $data2['optname'] = $admin['name'];
            $data2['date'] = $data['statdt'];
            $data2['adddt'] = $data['optdt'];
            $data2['del'] = 0;
            $data2['zuozhe'] = $admin['departmentname'];
            $data2['status'] = 1;
            $m_infor = spClass('m_infor');
            $ad2 = $m_infor->create($data2);
            if ($ad2) {
                $this->sendRemind(1, $ad2, $receuser, $data['name']);
                $this->sendUpcoming(37, $ad, $admin['name'] . '添加培训记录');
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        }
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
            $this->result = $result;
        }
        $m_admin = spClass('m_admin');
        $con2['departmentid'] = $re['admin']['departmentid'];
        $admins = $m_admin->findAll($con2, null, 'id,name');
        $this->depnames = $admins;
    }

    function saveQuota() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_quota');
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value;
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }

        if (empty($data['money']) || !is_numeric($data['money'])) {
            $this->msg_json(0, '请输入部门绩效目标');
        }
        foreach ($data['assigns'] as $k => $v) {
            if (empty($v['money'])) {
                $this->msg_json(0, $v['name'] . '请设置当月绩效');
            } else {
                $data['assigns'][$k]['money'] = $v['money'] * 1;
                $data['assigns'][$k]['ymoney'] = 0;
            }
        }

        $data['assigns'] = json_encode($data['assigns']);
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s', time());
        $id = $data['id'];
        unset($data['id']);


        if ($id) {
            $con['id'] = $id;
            $con['uid'] = $admin['id'];
            $tmp = $model->find($con);
            if ($tmp['status'] < 3) {
                $up = $model->update($con, $data);
                if ($up) {
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                if (empty($tmp)) {
                    $this->msg_json(0, '信息有误');
                } else {
                    $this->msg_json(0, '当前状态不可修改');
                }
            }
        } else {
            $con['month'] = $data['month'];
            $con['uid'] = $admin['id'];
            $data['department'] = $admin['departmentname'];
            $data['deid'] = $admin['departmentid'];
            $tmp = $model->find($con);
            if ($tmp) {
                $this->msg_json(0, '已添加该月绩效信息');
            }
            if (empty($data['month'])) {
                $this->msg_json(0, '请选择部门绩效月份');
            }
            $data['uid'] = $admin['id'];
            $data['adddt'] = date('Y-m-d H:i:s', time());
            $data['status'] = 1;
            $add = $model->create($data);
            if ($add) {

                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        }
    }

    function Culsys() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];

        $id = (int) htmlentities($this->spArgs('id'));
        if ($id) {
            $model = spClass('m_culsys');
            $con['id'] = $id;
            $result = $model->find($con);
            $this->result = $result;
        }
    }

    function saveCulsys() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $name = htmlspecialchars($this->spArgs('name'));
        $type = (int) htmlentities($this->spArgs('type'));
        $zddt = htmlspecialchars($this->spArgs('zddt'));
        $content = htmlspecialchars($this->spArgs('content'));
        if (empty($name)) {
            $this->msg_json(0, '请输入主题信息');
        } else {
            $data['name'] = $name;
        }

        if (empty($type)) {
            $this->msg_json(0, '请选择类型');
        } else {
            $data['type'] = $type;
        }

        if (empty($zddt)) {
            $this->msg_json(0, '请选择制定时间');
        } else {
            $data['zddt'] = $zddt;
        }

        if (empty($content)) {
            $this->msg_json(0, '请输入内容');
        } else {
            $data['content'] = $content;
        }
        $data['optname'] = $admin['name'];
        $data['optdt'] = date("Y-m-d H:i:s");

        $model = spClass('m_culsys');
        if ($id) {
            $con['id'] = $id;
            $tmp = $model->find($con);
            if ($tmp) {
                $up = $model->update($con, $data);
                if ($up) {
                    $this->sendUpcoming(39, $id, '更新文化制度信息');
                    $this->msg_json(1, '更新成功');
                } else {
                    $this->msg_json(0, '更新失败');
                }
            } else {
                $this->msg_json(0, '信息错误');
            }
        } else {
            $data['adddt'] = date("Y-m-d H:i:s", time());
            $data['uid'] = $admin['id'];
            $add = $model->create($data);
            if ($add) {
                $this->sendUpcoming(39, $add, '新增文化制度信息');
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '添加失败');
            }
        }
    }

    function Department_bill() {
        $re = $this->get_menu();
        $this->admin = $re['admin'];
        $id = (int) $this->spArgs('id');
        $con['id'] = $id;
        $con['did'] = $re['admin']['departmentid'];
        $model = spClass('m_department_bill');
        $result = $model->find($con);
        $this->result = $result;
    }

    function saveDepartbill() {
        $admin = $this->get_ajax_menu();
        $id = (int) $this->spArgs('id');
        $money = htmlentities($this->spArgs('money'));
        $explain = htmlspecialchars($this->spArgs('explain'));

        if (!is_numeric($money)) {
            $this->msg_json(0, '请输入正确的金额');
        } else {
            $data['money'] = abs($money);
        }
        if (empty($explain)) {
            $this->msg_json(0, '请填写申请说明');
        } else {
            $data['explain'] = $explain;
        }

        $m_department = spClass('m_department');

        $con['id'] = $admin['departmentid'];
        $tmp = $m_department->find($con);
        $zmoney = $tmp['summoney'] - $tmp['money'];
        if ($zmoney < $money) {
            $this->msg_json(0, '申请奖金超出剩余奖金');
        }

        $data['uname'] = $admin['name'];
        $data['type'] = -1;
        $model = spClass('m_department_bill');
        $data['did'] = $admin['departmentid'];
        $data['uid'] = $admin['id'];
        $data['adddt'] = date('Y-m-d H:i:s', time());
        $data['status'] = 1;
        $add = $model->create($data);
        if ($add) {

            $up2 = $m_department->incrField($con, 'money', $money);

            $this->sendUpcoming(40, $add, $admin['departmentname'] . '申请部门奖金');
            $this->msg_json(1, '更新成功');
        } else {
            $this->msg_json(0, '更新失败');
        }
    }

}
