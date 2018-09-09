
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div class="MainHtml">
        <div class="framemain">
            <div class="FrameTableTitl">添加售出</div>
            <table class="FrameTableCont">
            	<tbody class="addbox">
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>填写人 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" readonly="readonly"/></td>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>客户姓名 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                </tr>
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>订单号 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>楼盘 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                </tr>
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>户型 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>售出数量 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                </tr>
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>售出时间 ：</td>
	                    <td><input type="text" class="input dates" name="" id="" value="" /></td>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>售出数量 ：</td>
	                    <td><input type="text" class="input" name="" id="" value="" /></td>
	                </tr>
            	</tbody>
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