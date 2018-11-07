<?php

class service extends AppController {

    /**
     * 检查表存储
     */
    function saveProductCheck() {
        $admin = $this->islogin();
        $model = spClass('m_dyjy');
        $data['oid'] = (int) htmlspecialchars($this->spArgs('oid'));
        $data['mid'] = (int) htmlspecialchars($this->spArgs('mid')); //产品(带参数表)id
        $data['title'] = htmlspecialchars($this->spArgs('title'));    //文件名称，表顶上的名称数据
        $data['number'] = htmlspecialchars($this->spArgs('number'));   //文件编号
        $data['name'] = htmlspecialchars($this->spArgs('name'));     //产品名称
        $data['format'] = htmlspecialchars($this->spArgs('format'));   //规格型号
        $data['num'] = htmlspecialchars($this->spArgs('num'));      //检验数量
        $data['dt'] = htmlspecialchars($this->spArgs('dt'));       //检验日期
        $data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));  //产品编号
        $data['sign'] = htmlspecialchars($this->spArgs('sign'));     //检验员
        $data['prodt'] = htmlspecialchars($this->spArgs('prodt'));    //生产日期
        $data['dytype'] = htmlspecialchars($this->spArgs('type'));
        
        $id = (int) htmlentities($this->spArgs('id'));
        //获取mid
        $mid_arr = explode('/', parse_url($_SERVER["HTTP_REFERER"])['path']);
        $data['mid'] = $mid_arr[6];

        //check params
//         $this->emptyNotice($data['pnumber'], '请填写产品编号');
//         $this->emptyNotice($data['name'], '请填写产品名称');
//         $this->emptyNotice($data['sign'], '请上传签名');
        //数据处理
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'q') === 0) {
                $q[$k] = $v;
            } elseif (strpos($k, 'w') === 0) {
                $w[$k] = $v;
            } elseif (strpos($k, 'e') === 0) {
                $e[$k] = $v;
            } elseif (strpos($k, 'r') === 0) {
                $r[$k] = $v;
            }
        }
        $data['jilu'] = json_encode($q);
        $data['jielun'] = json_encode($w);
        $data['info'] = json_encode($e);

        //一产品参数对多个检查记录
        if ($id) {
            $re = $model->find(array('id' => $id));
            $this->emptyNotice($re, '数据不存在');

            $data = $this->checkUpdateArr($re, $data);
            $up = $model->update(array('id' => $id), $data);
        } else {
            //检查表新增
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $data['cid'] = $admin['cid'];
            $up = $model->create($data);
        }

        if ($up)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * 订单列表接口
     */
    function ordersLst() {
        $model = spClass('m_orders');
        $results = $model->findAll('del = 0 and status > 1', 'optdt desc', 'id,name');
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 检查表存储-app H5端
     */
    function saveJsonProduct() {
//         $admin = $this->islogin();
//         $model = spClass('m_dyjy');
        
//         $form = json_decode(file_get_contents('php://input'));
//         dump($form);
//         dump(1);die;
//         foreach ($form as $k => $v) {
//             if ($k == 'type')
//                 $data['dytype'] = $v;
//             if ($k == 'mid')
//                 $data['mid'] = $v; //参数id
//             if ($k == 'oid')
//                 $data['oid'] = $v;
//             if ($k == 'number')
//                 $data['number'] = $v;
//             if ($k == 'name')
//                 $data['name'] = $v;
//             if ($k == 'format')
//                 $data['format'] = $v;
//             if ($k == 'num')
//                 $data['num'] = $v;
//             if ($k == 'dt')
//                 $data['dt'] = $v;
//             if ($k == 'pnumber')
//                 $data['pnumber'] = $v;
//             if ($k == 'sign')
//                 $data['sign'] = $v;
//             if ($k == 'title')
//                 $data['title'] = $v;
//             if ($k == 'explain')
//                 $data['explain'] = $v;
//             //json参数数据
//             if (strpos($k, 'q') === 0) {
//                 $q[$k] = $v;
//             } elseif (strpos($k, 'w') === 0) {
//                 $w[$k] = $v;
//             } elseif (strpos($k, 'e') === 0) {
//                 $e[$k] = $v;
//             } elseif (strpos($k, 'r') === 0) {
//                 $r[$k] = $v;
//             }
//         }
//         $data['jilu'] = json_encode($q);
//         $data['jielun'] = json_encode($w);
//         $data['info'] = json_encode($e);

//         //检查表新增
//         $data['optid'] = $admin['id'];
//         $data['optname'] = $admin['name'];
//         $data['optdt'] = date('Y-m-d H:i:s');
//         $data['status'] = 1;
//         $data['cid'] = $admin['cid'];
//         $up = $model->create($data);
        
//         if ($up) $this->returnSuccess('成功');
//         $this->returnError('失败');
    
$admin = $this->islogin();
$model = spClass('m_dyjy');
$data['oid'] = (int) htmlspecialchars($this->spArgs('oid'));
$data['mid'] = (int) htmlspecialchars($this->spArgs('mid')); //产品(带参数表)id
$data['title'] = htmlspecialchars($this->spArgs('title'));    //文件名称，表顶上的名称数据
$data['number'] = htmlspecialchars($this->spArgs('number'));   //文件编号
$data['name'] = htmlspecialchars($this->spArgs('name'));     //产品名称
$data['format'] = htmlspecialchars($this->spArgs('format'));   //规格型号
$data['num'] = htmlspecialchars($this->spArgs('num'));      //检验数量
$data['dt'] = htmlspecialchars($this->spArgs('dt'));       //检验日期
$data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));  //产品编号
$data['sign'] = htmlspecialchars($this->spArgs('sign'));     //检验员
$data['prodt'] = htmlspecialchars($this->spArgs('prodt'));    //生产日期
$data['dytype'] = htmlspecialchars($this->spArgs('type'));

