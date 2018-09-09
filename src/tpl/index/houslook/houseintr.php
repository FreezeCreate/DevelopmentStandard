
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/houslist.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div>当前楼盘：蓝光长岛国际社区<span> 1栋L4户型</span> <span class="btn btn-sm btn-info" onclick="Refresh()">刷新</span></div>
			<div class="top20">
				<div class="hxbox">
					<div class="hximgbox">
						<div class="hximg h-center">
							<img src="<?php echo SOURCE_PATH?>/images/houses/house_2.png"/>
						</div>
					</div>
					<div class="hxtex">
						<p class="hxtit">户型：一室一厅一卫</p>
						<p class="hxc">价格: 约合45万/套</p>
						<p class="hxc">建筑面积45㎡</p>
						<p class="hxc">剩余户数:33</p>
					</div>
				</div>
				<div class="hxsp">
					<p class="hxspt">视屏播放</p>
					<div class="hxspbf h-center">
						<video>
							<source src="<?php echo SOURCE_PATH?>/move/mov_bbb.mp4" type="video/mp4"></source>
							当前浏览器不支持 video直接播放。
						</video>
						<div class="hxmark h-center">
							<div class="hxplay"></div>
							<div class="hxout"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="top20">
				<p>点击查看图片</p>
				<div class="ypyl">
					<span class="ylbtn prev"></span>
					<span class="ylbtn next"></span>
					<div class="ylbox">
						<ul class="ylitembox">
							<?php for($i = 0; $i < 10; $i++){?>
							<li class="ylitem h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_2.png"/></li>
							<?php }?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).on('click', '.hxplay', function(){
		var that = $(this);
		that.parent().toggleClass('active');
		if(that.parent().hasClass('active')){
			that.parent().prev()[0].play()
		}else{
			that.parent().prev()[0].pause()
		}
	})
	$(document).on('click', '.hxout', function(){
		var that = $(this);
		FullScreen(that.parent().prev()[0])
	})
	$('.ylbtn.prev').click(function(){
		var imgbox = $('.ylitembox');
		var box = $('.ylbox');
		var num = parseInt(imgbox.css('left'));
		if( num < 0 ){
			imgbox.animate({'left': num + box.width() })
		}
	})
	$('.ylbtn.next').click(function(){
		var imgbox = $('.ylitembox');
		var box = $('.ylbox');
		var num = Math.abs(parseInt(imgbox.css('left')));
		if( box.width() + num < imgbox.width()){
			imgbox.animate({'left': -(num + box.width()) })
		}
	})
	var arr = [
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
	]
	$('.ylitem').click(function(){
		var that = $(this)
		parent.window.bigimg(arr,that.index())
	})
</script>