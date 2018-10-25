<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class apply extends IndexController {

    //审核处理
    function saveCheck() {
        $admin = $this->get_ajax_menu();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_course = spClass('m_flow_course');
        $id = (int) htmlentities($this->spArgs('id'));
        $sid = (int) htmlentities($this->spArgs('sid'));
        $bill = $m_flow_bill->find(array('id' => $id));
        if (empty($bill)) {
            $this->msg_json(0, '信息有误');
        }
        $nowcheck = explode(',', $bill['nowcheckid']);
        if (!in_array($admin['id'], $nowcheck)) {
            $this->msg_json(0, '您没有审核权限');
        }
        $model = spClass('m_' . $bill['table']);
        $re = $model->find(array('id' => $bill['tid'], 'del' => 0));
        if (empty($re)) {
            $this->msg_json(0, '审核信息有误');
        }
        $status = (int) htmlentities($this->spArgs('status'));
        $checksm = htmlspecialchars($this->spArgs('checksm'));
        $qianming = htmlspecialchars($this->spArgs('qianming'));
        if (empty($status)) {
            $this->msg_json(0, '请选择处理动作');
        }
        $data = array('optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'status' => $status);
        $files = $this->spArgs('files');
        $files = empty($files) ? '' : implode(',', $files);
        $up = $model->update(array('id' => $re['id']), $data);
        if ($up) {
            $data_bill = array('optid' => $admin['id'], 'optname' => $admin['name'], 'optdt' => date('Y-m-d H:i:s'), 'status' => $status, 'checksm' => $checksm);
            $pcourse = $m_flow_course->find(array('id' => $bill['cid']), '', 'id,name,courseact');
            $pcourse['courseact'] = explode(',', $pcourse['courseact']);
            $act = array(2 => '驳回', 3 => '通过');
            foreach ($pcourse['courseact'] as $k => $v) {
                $courseact = explode('|', $v);
                $act[$courseact[1]] = $courseact[0];
            }
            if ($status > 2) {
                if ($sid == $status) {
                    $data_bill['cid'] = 0;
                    $data_bill['cname'] = '';
                    $data_bill['statustext'] = $act[$status];
                    $data_bill['nowcheckid'] = 0;
                    $data_bill['nowcheckname'] = '';
                } else {
                    $course = $m_flow_course->find(array('pid' => $pcourse['id']), '', 'id,name,checktype,checktypeid');
                    if ($course) {
                        $applyadmin = spClass('m_admin')->find(array('id' => $bill['uid']), '', 'id,name,cid');
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
                        if ($bill['table'] == 'daily') {
                            $m_admin = spClass('m_admin');
                            $receuser = $m_admin->find(array('status' => 1, 'id' => $re['uid']));
                            $receuser = $m_admin->findAll(array('status' => 1, 'id' => $receuser['pid']));
                            $this->sendRemind(8, $re['id'], $receuser, '[' . $re['uname'] . ']' . $re['date'] . $re['type']);
                        }
                        $data_bill['cid'] = 0;
                        $data_bill['cname'] = '';
                        $data_bill['statustext'] = $act[$status];
                        $data_bill['nowcheckid'] = 0;
                        $data_bill['nowcheckname'] = '';
                    }
                }
            } else {
                $this->sendRemind($bill['modelid'], $bill['tid'], $bill['uid'], '申请未通过');
                $data_bill['cid'] = 0;
                $data_bill['cname'] = '';
                $data_bill['statustext'] = $act[$status];
                $data_bill['nowcheckid'] = ',' . $bill['optid'] . ',';
                $data_bill['nowcheckname'] = $bill['optname'];
            }
            $data_bill['allcheckid'] = $bill['allcheckid'] . $admin['id'] . ',';
            $m_flow_bill->update(array('id' => $id), $data_bill);
            $data_log = array('table' => $bill['table'], 'tid' => $bill['tid'], 'status' => $status, 'statusname' => $act[$status], 'name' => $pcourse['name'], 'courseid' => $pcourse['id'], 'optdt' => date('Y-m-d H:i:s'), 'explain' => $checksm, 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => $bill['modelid'], 'files' => $files, 'sign' => $qianming);
            spClass('m_flow_log')->create($data_log);
            $this->msg_json(1, '处理成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

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

    function Quotation() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('technology', 'quotationInfo', array('id' => $id)));
    }

    function Contract() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('sell', 'contractInfo', array('id' => $id)));
    }

    function Produce() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('produce', 'planInfo', array('id' => $id)));
    }

    function Purchase() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('stock', 'editMater', array('id' => $id)));
    }

    function Purchase_biangeng() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('stock', 'biangengInfo', array('id' => $id)));
    }

    function Purchase_caigou() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('stock', 'caigouInfo', array('id' => $id)));
    }

    function Qualitylog() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('quality', 'qualitylogInfo', array('id' => $id)));
    }

    function Draw() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('produce', 'drawInfo', array('id' => $id)));
    }

    function Liucheng() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('produce', 'liuchengInfo', array('id' => $id)));
    }

    function Zxlog() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('quality', 'zxlogInfo', array('id' => $id)));
    }

    function Dyjy() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('quality', 'dyctlogInfo', array('id' => $id)));
    }

    function Dyjyqr() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('quality', 'dyctlogInfo', array('id' => $id)));
    }

    function Ruku() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('warehouse', 'rukuInfo', array('id' => $id)));
    }

    function Supplier() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('warehouse', 'rukuInfo', array('id' => $id)));
    }

    function Failed() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('administration', 'failedInfo', array('id' => $id)));
    }

    function Chuku() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('warehouse', 'chukuInfo', array('id' => $id)));
    }

    function Clruku() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('warehouse', 'clrukuInfo', array('id' => $id)));
    }

    function Clchuku() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->jump(spUrl('warehouse', 'clchukuInfo', array('id' => $id)));
    }

    function Nsjc() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 20);
        $result = $this->result;
        $result['content'] = json_decode($result['content'], true);
        $result['jieguo'] = json_decode($result['jieguo'], true);
        $this->result = $result;
    }

    function Nbshjh() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 21);
        $result = $this->result;
        $result['anpai'] = json_decode($result['anpai'], true);
        $this->result = $result;
    }

    function Nbshzj() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 22);
    }

    function Wjqd() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 23);
        $result = $this->result;
        $result['children'] = spClass('m_wjqd_ch')->findAll('wid = ' . $result['id']);
        $this->result = $result;
    }

    function Wjff() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 24);
        $result = $this->result;
        $result['children'] = spClass('m_wjff_ch')->findAll('wid = ' . $result['id']);
        $this->result = $result;
    }

    function Wjxdsq() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 25);
    }

    function Bdly() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 26);
        $result = $this->result;
        $result['children'] = spClass('m_bdly_ch')->findAll('bid = ' . $result['id']);
        $this->result = $result;
    }

    function Wlwj() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 29);
        $result = $this->result;
        $result['children'] = spClass('m_wlwj_ch')->findAll('wid = ' . $result['id']);
        $this->result = $result;
    }

    function Ndpxjh() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 30);
        $result = $this->result;
        $result['children'] = spClass('m_ndpxjh_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Pxjl() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 31);
        $result = $this->result;
        $result['children'] = spClass('m_pxjl_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Ndnsjh() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 32);
        $result = $this->result;
        $result['gl'] = json_decode($result['gl'], true);
        $result['xz'] = json_decode($result['xz'], true);
        $result['sc'] = json_decode($result['sc'], true);
        $result['cg'] = json_decode($result['cg'], true);
        $result['zj'] = json_decode($result['zj'], true);
        $this->result = $result;
    }

    function Hzcp() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 33);
        $result = $this->result;
        $result['children'] = spClass('m_hzcp_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Sbbyjl() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 34);
        $result = $this->result;
        $result['content'] = json_decode($result['content'], true);
        $this->result = $result;
    }

    function Zztz() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 35);
        $result = $this->result;
        $result['children'] = spClass('m_zztz_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Sbwxjh() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 36);
        $result = $this->result;
        $result['children'] = spClass('m_sbwxjh_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Bsd() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 33);
        $result = $this->result;
        $result['children'] = spClass('m_bsd_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Gysgl() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 28);
        $result = $this->result;
        $result['zhiliang'] = json_decode($result['zhiliang'], true);
        $result['fuwu'] = json_decode($result['fuwu'], true);
        $result['tousu'] = json_decode($result['tousu'], true);
        $result['jiaohuo'] = json_decode($result['jiaohuo'], true);
        $result['jiage'] = json_decode($result['jiage'], true);
        $this->result = $result;
    }

    function Fankui() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 42);
    }

    function Sbtz() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 38);
        $result = $this->result;
        $result['children'] = spClass('m_sbtz_log')->findAll('sid = ' . $result['id']);
        $this->result = $result;
    }

    function Sbyxjc() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 39);
        $result = $this->result;
        $result['val1'] = json_decode($result['val1'],true);
        $result['val2'] = json_decode($result['val2'],true);
        $result['val3'] = json_decode($result['val3'],true);
        $this->result = $result;
    }

    function Bzffjl() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 40);
        $result = $this->result;
        $result['children'] = spClass('m_bzffjl_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }

    function Sbxzjh() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 41);
        $result = $this->result;
        $result['children'] = spClass('m_sbxzjh_ch')->findAll('pid = ' . $result['id']);
        $this->result = $result;
    }
    
    /**
     * 报销申请详情页面
     */
    function Expend()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
//         $url   = spUrl('app.php/keep', 'payMonInfo', array('id' => $id, 'mid' => $mid, 'token' => $token));
        $url   = URL.'/html/service/payMonItem.html?id='.$id;
        $this->jump($url);
    }
    
    //contract_apply invoice inven custpay_mon device_desc kqinfo  TODO
    function Contract_apply()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/custmang/applyContractItem.html?id='.$id;
        $this->jump($url);
    }
    
    function Invoice()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/applyFill/invoiceApplyItem.html?id='.$id;
        //http://gscs.sem98.com/apply/Invoice?mid=44&id=13
        //http://gscs.sem98.com/html/applyFill/invoiceApplyItem.html?id=13
        $this->jump($url);
    }
    
    function inven()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/inven/indexItem.html?id='.$id;
        $this->jump($url);
    }
    
    function Custpay_mon()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/custpaymon/custPayMonItem.html?id='.$id;
        $this->jump($url);
    }
    
    function Regoods()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/regoods/regoodsItem.html?id='.$id;
        $this->jump($url);
    }
    
    function kqinfo()
    {
        $id    = (int) htmlentities($this->spArgs('id'));
        $url   = URL.'/html/checkwork/leavercordItem.html?id='.$id;
        $this->jump($url);
    }

}
