<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>转正申请</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">转正申请</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">转正申请</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 申请人</td>
                                    <td><?php echo $admin['name'] ?></td>
                                    <td class="FrameGroupName">申请人部门</td>
                                    <td><?php echo $admin['departmentname'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 入职日期</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" value="<?php echo $admin['workdate'] ?>"/></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 转正日期</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="positivedt" name="positivedt" value="<?php echo empty($result['positivedt']) ? '' : $result['positivedt'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 说明</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">相关文件 ：</td>
                                    <td colspan="3">
                                        <ul class="FileBox">
                                            <?php foreach ($result['files'] as $v) { ?>
                                                <li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="DelFile">删除</span></li>
                                            <?php } ?>
                                        </ul>
                                        <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                        <span class="addFile">+添加文件</span>
                                    </td>
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
            dateCell: "#positivedt", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false,
            //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        });
$(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        };
        $('.addFile').click(function(){
            $(this).prev().click()
        });
        $(document).on('change', '.fileToUpload', function() {
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.id + '">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>';
                        $('#' + name).parent().children('.FileBox').append(txt);
                        $('#' + name).val('');
                    } else {
                        $('#' + name).val('');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });
    });

                    function do_sub() {
                        $.ajax({
                            cache: false,
                            type: "POST",
                            url: "<?php echo spUrl($c, "saveHrpositive"); ?>",
                            data: $('#check_form').serialize(),
                            dataType: "json",
                            async: false,
                            error: function(request) {
                                Alert('提交失败');
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    parent.window.closHtml();
                                    Refresh();
                                } else {
                                    Alert(data.msg);
                                }

                            }
                        });
                    }
</script>