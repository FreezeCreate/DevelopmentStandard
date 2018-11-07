

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="姓名" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'addregula')?>"data-title="添加转正申请">+ 添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b"><td>序号</td><td>姓名</td><td>部门</td><td>入职日期</td><td>转正日期</td><td>说明</td><td>相关文件</td><td>操作人</td><td>操作</td></tr>
					</thead>
					<tbody class="hover colorGra">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td><?php echo $i +1?></td><td>张三</td><td>商务部</td><td>2018-09-06</td><td>2018-05-06</td><td>说明说明说明说明</td>
							<td><p class="colorBlu NewPop" data-url="<?php echo spUrl('apply', 'img')?>" data-title="查看图片" data-type="img" data-src="<?php echo SOURCE_PATH; ?>/images/login/login_bg.png">tmp.png</p></td>
							<td>历史</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'regularcont')?>"data-title="转正申请详情"><a >详情</a></li>
										<li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'addregula')?>"data-title="编辑转正申请"><a >编辑</a></li>
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