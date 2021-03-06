<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class applyFill extends IndexController {
    /*     * *****
     * 通知公告
     * ***** */

    function Infor() {
        $result = $this->get_menu();
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_infor = spClass('m_infor');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_infor->find(array('id' => $id));
        $this->result = $result;
    }

    function saveInfor() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['receid'] = trim(htmlspecialchars($this->spArgs('receid')), ',');
        $data['recename'] = trim(htmlspecialchars($this->spArgs('recename')), ',');
        $data['zuozhe'] = htmlspecialchars($this->spArgs('zuozhe'));
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        $id = (int) htmlentities($this->spArgs('id'));
        $m_infor = spClass('m_infor');
        $m_admin = spClass('m_admin');
        if (empty($data['receid'])) {
            $receuser = $m_admin->findAll(array('status' => 1));
        } else {
            $receuser = $m_admin->findAll('status = 1 and did in(' . $data['receid'] . ')');
        }
        if (empty($data['title'])) {
            $this->msg_json(0, '请填写标题');
        }
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择类型');
        }
        if (empty($data['zuozhe'])) {
            $this->msg_json(0, '请填写来源');
        }
        if (empty($data['content'])){
            $this->msg_json(0, '请填写内容');
        }
        if (empty($data['date'])) {
            $this->msg_json(0, '请填写时间');
        }
        if ($id) {
            $re = $m_infor->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->msg_json(0, '信息有误');
            }
            $data['status'] = 1;
            $up = $m_infor->update(array('id' => $re['id']), $data);
            if ($up) {
                $ad = $re['id'];
                $data_log = array('table' => 'infor', 'tid' => $ad, 'status' => 1, 'statusname' => '编辑', 'name' => '编辑', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => 1);
                spClass('m_flow_log')->create($data_log);
            }
        } else {
            $data['cid'] = $admin['cid'];
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['adddt'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $ad = $m_infor->create($data);
        }
        if ($ad) {
            $this->sendMsgNotice(1, $ad, $data['title'], 2, $data['receid']);
            $this->sendRemind(1, $ad, $receuser, $data['title']);
            $this->msg_json(1, '提交成功');
        } else {
            $this->msg_json(0, '提交失败');
        }
    }

    function Report() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_report');
        $oid = (int) htmlentities($this->spArgs('oid'));
        $this->oid = $oid;
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id));
        if ($result) {
            $this->result = $result;
        }
    }

    function saveReport() {
        $admin = $this->get_ajax_menu();
        $data = $_POST;
        foreach ($data as $k => $v) {
            $data[$k] = htmlspecialchars($v);
        }
        $id = $data['id'];
        unset($data['id']);
        $model = spClass('m_report');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据有误');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Nsjc() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveNsjc() {
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['zongjie'] = htmlspecialchars($this->spArgs('zongjie'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $content = $this->spArgs('content');
        $jieguo = $this->spArgs('jieguo');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_nsjc');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['content'] = json_encode($content);
        $data['jieguo'] = json_encode($jieguo);
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(20, $id, '【内审检查表】' . $data['number']);
                $this->sendMsgNotice(20, $id, '【内审检查表】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(20, $ad, '【内审检查表】' . $data['number']);
                
                $this->sendMsgNotice(20, $ad, '【内审检查表】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Nbshjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveNbshjh() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['mudi'] = htmlspecialchars($this->spArgs('mudi'));
        $data['fanwei'] = htmlspecialchars($this->spArgs('fanwei'));
        $data['yiju'] = htmlspecialchars($this->spArgs('yiju'));
        $data['zu'] = htmlspecialchars($this->spArgs('zu'));
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $data['baogao'] = htmlspecialchars($this->spArgs('baogao'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $anpai = $this->spArgs('anpai');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_nbshjh');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['anpai'] = json_encode($anpai);
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(21, $id, '【内部审核计划表】' . $data['number']);
                
                $this->sendMsgNotice(21, $id, '【内部审核计划表】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(21, $ad, '【内部审核计划表】' . $data['number']);
                
                $this->sendMsgNotice(21, $ad, '【内部审核计划表】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Nbshzj() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveNbshzj() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['mudi'] = htmlspecialchars($this->spArgs('mudi'));
        $data['fanwei'] = htmlspecialchars($this->spArgs('fanwei'));
        $data['yiju'] = htmlspecialchars($this->spArgs('yiju'));
        $data['zu'] = htmlspecialchars($this->spArgs('zu'));
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['zongshu'] = htmlspecialchars($this->spArgs('zongshu'));
        $data['jielun'] = htmlspecialchars($this->spArgs('jielun'));
        $data['baogao'] = htmlspecialchars($this->spArgs('baogao'));
        $data['fujian'] = htmlspecialchars($this->spArgs('fujian'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $anpai = $this->spArgs('anpai');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_nbshzj');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['anpai'] = json_encode($anpai);
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(22, $id, '【内部审核总结报告】' . $data['number']);
                
                $this->sendMsgNotice(22, $id, '【内部审核总结报告】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(22, $ad, '【内部审核总结报告】' . $data['number']);
                
                $this->sendMsgNotice(22, $ad, '【内部审核总结报告】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Wjqd() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveWjqd() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $banben = $this->spArgs('banben');
        $name = $this->spArgs('name');
        $sxdt = $this->spArgs('sxdt');
        $hsdt = $this->spArgs('hsdt');
        $explain = $this->spArgs('explain');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_wjqd');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'banben' => htmlspecialchars($banben[$k]),
                'sxdt' => htmlspecialchars($sxdt[$k]),
                'hsdt' => htmlspecialchars($hsdt[$k]),
                'explain' => htmlspecialchars($explain[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $id;
                }
                spClass('m_wjqd_ch')->updateAll(array('wid'=>$id),$data_ch);
                $this->sendUpcoming(23, $id, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(23, $id, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $ad;
                }
                spClass('m_wjqd_ch')->updateAll(array('wid'=>$ad),$data_ch);
                $this->sendUpcoming(23, $ad, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(23, $ad, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Wjff() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveWjff() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $banben = $this->spArgs('banben');
        $name = $this->spArgs('name');
        $num = $this->spArgs('num');
        $date = $this->spArgs('date');
        $explain = $this->spArgs('explain');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_wjff');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'banben' => htmlspecialchars($banben[$k]),
                'num' => htmlspecialchars($num[$k]),
                'date' => htmlspecialchars($date[$k]),
                'explain' => htmlspecialchars($explain[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $id;
                }
                spClass('m_wjff_ch')->updateAll(array('wid'=>$id),$data_ch);
                $this->sendUpcoming(24, $id, '【文件分发记录】' . $data['number']);
                
                $this->sendMsgNotice(24, $id, '【文件分发记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $ad;
                }
                spClass('m_wjff_ch')->updateAll(array('wid'=>$ad),$data_ch);
                $this->sendUpcoming(24, $ad, '【文件分发记录】' . $data['number']);
                
                $this->sendMsgNotice(24, $ad, '【文件分发记录】' . $data['number']);
                $todos = array(
                    'modelid' => 24,
                    'modelname' => '文件分发记录',
                    'table' => 'wjff',
                    'tid' => 0,
                    'uid' => $admin['id'],
                    'adddt' => date('Y-m-d H:i:s'),
                    'title' => '【提醒】添加文件分发记录',
                    'senddt' => strtotime('1year'),
                    'type' => 1
                );
                $rt = spClass('m_flow_todos')->find('uid = '.$admin['id'].' and modelid = 24 and senddt >'.time());
                if(empty($rt)){
                    spClass('m_flow_todos')->create($todos);
                }
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function Wjxdsq() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveWjxdsq() {
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['wname'] = htmlspecialchars($this->spArgs('wname'));
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['dep'] = htmlspecialchars($this->spArgs('dep'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $data['wname'] = htmlspecialchars($this->spArgs('wname'));
        $data['wnumber'] = htmlspecialchars($this->spArgs('wnumber'));
        $data['case'] = htmlspecialchars($this->spArgs('case'));
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        $data['fulu'] = htmlspecialchars($this->spArgs('fulu'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_wjxdsq');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(25, $id, '【文件修订申请】' . $data['number']);
                
                $this->sendMsgNotice(25, $id, '【文件修订申请】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(25, $ad, '【文件修订申请】' . $data['number']);
                
                $this->sendMsgNotice(25, $ad, '【文件修订申请】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Bdly() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveBdly() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $banben = $this->spArgs('banben');
        $name = $this->spArgs('name');
        $sum = $this->spArgs('sum');
        $uname = $this->spArgs('uname');
        $explain = $this->spArgs('explain');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_bdly');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'banben' => htmlspecialchars($banben[$k]),
                'sum' => htmlspecialchars($sum[$k]),
                'uname' => htmlspecialchars($uname[$k]),
                'explain' => htmlspecialchars($explain[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['bid'] = $id;
                }
                spClass('m_bdly_ch')->updateAll(array('bid'=>$id),$data_ch);
                $this->sendUpcoming(23, $id, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(23, $id, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['bid'] = $ad;
                }
                spClass('m_bdly_ch')->updateAll(array('bid'=>$ad),$data_ch);
                $this->sendUpcoming(23, $ad, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(23, $ad, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Wlwj() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveWlwj() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $type = $this->spArgs('type');
        $name = $this->spArgs('name');
        $laiyuan = $this->spArgs('laiyuan');
        $gddt = $this->spArgs('gddt');
        $jsdep = $this->spArgs('jsdep');
        $ffdep = $this->spArgs('ffdep');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_wlwj');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'type' => htmlspecialchars($type[$k]),
                'laiyuan' => htmlspecialchars($laiyuan[$k]),
                'gddt' => htmlspecialchars($gddt[$k]),
                'jsdep' => htmlspecialchars($jsdep[$k]),
                'ffdep' => htmlspecialchars($ffdep[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $id;
                }
                spClass('m_wlwj_ch')->updateAll(array('wid'=>$id),$data_ch);
                $this->sendUpcoming(29, $id, '【外来文件清单】' . $data['number']);
                
                $this->sendMsgNotice(29, $id, '【外来文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['wid'] = $ad;
                }
                spClass('m_wlwj_ch')->updateAll(array('wid'=>$ad),$data_ch);
                $this->sendUpcoming(29, $ad, '【外来文件清单】' . $data['number']);
                
                $this->sendMsgNotice(29, $ad, '【外来文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Ndpxjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveNdpxjh() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $dep = $this->spArgs('dep');
        $content = $this->spArgs('content');
        $duixiang = $this->spArgs('duixiang');
        $type = $this->spArgs('type');
        $month = $this->spArgs('month');
        $explain = $this->spArgs('explain');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_ndpxjh');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($dep as $k => $v) {
            $data_ch[] = array(
                'dep' => htmlspecialchars($v),
                'content' => htmlspecialchars($content[$k]),
                'duixiang' => htmlspecialchars($duixiang[$k]),
                'type' => htmlspecialchars($type[$k]),
                'month' => htmlspecialchars($month[$k]),
                'explain' => htmlspecialchars($explain[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_ndpxjh_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(30, $id, '【年度培训计划】' . $data['number']);
                
                $this->sendMsgNotice(30, $id, '【年度培训计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_ndpxjh_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(30, $ad, '【年度培训计划】' . $data['number']);
                
                $this->sendMsgNotice(30, $ad, '【年度培训计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Pxjl() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function savePxjl() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['date'] = htmlspecialchars($this->spArgs('date'));
        $data['lector'] = htmlspecialchars($this->spArgs('lector'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $name = $this->spArgs('name');
        $dep = $this->spArgs('dep');
        $diandao = $this->spArgs('diandao');
        $type = $this->spArgs('type');
        $result = $this->spArgs('result');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_pxjl');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($name as $k => $v) {
            $data_ch[] = array(
                'name' => htmlspecialchars($v),
                'dep' => htmlspecialchars($dep[$k]),
                'diandao' => htmlspecialchars($diandao[$k]),
                'type' => htmlspecialchars($type[$k]),
                'result' => htmlspecialchars($result[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_pxjl_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(31, $id, '【培训记录】' . $data['number']);
                
                $this->sendMsgNotice(31, $id, '【培训记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_pxjl_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(31, $ad, '【培训记录】' . $data['number']);
                
                $this->sendMsgNotice(31, $ad, '【培训记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Ndnsjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveNdnsjh() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $gl = $this->spArgs('gl');
        $xz = $this->spArgs('xz');
        $sc = $this->spArgs('sc');
        $cg = $this->spArgs('cg');
        $zj = $this->spArgs('zj');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_ndnsjh');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['gl'] = json_encode($gl);
        $data['xz'] = json_encode($xz);
        $data['sc'] = json_encode($sc);
        $data['cg'] = json_encode($cg);
        $data['zj'] = json_encode($zj);
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(32, $id, '【年度内审计划】' . $data['number']);
                
                $this->sendMsgNotice(32, $id, '【年度内审计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(32, $ad, '【年度内审计划】' . $data['number']);
                
                $this->sendMsgNotice(32, $ad, '【年度内审计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Hzcp() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveHzcp() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['jcbg'] = htmlspecialchars($this->spArgs('jcbg'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $fzdt = $this->spArgs('fzdt');
        $zsenddt = $this->spArgs('zsenddt');
        $bgnumber = $this->spArgs('bgnumber');
        $bznumber = $this->spArgs('bznumber');
        $enddt = $this->spArgs('enddt');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_hzcp');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'format' => htmlspecialchars($format[$k]),
                'fzdt' => htmlspecialchars($fzdt[$k]),
                'zsenddt' => htmlspecialchars($zsenddt[$k]),
                'bgnumber' => htmlspecialchars($bgnumber[$k]),
                'bznumber' => htmlspecialchars($bznumber[$k]),
                'enddt' => htmlspecialchars($enddt[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_hzcp_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(33, $id, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(33, $id, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_hzcp_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(33, $ad, '【文件清单】' . $data['number']);
                
                $this->sendMsgNotice(33, $ad, '【文件清单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Sbbyjl() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbbyjl');
        $result = $model->find(array('id'=>$id));
        $result['content'] = json_decode($result['content'], true);
        $this->result = $result;
    }

    function saveSbbyjl() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['year'] = htmlspecialchars($this->spArgs('year'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['person'] = htmlspecialchars($this->spArgs('person'));
        $data['case'] = htmlspecialchars($this->spArgs('case'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $content = $this->spArgs('content');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbbyjl');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($content as $k => $v) {
            if(!empty($v)){
                $con[$k] = $v;
            }
        }
        $data['content'] = json_encode($con);
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(34, $id, '【生产设备保养记录】' . $data['number']);
                
                $this->sendMsgNotice(34, $id, '【生产设备保养记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(34, $ad, '【生产设备保养记录】' . $data['number']);
                
                $this->sendMsgNotice(34, $ad, '【生产设备保养记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Zztz() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveZztz() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['dep'] = htmlspecialchars($this->spArgs('dep'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $name = $this->spArgs('name');
        $number = $this->spArgs('number');
        $num = $this->spArgs('num');
        $type = $this->spArgs('type');
        $ffdep = $this->spArgs('ffdep');
        $qianshou = $this->spArgs('qianshou');
        $dt = $this->spArgs('dt');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_zztz');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($name as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($number[$k]),
                'name' => htmlspecialchars($name[$k]),
                'num' => htmlspecialchars($num[$k]),
                'type' => htmlspecialchars($type[$k]),
                'ffdep' => htmlspecialchars($ffdep[$k]),
                'qianshou' => htmlspecialchars($qianshou[$k]),
                'dt' => htmlspecialchars($dt[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_zztz_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(35, $id, '【自制图纸记录】' . $data['number']);
                
                $this->sendMsgNotice(35, $id, '【自制图纸记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_zztz_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(35, $ad, '【自制图纸记录】' . $data['number']);
                
                $this->sendMsgNotice(35, $ad, '【自制图纸记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Sbwxjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveSbwxjh() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $number = $this->spArgs('number');
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $level = $this->spArgs('level');
        $company = $this->spArgs('company');
        $changsuo = $this->spArgs('changsuo');
        $lastdt = $this->spArgs('lastdt');
        $jhdt = $this->spArgs('jhdt');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbwxjh');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($number as $k => $v) {
            $data_ch[] = array(
                'number' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'format' => htmlspecialchars($format[$k]),
                'level' => htmlspecialchars($level[$k]),
                'company' => htmlspecialchars($company[$k]),
                'changsuo' => htmlspecialchars($changsuo[$k]),
                'lastdt' => htmlspecialchars($lastdt[$k]),
                'jhdt' => htmlspecialchars($jhdt[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_sbwxjh_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(36, $id, '【生产设备维修计划】' . $data['number']);
                
                $this->sendMsgNotice(36, $id, '【生产设备维修计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_sbwxjh_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(36, $ad, '【生产设备维修计划】' . $data['number']);
                
                $this->sendMsgNotice(36, $ad, '【生产设备维修计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Bsd() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveBsd() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['dep'] = htmlspecialchars($this->spArgs('dep'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['case'] = htmlspecialchars($this->spArgs('case'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $name = $this->spArgs('name');
        $num = $this->spArgs('num');
        $price = $this->spArgs('price');
        $money = $this->spArgs('money');
        $address = $this->spArgs('address');
        $explain = $this->spArgs('explain');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_bsd');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($name as $k => $v) {
            $data_ch[] = array(
                'name' => htmlspecialchars($v),
                'num' => htmlspecialchars($num[$k]),
                'price' => htmlspecialchars($price[$k]),
                'money' => $num[$k]*$price[$k],
                'address' => htmlspecialchars($address[$k]),
                'explain' => htmlspecialchars($explain[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_bsd_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(37, $id, '【报损单】' . $data['number']);
                
                $this->sendMsgNotice(37, $id, '【报损单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_bsd_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(37, $ad, '【报损单】' . $data['number']);
                
                $this->sendMsgNotice(37, $ad, '【报损单】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Gysgl() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveGysgl() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['produce'] = htmlspecialchars($this->spArgs('produce'));
        $data['kaopin'] = htmlspecialchars($this->spArgs('kaopin'));
        $data['cg'] = htmlspecialchars($this->spArgs('cg'));
        $data['cgdt'] = htmlspecialchars($this->spArgs('cgdt'));
        $data['zl'] = htmlspecialchars($this->spArgs('zl'));
        $data['zldt'] = htmlspecialchars($this->spArgs('zldt'));
        $zhiliang = $this->spArgs('zhiliang');
        $fuwu = $this->spArgs('fuwu');
        $tousu = $this->spArgs('tousu');
        $jiaohuo = $this->spArgs('jiaohuo');
        $jiage = $this->spArgs('jiage');
        $data['zhiliang'] = json_encode($zhiliang);
        $data['fuwu'] = json_encode($fuwu);
        $data['tousu'] = json_encode($tousu);
        $data['jiaohuo'] = json_encode($jiaohuo);
        $data['jiage'] = json_encode($jiage);
        $data['sum'] = $zhiliang[1]+$fuwu[1]+$tousu[1]+$jiaohuo[1]+$jiage[1];
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_gysgl');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写供应商');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(28, $id, '【供应商管理】' . $data['number']);
                
                $this->sendMsgNotice(28, $id, '【供应商管理】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(28, $ad, '【供应商管理】' . $data['number']);
                
                $this->sendMsgNotice(28, $ad, '【供应商管理】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function Fankui() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveFankui() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['fkdt'] = htmlspecialchars($this->spArgs('fkdt'));
        $data['cpname'] = htmlspecialchars($this->spArgs('cpname'));
        $data['onumber'] = htmlspecialchars($this->spArgs('onumber'));
        $data['content'] = htmlspecialchars($this->spArgs('content'));
        $data['cname'] = htmlspecialchars($this->spArgs('cname'));
        $data['case'] = htmlspecialchars($this->spArgs('case'));
        $data['cdep'] = htmlspecialchars($this->spArgs('cdep'));
        $data['jiejue'] = htmlspecialchars($this->spArgs('jiejue'));
        $data['jdep'] = htmlspecialchars($this->spArgs('jdep'));
        $data['cstype'] = htmlspecialchars($this->spArgs('cstype'));
        $data['cuoshi'] = htmlspecialchars($this->spArgs('cuoshi'));
        $data['csdep'] = htmlspecialchars($this->spArgs('csdep'));
        $data['csname'] = htmlspecialchars($this->spArgs('csname'));
        $data['yygz'] = htmlspecialchars($this->spArgs('yygz'));
        $data['jluser'] = htmlspecialchars($this->spArgs('jluser'));
        $data['yyuser'] = htmlspecialchars($this->spArgs('yyuser'));
        $data['yydt'] = htmlspecialchars($this->spArgs('yydt'));
        $files = $this->spArgs('files');
        $data['files'] = implode(',', $files);
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_fankui');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写顾客姓名');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(42, $id, '【顾客反馈记录】' . $data['number']);
                
                $this->sendMsgNotice(42, $id, '【顾客反馈记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(42, $ad, '【顾客反馈记录】' . $data['number']);
                
                $this->sendMsgNotice(42, $ad, '【顾客反馈记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function sbtz() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }

    function saveSbtz() {
        $admin = $this->get_ajax_menu();
        $data_log['title'] = htmlspecialchars($this->spArgs('title'));
        $data_log['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data_log['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $name = $this->spArgs('name');
        $xinghao = $this->spArgs('model');
        $shang = $this->spArgs('shang');
        $num = $this->spArgs('num');
        $address = $this->spArgs('address');
        $note = $this->spArgs('note');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbtz');
        if (empty($data_log['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        if (empty($data_log['uname'])) {
            $this->msg_json(0, '请上传签名');
        }
        $data_log['optid'] = $admin['id'];
        $data_log['optname'] = $admin['name'];
        $data_log['dt'] = date('Y-m-d H:i:s');
        $data_log['optdt'] = date('Y-m-d H:i:s');
        $data_log['status'] = 1;
        foreach ($xinghao as $k => $v) {
            $data[] = array(
                'model' => htmlspecialchars($v),
                'name' => htmlspecialchars($name[$k]),
                'num' => htmlspecialchars($num[$k])==0?'':htmlspecialchars($num[$k]),
                'address' => htmlspecialchars($address[$k]),
                'note' => htmlspecialchars($note[$k]),
                'shang' => htmlspecialchars($shang[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data_log);
            if ($up) {
                foreach($data as $k=>$v){
                    $data[$k]['sid'] = $id;
                }
                spClass('m_sbtz_log')->updateAll(array('sid'=>$id),$data);
                $this->sendUpcoming(38, $id, '【检验和试验设备台账】' . $data_log['number']);
                
                $this->sendMsgNotice(38, $id, '【检验和试验设备台账】' . $data_log['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data_log['cid'] = $admin['cid'];
            $ad = $model->create($data_log);
            if ($ad) {
                foreach($data as $k=>$v){
                    $data[$k]['sid'] = $ad;
                }
                spClass('m_sbtz_log')->updateAll(array('sid'=>$ad),$data);
                $this->sendUpcoming(38, $ad, '【检验和试验设备台账】' . $data_log['number']);
                
                $this->sendMsgNotice(38, $ad, '【检验和试验设备台账】' . $data_log['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }


   function Sbyxjc() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }


  function saveSbyxjc() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['jielun'] = htmlspecialchars($this->spArgs('jielun'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $val1 = $this->spArgs('val1');
        $val2 = $this->spArgs('val2');
        $val3 = $this->spArgs('val3');
        $data['val1'] = json_encode($val1);
        $data['val2'] = json_encode($val2);
        $data['val3'] = json_encode($val3);
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbyxjc');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(39, $id, '【设备运行检查记录】' . $data['number']);
                
                $this->sendMsgNotice(39, $id, '【设备运行检查记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(39, $ad, '【设备运行检查记录】' . $data['number']);
                
                $this->sendMsgNotice(39, $ad, '【设备运行检查记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }


   function Bzffjl() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }


  function saveBzffjl() {
        $admin = $this->get_ajax_menu();
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['format'] = htmlspecialchars($this->spArgs('pformat'));
        $data['sum'] = htmlspecialchars($this->spArgs('sum'));
        $data['uname'] = htmlspecialchars($this->spArgs('qianming'));
        $format = $this->spArgs('format');
        $fname = $this->spArgs('fname');
        $fdt = $this->spArgs('fdt');
        $fnum = $this->spArgs('fnum');
        $lname = $this->spArgs('lname');
        $yonghu = $this->spArgs('yonghu');
        $snum = $this->spArgs('snum');
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_bzffjl');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($format as $k => $v) {
            $data_ch[] = array(
                'format' => htmlspecialchars($v),
                'fname' => htmlspecialchars($fname[$k]),
                'fname' => htmlspecialchars($fname[$k]),
                'fdt' => htmlspecialchars($fdt[$k]),
                'fnum' => htmlspecialchars($fnum[$k]),
                'lname' => htmlspecialchars($lname[$k]),
                'yonghu' => htmlspecialchars($yonghu[$k]),
                'snum' => htmlspecialchars($snum[$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_bzffjl_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(40, $id, '【标识发放记录】' . $data['number']);
                
                $this->sendMsgNotice(40, $id, '【标识发放记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_bzffjl_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(40, $ad, '【标识发放记录】' . $data['number']);
                
                $this->sendMsgNotice(40, $ad, '【标识发放记录】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }


   function Sbxzjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
    }


  function saveSbxzjh() {
        $admin = $this->get_ajax_menu();
        foreach($_POST as $k=>$v){
            $data[$k] = $v;
        }
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbxzjh');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入编号');
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        foreach ($data['name'] as $k => $v) {
            $data_ch[] = array(
                'name' => htmlspecialchars($v),
                'keshi' => htmlspecialchars($data['keshi'][$k]),
                'sum' => htmlspecialchars($data['sum'][$k]),
                'zhouqi' => htmlspecialchars($data['zhouqi'][$k]),
                'm1' => htmlspecialchars($data['m1'][$k]).'/'.htmlspecialchars($data['my1'][$k]),
                'm2' => htmlspecialchars($data['m2'][$k]).'/'.htmlspecialchars($data['my2'][$k]),
                'm3' => htmlspecialchars($data['m3'][$k]).'/'.htmlspecialchars($data['my3'][$k]),
                'm4' => htmlspecialchars($data['m4'][$k]).'/'.htmlspecialchars($data['my4'][$k]),
                'm5' => htmlspecialchars($data['m5'][$k]).'/'.htmlspecialchars($data['my5'][$k]),
                'm6' => htmlspecialchars($data['m6'][$k]).'/'.htmlspecialchars($data['my6'][$k]),
                'm7' => htmlspecialchars($data['m7'][$k]).'/'.htmlspecialchars($data['my7'][$k]),
                'm8' => htmlspecialchars($data['m8'][$k]).'/'.htmlspecialchars($data['my8'][$k]),
                'm9' => htmlspecialchars($data['m9'][$k]).'/'.htmlspecialchars($data['my9'][$k]),
                'm10' => htmlspecialchars($data['m10'][$k]).'/'.htmlspecialchars($data['my10'][$k]),
                'm11' => htmlspecialchars($data['m11'][$k]).'/'.htmlspecialchars($data['my11'][$k]),
                'm12' => htmlspecialchars($data['m12'][$k]).'/'.htmlspecialchars($data['my12'][$k]),
            );
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $id;
                }
                spClass('m_sbxzjh_ch')->updateAll(array('pid'=>$id),$data_ch);
                $this->sendUpcoming(41, $id, '【检测设备校准计划】' . $data['number']);
                
                $this->sendMsgNotice(41, $id, '【检测设备校准计划】' . $data['number']);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach($data_ch as $k=>$v){
                    $data_ch[$k]['pid'] = $ad;
                }
                spClass('m_sbxzjh_ch')->updateAll(array('pid'=>$ad),$data_ch);
                $this->sendUpcoming(41, $ad, '【检测设备校准计划】' . $data['number']);
                
                $this->sendMsgNotice(41, $ad, '【检测设备校准计划】' . $data['number']);
                $todos = array(
                    'modelid' => 41,
                    'modelname' => '检测设备校准计划',
                    'table' => 'sbxzjh',
                    'tid' => 0,
                    'uid' => $admin['id'],
                    'adddt' => date('Y-m-d H:i:s'),
                    'title' => '【提醒】检测设备校准计划',
                    'senddt' => strtotime('1year'),
                    'type' => 1
                );
                $rt = spClass('m_flow_todos')->find('uid = '.$admin['id'].' and modelid = 41 and senddt >'.time());
                if(empty($rt)){
                    spClass('m_flow_todos')->create($todos);
                }
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

}
