
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div class="MainHtml">
        <div class="framemain">
            <div class="FrameTableTitl">添加栏目</div>
            <table class="FrameTableCont">
            	<tbody class="addbox">
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>栏目名称 ：</td>
	                    <td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
	                </tr>
	                <tr>
	                    <td class="FrameGroupName"><i class="colorRed">*</i>栏目内容 ：</td>
	                    <td colspan="3">
	                        <input class="input text1" type="text"/><span class="btn btn-success btn-sm addlm mg-r-10" >添加</span>
	                    </td>
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
	$(document).on('click', '.addlm', function(){
		$('.addbox').append(
			'<tr><td class="FrameGroupName"><i class="colorRed">*</i>栏目内容 ：</td> <td colspan="3">'
	        +'<input class="input text1" type="text"/><span class="btn btn-success btn-sm addlm mg-r-10" >添加</span></td></tr>'
		)
		$(this).after('<span class="btn btn-danger btn-sm deled" >删除</span></td></tr>').remove()
	})
	$(document).on('click', '.deled', function(){
		var that = $(this);
		parent.window.Confirm('确定删除？', function(e){
			if(e){
				that.parent().parent().remove()
			}
		})
	})
</script>