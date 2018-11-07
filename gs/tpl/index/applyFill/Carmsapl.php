<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>车辆预定</title>
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
			<div class="FrameTit"><span class="FrameTitName">车辆预定</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">车辆预定</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">申请时间：</td>
                                <td><input class="FrameGroupInput" readonly="readonly" type="text" value="<?php echo empty($result['applydt']) ? date('Y-m-d') : $result['applydt']; ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 申请人：</td>
                                <td><?php echo $result['uname'] ? $result['uname'] : $admin['name'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 开始时间：</td>
                                <td><input class="FrameGroupInput FrameDatGroup" id="start"  type="text" name="start" value="<?php echo empty($result['start']) ? '' : $result['start']; ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 截止时间：</td>
                                <td><input class="FrameGroupInput notenter FrameDatGroup" id="end" type="text" name="end" value="<?php echo empty($result['end']) ? '' : $result['end']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 目的地：</td>
                                <td><input class="FrameGroupInput" type="text" name="mudi" value="<?php echo empty($result['mudi']) ? '' : $result['mudi']; ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 路线：</td>
                                <td><input class="FrameGroupInput" type="text" name="luxian" value="<?php echo empty($result['luxian']) ? '' : $result['luxian']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 预定车辆：</td>
                                <td>
                                    <select class="FrameGroupInput" name="gid">
                                        <option value="">请选择...</option>
                                        <?php foreach ($carms as $v) { ?>
                                            <option <?php echo $v['id'] === $result['gid'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">说明</td>
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
    jeDate({
        dateCell: "#start", //isinitVal:true,
        format: "YYYY-MM-DD hh:mm",
        isTime: true, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#end", //isinitVal:true,
        format: "YYYY-MM-DD hh:mm",
        isTime: true, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });

    function do_sub() {
       // loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCarmsapl"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                   //loading('none');
                   
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