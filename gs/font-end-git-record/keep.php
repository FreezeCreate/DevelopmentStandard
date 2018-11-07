<?php


class keep extends AppController 
{
    
    /**
     * TO DO 新增一个报销表 费用报销详情页的审核(拒绝和处理)-app
     * TO DO 采购、退货、出库、入库的修改 入库出库的新增文档编写
     * TO DO 我的客户删除接口
     * TO DO 维修单处理接口(只有workID=自己才或者是上级才能处理)
     * 
     * TO DO 员工进程上报 不做
     * TO DO 设备维修详情 中间的维修频率显示：维修了几次、保养了几次
     * 
     * TO DO 设备管理页无未处理和已处理项
     * 
     */
    
    
    /**
     * app端消息提醒处理
     */
    function jpushMsg()
    {
        require 'jpush/autoload.php';
        $client = new \JPush\Client($GLOBALS['jpush']['appKey'], $GLOBALS['jpush']['masterSecret']);
        
//         $client->push()
//                ->setPlatform('all')
// //                ->setPlatform('android')
//                ->addAlias('1')
// //                ->addTag(array('guansheng1', 'guansheng2', 'guansheng3'))
// //                ->addAllAudience()
// //                ->setNotificationAlert('你怎么回事？老弟')    //单条发送
// //                ->androidNotification(array('asd','dsa'))
//                 ->androidNotification('摘要'.time().'', array(    //多条安卓发送
//                     'title'      => '标题'.time().'',
// //                     'style'      => 1,   //通知栏样式
// //                     'builder_id' => 1,   //表示通知栏样式 ID
//                     ))
               
// //             ->message('message', array(
// //                 'title' => 'hellojpush',
// //                 // 'content_type' => 'text',
// // //                 'extras' => array(
// // //                     'key' => 'value',
// // //                     'jiguang'
// // //                 ),
// //             ))
//                ->send();
               
               try {
                   $client->push()
                   ->setPlatform('all')
//                    ->addAlias('1')
                   ->addAlias(array('1'))
                   ->iosNotification('123'.time(), array(    //多条IOS send
                       'title' => time(),
                       //                    'badge' => '+1',
                   ))
                   ->send();
               }catch (\JPush\Exceptions\JPushException $e) {
                   print $e;
               }
    }
    
