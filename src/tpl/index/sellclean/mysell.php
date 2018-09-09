
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<span class="mg-r-6">楼盘</span>
				<input class="input radius text1" type="text" placeholder="点击选择楼盘" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
				<input type="hidden" class="text2" name="" id="" value="" />
				<span class="mg-r-6">销售人员</span>
				<input class="input radius text1" type="text" placeholder="点击选择人员" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
				<input type="hidden" class="text2" name="" id="" value="" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-success float-right NewPop"data-url="<?php echo spUrl('applyFill', 'addsell')?>"data-title="添加售出" >+ 添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead class="bg">
						<tr>
							<td>订单号</td>
							<td>楼盘</td>
							<td>户型</td>
							<td>售出数量</td>
							<td>售出时间</td>
							<td>销售人员</td>
							<td>客户</td>
						</tr>
					</thead>
					<tbody class="hover">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>51025466811</td>
							<td>蓝光长城半岛国际</td>
							<td>一户</td>
							<td>32</td>
							<td>2018-05-05</td>
							<td>张三</td>
							<td>李四</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>