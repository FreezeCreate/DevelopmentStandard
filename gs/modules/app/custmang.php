<?php

class custmang extends AppController
{
    /**
     * TODO 所有表的数据校验和查询的公共方法
     * 
     * 仓库管理模块：
     * 采购单 invoice 退货 regoods
     * 盘点 inven 报亏损报溢出
     * 库房 stock_room=>库房产品表 order_goods
     * 设备表 device => 设备分类表 device_cate =>设备检修等信息表 device_desc devicedesc_check(验收报告表)
     * ruku + chuku表
     * 
     * 
     * 财务管理模块：
     *  收付款管理：
     * 
     * 
     * 我的客户，潜在客户 TO DO 按照公司网站的来做 已完成
     * 
     * 企业办公管理
     * //奖罚表 ：yld_manageuser 财务管理->奖罚管理
     * //员工关系和重要日子 ：yld_relation
     * 沟通和分析员工记录表：yld_talkrecord
     * 薪酬设定表：yld_salarystand
     * 标※：公司培训计划的增删改查和审核：(yld_trainplan未建表) 培训材料和总结也在该表中 需要培训流程（审核多流程）
     * 行政管理表(公司活动)：(yld_activity建表) + 活动类型(Sealapl表，印章表)+印章类型
     * 考勤管理：(yld_attendance未建表) (参照lejubang考勤管理)
     * 会议管理：yld_meeting
     * 预警设置：(yld_warnoa未建表)
     * 通知类型 TO DO
     * OA参数设置
     * 通知公告
     * 
     * TO DO 通知公告提醒
     * TO DO 所有更新功能的检查
     * TO DO 所有需审核的详情页面检查
     * TODO 记录表格的字段对比，然后新增或修改字段名称，规范化字段
     * TO DO 很多地方日期和时间的混淆
     * 
     * TO DO 我的客户详情返回的电话，如果为空就写成空字符串;
     * 
     * TO DO 合同申请：如果没有通过就没有完善合同按钮;申请列表要有状态;
     * TO DO 打卡记录 有ip数据，不要精确范围数据;
     * TO DO 财务模块按照区间来查询;开始时间和结束时间;
     * TO DO 打卡统一做成乐居帮的样式;
     * TO DO 例行检查的选中问题;
     * TO DO get_menu和get_ajax_menusession、cookie同步清除的优化
     * 
     * TO DO 更新页面的渲染;
     * TO DO 参数详情页面;
     * 
     * TO DO 添加设备检查需要一个设备二维码存库 + 上传文件字段
     * 
     * TO DO 待办事项和通知公告的消息列表提醒 app端
     * TO DO 设备例行检查新增的接口文档
     * TO DO 列表商品的更新
     * TO DO header动态数据
     * TO DO 合同申请里：已通过的合同申请详情需要显示合同详情;
     * TO DO 合同完善要显示合同申请的基本信息;前端页面;
     * 
     * TO DO 最近出库时间和积压时间的设置
     * TO DO 集成极光推送
     * TO DO 客户用客户分类来选择用户 用部门和人员的形式来写
     * TO DO 服务器上所有签名的默认图片检查和替换;
     * TO DO 商品分类直接选择商品,前端
     * TO DO 工作台 (Tips:所有功能完成后，按需渲染工作台数据) 通知公告+打卡 index模块/apply下的方法对应跳转
     * TO DO 安卓和IOS端两种类型推送消息的编写-- TO DO 待账号数据的沟通
     * TO DO 打卡的bug
     * TO DO 线上合同管理、客户管理报损单和最后的培训管理hide置1;
     * TO DO 例行检查如果没有选择，则无下面的数据，选项卡模块需要把新的置换过来
     * TO DO 例行检查的日期插件;
     * TO DO 我的工作计划：修改页面的字段bug;
     * TO DO 知识库做成h5;
     * TO DO 重构商品采购表;
     * TO DO 张媛汁的bug列表修改;
     * not TO DO 最后一个参数类型的单选bug;
     * TO DO 采购单 需要整合 合同需要整合 审核流程需要加上各种新增
     * TO DO 过程检验详情的编写
     * TO DO 客户来源数据返回
     * TO DO 修改JS第一模块新增后弹框不消失的bug
     * TO DO 进货检验;采购单详情;
     * 
     * TO DO 采购单增加订单单选;成功后新增yld_qualitylog表的数据,然后才能继续走流程到进货检验记录;
     * TO DO 极光推送推送到指定人
     * TO DO 封装方法的抽离文档
     * TO DO 极光推送使用文档md的编写和push
     * TO DO 我的客户线上消失
     * TO DO 新增合同申请+上订单oid
     * TO DO 走流程的合同新增需要新增custid
     * 
     * TODO 工作日志：登陆状态的优化;IOS端推送优化问题;汇款记录的汇款人优化;新模块合同订单接口的优化;第一模块合同的优化;销售管理导航的回复;应付款明细文件的优化;
     * 
     * TO DO 开一个公司+账号，然后赋所有权限和部分权限，测试问题和数据;
     * TO DO 订单供应商无数据
     * TO DO ios无法选中单选框
     * TO DO 没有数据的变成图片
     * TO DO 人员关系提示铃铛
     * TO DO 例行检查新增出现undefined
     * TO DO 现场知识库更新变新增
     * 
     * 前端：例行检查记录、盘点
     * TO DO session和cookie的同存,第一次登陆后即存session,然后交给前端存cookie
     * TO DO 新增销售目标和列表是制定日期
     * TO DO 员工关系的提醒，在第一模块的员工里
     * TO DO 预算控制的重构和api文档编写
     * TO DO 工作计划，参照我们的OA
     * TO DO 其他收款不要合同收款
     * TO DO 我的申请里面的客户只能是我自己的客户
     * TO DO 销售目标：选择自己的下级
     * TO DO 盘点没改前端 
     * TO DO 例行检查界面 
     * TO DO 供应商上传签名的界面
     * 
     * TO DO 上传服务器：第一要素
     * TO DO 入出库、采购、退货对库存的影响 入出库model库存增减的修改
     * TO DO 订单app接口的编写 页面要改，按照电脑端的来做
     * TO DO 新增出入库、采购退货文档的编写
     * TO DO 点进去看多个商品信息的文档编写
     * TO DO 新增不要销售人员、不要制单人、不要地址
     * 
     * TO DO采购申请(status=3列表) 采购明细(status!=3列表)库存积压
     * TO DO客户不要修改删除,
     * TO DO 在我的客户里添加合同申请 
     * TO DO 图标库更改
     * TO DO没有销售目标完成状态                     前端沟通显示
     * TO DO 工作计划没有开始结束时间    前端沟通显示
     * TO DO 销售目标以月为单位
     * TO DO 考勤统计的导航敬哥做 日程只有休息日和工作日
     * TO DO 最后一个模块的整合
     * TO DO 仓库名的重复判断
     * TO DO 采购主附表、采购可以采购多个商品   回滚处理单个接口
     * TO DO 入出库也是可以多商品添加
     * TO DO 采购明细和退货明细点进去可以看到多个商品的采购信息
     * TO DO 仓库列表和库房列表重复
     * TO DO 盘点处理 按照线上进行盘点
     * not TO DO goods_order表加上单位unit字段
     * not TO DO 按供应商和商品的详细信息+上采购列表单
     * 
     * TO DO 已完成
     * 合同详情里需要显示回款列表信息
     * TO DO 已完成
     * 固资设备报告需要审核
     * TO DO 已完成 
     * 供应商审核
     * TO DO 已完成
     * 完善AUTH侧边栏
     * 
     * TO DO 
     * 第一模块移植过来
     * 加入session和cookie(登陆不用做)
     * TO DO
     * 供应商三个部门的审核
     * 
     */
    
