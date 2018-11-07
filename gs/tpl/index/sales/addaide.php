<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>销售助手</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/kindeditor-min.js"></script>
        <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/lang/zh_CN.js"></script>
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">销售助手</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameTableTitl">销售助手</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName" style="width: 150px;"><span style="color:red;">*</span> 标题</td>
                                <td colspan="3"><input class="FrameGroupInput" style="width: 80%;" type="text" name="title" value="<?php echo $result['title'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">内容</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="content"><?php echo $result['content'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
          <div class="FrameTableFoot">
        <a class="but but-primary" onclick="do_sub()"><span class="Btn Big">保存</span></a>
        </div>
    </div>
  </body>

</html>

<script>

    KindEditor.ready(function(K) {
        K.create('textarea[name="content"]', {
            width: 500,
            autoHeightMode: true,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            afterCreate: function() {
            },
            afterBlur: function() {
                this.sync()
            },
        });
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('sales', "saveAide"); ?>",
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
                     
                    Alert(data.msg);
                    parent.closHtml();
                    // Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }

</script>