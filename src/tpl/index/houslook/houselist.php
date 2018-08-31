
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/houslist.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<ul class="grpBtn grpBtn-md">
					<li class="grpBtnItem active">商户</li>
					<li class="grpBtnItem">住宅</li>
					<li class="grpBtnItem">公寓</li>
					<li class="grpBtnItem">酒店</li>
					<li class="grpBtnItem">写字楼</li>
					<li class="grpBtnItem">其他</li>
				</ul>
				<input class="input input-md radius" type="text" placeholder="搜索" />
				<span class="btn btn-primary mg-r-6">搜索</span>
				<span class="btn btn-info mg-r-6" onclick="Refresh()">刷新</span>
				<span>当前位置：成都</span>
			</div>
			<div class="meitm top20">
				<ul class="floatBox">
					<li class="meitem">
						<ul class="grpBtn grpBtn-sm">
							<li class="grpBtnItem active">区域</li>
							<li class="grpBtnItem">地铁</li>
							<li class="grpBtnItem">附近</li>
						</ul>
					</li>
					<li class="meitem active">不限</li>
					<li class="meitem">成华区</li>
					<li class="meitem">武侯区</li>
					<li class="meitem">青羊区</li>
					<li class="meitem">高新区</li>
					<li class="meitem">锦江区</li>
					<li class="meitem">双流</li>
					<li class="meitem">犀浦</li>
				</ul>
			</div>
			<div class="meitm">
				<ul class="floatBox">
					<li class="meitem">
						<ul class="grpBtn grpBtn-sm">
							<li class="grpBtnItem active">总价</li>
							<li class="grpBtnItem">单价</li>
						</ul>
					</li>
					<li class="meitem active">不限</li>
					<li class="meitem">30万以下</li>
					<li class="meitem">30-50万</li>
					<li class="meitem">50-80万</li>
					<li class="meitem">80-100万</li>
					<li class="meitem">100-130万</li>
					<li class="meitem">150-200万</li>
					<li class="meitem">200-250万</li>
					<li class="meitem">250-300万</li>
					<li class="meitem">350-400万</li>
					<li class="meitem">400-450万</li>
					<li class="meitem">450-500万</li>
					<li class="meitem">450-500万</li>
					<li class="meitem">500-600万</li>
					<li class="meitem">600-700万</li>
					<li class="meitem">700-800万</li>
					<li class="meitem">800-1000万</li>
					<li class="meitem">1000-1500万</li>
					<li class="meitem">1500-2000万</li>
					<li class="meitem">2000-3000万</li>
					<li class="meitem">3000万以上</li>
					<li class="meitem">
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span>-</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">万元</span>
						<span class="btn btn-sm btn-primary">确定</span>
					</li>
				</ul>
			</div>
			<div class="meitm">
				<ul class="floatBox">
					<li class="meitem">
						<ul class="grpBtn grpBtn-sm">
							<li class="grpBtnItem active">面积</li>
						</ul>
					</li>
					<li class="meitem active">不限</li>
					<li class="meitem">20平米以下</li>
					<li class="meitem">20-50平米</li>
					<li class="meitem">50-80平米</li>
					<li class="meitem">80-120平米</li>
					<li class="meitem">120-200平米</li>
					<li class="meitem">200-300平米</li>
					<li class="meitem">300-500平米</li>
					<li class="meitem"> 500平米以上</li>
					<li class="meitem">
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span>-</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">平米</span>
						<span class="btn btn-sm btn-primary">确定</span>
					</li>
				</ul>
			</div>
			<div class="meres">
				<div class="meres-tit">筛选结果</div>
				<div class="clerPd">
					<div class="row pdX10">
						<?php for($i = 0; $i < 10; $i++){?>
						<div class="col-4 col-sm-6">
							<div class="pdX10">
								<div class="meres-item NewHtml" data-clas="a_123" data-url="<?php echo spUrl('houslook','houscont')?>" data-name="楼盘详情">
									<div class="house-img">
										<div class="house-imgbox h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_1.png" alt="" /></div>
									</div>
									<div class="house-con">
										<p class="house-name">蓝光长岛国际社区</p>
										<p>地址：成都市成华区建设路45号</p>
										<p class="colorBlu"><i class="point"></i>佣金：455元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="point"></i>带看费：45元</p>
										<p class="colorRed">单价：6000㎡</p>
									</div>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
				</div>
				<?php require_once TPL_DIR . '/layout/page.php'; ?>
			</div>
		</div>
	</body>
</html>