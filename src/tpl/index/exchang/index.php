
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
						<a href="<?php echo spUrl('exchang', 'exmsg')?>">
						<img class="exuserimg" src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
						<span class="exmsg">12</span>
						</a>
					</div>
					<p class="exusnam">海阔天空</p>
					<p class="exqm"><span>唯有年轻是我们唯一有权利去编写的时光</span><i class="bj"></i></p>
					<p class="exbj">
						<input type="text" class="exbjinp" name="" id="" value="唯有年轻是我们唯一有权利去编写的时光" />
						<span class="exbjtj">确定</span>
					</p>
				</div>
			</div>
		</div>
		<div class="excont">
			<div class="exbody">
				<div class="exfb">
					<p class="exfbtit">发布动态</p>
					<div class="exfbinpbox">
						<textarea class="exfbinp"></textarea>
					</div>
					<ul class="exupimg">
						<li class="exupitem tp">图片</li>
						<li class="exupitem sp">视屏</li>
						<li class="exupitem dw">定位</li>
						<li class="exupitem exsubmit">发布</li>
					</ul>
					<div class="fbbox">
						<span class="squer"></span>
						<i class="squerin"></i>
						<input type="file" class="None" id="upinput" />
						<span class="upclos"></span>
						<p class="fbbne">本地上传</p>
						<ul class="imgsboxs">
							<li class="imgsit upcontol" onclick="$('#upinput').click()">+</li>
						</ul>
					</div>
				</div>
				<ul class="excontent">
					<li class="excontitem">
						<span class="excontitemdel"></span>
						<div class="itemtit">
							<div class="itemtitimg"><img class="exuserimg" src="<?php echo SOURCE_PATH?>/images/user/user.png"/></div>
							<div class="itemttitcon">
								<p class="itemna">鱼与飞鸟</p>
								<p class="itemti">今天14:00</p>
								<p class="itemtex">今天新发布了一个房源，环境不错，大家可以看看</p>
								<ul class="itemimgbox">
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
								</ul>
								<p class="itemdw">成都成华区长岛国际社区</p>
								<p class="itemll">
									<span class="ll">浏览100次</span>
									<span class="pl">评论（<i class="plnum">1</i>）</span>
									<span class="dz">点赞（<i class="dznum">1</i>）</span>
								</p>
								<div class="recod">
									<span class="squ"></span>
									<div class="hddz">
										<span>小王</span>
									</div>
									<div class="pljl">
										<p><span class="nam">小王：</span><span>已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮</span></p>
										<p><span class="nam">小王：</span><span>已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮</span></p>
									</div>
								</div>
								<div class="plbox">
									<textarea class="plinp"></textarea>
									<div class="plfb"><span class="plqx">取消</span><span class="plsub">发表</span></div>
								</div>
							</div>
						</div>
					</li>
					<li class="excontitem">
						<div class="itemtit">
							<div class="itemtitimg"><img class="exuserimg" src="<?php echo SOURCE_PATH?>/images/user/user.png"/></div>
							<div class="itemttitcon">
								<p class="itemna">鱼与飞鸟</p>
								<p class="itemti">今天14:00</p>
								<p class="itemtex">今天新发布了一个房源，环境不错，大家可以看看</p>
								<ul class="itemimgbox">
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
									<li class="itemimgit h-center"><img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png"/></li>
								</ul>
								<p class="itemdw">成都成华区长岛国际社区</p>
								<p class="itemll">
									<span class="ll">浏览100次</span>
									<span class="pl">评论（<i class="plnum">1</i>）</span>
									<span class="dz">点赞（<i class="dznum">1</i>）</span>
								</p>
								<div class="recod">
									<span class="squ"></span>
									<div class="hddz">
										<span>小王</span>
									</div>
									<div class="pljl">
										<p><span class="nam">小王：</span><span>已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮</span></p>
										<p><span class="nam">小王：</span><span>已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮</span></p>
									</div>
								</div>
								<div class="plbox">
									<textarea class="plinp"></textarea>
									<div class="plfb"><span class="plqx">取消</span><span class="plsub">发表</span></div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="dztc">
			<div class="dztcbox">
				<div class="dztit"><span>选择地址</span><span class="dzclos"></span></div>
				<div class="dzc">
					<ul>
						<li class="dzit active">不显示</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
						<li class="dzit">某某某地址某某某地址某某某地址</li>
					</ul>
				</div>
				<div class="dzbtn">
					<span class="bt qx">取消</span>
					<span class="bt qr">确定</span>
				</div>
			</div>
		</div>
		<div class="lilan">
			<div class="lilanbox">
				<div class="lilantit"><span>看过此动态的人</span><span class="dtclos"></span></div>
				<div class="licon">
					<ul>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
						<li class="liitem">
							<img src="<?php echo SOURCE_PATH?>/images/user/user.png"/>
							<span class="na">海阔天空</span>
							<span class="ta">今天：12:00</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('.bj').click(function(){
		$('.exqm').toggle()
		$('.exbj').toggle()
		$('.exbjinp').val($('.exqm span').text())
	})
	$('.exbjtj').click(function(){
		$('.exqm').toggle()
		$('.exbj').toggle()
		$('.exqm span').text($('.exbjinp').val())
	})
	
	$('#upinput').change(function(){
		$('.upcontol').before(
			'<li class="imgsit h-center"><div>'
			+'<img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png" alt="" />'
			+'<div class="upmk"><i class="updel"></i></div></div></li>'
		)
		$('#upinput').val('')
	})
	
	$(document).on('click', '.updel', function(){
		var that = $(this);
		Confirm('确定删除？', function(e){
			if(e){
				that.parent().parent().parent().remove()
			}
		})
	})
	$(document).on('click', '.dz', function(){
		var that = $(this);
		that.toggleClass('active')
		if(that.hasClass('active')){
			that.parent().next().children('.hddz').append('<span class="xw">小王</span>')
			that.children('.dznum').text(that.children('.dznum').text()-0+1)
		}else{
			that.parent().next().children('.hddz').children('.xw').remove()
			that.children('.dznum').text(that.children('.dznum').text()-0-1)
		}
	})
	$(document).on('click', '.excontitemdel', function(){
		var that = $(this);
		Confirm('确定删除？', function(e){
			if(e){
				that.parent().remove()
			}
		})
	})
	var arr = [
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
		{'type': 'video', 'url': '<?php echo SOURCE_PATH?>/move/mov_bbb.mp4'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
		{'type': 'video', 'url': '<?php echo SOURCE_PATH?>/move/mov_bbb.mp4'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_1.png'},
		{'type': 'img', 'url': '<?php echo SOURCE_PATH?>/images/houses/house_2.png'},
		{'type': 'video', 'url': '<?php echo SOURCE_PATH?>/move/mov_bbb.mp4'},
	]
	$('.itemimgit').click(function(){
		var that = $(this)
		bigimg(arr,that.index())
	})
	$('.bt.qr').click(function(){
		var val = $('.dzit.active').text()
		alert(val)
	})
	$(document).on('click', '.plsub', function(){
		var that = $(this);
		var val = that.parent().prev().val();
		alert(val)
		that.parent().parent().prev().children('.pljl').append('<p><span class="nam">小王：</span><span>已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮已经去看过了，很漂亮</span></p>')
		that.parent().parent().hide()
	})
</script>