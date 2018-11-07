
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/scocheck.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<label>
					<span class="mg-r-6">项目选择</span>
					<input type="text" class="input text1" name="" id="" value="" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
					<input type="hidden" class="text2" name="" id="" value="" />
				</label>
				<span class="mg-r-6">时间段选择</span>
				<input type="text" class="input dates" name="" id="" value="" readonly="readonly"/>
				<span class="mg-r-6">至</span>
				<input type="text" class="input dates" name="" id="" value="" readonly="readonly"/>
				<span class="btn btn-sm btn-primary">搜索</span>
				<span class="btn btn-sm btn-info" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<div class="socheckbox">
					<ul class="socfbo">
						<li class="yjit">
							<p class="yjtit">总业绩</p>
							<div class="yjc">
								<p><span class="yjbig">1145</span>元</p>
								<div class="yjbd"></div>
							</div>
						</li>
						<li class="yjit">
							<p class="yjtit">总提成</p>
							<div class="yjc">
								<p><span class="yjbig">115</span>元</p>
								<div class="yjbd"></div>
							</div>
						</li>
						<li class="yjit">
							<p class="yjtit">签约客户数</p>
							<div class="yjc">
								<p><span class="yjbig">45</span>个</p>
								<div class="yjbd"></div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="yjtc">
				<p class="yjtctit">项目提出业绩</p>
				<div class="clerPd">
					<div class="row pdX10">
						<?php for($i = 0; $i < 10; $i++){?>
						<div class="col-4">
							<div class="pdX10">
								<div class="yjtcbox">
									<img class="yjimg" src="<?php echo SOURCE_PATH?>/images/houses/house_2.png"/>
									<div class="yjconte">
										<p class="yjconttit">成都蓝光长岛国际社区</p>
										<p class="yjcn"><i class="icon"></i><span>成都市成华区间建设路45号</span></p>
										<p class="yjcn">签单时间：2018-06-12</p>
										<p class="yjmoney">6500元/㎡</p>
										<div>
											<span class="yjbtn yj">业绩：1.5万</span>
											<span class="yjbtn tc">提成：500元</span>
										</div>
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
<script type="text/javascript">
	jeDate({
		dateCell:".dates",
		format:"YYYY-MM-DD",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){alert(val)}
	})
</script>