    /**
     * 新增合同对应的订单列表
     */
    function orderLsts()
    {
        $admin = $this->islogin();
        $sql   = 'select oid from '.DB_NAME.'_contract where cid='.$admin['cid'].' and del=0 group by oid';
        $o_con = spClass('m_contract')->findSql($sql);
        $this->emptyNotice($o_con, '无订单数据');
        foreach ($o_con as $k => $v){
            if ($v['oid'] == 0) continue;
            if ($k + 1 == count($o_con)){
                $oid_str .= $v['oid'];
                continue;
            }
            $oid_str .= $v['oid'].',';
        }
        $sql1 = 'select id,name from '.DB_NAME.'_orders where id not in ('.$oid_str.') and comid='.$admin['cid'].' and del=0';
        $result['results'] = spClass('m_orders')->findSql($sql1);
        if (!empty($result['results'])) $this->returnSuccess('成功', $result);
        $this->returnError('失败');
    }
    
    /**
     * 我的-潜在客户
     */
    function latentUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=1';
        $this->addmang($con);
    }
    /**
     * 我的-跟进客户
     */
    function flowUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=2';
        $this->addmang($con);
    }
    /**
     * 我的-签约客户
     */
    function signUser()
    {
        $admin  = $this->islogin();
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        $con   .= ' and saleid='.$admin['id'].' and flowid=3';
        $this->addmang($con);
    }
    
    /**
     * custmang list page
     * 列表公共方法
     * @param unknown $con
     */
    function addmang($con)
    {
        $admin  = $this->islogin();
        if (empty($con)) $this->returnError('非法输入');
//         $admin              = $this->get_ajax_menu();   //admin data
//         $admin['cust_mang'] = spClass('m_custmang')->findAll();  //TODO 先不删除该数据
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_admin    = spClass('m_admin');
        $m_cust     = spClass('m_custmang');
        $m_record   = spClass('m_cust_record');
        $m_cate     = spClass('m_cust_cate');
        
        if (!empty($searchname)) {
            $con .= ' and concat(cust_name,type,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        //pagenum
        //         $results        = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'applydt desc,id desc');
//         $this->results  = $results;
//         $this->pager    = $m_cust->spPager()->getPager();
//         $this->page_con = $page_con;
        $sale    = spClass('m_admin')->findAll('', 'id desc', 'id,username');
        $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'noticetime desc,birth desc');
        $pager   = $m_cust->spPager()->getPager();
//         $page    = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['pager'] = $pager;
        
        foreach ($results as $_k => $_v){
            $record = $m_record->findSql('select addtime,status,`explain` from '.DB_NAME.'_cust_record where fid='.$_v['id'].' and cid='.$admin['cid'].' order by id desc limit 1');
            if ($record){
                $results[$_k]['record_addtime'] = $record[0]['addtime'];
                $results[$_k]['record_status']  = $record[0]['status'];
                $results[$_k]['record_explain'] = $record[0]['explain'];
            }else {
                $results[$_k]['record_addtime'] = '';
                $results[$_k]['record_status']  = '';
                $results[$_k]['record_explain'] = '';
            }
        }
        
        foreach($results as $k=>$v){
            $notic = '';
            $salename = $m_admin->find(array('id'=>$v['saleid']), '', 'id,name');
            if (strtotime($v['noticetime']) - time() < 86400 && strtotime($v['noticetime']) - time() > 0){  //提前一天
                $notic = $v['noticecontent'];
            }
            if (strtotime($v['birth']) - time() < 86400 && strtotime($v['birth']) - time() > 0){  //提前一天
                $notic = $v['noticecontent'];
            }
            
            if (strtotime($v['noticetime']) - time() > -86400 && strtotime($v['noticetime']) - time() < 0){  //延后一天
                $notic = $v['noticecontent'];
            }
            if (strtotime($v['birth']) - time() > -86400 && strtotime($v['birth']) - time() < 0){  //延后一天
                $notic = $v['noticecontent'];
            }
            
            $cust_cate = $m_cate->find(array('id' => $v['type']), '', 'catename');   //客户类型显示
            $result['results'][$k] = array(
                'id'         => $v['id'],
                'cust_name'  => $v['cust_name'],
                'custdname'  => $v['custdname'],
                'phone'      => $v['phone'],
                'sex'        => $v['sex'],
                'age'        => $v['age'],
                'address'    => $v['address'],
                'noticetime' => $v['noticetime'],
                'noticecontent' => $notic,
                'flowid'     => $v['flowid'],
                'salename'   => $salename['name'],
                'record_status'  => $v['record_status'],  //跟进状态
                'record_addtime' => $v['record_addtime'], //跟进时间
                'record_explain' => $v['record_explain'], //跟进内容
                'cust_cate'  => $cust_cate['catename'], //列表显示客户类型
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    //del custmang
    function delCustmang()
    {
        $admin = $this->islogin();
        $id = htmlspecialchars($this->spArgs('id'));
        $res = spClass('m_custmang')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }
    
    //custmang detail 详细
    function custInfo()
    {
        //check
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        if (empty($id)) $this->returnError('id不存在');
        
        //select data
//         $data = 'id,type,cust_name,custdname,custcname,phone,address,retime,noticetime,birth,charact,comment,forecast,goal,edu,info';
//         $result['results'] = spClass('m_custmang')->find('id='.$id, '', $data);
        $result['results'] = spClass('m_custmang')->find('id='.$id.' and cid='.$admin['cid'], '', '');
        //客户类型
        $cust_name = spClass('m_cust_cate')->find('id='.$result['results']['type'].' and cid='.$admin['cid'].' and del=0', '', 'catename');
        $result['results']['cust_cate'] = $cust_name['catename'];
        //客户来源
        //客户来源类型
        if ($result['results']['source'] == 1) $result['results']['source'] = '网上开拓';
        if ($result['results']['source'] == 2) $result['results']['source'] = '电话开拓';
        if ($result['results']['source'] == 3) $result['results']['source'] = '线下开拓';
        if ($result['results']['source'] == 4) $result['results']['source'] = '主动来访';
        
        if (empty($result['results'])) $this->returnError('失败');
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * update/add cust mang
     * 更新/添加用户管理
     */
    function saveCustmang()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_custmang');
        
        $arg = array(
            'id'         => '',
            'type'       => '客户从业类型', //客户从业类型
            'sex'        => '', //性别
            'age'        => '', //年龄
            'cust_name'  => '客户名称', //客户名称
            'custdname'  => '',
            'custcname'  => '', //客户公司
            'phone'      => '', //客户手机，不能为空 客户手机
            'telephone'  => '',       //客户电话，可以为空
            'source'     => '', //来源,$GLOBALS 客户来源
            'email'      => '',
            'address'    => '',
            'retime'     => '',
            'noticetime' => '',
            'noticecontent' => '',
            'birth'      => '',
            'charact'    => '',
            'comment'    => '',
            'forecast'   => '',
            'goal'       => '',
            'edu'        => '',
            'info'       => '',
//             'saleid'     => '',
            'pid'        => '',
            'pname'      => '',
            'flowid'     => '', //跟进状态
        );
        
        $data = $this->receiveData($arg);
        $data['status'] = 1;
        $id = (int) $data['id'];
        unset($data['id']);
        //手机表单判断
        if (!is_numeric($data['phone'])) $this->returnError('电话号码请填写数字');
        
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0, 'cid' => $admin['cid']), '');
            if (empty($re)) $this->returnError('信息有误');
//             $data['pid']    = $re['pid'];
//             $data['saleid'] = $re['saleid'];
//             $data['pname']  = $re['pname'];
//             $data['flowid'] = $re['flowid'];
//             $data['status'] = $re['flowid'];
            $data = $this->checkUpdateArr($re, $data);
            $up = $model->update(array('id' => $re['id']), $data);
        } else {
            $data['saleid']    = $admin['id'];
            $data['applyid']   = $admin['id'];
            $data['applyname'] = $admin['name'];
            $data['applydt']   = date('Y-m-d H:i:s');
            $data['cid']       = $admin['cid'];
            $data['flowid']    = 1;
            $up = $model->create($data);
        }
        if ($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }

    /**
     * return JSON
     * 客户跟进+状态的列表
     * 
     */
//     function flowLst()
//     {
//         $admin = $this->islogin();
//         $searchname          = urldecode(htmlspecialchars($this->spArgs('searchname')));
        
//         $m_cust   = spClass('m_custmang');
//         $m_record = spClass('m_cust_record');
        
//         //where和分页where
//         $con    = 'del = 0 and cid = ' . $admin['cid']. ' and flowid<3';
//         if (!empty($searchname)) {
//             $con .= ' and concat(cust_name,custdname,custcname,source,phone,address,info) like "%' . $searchname . '%"';
//             $page_con['searchname'] = $searchname;
//         }
        
//         $results = $m_cust->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
//         $pager   = $m_cust->spPager()->getPager();
//         $result['pager'] = $pager;
        
//         foreach ($results as $_k => $_v){
//             $record = $m_record->findSql('select addtime,status from '.DB_NAME.'_cust_record where fid='.$_v['id'].' order by id desc limit 1');
//             if ($record){
//                 $results[$_k]['record_addtime'] = $record[0]['addtime'];
//                 $results[$_k]['record_status']  = $record[0]['status'];
//             }else {
//                 $results[$_k]['record_addtime'] = '';
//                 $results[$_k]['record_status']  = '';
//             }
//         }
        
//         foreach($results as $k=>$v){
//             $result['results'][$k] = array(
//                 'id'             => $v['id'],
//                 'custcname'      => $v['custcname'],
//                 'cust_name'      => $v['cust_name'],
//                 'record_status'  => $v['record_status'],    //跟进情况
//                 'record_addtime' => $v['record_addtime'],    //最新跟进时间
//                 'phone'          => $v['phone'],
//                 'address'        => $v['address'],
//             );
//         }
        
//         $this->returnSuccess('成功', $result);
//     }
    
    /**
     * 客户跟进管理详情
     * 客户管理信息 && 客户回访记录
     * cust info && cust record list
     * 返回连表数据
     */
    function flowcust()
    {
        $admin         = $this->islogin();
        $m_record      = spClass('m_cust_record');
        $m_mang        = spClass('m_custmang');
        $m_contract    = spClass('m_contract');
        
        $f_id    = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($f_id)) $this->returnError('id不存在');
        $f_result = $m_mang->find('id='.$f_id.' and cid='.$admin['cid']);   //客户
        $c_result = $m_record->findAll('fid='.$f_id.' and cid='.$admin['cid'], 'id desc', 'addtime,`explain`'); //回访
        if (empty($f_result)) $this->returnError('id非法');
        
        //客户类型
        $cust_name = spClass('m_cust_cate')->find('id='.$f_result['type'].' and cid='.$admin['cid'].' and del=0', '', 'catename');
        $f_result['cust_cate'] = $cust_name['catename'];
        //客户来源类型
//         if ($f_result['source'] == 1) $f_result['source'] = '网上开拓';
//         if ($f_result['source'] == 2) $f_result['source'] = '电话开拓';
//         if ($f_result['source'] == 3) $f_result['source'] = '线下开拓';
//         if ($f_result['source'] == 4) $f_result['source'] = '主动来访';
        
        $t_result = $m_contract->findAll('custid='.$f_id.' and cid='.$admin['cid'].' and del=0');  //合同
        $results['t_result'] = $t_result;
        $results['f_result'] = $f_result;
        $results['c_result'] = $c_result;
        $this->returnSuccess('成功', $results);
//         $res = $m_mang->findSql("select a.*,b.flowname,b.addtime,b.explain from yld_custmang as a,yld_cust_record as b where a.id = b.fid");
    }
    
    /**
     * add record
     * 增加回访记录
     */
    function addCustRecord()
    {
        $admin   = $this->islogin();
        $model   = spClass('m_cust_record');
        $f_id    = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($f_id)) $this->returnError('id不存在');
        $id_exist = spClass('m_custmang')->find('id='.$f_id.' and del=0 and cid='.$admin['cid'], '', 'id,flowid');
        if (empty($id_exist)) $this->returnError('id非法');
        
        $arg = array(
            'addtime'   => '添加时间',
            'explain'   => '描述情况',
        );
        $data = $this->receiveData($arg);
        
        $data['applyid']   = $admin['id'];
        $data['applyname'] = $admin['username'];
        $data['applydt']   = date('Y-m-d H:i:s');
        $data['cid']       = $admin['cid'];
        $data['fid']       = $f_id;
        $data['ip']        = $_SERVER['REMOTE_ADDR'];
        
        //当回访客户时，flowID为2
        if ($id_exist['flowid'] != 3){
            spClass('m_custmang')->update(array('id' => $f_id, 'del' => 0, 'cid' => $admin['cid']), array('flowid' => 2));
        }
        
        $res = $model->create($data);
        if ($res) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    
    /*
     * 签约客户详情
     */
