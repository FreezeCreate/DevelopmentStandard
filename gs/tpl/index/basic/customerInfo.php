<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
    <script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <div class="FrameTableTitl">客户详情</div>
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName" width="20%">客户名称：</td>
                                <td class="" width="30%"><?php echo $result['company'] ?></td>
                                <td class="FrameGroupName">负责人：</td>
                                <td><?php echo $result['name'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName" width="20%">联系电话：</td>
                                <td class=""width="30%"><?php echo $result['phone'] ?></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 地区：</td>
                                <td><?php echo $result['address'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">供货产品类别：</td>
                                <td><?php echo $result['goodstype'] ?></td>
                                <td class="FrameGroupName">顾客信誉等级</td>
                                <td><?php echo $result['relevel'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="FrameTableFoot">
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, $a); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                     
                    Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>

