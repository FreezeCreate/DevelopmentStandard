<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>办公用品</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/apply.css" />
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="content" style="width: 800px;">
            <div class="ptitle">物料用品</div>
            <div class="info">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <table class="table01">
                        <tbody>
                            <tr>
                                <td><span style="color:red;">*</span> 名称：</td>
                                <td><input class="form-control" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                                <td><span style="color:red;">*</span> 分类：</td>
                                <td>
                                    <select class="form-control" name="type">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['OFFICE_TYPE'] as $v) { ?>
                                            <option <?php echo $v === $result['type'] ? 'selected=""' : '' ?> value="<?php echo $v ?>"><?php echo $v ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>规格</td>
                                <td><input type="text" class="form-control" name="model" value="<?php echo $result['model'] ?>"/></td>
                                <td>型号</td>
                                <td><input type="text" class="form-control" name="format" value="<?php echo $result['format'] ?>"/></td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td colspan="3"><textarea class="form-control" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="center">
                        <a class="but but-primary" onclick="do_sub()"><?php echo empty($result['id']) ? '提交' : '更新'; ?></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>
    </body>

</html>

<script>

    $(function() {
        
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveOffice"); ?>",
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