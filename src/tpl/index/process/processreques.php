
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/processreques.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="clerPd">
				<div class="row pdX10">
					<div class="col-6">
						<div class="pdX10">
							<div class="lcreq">
								<div class="lcreqtit">行政类</div>
								<div class="lcreqcont">
									<div class="lcreqitem"data-url=""data-title="添加通知公告" onclick="fill_apply(1)">
										<span class="lcimg lc_tzgg"></span>
										<p>通知公告</p>
									</div>
									<!--<div class="lcreqitem NewPop" data-url="<?php /*echo spUrl('applyFill', 'adduse')*/?>"data-title="办公用品申请">-->
									<div class="lcreqitem" onclick="fill_apply(7)" data-title="办公用品申请">
										<span class="lcimg lc_bgyp"></span>
										<p>办公用品</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="pdX10">
							<div class="lcreq">
								<div class="lcreqtit">基础</div>
								<div class="lcreqcont">
									<!--<div class="lcreqitem NewPop"data-url="<?php /*echo spUrl('applyFill', 'adddatwork')*/?>"data-title="添加工作日报">-->
									<div class="lcreqitem" onclick="fill_apply(8)" data-title="添加工作日报">
										<span class="lcimg lc_gzrb"></span>
										<p>工作日报</p>
									</div>
									<div class="lcreqitem" onclick="fill_apply(9)" data-title="添加任务">
										<span class="lcimg lc_rw"></span>
										<p>任务</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row pdX10 top20">
					<div class="col-6">
						<div class="pdX10">
							<div class="lcreq">
								<div class="lcreqtit">人事</div>
								<div class="lcreqcont">
									<div class="lcreqitem" onclick="fill_apply(12)" data-title="转正申请">
										<span class="lcimg lc_zzsq"></span>
										<p>转正申请</p>
									</div>
										<div class="lcreqitem" onclick="fill_apply(13)" data-title="转正申请">
										<span class="lcimg lc_lzsq"></span>
										<p>离职申请</p>
									</div>
									<div class="lcreqitem"  onclick="fill_apply(14)" data-title="人事调动">
										<span class="lcimg lc_rsdd"></span>
										<p>人事调动</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="pdX10">
							<div class="lcreq">
								<div class="lcreqtit">考勤</div>
								<div class="lcreqcont">
									<div class="lcreqitem" onclick="fill_apply(10)" data-title="请假申请">
										<span class="lcimg lc_qjt"></span>
										<p>请假条</p>
									</div>
									<div class="lcreqitem"onclick="fill_apply(11)" data-title="打卡异常">
										<span class="lcimg lc_dkyc"></span>
										<p>打卡异常</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
