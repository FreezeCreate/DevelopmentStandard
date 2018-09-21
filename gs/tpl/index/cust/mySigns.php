<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>列表</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="输入关键字"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                            <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                        </form>
                    </div>
                </div>
                <?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="TablesBody top20">
                        <table>
                            <thead>
                                <tr>
                                    <td>客户名称</td>
                                    <td>项目类型</td>
                                    <td>预计签单率</td>
                                    <td>预计金额</td>
                                    <td>添加时间</td>
                                    <td>下次联系时间</td>
                                    <td>状态</td>
                                    <td>说明</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="User<?php echo $v['id'] ?>">
                                        <td><a onclick="check_apply(21,<?php echo $v['custid'] ?>)"><?php echo $v['custname']; ?></a></td>
                                        <td><?php echo $GLOBALS['SALE_TYPE'][$v['type']]; ?></td>
                                        <td><?php echo empty($v['rate']) ? '' : $v['rate'] . '%'; ?></td>
                                        <td><?php echo $v['money']; ?></td>
                                        <td><?php echo $v['adddt']; ?></td>
                                        <td><?php echo empty($v['nextdt'])?'待定':date('Y-m-d',$v['nextdt']); ?></td>
                                        <td><?php echo $GLOBALS['SALE_STATUS'][$v['status']]; ?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(22,<?php echo $v['id'] ?>)">详情</a></li>
                                            </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>

</html>
