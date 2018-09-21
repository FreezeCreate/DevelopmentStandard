<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>车辆登记信息</title>
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
			<div class="FrameTit"><span class="FrameTitName">车辆登记信息</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    	<div class="FrameTableTitl">车辆登记信息</div>
						<table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">车牌号：</td>
                                <td><?php echo $result['name'] ?></td>
                                <td class="FrameGroupName">类型：</td>
                                <td><?php echo $result['type']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">车辆品牌：</td>
                                <td><?php echo $result['brank'] ?></td>
                                <td class="FrameGroupName">型号：</td>
                                <td><?php echo $result['format']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">购买日期：</td>
                                <td><?php echo $result['date'] ?></td>
                                <td class="FrameGroupName">购买价格：</td>
                                <td><?php echo $result['money']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">状态：</td>
                                <td><?php echo $GLOBALS['CARMS_STATUS'][$result['status']] ?></td>
                                <td class="FrameGroupName">操作人：</td>
                                <td><?php echo $result['optname']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </tbody>
                    </table>
						<p class="FrameListTableTit">处理记录</p>	
                    <table class="table02 FrameListTableItem">
					<thead>	
                            <tr>
                                <td>序号</td>
                                <td >处理人</td>
                                <td >处理状态</td>
                                <td >说明</td>
                                <td >时间</td>
                            </tr>
						</thead>		
						<tbody>
                            <tr>
                                <td>1</td>
                                <td><?php echo $bill['uname'] ?></td>
                                <td>提交</td>
                                <td></td>
                                <td><?php echo $bill['applydt'] ?></td>
                            </tr>
                            <?php foreach ($log as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $k + 2; ?></td>
                                    <td><?php echo $v['checkname']; ?></td>
                                    <td><?php echo $v['statusname']; ?></td>
                                    <td><?php echo $v['explain']; ?></td>
                                    <td><?php echo $v['optdt']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                        <div class="tit">审核处理</div>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table class="table01">
                                <tbody>
                                    <tr>
                                        <td class="FrameGroupName">状态：</td>
                                        <td class="FrameGroupName">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
                                    <tr>
                                        <td>处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>说明：</td>
                                        <td><textarea class="form-control" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="but but-primary" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    <?php } ?>
            </div>
        </div>
		</div>
    </body>

</html>

<script>
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>