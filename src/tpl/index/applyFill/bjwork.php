
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<form id="addmen_form" action="" method="">
					<input type="hidden" name="hide_form" value="1" />
					<input type="hidden" name="id" value="<?php echo $result['id']?>" />
					<div class="FrameTableTitl">编辑参数</div>
					<table class="FrameTableCont">
						<!--<tr>
							<td class="FrameGroupName"><i class="colorRed">*</i>名称 ：</td>
							<td><input class="input" type="text" name="name" id="name" value="" /></td>
							<td></td><td></td>
						</tr>-->
						<!--<tr>
							<td class="FrameGroupName">开始时间 ：</td>
							<td><input class="input dates" type="text" name="stime" id="stime" readonly="readonly" /></td>
							<td class="FrameGroupName">结束时间 ：</td>
							<td><input class="input dates" type="text" name="etime" id="etime" readonly="readonly" /></td>
						</tr>-->
						<tr>
							<td class="FrameGroupName">开始时间 ：</td>
							<td><input class="input" type="text" name="stime" id="stime" /></td>
							<td class="FrameGroupName">结束时间 ：</td>
							<td><input class="input" type="text" name="etime" id="etime" /></td>
						</tr>
						<!--<tr>
							<td class="FrameGroupName">排序 ：</td>
							<td><input class="input" type="text" name="sort" id="sort" value="" /></td>
							<td class="FrameGroupName">取值类型 ：</td>
							<td>
								<select class="input" name="qtype">
									<option value="0">最小值</option>
									<option value="1">最大值</option>
								</select>
							</td>
						</tr>-->
					</table>
				</div>
				<div class="frameFoot">
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
		format:"YYYY-MM-DD",
		isinitVal:false,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){/*alert(val)*/}
	})
	function do_addmen() {
		$.ajax({
			cache: false,
			type: "POST",
			url: "<?php echo spUrl($c, "bjwork"); ?>",
			data: $('#addmen_form').serialize(),
			dataType: "json",
			async: false,
			error: function(request) {},
			success: function(data) {
				if(data.status == 1) {
					$('.men' + data.data.id + ' .data-stime').attr('title', data.data.stime);
					$('.men' + data.data.id + ' .data-stime').text(data.data.stime);
					$('.men' + data.data.id + ' .data-etime').attr('title', data.data.etime);
					$('.men' + data.data.id + ' .data-etime').text(data.data.etime);
					$('#addmen').click();
				} else {
//					Alert(data.msg);
					Alert(data.msg, function(){
						parent.window.closHtml();
						Refresh();
					});
				}
	
			}
		});
	};
	function bjcs(that){
		$('#name').val(that.names)
		$('#stime').val(that.stime)
		$('#etime').val(that.etime)
		$('#sort').val(that.sort)
		$('#qtype').val(that.qtype)
		$('#eid').val(that.id)
	}
	$(function(){
		parent.window.a_13.chan()
	})
</script>