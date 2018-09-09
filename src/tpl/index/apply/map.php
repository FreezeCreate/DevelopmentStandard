
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GN12Dq9THzHCGBP1rehImrvwqdUPr3uf"></script>
	</head>
	<body>
		<div id="allmap"></div>
	</body>
</html>
<script type="text/javascript">
	$(function(){
		$('#allmap').width($(window).width())
		$('#allmap').height($(window).height())
		window.onresize = function(){
			$('#allmap').width($(window).width())
			$('#allmap').height($(window).height())
		}
		// 百度地图API功能
		var map = new BMap.Map("allmap");
		var point = new BMap.Point(parent.window.getJWD().jd, parent.window.getJWD().wd);
		map.centerAndZoom(point, 15);
		var marker = new BMap.Marker(point);  // 创建标注
		map.addOverlay(marker);               // 将标注添加到地图中
		marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
		map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放
	})
</script>