    /**
     * 检验详情
     * inout :goods_id  invoice_id             goods_unit    room_id room_name  goods_num content  goods_price discount discountprice buyprice cid optid optname optdt del status
     * master:inout     pid         supplier   format                           num       explain  
     * 
     */
    function checkoutInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_purchase_caigou_mater');
        $m_sup   = spClass('m_supplier');
        $id      = (int) htmlentities($this->spArgs('id'));
        $results = $model->findAll(array('invoice_id' => $id, 'status' => 1));
        
//         $this->emptyNotice($results, '暂无数据');
        foreach ($results as $k => $v){
            $company = $m_sup->find(array('id' => $v['supplier']), '', 'company');  //supplier name
            $results[$k] = $this->keepField($v, 'id,name,format,num,checknum,packing,wgjc,formatparam,format,machine,aboutfile,internetrecord,checkstatus,finenum');
            $results[$k]['supplier'] = $company['company'];
            foreach ($results[$k] as $_k => $_v){
                if (empty($_v)) $results[$k][$_k] = '暂无';
                if ($results[$k]['checkstatus'] == '暂无' || empty($results[$k]['checkstatus']) || $results[$k]['checkstatus'] == 0){
                    $results[$k]['checkstatus'] = '不合格';
                }else {
                    $results[$k]['checkstatus'] = '合格';
                }
            }
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 采购单列表
     */
    function orderLst()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_orders');
        $st     = (int) htmlentities($this->spArgs('st'));
        $search = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $con    = 'a.cid='.$admin['cid'].' and b.comid='.$admin['cid'].' and a.del=0 and b.del=0';
        
        //where
        if (!empty($search)) $con .= ' and concat(a.buldcom,a.billnum,a.optname,a.optdt) like "%' . $search . '%"';
        
        //m_qualitylog表id的拆分重组
        $in_id  = spClass('m_qualitylog')->findAll(array('del' => 0, 'comid' => $admin['cid']), '', 'cid');
        $in_str = '(';
        foreach ($in_id as $k => $v){
            //$in_arr[]构造数组，为了已检验未检验的字符串标识
            $in_arr[] = $v['cid'];
            
            if (count($in_id) == ($k + 1)){
                $in_str .= $v['cid'].')';
                break;
            }
            $in_str .= $v['cid'].',';
        }
        if ($in_str == '(') $this->returnError('数据不存在');
        //1为全部、2为未检验、3为已检验
        if (empty($st) || $st == 1){
            $sql = 'select a.id,a.buldcom,a.billnum,a.optname,a.optdt from '.DB_NAME.'_purchase_caigou as a,'.DB_NAME.'_qualitylog as b where '.$con.' group by a.id';
        }elseif ($st == 2){
            $sql = 'select a.id,a.buldcom,a.billnum,a.optname,a.optdt from '.DB_NAME.'_purchase_caigou as a,'.DB_NAME.'_qualitylog as b where '.$con.' and a.id not in '.$in_str.' group by a.id';
        }elseif ($st == 3){
            $sql = 'select a.id,a.buldcom,a.billnum,a.optname,a.optdt from '.DB_NAME.'_purchase_caigou as a,'.DB_NAME.'_qualitylog as b where '.$con.' and a.id=b.cid group by a.id';
        }
        $results = $model->spPager($this->spArgs('page', 1), 15)->findSql($sql);
        $this->emptyNotice($results, '暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach ($results as $k => $v){
            $results[$k] = $this->setEmptyStr($v, '暂无');
            $results[$k]['sign'] = '未检验';
            if (in_array($v['id'], $in_arr)){
                $results[$k]['sign'] = '已检验';
            }else {
                $results[$k]['url'] = URL.'/app.php/keep/addCheckWebPage?id='.$v['id'].'';
            }
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * h5页面渲染
     */
    function addCheckWebPage()
    {
        $admin   = $this->islogin();
        $this->display('tpl/app/keep/addEditDyct.html', TRUE);
    }
    
    /**
     * 添加检验TO DO 需要优化
     */
    function saveCheckLog()
    {
        $admin  = $this->islogin();
        $list   = $this->spArgs('list');
        $id     = (int) htmlentities($this->spArgs('id'));
        
        $m_qualitylog            = spClass('m_qualitylog');
        $m_purchase_caigou_mater = spClass('m_purchase_caigou_mater');
        
        //checknum,paking,wgjc,format,machine,aboutfile,internetrecord,checkstatus,finenum
        foreach ($list as $k => $v){
            $now_id = $v['id'];
            $m_purchase_caigou_mater->update(array('id' => $v['id']), $v);
        }
        
        $this->returnSuccess('成功');
    }
    
    /**
     * 例行检查设备分类及其列表
     */
    function dyTypeLst()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_dyjy_para');
        foreach ($GLOBALS['DYCT_TYPE'] as $k => $v){
            if ($k == 4) continue;
            $pros[$k]['cate'] = $v;
            $pros[$k]['data'] = $model->findAll(array('type' => $k), 'id asc', 'id as mid,name,type');
            foreach ($pros[$k]['data'] as $_k => $_v){
                $pros[$k]['data'][$_k]['url'] = URL.'/app.php/keep/saveDyPage?mid='.$_v['mid'].'&type='.$_v['type'].'';
            }
            if (empty($pros[$k]['data'])) unset($pros[$k]['data']);
        }
        $result['results'] = array_values($pros);
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 单一流程卡列表
     */
    function xmProcessLst()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_dyjy_para');
        $results = $model
                   ->spPager($this->spArgs('page', 1), 10)
                   ->findAll(array('type' => 4), 'type asc,id asc', 'id as mid,name,type');
        
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach ($results as $k => $v){
            $results[$k]['url'] = URL.'/app.php/keep/saveDyPage?mid='.$v['mid'].'&type='.$v['type'].'';
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 例行检查-传参地址
     */
    function saveDyPage()
    {
        $admin   = $this->islogin();
        $id      = (int) htmlspecialchars($this->spArgs('mid'));
        $dy_data = spClass('m_dyjy_para')->find(array('id' => $id));
        $this->emptyNotice($dy_data, '数据不存在');
        $GLOBALS['results'] = array('mid' => $id, 'type' => $dy_data['type']);
        $this->display('tpl/app/keep/editDyctlog.html', TRUE);
//         $this->returnSuccess('成功', array('mid' => $id, 'type' => $dy_data['type']));
    }
    
    /**
     * 提醒消息列表 此处返回未读和已读所有数据
     * 在每个需要审核(即待办事项)和通知公告的地方添加新增todos表的接口
     * 此处添加接口列表
     */
    function noticeMsgLst()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_flow_todos');
        $con     = 'uid='.$admin['id'].'';
        //通知公告部门消息的设置
//         $infor = spClass('m_flow_todos')->findAll(array('type' => 2), '', 'id,tid');
//         foreach ($infor as $k => $v){
//             $in_todos = spClass('m_infor')->find(array('id' => $v['tid']), '', 'receid');
//             if (empty($in_todos) || $in_todos['receid'] == $admin['did']){
//                 $notice_id .= $v['id'].',';
//             }
//         }
// //         if (!empty($notice_id)) $notice_id = substr($notice_id, 0, -1);
        
//         //其他审核待办事项
//         $check = spClass('m_flow_todos')->findAll(array('type' => 1), 'id desc', 'id,tid,`table`');
//         foreach ($check as $_k => $_v){
//             $in_check = spClass('m_flow_bill')->find('tid='.$_v['tid'].' and `table` like "%'.$_v['table'].'%"');
//             if (!empty($in_check['nowcheckid'])){
//                 $arr_id = explode(',', $in_check['nowcheckid']);
//                 $arr_id = array_filter($arr_id);
//                 if (in_array($admin['id'], $arr_id)){
//                     $notice_id .= $_v['id'].',';
//                 }
//             }
//         }
//         if (!empty($notice_id)) $notice_id = substr($notice_id, 0, -1);
//         if (empty($notice_id)) $this->returnError('无数据');
        
//         $sql = 'select id,adddt,modelname,title from '.DB_NAME.'_flow_todos where id in ('.$notice_id.') order by adddt desc';
//         $results = $model->spPager($this->spArgs('page', 1), 15)->findSql($sql);
        $results = $model->spPager($this->spArgs('page', 1), 15)->findAll($con, 'adddt desc', 'id,adddt,modelname,title');    //未读排在最开始、然后按时间排序
        $this->emptyNotice($results, '暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        //未读置一
        $model->update(array('uid' => $admin['id']), array('isread' => 1));
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 单条详细提醒信息，如果访问此接口则isread置1表示已读
     */
    function noticeMsgInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_flow_todos');
        $id      = (int) htmlspecialchars($this->spArgs('id'));
        $results = $model->find('id='.$id.'', '', 'id,adddt,title,isread');
        //isread detail
        if ($results['isread'] == 0){
            $up = $model->update(array('id' => $id), array('isread' => 1, 'readdt' => date('Y-m-d H:i:s')));
            if (!$up) $this->returnError('网络错误,请稍后重试'); 
        }
        
        $this->returnSuccess('成功', $results);
    }
    
    /**
     * 设备例行检查新增
     */
    function routineCheck()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_dyjy');
        $m_param         = spClass('m_dyjy_para');
        $data['oid']     = (int) htmlspecialchars($this->spArgs('oid'));
        $data['mid']     = (int) htmlspecialchars($this->spArgs('mid'));
        
        $data['title']   = htmlspecialchars($this->spArgs('title'));    //文件名称，表顶上的名称数据
        $data['number']  = htmlspecialchars($this->spArgs('number'));   //文件编号
        $data['name']    = htmlspecialchars($this->spArgs('name'));     //产品名称
        $data['format']  = htmlspecialchars($this->spArgs('format'));   //规格型号
        $data['num']     = htmlspecialchars($this->spArgs('num'));      //检验数量
        $data['dt']      = htmlspecialchars($this->spArgs('dt'));       //检验日期
        $data['pnumber'] = htmlspecialchars($this->spArgs('pnumber'));  //产品编号
        $data['sign']    = htmlspecialchars($this->spArgs('sign'));     //检验员
        $data['prodt']   = htmlspecialchars($this->spArgs('prodt'));    //生产日期
        
        $id              = (int) htmlentities($this->spArgs('id'));
        
        //para表数据
        $p_data['type']  = htmlspecialchars($this->spArgs('protype'));
//         $p_data['name']  = htmlspecialchars($this->spArgs('proname'));
        $p_data['name']  = $data['name'];
        
        //check params
        $this->emptyNotice($data['pnumber'], '请填写产品编号');
        $this->emptyNotice($data['name'], '请填写产品名称');
        $this->emptyNotice($data['sign'], '请上传签名');
        
        //数据处理
        foreach ($_POST as $k => $v){
            if (strpos($k, 'q') === 0){
                $q[$k] = $v;
            }elseif (strpos($k, 'w') === 0){
                $w[$k] = $v;
            }elseif (strpos($k, 'e') === 0){
                $e[$k] = $v;
            }elseif (strpos($k, 'r') === 0){
                $r[$k] = $v;
            }
        }
        
        $data['jilu']        = json_encode($q);
        $data['jielun']      = json_encode($w);
        $data['info']        = json_encode($e);
        $p_data['parameter'] = json_decode($r);
        
        //一产品参数对多个检查记录
        if ($id){
            $p_re = $m_param->find(array('id' => $id));
            $this->emptyNotice($p_re, '数据不存在');
            
            $p_data = $this->checkUpdateArr($p_re, $p_data);
            $p_up   = $m_param->update(array('id' => $id), $p_data);
            //TO DO 确认是几对几的关系再更新数据 一对一
            if ($p_up){
                $re = $model->find(array('id' => $id));
                $this->emptyNotice($re, '数据不存在');
                
                $data = $this->checkUpdateArr($re, $data);
                $up   = $model->update(array('id' => $id), $data);
            }
        }else {
            $p_up = $m_param->create($p_data);
            if ($p_up){
                //检查表新增
                $data['optid']   = $admin['id'];
                $data['optname'] = $admin['name'];
                $data['optdt']   = date('Y-m-d H:i:s');
                $data['status']  = 1;
                $data['cid']     = $admin['cid'];
                $up = $model->create($data);
            }else {
                $this->returnError('新增检查出错');
            }
        }
        
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 维修单管理 记录条数 待处理 TO DO 权限判断和处理
     */
    function serviceCount()
    {
        //省略index.php $control = $this->spArgs('c');
        if (empty($control)) $control = $this->c;
        if (empty($way)) $way = $this->a;
        
        $m_admin = spClass("m_admin");
        $m_auth  = spClass('m_auth');
        $m_role  = spClass('m_role');
        $data['control'] = $control;
        $data['way']     = $way;
        $thisauth        = $m_auth->find($data);   //auth鉴权
        //token验证，然后thisauth鉴权
        $token = htmlentities($this->spArgs('token'));
        //已登陆
        $user = $m_admin->find('login = "' . $token . '"');
        
        if (empty($user)) $this->returnError('用户不存在');
        
        if ($user) {
            if ($user['id'] == 1) {
                $admin = $user;
            } else {
                $role = json_decode($user['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    //当前权限判断
                    if ($re_role) {
                        $pro = json_decode($re_role['promission']);
                        if (in_array($thisauth['id'], $pro)) {
                            $admin = $user;
                        } else {
                            $admin = $user;
                            $user_roll = 1;    //权限判断
                        }
                    }
                }
            }
        }
        
        $con    = 'del=0';
        $number = htmlentities($this->spArgs('number'));
        $model  = spClass('m_equipment_service');
        $m_todo = spClass('m_flow_todos');
        if ($user_roll == 1) $con .= ' and workid='.$admin['id'].'';    //对于没有全部查看人的权限判定
        
        $sql    = 'select count(*) from '.DB_NAME.'_equipment_service where '.$con.' and status=1';
        $count  = $model->findSql($sql);
        $result['count'] = $count[0]['count(*)'];
        //待办事项是否有红点的统计
        $todos      = $m_todo->findAll('uid='.$admin['id'].' and isread=0');
        $todo_count = 0;
        if (!empty($todos)) $todo_count = 1;
        $result['todo_status'] = $todo_count;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 设备维修详情
     */
    function serviceHandleInfo()
    {
        $admin     = $this->islogin();
        $model     = spClass('m_equipment');
        $m_service = spClass('m_equipment_service');
        
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        $this->emptyNotice($result, '数据不存在或已删除');
        $result = $this->keepField($result, 'id,number,custname,custphone,name,address,optdt,day,explain');
        
        $edit = $keep = 0;
        
        $up1 = $model->update(array('id' => $id), array('see' => 1));
        
        $service = $m_service->findAll('eid = ' . $id);
        if (!empty($service)) {
            foreach ($service as $k => $v){
                $service[$k] = $this->keepField($v, 'id,workid,workname,handletime,explain');
                if ($v['type'] == '维修'){
                    $edit ++;
                }else {
                    $keep ++;
                }
            }
            $result['service'] = $service;
        }
        //维修保养频率数据
//         $result['type']['repair'][] = '维修';
        $result['repair'] = $edit;    //维修
//         $result['type']['keep'][]   = '保养';
        $result['keep']   = $keep;    //保养
        
        $this->returnSuccess('成功', $result);
    }
    
    function saveEquipment() {
        $admin = $this->islogin();
        $args = array(
            'number'  => '设备编号',
            'custid'  => '客户',
            'name'    => '设备名称',
            'format'  => '规格型号',
            'day'     => '',
            'address' => '',
            'explain' => '',
            'id'      => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $model = spClass('m_equipment');
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        if (empty($id)) {
            $data['cid'] = $admin['cid'];
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            if (empty($cust)) {
                $this->returnError('请选择客户');
            }
            $data['custname'] = $cust['name'];
            $data['custphone'] = $cust['phone'];
            $ad = $model->create($data);
            if ($ad) {
                $this->returnSuccess('添加成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            if (empty($re)) {
                $this->returnError('数据有误，修改失败');
            }
            $cust = spClass('m_custmang')->find(array('cid' => $admin['cid'], 'id' => $data['custid']));
            if (empty($cust)) {
                $this->returnError('请选择客户');
            }
            $data['custname'] = $cust['name'];
            $data['custphone'] = $cust['phone'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) {
                $this->returnSuccess('修改成功');
            } else {
                $this->returnError('网络错误，请稍后重试');
            }
        }
    }

//    
//     function saveService(){
//        $admin = $this->islogin();
//        $args = array(
//            'number' => '设备编号',
//            'type' => '服务类型',
//            'explain' => '',
//            'id' => '',
//        );
//        $data = $this->receiveData($args);
//        $id = $data['id'];
//        unset($data['id']);
//        $m_equipment = spClass('m_equipment');
//        $model = spClass('m_equipment_service');
//        $data['optid'] = $admin['id'];
//        $data['optname'] = $admin['name'];
//        $data['optdt'] = date('Y-m-d H:i:s');
//        if(empty($id)){
//            $equipment = $m_equipment->find(array('number'=>$data['number'],'cid'=>$admin['cid']));
//            if(empty($equipment)){
//                $this->returnError('设备不存在，请检查设备编号是否正确');
//            }
//            $ad = $model->create($data);
//            if($ad){
//                $this->returnSuccess('添加成功');
//            }else{
//                $this->returnError('网络错误，请稍后重试');
//            }
//        }else{
//            $re = $model->find(array('cid'=>$admin['cid'],'id'=>$id));
//            if(empty($re)){
//                $this->returnError('数据有误，修改失败');
//            }
//            $equipment = $m_equipment->find(array('number'=>$data['number'],'cid'=>$admin['cid']));
//            if(empty($equipment)){
//                $this->returnError('设备不存在，请检查设备编号是否正确');
//            }
//            $up = $model->update(array('id'=>$id),$data);
//            if($up){
//                $this->returnSuccess('修改成功');
//            }else{
//                $this->returnError('网络错误，请稍后重试');
//            }
//        }
//    }

    function saveService() {
        $admin = $this->islogin();
        $args = array(
            'number'  => '设备编号',
            'type'    => '',
            'explain' => '',
            'id'      => '',
            'workid'  => '',
            'workname'=> '',
//             'eid'     => '',
        );
        $data = $this->receiveData($args);
        $id = $data['id'];
        unset($data['id']);
        $m_equipment     = spClass('m_equipment');
        $model           = spClass('m_equipment_service');
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt']   = date('Y-m-d H:i:s');
        if (empty($id)) {
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) $this->returnError('设备不存在，请检查设备编号是否正确');
            //设备id=eid
            $data['eid'] = $equipment['id'];
            $ad = $model->create($data);
            if ($ad) $this->returnSuccess('添加成功');
            $this->returnError('网络错误，请稍后重试');
        } else {
            $re = $model->find(array('cid' => $admin['cid'], 'id' => $id));
            if (empty($re)) $this->returnError('数据有误，修改失败');
            $equipment = $m_equipment->find(array('number' => $data['number'], 'cid' => $admin['cid']));
            if (empty($equipment)) $this->returnError('设备不存在，请检查设备编号是否正确');
            
            $data['eid'] = $equipment['id'];
            $up = $model->update(array('id' => $id), $data);
            if ($up) $this->returnSuccess('修改成功');
            $this->returnError('网络错误，请稍后重试');
        }
    }

    function findEquipment() {
        $admin = $this->islogin();
        $number = htmlentities($this->spArgs('number'));
        $m_equipment = spClass('m_equipment');
        $equipment = $m_equipment->find(array('number' => $number, 'cid' => $admin['cid']), '', 'id,number,custname,custphone,name,format,day,address');
        if (empty($equipment)) {
            $this->returnError('设备信息不存在');
        }
        $this->returnSuccess('成功', $equipment);
    }

    function myCust() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = ' . $admin['cid'] . ' and saleid = ' . $admin['id'];
        if($name){
            $con .= ' and cust_name like "%'.$name.'%"';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc', 'id,cust_name,phone');
        if (empty($results)) {
            $this->returnError('暂无数据');
        }
        foreach ($results as $k => $v) {
            $results[$k]['name'] = $v['cust_name'];
            $results[$k] = $this->setEmptyStr($results[$k], '暂无');
        }
//         dump($results);die;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    

    /**
     * update/add cust mang
     * 更新/添加用户管理
     */
    function saveCust() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $arg = array(
            'id' => '',
            'sex' => '性别',
            'age' => '年龄',
            'cust_name' => '客户姓名',
            'custcname' => '客户公司',
            'phone' => '客户手机', //客户手机，不能为空
            'address' => '',
            'info' => '',
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
            $data['status'] = 1;
            $data['applyid'] = $admin['id'];
            $data['saleid'] = $admin['id'];
            $data['applyname'] = $admin['name'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $data['cid'] = $admin['cid'];
            $data['flowid'] = 1;
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    function custInfo() {
        $admin = $this->islogin();
        $model = spClass('m_custmang');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) $this->returnError('暂无数据');
        $result = $this->setEmptyStr($result, '暂无');
        $this->returnSuccess('成功', $result);
    }

    /**
     * 该用户的设备
     */
    function custEquipment() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $id = htmlentities($this->spArgs('id'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and custid = ' . $id . ' and cid = ' . $admin['cid'];
        if($name){
            $con .= ' and number like "%'.$name.'%"';
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,name,number,address');
        if (empty($results)) {
            $this->returnError('暂无数据');
        }
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }

    function equipmentInfo() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        $id = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) {
            $this->returnError('数据不存在或已删除');
        }
        $service = $m_equipment_service->findAll('eid = ' . $id);
        if (!empty($service)) {
            $result['service'] = $service;
        }
        $this->returnSuccess('成功', $result);
    }

    function service() {
        $admin = $this->islogin();
        $model = spClass('m_equipment');
        $m_equipment_service = spClass('m_equipment_service');
        
    }
    
    /**
     * -----------------------------维修管理模块---------------------------------------
     */
    
    
    /**
     * 我的定位考勤列表
     */
    function localLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_kqdkjl');
        $id    = $admin['id'];
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'uid = ' . $id . ' and cid = ' . $admin['cid'];
        if($name) $con .= ' and address like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc', 'id,optdt,address,`explain`');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 费用报销管理
     */
    function payMonLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status     = urldecode(htmlspecialchars($this->spArgs('status')));
        $model      = spClass('m_expend');
        $m_user     = spClass('m_admin');
        $m_cate     = spClass('m_paycate');
        $m_bill     = spClass('m_flow_bill');
        
        //where
        $con    = 'del = 0 and cid = ' . $admin['cid'].'';
        if (!empty($searchname)) $con .= ' and concat(paymoney,adddt) like "%' . $searchname . '%"';
        if (!empty($status)){
//             if ($status != 3){
//                 $con .= ' and status<>3';
//             }else {
//                 $con .= ' and status='.$status.'';
//             }
            $con .= ' and status='.$status.'';  //在审核流程后的重构
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            //查看是否有审核人
            $bill_data = $m_bill->find('`table` like "%expend%" and tid='.$v['id'].' and del=0');
            if (!empty($bill_data['nowcheckid'])){
                $check_id = array_filter(explode(',', $bill_data['nowcheckid']));
            }
            
            $str_status = '未报销';
            if ($v['status'] == 3){
                $str_status = '已报销';
            }elseif ($v['status'] == 2){
                $str_status = '驳回';
            }
            $pay_cate = $m_cate->find('id='.$v['cateid'].'', '', 'catename');   //报销类别
            
            $result['results'][$k] = array(
                'id'        => $v['id'],
                'username'  => $v['salename'],
                'paymoney'  => $v['paymoney'],
                'adddt'     => $v['adddt'],
                'catename'  => $pay_cate['catename'],
                'content'   => $v['content'],
                'status'    => $str_status,    //文档申明判断报销状态：不为3的都是未报销
                'roll'      => in_array($admin['id'], $check_id) ? 1 : 0,
            );
            $check_id = '';
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 费用报销详情
     */
    function payMonInfo()
    {
//         $admin   = $this->islogin();
//         $model   = spClass('m_custpay_mon');
//         $id      = htmlentities($this->spArgs('id'));
//         $result  = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0, 'monstatus' => 3));
//         if (empty($result)) $this->returnError('数据不存在或已删除');
           
//         $paycate             = spClass('m_paycate')->find('id='.$result['cateid'].' and del=0 and cid='.$admin['cid'].'');
//         $results             = array();
//         $results['id']       = $result['id'];
//         $results['username'] = $result['salename'];
//         $results['adddt']    = $result['adddt'];
//         $results['catename'] = $paycate['catename'];
//         $results['paymoney'] = $result['paymoney'];
//         $results['status']   = $result['status'];
//         $results['content']  = $result['content'];
//         if ($results['status'] == 3){
//             $results['status'] = '已报销';
//         }else {
//             $results['status'] = '未报销';
//         }
//         $this->returnSuccess('成功', $results);
        
        $admin = $this->islogin();
        $mid = (int) htmlentities($this->spArgs('mid'));
        $id  = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 51);
    }
    
    /**
     * 分配人员 列表
     * 职位名称
     */
    function allotUser()
    {
        $admin = $this->islogin();
        $model = spClass('m_admin');
        $id    = $admin['id'];
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del=0 and cid = ' . $admin['cid'];
        if($name) $con .= ' and name like "%'.$name.'%"';    //where like
        
        $results = $model->findAll($con, 'id asc', 'id,name,pname');
        foreach ($results as $k => $v){
            $results[$k] = $this->setEmptyStr($results[$k], '暂无');
        }
        if (empty($results)) $this->returnError('暂无数据');
        
        $result['results'] = array_values($results);
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 所有设备管理 列表(无状态，app图需要修改) TODO
     */
    function equipmentMang()
    {
        //省略index.php $control = $this->spArgs('c');
        if (empty($control)) $control = $this->c;
        if (empty($way)) $way = $this->a;
        
        $m_admin = spClass("m_admin");
        $m_auth  = spClass('m_auth');
        $m_role  = spClass('m_role');
        $data['control'] = $control;
        $data['way']     = $way;
        $thisauth        = $m_auth->find($data);   //auth鉴权
        //token验证，然后thisauth鉴权
        $token = htmlentities($this->spArgs('token'));
        //已登陆
        $user = $m_admin->find('login = "' . $token . '" and del=0 and status=1');
        
        if (empty($user)) $this->returnError('用户不存在');
        
        if ($user) {
            if ($user['id'] == 1) {
                $admin = $user;
            } else {
                $role = json_decode($user['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    //当前权限判断
                    if ($re_role) {
                        $pro = json_decode($re_role['promission']);
                        if (in_array($thisauth['id'], $pro)) {
                            $admin = $user;
                        } else {
                            $admin = $user;
                            $user_roll = 1;    //权限判断
                        }
                    }
                }
            }
        }
        
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $model      = spClass('m_equipment');
        $m_cust     = spClass('m_custmang');
        
        //where
        $con    = 'del = 0 and cid = ' . $admin['cid'].'';
        if (!empty($searchname)) $con .= ' and concat(custname,name,number,address) like "%' . $searchname . '%"';
        
        if ($user_roll == 1){   //对于没有全部查看人的权限判定
            $cust_data = $m_cust->findAll('saleid='.$admin['id'].' and del=0 and cid='.$admin['cid'].'', '', 'id');
            foreach ($cust_data as $k => $v){
                $id_str .= $v['id'].',';
            }
            $id_str = substr($id_str, 0, -1);
            $con .= ' and custid in ('.$id_str.')';
            
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $v['custname'],
                'name'     => $v['name'],
                'number'   => $v['number'],
                'address'  => $v['address'],
                'see'      => $v['see'],    //0、未查看；1、已查看
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 设备详情 not TODO
     */
    function equipmentAllInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_equipment');
        $id      = htmlentities($this->spArgs('id'));
        $results = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($results)) $this->returnError('数据不存在或已删除');
        
        $log = array();
        $service = spClass('m_equipment_service')->findAll('eid='.$id.' and del=0');
        foreach ($service as $k => $v){
            $log = spClass('m_equipment_service_log')->findAll('esid='.$v['id'].' and del=0');
        }
        //查看置1
        $up = $model->update(array('id' => $id), array('see' => 1));
        if (!$up) $this->returnError('网络错误');
        
        //做冗余字段的清除
        $keep_data    = $this->keepField($results, 'id,number,custname,custphone,name,address,optdt,day,explain');
        foreach ($service as $_k => $_v){
            $_v['status'] = '待处理';
            if ($_v['status'] == 2) $_v['status'] = '保养中';
            $service_data[] = $this->keepField($_v, 'id,type,status,workname,explain,optdt');
        }
        
        foreach ($log as $__k => $__v){
            $log_data[]     = $this->keepField($__v, 'id,optname,optdt,explain,st');
        }
        
        if ($keep_data['day'] < 15) $keep_data['day'] = '一周';
        if ($keep_data['day'] > 15 && $keep_data['day'] < 32) $keep_data['day'] = '一月';
        if ($keep_data['day'] > 32 && $keep_data['day'] < 300) $keep_data['day'] = '半年';
        if ($keep_data['day'] > 300 && $keep_data['day'] < 367) $keep_data['day'] = '一年';
        if ($keep_data['day'] > 365 && $keep_data['day'] < 732) $keep_data['day'] = '两年';
        if ($keep_data['day'] > 732 && $keep_data['day'] < 1097) $keep_data['day'] = '三年';
        
        $result['results'] = $keep_data;       //设备单
        $result['service'] = $service_data;    //维修单
        $result['log']     = $log_data;        //维修记录
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单选择：我的维修单
     */
//     function myServiceMangLst()
//     {
//         $admin  = $this->islogin();
//         $workid = $admin['id'];
//         $this->commonServiceLst($workid);
//     }
    
    /**
     * 维修单管理
     * 所有列表status=未处理； status=2 已处理；
     * 即未处理为status=0，待处理为红点
     */
    function serviceMangLst()
    {
        $admin  = $this->islogin();
        $this->commonServiceLst();
    }
    
    function commonServiceLst($workid = '')
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status     = urldecode(htmlspecialchars($this->spArgs('status')));
        $model      = spClass('m_equipment_service');
        $m_equip    = spClass('m_equipment');
        
        //where
        $con    = 'del=0';
        if (!empty($searchname)) $con .= ' and concat(workname,`explain`) like "%' . $searchname . '%"';
        if (!empty($status)) $con .= ' and status='.$status.'';
        //我的列表check
        if (!empty($workid)) $con .= ' and workid='.$workid.'';
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $equip = $m_equip->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'');
            
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $equip['custname'],
                'name'     => $equip['name'],
                'number'   => $equip['number'],
                'status'   => (int)$v['status'], //app端判断类型来选择红点
                'address'  => $equip['address'],
                'see'      => $equip['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单管理
     */
    function myServiceMangLst()
    {
        //省略index.php $control = $this->spArgs('c');
        if (empty($control)) $control = $this->c;
        if (empty($way)) $way = $this->a;
        
        $m_admin = spClass("m_admin");
        $m_auth  = spClass('m_auth');
        $m_role  = spClass('m_role');
        $data['control'] = $control;
        $data['way']     = $way;
        $thisauth        = $m_auth->find($data);   //auth鉴权
        //token验证，然后thisauth鉴权
        $token = htmlentities($this->spArgs('token'));
        //已登陆
        $user = $m_admin->find('login = "' . $token . '" and del=0 and status=1');
        
        if (empty($user)) $this->returnError('用户不存在');
        
        if ($user) {
            if ($user['id'] == 1) {
                $admin = $user;
            } else {
                $role = json_decode($user['role'], true);
                foreach ($role as $k => $v) {
                    $re_role = $m_role->find("id = " . $v, '', 'promission');
                    //当前权限判断
                    if ($re_role) {
                        $pro = json_decode($re_role['promission']);
                        if (in_array($thisauth['id'], $pro)) {
                            $admin = $user;
                        } else {
                            $admin = $user;
                            $user_roll = 1;    //权限判断
                        }
                    }
                }
            }
        }
        
//         $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
        $status     = urldecode(htmlspecialchars($this->spArgs('status')));
        $model      = spClass('m_equipment_service');
        $m_equip    = spClass('m_equipment');
        
        //where
        $con    = 'del=0';
        if (!empty($searchname)) $con .= ' and concat(workname,`explain`) like "%' . $searchname . '%"';
        if (!empty($status)) $con .= ' and status='.$status.'';
        if ($user_roll == 1) $con .= ' and workid='.$admin['id'].'';    //对于没有全部查看人的权限判定
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $equip = $m_equip->find('id='.$v['eid'].' and del=0 and cid='.$admin['cid'].'');
            $result['results'][$k] = array(
                'id'       => $v['id'],
                'custname' => $equip['custname'],
                'name'     => $equip['name'],
                'number'   => $equip['number'],
                'status'   => (int)$v['status'],
                'address'  => $equip['address'],
                'see'      => $v['see'],
            );
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单详情
     */
    function serviceInfo()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_equipment_service');
        $m_equip = spClass('m_equipment');
        $m_log   = spClass('m_equipment_service_log');
        $id      = htmlentities($this->spArgs('id'));
        $m_file  = spClass('m_file');
        
        if (!is_numeric($id) || empty($id)) $this->returnError('数据非法');
        $results = $model->find(array('id' => $id, 'del' => 0), '', 'eid,workid,status');
        if (empty($results)) $this->returnError('数据不存在或已删除');
        $equip   = $m_equip->find(array('id' => $results['eid'], 'del' => 0, 'cid' => $admin['cid']));
        $equip   = $this->keepField($equip, 'custname,custphone,name,number,address,optdt,explain');
        
        $result  = $equip;
        $result['status'] = $results['status'];
        //分配人员状态check
        $result['allotid'] = 0;
//         if (!empty($results['workid'])){
//             $result['allotid'] = 1;
//             //维修记录列表
//             $log_data = $m_log->findAll('esid='.$id.' and del=0');
//             if (!empty($log_data)) {
//                 foreach ($log_data as $__k => $__v){
//                     $log_data[$__k] = $this->keepField($log_data[$__k], 'optdt,optname,explain,files'); //提取字段
                    
// //                     if (!empty($__v['files'])){
// //                         $files  = $m_file->findAll('id in (' . $__v['files'] . ')', '', 'id,filename,filepath');
// //                         foreach ($files as $fk => $fv){
// //                             $files[$fk]['filepath'] = URL.$fv['filepath'];
// //                         }
// //                         $log_data[$__k]['files'] = array_values($files);
// //                     }else {
// //                         unset($log_data[$__k]['files']);
// //                     }
//                     if (!empty($__v['files'])){
//                         $log_data[$__k]['files'] = explode(',', $__v['files']);
//                     }else {
//                         unset($log_data[$__k]['files']);
//                     }
//                 }
                
//                 $result['log'] = $log_data;
//             }
//         }
        if (!empty($results['workid'])){
            $result['allotid'] = 1;
            //维修记录列表
            $log_data = $m_log->findAll('esid='.$id.' and del=0');
            $result['log'] = $log_data;
        }
        if (empty($result['log'])) unset($result['log']);
        //TODO 当workid=我自时，才能显示下方处理弹框
        //查看
        $see_status = $model->update(array('id' => $id, 'del' => 0), array('see' => 1));
        $this->emptyNotice($see_status, '网络错误');
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 维修单详情(只是分配)-处理
     * 当为分配人员status=0，分配人员后status=1，在点击已完成后status=2
     */
    function serviceHandle()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_equipment_service');
        $args    = array(
            'type'    => '',
            'explain' => '',
            'id'      => '维修单id',
            'workid'  => '',
            'handletime' => '',
        );
        $data = $this->receiveData($args);
        $work_info = spClass('m_admin')->find('id='.$data['workid'].' and del=0 and cid='.$admin['cid'].'', '', 'name');
        $this->emptyNotice($work_info, '该人员不存在');
        $data['workname'] = $work_info['name'];
        //分配人员后为status=1
        $data['status'] = 1;
        
        //check&更新
        $re   = $model->find(array('id' => $data['id']));
        $this->emptyNotice($re, '该维修单不存在');
        $data = $this->checkUpdateArr($re, $data);
        $up   = $model->update(array('id' => $data['id']), $data);
        if ($up){
//             $re2 = $model->update(array('id' => $data['id']), array('status' => 2));
//             $this->emptyNotice($re2, '失败');
            $this->returnSuccess('成功');
        }
        $this->returnError('失败');
    }
    
    
    
    /**
     * /**维修单处理 not/
     * 进程上报
     */
    function saveServiceDetail()
    {
        $admin      = $this->islogin();
        $m_service  = spClass('m_equipment_service');
        $model      = spClass('m_equipment_service_log');
        $args = array(
            'esid'    => '维修单',
            'explain' => '',
            'status'  => '',
            'optdt'   => '',
            'files'   => '',    //图片文件
        );
        $data = $this->receiveData($args);
        
        $data['optid']   = $admin['id'];
        $data['optname'] = $admin['name'];
        if (empty($data['optdt'])) $data['optdt'] = date('Y-m-d H:i:s');
        
        $this->checkService($data['esid']);  //检查是否存在于checkService
        $ad = $model->create($data);
        $m_service->update(array('id' => $data['esid'], 'del' => 0), array('status' => $data['status']));   //维修单status的处理
        if ($ad) $this->returnSuccess('处理成功');
        $this->returnError('网络错误，请稍后重试');
    }
    
    /**
     * 维修日志管理 已处理：st=已处理 未处理：st=未处理
     */
//     function serviceDetailMang()
//     {
//         $admin      = $this->islogin();
//         $searchname = urldecode(htmlspecialchars($this->spArgs('name')));
//         $status     = urldecode(htmlspecialchars($this->spArgs('status')));
//         $m_log      = spClass('m_equipment_service_log');
//         $m_service  = spClass('m_equipment_service');
//         $m_equip    = spClass('m_equipment');
        
//         //where
//         $con    = 'del = 0';
//         if (!empty($searchname)) $con .= ' and explain like "%' . $searchname . '%"';
//         if (!empty($status)) $con .= ' and st='.$status.'';
        
//         $results = $m_log->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
//         if (empty($results)) $this->returnError('暂无数据');
        
//         $pager = $m_log->spPager()->getPager();
//         $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
//         $result['page'] = $page;
        
//         foreach($results as $k=>$v){
//             $service = $m_service->find('id='.$v['esid'].' and del=0', '', 'eid');
//             $equip   = $m_equip->find('id='.$service['eid'].' and del=0 and cid='.$admin['cid'].'');
            
//             $result['results'][$k] = array(
//                 'id'       => $v['id'],   //设备维修报告id,从列表进入详情
//                 'custname' => $equip['custname'],
//                 'name'     => $equip['name'],
//                 'number'   => $equip['number'],
//                 'address'  => $equip['address'],
//             );
//         }
//         $this->returnSuccess('成功', $result);
//     }
    
//     /**
//      * 维修单进程详情+处理：处理后st=处理,未处理st=未处理 TODO
//      */
//     function serviceDetailInfo()
//     {
//         $admin   = $this->islogin();
//         $model   = spClass('m_equipment_service_log');
//         $id      = htmlentities($this->spArgs('id'));
//         $results = $model->find(array('id' => $id, 'del' => 0));
//         if (empty($results)) $this->returnError('数据不存在或已删除');
        
//         $equip = array();
//         $service = $model->findAll('eid='.$id.' and del=0');
//         foreach ($service as $k => $v){
//             $log = spClass('m_equipment_service_log')->findAll('esid='.$v['id'].' and del=0');
//         }
        

        
//         $result['results'] = $results;  //设备单
//         $result['service'] = $service;  //维修单
//         $result['log']     = $log;      //维修记录
        
//         $this->returnSuccess('成功', $result);
//     }
    
    
    /**
     * 进程上报：添加/修改详细信息或者上传图片上报信信息，可写在维修单处理方法中
     */
    
    /**
     *  现场知识库新增
     */
    function saveLiveCon()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $arg   = array(
            'live_title' => '标题',
            'live_desc'  => '',
            'live_adddt' => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re)) $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['cid']     = $admin['cid'];
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 现场知识库列表
     */
    function liveConLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        if($name) $con .= ' and title like "%'.$name.'%"';    //where like
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'optdt desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 现场知识库详情
     */
    function liveConInfo()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_livecon');
        $id     = htmlentities($this->spArgs('id'));
        $result = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
        if (empty($result)) $this->returnError('暂无数据');
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 知识库分类新增
     */
    function saveLiveCate()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon_cate');
        $arg   = array(
            'catename' => '标题',
            'catedesc'  => '',
        );
        $data = $this->receiveData($arg);
        $id = (int) $data['id'];
        unset($data['id']);
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '', 'id');
            if (empty($re)) $this->returnError('信息有误', 1);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $data['cid']     = $admin['cid'];
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 知识库分类列表
     */
    function liveCateLst()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_livecon_cate');
        $m_live = spClass('m_livecon');
        $name   = urldecode(htmlspecialchars($this->spArgs('name')));
        if($name) $con .= ' and catename like "%'.$name.'%"';    //where like
        
        $results = $model->findAll($con, 'optdt desc', 'id,catename');
        if (empty($results)) $this->returnError('暂无数据');
        foreach ($results as $k => $v){
            $see_data = $m_live->findAll('cateid='.$v['id'].' and del=0 and cid='.$admin['cid'].' and see=0');  //查询未查看的文章
            if (empty($see_data)){
                $results[$k]['see'] = 1;
            }else {
                $results[$k]['see'] = 0;
            }
        }
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 分类列表下的所有文章
     */
    function cateAllLst()
    {
        $admin = $this->islogin();
        $model = spClass('m_livecon');
        $name  = urldecode(htmlspecialchars($this->spArgs('name')));
        $id    = htmlspecialchars($this->spArgs('id'));
        
        if($name) $con .= ' and live_title like "%'.$name.'%"';    //where like
        $this->emptyNotice($id, '知识库不存在');
        $con .= 'cateid='.$id.' and del=0 and cid='.$admin['cid'].'';
        
        $results = $model->findAll($con, 'optdt desc', 'id,live_title');
        $this->emptyNotice($results, '暂无数据');
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 所有分类及其文章
     */
    function liveConLstAll()
    {
        $admin  = $this->islogin();
        $model  = spClass('m_livecon');
        $m_cate = spClass('m_livecon_cate');
        $con   .= 'del=0 and cid='.$admin['cid'].'';
        $name   = urldecode(htmlspecialchars($this->spArgs('name')));
        $id     = htmlspecialchars($this->spArgs('id'));
        
        if($name) $con .= ' and catename like "%'.$name.'%"';    //where like
        $results = $m_cate->findAll($con, 'optdt desc', 'id,catename');
        $this->emptyNotice($results, '暂无数据');
        foreach ($results as $k => $v){
            $results[$k]['article'] = $model->findAll('cateid='.$v['id'].' and del=0 and cid='.$admin['cid'].'');
            if (empty($results[$k]['article'])){
                unset($results[$k]['article']);
                continue;
            }
            foreach ($results[$k]['article'] as $_k => $_v){
                $results[$k]['article'][$_k]['url'] = URL.'/app.php/keep/liveWebPage?id='.$_v['id'].'';
            }
        }
        
        $result['cate'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * h5页面渲染
     */
    function liveWebPage()
    {
        $admin   = $this->islogin();
        $this->display('tpl/app/keep/liveConItem.html', TRUE);
    }
    
    
    /**
     * 用款类型列表
     */
    function paycate()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $searchname  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_paycate');
        if (!empty($searchname)) {
            $con .= ' and concat(catename,catedesc) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        if (empty($results)) $this->returnError('暂无数据');
        
        $pager = $model->spPager()->getPager();
        $page  = $pager['current_page'] >= $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 添加订单
     */
//     function saveOrders(){
//         $admin = $this->islogin();
//         $model = spClass('m_orders');
//         $data['name'] = htmlspecialchars($this->spArgs('name'));
//         $data['cname'] = htmlspecialchars($this->spArgs('cname'));
//         $data['cid'] = htmlspecialchars($this->spArgs('cid'));
//         $data['uname'] = htmlspecialchars($this->spArgs('uname'));
//         $data['uid'] = htmlspecialchars($this->spArgs('uid'));
//         $data['phone'] = htmlspecialchars($this->spArgs('phone'));
//         $data['address'] = htmlspecialchars($this->spArgs('address'));
//         $data['explain'] = htmlspecialchars($this->spArgs('explain'));
//         $files = $this->spArgs('files');
//         if($files){
//             $data['files'] = implode(',', $files);
//         }
//         if(empty($data['name'])){
//             $this->msg_json(0, '请填写订单名称');
//         }
//         if(empty($data['cid'])){
//             $this->msg_json(0, '请选择客户');
//         }
//         if(empty($data['uid'])){
//             $this->msg_json(0, '请选择业务员');
//         }
//         $sum = $model->findCount('number like "%'.date('Ymd').'%"');
//         $sum = $sum<9?'0'.($sum+1):($sum+1);
//         $data['number'] = date('Ymd').$sum;
//         $data['adddt'] = date('Y-m-d H:i:s');
//         $data['status'] = 1;
//         $data['comid'] = $admin['cid'];
//         $data['optid'] = $admin['id'];
//         $data['optname'] = $admin['name'];
//         $data['optdt'] = date('Y-m-d H:i:s');
//         $data['date'] = date('Y-m-d');
//         $ad = $model->create($data);
//         if($ad){
//             $quodata = array(
//                 'oid' => $ad,
//                 'cid'=>$admin['cid'],
//                 'status' => 0,
//                 'contact' => $data['cname'],
//                 'tel' => $data['phone'],
//             );
//             spClass('m_quotation')->create($quodata);
//             $this->msg_json(1, '操作成功');
//         }else{
//             $this->msg_json(0, '操作失败');
//         }
//     }
    
    function saveOrders()
    {
        $admin = $this->islogin();
        $model = spClass('m_orders');
        //订单名称
        $data['name']    = htmlspecialchars($this->spArgs('name'));
        //客户信息
        $data['cid']     = htmlspecialchars($this->spArgs('cid'));
        $cust_data       = spClass('m_custmang')->find('id='.$data['cid'].' and del=0 and cid='.$admin['cid'].'');
        $this->emptyNotice($cust_data, '客户不存在或已被删除');
        $data['money']   = htmlspecialchars($this->spArgs('money'));
        $data['cname']   = $cust_data['cust_name'];
        $data['phone']   = $cust_data['phone'];
        $data['address'] = $cust_data['address'];
//         $data['phone']   = htmlspecialchars($this->spArgs('phone'));
//         $data['address'] = htmlspecialchars($this->spArgs('address'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        
        //销售人员
        $data['uname'] = $admin['name'];
        $data['uid']   = $admin['id'];
        
        $files = $this->spArgs('files');
        if($files){
            $data['files'] = implode(',', $files);
        }
        if(empty($data['name'])){
            $this->returnError('请填写订单名称');
        }
        if(empty($data['cid'])){
            $this->returnError('请选择客户');
        }
        if(empty($data['uid'])){
            $this->returnError('请选择业务员');
        }
        $sum = $model->findCount('number like "%'.date('Ymd').'%"');
        $sum = $sum<9?'0'.($sum+1):($sum+1);
        $data['number'] = date('Ymd').$sum;
        $data['adddt'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $data['comid'] = $admin['cid'];
        $data['optid'] = $admin['id'];
        $data['optname'] = $admin['name'];
        $data['optdt'] = date('Y-m-d H:i:s');
        $data['date'] = date('Y-m-d');
        $ad = $model->create($data);
        if($ad){
            $quodata = array(
                'oid' => $ad,
                'cid'=>$admin['cid'],
                'status' => 0,
                'contact' => $data['cname'],
                'tel' => $data['phone'],
            );
            spClass('m_quotation')->create($quodata);
            $this->returnSuccess('操作成功');
        }else{
            $this->returnError('操作失败');
        }
    }
    
    /**
     * 设备维修单数据校验
     * @param string $esid
     */
    function checkService($esid)
    {
        $service = spClass('m_equipment_service')->find(array('id' => $esid));
        if (empty($service)) $this->returnError('设备维修单不存在');
    }
    

}
