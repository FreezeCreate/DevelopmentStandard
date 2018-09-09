
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl">添加入职审核</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><input class="input long" type="text" name="" id="" value="" readonly="readonly" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName">姓名 ：</td>
						<td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td class="FrameGroupName"><i class="colorRed">*</i>部门：</td>
						<td colspan="3">
							<select name=""class="input">
								<option value="">--请选择--</option>
								<option value="">汇报类型</option>
								<option value="">汇报类型</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName"><i class="colorRed">*</i>职位：</td>
						<td colspan="3">
							<select name=""class="input">
								<option value="">--请选择--</option>
								<option value="">汇报类型</option>
								<option value="">汇报类型</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">状态：</td>
						<td colspan="3">
							<select name=""class="input">
								<option value="">提交</option>
								<option value="">通过</option>
								<option value="">驳回</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">提交日期 ：</td>
						<td colspan="3">
							<input class="input dates" type="text" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">内容 ：</td>
						<td colspan="3">
							<textarea rows="4" class="input"></textarea>
						</td>
					</tr>
				</table>
			</div>
			<div class="frameFoot">
				<span class="btn btn-success pdX20 mg-r-30">确定</span>
				<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
			</div>
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
		okfun:function(val){/*alert(val)*/}
	})
</script>