//     function finishCustInfo()
//     {
//         $admin      = $this->islogin();
//         $m_contract = spClass('m_custmang');
//         $id         = htmlspecialchars($this->spArgs('id'));
//         //check params
//         if (empty($id)) $this->returnError('id不存在');
//         $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid'].' and flowid=3');
//         if (empty($results)) $this->returnError('id非法');
//         $result['results'] = $results;
        
//         $this->returnSuccess('成功', $result);
//     }
    
    /*
     * 审核通过的我的合同申请
     * 用于新增合同的渲染
     */
    function applyCheckLst()
    {
//         $admin      = $this->islogin();
//         $m_contract = spClass('m_contract');
//         $results    = spClass('m_contract_apply')->findAll('status=3 and del=0 and cid='.$admin['cid'].' and applyid='.$admin['id'].'');
//         foreach($results as $k=>$v){
//             $exist_contract = $m_contract->find('conapplyid='.$v['id'].' and del=0 and cid='.$admin['cid'].'');
//             if (!empty($exist_contract)) continue;  //合同中存在申请的id时说明合同已经通过，无需遍历
//             $result['results'][] = array(
//                 'apply_id'             => $v['id'],
//                 'apply_contractname'   => $v['contractname'],
//             );
//         }
        
//         $this->returnSuccess('成功', $result);
        
        
        $admin      = $this->islogin();
        $id         = htmlspecialchars($this->spArgs('id'));
        $m_contract = spClass('m_contract');
        $results    = spClass('m_contract_apply')->findAll('status=3 and del=0 and custid='.$id.' and cid='.$admin['cid'].' and applyid='.$admin['id'].'');
        foreach($results as $k=>$v){
            $exist_contract = $m_contract->find('conapplyid='.$v['id'].' and del=0 and cid='.$admin['cid'].'');
            if (!empty($exist_contract)) continue;  //合同中存在申请的id时说明合同已经通过，无需遍历
            $result['results'][] = array(
                'apply_id'             => $v['id'],
                'apply_contractname'   => $v['contractname'],
            );
        }
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同签订 更新 & 增加
     */
    function saveContract()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_contract');
        $id              = (int)htmlentities($this->spArgs('id'));
        $applyid         = (int)htmlentities($this->spArgs('apply_id'));
        
        $arg = array(
            'money'   => '合同金额',
            'signdt'  => '',
            'phone'   => '',
            'adddt'   => '',
            'explain' => '',
            'startdt' => '',
            'enddt'   => '',
            'content' => '',
        );
        $data = $this->receiveData($arg);
        //手机表单判断
        if (!is_numeric($data['phone'])) $this->returnError('电话号码请填写数字');
        
        //从申请表过来的数据
        $apply_data         = spClass('m_contract_apply')->find('id='.$applyid);
        if (!$apply_data) $this->returnError('合同申请不存在');
        $data['name']       = $apply_data['contractname'];
        $data['cname']      = $apply_data['applycname']; //客户名称
        $data['salename']   = $apply_data['applyname'];
        $data['saleid']     = $apply_data['applyid'];
        $data['custid']     = $apply_data['custid'];    //客户id
        $data['conapplyid'] = $apply_data['id'];    //合同申请id
//         $data['files']      = $apply_data['files'];  //文件资料
        $data['files'] = $this->spArgs('files');    //前端已经做了处理
        
        $sum   = $model->findCount('number like "%C'.date('Ymd').'%"');
        $sum   = $sum<9?'0'.($sum+1):($sum+1);
        
        //更新客户的签约状态
        spClass('m_custmang')->update(array('id'=>$data['custid'],'cid'=>$admin['cid']),array('flowid' => 3));
        
        if($id){
//             $re = $model->find(array('id'=>$id.' and cid='.$admin['cid'],'del'=>0));
            $re = $model->find(array('id' => $id, 'cid' => $admin['cid'], 'del' => 0));
            if(empty($re)) $this->returnError('信息不存在');
            if($re['status']>=3) $this->returnError('该合同已审核，不可操作');
            if(!empty($re['number'])) unset($data['number']);
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $ad = $re['id'];
            }
        }else{
            $data['number']  = 'C'.date('Ymd').$sum;
            $data['adddt']   = date('Y-m-d H:i:s');
            $data['status']  = 1;
            $data['cid']     = $admin['cid'];
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            $ad = $model->create($data);
            //合同申请表的constatus置1
            spClass('m_contract_apply')->update(array('id' => $applyid), array('constatus' => 1));
        }
        if ($ad) {
            //合同已经经过了申请合同的审核，不在需要审核 TODO
//             $this->sendUpcoming($admin, 3, $ad, '【'.$data['name'].'】合同');
//             $this->sendUpcoming(7, $ad, $data['uname'] . '申请领用[' . $data['gname'] . ']');
            $this->returnSuccess('成功');
        } else {
            $this->returnError('失败');
        }

    }
    
    /*
     * 合同列表
     */
    function contractLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $distance   = urldecode(htmlspecialchars($this->spArgs('distance')));
        $m_contract = spClass('m_contract');
        $m_custpay  = spClass('m_custpay');
        
