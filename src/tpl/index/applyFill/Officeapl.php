
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		
	<script>
		var Use;
		$.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
			Use = data;
//              alert(Use);
		}, 'json');
	</script>
	</head>
	<body>
		<div class="MainHtml">
			<form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
				<div class="framemain">
				<div class="FrameTableTitl">办公用品申请</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName">填写人 ：</td>
						<td colspan="3"><input class="input long" type="text" name="uname" id="" value="<?php echo $user['cname']?>" readonly="readonly" /></td>
					</tr>
			    <tr>
                    <td class="FrameGroupName">申请部门 ：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" name="dname" value="<?php echo $user['dname']?>" readonly="readonly"/>
                    </td>
                </tr>
					<tr>
						<td class="FrameGroupName">物品类型 ：</td>
						<td colspan="3">
							<input class="input long text1" type="text" name="gname" value=""/>
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">数量 ：</td>
						<td colspan="3">
							<input class="input" type="text" name="num" />
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">申请日期 ：</td>
						<td colspan="3">
							<input class="input dates" type="text" name="optdt" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<td class="FrameGroupName">申请说明 ：</td>
						<td colspan="3">
							<textarea rows="4" class="input" name="explain"></textarea>
						</td>
					</tr>
				</table>
			</div>
			<div class="frameFoot">
				<span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">确定</span>
				<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
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

	function do_sub() {
		//var formData = new FormData($("#upload")[0]);
		$.ajax({
			cache: false,
			type: "POST",
			url: "<?php echo spUrl($c, "adduse"); ?>",
			data: $('#check_form').serialize(),
			//data: formData,
			dataType: "json",
			async: false,
			error: function(request) {
				Alert('提交失败');
			},
			success: function(data) {
				if (data.code == 0) {
//					Alert(data.msg);
//					parent.window.closHtml();
//					Refresh();
					Alert(data.msg, function(){
						parent.window.closHtml();
						Refresh();
					});
				} else {
					Alert(data.msg);
				}
			}
		});
	}
</script>