
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/lpcont.css"/>
	<script src="<?php echo SOURCE_PATH?>/js/lpadd.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml bgf1">
			<div class="fbitem"><p class="fbmsg">填写信息 <span class="btn btn-sm btn-primary float-right"onclick="Refresh()">刷新</span></p></div>
			<div class="fbitem top20">
				<p class="fbmsg bord">基本信息</p>
				<ul>					
					<li class="fbmsg">
						<span class="fbnam">项目名称</span>
						<input type="text" class="input long" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">户型</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">室</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">厅</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">卫</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">面积</span>
						<input type="text" class="input" name="" id="" value="" />
						<span>㎡</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">所在地区</span>
						<div class="input gsTog"><span class="provice"></span> <span class="city"></span> <span class="area"></span></div>
						<input type="hidden" name="province" id="province" value=""/>
						<input type="hidden" name="city" id="city" value=""/>
						<input type="hidden" name="area" id="area" value=""/>
						<div class="gs">
							<div class="gsBox">
								<div class="gsNav">
									<ul>
										<li class="dzItem active">省</li>
										<li class="dzItem">市</li>
										<li class="dzItem">区</li>
									</ul>
									<span class="close"></span>
								</div>
								<div class="dzCon">
									<ul class="ItemBox">
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li class="fbmsg">
						<span class="fbnam">详细地址</span>
						<input type="text" class="input long" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">总价</span>
						<input type="text" class="input" name="" id="" value="" />
						<span>万元</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">单价</span>
						<input type="text" class="input" name="" id="" value="" />
						<span>万元</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">装修状况</span>
						<select name=""class="input">
							<option value="">毛坯</option>
							<option value="">清水</option>
							<option value="">简装</option>
							<option value="">精装</option>
						</select>
					</li>
					<li class="fbmsg">
						<span class="fbnam">楼层</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span class="mg-r-6">层，共</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span>层</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">朝向</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">建筑类型</span>
						<select name="" class="input">
							<option value="">板房</option>
							<option value="">板房</option>
							<option value="">板房</option>
						</select>
					</li>
					<li class="fbmsg">
						<span class="fbnam">栋</span>
						<input type="text" class="input input-sm mg-r-20" name="" id="" value="" />
						<span class="fbnam">单元</span>
						<input type="text" class="input input-sm mg-r-20" name="" id="" value="" />
						<span class="fbnam">门牌号</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
					</li>
					<li class="fbmsg"></li>
				</ul>
			</div>
			<div class="fbitem top20">
				<p class="fbmsg bord">其他信息</p>
				<ul>
					<li class="fbmsg">
						<span class="fbnam">开盘时间</span>
						<input type="text" class="input dates" name="" id="" value="" readonly="readonly"/>
					</li>
					<li class="fbmsg">
						<span class="fbnam">交房时间</span>
						<input type="text" class="input dates" name="" id="" value="" readonly="readonly"/>
					</li>
					<li class="fbmsg">
						<span class="fbnam">开发商</span>
						<input type="text" class="input long" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">产权年限</span>
						<input type="text" class="input input-sm mg-r-30" name="" id="" value="" />
						<span class="fbnam">绿化率</span>
						<input type="text" class="input input-sm mg-r-30" name="" id="" value="" />
						<span class="fbnam">容积率</span>
						<input type="text" class="input input-sm mg-r-30" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">规划户数</span>
						<input type="text" class="input input-sm mg-r-30" name="" id="" value="" />
						<span class="fbnam">车位数</span>
						<input type="text" class="input input-sm mg-r-30" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">物业费</span>
						<input type="text" class="input input-sm" name="" id="" value="" />
						<span>元/平米/月</span>
					</li>
					<li class="fbmsg">
						<span class="fbnam">物业公司</span>
						<input type="text" class="input long" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">销售许可证</span>
						<input type="text" class="input long" name="" id="" value="" />
					</li>
					<li class="fbmsg">
						<span class="fbnam">报备有效期</span>
						<input type="text" class="input dates" name="" id="" value="" readonly="readonly"/>
					</li>
					<li class="fbmsg">
						<span class="fbnam">带看有效期</span>
						<input type="text" class="input dates" name="" id="" value="" readonly="readonly" />
					</li>
					<li class="fbmsg"></li>
				</ul>
			</div>
			<div class="fbitem top20">
				<p class="fbmsg bord">项目描述</p>
				<div class="pdY20 pdX20">
					<textarea class="input" style="width: -webkit-fill-available;height: 200px;"></textarea>
				</div>
			</div>
			<div class="fbitem top20">
				<p class="fbmsg bord">更多设置</p>
				<ul>
					<li class="fbmsg">
						<span class="fbnam">佣金</span>
						<input type="text" class="input input-sm" name="" id="" value=""/>
						<label for="yjxs"><span class="radio">显示</span><input type="radio" name="yj" id="yjxs" class="None" value="" /></label>
						<label for="yjbxs"><span class="radio">不显示</span><input type="radio" name="yj" class="None" id="yjbxs" value="" /></label>
					</li>
					<li class="fbmsg">
						<span class="fbnam">带看费</span>
						<input type="text" class="input input-sm" name="" id="" value=""/>
						<label for="dkfxs"><span class="radio">显示</span><input type="radio" class="None" name="dkf" id="dkfxs" value="" /></label>
						<label for="dkfbxs"><span class="radio">不显示</span><input type="radio" class="None" name="dkf" id="dkfbxs" value="" /></label>
					</li>
				</ul>
			</div>
			<div class="fbitem top20">
				<p class="fbmsg bord">上传图片</p>
				<input type="file" name="upImg" class="None" id="upImg" value="" />
				<ul class="fbimgbox images">
					<li class="fbimgitem h-center">
						<div>
							<img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png" alt="" />
							<div class="mkr"><span class="mkrclos"></span></div>
							<input type="hidden" name="" id="" value="" />
						</div>
					</li>
					<li class="fbimgitem h-center imgup" onclick="$('#upImg').click()">
						<div>
							<div class="upim img"></div>
							<p>添加图片</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="fbitem top20">
				<p class="fbmsg bord">上传视屏</p>
				<input type="file" name="upVideo" class="None" id="upVideo" value="" />
				<ul class="fbimgbox videos">
					<li class="fbimgitem h-center">
						<div>
							<img src="<?php echo SOURCE_PATH?>/images/houses/house_1.png" alt="" />
							<div class="mkr"><span class="mkrclos"></span></div>
							<input type="hidden" name="" id="" value="" />
						</div>
					</li>
					<li class="fbimgitem h-center videoup" onclick="$('#upVideo').click()">
						<div>
							<div class="upim video"></div>
							<p>添加视屏</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="fbbtns">
				<span class="fbbtn qr">确定</span>
				<span class="fbbtn qx">取消</span>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	var ads = { p_name: '', p_id: '', c_name: '', c_id: '', a_name: '', a_id: '' };
	var num = 0;
	function adsReq(pid){
		$('.ItemBox').children().remove();
		$.ajax({
			type: "POST",
		    url: "/basic/findAddress",
		    data: { 'pid': pid, 't': new Date() },
		    dataType: "json",
		    success: function(res){
			    //console.log(res)
		    	setAds(res)
		    }
		});
	};
	
	function setAds(a){
		var str = '';
		$.each(a, function(k,v) {
			str += '<li class="Item"data-id="'+v.aid+'">'+v.name+'</li>'
		});
		$('.ItemBox').append(str)
	};
	jeDate({
		dateCell:".dates",
		format:"HH:mm:ss",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){alert(val)}
	})
	$('#upImg').change(function(){
		$('.imgup').before(
			'<li class="fbimgitem h-center"><div><img src="/source/images/houses/house_1.png" alt="" />'
			+'<div class="mkr"><span class="mkrclos"></span></div><input type="hidden" name="" id="" value="" /></div></li>'
		)
		$('#upImg').val('')
	})
	$('#upVideo').change(function(){
		$('.videoup').before(
			'<li class="fbimgitem h-center"><div><img src="/source/images/houses/house_1.png" alt="" />'
			+'<div class="mkr"><span class="mkrclos"></span></div><input type="hidden" name="" id="" value="" /></div></li>'
		)
		$('#upVideo').val('')
	})
	$(document).on('click', '.mkrclos', function(){
		var that = $(this);
		parent.window.Confirm('确定删除？', function(boo){
			if(boo){
				that.parent().parent().parent().remove()
			}
		})
	})
</script>