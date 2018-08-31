	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">办公用品申请</div>
				<table class="FrameTableCont">
					<tbody>
					<tr>
						<td class="tit01">编号：</td>
						<td><?php echo $result['number'] ?></td>
						<td class="tit01">申请时间：</td>
						<td><?php echo $result['applydt'] ?></td>
					</tr>
					<tr>
						<td class="tit01">申请人：</td>
						<td><?php echo $result['uname'] ?></td>
						<td class="tit01">部门：</td>
						<td><?php echo $result['dname'] ?></td>
					</tr>
					<tr>
						<td class="tit01">物品：</td>
						<td><?php echo $result['gname'] ?></td>
						<td class="tit01">数量：</td>
						<td><?php echo $result['num'];?></td>
					</tr>
					<tr>
						<td class="tit01"> 说明：</td>
						<td colspan="3"><?php echo $result['explain'] ?></td>
					</tr>
					</tbody>
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
			</div>
		</div>
	</body>
</html>


