
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/usercont.css"/>
</head>
<body>
	<div class="Mark">
		<div class="userback">
			<div class="usermsgtit">
				<span>添加跟进情况</span>
				<span class="usermsg-clos"></span>
			</div>
			<div class="userbackcon">
				<textarea class="userarea"></textarea>
			</div>
			<div class="userbackbtn">
				<span class="backbtn qr">确认</span>
				<span class="backbtn fh">取消</span>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var parents = parent;
	$(function(){
		$('.userback').css({'animation': 'zoomIn .3s forwards'})
		
		$('.usermsg-clos').click(function(){
			
			$('.userback').css({'animation': 'zoomOut .3s forwards'})
			setTimeout(function(){ parents.window.closPop() }, 300)
		})
	})
</script>