$id = (int) htmlentities($this->spArgs('id'));

//check params
//         $this->emptyNotice($data['pnumber'], '请填写产品编号');
//         $this->emptyNotice($data['name'], '请填写产品名称');
//         $this->emptyNotice($data['sign'], '请上传签名');
//数据处理
foreach ($_POST as $k => $v) {
    if (strpos($k, 'q') === 0) {
        $q[$k] = $v;
    } elseif (strpos($k, 'w') === 0) {
        $w[$k] = $v;
    } elseif (strpos($k, 'e') === 0) {
        $e[$k] = $v;
    } elseif (strpos($k, 'r') === 0) {
        $r[$k] = $v;
    }
}
$data['jilu'] = json_encode($q);
$data['jielun'] = json_encode($w);
$data['info'] = json_encode($e);

//一产品参数对多个检查记录
if ($id) {
    $re = $model->find(array('id' => $id));
    $this->emptyNotice($re, '数据不存在');
    
    $data = $this->checkUpdateArr($re, $data);
    $up = $model->update(array('id' => $id), $data);
} else {
    //检查表新增
    $data['optid'] = $admin['id'];
    $data['optname'] = $admin['name'];
    $data['optdt'] = date('Y-m-d H:i:s');
    $data['status'] = 1;
    $data['cid'] = $admin['cid'];
    $up = $model->create($data);
}

