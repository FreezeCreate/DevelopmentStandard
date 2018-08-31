	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">任务详情</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><?php echo $result['uname']; ?></td>
					</tr>
					<tr>
						<td class="FrameGroupName">标题 ：</td>
						<td colspan="3"><?php echo $result['title']; ?></td>
					</tr>
					<tr>
						<td class="FrameGroupName">说明 ：</td>
						<td colspan="3">
							<?php echo $result['content']; ?>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">分配给 ：</td>
						<td colspan="3"><?php echo $result['distname']; ?></td>
					</tr>
					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox">
								<?php
									foreach($result['files'] as $_v){
										echo '<li class="FileItem"><span class="FileItemNam colorBlu"><a itemid="'.$_v['id'].'" class="download">'.$_v['filename'].'</a></span></li>';
									}
								?>
							</ul>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">开始时间：</td>
						<td><?php echo $result['start']; ?></td>
						<td class="FrameGroupName">截止时间 ：</td>
						<td><?php echo $result['end']; ?></td>
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
			</div>
		</div>
	</body>
</html>
