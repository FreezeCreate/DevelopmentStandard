
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/exchang.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/exchang.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="exhd">
			<div class="exhdnav">
				<ul class="exnabox">
					<li class="exitem"><a href=""><img src="<?php echo SOURCE_PATH;?>/images/exchang/jl_back.png"/></a></li>
					<li class="exitem"><a href="<?php echo spUrl('main', 'index')?>"><img src="<?php echo SOURCE_PATH;?>/images/exchang/jl_home.png"/></a></li>
				</ul>
				<span class="rbtn" onclick="Refresh()"></span>
			</div>
			<div class="exhdcon h-center">
				<div>
					<div class="exuser">
						<img class="exuserimg" src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
						<span class="exmsg">12</span>
					</div>
					<p class="exusnam">海阔天空</p>
					<p class="exqm"><span>唯有年轻是我们唯一有权利去编写的时光</span></p>
				</div>
			</div>
		</div>
		<div class="excont">
			<div class="exbody">
				<div class="qk"><div class="allqk"><i class="qkbtn"></i><span>全部清空</span></div></div>
				<ul>
					<li class="xxitem">
						<span class="qkbtn"></span>
						<img class="xximg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />
						<div class="xxcon">
							<p class="xxname">小卖 <span class="xxpl">评论</span></p>
							<p class="xxtim">今天14:00</p>
							<div class="xxdetali">
								<img src="<?php echo SOURCE_PATH?>/images/houses/house_2.png"/>
								<div class="xxdet">
									<div class="xxdetbox h-center">
										<p><span class="colorBlu">鱼与飞鱼：</span>新发布了一条房源，佷不错</p>
									</div>
								</div>
							</div>
							<div class="plite">
								<img class="pliteimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />
								<div class="plitecon">
									<p><span class="colorBlu">小名:</span> 这是一条评论这是一条评论这是一条评论</p>
									<p class="plitetim">2018-06-22 <span class="plhf">回复</span></p>
								</div>
							</div>
							<div class="plite">
								<img class="pliteimg" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />
								<div class="plitecon">
									<p><span class="colorBlu">小名:</span> 这是一条评论这是一条评论这是一条评论</p>
									<p class="plitetim">2018-06-22 <span class="plhf">回复</span></p>
									<div class="hfbox">
										<img class="hfim" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />
										<div class="hfbx">
											<p><span class="colorBlu">鱼与非鱼</span> 回复<span class="colorBlu">小明：</span>这是一条评论这是一条评论这是一条评论</p>
											<p class="hft">2018-06-22</p>
										</div>
									</div>
									<div class="hfbox">
										<img class="hfim" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />
										<div class="hfbx">
											<p><span class="colorBlu">鱼与非鱼</span> 回复<span class="colorBlu">小明：</span>这是一条评论这是一条评论这是一条评论</p>
											<p class="hft">2018-06-22</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).on('click', '.plhf', function(){
		var that = $(this);
		if(!that.hasClass('active')){
			$('.plhf').removeClass('active')
			$('.plhfbox').remove()
			that.parent().parent().append(
				'<div class="plhfbox"><textarea class="plhfinp"></textarea><div class="plhfbtn">'
				+'<span class="plbtn qx">取消</span><span class="plbtn qr">确定</span></div></div>'
			)
		}
		that.addClass('active');
	})
	$(document).on('click', '.plbtn.qx', function(){
		$('.plhf').removeClass('active')
		$('.plhfbox').remove()
	})
	$(document).on('click', '.plbtn.qr', function(){
		var that = $(this)
		that.parent().parent().parent().append(
			'<div class="hfbox"><img class="hfim" src="<?php echo SOURCE_PATH?>/images/user/user.png" alt="" />'
			+'<div class="hfbx"><p><span class="colorBlu">鱼与非鱼</span> 回复<span class="colorBlu">小明：</span>这是一条评论这是一条评论这是一条评论</p>'
			+'<p class="hft">2018-06-22</p></div></div>'
		)
		$('.plhf').removeClass('active')
		$('.plhfbox').remove()
	})
	$('.allqk').click(function(){
		Confirm('确定全部删除？', function(e){
			if(e){
				$('.xxitem').remove()
			}
		})
	})
	$(document).on('click', '.xxitem .qkbtn', function(){
		var that = $(this);
		Confirm('确定删除？', function(e){
			if(e){
				that.parent().remove()
			}
		})
	})
</script>