<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>案例管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
        <style type="text/css">
        .upimg img{width: 100px;height: 100px;}
        </style>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">案例管理</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">案例管理</div>
                            <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName" style="width: 80px;"><span style="color:red;">*</span> 类别</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['CASETYPE'] as $key => $value) { ?>
                                        <option value='<?php echo $key;?>' <?php if($result['cate'] == $key){?>selected<?php } ?> ><?php echo $value;?></option>
                                        <?php } ?>  
                                    </select>
                                </td>
                                <td class="FrameGroupName" style="width: 80px;"><span style="color:red;">*</span> 类型</td>
                                <td>
                                    <select class="FrameGroupInput" name="cate">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['CASEBASE'] as $key => $value) { ?>
                                        <option value='<?php echo $key;?>' <?php if($result['cate'] == $key){?>selected<?php } ?> ><?php echo $value;?></option>
                                        <?php } ?>  
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span>案例名称</td>
                                <td><input type="text" class="FrameGroupInput" name="name" value="<?php echo $result['name'] ?>"/></td>
                                <td class="FrameGroupName"> 工期</td>
                                <td><input type="text" class="FrameGroupInput" name="cycle" value="<?php echo $result['cycle'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">链接地址</td>
                                <td colspan="3"><input type="text" class="FrameGroupInput" name="url" style="width:90%" value="<?php echo $result['url'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">二维码</td>
                                <td>
                                    <input type="file" class="scimage" style="display:none;" name="fileToUpload2" id="fileToUpload2"/>
                                    <div class="upimg" onclick="$('#fileToUpload2').click()"><img src="<?php echo empty($result['erweima'])?SOURCE_PATH.'/images/liaotshi_78.png':$result['erweima']; ?>"/><input type="hidden" name="erweima" value="<?php echo empty($result['erweima'])?'':$result['erweima']; ?>"/></div>
                                </td>
                                <td class="FrameGroupName">案例展示图</td>
                                <td>
                                    <input type="file" class="scimage" style="display:none;" name="fileToUpload3" id="fileToUpload3"/>
                                    <div class="upimg" onclick="$('#fileToUpload3').click()"><img src="<?php echo empty($result['image'])?SOURCE_PATH.'/images/liaotshi_78.png':$result['image']; ?>"/><input type="hidden" name="image" value="<?php echo empty($result['image'])?'':$result['image']; ?>"/></div>
                                </td>
                            </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 备注</td>
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
$(function() {
    $(document).on('change', '.scimage', function() {
        loading();
        var name = $(this).attr('name');
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "upload"); ?>',
            secureuri: false,
            fileElementId: name,
            dataType: 'json',
            data: {name: name, id: name},
            error: function(data, status, e) {
                loading('none');
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    var src = '/tmp/' + data.src;
                    $('#' + name).next('.upimg').children('img').attr('src', src);
                    $('#' + name).next('.upimg').children('input').val(src);
                    loading('none');
                } else {
                    $('#' + name).val('');
                    loading('none');
                    alert(data.msg);
                }
            },
        });
        return false;
    });


    $(document).on('change', '.scfile', function() {
        loading();
        var name = $(this).attr('name');
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
            secureuri: false,
            fileElementId: name,
            dataType: 'json',
            data: {name: name, id: name},
            error: function(data, status, e) {
                loading('none');
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    var txt = '<div class="download"><a class="download-a" itemid="' + data.data.id + '" href="javascript:void(0)">' + data.data.filename + '</a><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="del">删除</span></div>';
                    $('#' + name).val('');
                    $('#' + name).before(txt);
                    loading('none');
                } else {
                    $('#' + name).val('');
                    loading('none');
                    alert(data.msg);
                }
            },
        });
        return false;
    });
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
            url: "<?php echo spUrl($c, "saveCaseBase"); ?>",
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