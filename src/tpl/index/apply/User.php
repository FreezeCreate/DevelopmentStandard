<?php
require_once TPL_DIR . '/layout/con_header.php';
 ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div class="MainHtml">
		<div class="framemain">
			<div class="FrameTableTitl">
				员工详情
			</div>
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
					<td class="FrameGroupName"><i class="colorRed">*</i>部门 ：</td>
					<td>
						<?php echo $per_user['dname'];?></td>
				</tr>


				<tr>
					<td class="FrameGroupName"><i class="colorRed">*</i>职位 ：</td>
					<td>
						<?php echo $per_user['pname'];?></td>
				</tr>
				<tr>
					<td class="FrameGroupName">直属上级 ：</td>
					<td>
						<?php echo $per_user['dname'];?>
					</td>
					<td class="FrameGroupName">员工状态 ：</td>
					<td>
						<?php
							switch($per_user['dir'])
							{
								case 1:
									echo '试用期';
									break;
								case 2:
									echo '正式';
									break;
								case 3:
									echo '实习生';
									break;
								case 4:
									echo '兼职';
									break;
								case 5:
									echo '合同工';
									break;
								case 6:
									echo '离职';
									break;
								default:
									echo '正式';
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">入职日期：</td>
					<td>
						<?php echo $per_user['entrydt'];?>
					</td>
					<td class="FrameGroupName">转正日期 ：</td>
					<td>
						<?php echo $per_user['positivedt'];?>
					</td>
				</tr>
				<tr>
					<td class="FrameGroupName">菜单角色：</td>
					<td colspan="3">
						<?php echo $per_user['role'];?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
