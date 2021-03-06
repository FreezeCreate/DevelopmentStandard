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
                            <input class="TablesSerchInput" name="name" type="text"  placeholder="输入搜索内容" value="<?php echo $page_con['name'] ?>"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn" onclick="fill_apply(21)">＋ 新增</div>
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
                                    <td>添加时间</td>
                                    <td>跟进时间</td>
                                    <td>客户名称</td>
                                    <td>客户类型</td>
                                    <td>客户单位</td>
                                    <td>联系人</td>
                                    <td>联系手机</td>
                                    <td>地址</td>
                                    <td>是否标★</td>
                                    <td>客户状态</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?> <?php echo $v['status'] == 0 ? 'isread' : '' ?>">
                                        <td><?php echo $v['id'] ?></td>
                                        <td><?php echo date('y-m-d', strtotime($v['adddt'])); ?></td>
                                        <td><?php echo date('y-m-d', $v['endtime']); ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $GLOBALS['CUST_TYPE'][$v['type']] ?></td>
                                        <td><?php echo $v['unitname'] ?></td>
                                        <td><?php echo $v['linkname'] ?></td>
                                        <td><?php echo!empty($v['mobile']) ? $v['mobile'] : $v['tel'] ?></td>
                                        <td><?php echo $v['address'] ?></td>
                                        <td><?php echo $v['isstat'] == 1 ? '是' : '否'; ?></td>
                                        <td><?php echo $v['status'] == 0 ? '已放弃' : $GLOBALS['CUST_STATUS'][$v['status']] ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(21,<?php echo $v['id'] ?>)">详情</a></li>
                                                <li class="menu-item"><a class="follow InPop" data-BoxId="genjin" itemid="<?php echo $v['id'] ?>"> + 添加跟进</a></li>
                                                <?php if (1 == 2) { ?><li class="menu-item"><a onclick="fill_apply(21,<?php echo $v['id'] ?>)">编辑</a></li><?php } ?>
                                                <?php if ($v['status'] == 1) { ?><li class="menu-item void"><a class="color-gray" onclick="voidBox(<?php echo $v['id'] ?>)">放弃</a></li><?php } ?>
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
                            <span class="Btn Big InPop" data-BoxId="genjin" onclick="do_genjin()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="genjin">取消</span>
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
                                $('.follow').click(function() {
                                    $('#eid').val($(this).attr('itemid'));
                                    $('input[name="explain"]').val('');
                                });
                                jeDate({
                                    dateCell: "#next",
                                    format: "YYYY-MM-DD",
                                    isinitVal: true,
                                    isTime: true, //isClear:false,
                                    minDate: "2017-09-19 00:00:00",
//        okfun:function(val){alert(val)}
                                });
                                function voidBox(id) {
                                    Confirm('确定删除该客户？删除后其他员工可联系该客户', function(e) {
                                        if (e) {
                                            $.get("<?php echo spUrl($c, "giveup"); ?>", {id: id}, function(data) {
                                                if (data.status == 1) {
                                                    window.location.reload();
                                                } else {
                                                    Alert(data.msg);
                                                }
                                                $('.operate').hide();
                                            }, 'json');
                                        }
                                    });
                                }

                                function del_form() {
                                    Confirm('确定删除该客户？删除后其他员工可联系该客户', function(e) {
                                        if (e) {
                                            $.post("<?php echo spUrl($c, "delCustomer"); ?>", $('#Delete_form').serialize(), function(data) {
                                                if (data.status == 1) {
                                                    Alert(data.msg, function() {
                                                        window.location.reload();
                                                    });
                                                } else {
                                                    Alert(data.msg);
                                                }
                                                $('.operate').hide();
                                            }, 'json');
                                        }
                                    });
                                }
                                ;
                                function do_genjin() {
                                    $.ajax({
                                        cache: false,
                                        type: "POST",
                                        url: "<?php echo spUrl('cust', "follow2"); ?>",
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

</script>

