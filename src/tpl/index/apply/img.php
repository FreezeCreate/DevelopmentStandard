
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<style type="text/css">
		.Img{max-width:100%;max-height: 100%;}
	</style>
	</head>
	<body>
		<div style="position: fixed;width: 100%;height: 100%;" class="h-center">
			<div><img class="Img" src=""/></div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('.Img')[0].src = parent.window.getSrc()
</script>