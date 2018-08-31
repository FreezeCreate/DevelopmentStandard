
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/usercont.css"/>
</head>
<body>
	<div class="Mark">
		<div class="usermsg">
			<div class="usermsgtit">
				<span>成交客户信息录入</span>
				<span class="usermsg-clos"></span>
			</div>
			<div class="usermsg-con">
				<table class="table border">
					<tr>
						<td><i class="colorRed">*</i>项目名称</td>
						<td colspan="5"><input type="text" class="input long" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>购买房号</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>建筑面积</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>套内面积</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>客户名称</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>联系电话</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>身份证号</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>联系地址</td>
						<td colspan="5"><input type="text" class="input long" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>认购日期</td>
						<td><input type="text" class="input dates" name="" id="" value="" readonly="readonly"/></td>
						<td><i class="colorRed">*</i>签约日期</td>
						<td><input type="text" class="input dates" name="" id="" value="" readonly="readonly"/></td>
						<td><i class="colorRed">*</i>放款日期</td>
						<td><input type="text" class="input dates" name="" id="" value="" readonly="readonly"/></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>成交金额</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>按揭金额</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>付款方式</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td>按揭银行</td>
						<td colspan="5"><input type="text" class="input long" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td><i class="colorRed">*</i>业务员</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>客户渠道</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
						<td><i class="colorRed">*</i>归属公司</td>
						<td><input type="text" class="input" name="" id="" value="" /></td>
					</tr>
					<tr>
						<td>其他</td>
						<td colspan="5"><input type="text" class="input long" name="" id="" value="" /></td>
					</tr>
				</table>
				<div class="top20 textCenter">
					<span class="husbtn qr">确认</span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var parents = parent;
	$(function(){
		$('.usermsg').css({'animation': 'zoomIn .3s forwards'})
		
		$('.usermsg-clos').click(function(){
			
			$('.usermsg').css({'animation': 'zoomOut .3s forwards'})
			setTimeout(function(){ parents.window.closPop() }, 300)
		})
	})
</script>