//         $con = 'select * from '.DB_NAME.'_contract where ';
        //where和分页where
        $con    .= 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(number,name,adddt,cname,money,startdt,enddt,signdt,salename) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($distance)) {
            if ($distance == 1){    //未生效 签约时间未到
                $con .= ' and UNIX_TIMESTAMP(startdt)>'.time().'';
                $page_con['distance'] = $distance;
            }elseif ($distance == 2){   //已生效
                $con .= ' and UNIX_TIMESTAMP(startdt)<'.time().' and UNIX_TIMESTAMP(enddt)>'.time().'';
                $page_con['distance'] = $distance;
            }elseif ($distance == 3){   //已过期
                $con .= ' and UNIX_TIMESTAMP(enddt)<'.time().'';
                $page_con['distance'] = $distance;
            }
        }
        
        //统计总金额数据
        $re_all  = $m_contract->findAll('del=0 and cid='.$admin['cid'], 'id desc', 'money'); //总金额
        $pay_all = $m_custpay->findAll('del=0 and cid='.$admin['cid'], 'id desc', 'getmoney');    //总已收款
        $sum_all = $sum_pay = $con_pay = 0;
        foreach ($re_all as $re_v){
            $sum_all = $sum_all + $re_v['money'];
        }
        foreach ($pay_all as $pay_v){
            $sum_pay = $sum_pay + $pay_v['getmoney'];
        }
