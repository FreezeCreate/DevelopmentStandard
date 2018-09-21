<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>证件申请</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="Frame">
			<div class="FrameTit"><span class="FrameTitName">证件申请</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">证件申请</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">编号：</td>
                                <td><?php echo $result['number']?></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 申请人：</td>
                                <td><?php echo $result['uname']?$result['uname']:$admin['name']?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 申请证件：</td>
                                <td colspan="3" >
                                    <select class="FrameGroupInput" name="gid">
                                        <option value="">请选择...</option>
                                        <?php foreach ($paperworks as $v) { ?>
                                            <option <?php echo $v['id'] === $result['gid'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">说明</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">相关文件</td>
                                <td colspan="3">
                                    <?php foreach($result['files'] as $v){?>
                                    <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id']?>"><?php echo $v['filename']?></a><input type="hidden" name="files[]" value="<?php echo $v['id']?>"/><span class="del">删除</span></div>
                                    <?php }?>
									 <ul class="FileBox"></ul>
									<input type="file" class="None addFileVal fileToUpload"    name="fileToUpload1" id="fileToUpload1" />
									<span class="addFile" onclick="$('#fileToUpload1').click()">+添加文件</span>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
			<div class="FrameTableFoot">
				<a class="but but-primary" ><span class="Btn Big" onclick="do_sub()"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
			</div>
		</div>
    </body>

</html>

<script>

    $(function() {
        $(document).on('change', '.fileToUpload', function() {
           // loading();
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                   // loading('none');
                    alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam">' + data.data.filename + '</span><span class="DelFile">删除</span><input type="hidden" id="file" name="files[]" value="' + data.data.id + '"/></li>';
                        $('.FileBox').html(txt);
                       // loading('none');
                    } else {
                        $('#' + name).val('');
                       // loading('none');
                        alert(data.msg);
                    }
                },
            });
            return false;
        });

    });

    function do_sub() {
       // loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savePaperworkapl"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
               // loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                  //  loading('none');
                     
                    Refresh();
                } else {
                    alert(data.msg);
                   // loading('none');
                }

            }
        });
    }
</script>