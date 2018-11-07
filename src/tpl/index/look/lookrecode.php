
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="搜索" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr>
							<td>客户姓名</td><td>电话</td><td>项目</td><td>地址</td><td>看房时间</td><td>销售人员</td><td>操作</td>
						</tr>
					</thead>
					<tbody class="hover">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>客户姓名</td><td>电话</td><td>项目</td><td>地址</td><td>看房时间</td><td>销售人员</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item Pop"data-url="<?php echo spUrl('apply', 'lookcont')?>"><a >详情</a></li>
									</ul>
								</div>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<?php require_once TPL_DIR . '/layout/page.php'; ?>
		</div>
	</body>
</html>