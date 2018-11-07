
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/scores.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="scoserch">
				<label>
					<span class="mg-r-6">员工姓名</span>
					<input type="text" class="input text1" readonly="readonly" name="" id="" value="" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)" />
					<input type="hidden" class="text2"name="" id="" value="" />
				</label>
				<select name=""class="input">
					<option value="1">1月</option>
					<option value="2">2月</option>
					<option value="3">3月</option>
					<option value="4">4月</option>
					<option value="5">5月</option>
					<option value="6">6月</option>
					<option value="7">7月</option>
					<option value="8">8月</option>
					<option value="9">9月</option>
					<option value="10">10月</option>
					<option value="11">11月</option>
					<option value="12">12月</option>
				</select>
				<span class="btn btn-sm btn-primary">搜索</span>
				<span class="btn btn-sm btn-info" onclick="Refresh()">刷新</span>
				<div class="choicebox">
					<label>
						<span class="radio">渠道公司</span>
						<input type="radio" name="choice" class="None" id="" value="" />
					</label>
					<label>
						<span class="radio">项目方</span>
						<input type="radio" name="choice" class="None" id="" value="" />
					</label>
				</div>
			</div>
			<div class="scnit">
				<div class="scnitit">核算表</div>
				<div>
					<table class="table borderTr textCenter">
						<thead>
							<tr>
								<td></td>
								<td>通电数</td>
								<td>回访数</td>
								<td>带看组数</td>
								<td>成交金额</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>目标</td>
								<td>200</td>
								<td>100</td>
								<td>500</td>
								<td>30万</td>
							</tr>
							<tr>
								<td>完成量</td>
								<td>200</td>
								<td>100</td>
								<td>500</td>
								<td>30万</td>
							</tr>
							<tr>
								<td>完成率</td>
								<td>200</td>
								<td>100</td>
								<td>500</td>
								<td>30万</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="scnit grp">
				<div class="scnitit">绩效参考图</div>
				<div class="yejiCont">
					<div class="GraphMap"style="height: 180px; ">
						<ul class="GraphMapY colorGre colorRed">
							<li class="GraphMapYText ">成交额/万元</li>
						</ul>
						<ul class="GraphMapX"></ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	var res = {"maxexpe":70000,"maxsucc":44000,"results":[{"expe":null,"succ":6000,"name":"某某某"},{"expe":14000,"succ":44000,"name":"某某某"},{"expe":25000,"succ":null,"name":"某某某"},{"expe":20000,"succ":null,"name":"某某某"},{"expe":30000,"succ":null,"name":"某某某"},{"expe":70000,"succ":null,"name":"某某某"},{"expe":50000,"succ":null,"name":"某某某"},{"expe":25000,"succ":null,"name":"某某某"},{"expe":30000,"succ":null,"name":"某某某"},{"expe":14000,"succ":null,"name":"某某某"},{"expe":14000,"succ":null,"name":"某某某"}]}
	Graph(res, '.yejiCont', 3)
</script>