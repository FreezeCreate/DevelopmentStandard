<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>会议记录</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
        <script>
            var Use;
//            var Pos;
//            var Dep;
            $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                    Use = {}
                    Use.status = 2;
                    Use.data = data.data[0].children;
            }, 'json');
            //职位
//            $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
            //部门
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');
        </script>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">会议记录</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <input type='hidden' name='type' value='1'/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">活动</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span>会议室</td>
                                    <td>
                                        <select class='FrameGroupInput' name='mRoom' style='width:100%'>
                                            <?php foreach ($room as $k => $v) { ?>
                                                <option value='<?php echo $v['name']; ?>' <?php
                                                if ($v['name'] == $result['mRoom']) {
                                                    echo 'selected';
                                                }
                                                ?>><?php echo $v['name']; ?>-<?php echo $v['shopname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="FrameGroupName">会议纪要人</td>
                                    <td>
                                        <input class="FrameGroupInput uname" type="text" name="recorder" placeholder="" value="<?php echo $result['recorder'] ?>"/>
                                        <input type="hidden" class="uid" name="rid" value="<?php echo $result['rid'] ?>"/>
                                        <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 开始日期</td>
                                    <td><input type="text" class="FrameGroupInput" id="statdt" name="statdt" value="<?php echo $result['statdt'] ?>"/></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 结束日期</td>
                                    <td><input type="text" class="FrameGroupInput" id="enddt" name="enddt" value="<?php echo $result['enddt'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span>会议主题</td>
                                    <td colspan='3'><input style='width:90%' type="text" class="FrameGroupInput" name='name' value="<?php echo $result['name'] ?>"/></td>
                                </tr>

                                <tr>
                                    <td class="FrameGroupName">参会人</td>
                                    <td colspan='3'>
                                        <textarea class="FrameGroupInput uparname" name="participants"><?php echo $result['participants'] ?></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="FrameGroupName">会议说明</td>
                                    <td colspan='3'><textarea class="FrameGroupInput" name="content"><?php echo $result['content'] ?></textarea></td>
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
</html>
<script>
                    
                    $(function() {
                        jeDate({
                            dateCell: "#statdt", //isinitVal:true,
                            format: "YYYY-MM-DD",
                            isTime: false, //isClear:false,
                        })

                        jeDate({
                            dateCell: "#enddt", //isinitVal:true,
                            format: "YYYY-MM-DD",
                            isTime: false, //isClear:false,
                        })
                    });
                    $(function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                        window.onresize = function() {
                            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                        };
                        $('.addFile').click(function() {
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
                        loading();
                        $.ajax({
                            cache: false,
                            type: "POST",
                            url: "<?php echo spUrl($c, "saveConference"); ?>",
                            data: $('#check_form').serialize(),
                            dataType: "json",
                            async: false,
                            error: function(request) {
                                loading('none');
                                Alert('提交失败');
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    loading('none');
                                     
                                    Refresh();
                                    Alert(data.msg);
                                    parent.window.closHtml();
                                } else {
                                    Alert(data.msg);
                                    loading('none');
                                }

                            }
                        });
                    }
</script>