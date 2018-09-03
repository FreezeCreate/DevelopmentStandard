<?php
require_once TPL_DIR . '/layout/con_header.php';
 ?>

<script src="<?php echo SOURCE_PATH ?>/js/addpower.js" type="text/javascript" charset="utf-8"></script>
<script>
	var Use;
	$.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
		Use = data;
	}, 'json');
</script>
</head>
<body>
	<div class="MainHtml">
		<div class="framemain">
			<div class="FrameTableTitl">
				编辑员工
			</div>
			<form action="" method="" id="check_form" onsubmit="return false;">
			<input type="hidden" name="id" value="<?php echo $per_user['id'];?>" />
			<table class="FrameTableCont">
				<tr>
					<td class="FrameGroupName">姓名 ：</td>
					<td>
						<?php echo $per_user['name']?>
					</td>
					<td class="FrameGroupName" rowspan="1">头像 ：</td>
					<td rowspan="2">
						<img class="userImg" src="<?php echo $per_user['head']?>" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">登录账号 ：</td>
					<td>
						<?php echo $per_user['username']?></td>
				</tr>
				<tr>
					<td class="FrameGroupName">身份证号 ：</td>
					<td>
						<?php echo $per_user['idcardnumber']?>
					</td>
					<td class="FrameGroupName" rowspan="1">身份证照片 ：</td>
					<td rowspan="2">
						<img class="userImg" src="<?php echo $per_user['idcard']?>" />
					</td>
				</tr>

				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>手机号 ：</td>
					<td>
						<?php echo $per_user['phone']?>
					</td>

				</tr>

				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>所属公司 ：</td>
					<td>
						<?php echo $per_user['cname']?>
					</td>
				</tr>



				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>部门 ：</td>
					<td>
						<input type="hidden" name="did" value="<?php echo $result['did'];?>" />
						<select name="dname"class="input">
							<?php
								foreach($dep as $dep_v){
									echo '<option '.($result['did'] == $dep_v['id'] ? 'selected="selected"' : '').' value="'.$dep_v['name'].'">'.$dep_v['name'].'</option>';
								}
							?>
						</select></td>
					<td class="FrameGroupName"><i class="colorRed">*</i>职位 ：</td>
					<td>
						<input type="hidden" name="pid" value="<?php echo $result['pid'];?>" />
						<select name="pname"class="input">
							<?php
								foreach($pos as $pos_v){
									echo '<option '.($result['pid'] == $pos_v['id'] ? 'selected="selected"' : '').' value="'.$pos_v['name'].'">'.$pos_v['name'].'</option>';
								}
							?>
						</select></td>
				</tr>
				<tr>
					<td class="FrameGroupName">直属上级 ：</td>
					<td>
						<input class="input text1" type="text" name="sname" id="" value="<?php echo $result['sname']?>" />
						<input class="text2" type="hidden" name="superior" id="" value="<?php echo $result['superior']?>" />
						<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'one', '.text1', '.text2', this)">选择</span></td>
					<td class="FrameGroupName">员工状态 ：</td>
					<td>
						<select name=""class="input">
							<?php
								foreach($GLOBALS['USER_DIR'] as $_userk => $_userv){
									echo '<option '.($dir_name == $_userv ? 'selected="selected"' : '').' value="'.$_userk.'">'.$_userv.'</option>';
								}
							?>
						</select></td>
				</tr>
				<tr>
					<td class="FrameGroupName">入职日期：</td>
					<td>
						<input class="input dates" type="text" name="entrydt" value="<?php echo $result['entrydt'];?>" readonly="readonly" />
					</td>
					<td class="FrameGroupName">转正日期 ：</td>
					<td>
						<input class="input dates" type="text" name="positivedt" value="<?php echo $result['positivedt'];?>" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">菜单角色：</td>
					<td colspan="3">
						<?php
							foreach($role as $ro_k => $ro_v){
								foreach($my_role as $ro_my){
									if($ro_my == $ro_v['id']){
										$select = 'checked="checked"';
										break;
									}else{
										$select = '';
									}
								}
								echo '
									<label>
										<span class="checkbox '.(empty($select) ? '' : 'active').'">'.$ro_v['name'].'</span>
										<input type="checkbox" '.$select.' class="None" name="role[]" id="q'.$ro_k.'" value="'.$ro_v['id'].'" data-type="type">
									</label>
								';
							}
						?>
						<!--<label for="q3">
							<span class="radio" data-val="3">人事管理</span>
							<input type="radio" class="None" name="role" id="q3" value="3" data-type="type">
						</label>
						<label for="q4">
							<span class="radio" data-val="4">行政管理</span>
							<input type="radio" class="None" name="role" id="q4" value="4" data-type="type">
						</label>-->
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">用户操作：</td>
					<td colspan="3">
						<?php
							foreach($GLOBALS['USER_OPERATE'] as $ope_k => $ope_v){
								foreach($my_ope as $ope_my){
									if($ope_my == $ope_k){
										$select = 'checked="checked"';
										break;
									}else{
										$select = '';
									}
								}

								echo '
									<label for="q2">
										<span class="checkbox '.(empty($select) ? '' : 'active').'" data-val="'.$ope_k.'">'.$ope_v.'</span>
										<input type="checkbox" '.$select.' class="None" name="operate[]" id="q'.$ope_k.'" value="'.$ope_k.'" data-type="type">
									</label>
								';
							}
						?>
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div class="frameFoot">
			<span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">确定</span>
			<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">jeDate({
	dateCell: ".dates",
	format: "YYYY-MM-DD",
	isinitVal: false,
	isTime: true, //isClear:false,
	minDate: "2014-09-19 00:00:00",
	okfun: function(val) { /*alert(val)*/ }
})

	function do_sub() {
		//var formData = new FormData($("#upload")[0]);
		$.ajax({
			cache: false,
			type: "POST",
			url: "<?php echo spUrl($c, "updateuser"); ?>",
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