

	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">调动详情</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">调动人员 ：</td>
						<td>张三</td>
						<td class="FrameGroupName">调动类型 ：</td>
						<td>上级调动</td>
					</tr>
					<tr>
						<td class="FrameGroupName">调动前部门 ：</td>
						<td>技术一部</td>
						<td class="FrameGroupName">调动后部门 ：</td>
						<td>技术二部</td>
					</tr>
					<tr>
						<td class="FrameGroupName">调动前部职位：</td>
						<td>PHP工程师</td>
						<td class="FrameGroupName">调动后职位 ：</td>
						<td>PHP工程师</td>
					</tr>
					<tr>
						<td class="FrameGroupName">申请说明 ：</td>
						<td colspan="3">
							申请说明申请说明申请说明申请说明申请说明申请说明申请说明
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">相关文件 ：</td>
						<td colspan="3">
							<ul class="FileBox">
								<li class="FileItem"><span class="colorBlu NewPop" data-url="<?php echo spUrl('apply', 'img')?>" data-title="查看图片" data-type="img" data-src="<?php echo SOURCE_PATH; ?>/images/login/login_bg.png">asldfj.png</span></li>
								<li class="FileItem"><span class="colorBlu">asldfj.png</span></li>
							</ul>
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
							<tr><td>1</td><td>张三</td><td>提交</td><td>说明</td><td>2018-06-02</td></tr>
							<tr><td>1</td><td>张三</td><td>已完成</td><td>说明</td><td>2018-06-02</th></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
