
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="/source/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>
	<script>
		var Use;
		$.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
			Use = data;
//              alert(Use);
		}, 'json');
	</script>
	</head>
	<body>
		<div class="MainHtml">
			<form action="" method="" id="check_form" onsubmit="return false;" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
			<div class="framemain">
				<div class="FrameTableTitl">添加任务</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><input class="input long" type="text" name="" id="" value="<?php echo $user['name']?>" readonly="readonly"/></td>
					</tr>
					<tr>
						<td class="FrameGroupName"><i class="colorRed">*</i>标题 ：</td>
						<td colspan="3"><input class="input long" type="text" name="title" id="" value="" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName">分配给 ：</td>
						<td colspan="3">
							<input class="input long text1" type="text" name="distname" id="" value="" readonly="readonly"/>
							<input class="text2" type="hidden" name="distid" id="" value="" />
							<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'one', '.text1', '.text2', this)">选择</span>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">开始时间：</td>
						<td><input class="input dates" type="text" name="start" readonly="readonly" placeholder="点击选择"/></td>
						<td class="FrameGroupName">截止时间 ：</td>
						<td><input class="input dates" type="text" name="end" readonly="readonly" placeholder="点击选择" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName">说明 ：</td>
						<td colspan="3">
							<textarea rows="4" class="input" name="content"></textarea>
						</td>
					</tr>
<!--					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox"></ul>
							<span class="None addFile">+添加文件</span>
							<input type="file" class="addFileVal" name="files" id="files" >
						</td>
					</tr>-->
					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox"></ul>
							<input class="None addFileVal" type="file" name="files" id="files" />
							<span class="addFile">+添加文件</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="frameFoot">
				<span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">确定</span>
				<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
			</div>
			</form>
		</div>
	</body>
</html>
<script type="text/javascript">
	jeDate({
		dateCell:".dates",
		format:"YYYY-MM-DD",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){/*alert(val)*/}
	})
	$('.addFile').click(function() {
		$(this).prev().click()
	})
/*	$('.addFileVal').change(function() {
		$th = $(this);
		$.ajaxFileUpload({
			url: "<?php echo spUrl('uplaodimage', "uploadFile"); ?>",
			secureuri: false,
			fileElementId: 'files',
			dataType: 'json',
			data: {name: 'files', id: 'files'},
			success: function(data, status) {
				if (data.status == 1) {
					$th.parent().children('.FileBox').append(
						'<li class="FileItem"><span class="FileItemNam">' + data.msg + '</span><span class="DelFile">删除</span></li>'
					)
				} else {
					Alert(data.msg);
				}
			},
			error: function(data, status, e) {
				Alert(e);
			}


		});
		$th.val('');
		return false;
	})*/
	$(document).on('change', '.addFileVal', function() {
		$.ajaxFileUpload({
			url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
			secureuri: false,
			fileElementId: 'files',
			dataType: 'json',
			data: {name: 'files', id: 'files'},
			success: function(data, status) {
				console.log(data)
				if (data.status == 1) {
					$('#files').parent().children('.FileBox').append(
						'<li class="FileItem"><span class="FileItemNam">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>'
					)
					$('#files').val('');
				} else {
					Alert(data.msg);
				}
			},
			error: function(data, status, e) {
				Alert(e);
			}
		});
		return false;
	});

	$(document).on('click', '.DelFile', function(){
		var that = this;
		Confirm('确定删除？', function(e){
			if(e){
				$(that).parent().remove()
			}
		})
	})

	function do_sub() {
		//var formData = new FormData($("#upload")[0]);
		$.ajax({
			cache: false,
			type: "POST",
			url: "<?php echo spUrl($c, "addTask"); ?>",
			data: $('#check_form').serialize(),
			//data: formData,
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

	$('#upload1').change(function() {

	});

</script>