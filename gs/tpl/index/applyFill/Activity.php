<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>活动</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">活动</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">活动</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 活动主题</td>
                                    <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                                    <td class="FrameGroupName">类别</td>
                                    <td>
                                        <select class="FrameGroupInput" name="cate">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['ACTIVITY'] as $key => $value) { ?>
                                        <option value='<?php echo $key;?>' <?php if($result['cate'] == $key){?>selected<?php } ?> ><?php echo $value;?></option>
                                        <?php } ?>  
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 开始日期</td>
                                    <td><input type="text" class="FrameGroupInput" id="statdt" name="statdt" value="<?php echo $result['statdt'] ?>"/></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 结束日期</td>
                                    <td><input type="text" class="FrameGroupInput" id="enddt" name="enddt" value="<?php echo $result['enddt'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 活动地点</td>
                                    <td colspan='3'><input style='width:90%' type="text" class="FrameGroupInput" name='address' value="<?php echo $result['address'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style='color:red'>*</span>活动所需</td>
                                    <td colspan='3'><textarea class="FrameGroupInput" name="prepare"><?php echo $result['prepare']?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">活动背景</td>
                                    <td colspan='3'><textarea class="FrameGroupInput" name="content"><?php echo $result['content']?></textarea></td>
                                </tr>

                                <tr>
                                    <td class="FrameGroupName">线路说明</td>
                                    <td colspan='3'><textarea class="FrameGroupInput" name="luxian"><?php echo $result['luxian']?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 预算费用</td>
                                    <td><input type="text" class="FrameGroupInput" name="ymoney" value="<?php echo $result['ymoney'] ?>"/></td>
                                    <td class="FrameGroupName"> 实际费用</td>
                                    <td><input type="text" class="FrameGroupInput" name="money" value="<?php echo $result['money'] ?>"/></td>
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
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveActivity"); ?>",
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