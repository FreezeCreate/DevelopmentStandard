<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class produce extends IndexController {
    
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

    function plan() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $con = 'b.del = 0 and b.cid = ' . $admin['cid'];
        $status = (int) $this->spArgs('status');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 4));
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
            $con .= ' and (b.number like "%' . $name . '%" or b.workshop like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a left outer join ' . DB_NAME . '_produce as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function planInfo() {
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

    function editPlan() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $id = (int) htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid']));
        if ($result) {
            $result['children'] = spClass('m_produce_chanpin')->findAll(array('pid' => $id));
            $this->result = $result;
        } else {
            //新增逻辑
            $sql = 'select oid from '.DB_NAME.'_produce where del=0 and cid='.$admin['cid'].' group by oid';
            $exist_orders = $model->findSql($sql);
            foreach ($exist_orders as $k => $v){
                if (empty($v['oid'])) continue;
                if ($k + 1 == count($exist_orders)){
                    $o_id .= $v['oid'];
                    continue;
                }
                $o_id .= $v['oid'].',';
            }
            if (!empty($o_id)){
                //订单选择
                $o_sql      = 'select id,name from '.DB_NAME.'_orders where del=0 and comid='.$admin['cid'].' and id not in ('.$o_id.')';
                $all_orders = spClass('m_orders')->findSql($o_sql);
                $this->all_orders = $all_orders;
            }
            
//             $this->error('信息不存在');
        }
    }

    function savePlan() {
        $admin = $this->get_ajax_menu();
        //订单选择处理
        $oid = htmlspecialchars($this->spArgs('oid'));
        if (!empty($oid)) $data['oid'] = $oid;
        $model = spClass('m_produce');
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['No'] = htmlspecialchars($this->spArgs('No'));
        $data['workshop'] = htmlspecialchars($this->spArgs('workshop'));
        $data['explain'] = htmlspecialchars($this->spArgs('pexplain'));
        $id = (int) htmlentities($this->spArgs('id'));
        $name = $this->spArgs('name');
        $format = $this->spArgs('format');
        $num = $this->spArgs('num');
        $dt = $this->spArgs('dt');
        $explain = $this->spArgs('explain');
        $data['cid'] = $admin['cid'];
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($name[0]) || empty($num[0])) {
            $this->msg_json(0, '请确认信息完整');
        }
        foreach ($name as $k => $v) {
            if ($v && $num[$k]) {
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'format' => $format[$k],
                    'num' => $num[$k],
                    'dt' => $dt[$k],
                    'explain' => $explain[$k],
                );
            }
        }
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0));
            if (empty($re)) {
                $this->msg_json(0, '信息不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                spClass('m_produce_chanpin')->updateAll(array('pid' => $id), $chanpin);
                $this->sendUpcoming(4, $id, '【' . $data['workshop'] . '】生产计划');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $up = $model->create($data);
            $this->msg_json(1, '操作成功');
//             $this->msg_json(0, '操作失败1');
        }
    }

    function draw() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_produce');
        $con = 'b.del = 0 and b.cid = ' . $admin['cid'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $st = spClass('m_flow_set')->find(array('id' => 9));
        $st = explode(',', $st['statusstr']);
        $statustxt = $GLOBALS['PRO_STATUS'];
        foreach ($st as $k => $v) {
            $sta = explode('|', $v);
            $statustxt[$sta[1]]['text'] = $sta[0];
            $statustxt[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $statustxt;
        if (!empty($name)) {
            $con .= ' and (b.number like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_draw as b on a.id = b.oid where ' . $con . ' order by b.id desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function drawInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 9);
        $result = $this->result;
        if ($result) {
            $result['children'] = spClass('m_draw_mater')->findAll(array('pid' => $id));
            $this->result = $result;
        } else {
            $this->error('信息不存在');
        }
    }

    function editDraw() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 9);
        $admin = $this->admin;
        $result = $this->result;
        $orders = spClass('m_orders')->findAll('del = 0 and status > 1 and comid = ' . $admin['cid'], 'optdt desc');
        $this->orders = $orders;
        if ($result) {
            $result['children'] = spClass('m_draw_mater')->findAll(array('pid' => $id));
            $this->result = $result;
        }
    }

    function saveDraw() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_draw');
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $data['oid'] = htmlspecialchars($this->spArgs('oid'));
        $id = (int) htmlentities($this->spArgs('id'));
        $name = $this->spArgs('name');
        $num = $this->spArgs('num');
        $data['status'] = 1;
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['uid'] = $admin['id'];
        $data['uname'] = $admin['name'];
        $data['dname'] = $admin['dname'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($data['number'])) {
            $this->msg_json(0, '请填写文件编号');
        }
        if (empty($data['dt'])) {
            $this->msg_json(0, '请填写领取时间');
        }
        if (empty($data['explain'])) {
            $this->msg_json(0, '请填写领取事由');
        }
        if (empty($name[0]) || empty($num[0])) {
            $this->msg_json(0, '请确认信息完整');
        }
        foreach ($name as $k => $v) {
            if ($v && $num[$k]) {
                $chanpin[] = array(
                    'pid' => $id,
                    'name' => $v,
                    'num' => $num[$k],
                );
            }
        }
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0));
            if (empty($re)) {
                $this->msg_json(0, '信息不存在');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                spClass('m_draw_mater')->updateAll(array('pid' => $id), $chanpin);
                $this->sendUpcoming(9, $id, '领料单申请');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            $data['cid'] = $admin['cid'];
            $up = $model->create($data);
            foreach ($chanpin as $k => $v) {
                $chanpin[$k]['pid'] = $up;
            }
            if ($up) {
                spClass('m_draw_mater')->createAll($chanpin);
                $this->sendUpcoming(9, $up, '领料单申请');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
            $this->msg_json(0, '操作失败1');
        }
    }
    
    function liucheng() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_dyjy');
        //         $con = 'b.del = 0 and b.type = 1 and b.cid = ' . $admin['cid'];
        $con = 'b.del = 0 and b.dytype=4 and b.cid = ' . $admin['cid'];
        
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
//         $result = $this->get_menu();
//         $this->menu = $result['menu'];
//         $admin = $result['admin'];
//         $model = spClass('m_liucheng');
//         $con = 'b.del = 0 and b.cid = ' . $admin['cid'];
//         $status = (int) $this->spArgs('status');
//         $name = urldecode(htmlspecialchars($this->spArgs('name')));
//         $st = spClass('m_flow_set')->find(array('id' => 10));
//         $st = explode(',', $st['statusstr']);
//         $statustxt = $GLOBALS['PRO_STATUS'];
//         foreach ($st as $k => $v) {
//             $sta = explode('|', $v);
//             $statustxt[$sta[1]]['text'] = $sta[0];
//             $statustxt[$sta[1]]['color'] = $sta[2];
//         }
//         $this->status = $statustxt;
//         if (!empty($status)) {
//             if ($status == 2) {
//                 $con .= ' and b.status in(0,2)';
//             } else {
//                 $con .= ' and b.status = ' . $status;
//             }
//             $page_con['status'] = $status;
//         }
//         if (!empty($name)) {
//             $con .= ' and (a.number like "%' . $name . '%" or b.number like "%' . $name . '%" or b.name like "%' . $name . '%")';
//             $page_con['name'] = $name;
//         }
//         $sql = 'select a.number as onumber,a.name as oname,b.* from ' . DB_NAME . '_orders as a right outer join ' . DB_NAME . '_liucheng as b on a.id = b.oid where ' . $con . ' order by b.optdt desc';
//         $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
//         $this->results = $results;
//         $this->pager = $model->spPager()->getPager();
//         $this->page_con = $page_con;
    }

    function addlcex() {
        
        if($_POST){
            $admin = $this->get_ajax_menu();
            $name = htmlspecialchars($this->spArgs('name'));
            $gname = $this->spArgs('gname');
            $content = $this->spArgs('content');
            $ad = spClass('m_lcex')->create(array('name'=>$name,'cid'=>$admin['cid']));
            if(empty($ad)){
                $this->msg_json(0, '操作失败');
            }
            $s = 1;
            foreach($gname as $k=>$v){
                $lad = spClass('m_lcex')->create(array('name'=>$v,'pid'=>$ad,'sort'=>$s));
                $s++;
                $ls = 1;
                foreach($content[$k] as $k1=>$v1){
                    spClass('m_lcex_ch')->create(array('content'=>$v1,'pid'=>$lad,'sort'=>$ls));
                    $ls++;
                }
            }
            $this->msg_json(1, '操作成功');
        }else{
            $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        }
        
    }

    function editLiucheng() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_liucheng');
        $model_children = spClass('m_liucheng_gongxu');
        $id = (int) htmlentities($this->spArgs('id'));
        $lid = (int) htmlentities($this->spArgs('lid'));
        $result = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']));
        $orders = spClass('m_orders')->findAll('del = 0 and status > 1 and comid = ' . $admin['cid'], 'optdt desc');
        $this->orders = $orders;
        $lcex = spClass('m_lcex')->findAll('pid = 0 and cid = ' . $admin['cid']);
        $this->lcex = $lcex;
        if ($result) {
            $result['children'] = $model_children->findAll(array('pid' => $id), 'sort');
            $this->result = $result;
            $lid = $result['lid'];
        } else {
            
        }
        $lid = empty($lid) ? $lcex[0]['id'] : $lid;
        $lcre = spClass('m_lcex')->findAll(array('pid' => $lid), 'sort');
        foreach ($lcre as $k => $v) {
            $lcre[$k]['children'] = spClass('m_lcex_ch')->findAll(array('pid' => $v['id']));
        }
        $this->lcre = $lcre;
    }
    
    /**
     * 工序流程卡
     */
    function editDyctlog1() {
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
        $paras = $m_para->findAll(array('type' => 4));
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
        $orders = spClass('m_orders')->findAll('del = 0 and status > 1 and comid='.$admin['cid'].'', 'optdt desc');
//         $orders = spClass('m_orders')->findAll('del = 0 and comid='.$admin['cid'].'', 'optdt desc');
        
        $this->orders = $orders;
        $examples = spClass('m_jyexamples')->findAll(array('type' => 1), 'id desc', 'id,name');
        $this->examples = $examples;
        $mode = spClass('m_jyexamples')->find(array('id' => $mid));
        if (!empty($mode)) {
            $this->mode = $mode;
            //             $this->mid = $mid;
        }
    }

    function liuchengInfo() {
        $id = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 10);
        $result = $this->result;
        if ($result) {
            $gongxu = spClass('m_liucheng_gongxu')->findAll(array('pid' => $id), 'sort');
            foreach ($gongxu as $k => $v) {
                $result['children'][$v['sort']]['sign'] = $v['sign'];
                $result['children'][$v['sort']]['dt'] = $v['dt'];
                $result['children'][$v['sort']]['content'] = json_decode($v['content'], true);
            }
            $this->result = $result;
            $lcre = spClass('m_lcex')->findAll(array('pid' => $result['lid']), 'sort');
            foreach ($lcre as $k => $v) {
                $lcre[$k]['children'] = spClass('m_lcex_ch')->findAll(array('pid' => $v['id']));
            }
            $this->lcre = $lcre;
        } else {
            $this->error('信息不存在');
        }
    }

    function saveLiucheng() {
        $admin = $this->get_ajax_menu();
        $model = spClass('m_liucheng');
        $m_liucheng_gongxu = spClass('m_liucheng_gongxu');
        $id = (int) htmlentities($this->spArgs('id'));
        $oid = (int) htmlentities($this->spArgs('oid'));
        $data['lid'] = htmlspecialchars($this->spArgs('lid'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['format'] = htmlspecialchars($this->spArgs('format'));
        $data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));
        $sign = $this->spArgs('sign');
        $dt = $this->spArgs('date');
        $content = $this->spArgs('content');
        if (empty($data['number'])) {
            $this->msg_json(0, '请输入文件编号');
        }
        if (empty($data['name'])) {
            $this->msg_json(0, '请输入产品名称');
        }
        foreach ($content as $k => $v) {
            foreach ($v as $k1 => $v1) {
                if ($v1 !== '√' && $v1 !== '×' && $v1 !== '/') {
                    $this->msg_json(0, '请完善质量情况');
                }
            }
            if (empty($sign[$k])) {
                $this->msg_json(0, '请上传签名');
            }
            $gx[] = array(
                'optid' => $admin['id'],
                'optname' => $admin['name'],
                'optdt' => date('Y-m-d H:i:s'),
                'sign' => $sign[$k],
                'dt' => $dt[$k],
                'content' => json_encode($v),
                'sort' => $k,
            );
        }
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0));
            if (empty($re)) {
                $this->msg_json(0, '数据有误');
            }
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                foreach ($gx as $k => $v) {
                    $gx[$k]['pid'] = $ad;
                }
                $sort = $m_liucheng_gongxu->updateAll(array('pid' => $ad), $gx);
                $this->sendUpcoming(10, $id, '【' . $data['name'] . '】电气装配工序流程卡');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        } else {
            if (empty($oid)) {
                // $this->msg_json(0, '请选择订单');
            }
            $data['oid'] = $oid;
            $data['cid'] = $admin['cid'];
            $ad = $model->create($data);
            if ($ad) {
                foreach ($gx as $k => $v) {
                    $gx[$k]['pid'] = $ad;
                }
                $sort = $m_liucheng_gongxu->updateAll(array('pid' => $ad), $gx);
                $this->sendUpcoming(10, $id, '【' . $data['name'] . '】电气装配工序流程卡');
                $this->msg_json(1, '操作成功');
            } else {
                $this->msg_json(0, '操作失败');
            }
        }
    }

}
