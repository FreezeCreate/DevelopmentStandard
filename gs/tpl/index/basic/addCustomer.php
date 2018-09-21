<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
    <script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var Use;
//        var Pos;
//        var Dep;
        $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
            Use = {}
            Use.status = 2;
            Use.data = data.data[0].children;
        }, 'json');
            //职位
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
            //部门
//            $.get('<?php  echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');
    </script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <div class="FrameTableTitl">新增客户</div>
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName" width="20%"><span style="color:red;">*</span> 客户名称：</td>
                                <td class="" width="30%"><input class="FrameGroupInput" type="text" name="company" id="" value="" /></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 负责人：</td>
                                <td>
                                    <input class="FrameGroupInput" type="text" name="name" placeholder="" value="<?php echo $result['name'] ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName" width="20%"><span style="color:red;">*</span> 联系电话：</td>
                                <td class=""width="30%"><input class="FrameGroupInput" type="text" name="phone" id="" value="" /></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 地区：</td>
                                <td><input class="FrameGroupInput" type="text" name="address" id="" value="" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">供货产品类别：</td>
                                <td><input class="FrameGroupInput" type="text" name="goodstype" id="" value="" /></td>
                                <td class="FrameGroupName">顾客信誉等级</td>
                                <td><input class="FrameGroupInput" type="text" name="relevel" id="" value="" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注：</td>
                                <td colspan="3">
                                    <textarea class="FrameGroupInput Lang" name="explain"></textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
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

