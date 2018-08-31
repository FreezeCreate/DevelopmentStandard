
<?php
//新增控制器
/**
 * Description of applyFill
 * 添加类弹窗
 * @author IndexController
 */
class applyFill extends IndexController {
/*     * *****
     * 通知公告 更新+保存
     * ***** */

    function Infor() {
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_infor->find(array('id' => $id));
        $this->result = $result;
    }

    function saveInfor() {
        $user = $this->islogin();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['receid'] = trim(htmlspecialchars($this->spArgs('receid')), ',');
        $data['recename'] = trim(htmlspecialchars($this->spArgs('recename')), ',');
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        $m_infor = spClass('m_infor');
        $m_infor->save($data,$user);
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

    //更新/插入
    function saveWork() {
        $user = $this->islogin();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['distid'] = (int) htmlspecialchars($this->spArgs('uid'));
        $data['start'] = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        if ($end) {
            $data['end'] = $end;
        }
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $files = $this->spArgs('files');
        if ($files) {
            $data['files'] = implode(',', $files);
        }
        $m_work = spClass('m_work');
        if (empty($data['title'])) {
            $this->msg_json(0, '请填写任务标题');
        }
        $auto = spClass('m_user')->find(array('id' => $data['distid']), '', 'id,name');
        if ($auto) {
            $data['distname'] = $auto['name'];
        } else {
            $this->msg_json(0, '请选择任务执行人');
        }
        $data['status'] = 1;
        if ($id) {
            $re = $m_work->find(array('id' => $id, 'del' => 0), '', 'id');
            if ($re) {
                $up = $m_work->update(array('id' => $re['id']), $data);
                if ($up) {
                    $ad = $re['id'];
                }
            } else {
                $this->msg_json(0, '信息有误');
            }
        } else {
            $data['uid'] = $user['id'];
            $data['uname'] = $user['name'];
            $data['shopid'] = $user['shopid'];
            $data['udeptname'] = $user['departmentname'];
            $data['applydt'] = date('Y-m-d');
            $ad = $m_work->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(9, $ad, '[' . $data['title'] . '] 分配给：' . $data['distname'], $auto);
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    //添加任务
    function addTask() {
        $user = $this->islogin();
        $data['title']    = htmlspecialchars($this->spArgs('title'));
        $data['distid']   = $this->spArgs('distid');
        $data['distname'] = trim(htmlspecialchars($this->spArgs('distname')), ',');
        $data['content']  = htmlspecialchars($this->spArgs('content'));
        $files            = $this->spArgs('files');
        $data['dname']    = $user['dname']; //dname处理
        $data['start']    = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        if ($files) {$data['files'] = implode(',', $files);}
        if ($end) {$data['end'] = $end;}
        $id = (int) htmlspecialchars($this->spArgs('id'));

        //表单为空和特殊验证
        $form_data = array(
            'id'      => '',
            'title'   => '标题',
            'distid'  => '分配者',
            'distname'=> '分配者',
            'content' => '',
            'files'   => '',
            'start'   => '开始时间',
            'end'     => '截止时间',
        );
        $this->receiveData($form_data);
        if(!is_numeric($data['distid'])) $this->msg_json(0, '分配id必须为数字');
        if(strtotime($data['end']) < strtotime($data['start'])) $this->msg_json(0, '起始时间必须大于结束时间');

        $auto = spClass('m_user')->find(array('id' => $data['distid']), '', 'id,name');

        if ($auto) {
            $data['distname'] = $auto['name'];
        } else {
            $this->msg_json(0, '请选择任务执行人');
        }

        $m_word = spClass('m_work');
        //$m_word->save($data,$user);
        //以下替换save方法
        //save方法
//        $id = (int)$data['id'];
        unset($data['id']);
        $data['optid']   = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if($id){
            $re = $m_word->find(array('id'=>$id,'del'=>0,'cid'=>$user['cid']));
            if(empty($re)){
                $this->returnError('数据不存在');
            }
            $up = $m_word->update(array('id'=>$id),$data);
            if($up){
                $ad = $re['id'];
            }
        }else{
            $data['uid']    = $user['id'];
            $data['uname']  = $user['name'];
            $data['cid']    = $user['cid'];
            $data['applydt']= date('Y-m-d');
            $data['status'] = 1;
            $ad = $m_word->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(9, $ad, '[' . $data['title'] . '] 分配给：' . $data['distname'], $auto);
            $this->returnSuccess('操作成功');
        } else {
            $this->returnError('操作失败');
        }

    }

    //删除任务
    function delTask(){
        $id = (int) htmlspecialchars($this->spArgs('id'));
        if(!is_numeric($id)) $this->returnError('操作失败');

        $work = spClass('m_work')->find(array('id' => $id), '', 'id');
        if($work){
            $up = spClass('m_work')->update(array('id' => $id), array('del' => 1));
            $fb = spClass('m_flow_bill')->update(array('tid' => $id, 'modelid' => 9), array('del' => 1));
        }
    }


    //添加考勤奖惩
    function addwork() {
        
    }

    //编辑考勤参数
    function bjwork() {
        $user         = $this->islogin();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $m_kqsjgz     = spClass('m_kqsjgz');
        $this->result = $m_kqsjgz->find(array('id' => $id));

        $hide_form = $this->spArgs('hide_form');    //初次点击和本页提交时的判断字段
        if(!empty($hide_form)){
            $data['stime'] = htmlspecialchars($this->spArgs('stime'));
            $data['etime'] = htmlspecialchars($this->spArgs('etime'));
            //表单验证
            $form_data = array(
                'stime'    => '开始时间',
                'etime'    => '结束时间',
            );
            $this->receiveData($form_data);
            $ad = $m_kqsjgz->update(array('id'=>$id),$data);

            if ($ad) {
                $this->returnSuccess('操作成功');
            } else {
                $this->returnError('操作失败');
            }
        }

        //渲染模板
    }

    //楼盘客户报备
    function housekeep() {
        
    }

    //工作日报
    function Daily(){
        $user = $this->islogin();
    }

    //添加工作日报
    function adddatwork() {
        $user    = $this->islogin();
        $m_daily = spClass('m_daily');
        $arg     = array(
            'id'      => '',
            'type'    => '日报类型',
            'date'    => '日期',
            'content' => '',
        );
        $data   = $this->receiveData($arg);
        $id     = (int) $data['id'];
        unset($data['id']);
        $result = $m_daily->find(array('date' => $data['date'], 'uid' => $user['id'], 'type' => $data['type'], 'del' => 0)); //echo empty($result)?'1':'2';die;
        if(!empty($result)){$this->returnError('该'.$data['type'].'已填');}

        $data['uid']    = $user['id'];
        $data['uname']  = $user['name'];
        $data['cid']    = $user['cid'];
        $data['status'] = 1;
        $data['adddt']  = date('Y-m-d H:i:s');
        $ad = $m_daily->create($data);
        if ($ad) {
            //$this->sendRemind(8, $ad, $receuser, '[' . $user['name'] . ']' . $data['date'] . $data['type']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }


    //办公用品新增页面
    function Officeapl(){
        $user        = $this->islogin();
        $m_officeapl = spClass('m_officeapl');
        $id          = (int) htmlspecialchars($this->spArgs('id'));
        $result      = $m_officeapl->find(array('id' => $id));

        if (!empty($result['files'])) {
            $m_file = spClass('m_file');
            $files  = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename');
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }

        $this->result = $result;
    }

    //办公用品申请
    function adduse() {
        //初始化
        $user             = $this->islogin();
        $m_officeapl      = spClass('m_officeapl');
        //过滤
        $data['explain']  = htmlspecialchars($this->spArgs('explain'));
        $data['num']      = htmlspecialchars($this->spArgs('num'));
        $data['gname']    = htmlspecialchars($this->spArgs('gname'));
        $data['status']   = 1;
        $data['optid']    = $user['id'];
        $data['optname']  = $user['name'];
        $data['optdt']    = date('Y-m-d H:i:s');

        //表单&特殊验证
        $form_data = array(
            'id'      => '',
            'gname'   => '物品类型',
            'num'     => '数量',
            'explain' => '',
        );
        $this->receiveData($form_data);
        if(!is_numeric($data['num'])) $this->msg_json(0, '分配id必须为数字');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        unset($data['id']);

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
            $data['uid']     = $user['id'];
            $data['uname']   = $user['name'];
            $data['applydt'] = htmlspecialchars($this->spArgs('optdt'));
            $data['cid']     = $user['cid'];
            $data['dname']   = $user['dname'];
            $data['number']  = date('YmdHis') . rand(100, 999);
            $ad = $m_officeapl->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(7, $ad, $data['uname'] . '申请领用[' . $data['gname'] . ']');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }

    }

    //转正页面
    function Hrpositive(){
        $user = $this->islogin();
    }

    //转正申请
    function addregula() {
        $user   = $this->islogin();
        $model  = spClass('m_hrpositive');
        $m_user = spClass('m_user');
        $arg    = array(
            'id'         => '',
            'entrydt'    => '入职日期',
            'positivedt' => '转正日期',
            'explain'    => '申请说明',
            'files'      => '',
        );
        $data = $this->receiveData($arg);
        $id   = (int) $data['id'];
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
            $data['uid']     = $user['id'];
            $data['optid']   = $user['id'];
            $data['uname']   = $user['name'];
            $data['optname'] = $user['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['cid']     = $user['cid'];
            $data['dname']   = $user['dname'];
            $data['position']= $user['pname'];
            $files           = $this->spArgs('files');
            if ($files) {$data['files'] = implode(',', $files);}
            $data['number']  = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(12, $ad, '申请' . $data['positivedt'] . '转正');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }

    }

    //离职页面
    function Hrredund(){
        $user = $this->islogin();
    }

    //离职申请
    function addleave() {
        $user         = $this->islogin();
        $model        = spClass('m_hrredund');
        $m_user       = spClass('m_user');
        $arg = array(
            'id'      => '',
            'type'    => '离职类型',
            'leavedt' => '离职日期',
            'entrydt' => '入职日期',
            'cause'   => '离职原因',
            'explain' => '',
            'files'   => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        $data['status']  = 1;
        $data['optid']   = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        $files            = $this->spArgs('files');
        if ($files) {$data['files'] = implode(',', $files);}

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
            $data['uid']      = $user['id'];
            $data['uname']    = $user['name'];
            $data['position'] = $user['pname'];
            $data['applydt']  = date('Y-m-d H:i:s');
            $data['cid']      = $user['cid'];
            $data['dname']    = $user['dname'];
            $data['number']   = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(13, $ad, '[' . $data['type'] . '],在' . $data['leavedt'] . '离职');
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    //人事页面
    function Hrtransfer(){
        $user = $this->islogin();
    }

    //人事调动
    function adddiaod() {
        //TODO eudept 调动后部门; id
        //TODO eposition 调动后职位; id
        //TODO tranuid 要调动的人ID
        //TODO tranuname 要调动的人name

        //TODO udept 原部门
        //TODO position 原职位

        $user   = $this->islogin();

        $m_user = spClass('m_user');
        $arg    = array(
            'id'          => '',
            'type'        => '调动类型',
            'tranuname'   => '',
            'tranuid'     => '',
            'eudeptid'    => '调动后部门',
            'epositionid' => '调动后职位',
            'explain'     => '',
            'files'       => '',
            );
        $data  = $this->receiveData($arg);
        $id    = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_hrtransfer');
        $tranu = $m_user->find(array('id' => $data['tranuid']), '', 'id,name,pname,dname');
        if (empty($tranu)) {
            $this->returnError('请选择要调动人', 1);
        } else {
            $data['tranuname'] = $tranu['name'];
            $data['position']  = $tranu['pname'];
            $data['udept']     = $tranu['dname'];
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
        $data['status']  = 1;
        $data['optid']   = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        $files            = $this->spArgs('files');
        if ($files) {$data['files'] = implode(',', $files);}
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
            $data['uid']     = $user['id'];
            $data['uname']   = $user['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid']     = $user['cid'];
            $data['dname']   = $user['dname'];
            $data['number']  = date('YmdHis') . rand(100, 999);
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(14, $ad, '[' . $data['tranuname'] . ']【' . $data['type'] . '】：' . $data['udept'] . '→' . $data['eudept'] . ',' . $data['position'] . '→' . $data['eposition']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    //请假页面
    function Kqinfo(){
        $user = $this->islogin();
    }

    //请假申请
    function addreast() {
        $user            = $this->islogin();
        $m_user          = spClass('m_user');
        $arg = array(
            'id'      => '',
            'type'    => '请假类型',
            'start'   => '开始时间',
            'end'     => '截止时间',
            'explain' => '请假说明',
        );
        $data  = $this->receiveData($arg);
        $id    = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_kqinfo');

        $data['status']  = 1;
        $data['optid']   = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt']   = date('Y-m-d H:i:s');

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
            $data['status']  = 1;
            $data['uid']     = $user['id'];
            $data['uname']   = $user['name'];
            $data['cid']     = $user['cid'];
            $data['dname']   = $user['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(10, $ad, '[' . $data['type'] . ']' . $data['start'] . '->' . $data['end']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    //打卡页面
    function Kqerr(){
        $user = $this->islogin();
    }

    //打卡异常
    function adddkyc() {
        $user   = $this->islogin();
        $m_user = spClass('m_user');
        $arg    = array(
            'id'      => '',
            'type'    => '异常类型',
            'date'    => '异常日期',
            'explain' => '异常说明',
            'files'   => '',
        );
        $data  = $this->receiveData($arg);
        $id    = (int) $data['id'];
        unset($data['id']);
        $model = spClass('m_kqerr');
        $data['status']  = 1;
        $data['optid']   = $user['id'];
        $data['optname'] = $user['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
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
            $data['uid']     = $user['id'];
            $data['uname']   = $user['name'];
            $data['cid']     = $user['cid'];
            $data['dname']   = $user['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendUpcoming(11, $ad, '[' . $data['uname'] . ']' . $data['date'] . $data['type']);
            $this->returnSuccess('提交成功');
        } else {
            $this->returnError('提交失败');
        }
    }

    //添加员工
    function addpersonel() {
        
    }

    //添加入职审核
    function addcheck() {
        
    }

    //客户信息录入
    function usermsgin() {
        
    }

    //填写退回理由
    function userback() {
        
    }

    //添加角色
    function addpower() {
        
    }

    //添加客户跟进情况
    function newgj() {
        
    }

    //添加合同
    function addpersonnel() {
        
    }

    //添加部门
    function addbm() {
        
    }

    //添加栏目
    function addlm() {
        
    }

    //添加栏目
    function addsell() {
        
    }

}
