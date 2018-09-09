<?php
require_once TPL_DIR . '/layout/con_header.php';
 ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div class="MainHtml">
		<div class="framemain">
			<div class="FrameTableTitl">
				添加员工
			</div>
			<table class="FrameTableCont">
				<tr>
					<td class="FrameGroupName">编号 ：</td>
					<td>
						<input class="input" type="text" name="" id="" value="" />
					</td>
					<td class="FrameGroupName" rowspan="2">头像 ：</td>
					<td rowspan="2">
						<img class="userImg" src="<?php echo SOURCE_PATH; ?>/images/user/user.png" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">姓名 ：</td>
					<td>
						<input class="input" type="text" name="" id="" value="" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">登录账号 ：</td>
					<td>
						<input class="input" type="text" name="" id="" value="" />
					</td>
					<td class="FrameGroupName">登录密码 ：</td>
					<td>
						<input class="input" type="text" name="" id="" value="" placeholder="不填默认123456"/>
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">性别 ：</td>
					<td>
						<select name=""class="input">
							<option value="">男</option>
							<option value="">女</option>
						</select></td>
					<td class="FrameGroupName">登录权限 ：</td>
					<td><label> <span class="checkbox">允许登录</span>
						<input type="checkbox" class="None" name="" id="" value="" />
						</label></td>
				</tr>
				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>手机号 ：</td>
					<td>
						<input type="text"class="input" name="" id="" value="" />
					</td>
					<td class="FrameGroupName">短号 ：</td>
					<td>
						<input type="text"class="input" name="" id="" value="" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">身份证号 ：</td>
					<td>
						<input type="text"class="input" name="" id="" value="" />
					</td>
					<td class="FrameGroupName">生日 ：</td>
					<td>
						<input type="text"class="input" name="" id="" value="" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>部门 ：</td>
					<td>
						<select name=""class="input">
							<option value="">技术部</option>
							<option value="">行政部</option>
							<option value="">商务部</option>
						</select></td>
					<td class="FrameGroupName"><i class="colorRed">*</i>职位 ：</td>
					<td>
						<select name=""class="input">
							<option value="">技术部</option>
							<option value="">行政部</option>
							<option value="">商务部</option>
						</select></td>
				</tr>
				<tr>
					<td class="FrameGroupName">直属上级 ：</td>
					<td>
						<input class="input text1" type="text" name="" id="" value="" />
						<input class="text2" type="hidden" name="" id="" value="" />
						<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span></td>
					<td class="FrameGroupName">员工状态 ：</td>
					<td>
						<select name=""class="input">
							<option value="">入职</option>
							<option value="">入职</option>
						</select></td>
				</tr>
				<tr>
					<td class="FrameGroupName">入职日期：</td>
					<td>
						<input class="input dates" type="text" readonly="readonly" />
					</td>
					<td class="FrameGroupName">转正日期 ：</td>
					<td>
						<input class="input dates" type="text" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">离职日期：</td>
					<td>
						<input class="input dates" type="text" readonly="readonly" />
					</td>
					<td class="FrameGroupName">邮箱：</td>
					<td>
						<input type="text"class="input" name="" id="" value="" />
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">QQ：</td>
					<td>
						<input class="input" type="text"  />
					</td>
					<td class="FrameGroupName"></td>
					<td></td>
				</tr>
				<tr>
					<td class="FrameGroupName">菜单角色：</td>
					<td colspan="3">
						<label for="q2">
							<span class="radio" data-val="2">管理员</span>
							<input type="radio" class="None" name="role" id="q2" value="2" data-type="type">
						</label>
						<label for="q3">
							<span class="radio" data-val="3">人事管理</span>
							<input type="radio" class="None" name="role" id="q3" value="3" data-type="type">
						</label>
						<label for="q4">
							<span class="radio" data-val="4">行政管理</span>
							<input type="radio" class="None" name="role" id="q4" value="4" data-type="type">
						</label>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
