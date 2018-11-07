

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/myuser.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<span>客户情况</span>
			</div>
			<div class="userbtns top20">
				<span class="khzt">客户异常</span>
				<span class="dzzt">带看成功</span>
				<span class="sjzq">一周内</span>
			</div>
			<div class="top20">
				<span class="umsg">客户：李冰 （男）</span>
			</div>
			<div class="top20">
				<span class="umsg">年龄：18-25</span>
				<span class="umsg">意向楼盘：成都蓝光长城半岛国际</span>
			</div>
			<div class="top20">
				<span class="umsg">电话：1655456545</span>
				<span class="umsg">客户情况：某某某情况</span>
			</div>
			<div class="top20">
				<p class="xgxx">修改信息</p>
				<div class="changbox">
					<div class="xgitem">
						<span class="xgitman">负责人：</span>
						<span class="text1 xgval">李勇</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)"></span>
					</div>
					<div class="xgitem">
						<span class="xgitman">客户途径：</span>
						<span class="text1 xgval">短信</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn"></span>
					</div>
					<div class="xgitem">
						<span class="xgitman">预算单价：</span>
						<span class="text1 xgval">5000-6000,7000-8000,8000-9000</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn"></span>
					</div>
					<div class="xgitem">
						<span class="xgitman">预算总价：</span>
						<span class="text1 xgval">5000-6000万</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn"></span>
					</div>
					<div class="xgitem">
						<span class="xgitman">物业类型：</span>
						<span class="text1 xgval">商铺；酒店；公寓；其他；写字楼，住宅</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn"></span>
					</div>
					<div class="xgitem">
						<span class="xgitman">物业面积：</span>
						<span class="text1 xgval">20以下；20-50；50-80；80-120</span>
						<input type="hidden" class="text2" name="" id="" value=""/>
						<span class="xgbtn"></span>
					</div>
				</div>
			</div>
			<div class="top20">
				<div class="gj">
					<span>跟进情况</span>
					<span class="addgj Pop"data-url="<?php echo spUrl('applyFill', 'newgj')?>">添加更新+</span>
				</div>
				<table class="table textCenter borderTr">
					<thead>
						<tr>
							<td>接待人</td><td>跟进情况</td><td>跟进时间</td><td><span class="gjhid"></span></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>张三</td><td>带看</td><td>2018-06-06</td><td></td>
						</tr>
						<tr>
							<td>张三</td><td>带看</td><td>2018-06-06</td><td></td>
						</tr>
						<tr>
							<td>张三</td><td>带看</td><td>2018-06-06</td><td></td>
						</tr>
						<tr>
							<td>张三</td><td>带看</td><td>2018-06-06</td><td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="top20">
				<div class="gj">
					<span>报备项目</span>
				</div>
				<table class="table textCenter borderTr">
					<thead>
						<tr>
							<td>项目名称</td><td>项目地址</td><td>项目单价</td><td>项目状态</td><td>项目详情</td><td><span class="gjhid"></span></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>项目名称</td><td>项目地址</td><td>项目单价</td><td>项目状态</td>
							<td class="colorBlu">
								<span class="NewHtml"data-url="<?php echo spUrl('myuser', 'msgshow')?>"data-name="报备详情"data-clas="a_msgcon">项目详情</span>
							</td><td></td>
						</tr>
						<tr>
							<td>项目名称</td><td>项目地址</td><td>项目单价</td><td>项目状态</td>
							<td class="colorBlu">
								<span class="NewHtml"data-url="<?php echo spUrl('myuser', 'msgshow')?>"data-name="报备详情"data-clas="a_msgcon">项目详情</span>
							</td><td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('.gjhid').click(function(){
		$(this).parent().parent().parent().next().toggle()
	})
</script>