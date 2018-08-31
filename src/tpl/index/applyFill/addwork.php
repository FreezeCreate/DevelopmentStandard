
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		<!--人员选择本地数据-->
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<form id="addmen_form">
					<div class="FrameTableTitl">新增奖惩处罚</div>
					<table class="FrameTableCont">
						<tr>
							<td class="FrameGroupName"><i class="colorRed">*</i>申请日期 ：</td>
							<td><input class="input dates" type="text" name="date" id="date" value=""readonly="readonly"  placeholder="点击选择"/></td>
							<td class="FrameGroupName"><i class="colorRed">*</i>奖惩对象 ：</td>
							<td>
								<input class="input text1" type="text" name="oname" id="oname" value="" />
								<input class="input text2" type="hidden" name="oid" id="oid" value="" />
								<span class="btn btn-success btn-sm"  onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span>
							</td>
						</tr>
						<tr>
							<td class="FrameGroupName"><i class="colorRed">*</i>奖惩类型 ：</td>
							<td>
								<select name="type" class="input">
									<option value="奖励">奖励</option>
									<option value="处罚">处罚</option>
								</select>
							</td>
							<td class="FrameGroupName"><i class="colorRed">*</i>奖惩金额 ：</td>
							<td><input class="input" type="text" name="money" id="money" /></td>
						</tr>
						<tr>
							<td class="FrameGroupName"><i class="colorRed">*</i>说明 ：</td>
							<td colspan="3">
								<textarea name="explain" class="input"></textarea>
							</td>
						</tr>
						<tr>
							<td class="FrameGroupName">相关文件 ：</td>
							<td colspan="3">
								<ul class="FileBox"></ul>
								<input class="None addFileVal" type="file" name="" id="" value="" />
								<span class="addFile">+添加文件</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="frameFoot">
					<input type="hidden" name="id" id="eid" value="" />
					<span class="btn btn-success pdX20 mg-r-30" onclick="do_addmen()">确定</span>
					<span class="btn btn-info pdX20" id="addmen" onclick="parent.window.closHtml()">取消</span>
				</div>
			</form>
		</div>
	</body>
</html>
<script type="text/javascript">
	jeDate({
		dateCell:".dates",
		format:"yyy-MM-dd",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){alert(val)}
	})
	$('.addFile').click(function() {
		$(this).prev().click()
	})
	$('.addFileVal').change(function() {
		var val = $(this).val().slice($(this).val().lastIndexOf('\\') + 1);
		$(this).parent().children('.FileBox').append(
			'<li class="FileItem"><span class="FileItemNam">' + val + '</span><span class="DelFile">删除</span></li>'
		)
		$(this).val('')
	})
	$(document).on('click', '.DelFile', function(){ 
		var that = this;
		Confirm('确定删除？', function(e){
			if(e){
				$(that).parent().remove()
			}
		})
	})
</script>