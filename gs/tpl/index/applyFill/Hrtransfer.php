<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>人事调动</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">人事调动</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">人事调动</div>
                            <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 要调动人</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="tranuname" placeholder="" value="<?php echo $result['tranuname'] ?>"/>
                                    <input type="hidden" class="uid" name="tranuid" value="<?php echo $result['tranuid'] ?>"/>
                                    <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 调动类型</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">请选择...</option>
                                        <option <?php echo $result['type']==='平调'?'selected=""':''; ?> value="平调">平调</option>
                                        <option <?php echo $result['type']==='晋升'?'selected=""':''; ?> value="晋升">晋升</option>
                                        <option <?php echo $result['type']==='降职'?'selected=""':''; ?> value="降职">降职</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 调动后部门</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="eudept" placeholder="" value="<?php echo $result['eudept'] ?>"/>
                                    <input type="hidden" class="uid" name="eudeptid" value="<?php echo $result['eudeptid'] ?>"/>
                                    <a class="Btn" onclick="ChousPerson(Dep, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 调动后职位</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="eposition" placeholder="" value="<?php echo $result['eposition'] ?>"/>
                                    <input type="hidden" class="uid" name="epositionid" value="<?php echo $result['epositionid'] ?>"/>
                                    <a class="Btn" onclick="ChousPerson(Pos, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
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
<script type="text/javascript">
        var Use;
        var Pos;
        var Dep;
        $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
            Use = {}
            Use.status = 2;
            Use.data = data.data[0].children;
        }, 'json');
            //职位
            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
                    Pos = data;
            }, 'json');
            //部门
            $.get('<?php  echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
                    Dep = data;
            }, 'json');
    </script>
<script>
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
            url: "<?php echo spUrl($c, "saveHrtransfer"); ?>",
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