<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/forget.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="main">
			<div class="header">
				<i class="headerLine"></i>
				<div class="logo">
					<p>LOGG</p>
					<p>乐居邦</p>
				</div>
				<span class="pgN">找回密码</span>
			</div>
			<div class="path">
				<ul class="pathBox">
					<li class="pathItem active">
						<div class="roundBox">
							<div class="round">1</div>
						</div>
					</li>
					<li class="pathItem active">
						<div class="roundBox">
							<div class="round">2</div>
						</div>
					</li>
					<li class="pathItem">
						<div class="roundBox">
							<div class="round">3</div>
						</div>
					</li>
					<li class="pathItem last">
						<div class="roundBox"></div>
					</li>
				</ul>
			</div>
			<div class="forgetForm">
				<div class="regLin">
					<label>
						<span class="regName">新密码:</span>
						<input class="regVal" type="tex"/>
					</label>
				</div>
				<div class="regLin">
					<label>
						<span class="regName">确认密码:</span>
						<input class="regVal" type="tex"/>
					</label>
				</div>
				<a class="nextBtn" href="<?php echo spUrl('passport', 'forget_2') ?>">下一步</a>
			</div>
		</div>
	</body>
	<script type="text/javascript">
//		$('.nextBtn').click(function(){
//			window.location.href = 'forget_2.html'
//		})
	</script>
</html>
