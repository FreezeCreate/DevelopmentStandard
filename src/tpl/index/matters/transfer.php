

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="姓名" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'adddiaod')?>"data-title="添加调动">+ 添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b">
							<td>序号</td><td>姓名</td><td>调动前部门</td><td>调动后部门</td><td>调动前职位</td>
							<td>调动后职位</td><td>调动类型</td><td>调动说明</td><td>相关文件</td><td>操作</td>
						</tr>
					</thead>
					<tbody class="hover colorGra">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td><?php echo $i+1?></td><td>张三</td><td>技术一部</td><td>技术二部</td><td>PHP工程师</td>
							<td>PHP工程师</td><td>上级调动</td><td>人员编制变更</td><td></td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'transcont')?>"data-title="调动详情"><a >详情</a></li>
										<li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'adddiaod')?>"data-title="编辑调动"><a >编辑</a></li>
										<li class="menu-item read deled"><a >删除</a></li>
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
<script type="text/javascript">
	$(document).on('click', '.deled', function(){
		var that = $(this);
		parent.window.Confirm('确定删除？', function(e){
			if(e){
				that.parent().parent().parent().parent().remove()
			}
		})
	})
</script>