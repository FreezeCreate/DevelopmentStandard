

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH?>/css/myuser.css"/>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<ul class="grpBtn">
					<li class="grpBtnItem active">所有客户</li>
					<li class="grpBtnItem">带看客户</li>
					<li class="grpBtnItem">报备客户</li>
					<li class="grpBtnItem">成交客户</li>
					<li class="grpBtnItem">签约客户</li>
				</ul>
				<span>项目</span>
				<input type="text" class="input radius mg-r-10" name="" id="" value="" />
				<span class="mg-r-6">日期</span>
				<input type="text" class="input radius dates" name="" id="" value="" />
				<label>
					<input type="text" class="input radius text1" name="" id="" value="" readonly="readonly" onclick="parent.window.ChousPerson(Use, 'one', '.text1', '.text2', this)" placeholder="点击选择负责人"/>
					<input type="hidden" class="text2" name="" id="" value="" />
				</label>
				<span class="btn btn-sm btn-primary">查询</span>
				<span class="btn btn-info btn-sm" onclick="Refresh()">刷新</span>
				<span class="btn btn-success btn-sm float-right NewHtml"data-clas="a_xzkh"data-name="新增客户"data-url="<?php echo spUrl('myuser', 'adduser')?>">新增客户</span>
			</div>
			<div class="top20">
				<span>选择时间段：</span>
				<select name="" class="input">
					<option value="">一周内</option>
					<option value="">10天内</option>
					<option value="">15天内</option>
					<option value="">30天内</option>
				</select>
				<span>选择状态：</span>
				<select name="" class="input">
					<option value="">报备确认</option>
					<option value="">带看成功</option>
					<option value="">客户认筹</option>
					<option value="">客户认购</option>
					<option value="">客户签约</option>
					<option value="">客户未成功</option>
					<option value="">未成交</option>
				</select>
				<span>选择客户状态：</span>
				<select name="" class="input">
					<option value="">客户异常</option>
					<option value="">正常客户</option>
				</select>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead class="bg">
						<tr>
							<td>姓名</td>
							<td>性别</td>
							<td>年龄</td>
							<td>电话</td>
							<td>时间</td>
							<td>标签</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody class="hover">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>李冰</td>
							<td>男</td>
							<td>18-25</td>
							<td>1655456545</td>
							<td>2018-05-12</td>
							<td class="userbtns" width="450"><span class="khzt">客户异常</span><span class="dzzt">带看成功</span><span class="sjzq">一周内</span></td>
							<td><span class="colorBlu  NewHtml"data-url="<?php echo spUrl('myuser', 'usercont')?>"data-name="用户详情"data-clas="a_content">详情</span></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<?php require_once TPL_DIR . '/layout/page.php'; ?>
		</div>
	</body>
</html>
<script type="text/javascript">
	jeDate({
		dateCell:".dates",
		format:"YYYY-MM-DD",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){alert(val)}
	})
</script>