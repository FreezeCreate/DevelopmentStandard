
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/sell.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius text1" type="text" placeholder="点击选择楼盘" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
				<input type="hidden" class="text2" name="" id="" value="" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<div class="imgbox">
					<div class="imgim h-center">
						<img src="<?php echo SOURCE_PATH?>/images/houses/house_2.png"/>
					</div>
				</div>
				<div class="housc">
					<p class="housnam">蓝光长岛国际社区</p>
					<p class="housnam"><i class="icon-dz"></i>成都市成华区建设路54号</p>
					<p class="housnam colorRed">项目单价：5600/元</p>
					<p class="housnam">户型：<span class="hx">一户</span><span class="hx">二户</span><span class="hx">三户</span></p>
				</div>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead class="bg">
						<tr>
							<td>订单号</td>
							<td>销售人</td>
							<td>销售时间</td>
							<td>销售数量</td>
							<td>销售金额</td>
							<td>户型</td>
							<td>客户</td>
						</tr>
					</thead>
					<tbody class="hover">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>51025466811</td>
							<td>张三</td>
							<td>2018-05-05</td>
							<td>25</td>
							<td>2550</td>
							<td>一户</td>
							<td>李四</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>