//         $a = $m_contract->findSql('select * from '.DB_NAME.'_contract where UNIX_TIMESTAMP(enddt)>'.time().'','adddt desc,id desc');
//         dump($a);die;
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'adddt desc,id desc');
//         dump($m_contract->dumpSql());die;
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
            $cust_res = $m_custpay->findAll('contractid='.$v['id'].' and del=0 and cid='.$admin['cid'].'');
            if (!empty($cust_res)){
                foreach ($cust_res as $cust_v){
                    $con_pay = $con_pay + $cust_v['getmoney'];
                }
            }else {
                $con_pay = 0;
            }
            $result['results'][$k]['con_pay']  = $con_pay;
            $result['results'][$k]['con_will'] = $v['money'] - $con_pay;
            $con_pay = 0;
        }
        
        $result['sum_all'] = $sum_all;//合同总金额
        $result['sum_pay'] = $sum_pay;//总已收款
        $result['sum_not'] = $sum_all - $sum_pay;//总未收款
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同详情
     */
    function contractInfo()
    {
        $admin      = $this->islogin();
        $m_contract = spClass('m_contract');
        $m_file     = spClass('m_file');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $m_contract->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        
        //files处理
        if (!empty($results['files'])){
            $re_file = explode(',', $results['files']);
            foreach ($re_file as $k => $v){
                $reak[] = $m_file->find(array('id' => $v));
            }
        }
        
        $results['files']  = $reak;
        $result['results'] = $results;
        $cust_pay = spClass('m_custpay')->findAll('contractid='.$id.' and del=0 and cid='.$admin['cid'].'');
        foreach ($cust_pay as $_k => $_v){
            if (!empty($_v['files'])){
                if (strpos($_v['files'], ',')){
                    $re_file1 = explode(',', $_v['files']);
                }else {
                    $re_file1[] = $_v['files'];
                }
                
                foreach ($re_file1 as $__k => $__v){
                    $reak1[] = $m_file->find(array('id' => $__v));
                }
                $cust_pay[$_k]['files'] = $reak1;
            }
        }
        $result['custpay'] = $cust_pay;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 删除合同
     */
    function delContract()
    {
        $admin = $this->islogin();
        $id    = htmlspecialchars($this->spArgs('id'));
        $res   = spClass('m_contract')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res){
            spClass('m_flow_bill')->update(array('tid'=>$id, 'table' => 'contract'),array('del' => 1));
            $this->returnSuccess('成功');
        }else {
            $this->returnError('失败');
        }
    }

    /**
     * 新增合同申请
     */
    function saveContractApply()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_contract_apply');
        $id              = (int)htmlentities($this->spArgs('id'));
        $arg = array(
            'custid'          => '客户id',
//             'applyname'       => '申请人(销售人员)',
            'contractname'    => '申请合同名称',
            'contractdesc'    => '合同对方简介',
            'contractcontent' => '合同内容',
//             'applydname'      => '申请部门',
            'suggest'         => '审核意见',
//             'applyid'         => '申请人',
            'applydt'         => '申请日期',
        );
        $data = $this->receiveData($arg);
        $cust_data = spClass('m_custmang')->find('id='.$data['custid'].'');
        $data['custname'] = $cust_data['cust_name'];
        
        //申请人数据
        $data['applyid']   = $admin['id'];
        $data['applyname'] = $admin['name'];
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('信息不存在');
            if($re['status']>=3) $this->returnError('该合同申请已审核，不可操作');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
            if($up){
                $ad = $re['id'];
            }
        }else{
            $data['adddt']      = date('Y-m-d H:i:s');
            $data['status']     = 1;
            $data['cid']        = $admin['cid'];
            $data['optid']      = $admin['id'];
            //         $data['applydname'] = $admin['dname'];
            $data['optname']    = $admin['name'];
            $data['optdt']      = date('Y-m-d H:i:s');
            $ad = $model->create($data);
            $id = $ad;
        }
        if ($ad) {
            $this->sendUpcoming($admin, 43, $id, '【'.$data['contractname'].'】合同申请');
            
            $this->sendMsgNotice($admin, 43, $id, '【'.$data['contractname'].'】合同申请');
            $this->returnSuccess('成功');
        } else {
            $this->returnError('失败');
        }
    }
    
    /**
     * 合同申请详情
     */
    function applyContractInfo()
    {
        $admin = $this->islogin();
        $id    = (int) htmlentities($this->spArgs('id'));
        $this->findCheck($id, 43);
    }
    
    /**
     * 合同申请列表(当前用户)
     */
    function applyContractLst()
    {
        $admin         = $this->islogin();
        $searchname    = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_contract    = spClass('m_contract_apply');
        $m_custmang    = spClass('m_custmang');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and applyid='.$admin['id'];
        if (!empty($searchname)) {
            $con .= ' and concat(applyname,contractname,contractdesc,applydt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $cust = $m_custmang->find('id='.$v['custid'].' and del=0 and cid='.$admin['cid'].'');
            $result['results'][$k] = $v;
            $result['results'][$k]['cust_name'] = $cust['cust_name'];
        }
        
        $result['sales']   = spClass('m_admin')->findAll('', 'id desc', 'id,username');   //销售人员渲染
        $result['sales']   = array_values($result['sales']);
        $result['status']  = array(1,2,3);  //合同状态
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同申请列表(管理员)
     */
    function applyContractAll()
    {
        $admin         = $this->islogin();
        $searchname    = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $m_contract    = spClass('m_contract_apply');
        $m_custmang    = spClass('m_custmang');
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'];
        if (!empty($searchname)) {
            $con .= ' and concat(applyname,contractname,contractdesc,applydname,applydt) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        
        $results = $m_contract->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $m_contract->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $cust = $m_custmang->find('id='.$v['custid'].' and del=0 and cid='.$admin['cid'].'');
            $result['results'][$k] = $v;
            $result['results'][$k]['cust_name'] = $cust['cust_name'];}
        
        $result['sales']   = spClass('m_admin')->findAll('', 'id desc', 'id,username');   //销售人员渲染
        $result['sales']   = array_values($result['sales']);
        $result['status']  = array(1,2,3);  //合同状态
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 合同申请删除
     */
    function applyContractDel()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $admin = $this->islogin();
        $data = spClass('m_contract_apply')->find('id='.$id);
        if ($data['applyid'] != $admin['id']) $this->returnError('该用户未申请该合同!');
        
        $res   = spClass('m_contract_apply')->update(array('id' => $id, 'cid' => $admin['cid']), array('del' => 1));
        if ($res) $this->returnSuccess('成功');;
        $this->returnError('失败');
    }
    
    
    
    
    
    /**
     * -----------------------------------财务管理模块---------------------------------
     */
    
    /*
     * 项目对账单+收款记录信息
     * 搜索参数和前端对接
     * TIps:循环合同，选择一个合同查看其数据
     */
    function projectBill()
    {
        $admin         = $this->islogin();
        $id            = (int)htmlspecialchars($this->spArgs('id'));
        $m_contract    = spClass('m_contract');
        $result['results']       = $m_contract->find('id='.$id.' and del=0 and cid='.$admin['cid']);    //合同数据
        $result['paymon']        = spClass('m_custpay')->findAll('cid='.$admin['cid'].' and contractid='.$result['results']['id']);   //付款数据
        $will = 0;
        foreach ($result['paymon'] as $k => $v){
            $will = $will + $v['getmoney'];
        }
        if (empty($result['paymon'])) $result['paymon'] = '';
        
        $result['balance'] = $result['results']['money'] - $will;   //未收款
        $this->returnSuccess('成功', $result);
    }
    
    function projectBillLst()
    {
        $admin     = $this->islogin();
        $con       = 'a.del = 0 and a.cid = ' . $admin['cid'];
        $searchname= urldecode(htmlspecialchars($this->spArgs('searchname')));
        $model     = spClass('m_contract');
        
        if (!empty($searchname)) {
            $con .= ' and concat(a.number,a.name,a.adddt,a.cname,a.money,a.startdt,a.enddt,a.signdt,a.salename) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        //开始时间和结束时间查询
        $start      = htmlspecialchars($this->spArgs('start'));
        $end        = htmlspecialchars($this->spArgs('end'));
        if (!empty($start)){
            $con .= ' and a.optdt>"'.$start.'"';
        }
        if (!empty($end)){
            $con .= ' and a.optdt<"'.$end.'"';
        }
        
        $sql     = 'select a.* from '.DB_NAME.'_contract as a,'.DB_NAME.'_custpay as b where '.$con.' and b.del=0 and b.cid='.$admin['cid'].' and a.id=b.contractid group by a.id order by a.id desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 其他收支明细列表
     * 即checkstatus=2
     */
    function otherBillLst()
    {
        $admin      = $this->islogin();
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $searchdt   = urldecode(htmlspecialchars($this->spArgs('searchdt')));   //现在按照具体时间查找 //查询时间范围查询
        
        //where和分页where
        $con    = 'del = 0 and cid = ' . $admin['cid'].' and checkstatus=2';
        if (!empty($searchname)) {
            $con .= ' and concat(paynumber,custname,contractname,getmoney,adddt) like "%' . $searchname . '%"';
        }
        if (!empty($searchdt)){
            $con .= ' and adddt like "%' . $searchdt . '%"';
            $result['pay'] = spClass('m_custpay_mon')->findAll($con);
            $result['get'] = spClass('m_custpay')->findAll($con);
        }
//         if (empty($result)) $result = '';
        $this->returnSuccess('成功', $result);
    }
    
    
    
    
}

