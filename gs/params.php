<?php

/**
 * 定义全局参数
 */
//分页大小
define("PAGE_NUM", 30);

$GLOBALS['SHOPNAME'] = '成都冠晟科技';
$GLOBALS['SHOPURL'] = '';
//版本信息
$GLOBALS['VERSION'] = array(
    'num' => '1.1',
    'android' => 'http://gscs.sem98.com/apk/1.1.apk',
    'ios' => 'http://gscs.sem98.com/apk/1.0',
);

//星期几
$GLOBALS['WEEK'] = array(
    0 => '日',
    1 => '一',
    2 => '二',
    3 => '三',
    4 => '四',
    5 => '五',
    6 => '六',
);

//人员状态
$GLOBALS['USER_DIR'] = array(
    1 => '试用期',
    2 => '正式',
    3 => '实习生',
    4 => '兼职',
    5 => '合同工',
    6 => '离职',
);


//合同类型
$GLOBALS['CONTRACT_TYPE'] = array(
    1 => '劳动合同',
);

//项目合同类型
$GLOBALS['CUSTRACT_TYPE'] = array(
    1 => '生效',
    2 => '失效',
);

//客户来源
$GLOBALS['CUST_LAIYUAN'] = array(
    1 => '网上开拓',
    2 => '电话开拓',
    3 => '线下开拓',
    4 => '主动来访',
);

//印章类型
$GLOBALS['SEAL_TYPE'] = array(
    1 => '合同章',
    2 => '法人章',
    3 => '财务章',
    4 => '公章',
    5 => '收款章',
);

//证件类型
$GLOBALS['PAPER_TYPE'] = array(
    1 => '身份证',
);

//办公用品分类
$GLOBALS['OFFICE_TYPE'] = array(
    1 => '办公设备',
    2 => '办公用纸',
    3 => '财务用品',
    4 => '资料管理',
    5 => '日用劳保',

);

//合同状态
$GLOBALS['CONTRACT_STATUS'] = array(
    1 => '未生效',
    2 => '生效中',
    3 => '已过期',
);

//收款方式
$GLOBALS['PAY_TYPE'] = array(
    1 => '网银',
    2 => '现金',
    3 => '支付宝',
    4 => '转账支票',
    5 => '汇款',
    6 => '资金注入',
);

//流程分类
$GLOBALS['PRO_TYPE'] = array(
    1 => '行政',
    2 => '生产流程',
    3 => '采购部',
    4 => '生产技术部',
    5 => '质检部',
    6 => '销售部',
);

//审核人员类型
$GLOBALS['COURSE_TYPE'] = array(
    'super' => '直属上级',
    'rank' => '职位',
    'dept' => '部门负责人',
    'pub' => '申请发布人',
    'admin' => '指定人员',
    'assign' => '上级分配',
    'auto' => '自定义',
);

//流程申请状态
$GLOBALS['PRO_STATUS'] = array(
    -1 => array('text'=>'未找到审核人','color'=>'red'),
     0 => array('text'=>'已作废','color'=>'gray'),
     1 => array('text'=>'待审核','color'=>'green'),
     2 => array('text'=>'驳回','color'=>'gray'),
     3 => array('text'=>'通过','color'=>'green'),
);

$GLOBALS['GRANT_TYPE'] = array(
    1 => '未结算',
    2 => '已结算',
);

$GLOBALS['INFOR_TYPE'] = array(
    1 => '通知公告',
    2 => '规章制度',
    3 => '奖惩',
    4 => '培训',
);

//报价单状态
$GLOBALS['QUO_STATUS'] = array(
    0 => '待报价',
    1 => '待审核',
    2 => '驳回',
    3 => '审核通过',
);

//流程申请状态
$GLOBALS['PRO_STATUS'] = array(
    -1 => array('text'=>'未找到审核人','color'=>'red'),
     0 => array('text'=>'已作废','color'=>'gray'),
     1 => array('text'=>'待审核','color'=>'green'),
     2 => array('text'=>'驳回','color'=>'gray'),
     3 => array('text'=>'通过','color'=>'green'),
);

$GLOBALS['MID_STATUS'] = array(
    0 => '待生产',
    1 => '报价单',
    2 => '签订合同',
    3 => '制作生产计划',
    4 => '元器件检查',
    5 => '进货检验',
    6 => '材料领取',
    7 => '生产部流程卡',
    8 => '成品检查',
    9 => '成品入库',
);

//活动类型
$GLOBALS['ACTYPE'] = array(
    1 => '户外运动',
    2 => '文艺',
    3 => '娱乐',
    4 => '员工生日',
);

//请假类型
$GLOBALS['HOLIDAY'] = array(
    1 => '事假',
    2 => '病假',
    3 => '年假',
);



