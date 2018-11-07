<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>个人办公用品</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="Frame">
			<div class="FrameTit"><span class="FrameTitName">个人办公用品</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">新增个人用品</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 名称：</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 分类：</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['OFFICE_TYPE'] as $v) { ?>
                                            <option <?php echo $v === $result['type'] ? 'selected=""' : '' ?> value="<?php echo $v ?>"><?php echo $v ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">规格</td>
                                <td><input type="text" class="FrameGroupInput" name="model" value="<?php echo $result['model'] ?>"/></td>
                                 <td class="FrameGroupName">单位</td>
                                <td><input type="text" class="FrameGroupInput" name="unit" value="<?php echo $result['unit'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">单价</td>
                                <td><input type="text" class="FrameGroupInput" name="price" value="<?php echo $result['price'] ?>"/></td>
                                 <td class="FrameGroupName">押金</td>
                                <td><input type="text" class="FrameGroupInput" name="money" value="<?php echo $result['money'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
		  <div class="FrameTableFoot">
		<a class="but but-primary" onclick="do_sub()"><span class="Btn Big"><?php echo empty($result['id']) ? '提交' : '更新'; ?></span></a>
	</div>
  </div>
    </body>

</html>

<script>

    $(function() {
        
    });

    function do_sub() {
        //loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savemyOffice"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
               // loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                   // loading('none');
                     
                    Refresh();
                    Alert(data.msg);
                    parent.window.closHtml();
                } else {
                    alert(data.msg);
                   // loading('none');
                }

            }
        });
    }
</script>