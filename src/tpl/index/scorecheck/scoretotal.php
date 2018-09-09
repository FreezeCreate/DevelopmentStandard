
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/myuser.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<ul class="grpBtn">
					<li class="grpBtnItem pdX30 active">日</li>
					<li class="grpBtnItem pdX30">月</li>
					<li class="grpBtnItem pdX30">年</li>
				</ul>
				<span class="btn btn-info btn-sm"onclick="Refresh()">刷新</span>
			</div>
			<p class="top20">我的排名</p>
			<div class="phbox">
				<div class="phbpm">
					<p class="phname no1">张三</p>
					<p class="phnum">No. <span class="big">1</span></p>
				</div>
				<div class="phimg"><img src="<?php echo SOURCE_PATH?>/images/user/user.png"/></div>
				<div class="phtem">提成：<span class="big gre">455</span>元</div>
				<div class="phtem">业绩：<span class="big red">45534</span>元</div>
			</div>
			<div class="phb">排行榜</div>
			<div>
				<table class="table borderTr yjph textCenter">
					<thead>
						<tr>
							<td></td>
							<td>排名</td>
							<td>头像</td>
							<td>姓名</td>
							<td>业绩</td>
							<td>提成</td>
						</tr>
					</thead>
					<tbody>
						<tr class="gold">
							<td><span class="no no1"></span></td>
							<td>1</td>
							<td><img class="usimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" /></td>
							<td>张三</td>
							<td>1234.5元</td>
							<td>1234.5元</td>
						</tr>
						<tr>
							<td><span class="no no2"></span></td>
							<td>2</td>
							<td><img class="usimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" /></td>
							<td>张三</td>
							<td>1234.5元</td>
							<td>1234.5元</td>
						</tr>
						<tr>
							<td><span class="no no3"></span></td>
							<td>3</td>
							<td><img class="usimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" /></td>
							<td>张三</td>
							<td>1234.5元</td>
							<td>1234.5元</td>
						</tr>
						<tr>
							<td><span class="no no4"></span></td>
							<td>4</td>
							<td><img class="usimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" /></td>
							<td>张三</td>
							<td>1234.5元</td>
							<td>1234.5元</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>