<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class stock extends IndexController {

    function mater() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 5));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            if ($status == 2) {
                $con .= ' and b.status in(0,2)';
            } else {
                $con .= ' and b.status = ' . $status;
            }
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $con .= ' and (number like "%' . $name . '%" or name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a left outer join ' . DB_NAME . '_purchase as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function bginfo() {
        $id = (int) htmlentities($this->spArgs('id'));

        $pre = spClass('m_purchase')->find(array('id' => $id), '', 'id,oid');
        $re = spClass('m_purchase_biangeng')->find(array('oid' => $pre['oid']), '', 'id');
        $this->jump(spUrl('stock', 'biangengInfo', array('id' => $re['id'])));
    }

    function cginfo() {
        $id = (int) htmlentities($this->spArgs('id'));

        $pre = spClass('m_purchase')->find(array('id' => $id), '', 'id,oid');
        $re = spClass('m_purchase_caigou')->find(array('oid' => $pre['oid']), '', 'id');
        $this->jump(spUrl('stock', 'caigouInfo', array('id' => $re['id'])));
    }

    function materInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 4);
        $result = $this->result;
        if ($result) {
            $result['children'] = spClass('m_produce_chanpin')->findAll(array('pid' => $id));
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function editMater() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_purchase');
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id));
        if ($result) {
            $result['children'] = spClass('m_purchase_mater')->findAll(array('pid' => $id));
            $log = spClass('m_flow_log')->findAll(array('table' => 'purchase', 'tid' => $id));
            foreach ($log as $k => $v) {
                if (!empty($v['files'])) {
                    $files = spClass('m_file')->findAll('id in (' . $v['files'] . ')', '', 'id,filename');
                    $log[$k]['files'] = $files;
                } else {
                    $log[$k]['files'] = array();
                }
            }
            $this->log = $log;
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveMater() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_purchase');
        $data['is_have'] = (int) htmlspecialchars($this->spArgs('is_have'));
        $data['is_stock'] = (int) htmlspecialchars($this->spArgs('is_stock'));
        $data['qianming'] = htmlspecialchars($this->spArgs('qianming'));
        $data_bg['number'] = htmlspecialchars($this->spArgs('number'));
        $data_bg['title'] = htmlspecialchars($this->spArgs('title'));
        $data_bg['project'] = htmlspecialchars($this->spArgs('project'));
        $data_bg['case'] = htmlspecialchars($this->spArgs('case'));
        $data_bg['start'] = htmlspecialchars($this->spArgs('start'));
        $data_bg['end'] = htmlspecialchars($this->spArgs('end'));
        $data_bg['yiju'] = htmlspecialchars($this->spArgs('yiju'));
        $data_bg['zlyijian'] = htmlspecialchars($this->spArgs('zlyijian'));
        $data_bg['jsyijian'] = htmlspecialchars($this->spArgs('jsyijian'));
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $model->find(array('id' => $id));
        if (empty($re)) {
            $this->msg_json(0, '数据不存在');
        }
        $data_bg['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($data['is_have'] == 1) {
            if (empty($data['qianming'])) {
                $this->msg_json(0, '请上传签名');
            }
            unset($data['is_stock']);
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $data_log = array('table' => 'purchase', 'tid' => $id, 'status' => 1, 'statusname' => '元器件检查', 'name' => '全部存在', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '元器件全部在合格供应商名单中', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => 5, 'qianming' => $data['qianming']);
                spClass('m_flow_log')->create($data_log);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else if ($data['is_have'] == 2) {
            if (empty($data_bg['number'])) {
                $this->msg_json(0, '请填写文件编号');
            }
            if (empty($data_bg['title'])) {
                $this->msg_json(0, '请填写标题');
            }
            if (empty($data_bg['case'])) {
                $this->msg_json(0, '请填写变更原因');
            }
            if (empty($data_bg['start'])) {
                $this->msg_json(0, '请填写变更前内容');
            }
            if (empty($data_bg['end'])) {
                $this->msg_json(0, '请填写变更后内容');
            }
            unset($data['is_stock']);
            $up = $model->update(array('id' => $id), $data);
            if (empty($up)) {
                $this->msg_json(0, '操作失败');
            }
            $data_log = array('table' => 'purchase', 'tid' => $id, 'status' => 2, 'statusname' => '元器件检查', 'name' => '不在合格供应商名单中', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '元器件不在合格供应商名单中', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => 5);
            spClass('m_flow_log')->create($data_log);
            $data_bg['cid'] = $admin['cid'];
            $data_bg['optid'] = $admin['id'];
            $data_bg['optname'] = $admin['name'];
            $data_bg['dname'] = $admin['dname'];
            $data_bg['optdt'] = date('Y-m-d H:i:s');
            $data_bg['oid'] = $re['oid'];
            $data_bg['pid'] = $re['id'];
            $ad = spClass('m_purchase_biangeng')->create($data_bg);
            if ($ad) {
                $this->sendUpcoming(6, $ad, '【' . $data_bg['title'] . '】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else if ($data['is_stock'] == 1) {
            if (empty($data['qianming'])) {
                $this->msg_json(0, '请上传签名');
            }
            unset($data['is_have']);
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $data_log = array('table' => 'purchase', 'tid' => $id, 'status' => 1, 'statusname' => '元器件检查', 'name' => '库存足够', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '元器件库存足够', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => 5, 'qianming' => $data['qianming']);
                spClass('m_flow_log')->create($data_log);
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else if ($data['is_stock'] == 2) {
            $name = $this->spArgs('name');
            $format = $this->spArgs('format');
            $supplier = $this->spArgs('supplier');
            $num = $this->spArgs('num');
            $explain = $this->spArgs('explain');
            if (empty($name)) {
                $this->msg_json(0, '请填写请购产品');
            }
            foreach ($name as $k => $v) {
                $vname = trim(htmlspecialchars($v));
                if ($vname) {
                    $data_cg[] = array(
                        'name' => trim(htmlspecialchars($v)),
                        'format' => trim(htmlspecialchars($format[$k])),
                        'supplier' => trim(htmlspecialchars($supplier[$k])),
                        'num' => trim(htmlspecialchars($num[$k])),
                        'explain' => trim(htmlspecialchars($explain[$k])),
                    );
                }
            }
            unset($data['is_have']);
            $up = $model->update(array('id' => $id), $data);
            if (empty($up)) {
                $this->msg_json(0, '操作失败');
            }
            $data_log = array('table' => 'purchase', 'tid' => $id, 'status' => 2, 'statusname' => '元器件检查', 'name' => '库存不足', 'courseid' => 0, 'optdt' => date('Y-m-d H:i:s'), 'explain' => '元器件库存不足', 'ip' => Common::getIp(), 'checkname' => $admin['name'], 'checkid' => $admin['id'], 'mid' => 5);
            spClass('m_flow_log')->create($data_log);
            $data_bg['cid'] = $admin['cid'];
            $data_bg['optid'] = $admin['id'];
            $data_bg['optname'] = $admin['name'];
            $data_bg['optdt'] = date('Y-m-d H:i:s');
            $data_bg['oid'] = $re['oid'];
            $data_bg['pid'] = $re['id'];
            $ad = spClass('m_purchase_caigou')->create($data_bg);
            if ($ad) {
                foreach ($data_cg as $k => $v) {
                    $data_cg[$k]['pid'] = $ad;
                }
                spClass('m_purchase_caigou_mater')->createAll($data_cg);
                $this->sendUpcoming(7, $ad, '【请购单申请】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function biangeng() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 6));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            if ($status == 2) {
                $con .= ' and b.status in(0,2)';
            } else {
                $con .= ' and b.status = ' . $status;
            }
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $con .= ' and (b.number like "%' . $name . '%" or b.name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_purchase_biangeng as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function biangengInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 6);
    }

    function editBiangeng() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_purchase_biangeng');
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id,'cid'=>$admin['cid']));
        if ($result) {
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveBiangeng() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_purchase_biangeng');
        $data_bg['number'] = htmlspecialchars($this->spArgs('number'));
        $data_bg['title'] = htmlspecialchars($this->spArgs('title'));
        $data_bg['project'] = htmlspecialchars($this->spArgs('project'));
        $data_bg['case'] = htmlspecialchars($this->spArgs('case'));
        $data_bg['start'] = htmlspecialchars($this->spArgs('start'));
        $data_bg['end'] = htmlspecialchars($this->spArgs('end'));
        $data_bg['yiju'] = htmlspecialchars($this->spArgs('yiju'));
        $data_bg['zlyijian'] = htmlspecialchars($this->spArgs('zlyijian'));
        $data_bg['jsyijian'] = htmlspecialchars($this->spArgs('jsyijian'));
        $id = (int) htmlentities($this->spArgs('id'));
        $data_bg['status'] = 1;
        if (empty($data_bg['number'])) {
            $this->msg_json(0, '请填写文件编号');
        }
        if (empty($data_bg['title'])) {
            $this->msg_json(0, '请填写标题');
        }
        if (empty($data_bg['case'])) {
            $this->msg_json(0, '请填写变更原因');
        }
        if (empty($data_bg['start'])) {
            $this->msg_json(0, '请填写变更前内容');
        }
        if (empty($data_bg['end'])) {
            $this->msg_json(0, '请填写变更后内容');
        }
        $data_bg['optid'] = $admin['id'];
        $data_bg['optname'] = $admin['name'];
        $data_bg['dname'] = $admin['dname'];
        $data_bg['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            if ($re['status'] > 2) {
                $this->msg_json(0, '该申请已通过审核，不可编辑');
            }
            $up = $model->update(array('id' => $id), $data_bg);
            if ($up) {
                $this->sendUpcoming(6, $id, '【' . $data_bg['title'] . '】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data_bg['cid'] = $admin['cid'];
            $ad = $model->create($data_bg);
            if ($ad) {
                $this->sendUpcoming(6, $ad, '【' . $data_bg['title'] . '】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

    function caigou() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $con = 'b.del = 0 and b.cid = '.$admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 7));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($status)) {
            if ($status == 2) {
                $con .= ' and b.status in(0,2)';
            } else {
                $con .= ' and b.status = ' . $status;
            }
            $page_con['status'] = $status;
        }
        if (!empty($name)) {
            $con .= ' and (b.number like "%' . $name . '%" or b.name like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_purchase_caigou as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function caigouInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 7);
        $result = $this->result;
        $result['children'] = spClass('m_purchase_caigou_mater')->findAll(array('pid' => $result['id']));
        $this->result = $result;
    }

    function editCaigou() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_purchase_caigou');
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id));
        if ($result) {
            $result['children'] = spClass('m_purchase_caigou_mater')->findAll(array('pid' => $result['id']));
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveCaigou() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_purchase_caigou');
        $id = (int)  htmlentities($this->spArgs('id'));
        $data_bg['number'] = htmlspecialchars($this->spArgs('number'));
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $supplier = $this->spArgs('supplier');
        $num = $this->spArgs('num');
        $explain = $this->spArgs('explain');
        if (empty($name)) {
            $this->msg_json(0, '请填写请购产品');
        }
        foreach ($name as $k => $v) {
            $vname = trim(htmlspecialchars($v));
            if ($vname) {
                $data_cg[] = array(
                    'name' => trim(htmlspecialchars($v)),
                    'format' => trim(htmlspecialchars($format[$k])),
                    'supplier' => trim(htmlspecialchars($supplier[$k])),
                    'num' => (int)htmlspecialchars($num[$k]),
                    'explain' => trim(htmlspecialchars($explain[$k])),
                    'optdt' => date('Y-m-d H:i:s'),
                );
            }
        }
        $data_bg['optid'] = $admin['id'];
        $data_bg['optname'] = $admin['name'];
        $data_bg['optdt'] = date('Y-m-d H:i:s');
        $ad = spClass('m_purchase_caigou')->create($data_bg);
        if ($ad) {
            $this->sendUpcoming(7, $ad, '【采购单申请】');
            $this->msg_json(1, '操作成功');
        } else {
            $this->msg_json(0, '操作失败');
        }
        if ($id) {
            $re = $model->find(array('id' => $id));
            if (empty($re)) {
                $this->msg_json(0, '数据不存在');
            }
            if ($re['status'] > 2) {
                $this->msg_json(0, '该申请已通过审核，不可编辑');
            }
            $up = $model->update(array('id' => $id), $data_bg);
            if ($up) {
                foreach ($data_cg as $k => $v) {
                    $data_cg[$k]['pid'] = $id;
                }
                spClass('m_purchase_caigou_mater')->createAll($data_cg);
                $this->sendUpcoming(7, $id, '【' . $data_bg['title'] . '】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data_bg['cid'] = $admin['cid'];
            $ad = $model->create($data_bg);
            if ($ad) {
                foreach ($data_cg as $k => $v) {
                    $data_cg[$k]['pid'] = $ad;
                }
                spClass('m_purchase_caigou_mater')->createAll($data_cg);
                $this->sendUpcoming(7, $ad, '【' . $data_bg['title'] . '】');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }
    
    function gysgl(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_gysgl');
        $where = 'del = 0 and cid = '.$admin['cid'];
        $status = (int)$this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id'=>28));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if(!empty($status)){
            $where .= ' and status ='.$status;
            $page_con['status'] = $status;
        }
        if(!empty($name)){
            $where .= ' and (number like "%'.$name.'%" or name like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'id desc');
        foreach($results as $k=>$v){
            $ids = empty($v['files'])?'0':$v['files'];
            $results[$k]['files'] = spClass('m_file')->findAll('id in ('.$ids.')','id,filename');
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    

}
