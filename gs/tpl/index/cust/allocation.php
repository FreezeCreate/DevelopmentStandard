<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>公共池</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['time']) ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a) ?>">全部</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['time'] == 1 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('time' => 1)) ?>">三天内</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['time'] == 2 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('time' => 2)) ?>">一周内</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['time'] == 3 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('time' => 3)) ?>">一个月内</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['time'] == 4 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('time' => 4)) ?>">三个月内</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['time'] == 5 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('time' => 5)) ?>">三个月之前</a>
                        </li>
                    </ul>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
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
                                    <td>序号</td>
                                    <td>客户名称</td>
                                    <td>创建人</td>
                                    <td>客户类型</td>
                                    <td>客户单位</td>
                                    <td>联系人</td>
                                    <td>地址</td>
                                    <td>说明</td>
                                    <td>添加日期</td>
                                    <td>客户状态</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td><?php echo $k + 1 ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['createname'] ?></td>
                                        <td><?php echo $GLOBALS['CUST_TYPE'][$v['type']] ?></td>
                                        <td><?php echo $v['unitname'] ?></td>
                                        <td><?php echo $v['linkname'] ?></td>
                                        <td><?php echo $v['address'] ?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td><?php echo $v['adddt']; ?></td>
                                        <td><?php echo $v['status'] == 0 ? '已放弃' : $GLOBALS['CUST_STATUS'][$v['status']] ?></td>
                                        <td>
                                            <a class="Btn Btn-danger grab" itemid="<?php echo $v['id'] ?>"> 抢 </a>
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
<!--<div class="MoreSelectGroup">
        <input type="text" class="MoreSelectVal" value="" placeholder="--请选择--" />
        <input type="hidden" class="MoreSelectValue" value="" />
        <ul class="MoreSelectMenu">
                <li class="MoreSelectItem"><span class="MoreSelectItemVal" data-val="周报1">周报1</span><i class="CakeImg"></i></li>
                <li class="MoreSelectItem"><span class="MoreSelectItemVal" data-val="周报2">周报2</span><i class="CakeImg"></i></li>
                <li class="MoreSelectItem"><span class="MoreSelectItemVal" data-val="周报3">周报3</span><i class="CakeImg"></i></li>
                <li class="MoreSelectItem"><span class="MoreSelectItemVal" data-val="周报4">周报4</span><i class="CakeImg"></i></li>
                <li class="MoreSelectItem"><span class="MoreSelectItemVal" data-val="周报5">周报5</span><i class="CakeImg"></i></li>
        </ul>
</div>-->
<script type="text/javascript">
    $('.grab').click(function() {
        $id = $(this).attr('itemid');
        $.get("<?php echo spUrl($c, "grab"); ?>", {id: $id}, function(data) {
            if (data.status < 2) {
                $('.Result' + $id + ' td .grab').remove();
            }
            Alert(data.msg, function() {
                if (data.status == 1) {
                    check_apply(21, $id);
                }
            });
        }, 'json');
    });

</script>
