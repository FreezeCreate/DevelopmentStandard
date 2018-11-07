

	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">审核详情</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3">张三</td>
					</tr>
					<tr>
						<td class="FrameGroupName">标题 ：</td>
						<td colspan="3">某某项目</td>
					</tr>
					<tr>
						<td class="FrameGroupName">说明 ：</td>
						<td colspan="3">
							说明文本说明文本说明文本说明文本说明文本说明文本说明文本
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">分配给 ：</td>
						<td colspan="3">李四</td>
					</tr>
					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox">
								<li class="FileItem"><span class="FileItemNam colorBlu">temp.jpg</span></li>
								<li class="FileItem"><span class="FileItemNam colorBlu">temp.jpg</span></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">开始时间：</td>
						<td>2018-03-05</td>
						<td class="FrameGroupName">截止时间 ：</td>
						<td>2018-05-06</td>
					</tr>
				</table>
				<div class="top20">
					<p class="taskjl">处理记录</p>
					<table class="table borderTr">
						<thead>
							<tr class="tablebg"><th>序号</th><th>操作人</th><th>操作状态</th><th>说明</th><th>时间</th></tr>
						</thead>
						<tbody class="textCenter hover">
							<tr><td>1</td><td>张三</td><td>提交</td><td>说明</td><td>2018-06-02</td></tr>
							<tr><td>1</td><td>张三</td><td>已完成</td><td>说明</td><td>2018-06-02</th></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
