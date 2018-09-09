
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>

<link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/lang/zh_CN.js"></script>
<script>
    var Use;
    $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
        Use = data;
//              alert(Use);
    }, 'json');
</script>
</head>
<body>
    <div class="MainHtml">
        <form action="" method="" id="check_form" onsubmit="return false;">
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
            <div class="framemain">
                <div class="FrameTableTitl">添加通知</div>
                <table class="FrameTableCont">
                    <tr>
                        <td class="FrameGroupName">填写人 ：</td>
                        <td colspan="3"><input class="input long" type="text" readonly="readonly" name="" id="" value="<?php echo $user['name']?>" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName"><i class="colorRed">*</i>标题 ：</td>
                        <td colspan="3"><input class="input long" type="text" name="title" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">发送给 ：</td>
                        <td colspan="3">
                            <input class="input long text1" type="text" name="recename" readonly="readonly" placeholder="不选择默认发送给所有人员"/>
                            <input class="input text2" type="hidden" name="receid" />
                            <span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName"><i class="colorRed">*</i>公告内容 ：</td>
                        <td colspan="3">
                            <textarea rows="10" class="input" name="content"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="frameFoot">
                <span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">确定</span>
                <span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
            </div>
        </form>
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
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveInfor"); ?>",
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
