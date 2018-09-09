
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/home.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/home.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="clerPd">
				<div class="row pdX10">
					<div class="col-4">
						<div class="pdX10">
							<div class="Module">
								<div class="Head">
									<div class="HeadTitBox">
										<img class="HeadLImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_db.png"/>
										<div class="HeadLText">
											<span>待办事项</span>
											<span class="Eng">Backlog</span>
										</div>
									</div>
									<div class="HeadMenu">
										<div class="HeadMenuGroupBox">
											<span class="addBtn"></span>
										</div>
									</div>
								</div>
								<div class="ModuleCont pdX10">
									<ul class="daibanBox">
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_g"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="pdX10">
							<div class="Module">
								<div class="Head">
									<div class="HeadTitBox">
										<img class="HeadLImg" src="<?php echo SOURCE_PATH; ?>/images/icon/menu_wckq.png"/>
										<div class="HeadLText">
											<span>个人考勤情况</span>
											<span class="Eng">Personal attendance</span>
										</div>
									</div>
								</div>
								<div class="ModuleCont">
									<ul class="floatBox dkbox">
										<li class="dkItem bdr">
											<div class="dkItemBox">
												<p class="dkqk">今天打卡情况</p>
												<div class="dkzt">未打卡</div>
											</div>
										</li>
										<li class="dkItem">
											<div class="dkItemBox">
												<p class="time"><span class="hour"></span>：<span class="min"></span>：<span class="second"></span></p>
												<p class="dates"><span class="year"></span>年<span class="mont"></span>月<span class="day"></span> <span class="dat"></span></p>
												<span class="dkBtn">打卡</span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="Module top20">
				<div class="Head">
					<div class="HeadTitBox">
						<img class="HeadLImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_tj.png"/>
						<div class="HeadLText">
							<span>今日统计</span>
							<span class="Eng">Statistics Today</span>
						</div>
					</div>
				</div>
				<div class="ModuleCont">
					<ul class="floatBox dkbox">
						<li class="tjItem bdr">
							<div class="dkItemBox">
								<div class="tjImgbox">
									<img class="tjImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_lr.png" alt="" />
									<div class="tjTx">
										<p class="tjtit">今日新增录入</p>
										<p class="tjcon">45 <img src="<?php echo SOURCE_PATH; ?>/images/icon/home_d.png"/></p>
									</div>
								</div>
								<p class="tjNam">共计录入：<span class="colorGre">54/组</span></p>
							</div>
						</li>
						<li class="tjItem bdr">
							<div class="dkItemBox">
								<div class="tjImgbox">
									<img class="tjImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_dk.png" alt="" />
									<div class="tjTx">
										<p class="tjtit">今日新增带看</p>
										<p class="tjcon" style="color:#7980db;">98 <img src="<?php echo SOURCE_PATH; ?>/images/icon/home_u.png"/></p>
									</div>
								</div>
								<p class="tjNam">共计带看：<span class="colorGre">54/组</span></p>
							</div>
						</li>
						<li class="tjItem">
							<div class="dkItemBox">
								<div class="tjImgbox">
									<img class="tjImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_cj.png" alt="" />
									<div class="tjTx">
										<p class="tjtit">今日新增成交</p>
										<p class="tjcon" style="color:#f26643;">98 <img src="<?php echo SOURCE_PATH; ?>/images/icon/home_u.png"/></p>
									</div>
								</div>
								<p class="tjNam">共计成交：<span class="colorGre">54/组</span></p>
							</div>
						</li>
					</ul>
				</div>
				<div class="ModuleFoot">
					<p class="tjfoot"><span>共计成交金额：</span><span class="colorRed">4563/万元</span><img src="<?php echo SOURCE_PATH; ?>/images/icon/home_u.png"/></p>
				</div>
			</div>
			<div class="Module yjph top20">
				<div class="Head">
					<div class="HeadTitBox">
						<img class="HeadLImg" src="<?php echo SOURCE_PATH; ?>/images/icon/home_pm.png"/>
						<div class="HeadLText">
							<span>业绩排名</span>
							<span class="Eng">Performance ranking</span>
						</div>
					</div>
					<div class="HeadMenu">
						<div class="HeadMenuGroupBox">
							<label><span class="radio c1">公司</span><input type="radio"class="None" name="pm" id="" value="" /></label>
							<label><span class="radio c1">部门</span><input type="radio"class="None" name="pm" id="" value="" /></label>
							<label><span class="radio c1 active">个人</span><input type="radio"class="None"checked="checked" name="pm" id="" value="" /></label>
						</div>
					</div>
				</div>
				<div class="yejiCont">
					<div class="GraphMap"style="height: 180px; ">
						<ul class="GraphMapY colorGre colorRed">
							<li class="GraphMapYText ">成交额/万元</li>
						</ul>
						<ul class="GraphMapX"></ul>
					</div>
				</div>
			</div>
			<div class="clerPd top20">
				<div class="row pdX10">
					<div class="col-4">
						<div class="pdX10">
							<div class="Module">
								<div class="Head">
									<div class="HeadTitBox">
										<div class="HeadLText">
											<span>工作汇报</span>
											<span class="Eng">Reporting on work</span>
										</div>
									</div>
									<div class="HeadMenu">
										<div class="HeadMenuGroupBox">
											<label><span class="checkbox c1">下属</span><input type="checkbox"class="None"/></label>
											<span class="addBtn"></span>
											<span class="moreBtn"></span>
										</div>
									</div>
								</div>
								<div class="ModuleCont scroll">
									<table class="table textCenter">
										<thead>
											<tr class="colorGre"><td>标题</td><td>作者</td><td>日期</td></tr>
										</thead>
										<tbody class="hover">
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
											<tr><td>七月计划</td><td>张三</td><td>2018.05.06</td></tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="pdX10">
							<div class="Module">
								<div class="Head">
									<div class="HeadTitBox">
										<div class="HeadLText">
											<span>新增客户</span>
											<span class="Eng">New Customers</span>
										</div>
									</div>
									<div class="HeadMenu">
										<div class="HeadMenuGroupBox">
											<span class="addBtn"></span>
											<span class="moreBtn"></span>
										</div>
									</div>
								</div>
								<div class="ModuleCont scroll">
									<ul class="pdX20 pdY10 hover">
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="pdX10">
							<div class="Module">
								<div class="Head">
									<div class="HeadTitBox">
										<div class="HeadLText">
											<span>费用申请</span>
											<span class="Eng">Application for fees</span>
										</div>
									</div>
									<div class="HeadMenu">
										<div class="HeadMenuGroupBox">
											<span class="addBtn"></span>
											<span class="moreBtn"></span>
										</div>
									</div>
								</div>
								<div class="ModuleCont scroll">
									<ul class="pdX20 pdY10 hover">
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
										<li class="lisI squer_b"><span class="lisL">2018.07需要带看房源----锦江区</span><span class="lisR">2018.06.29</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		
		var dats = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
		var dt = new Date();
		var yer, mon, day, dath, m, s;
		yer = dt.getFullYear();
		mon = dt.getMonth() + 1;
		day = dt.getDate();
		dat = dats[dt.getDay()];
		h = dt.getHours();
		m = dt.getMinutes();
		s = dt.getSeconds();
		$('.year').text(yer);
		$('.mont').text(mon);
		$('.day').text(day);
		$('.dat').text(dat);
		$('.hour').text(h);
		$('.min').text(m);
		$('.second').text(s);
		setInterval(function() {
			if(++s == 60) {
				s = 0;
				if(++m == 60) {
					m = 0;
					if(++h == 24) {
						h = 0;
					}
					$('.hour').text(h<10?'0'+h:h);
				}
				$('.min').text(m<10?'0'+m:m);
			}
			$('.second').text(s<10?'0'+s:s);
		}, 1000)
		
		var res = {"maxexpe":70000,"maxsucc":44000,"results":[{"expe":null,"succ":6000,"name":"某某某"},{"expe":14000,"succ":44000,"name":"某某某"},{"expe":25000,"succ":null,"name":"某某某"},{"expe":20000,"succ":null,"name":"某某某"},{"expe":30000,"succ":null,"name":"某某某"},{"expe":70000,"succ":null,"name":"某某某"},{"expe":50000,"succ":null,"name":"某某某"},{"expe":25000,"succ":null,"name":"某某某"},{"expe":30000,"succ":null,"name":"某某某"},{"expe":14000,"succ":null,"name":"某某某"},{"expe":14000,"succ":null,"name":"某某某"}]}
		yjphSet(res)
		$('.dkBtn').click(function(){
			
			$('.dkzt').addClass('active').text('已打卡');
			$('.dkqk').text('已打卡：'+Format(new Date(), 'yyyy-MM-dd HH:mm:ss')).addClass('colorGre')
		})
	</script>
</html>
