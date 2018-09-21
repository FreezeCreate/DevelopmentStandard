<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>车辆信息</title>
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
			<div class="FrameTit"><span class="FrameTitName">添加车辆信息</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">车辆信息</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 车牌号：</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 类型：</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">请选择...</option>
                                        <option <?php echo $result['type'] == '小型车' ? 'selected=""' : '' ?> value="小型车">小型车</option>
                                        <option <?php echo $result['type'] == '轿车' ? 'selected=""' : '' ?> value="轿车">轿车</option>
                                        <option <?php echo $result['type'] == '货车' ? 'selected=""' : '' ?> value="货车">货车</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 车辆品牌</td>
                                <td><input type="text" class="FrameGroupInput" name="brank" value="<?php echo $result['brank'] ?>"/></td>
                                <td class="FrameGroupName">型号</td>
                                <td><input type="text" class="FrameGroupInput" name="format" value="<?php echo $result['format'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName "><span style="color:red;">*</span> 购买日期</td>
                                <td><input type="text" class="FrameGroupInput FrameDatGroup" id="date" name="date" value="<?php echo $result['date'] ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 购买价格</td>
                                <td><input type="text" class="FrameGroupInput" name="money" value="<?php echo $result['money'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 状态</td>
                                <td>
                                    <select class="FrameGroupInput" name="status">
                                        <?php foreach ($GLOBALS['CARMS_STATUS'] as $k => $v) { ?>
                                            <option <?php echo $result['status'] == $k ? 'selected=""' : '' ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
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
                        <a class="but but-primary" onclick="do_sub()"><span class="Btn Big"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
                    </div>
	</div>
    </body>

</html>

<script>

    $(function() {
        jeDate({
            dateCell: "#date", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        })
    });

    function do_sub() {
       // loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCarms"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
              //  loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                  //  loading('none');
                   
                    Refresh();
                } else {
                    alert(data.msg);
                  //  loading('none');
                }

            }
        });
    }
</script>