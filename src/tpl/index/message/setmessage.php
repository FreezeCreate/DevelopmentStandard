

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="搜索" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'addlm')?>"data-title="添加栏目">+ 添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b"><td>序号</td><td>栏目名称</td><td>栏目内容</td><td>操作</td></tr>
					</thead>
					<tbody class="hover colorGra">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td><?php echo $i+1?></td><td>项目名称</td><td>栏目内容</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'addlm')?>"data-title="编辑栏目"><a >编辑</a></li>
										<li class="menu-item read"><a >删除</a></li>
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
