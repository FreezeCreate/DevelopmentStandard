
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<ul class="grpBtn grpBtn-md">
					<li class="grpBtnItem active">所有</li>
					<li class="grpBtnItem">报备无效</li>
					<li class="grpBtnItem">报备成功</li>
					<li class="grpBtnItem">带看失败</li>
					<li class="grpBtnItem">带看成功</li>
					<li class="grpBtnItem">客户认筹</li>
					<li class="grpBtnItem">客户认购</li>
					<li class="grpBtnItem">客户签约</li>
					<li class="grpBtnItem">发起结佣</li>
					<li class="grpBtnItem">结佣完成</li>
				</ul>
			</div>
			<div class="HtmlNav top20">
				<input class="input" style="width: 380px;padding-left: 10px;padding-right: 10px;" type="text" placeholder="搜索" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-success float-right NewHtml"data-url="<?php echo spUrl('myuser', 'adduser')?>"data-clas="a_tjkh"data-name="添加客户">添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b"><td>序号</td><td>客户名称</td><td>项目地址</td><td>报备时间</td><td>报备人</td><td>报备状态</td><td>操作</td></tr>
					</thead>
					<tbody class="hover colorGra">
						<?php for($i = 0; $i < 5; $i++){?>
						<tr>
							<td></td><td>客户名称</td>
							<td><p class="colorBlu NewPop" data-url="<?php echo spUrl('apply', 'map')?>" data-title="四川省成都市郫都区犀安路" data-type="map" data-jd="103.99751216708"data-wd="30.76463999169">四川省成都市郫都区犀安路</p></td>
							<td>报备时间</td><td>报备人</td><?php echo ($i%2==0?'<td class="colorRed">报备无效</td>':'<td class="colorBlu">报备成功</td>')?>
							<td class="colorBlu">
								<span class="NewHtml"data-url="<?php echo spUrl('houseuser', 'usercont')?>"data-name="客户详情">查看详情</span>
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
