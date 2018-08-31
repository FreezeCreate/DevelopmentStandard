
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/lookcont.css"/>
	</head>
	<body>
		<div class="Mark">
			<div class="lookcont">
				<div class="lookcontit">
					<span>看房记录详情</span>
					<span class="look-cols"></span>
				</div>
				<div class="lccont">
					<p class="lctit">客户详情</p>
					<ul class="lcbox">
						<li class="lcitem">客户姓名：李冰</li>
						<li class="lcitem">电话：1564656545</li>
						<li class="lcitem">性   别：男</li>
						<li class="lcitem">年龄：18-24</li>
					</ul>
					<p class="lctit">项目详情</p>
					<ul class="lcbox">
						<li>看房时间：2018-07-24</li>
						<li>项目：蓝光长岛国际社区</li>
						<li>地址：成都市成华区建设路54号</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(function(){
		$('.lookcont').css({'animation': 'zoomIn .3s forwards'});
		$('.look-cols').click(function(){
			$('.lookcont').css({'animation': 'zoomOut .3s forwards'});
			setTimeout(function(){ parent.window.closPop()}, 300)
		})
	})
</script>