<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class quality extends IndexController {

    function qualitylog() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_qualitylog');
        $con = 'b.del = 0 and b.comid = ' . $admin['cid'];
        $status = (int) $this->spArgs('status');
        $number = urldecode(htmlspecialchars($this->spArgs('number')));
        $st = spClass('m_flow_set')->find(array('id' => 8));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            $con .= ' and b.status > 0';
            $page_con['status'] = $status;
        } else {
            $con .= ' and b.status = 0';
        }
        if (!empty($number)) {
            $con .= ' and (b.number like "%' . $number . '%")';
            $page_con['number'] = $number;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a left outer join ' . DB_NAME . '_qualitylog as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function qualitylogInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 8);
        $result = $this->result;

        if ($result) {
            $result['children'] = spClass('m_purchase_caigou_mater')->findAll(array('pid' => $result['cid']));
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function editQualitylog() {
        $result     = $this->get_menu();
        $this->menu = $result['menu'];
        $admin      = $result['admin'];
        $model      = spClass('m_quotation');
        $id         = (int) htmlentities($this->spArgs('id'));
        $result     = $model->find(array('id' => $id, 'comid' => $admin['cid']));
        $this->project = spClass('m_project')->findAll();
        if ($result) {
            $ids = empty($result['files']) ? '0' : $result['files'];
            $result['files'] = spClass('m_file')->findAll('id in (' . $ids . ')', 'id,filename');
            $result['children'] = spClass('m_quo_project')->findAll(array('pid' => $id));
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }
    
    function saveQualitylog() {
        $admin = $this->get_ajax_menu();
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $id = (int) htmlentities($this->spArgs('id'));
        $yzjc = $this->spArgs('yzjc');
        $wgjc = $this->spArgs('wgjc');
        $ccjc = $this->spArgs('ccjc');
        $xnjc = $this->spArgs('xnjc');
        $jielun = $this->spArgs('jielun');
        $dt = $this->spArgs('dt');
        
        //新增数据
        $checknum = $this->spArgs('checknum');
        $finenum = $this->spArgs('finenum');
        $packing = $this->spArgs('packing');
        $machine = $this->spArgs('machine');
        $aboutfile = $this->spArgs('aboutfile');
        $internetrecord = $this->spArgs('internetrecord');
        $formatparam = $this->spArgs('formatparam');
        $checkstatus = $this->spArgs('checkstatus');
        
        $m_qualitylog = spClass('m_qualitylog');
        $m_purchase_caigou_mater = spClass('m_purchase_caigou_mater');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入文件编号');
        }
        foreach ($yzjc as $k => $v) {
            $data_ma = array();
            $data_ma['yzjc'] = $v;
            $data_ma['wgjc'] = $wgjc[$k];
            $data_ma['ccjc'] = $ccjc[$k];
            $data_ma['xnjc'] = $xnjc[$k];
            $data_ma['jielun'] = $jielun[$k];
            $data_ma['dt'] = $dt[$k];
            
            //新增数据
            $data_ma['checknum'] = $checknum[$k];
            $data_ma['finenum'] = $finenum[$k];
            $data_ma['packing'] = $packing[$k];
            $data_ma['machine'] = $machine[$k];
            $data_ma['aboutfile'] = $aboutfile[$k];
            $data_ma['internetrecord'] = $internetrecord[$k];
            $data_ma['formatparam'] = $formatparam[$k];
            $data_ma['checkstatus'] = $checkstatus[$k];
            
            $m_purchase_caigou_mater->update(array('id' => $k), $data_ma);
        }
        $data['status'] = 1;
        if ($id) {
            $re = $m_qualitylog->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            if ($re['status'] > 0) {
                $this->msg_json(0, '该检验记录已编辑，不可重复编辑');
            }
            $up = $m_qualitylog->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(8, $id, '进货检验单');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['comid'] = $admin['cid'];
            $ad = $m_qualitylog->create($data);
            if ($ad) {
                $this->sendUpcoming(8, $id, '进货检验单');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function report() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_report');
        $con = 'b.del = 0 and b.cid = ' . $admin['cid'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($name)) {
            $con .= ' and (b.number like "%' . $name . '%" or a.number like "%' . $name . '%" or b.name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_report as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function reportInfo() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_report');
        $m_qualitylog = spClass('m_qualitylog');
        $pid = (int) htmlentities($this->spArgs('pid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        $presult = $m_qualitylog->find(array('id' => $pid));
        if ($presult) {
            $this->presult = $presult;
        }
        if ($result) {
            $this->result = $result;
        }
    }

    function editReport() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_report');
        $m_qualitylog = spClass('m_qualitylog');
        $oid = (int) htmlentities($this->spArgs('oid'));
        $this->oid = $oid;
        $pid = (int) htmlentities($this->spArgs('pid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        $presult = $m_qualitylog->find(array('id' => $pid));
        if ($presult) {
            $this->presult = $presult;
        }
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
            $up = $model->delete(array('id' => $id), $data);
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

    function shebei() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_zxlog_shebei');
        $con = 'del = 0 and cid = ' . $admin['cid'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($name)) {
            $con .= ' and (number like "%' . $name . '%" or name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'id');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveShebei() {
        $admin = $this->get_ajax_menu();
        $data['number'] = trim(htmlspecialchars($this->spArgs('number')));
        $data['name'] = trim(htmlspecialchars($this->spArgs('name')));
        $data['day'] = (int) htmlspecialchars($this->spArgs('day'));
        $yaoqiu = $this->spArgs('yaoqiu');
        $model = spClass('m_zxlog_shebei');
        if (empty($data['name'])) {
            $this->msg_json(0, '请输入设备名称');
        }
        if (empty($data['day'])) {
            $this->msg_json(0, '请填写设备周期');
        }
        $data['cid'] = $admin['cid'];
        $data['yaoqiu'] = implode(',', $yaoqiu);
        $ad = $model->create($data);
        if ($ad) {
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    function delShebei() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $model = spClass('m_zxlog_shebei');
        $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']));
        if (empty($re)) {
            $this->msg_json(0, '数据不存在');
        }
        $up = $model->update(array('id' => $id), array('del' => 1));
        if ($up) {
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
    }

    function zxlog() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_zxlog_shebei');
        $con = 'del = 0 and cid = ' . $admin['cid'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($name)) {
            $con .= ' and (number like "%' . $name . '%" or name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'id');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function addZxlog() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_zxlog');
        $id = (int) htmlentities($this->spArgs('id'));
        $sid = (int) htmlentities($this->spArgs('sid'));
        $result = $model->find(array('del' => 0, 'id' => $id));
        $sid = empty($result) ? $sid : $result['sid'];
        $this->sid = $sid;
        $log = spClass('m_zxlog_log')->findAll(array('pid' => $id));
        $shebei = spClass('m_zxlog_shebei')->find('del = 0 and (cid = ' . $admin['cid'] . ') and id = ' . $sid);
        $shebei['yaoqiu'] = explode(',', $shebei['yaoqiu']);
        $this->shebei = $shebei;
        foreach ($log as $k => $v) {
            $v['content'] = json_decode($v['content'], true);
            $sb[$v['sid']]['log'][] = $v;
        }
        $result['log'] = $sb;
        $this->result = $result;
    }

    function zxlogInfo() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $id = (int) htmlentities($this->spArgs('id'));
        $sid = (int) htmlentities($this->spArgs('sid'));
        $log = spClass('m_zxlog_log')->findAll(array('sid' => $sid));
        $shebei = spClass('m_zxlog_shebei')->find('del = 0 and (cid = ' . $admin['cid'] . ') and id = ' . $sid);
        $shebei['yaoqiu'] = explode(',', $shebei['yaoqiu']);
        $this->shebei = $shebei;
        foreach ($log as $k => $v) {
            $log[$k]['content'] = json_decode($v['content'], true);
        }
        $this->log = $log;
    }

    function saveZxlog() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $sid = (int) htmlentities($this->spArgs('sid'));
        $format = $this->spArgs('format');
        $number = $this->spArgs('number');
        $content = $this->spArgs('content');
        $jieguo = $this->spArgs('jieguo');
        $sign = $this->spArgs('sign');
        $dt = $this->spArgs('dt');
        $explain = $this->spArgs('explain');
        $model = spClass('m_zxlog_log');
        foreach ($content as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $con[$k1][$k] = $v1;
            }
        }
        $data_log = array();
        foreach ($format as $k => $v) {
            if ($v) {
                $data_log[] = array(
                    'sid' => $sid,
                    'format' => htmlspecialchars($v),
                    'number' => htmlspecialchars($number[$k]),
                    'content' => json_encode($con[$k]),
                    'jieguo' => htmlspecialchars($jieguo[$k]),
                    'sign' => htmlspecialchars($sign[$k]),
                    'dt' => empty($dt[$k]) ? date('Y-m-d') : htmlspecialchars($dt[$k]),
                    'explain' => htmlspecialchars($explain[$k]),
                    'optid' => $admin['id'],
                    'optname' => $admin['name'],
                    'optdt' => date('Y-m-d H:i:s')
                );
            }
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '信息有误');
            }
            $up = $model->updateAll(array('sid' => $sid), $data_log);
            if ($up) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data_log['cid'] = $admin['cid'];
            $ad = $model->createAll($data_log);
            if ($ad) {
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function dyctlog() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_dyjy');
//         $con = 'b.del = 0 and b.type = 1 and b.cid = ' . $admin['cid'];
        $con = 'b.del = 0 and b.dytype<>4 and b.cid = ' . $admin['cid'];
        
        $number = urldecode(htmlspecialchars($this->spArgs('number')));
        $st = spClass('m_flow_set')->find(array('id' => 12));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($number)) {
            $con .= ' and (b.number like "%' . $number . '%")';
            $page_con['number'] = $number;
        }
//         $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_dyjy as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_dyjy as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);

        //对type的查询
        foreach ($results as $_k => $_v) {
            $para_data = spClass('m_dyjy_para')->find(array('id' => $_v['mid']));
            $results[$_k]['typ'] = $para_data['type'];
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function dyctqueren() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_dyjy');
        $con = 'b.del = 0 and b.type = 2 and b.cid = ' . $admin['cid'];
        $number = urldecode(htmlspecialchars($this->spArgs('number')));
        $st = spClass('m_flow_set')->find(array('id' => 13));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($number)) {
            $con .= ' and (b.number like "%' . $number . '%")';
            $page_con['number'] = $number;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_dyjy as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    /**
     * 例行检查页面
     */
    function editDyctlog() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_dyjy');
        $id = (int) htmlentities($this->spArgs('id'));
        $mid = (int) htmlentities($this->spArgs('mid'));
        $type = (int) htmlentities($this->spArgs('type'));
        
        $this->type = $type;
        //产品参数列表
        $m_para = spClass('m_dyjy_para');
        $paras = $m_para->findAll();
        $this->mid = $mid;
//         dump($mid);die;
        $that_paras = $m_para->find(array('id' => $mid));
        $this->that_paras = $that_paras;
        $this->paras = $paras;

        $result = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        if ($result) {
            $result['jilu'] = json_decode($result['jilu'], true);
            $result['jielun'] = json_decode($result['jielun'], true);
//             $mid = empty($mid) ? $result['mid'] : $mid;
            $this->result = $result;
        }
        //订单数据
        $orders = spClass('m_orders')->findAll('del = 0 and status > 1', 'optdt desc');
        $this->orders = $orders;
        $examples = spClass('m_jyexamples')->findAll(array('type' => 1), 'id desc', 'id,name');
        $this->examples = $examples;
        $mode = spClass('m_jyexamples')->find(array('id' => $mid));
        if (!empty($mode)) {
            $this->mode = $mode;
//             $this->mid = $mid;
        }
    }

    function dyctlogInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $mid = (int) htmlentities($this->spArgs('mid'));
        $mid = $mid == 13 ? 13 : 12;
        $this->findCheck($id, $mid);
        $result = $this->result;
        if ($result) {
//             $mode = spClass('m_jyexamples')->find(array('id' => $result['mid']));
            $mode = spClass('m_dyjy_para')->find(array('id' => $result['mid']));
            $this->mode = $mode;
            $result['jilu'] = json_decode($result['jilu'], true);
            $result['jielun'] = json_decode($result['jielun'], true);
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function dyctlogInfo1() {
        $id = (int) htmlentities($this->spArgs('id'));
        $mid = (int) htmlentities($this->spArgs('mid'));
        $mid = $mid == 13 ? 13 : 12;
        $this->findCheck($id, $mid);
        $result = $this->result;
        $orders = spClass('m_orders')->find(array('id' => $result['oid'])); //订单数据
        $this->orders = $orders;
        $pro = spClass('m_dyjy_para')->find(array('id' => $result['mid']));  //产品数据
        $this->pro = $pro;
        $type = $pro['type'];   //类型数据
        $this->type = $type;
        $that_paras = spClass('m_dyjy_para')->find(array('id' => $result['mid']));    //产品参数数据
        $this->that_paras = $that_paras;
        //后几项数据

        if ($result) {
            $mode = spClass('m_dyjy_para')->find(array('id' => $result['mid']));
            $this->mode = $mode;
            $result['jilu'] = json_decode($result['jilu'], true);
            $result['jielun'] = json_decode($result['jielun'], true);
            $result['info'] = json_decode($result['info'], true);

            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveDyctlog() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_dyjy');
        $data['oid'] = (int) htmlspecialchars($this->spArgs('oid'));
        $data['mid'] = (int) htmlspecialchars($this->spArgs('mid'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['num'] = htmlspecialchars($this->spArgs('num'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['sign'] = htmlspecialchars($this->spArgs('sign'));
        $jilu = $this->spArgs('jilu');
        $jielun = $this->spArgs('jielun');
        $id = (int) htmlentities($this->spArgs('id'));
        if (empty($data['title'])) {
            $this->msg_json(0, '请填写记录名称');
        }
        if (empty($data['number'])) {
            $this->msg_json(0, '请填写文件编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写产品名称');
        }
        if (empty($data['sign'])) {
            $this->msg_json(0, '请上传签名');
        }
        if ($data['mid'] == 1) {
            $data_m = array(
                'type' => 1,
                'name' => $data['title'],
                'q1' => htmlspecialchars($this->spArgs('q1')),
                'w1' => htmlspecialchars($this->spArgs('w1')),
                'e1' => htmlspecialchars($this->spArgs('e1')),
                'q2' => htmlspecialchars($this->spArgs('q2')),
                'w2' => htmlspecialchars($this->spArgs('w2')),
                'e2' => htmlspecialchars($this->spArgs('e2')),
                'q3' => htmlspecialchars($this->spArgs('q3')),
                'w3' => htmlspecialchars($this->spArgs('w3')),
                'e3' => htmlspecialchars($this->spArgs('e3')),
                'q4' => htmlspecialchars($this->spArgs('q4')),
                'w4' => htmlspecialchars($this->spArgs('w4')),
                'e4' => htmlspecialchars($this->spArgs('e4')),
                'q5' => htmlspecialchars($this->spArgs('q5')),
                'w5' => htmlspecialchars($this->spArgs('w5')),
                'e5' => htmlspecialchars($this->spArgs('e5')),
                'q6' => htmlspecialchars($this->spArgs('q6')),
                'w6' => htmlspecialchars($this->spArgs('w6')),
                'e6' => htmlspecialchars($this->spArgs('e6')),
                'q7' => htmlspecialchars($this->spArgs('q7')),
                'w7' => htmlspecialchars($this->spArgs('w7')),
                'e7' => htmlspecialchars($this->spArgs('e7')),
                'q8' => htmlspecialchars($this->spArgs('q8')),
                'w8' => htmlspecialchars($this->spArgs('w8')),
                'e8' => htmlspecialchars($this->spArgs('e8')),
                'q9' => htmlspecialchars($this->spArgs('q9')),
                'w9' => htmlspecialchars($this->spArgs('w9')),
                'e9' => htmlspecialchars($this->spArgs('e9')),
                'q10' => htmlspecialchars($this->spArgs('q10')),
                'w10' => htmlspecialchars($this->spArgs('w10')),
                'e10' => htmlspecialchars($this->spArgs('e10')),
            );
            $mad = spClass('m_jyexamples')->create($data_m);
            $data['mid'] = $mad;
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
            if ($re['status'] > 1) {
                $this->msg_json(0, '该记录不可操作');
            }
            $data['jilu'] = json_encode($jilu);
            $data['jielun'] = json_encode($jielun);
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                if ($re['type'] == 2) {
                    $this->sendUpcoming(13, $id, '【' . $data['name'] . '】确认检验记录');
                } else {
                    $this->sendUpcoming(12, $id, '【' . $data['name'] . '】例行检验记录');
                }
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $data['type'] = (int) htmlspecialchars($this->spArgs('type'));
            $data['jilu'] = json_encode($jilu);
            $data['jielun'] = json_encode($jielun);
            $ad = $model->create($data);
            if ($ad) {
                if ($data['type'] == 2) {
                    $this->sendUpcoming(13, $ad, '【' . $data['name'] . '】确认检验记录');
                } else {
                    $this->sendUpcoming(12, $ad, '【' . $data['name'] . '】例行检验记录');
                }
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function chuchang() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_chuchang');
        $con = 'b.del = 0 and b.cid = ' . $admin['cid'];
        $number = urldecode(htmlspecialchars($this->spArgs('number')));
        $st = spClass('m_flow_set')->find(array('id' => 12));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($number)) {
            $con .= ' and (b.number like "%' . $number . '%")';
            $page_con['number'] = $number;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_chuchang as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function editChuchang() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_chuchang');
        $id = (int) htmlentities($this->spArgs('id'));
        $mid = (int) htmlentities($this->spArgs('mid'));
        $this->type = (int) htmlentities($this->spArgs('type'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        if ($result) {
            $result['jilu'] = json_decode($result['jilu'], true);
            $result['jielun'] = json_decode($result['jielun'], true);
            $mid = empty($mid) ? $result['mid'] : $mid;
            $this->result = $result;
        }
        $orders = spClass('m_orders')->findAll('del = 0 and status > 1', 'optdt desc');
        $this->orders = $orders;
        $examples = spClass('m_jyexamples')->findAll('type = 2 or id = 1', 'id desc', 'id,name');
        $this->examples = $examples;
        $mode = spClass('m_jyexamples')->find(array('id' => $mid));
        if (!empty($mode)) {
            $this->mode = $mode;
            $this->mid = $mid;
        }
    }

    function chuchangInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 27);
        $result = $this->result;
        if ($result) {
            $mode = spClass('m_jyexamples')->find(array('id' => $result['mid']));
            $this->mode = $mode;
            $result['jilu'] = json_decode($result['jilu'], true);
            $result['jielun'] = json_decode($result['jielun'], true);
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveChuchang() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_chuchang');
        $data['oid'] = (int) htmlspecialchars($this->spArgs('oid'));
        $data['mid'] = (int) htmlspecialchars($this->spArgs('mid'));
        $data['title'] = htmlspecialchars($this->spArgs('title'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['num'] = htmlspecialchars($this->spArgs('num'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));
        $data['sign'] = htmlspecialchars($this->spArgs('sign'));
        $jilu = $this->spArgs('jilu');
        $jielun = $this->spArgs('jielun');
        $id = (int) htmlentities($this->spArgs('id'));
        if (empty($data['title'])) {
            $this->msg_json(0, '请填写记录名称');
        }
        if (empty($data['number'])) {
            $this->msg_json(0, '请填写文件编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写产品名称');
        }
        if (empty($data['sign'])) {
            $this->msg_json(0, '请上传签名');
        }
        if ($data['mid'] == 1) {
            $data_m = array(
                'type' => 2,
                'name' => $data['title'],
                'q1' => htmlspecialchars($this->spArgs('q1')),
                'w1' => htmlspecialchars($this->spArgs('w1')),
                'e1' => htmlspecialchars($this->spArgs('e1')),
                'q2' => htmlspecialchars($this->spArgs('q2')),
                'w2' => htmlspecialchars($this->spArgs('w2')),
                'e2' => htmlspecialchars($this->spArgs('e2')),
                'q3' => htmlspecialchars($this->spArgs('q3')),
                'w3' => htmlspecialchars($this->spArgs('w3')),
                'e3' => htmlspecialchars($this->spArgs('e3')),
                'q4' => htmlspecialchars($this->spArgs('q4')),
                'w4' => htmlspecialchars($this->spArgs('w4')),
                'e4' => htmlspecialchars($this->spArgs('e4')),
                'q5' => htmlspecialchars($this->spArgs('q5')),
                'w5' => htmlspecialchars($this->spArgs('w5')),
                'e5' => htmlspecialchars($this->spArgs('e5')),
                'q6' => htmlspecialchars($this->spArgs('q6')),
                'w6' => htmlspecialchars($this->spArgs('w6')),
                'e6' => htmlspecialchars($this->spArgs('e6')),
                'q7' => htmlspecialchars($this->spArgs('q7')),
                'w7' => htmlspecialchars($this->spArgs('w7')),
                'e7' => htmlspecialchars($this->spArgs('e7')),
                'q8' => htmlspecialchars($this->spArgs('q8')),
                'w8' => htmlspecialchars($this->spArgs('w8')),
                'e8' => htmlspecialchars($this->spArgs('e8')),
                'q9' => htmlspecialchars($this->spArgs('q9')),
                'w9' => htmlspecialchars($this->spArgs('w9')),
                'e9' => htmlspecialchars($this->spArgs('e9')),
                'q10' => htmlspecialchars($this->spArgs('q10')),
                'w10' => htmlspecialchars($this->spArgs('w10')),
                'e10' => htmlspecialchars($this->spArgs('e10')),
            );
            $mad = spClass('m_jyexamples')->create($data_m);
            $data['mid'] = $mad;
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
            if ($re['status'] > 1) {
                $this->msg_json(0, '该记录不可操作');
            }
            $data['jilu'] = json_encode($jilu);
            $data['jielun'] = json_encode($jielun);
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->sendUpcoming(27, $id, '【' . $data['name'] . '】出厂检验');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $data['type'] = (int) htmlspecialchars($this->spArgs('type'));
            $data['jilu'] = json_encode($jilu);
            $data['jielun'] = json_encode($jielun);
            $ad = $model->create($data);
            if ($ad) {
                $this->sendUpcoming(27, $ad, '【' . $data['name'] . '】出厂检验');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    //检验和试验设备台账
    function sbtz() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_sbtz');
        $where = 'del = 0 and cid = ' . $admin['cid'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($name)) {
            $where .= ' and (number like "%' . $name . '%" or title like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'id');
        foreach ($results as $k => $v) {
            $ids = empty($v['files']) ? '0' : $v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in (' . $ids . ')', 'id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveSbtz() {
        $admin = $this->get_ajax_menu();
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['chang'] = htmlspecialchars($this->spArgs('chang'));
        $data['num'] = htmlspecialchars($this->spArgs('num'));
        $data['address'] = htmlspecialchars($this->spArgs('address'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_sbtz');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['dt'] = date('Y-m-d H:i:s');
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
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

    //标识发放记录
    function bzffjl() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_bzffjl');
        $where = 'del = 0 and cid = ' . $admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($status)) {
            $where .= ' and status =' . $status;
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $where .= ' and (number like "%' . $name . '%" or format like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'id desc');
        foreach ($results as $k => $v) {
            $ids = empty($v['files']) ? '0' : $v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in (' . $ids . ')', 'id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function saveBzffjl() {
        $admin = $this->get_ajax_menu();
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['fname'] = htmlspecialchars($this->spArgs('fname'));
        $data['fdt'] = htmlspecialchars($this->spArgs('fdt'));
        $data['lname'] = htmlspecialchars($this->spArgs('lname'));
        $data['yonghu'] = htmlspecialchars($this->spArgs('yonghu'));
        $data['fnum'] = htmlspecialchars($this->spArgs('fnum'));
        $data['snum'] = htmlspecialchars($this->spArgs('snum'));
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_bzffjl');
        if (empty($data['format'])) {
            $this->msg_json(0, '请输入产品型号规格');
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

    //检测设备校准计划
    function sbxzjh() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_sbxzjh');
        $where = 'del = 0 and cid = ' . $admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 41));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            $where .= ' and status =' . $status;
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $where .= ' and (number like "%' . $name . '%" or title like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'id desc');
        foreach ($results as $k => $v) {
            $ids = empty($v['files']) ? '0' : $v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in (' . $ids . ')', 'id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //检测设备运行记录sbyxjc
    function sbyxjc() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_sbyxjc');
        $where = 'del = 0 and cid = ' . $admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 39));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            $where .= ' and status =' . $status;
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $where .= ' and (number like "%' . $name . '%" or title like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where, 'id desc');
        foreach ($results as $k => $v) {
            $ids = empty($v['files']) ? '0' : $v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in (' . $ids . ')', 'id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function dyctparm() {
        $result = $this->get_menu();
        $model = spClass('m_dyjy_para');
        $type = htmlentities($this->spArgs('type'));
        if ($type) {
            $con = 'type = ' . $type;
        }
        $results = $model->findAll($con);
        foreach ($results as $k => $v) {
            $results[$k]['parameter'] = implode(',', json_decode($v['parameter'], true));
        }
        $this->results = $results;
    }

    function addDyctparm() {
        $admin = $this->get_ajax_menu();
        $type = htmlentities($this->spArgs('type'));
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_dyjy_para');
        $result = $model->find(array('id' => $id));
        if ($result) {
            $type = $result['type'];
            $result['parameter'] = json_decode($result['parameter'], true);
            $this->result = $result;
        }
        $this->type = $type;
    }

    /**
     * 产品参数详情
     */
    function addDyctparm1() {
        $admin = $this->get_ajax_menu();
        $type = htmlentities($this->spArgs('type'));
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_dyjy_para');
        $result = $model->find(array('id' => $id));
        if ($result) {
            $type = $result['type'];
            $result['parameter'] = json_decode($result['parameter'], true);
            $this->result = $result;
        }
        $this->type = $type;
    }

    function dyctparmInfo() {
        $admin = $this->get_ajax_menu();
        $type = htmlentities($this->spArgs('type'));
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_dyjy_para');
        $result = $model->find(array('id' => $id));
        if ($result) {
            $type = $result['type'];
            $result['parameter'] = json_decode($result['parameter'], true);
            $this->result = $result;
        }
        $this->type = $type;
    }

    function saveDyctparm() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_dyjy_para');
        $data['type'] = htmlentities($this->spArgs('type'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $parameter = $this->spArgs('parameter');
        $data['parameter'] = json_encode($parameter);
        $id = (int) htmlentities($this->spArgs('id'));
//         dump($_POST);
//         die;   //TODO
        if (empty($data['type'])) {
            $this->msg_json(0, '请选择类别');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请填写产品名称');
        }

        foreach ($parameter as $k => $v) {
            if (empty($v)) {
                $this->msg_json(0, '请确认参数填写完整');
            }
        }
        if (empty($id)) {
            $ad = $model->create($data);
            if ($ad) {
                $this->msg_json(1, '添加成功');
            } else {
                $this->msg_json(0, '网络错误，请刷新重试');
            }
        } else {
            $re = $model->find(array('id' => $id), '', 'id');
            if (empty($re)) {
                $this->msg_json(0, '信息有误，修改失败');
            }
            $ad = $model->update(array('id' => $id), $data);
            if ($ad) {
                $this->msg_json(1, '修改成功');
            } else {
                $this->msg_json(0, '网络错误，请刷新重试');
            }
        }
    }

    function delDyctparm() {
        
    }

}
