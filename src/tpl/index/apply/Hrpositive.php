	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
	<script src="/source/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>

	</head>
	<style type="text/css">
		.color-green{
			color: green;
		}
		.color-red{
			color: red;
		}
		
	</style>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">转正申请</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">申请时间：</td>
						<td><?php echo $result['applydt'] ?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="FrameGroupName">申请人：</td>
						<td><?php echo $result['uname'] ?></td>
						<td class="FrameGroupName">部门：</td>
						<td><?php echo $result['dname'] ?></td>
					</tr>
					<tr>
						<td class="FrameGroupName">入职日期：</td>
						<td><?php echo $result['entrydt'] ?></td>
						<td class="FrameGroupName">转正日期：</td>
						<td><?php echo $result['positivedt'];?></td>
					</tr>
					<tr>
						<td class="FrameGroupName"> 说明：</td>
						<td colspan="3"><?php echo $result['explain'] ?></td>
					</tr>
					<tr>
						<td class="FrameGroupName"> 相关文件：</td>
						<td colspan="3">
							<?php foreach ($result['files'] as $v) { ?>
							<div class="download"><a class="download-a FileItemNam colorBlu" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a>
								<?php } ?>
						</td>
					</tr>
				</table>
				<div class="top20">
					<p class="taskjl">处理记录</p>
					<table class="table borderTr">
						<thead>
							<tr class="tablebg"><th>序号</th><th>操作人</th><th>操作状态</th><th>说明</th><th>时间</th></tr>
						</thead>
						<tbody class="textCenter hover">
							<?php
								foreach($log as $log_k => $log_v){
									echo '<tr><td>'.($log_k + 1).'</td><td>'.$log_v['checkname'].'</td><td>'.$log_v['statusname'].'</td><td>'.$log_v['explain'].'</td><td>'.$log_v['optdt'].'</td></tr>';
								}
							?>
						</tbody>
					</table>
				</div>
<?php //dump($user);die;?>
				<?php if (in_array($user['id'], $bill['nowcheckid'])) { ?>


					<div class="FrameListTable">
						<div class="FrameTableTitl">审核处理</div>
						<form id="check_form">
							<input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
							<table  class="FrameTableCont">
								<thead>
								<tr>
									<td class="FrameGroupName">状态：</td>
									<td class="">待<?php echo $bill['nowcheckname'] ?>处理</td>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td class="FrameGroupName">处理流程：</td>
									<td><?php echo $course['name'] ?></td>
								</tr>
								<tr>
									<td class="FrameGroupName"><span style="color:red;">*</span> 处理人：</td>
									<td><?php echo $user['name'] ?></td>
								</tr>
								<tr>
									<td class="FrameGroupName"><span style="color:red;">*</span> 处理动作：</td>
									<td>
										<?php foreach ($course['courseact'] as $v) { ?>
											<label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td class="FrameGroupName">申请说明 ：</td>
									<td colspan="3">
										<textarea rows="4" name="checksm" class="input"></textarea>
									</td>
								</tr>

								<tr>
									<td class="FrameGroupName">相关文件 ：</td>
									<td colspan="3">
										<ul class="FileBox">
										</ul>
										<input class="None addFileVal" type="file" name="files" id="files" />
										<span class="addFile">+添加文件</span>
									</td>
								</tr>

								<!--<tr>
									<td></td>
									<td><a class="Btn Btn-info" onclick="do_sub()">提交处理</a></td>
								</tr>-->
								<div class="frameFoot">
									<span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">提交处理</span>
									<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
								</div>
								</tbody>
							</table>
						</form>
					</div>
				<?php } ?>

			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
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
		loading();
		$.ajax({
			cache: false,
			type: "POST",
			url: "<?php echo spUrl($c, "saveCheck"); ?>",
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
					Alert(data.msg, function(){
						parent.window.closHtml();
						Refresh();
					});
//					parent.window.closHtml();
//					Refresh();
				} else {
					Alert(data.msg);
					loading('none');
				}

			}
		});
	}

</script>