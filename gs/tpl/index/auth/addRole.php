<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
    .jsItem{overflow: hidden;margin-bottom: 10px;}
    .jsItemName{float: left;text-align: right;width: 130px;min-height: 14px;line-height: 24px;}
    .jsItemVal{float: left;line-height: 24px;}
</style>
<body style="min-width: 930px;">
        <div class="TableHead TableHdBg">
            <?php echo isset($id) ? '编辑' : '添加'; ?>角色
        </div>
    <div class="ContentBox">
        <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
        <div class="jsItem">
            <span class="jsItemName">角色名称：</span>
            <div class="jsItemVal">
                <input type="text" class="FrameGroupInput radius" name="name" id="" placeholder="角色名称" value="<?php echo isset($result["name"]) ? $result["name"] : ''; ?>" />
            <a class="Btn Btn-blue" href="<?php echo spUrl($c, 'role') ?>" >返回</a>
            </div>
        </div>
        <div class="jsItem">
            <span class="jsItemName"></span>
            <div class="jsItemVal">
                <label for="q">
                    <span class="checkbox all" data-val="1">全选</span>
                    <input type="checkbox" class="None" name="" id="q" value="1" data-type="type">
                </label>
            </div>
        </div>
        <?php foreach ($results as $k => $v) { ?>
        <div class="jsItem">
            <span class="jsItemName">
                <label for="q<?php echo $v['id']?>">
                    <span class="checkbox itm Line <?php echo in_array($v['id'], $result['promission']) ? 'active' : '' ?>" data-val="<?php echo $v['id']?>"><?php echo $v['title'] ?>：</span>
                    <input type="checkbox" class="None" name="auth[]" value="<?php echo $v['id'] ?>" <?php echo in_array($v['id'], $result['promission']) ? 'checked=""' : '' ?> id="q<?php echo $v['id']?>" data-type="type">
                </label>
            </span>
            <div class="jsItemVal">
                <?php foreach ($v['children'] as $k1 => $v1) { ?>
                <label for="q<?php echo $v1['id']?>">
                    <span class="checkbox itm <?php echo in_array($v1['id'], $result['promission']) ? 'active' : '' ?>" data-val="<?php echo $v1['id']?>"><?php echo $v1['title']?></span>
                    <input type="checkbox" class="None" name="auth[]" id="q<?php echo $v1['id']?>" value="<?php echo $v1['id']?>" <?php echo in_array($v1['id'], $result['promission']) ? 'checked=""' : '' ?> data-type="type">
                </label>
                <?php }?>
            </div>
        </div>
        <?php }?>
        <div class="textCenter"><span class="Btn Big Btn-green"  onclick="do_submit()">保存</span><a class="Btn Big Btn-blue" style="margin-left: 20px;"  href="<?php echo spUrl($c, 'role') ?>" >返回</a></div>
        </form>
    </div>
</body>
<script type="text/javascript">
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
                        history.go(-1);
                    });
                }else{
                    Alert(data.msg);
                }
            }
        });
    }
    ;
    $(function() {
        $('.jsItemVal').width($(window).width() - 170)
        $('.checkbox.all').click(function() {
            var that = this;

            if ($(that).hasClass('active')) {
                $('.checkbox').each(function(k, v) {
                    if ($(v)[0] == that) {
                    } else {
                        $(v).removeClass('active')
                    }
                })
                $('input').each(function(k, v) {
                    if ($(v)[0] == $(that).next()[0]) {
                    } else {
                        $(v)[0].checked = false
                    }
                })
            } else {
                $('.checkbox').each(function(k, v) {
                    if ($(v)[0] == that) {
                    } else {
                        $(v).addClass('active')
                    }
                })
                $('input').each(function(k, v) {
                    if ($(v)[0] == $(that).next()[0]) {
                    } else {
                        $(v)[0].checked = true
                    }
                })
            }
        })
        $('.checkbox.Line').click(function() {
            var that = this
            if ($(that).hasClass('active')) {
                $(that).parent().parent().next().children().each(function(k1, v1) {
                    $(v1).children('.checkbox').removeClass('active')
                    $(v1).children('input')[0].checked = false
                })
            } else {
                $(that).parent().parent().next().children().each(function(k1, v1) {
                    $(v1).children('.checkbox').addClass('active')
                    $(v1).children('input')[0].checked = true
                })
            }
        })

        $('.checkbox.itm').click(function() {
            $('.checkbox.all').removeClass('active')
            $('.checkbox.all').next()[0].checked = false
        })
    })
</script>
</html>

