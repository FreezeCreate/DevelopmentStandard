<?php
require_once TPL_DIR . '/layout/con_header.php';
?>

<script src="<?php echo SOURCE_PATH ?>/js/addpower.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
    .jsItem {
        overflow: hidden;
        margin-bottom: 10px;
    }

    .jsItemName {
        float: left;
        text-align: right;
        width: 130px;
        min-height: 14px;
        line-height: 24px;
    }

    .jsItemVal {
        float: left;
        line-height: 24px;
    }
</style>
</head>
<body>
    <div class="MainHtml">
        <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
            <div class="jsItem">
                <span class="jsItemName">角色名称：</span>
                <div class="jsItemVal">
                    <input type="text" class="input" name="name" id="" value="<?php echo isset($result["name"]) ? $result["name"] : ''; ?>" />
                    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
                </div>
            </div>
            <div class="jsItem">
                <span class="jsItemName"></span>
                <label>
                    <span class="checkbox all" data-val="1">全选</span>
                    <input type="checkbox" class="None" name=""  value="" data-type="type" >
                </label>
            </div>
            <?php foreach ($results as $k => $v) { ?>
                <?php if (empty($v['children'])) { ?>
                    <div class="jsItem">
                        <span class="jsItemName"></span>
                        <div class="jsItemVal">
                            <label>
                                <span class="checkbox itm <?php echo in_array($v['id'], $result['promission']) ? 'active' : '' ?>" data-val="1"><?php echo $v['title'] ?></span>
                                <input type="checkbox" class="None" name="auth[]" <?php echo in_array($v['id'], $result['promission']) ? 'checked=checked' : '' ?> value="<?php echo $v['id'] ?>" data-type="type" >
                            </label>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="jsItem">
                        <span class="jsItemName">
                            <label>
                                <span class="checkbox Line <?php echo in_array($v['id'], $result['promission']) ? 'active' : '' ?>" data-val="1"><?php echo $v['title'] ?>：</span>
                                <input type="checkbox" class="None" name="auth[]" <?php echo in_array($v['id'], $result['promission']) ? 'checked=checked' : '' ?> value="<?php echo $v['id'] ?>" data-type="type" >
                            </label>
                        </span>
                        <div class="jsItemVal">
                            <?php foreach ($v['children'] as $k1 => $v1) { ?>
                                <label>
                                    <span class="checkbox itm <?php echo in_array($v1['id'], $result['promission']) ? 'active' : '' ?>" data-val="1"><?php echo $v1['title'] ?></span>
                                    <input type="checkbox" class="None" name="auth[]" <?php echo in_array($v1['id'], $result['promission']) ? 'checked=checked' : '' ?> value="<?php echo $v1['id'] ?>" data-type="type" >
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="top20 textCenter">
                <span class="btn btn-success pdX30 mg-r-30" onclick="do_submit()">保 存</span>
                <span class="btn btn-info pdX30" onclick="parent.window.closHtml()">取 消</span>
            </div>
        </form>
    </div>
</body>
</html>

<script>
    function do_submit() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveRole"); ?>",
            data: $('#submit_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert("数据提交失败！");
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg,function(){
                        Refresh();
                    });
                }else{
                    Alert(data.msg);
                }
            }
        });
    }
    ;
</script>
