<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>我的跟进客户</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['status']) ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a) ?>">全部</a>
                        </li>
                        <?php foreach ($GLOBALS['SALE_STATUS'] as $k => $v) { ?>
                            <?php if ($k == 1 || $k == 2) { ?>
                                <li class="TablesHeadItem <?php echo $page_con['status'] == $k ? 'active' : '' ?>">
                                    <a href="<?php echo spUrl($c, $a, array('status' => $k)) ?>"><?php echo $v; ?></a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
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
                                    <tr class="Result<?php echo $v['id'] ?> <?php echo $v['status'] == 0 ? 'isread' : '' ?>">
                                        <td><a onclick="check_apply(21,<?php echo $v['custid'] ?>)"><?php echo $v['custname']; ?></a></td>
                                        <td><?php echo $GLOBALS['SALE_TYPE'][$v['type']]; ?></td>
                                        <td><?php echo empty($v['rate']) ? '' : $v['rate'] . '%'; ?></td>
                                        <td><?php echo $v['money']; ?></td>
                                        <td><?php echo $v['adddt']; ?></td>
                                        <td><?php echo empty($v['nextdt']) ? '待定' : date('Y-m-d', $v['nextdt']); ?></td>
                                        <td><?php echo $GLOBALS['SALE_STATUS'][$v['status']]; ?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(21,<?php echo $v['custid'] ?>)">客户信息</a></li>
                                                <li class="menu-item"><a onclick="check_apply(22,<?php echo $v['id'] ?>)">详情</a></li>
                                                <?php if ($v['status'] > 1) { ?>
                                                    <li class="menu-item"><a onclick="fill_apply(22,<?php echo $v['id'] ?>)">信息变更</a></li>
                                                    <li class="menu-item"><a onclick="fill_apply(32,<?php echo $v['id'] ?>)">申请合同</a></li>
                                                    <li class="menu-item"><a class="follow InPop" data-BoxId="genjin" itemid="<?php echo $v['id'] ?>"> + 添加跟进</a></li>
                                                <?php } else { ?>
                                                    <li class="menu-item"><a onclick="fill_apply(22,<?php echo $v['id'] ?>)">完善信息</a></li>
                                                <?php } ?>
                                                <li class="menu-item"><a class="color-red" onclick="delBox(<?php echo $v['id'] ?>)">删除</a></li>
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
        <div class="Tan" id="genjin">
            <div class="TanBox">
                <div class="TanBoxTit">添加跟进 <span class="close OtPop"data-BoxId="genjin"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="genjin_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">跟进说明</td>
                                <td style="text-align: left;">
                                    <textarea class="FrameGroupInput" name="explain"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">下次联系时间</td>
                                <td style="text-align: left;"><input class="FrameGroupInput" id="next" type="text" name="next" value=""/></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="ckzl" onclick="do_genjin()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="xgmm">取消</span>
                        </div>
                    </div>
                    </form>
                </div>
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

<script type="text/javascript">
    jeDate({
        dateCell: "#next",
        format: "YYYY-MM-DD",
        isinitVal: true,
        isTime: true, //isClear:false,
        minDate: "2017-09-19 00:00:00",
//        okfun:function(val){alert(val)}
    });
    $('.follow').click(function() {
        $('#eid').val($(this).attr('itemid'));
        $('input[name="explain"]').val('');
    });
    function do_genjin() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('cust', "follow"); ?>",
            data: $('#genjin_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        $('#genjin .close').click();
                    });
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
    function del_form() {
        Confirm('确定删除该客户项目?', function() {
            $.post("<?php echo spUrl($c, "delSales"); ?>", $('#Delete_form').serialize(), function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        window.location.reload();
                    });
                } else {
                    Alert(data.msg);
                }
                $('.operate').hide();
            }, 'json');
        });
    }


</script>
