
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="输入关键字" />
				<span class="mg-r-6">时间段：</span>
				<input class="input radius dates" type="text" readonly="readonly" />
				<span class="mg-r-6">至</span>
				<input class="input radius dates" type="text" readonly="readonly" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<table class="table textCenter borderTr">
					<thead>
						<tr>
							<td>客户姓名</td>
							<td>性别</td>
							<td>年龄</td>
							<td>电话</td>
							<td>报备时间</td>
							<td>报备项目数</td>
							<td>报备项目</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody>
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>张三</td>
							<td>男</td>
							<td>34</td>
							<td>13333333333</td>
							<td>2018-03-05</td>
							<td>34</td>
							<td>蓝光长岛国际社区/蓝光长岛国际社区/蓝光长岛国际社区</td>
							<td>
								<span class="btn btn-danger btn-sm qd">抢单</span>
								<span class="btn btn-info btn-sm NewHtml"data-name="客户详情"data-url="<?php echo spUrl('publicuser', 'usercont')?>"data-clas="a_gkcxq">详情</span>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).on('click', '.qd', function(){
		parent.window.Alert('抢单成功')
	})
</script>