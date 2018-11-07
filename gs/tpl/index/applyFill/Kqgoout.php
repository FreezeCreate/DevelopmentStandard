<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>外出</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">外出</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">外出</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 外出类型</td>
                                    <td><select class="FrameGroupInput" id="type" name="type">
                                            <option <?php echo $result['type']==='约见客户'?'selected=""':''; ?> value="约见客户">约见客户</option>
                                            <option <?php echo $result['type']==='公司外派'?'selected=""':''; ?> value="公司外派">公司外派</option>
                                        </select></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 外出天数</td>
                                    <td><input class="FrameGroupInput" type="text" name="time" value="<?php echo empty($result['time'])?'':$result['time']; ?>" placeholder="1天"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span>开始时间</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="start" name="start" value="<?php echo empty($result['start'])?'':$result['start']; ?>"/></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span>截止时间</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="end" name="end" value="<?php echo empty($result['end'])?'':$result['end'] ?>"/></td>
                                </tr>
                                <tr id='luxian'>
                                    <td class="FrameGroupName"><span style='color:red'>*</span>交通路线</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="luxian"><?php echo $result['luxian'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 说明</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <span class="Btn Big" onclick="do_sub()">提交</span>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>


</html>

<script>

    jeDate({
        dateCell: "#start", //isinitVal:true,
        format: "YYYY-MM-DD hh:mm:ss",
        isTime: true, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#end", //isinitVal:true,
        format: "YYYY-MM-DD hh:mm:ss",
        isTime: true, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
        function do_sub() {
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "saveKqgoout"); ?>",
                data: $('#check_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    Alert('提交失败');
                },
                success: function(data) {
                    if (data.status == 1) {
                         
                        Refresh();
                        Alert(data.msg);
                        parent.window.closHtml();
                    } else {
                        Alert(data.msg);
                    }

                }
            });
        }
</script>