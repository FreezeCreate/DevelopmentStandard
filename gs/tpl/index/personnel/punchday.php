<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>考勤日期设置</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                    <label style="line-height: 30px; color: #00b8ff;">注：默认周一到周五为工作日，周六、日为休息日，如有其它安排在此添加</label>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn InPop" data-BoxId="day">＋ 新增</div>
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
                                    <td>日期</td>
                                    <td>星期</td>
                                    <td>工作安排</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td class="data-dt" title="<?php echo $v['dt'] ?>"><?php echo $v['dt'] ?></td>
                                        <td><?php echo $GLOBALS['WEEK'][date('w', strtotime($v['dt']))] ?></td>
                                        <td class="data-type" title="<?php echo $v['type'] ?>"><?php echo $v['type'] == 1 ? '工作日' : '休息日' ?></td>
                                        <td>
                                            <a class="Btn Btn-danger" onclick="del(<?php echo $v['id'] ?>)">删除</a>
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
        <div class="Tan" id="day">
            <div class="TanBox">
                <div class="TanBoxTit">工作安排 <span class="close OtPop"data-BoxId="day"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="day_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 日期</td>
                                <td><input class="FrameGroupInput" type="text" id="dt" name="dt"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">安排</td>
                                <td>
                                    <label><input type="radio" name="type" value="0"/> 休息日</label>
                                    <label><input type="radio" name="type" value="1"/> 工作日</label>
                                </td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="day" onclick="do_add()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="day">取消</span>
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
            dateCell: "#dt", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        });

        function do_add() {
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "savePunchday"); ?>",
                data: $('#day_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                },
                success: function(data) {
                    if (data.status == 1) {
                        window.location.reload();
                    } else {
                        Alert(data.msg);
                    }
                }
            });
        }

        function del(id) {
            if (confirm("确认删除？")) {
                $.get("<?php echo spUrl($c, "delPunchday"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Result' + id).remove();
                    } else {
                        alert(data.msg);
                    }
                }, "json");
            }
        }

    </script>


