<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>会议记录</title>
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
                            <input type="text" class="FrameDatGroup" name="start" id="start" value="<?php echo $page_con['start'] ?>"/>
                            ~
                            <input type="text" class="FrameDatGroup" name="end" id="end" value="<?php echo $page_con['end'] ?>"/>
                            <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="会议主题"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn" onclick="fill_apply(36)">＋ 新增</div>
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
                                    <td>主题</td>
                                    <td>记录人</td>
                                    <td>会议室</td>
                                    <td>会议开始时间</td>
                                    <td>会议结束时间</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $v['name'];?></td>
                                        <td><?php echo $v['recorder'];?></td>
                                        <td><?php echo $v['mRoom'];?></td>
                                        <td><?php echo $v['statdt'];?></td>
                                        <td><?php echo $v['enddt'];?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(36,<?php echo $v['id'] ?>)">详情</a></li>
                                                <li class="menu-item"><a onclick="fill_apply(36,<?php echo $v['id'] ?>)">编辑</a></li>
                                                <li class="menu-item"><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
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

<script>
    jeDate({
        dateCell: "#start", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#end", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    function del(id) {
        Confirm('确定删除该会议信息？', function(e) {
            if (e) {
                $.post("<?php echo spUrl($c, "delConf2"); ?>", {id:id}, function(data) {
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
</script>
