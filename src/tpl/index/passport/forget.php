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
					<li class="pathItem">
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
						<span class="regName">手机号:</span>
						<input class="regVal" type="tex" id="phone"/>
					</label>
				</div>
				<div class="regLin phone">
					<label>
						<span class="regName">验证码:</span>
						<input class="regVal" type="tex"/>
					</label>
				</div>
				<span class="yzm">获取验证码</span>
				<a class="nextBtn" href="<?php echo spUrl('passport', 'forget_1') ?>">下一步</a>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$('.yzm').click(function(){
			if( $(this).hasClass('active') ){
				return;
			}else{
				
				if( $('#phone').val().trim() == '' ) { return Alert('请输入手机号码') }
				
				var phone = /^1(3[0-9]|5[189]|8[6789])[0-9]{8}$/;
				if( !phone.test($('#phone').val().trim()) ) { return Alert('手机号格式不正确') }
				
				var num = 10;
				$('.yzm').addClass('active');
				$('.yzm').text('从新获取('+num+')');
				var timer = setInterval(function(){
					if( --num == 0 ){ return end() };
					$('.yzm').text('从新获取('+num+')');
				},1000);
				function end(){
					clearInterval(timer);
					$('.yzm').removeClass('active');
					$('.yzm').text('获取验证码');
				};
			}
		})
//		$('.nextBtn').click(function(){
//			window.location.href = 'forget_1.html'
//		})
	</script>
</html>
