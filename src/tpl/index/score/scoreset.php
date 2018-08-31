

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
				<span class="btn btn-sm btn-info" onclick="Refresh()">刷新</span>
			</div>
			<div class="scoit">
				<div class="scotit">渠道公司</div>
				<div class="scocont">
					<label>
						<span class="sconam">通电数</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">回访</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">带看组数</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">成交额</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
				</div>
			</div>
			<div class="scoit">
				<div class="scotit">项目方</div>
				<div class="scocont">
					<label>
						<span class="sconam">接待组数</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">回访组数</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">成交金额</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
					<label>
						<span class="sconam">回款金额</span>
						<input type="text" class="input" name="" id="" value="" />
					</label>
				</div>
			</div>
			<div class="scobtns">
				<span class="scobtn qx">取消</span>
				<span class="scobtn qr">确认</span>
			</div>
		</div>
	</body>
</html>