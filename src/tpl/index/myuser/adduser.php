
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/myuser.css"/>
	<style type="text/css">
		body{background-color: #f5f5f5;color: #adadad;}
		.MainHtml{padding: 0;}
	</style>
	</head>
	<body>
		<div class="MainHtml">
			<div class="additm">
				<div class="addtit">客户基本信息 </div>
				<div class="itemse">
					<span class="itemname"><i class="colorRed">*</i>姓名</span>
					<input type="text" class="input" name="" id="" value="" />
				</div>
				<div class="itemse sex">
					<span class="itemname"></span>
					<label>
						<span class="radio">男</span>
						<input type="radio"class="None" name="sex" id="" value="男" />
					</label>
					<label>
						<span class="radio">女</span>
						<input type="radio"class="None" name="sex" id="" value="女" />
					</label>
				</div>
				<div class="itemse">
					<span class="itemname"><i class="colorRed">*</i>电话</span>
					<input type="text" class="input" name="" id="" value="" />
				</div>
				<div class="itemse age">
					<span class="itemname">年龄</span>
					<div class="itemval">
						<label>
							<span class="radio">18-25</span>
							<input type="radio"class="None" name="age" id="" value="18-25" />
						</label>
						<label>
							<span class="radio">25-35</span>
							<input type="radio"class="None" name="age" id="" value="25-35" />
						</label>
						<label>
							<span class="radio">35-45</span>
							<input type="radio"class="None" name="age" id="" value="35-45" />
						</label>
						<label>
							<span class="radio">45-55</span>
							<input type="radio"class="None" name="age" id="" value="45-55" />
						</label>
						<label>
							<span class="radio">55-65</span>
							<input type="radio"class="None" name="age" id="" value="55-65" />
						</label>
						<label>
							<span class="radio">65以上</span>
							<input type="radio"class="None" name="age" id="" value="65以上" />
						</label>
					</div>
				</div>
			</div>
			<div class="additm">
				<div class="addtit">客户楼盘信息</div>
				<div class="itemse">
					<span class="itemname">客户途径</span>
					<div class="itemval">
						<label>
							<span class="radio">电话</span>
							<input type="radio"class="None" name="khtj" id="" value="电话" />
						</label>
						<label>
							<span class="radio">中介带看</span>
							<input type="radio"class="None" name="khtj" id="" value="中介带看" />
						</label>
						<label>
							<span class="radio">网络</span>
							<input type="radio"class="None" name="khtj" id="" value="网络" />
						</label>
						<label>
							<span class="radio">短信</span>
							<input type="radio"class="None" name="khtj" id="" value="短信" />
						</label>
						<label>
							<span class="radio">朋友介绍</span>
							<input type="radio"class="None" name="khtj" id="" value="朋友介绍" />
						</label>
						<label>
							<span class="radio">推荐会</span>
							<input type="radio"class="None" name="khtj" id="" value="推荐会" />
						</label>
						<label>
							<span class="radio">自然到访</span>
							<input type="radio"class="None" name="khtj" id="" value="自然到访" />
						</label>
						<label>
							<span class="radio">其他</span>
							<input type="radio"class="None" name="khtj" id="" value="其他" />
						</label>
					</div>
				</div>
				<div class="itemse">
					<div class="itemname">物业类型</div>
					<div class="itemval">
						<label>
							<span class="checkbox">商铺</span>
							<input type="checkbox"class="None" name="" id="" value="商铺" />
						</label>
						<label>
							<span class="checkbox">住宅</span>
							<input type="checkbox"class="None" name="" id="" value="住宅" />
						</label>
						<label>
							<span class="checkbox">公寓</span>
							<input type="checkbox"class="None" name="" id="" value="公寓" />
						</label>
						<label>
							<span class="checkbox">酒店</span>
							<input type="checkbox"class="None" name="" id="" value="酒店" />
						</label>
						<label>
							<span class="checkbox">写字楼</span>
							<input type="checkbox"class="None" name="" id="" value="写字楼" />
						</label>
						<label>
							<span class="checkbox">其他</span>
							<input type="checkbox"class="None" name="" id="" value="其他" />
						</label>
					</div>
				</div>
				<div class="itemse">
					<div class="itemname">
						<p>物业面积</p>
						<p class="kdx">(可多选)</p>
					</div>
					<div class="itemval">
						<label>
							<span class="checkbox">20以下</span>
							<input type="checkbox"class="None" name="" id="" value="20以下" />
						</label>
						<label>
							<span class="checkbox">20-50</span>
							<input type="checkbox"class="None" name="" id="" value="20-50" />
						</label>
						<label>
							<span class="checkbox">50-80</span>
							<input type="checkbox"class="None" name="" id="" value="50-80" />
						</label>
						<label>
							<span class="checkbox">80-120</span>
							<input type="checkbox"class="None" name="" id="" value="80-120" />
						</label>
						<label>
							<span class="checkbox">120-200</span>
							<input type="checkbox"class="None" name="" id="" value="120-200" />
						</label>
						<label>
							<span class="checkbox">200-300</span>
							<input type="checkbox"class="None" name="" id="" value="200-300" />
						</label>
						<label>
							<span class="checkbox">300-500</span>
							<input type="checkbox"class="None" name="" id="" value="300-500" />
						</label>
						<label>
							<span class="checkbox">500以上</span>
							<input type="checkbox"class="None" name="" id="" value="500以上" />
						</label>
					</div>
				</div>
				<div class="itemse">
					<div class="itemname">
						<p>预算单价</p>
						<p class="kdx">(可多选)</p>
					</div>
					<div class="itemval">
						<label>
							<span class="checkbox">5000以上</span>
							<input type="checkbox"class="None" name="" id="" value="5000以上" />
						</label>
						<label>
							<span class="checkbox">5000-6000</span>
							<input type="checkbox"class="None" name="" id="" value="5000-6000" />
						</label>
						<label>
							<span class="checkbox">6000-7000</span>
							<input type="checkbox"class="None" name="" id="" value="6000-7000" />
						</label>
						<label>
							<span class="checkbox">7000-8000</span>
							<input type="checkbox"class="None" name="" id="" value="7000-8000" />
						</label>
						<label>
							<span class="checkbox">8000-9000</span>
							<input type="checkbox"class="None" name="" id="" value="8000-9000" />
						</label>
						<label>
							<span class="checkbox">9000-10000</span>
							<input type="checkbox"class="None" name="" id="" value="9000-10000" />
						</label>
						<label>
							<span class="checkbox">10000-12000</span>
							<input type="checkbox"class="None" name="" id="" value="10000-12000" />
						</label>
						<label>
							<span class="checkbox">12000-15000</span>
							<input type="checkbox"class="None" name="" id="" value="12000-15000" />
						</label>
						<label>
							<span class="checkbox">15000-20000</span>
							<input type="checkbox"class="None" name="" id="" value="15000-20000" />
						</label>
						<label>
							<span class="checkbox">20000-25000</span>
							<input type="checkbox"class="None" name="" id="" value="20000-25000" />
						</label>
						<label>
							<span class="checkbox">25000-30000</span>
							<input type="checkbox"class="None" name="" id="" value="25000-30000" />
						</label>
						<label>
							<span class="checkbox">30000-40000</span>
							<input type="checkbox"class="None" name="" id="" value="30000-40000" />
						</label>
						<label>
							<span class="checkbox">40000以上</span>
							<input type="checkbox"class="None" name="" id="" value="40000以上" />
						</label>
					</div>
				</div>
				<div class="itemse">
					<div class="itemname">
						<p>预算总价</p>
						<p class="kdx">(可多选)</p>
					</div>
					<div class="itemval">
						<label>
							<span class="radio">30万以下</span>
							<input type="radio"class="None" name="" id="" value="30万以下" />
						</label>
						<label>
							<span class="radio">30-50万</span>
							<input type="radio"class="None" name="" id="" value="30-50万" />
						</label>
						<label>
							<span class="radio">50-80万</span>
							<input type="radio"class="None" name="" id="" value="50-80万" />
						</label>
						<label>
							<span class="radio">80-100万</span>
							<input type="radio"class="None" name="" id="" value="80-100万" />
						</label>
						<label>
							<span class="radio">100-130万</span>
							<input type="radio"class="None" name="" id="" value="100-130万" />
						</label>
						<label>
							<span class="radio">130-150万</span>
							<input type="radio"class="None" name="" id="" value="130-150万" />
						</label>
						<label>
							<span class="radio">150-200万</span>
							<input type="radio"class="None" name="" id="" value="150-200万" />
						</label>
						<label>
							<span class="radio">200-250万</span>
							<input type="radio"class="None" name="" id="" value="200-250万" />
						</label>
						<label>
							<span class="radio">250-300万</span>
							<input type="radio"class="None" name="" id="" value="250-300万" />
						</label>
						<label>
							<span class="radio">300-400万</span>
							<input type="radio"class="None" name="" id="" value="300-400万" />
						</label>
						<label>
							<span class="radio">400-450万</span>
							<input type="radio"class="None" name="" id="" value="400-450万" />
						</label>
						<label>
							<span class="radio">450-500万</span>
							<input type="radio"class="None" name="" id="" value="450-500万" />
						</label>
						<label>
							<span class="radio">600-700万</span>
							<input type="radio"class="None" name="" id="" value="600-700万" />
						</label>
						<label>
							<span class="radio">700-800万</span>
							<input type="radio"class="None" name="" id="" value="700-800万" />
						</label>
						<label>
							<span class="radio">800-1000万</span>
							<input type="radio"class="None" name="" id="" value="800-1000万" />
						</label>
						<label>
							<span class="radio">1000-1500万</span>
							<input type="radio"class="None" name="" id="" value="1000-1500万" />
						</label>
						<label>
							<span class="radio">1500-2000万</span>
							<input type="radio"class="None" name="" id="" value="1500-2000万" />
						</label>
						<label>
							<span class="radio">2000-3000万</span>
							<input type="radio"class="None" name="" id="" value="2000-3000万" />
						</label>
						<label>
							<span class="radio">3000万以上</span>
							<input type="radio"class="None" name="" id="" value="3000万以上" />
						</label>
					</div>
				</div>
			</div>
			<div class="additm">
				<div class="addtit">其他信息</div>
				<div class="itemse">
					<span class="itemname">意向楼盘</span>
					<div class="itemval">
						<input type="text" class="input text1" name="" id="" value="" placeholder="点击选择" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
						<input type="hidden" class="text2" name="" id="" value="" />
					</div>
				</div>
				<div class="itemse">
					<span class="itemname">客户情况</span>
					<div class="itemval">
						<textarea class="input" placeholder="输入客户情况"></textarea>
					</div>
				</div>
			</div>
			<div class="additm">
				<div class="itemse">
					<span class="itemname">抄送至</span>
					<div class="itemval">
						<input type="text" class="input text1" name="" id="" value="" placeholder="点击选择" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"/>
						<input type="hidden" class="text2" name="" id="" value="" />
					</div>
				</div>
			</div>
			<div class="adbtns">
				<span class="btns btns-false">取消</span>
				<span class="btns btns-true">确认</span>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('.itemval').width($(window).width()-200);
	window.onresize = function(){
		$('.itemval').width($(window).width()-200);
	}
</script>