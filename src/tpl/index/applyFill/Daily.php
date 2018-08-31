
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		
		<!--<script src="<?php /*echo SOURCE_PATH; */?>/js/data.js" type="text/javascript" charset="utf-8"></script>-->
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
			<form action="" method="" id="check_form" onsubmit="return false;">
			<div class="framemain">
				<div class="FrameTableTitl">添加工作日报</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><input class="input long" type="text" name="uname" id="" value="<?php echo $user['dname']?>" readonly="readonly" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName"><i class="colorRed">*</i>汇报类型：</td>
						<td colspan="3">
							<select name="type" class="input">
								<option value="日报">日报</option>
								<option value="月报">月报</option>
								<option value="周报">周报</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">汇报日期 ：</td>
						<td colspan="3">
							<input class="input dates" type="text" name="date" readonly="readonly" placeholder="点击选择"/>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">内容 ：</td>
						<td colspan="3">
							<textarea rows="4" name="content" class="input"></textarea>
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
	$('.addFileVal').change(function() {
		var val = $(this).val().slice($(this).val().lastIndexOf('\\') + 1);
		$(this).parent().children('.FileBox').append(
			'<li class="FileItem"><span class="FileItemNam">' + val + '</span><span class="DelFile">删除</span></li>'
		)
		$(this).val('')
	})
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
			url: "<?php echo spUrl($c, "adddatwork"); ?>",
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
</script>