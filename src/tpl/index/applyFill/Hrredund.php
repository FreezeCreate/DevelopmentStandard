
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="/source/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>

	<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<form action="" method="" id="check_form" onsubmit="return false;" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
				<div class="framemain">
				<div class="FrameTableTitl">离职申请</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><input class="input long" type="text" name="uname" id="" value="<?php echo $user['cname']?>" readonly="readonly" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName">所在部门 ：</td>
						<td colspan="3"><input class="input long" type="text" name="" id="" value="<?php echo $user['dname']?>" readonly="readonly" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName">职位 ：</td>
						<td colspan="3">
							<input class="input long text1" type="text" name="position" id="" value="<?php echo $user['pname']?>" readonly="readonly" />
							<input class="text2" type="hidden" name="" id="" value="" />
							<!--<span class="btn btn-sm btn-success"onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)">选择</span>-->
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">离职类型 ：</td>
						<td colspan="3">
							<select name="type"class="input">
								<option <?php echo $result['type']==='自动离职'?'selected=""':''; ?> value="自动离职">自动离职</option>
								<option <?php echo $result['type']==='退休'?'selected=""':''; ?> value="退休">退休</option>
								<option <?php echo $result['type']==='病辞'?'selected=""':''; ?> value="病辞">病辞</option>
								<option <?php echo $result['type']==='辞退'?'selected=""':''; ?> value="辞退">辞退</option>
								<option <?php echo $result['type']==='辞职'?'selected=""':''; ?> value="辞职">辞职</option>

							</select>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">入职日期：</td>
						<td><input class="input dates" type="text" name="entrydt" readonly="readonly" value="<?php echo empty($result['entrydt']) ? '' : $result['entrydt'] ?>" placeholder="点击选择"/></td>
						<td class="FrameGroupName">离职日期 ：</td>
						<td><input class="input dates" type="text" name="leavedt" readonly="readonly" value="<?php echo empty($result['leavedt']) ? '' : $result['leavedt'] ?>" placeholder="点击选择"/></td>
					</tr>
					<tr>
						<td class="FrameGroupName">离职说明 ：</td>
						<td colspan="3">
							<textarea rows="4" name="cause" class="input"><?php echo $result['cause'] ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox">
								<?php foreach ($result['files'] as $v) { ?>
									<li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="DelFile">删除</span></li>
								<?php } ?>
							</ul>
							<input class="None addFileVal" type="file" name="files" id="files" value="" />
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
			url: "<?php echo spUrl($c, "addleave"); ?>",
			data: $('#check_form').serialize(),
			//data: formData,
			dataType: "json",
			async: false,
			error: function(request) {
				Alert('提交失败');
			},
			success: function(data) {
				if (data.code == 0) {
					Alert(data.msg, function(){
						parent.window.closHtml();
						Refresh();
					});
				} else {
					Alert(data.msg);
				}

			}
		});
	}
</script>