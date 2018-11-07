<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>办公用品领用</title>
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
            <div class="FrameTit"><span class="FrameTitName">办公用品领用</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <form id="check_form">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <div class="FrameTableTitl">办公用品领用</div>
                        <table class="FrameTableCont">
                            <tbody>
                                <tr>
                                    <td class="FrameGroupName">申请日期：</td>
                                    <td><input class="FrameGroupInput notenter" type="text" value="<?php echo date('Y-m-d') ?>"/></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 申请部门：</td>
                                    <td><?php echo $result['udeptname'] ? $result['udeptname'] : $admin['departmentname'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 物品：</td>
                                    <td>
                                        <select class="FrameGroupInput" name="gid">
                                            <option value="">请选择...</option>
                                            <?php foreach ($offices as $v) { ?>
                                                <option <?php echo $v['id'] === $result['gid'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 数量：</td>
                                    <td><input class="FrameGroupInput input-digit" type="text" name="num" value="<?php echo $result['num'] ?>"/></td>
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

    $(function() {
        $(document).on('change', '.fileToUpload', function() {
            loading();
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    loading('none');
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<div class="download"><a class="download-a" itemid="' + data.data.id + '" href="javascript:void(0)">' + data.data.filename + '</a><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="del">删除</span></div>';
                        $('#' + name).val('');
                        $('#' + name).before(txt);
                        loading('none');
                    } else {
                        $('#' + name).val('');
                        loading('none');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });

    });

    function do_sub() {

        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveOfficeapl"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {

                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {

                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);

                }

            }
        });
    }
</script>