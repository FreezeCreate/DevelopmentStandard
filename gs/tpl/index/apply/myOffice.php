<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>办公用品申请</title>
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
			<div class="FrameTit"><span class="FrameTitName">办公用品资料</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">办公用品资料</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">编号：</td>
                                <td><?php echo $result['id'] ?></td>
                                <td class="FrameGroupName">分类：</td>
                                <td><?php echo $result['type'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">规格：</td>
                                <td><?php echo $result['model'] ?></td>
                                <td class="FrameGroupName">单位：</td>
                                <td><?php echo $result['unit'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">单价：</td>
                                <td><?php echo $result['price']; ?>元</td>
                                <td class="FrameGroupName">押金：</td>
                                <td><?php echo $result['money'];?>元</td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 说明：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
             </div>
                    <div class="FrameTableFoot">
                   </div>
            </div>

    </body>

</html>

<script>
            $(function(){
            $('.FrameBox').height($(window).height()-$('.FrameTit')[0].offsetHeight-$('.FrameTableFoot')[0].offsetHeight)
            window.onresize = function() {
               $('.FrameBox').height($(window).height()-$('.FrameTit')[0].offsetHeight-$('.FrameTableFoot')[0].offsetHeight)
            }});
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