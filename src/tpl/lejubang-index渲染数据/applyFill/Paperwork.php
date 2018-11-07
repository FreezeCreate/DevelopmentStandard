<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>证件</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
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
			<div class="FrameTit"><span class="FrameTitName">证件</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
					<div class="FrameTable">
						<form id="check_form">
							<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
							<table class="FrameTableCont">
								<tbody>
									<tr>
										<td class="FrameGroupName"><span style="color:red;">*</span> 证件名称：</td>
										<td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
										<td class="FrameGroupName"><span style="color:red;">*</span> 证件类型：</td>
										<td>
											<select class="FrameGroupInput" name="type">
												<option value="">请选择...</option>
												<?php foreach ($GLOBALS['PAPER_TYPE'] as $v) { ?>
													<option <?php echo $v === $result['type'] ? 'selected=""' : '' ?> value="<?php echo $v ?>"><?php echo $v ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="FrameGroupName"><span style="color:red;">*</span> 持证人</td>
										<td>
                                            <input class="FrameGroupInput uname" type="text" readonly="readonly" name="uname" placeholder="" value="<?php echo $result['uname'] ?>"/>
                                            <input type="hidden" class="uid" name="uid" value="<?php echo $result['uid'] ?>"/>
                                            <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
										</td>
										<td class="FrameGroupName">证件编号</td>
										<td><input type="text" class="FrameGroupInput" id="number" name="number" value="<?php echo $result['number'] ?>"/></td>
									</tr>
									<tr>
										<td class="FrameGroupName">证件照片</td>
										<td colspan="3">
                                                <input type="file" class="fileToUpload2" style="display:none;" name="fileToUpload2" id="fileToUpload2"/>
                                                <div class="upimg" onclick="$('#fileToUpload2').click()">
                                                    <img width="100px" height="100px"  src="<?php echo empty($result['image'])?SOURCE_PATH.'/images/liaotshi_78.png':$result['image']; ?>"/>
                                                    <input type="hidden" name="image" value="<?php echo empty($result['image'])?'':$result['image']; ?>"/>
                                                </div>
										</td>
									</tr>
									<tr>
										<td class="FrameGroupName">说明</td>
										<td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
		</div>
			 <div class="FrameTableFoot">
                        <a class="but but-primary" onclick="do_sub()"><span class="Btn Big"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
           </div>
		</div>
		

    </body>

</html>

<script>
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        };

    $(document).on('change', '.fileToUpload2', function() {
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
                Alert(e);
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
                    Alert(data.msg);
                }
            },
        });
        return false;
    });


		




    function do_sub() {
     //   loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savePaperwork"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                   // loading('none');
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                 //   loading('none');
                }

            }
        });
    }
	
		$('.close').click(function(){
		$('.PersonBox').animate({'top': '-500px'},300,function(){
			$('.Person').hide()
		})
	})
</script>