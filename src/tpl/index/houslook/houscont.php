
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/houscont.css"/>
	</head>
	</head>
	<body>
		<div class="MainHtml">
			<div class="MainTitle">楼盘名称：蓝光长岛国际社区<span class="btn btn-sm float-right btn-info mg-r-6" onclick="Refresh()">刷新</span></div>
			<div class="houscont">
				<div class="housimg">
					<div class="imgite h-center">
						<img class="bigimg" src="<?php echo SOURCE_PATH; ?>/images/login/login_bg.png"/>
					</div>
					<div class="smalimg">
						<span class="imgbtn prev"></span>
						<span class="imgbtn next"></span>
						<div class="imb">
							<ul class="imgsbox">
								<li class="imgs h-center active">
									<div class="mk"></div>
									<img src="<?php echo SOURCE_PATH; ?>/images/houses/house_1.png"/>
								</li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_pm.png"/></li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_1.png"/></li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_1.png"/></li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_pm.png"/></li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_1.png"/></li>
								<li class="imgs h-center"><img src="<?php echo SOURCE_PATH; ?>/images/houses/house_pm.png"/></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="houscon">
					<div class="housctit">
						<p>
							<span class="housjg colorRed">单价：4000元/㎡~6000元/㎡</span>
							<span>开盘时间：2017年10月23日</span>
						</p>
						<p>
							<div class="housjg colorBlu">
								<span class="mg-r-10"><i class="point"></i>佣金：455元 </span>
								<span><i class="point"></i>带看房：45元</span>
							</div>
							<span>交房时间：2018年10月23日</span>
						</p>
					</div>
					<ul class="itembox endl">
						<li class="conitem">建筑类型：搭板结合</li>
						<li class="conitem">容积率：4.5</li>
						<li class="conitem">规划车位：200</li>
						<li class="conitem">物业类型：住宅</li>
						<li class="conitem">绿化率：30%</li>
						<li class="conitem">装修状况：毛坯</li>
						<li class="conitem">规划户数：230</li>
						<li class="conitem">物业费：54元/平米/月</li>
						<li class="conitem">产权年限：70</li>
						<li class="conitem">开发商：成都富力地产开发有限公司</li>
						<li class="conitem">详细地址：四川省成都市成华区兴城大道777号</li>
						<li class="conitem">物业公司：广州天力物业反战有限公司</li>
						<li class="conitem">销售许可证：成都售房第215号</li>
					</ul>
					<span class="bb-btn Pop"data-url="<?php echo spUrl('applyFill', 'housekeep')?>">报备</span>
				</div>
			</div>
			<div class="househx">
				<div class="housmen">
					<span>户型：</span>
					<ul class="hxbox">
						<li class="hxitem active">全部</li>
						<li class="hxitem">一户</li>
						<li class="hxitem">二户</li>
						<li class="hxitem">三户</li>
						<li class="hxitem">四户</li>
						<li class="hxitem">五户</li>
						<li class="hxitem">五户以上</li>
					</ul>
				</div>
				<div class="clerPd">
					<div class="row pdX10">
						<?php for($i = 0; $i < 10; $i++){?>
						<div class="col-4 col-sm-6">
							<div class="pdX10">
								<div class="hxcon NewHtml"data-url="<?php echo spUrl('houslook', 'houseintr')?>" data-name="户型详情"data-clas="a_housxq">
									<div class="hximg h-center">
										<img src="<?php echo SOURCE_PATH; ?>/images/houses/house_pm.png"/>
									</div>
									<div class="hxco">
										<p>1栋L4户型</p>
										<p>一室一厅一卫</p>
										<p>建筑面积45㎡</p>
										<p class="colorRed">约合45万/套</p>
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
	<body>
</html>
<script type="text/javascript">
	$('.imgs').click(function(){
		$('.imgs').removeClass('active');
		$(this).addClass('active')
		$('.bigimg').attr({'src': $(this).children('img').attr('src')})
	})
	$('.next').click(function(){
		var imgbox = $('.imgsbox');
		var box = $('.imb');
		var num = Math.abs(parseInt(imgbox.css('left')));
		if( box.width() + num < imgbox.width()){
			imgbox.animate({'left': -(num + box.width()) })
		}
	})
	$('.prev').click(function(){
		var imgbox = $('.imgsbox');
		var box = $('.imb');
		var num = parseInt(imgbox.css('left'));
		if( num < 0 ){
			imgbox.animate({'left': num + box.width() })
		}
	})
</script>