if ($up){
    $this->returnSuccess('成功');
}else {
    $this->returnError('失败');
}
    }

    /**
     * 参数表存储
     */
    function saveProductParams() {
        $admin = $this->islogin();
        $m_param = spClass('m_dyjy_para');
        $data['name'] = htmlspecialchars($this->spArgs('name'));     //产品名称
        $id = (int) htmlentities($this->spArgs('id'));
        //para表数据
        $p_data['type'] = htmlspecialchars($this->spArgs('type'));
        $p_data['name'] = $data['name'];

        //check params
        $this->emptyNotice($p_data['name'], '请填写产品名称');
        $this->emptyNotice($p_data['type'], '请填写产品类型');

        //数据处理
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'q') === 0) {
                $q[$k] = $v;
            } elseif (strpos($k, 'w') === 0) {
                $w[$k] = $v;
            } elseif (strpos($k, 'e') === 0) {
                $e[$k] = $v;
            } elseif (strpos($k, 'r') === 0) {
                $r[$k] = $v;
            }
        }

        $p_data['parameter'] = json_decode($r);

        //一产品参数对多个检查记录
        if ($id) {
            $p_re = $m_param->find(array('id' => $id));
            $this->emptyNotice($p_re, '数据不存在');
            $p_data = $this->checkUpdateArr($p_re, $p_data);

            $p_up = $m_param->update(array('id' => $id), $data);
        } else {
            $p_up = $m_param->create($p_data);
        }
        if ($p_up)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * 检查内容详情
     */
    function productCheckInfo() {
        $admin = $this->islogin();
        $model = spClass('m_dyjy');
        $id = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id))
            $this->returnError('id不存在');
        $results = $model->find('id=' . $id . '');
        if (empty($results))
            $this->returnError('id非法');

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 检查表详情
     */
    function productParamsInfo() {
        $admin = $this->islogin();
        $model = spClass('m_dyjy_para');
        $id = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id))
            $this->returnError('id不存在');
        $results = $model->find('id=' . $id . '');
        if (empty($results))
            $this->returnError('id非法');

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 当文件入库后，将数据库数据渲染至$text中
     * 二维码生成指定目录
     */
    function qrCodeSet($id, $text, $dir = '/uploads/qrimg/') {
        $admin = $this->islogin();
        $this->emptyNotice($id, '请指定相应的设备生成二维码');

        include "phpqrcode/qrlib.php";
        //param set
        $qr_name = time() . mt_rand(1000, 9999) . '.jpg';
        $now_path = strtotime(date("Y-m-d", time())) . '/';
        //dir set
        $this->dirCreate('.' . $dir);
        $this->dirCreate('.' . $dir . $now_path);
        //图片的生成和入库
        $path_name = '.' . $dir . $now_path . $qr_name;
        $real_dir = $dir . $now_path . $qr_name;
//         QRcode::png('fuck', 'uploads/'.$qr_name, QR_ECLEVEL_L, 10, 3, true);//保存且打印图片
        $enc = QRencode::factory(QR_ECLEVEL_L, 10, 3);
        $enc->encodePNG($text, $path_name, $saveandprint = false);

        $res = spClass('m_equipment')->update(array('id' => $id), array('qrimg' => $real_dir));
        $this->emptyNotice($res, '二维码生成失败,请重试');
    }

    /**
     * 设备新增&修改
     * 
     */
    function saveEquipment() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');

        $args = array(
            'number' => '设备编号',
            'custid' => '客户',
            'name' => '设备名称',
            'format' => '规格型号',
            'day' => '',
            'address' => '',
            'explain' => '',
            'id' => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        //web上传文件处理
//         $files = $this->spArgs('files');
//         if ($files) $data['files'] = implode(',', $files);
        $data['files'] = $this->spArgs('files');    //前端已经做了处理

        if (empty($id)) {
            $data['cid'] = $admin['cid'];
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            $this->emptyNotice($cust, '请选择客户');
            //客户数据录入
            $data['custname'] = $cust['cust_name'];
            $data['custphone'] = $cust['phone'];
            $up = $model->create($data);

            //二维码模块
            $url_path = '/qrimg/index?id=' . $up;
            $qr_url = URL . $url_path . '/';
            if ($up)
                $this->qrCodeSet($up, $qr_url); //二维码
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            $this->emptyNotice($re, '数据有误，修改失败');
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            $this->emptyNotice($cust, '请选择客户');
            //客户数据录入
            $data['custname'] = $cust['cust_name'];
            $data['custphone'] = $cust['phone'];
            $up = $model->update(array('id' => $id), $data);

//             $result = $model->find('id='.$id.'');
//             if (!empty($result['files'])) {
//                 $m_file = spClass('m_file');
//                 $files  = $m_file->findAll('id in (' . $result['files'] . ')', '', 'id,filename,filepath');
//                 $result['files'] = $files;
//                 foreach ($result['files'] as $_k => $_v){
//                     $url .= '&'.$_v['filepath'];
//                     $file_name .= '&'.$_v['filename'];
//                 }
//             } else {
//                 $result['files'] = array();
//                 $url = '';  //无文件的url
//             }
//             $url = URL.'/qrimg/index?file='.urlencode($url).'&file_name='.urlencode($file_name).'&cname='.urlencode($admin['cname']);//TODO对图片做URL处理
            $url_path = '/qrimg/index?id=' . $id;
            $qr_url = URL . $url_path;
            if ($up)
                $this->qrCodeSet($id, $qr_url); //二维码
        }
        if ($up)
            $this->returnSuccess('成功');
        $this->returnError('网络错误，请稍后重试');
    }

    /**
     * 设备管理(列表)
     */
    function equipLst() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $con = 'del=0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(number,custname,name) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 维修单新增&修改 即客户上报
     */
    function saveService() {
        $admin = $this->islogin();
        $args = array(
//             'number'  => '设备编号',
            'type' => '',
            'explain' => '',
            'id' => '',
            'workid' => '',
            'workname' => '',
            'eid' => '设备',
            'handletime' => '',
        );
        $data = $this->receiveData($args);

        //设备数据新增
        $id = $data['id'];
        unset($data['id']);
        $m_equipment = spClass('m_equipment');
        $model = spClass('m_equipment_service');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($data['handletime']))
            $data['handletime'] = date('Y-m-d H:i:s');  //处理时间

        if (empty($id)) {
            //设备最后一次保养时间的更新
            $m_equipment->update(array('id' => $data['eid'], 'del' => 0, 'cid' => $admin['cid']), array('lasttime' => date('Y-m-d')));

            $equipment = $m_equipment->find(array('id' => $data['eid'], 'cid' => $admin['cid']));
            if (empty($equipment))
                $this->returnError('设备不存在，请检查设备编号是否正确');
            $ad = $model->create($data);
            if ($ad)
                $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('id' => $id));
            if (empty($re))
                $this->returnError('数据有误，修改失败');
            $data = $this->checkUpdateArr($re, $data);

            $up = $model->update(array('id' => $id), $data);
            if ($up)
                $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
        }
    }

    /**
     * 维修单列表
     * 需要做多个搜索：维修、保养
     */
    function serviceLst() {
        $admin      = $this->islogin();
        $model      = spClass('m_equipment_service');
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $type       = urldecode(htmlspecialchars($this->spArgs('type')));
        $m_equip    = spClass('m_equipment');
        
        //该公司账号下的数据
        $equip = $m_equip->findAll(array('del' => 0, 'cid' => $admin['cid']), 'id asc', 'id');
        if (!empty($equip)){
            foreach ($equip as $k => $v){
                if ($k + 1 == count($equip)){
                    $arr_str .= $v['id'];
                    continue;
                }
                $arr_str .= $v['id'].',';
            }
        }else {
            $result['results'] = array();
            $this->returnSuccess('成功', $result);
        }
        
        $con = 'del=0 and id in ('.$arr_str.')';
        if (!empty($searchname)) {
            $con .= ' and concat(workname,explain,type,handletime) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($type)) {
            $con .= ' and type like "%' . $type . '%"';
            $page_con['type'] = $type;
        }

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach ($results as $_k => $_v) {
            $equip1 = spClass('m_equipment')->find(array('id' => $_v['eid'], 'del' => 0, 'cid' => $admin['cid']), '', 'name');
            $results[$k]['equip_name'] = $equip1['name'];
        }

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 维修单详情
     */
    function serviceInfo() {
        $admin = $this->islogin();
        $model = spClass('m_equipment_service');
        $m_log = spClass('m_equipment_service_log');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'del' => 0));
        $this->emptyNotice($result, '数据不存在或已删除');

        $equip_name = spClass('m_equipment')->find('id=' . $result['eid'] . '', '', 'name');
        $result['equip_name'] = $equip_name['name'];
        $log = $m_log->findAll('esid = ' . $id);
        if (!empty($log))
            $result['log'] = $log;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 我的客户，用于新增设备时选择
     */
    function myCust() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $con = 'del = 0 and cid = ' . $admin['cid'] . ' and saleid = ' . $admin['id'];

        $cate = spClass('m_cust_cate')->findAll('del=0 and cid=' . $admin['cid'] . '');
        foreach ($cate as $k => $v) {
            $results[$k]['name'] = $v['catename'];
            $results[$k]['children'] = $model->findAll('del = 0 and cid = ' . $admin['cid'] . ' and saleid = ' . $admin['id'] . ' and type=' . $v['id'] . '', '', 'id,cust_name');
            foreach ($results[$k]['children'] as $_k => $_v) {
                $results[$k]['children'][$_k]['name'] = $results[$k]['children'][$_k]['cust_name'];
                unset($results[$k]['children'][$_k]['cust_name']);
            }
        }

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 设备详情
     */
    function equipmentInfo() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        $this->emptyNotice($result, '数据不存在或已删除');
        if (!empty($result['files'])) {
            $file = explode(',', $result['files']);
            foreach ($file as $k => $v) {
                $files[] = spClass('m_file')->find(array('id' => $v), '', 'id,filepath,filename');
            }
            $result['files'] = $files;
        } else {
            $result['files'] = array();
        }

        $service = $m_equipment_service->findAll('eid = ' . $id);
        if (!empty($service))
            $result['service'] = $service;
        $this->returnSuccess('成功', $result);
    }

    /**
     * -----------------------------维修管理模块---------------------------------------
     */

    /**
     * 我的定位考勤列表
     */
    function localLst() {
        $admin = $this->islogin();
        $model = spClass('m_kqdkjl');
        $id = $admin['id'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'uid = ' . $id . ' and cid = ' . $admin['cid'];
        if ($name)
            $con .= ' and address like "%' . $name . '%"';    //where like

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,optdt,address,`explain`');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 费用报销管理
     */
    function payMonLst() {
        $admin = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status = urldecode(htmlspecialchars($this->spArgs('status')));
        $model = spClass('m_expend');
        $m_user = spClass('m_admin');

        //where
        $con = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname))
            $con .= ' and concat(paymoney,adddt) like "%' . $searchname . '%"';
        if (!empty($status)) {
            if ($status != 3) {
                $con .= ' and status<>3';
            } else {
                $con .= ' and status=' . $status . '';
            }
        }

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        foreach ($results as $k => $v) {
            $str_status = '未报销';
            if ($v['status'] == 3)
                $str_status = '已报销';

            $result['results'][$k] = array(
                'id' => $v['id'],
                'username' => $v['salename'],
                'paymoney' => $v['paymoney'],
                'adddt' => $v['adddt'],
                'catename' => $v['catename'],
                'content' => $v['content'],
                'status' => $str_status, //文档申明判断报销状态：不为3的都是未报销
            );
        }
        $this->returnSuccess('成功', $result);
    }

    /**
     * 费用报销详情
     */
    function payMonInfo() {
        $admin = $this->islogin();
        $model = spClass('m_expend');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result))
            $this->returnError('数据不存在或已删除');

        $paycate = spClass('m_paycate')->find('id=' . $result['cateid'] . ' and del=0 and cid=' . $admin['cid'] . '');
        $results = array();
        $results['id'] = $result['id'];
        $results['username'] = $result['salename'];
        $results['adddt'] = $result['adddt'];
        $results['catename'] = $paycate['catename'];
        $results['paymoney'] = $result['paymoney'];
        $results['status'] = $result['status'];
        $results['content'] = $result['content'];
        if ($results['status'] == 3) {
            $results['status'] = '已报销';
        } else {
            $results['status'] = '未报销';
        }

        $this->returnSuccess('成功', $results);
    }

    /**
     * 分配人员 列表
     * 职位名称
     */
    function allotUser() {
        $admin = $this->islogin();
        $model = spClass('m_admin');
        $id = $admin['id'];
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del=0 and cid = ' . $admin['cid'];
        if ($name)
            $con .= ' and name like "%' . $name . '%"';    //where like

        $results = $model->findAll($con, 'id asc', 'id,name,pname');
        if (empty($results))
            $this->returnError('暂无数据');

        $result['results'] = array_values($results);
        $this->returnSuccess('成功', $result);
    }

    /**
     * 维修单管理
     * 所有列表status=未处理； status=2 已处理；
     * 即未处理为status=0，待处理为红点
     */
    function serviceMangLst() {
        $admin = $this->islogin();
        $this->commonServiceLst();
    }

    function commonServiceLst($workid = '') {
        $admin = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status = urldecode(htmlspecialchars($this->spArgs('status')));
        $model = spClass('m_equipment_service');
        $m_equip = spClass('m_equipment');

        //where
        $con = 'del=0';
        if (!empty($searchname))
            $con .= ' and concat(workname,`explain`) like "%' . $searchname . '%"';
        if (!empty($status))
            $con .= ' and status=' . $status . '';
        //我的列表check
        if (!empty($workid))
            $con .= ' and workid=' . $workid . '';

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        foreach ($results as $k => $v) {
            $equip = $m_equip->find('id=' . $v['eid'] . ' and del=0 and cid=' . $admin['cid'] . '');

            $result['results'][$k] = array(
                'id' => $v['id'],
                'custname' => $equip['custname'],
                'name' => $equip['name'],
                'number' => $equip['number'],
                'status' => (int) $v['status'], //app端判断类型来选择红点
                'address' => $equip['address'],
                'see' => $equip['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }

    /**
     * 维修单管理
     */
    function myServiceMangLst() {
        $admin = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status = urldecode(htmlspecialchars($this->spArgs('status')));
        $model = spClass('m_equipment_service');
        $m_equip = spClass('m_equipment');

        //where
        $con = 'del=0';
        if (!empty($searchname))
            $con .= ' and concat(workname,`explain`) like "%' . $searchname . '%"';
        if (!empty($status))
            $con .= ' and status=' . $status . '';
        if (!empty($admin['role']))
            $con .= ' and workid=' . $admin['id'] . ''; //根据auth的判断，暂时这样处理 TODO

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        foreach ($results as $k => $v) {
            $equip = $m_equip->find('id=' . $v['eid'] . ' and del=0 and cid=' . $admin['cid'] . '');

            $result['results'][$k] = array(
                'id' => $v['id'],
                'custname' => $equip['custname'],
                'name' => $equip['name'],
                'number' => $equip['number'],
                'status' => (int) $v['status'],
                'address' => $equip['address'],
                'see' => $v['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }

    /**
     *  现场知识库新增
     */
    function saveLiveCon() {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $arg = array(
            'live_title' => '标题',
            'live_desc'  => '',
            'live_adddt' => '',
            'cateid'     => '',
            'id'         => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re))
                $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['cid'] = $admin['cid'];
            $up = $model->create($data);
        }
        if ($up)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * 现场知识库列表
     */
    function liveConLst() {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $cateid = (int) htmlspecialchars($this->spArgs('cateid'));

        $con = 'del=0 and cid=' . $admin['cid'] . '';
        if ($name)
            $con .= ' and title like "%' . $name . '%"';    //where like
        if ($cateid)
            $con .= ' and cateid=' . $cateid . '';

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc');
        $pager = $model->spPager()->getPager();
        $result['pager'] = $pager;

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 现场知识库详情
     */
    function liveConInfo() {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) $this->returnError('暂无数据');
        if (!empty($result['cateid'])){
            $cate_name = spClass('m_livecon_cate')->find(array('id' => $result['cateid'], 'del' => 0, 'cid' => $admin['cid']), '', 'catename');
        }
        $result['catename'] = $cate_name['catename'];
        $this->returnSuccess('成功', $result);
    }

    /**
     * 知识库分类新增
     */
    function saveLiveCate() {
        $admin = $this->islogin();
        $model = spClass('m_livecon_cate');
        $arg = array(
            'catename' => '标题',
            'catedesc' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re))
                $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['optid'] = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt'] = date('Y-m-d H:i:s');
            $data['cid'] = $admin['cid'];
            $up = $model->create($data);
        }
        if ($up)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * 知识库分类列表
     */
    function liveCateLst() {
        $admin = $this->islogin();
        $model = spClass('m_livecon_cate');
        $m_live = spClass('m_livecon');
        $con = 'del=0 and cid=' . $admin['cid'] . '';
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if ($name)
            $con .= ' and catename like "%' . $name . '%"';    //where like

        $results = $model->findAll($con, 'optdt desc', 'id,catename,catedesc');
        if (empty($results))
            $this->returnError('暂无数据');

        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    /**
     * 用款类型列表
     */
    function paycate() {
        $admin = $this->islogin();
        $con = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model = spClass('m_paycate');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc,id desc');
        if (empty($results))
            $this->returnError('暂无数据');

        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;

        foreach ($results as $k => $v) {
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }

    /**
     * 设备维修单数据校验
     * @param string $esid
     */
    function checkService($esid) {
        $service = spClass('m_equipment_service')->find(array('id' => $esid));
        if (empty($service))
            $this->returnError('设备维修单不存在');
    }

    /**
     * 所有删除
     */

    /**
     * 设备删除
     */
    function delEquipment() {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_equipment', $id);
    }

    /**
     * 维修单删除
     */
    function delService() {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_equipment_service')->update(array('id' => $id), array('del' => 1));
        if ($res)
            $this->returnSuccess('成功');;
        $this->returnError('失败');
    }

    /**
     * 维修单记录删除
     */
    function delServiceLog() {
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_equipment_service_log')->update(array('id' => $id), array('del' => 1));
        if ($res)
            $this->returnSuccess('成功');;
        $this->returnError('失败');
    }

    /**
     * 知识库类型删除
     */
    function delLiveCate() {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_livecon_cate', $id);
    }

    /**
     * 知识库删除
     */
    function delLiveCon() {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_livecon', $id);
    }

    /**
     * 费用报销删除
     */
    function delPayMon() {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_expend')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res)
            $this->returnSuccess('成功');
        $this->returnError('失败');
    }

}
