<?php require_once TPL_DIR . '/layout/header.php'; ?>

<section id="content">
    ﻿<?php require_once TPL_DIR . '/layout/left.php'; ?>
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3><?php echo isset($id) ? '编辑' : '添加'; ?>职务</h3>
            <div class="tool">
                <a class="btn btn-primary" href="<?php echo spUrl($c, 'role') ?>"> 返 回 </a>
            </div>
        </div>
        <!-- DATA TABLES -->
        <div class="row">
            <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
                <div class="form-group">
                    <label class="col-label">职务名称：</label>
                    <div class="col-div">
                        <input type="text" name="name" class="form-control" placeholder="职务名称" value="<?php echo isset($results["name"]) ? $results["name"] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-label"></label>
                    <div class="col-div">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="allcheck" value=""> 全选
                        </label>
                    </div>
                </div>
                <?php foreach ($results as $k => $v) { ?>
                    <div class="form-group">
                        <label title="全选" class="col-label"><input type="checkbox" class="allcheck check hidden" name="auth[]" value="<?php echo $v['id'] ?>" <?php echo in_array($v['id'], $result['promission']) ? 'checked=""' : '' ?>><?php echo $v['title'] ?></label>
                        <div class="col-div">
                            <?php foreach ($v['children'] as $k1 => $v1) { ?>
                                <label class="checkbox-inline">
                                    <input class="<?php echo count($v1['children'])>0?'allcheck1':''?> check check<?php echo $v['id'] ?>" type="checkbox" name="auth[]" value="<?php echo $v1['id'] ?>" <?php echo in_array($v1['id'], $result['promission']) ? 'checked=""' : '' ?>> <?php echo $v1['title'] ?>
                                </label>
                            <?php foreach ($v1['children'] as $k2 => $v2) { ?>
                                <label class="checkbox-inline">
                                    <input class="check check<?php echo $v['id'] ?> check<?php echo $v1['id'] ?>" type="checkbox" name="auth[]" value="<?php echo $v2['id'] ?>" <?php echo in_array($v2['id'], $result['promission']) ? 'checked=""' : '' ?>> <?php echo $v2['title'] ?>
                                </label>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <p class="btn-toolbar center">
                        <button class="btn btn-red" onclick="do_submit()">保 存</button>
                        <button class="btn btn-info">取 消</button>
                    </p>
                </div>
            </form>
        </div>
        <!-- /DATA TABLES -->
    </div>
</section>
<!--/PAGE -->

<!-- /JAVASCRIPTS -->
</body>
</html>

<script>
    function do_submit() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "save"); ?>",
            data: $('#submit_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                alert("数据提交失败！");
            },
            success: function(data) {
                alert(data.msg);
                if (data.err == 1) {
                    history.go(-1);
                }
            }
        });
    }
    ;

    $('#allcheck').click(function() {
        if (this.checked) {
            $(".check").each(function() {
                this.checked = true;
            });
        } else {
            $(".check").each(function() {
                this.checked = false;
            });
        }
    });

    $('.allcheck').click(function() {
        var id = $(this).val();
        if (this.checked) {
            $(".check" + id).each(function() {
                this.checked = true;
            });
        } else {
            $(".check" + id).each(function() {
                this.checked = false;
            });
        }
    });

    $('.allcheck1').click(function() {
        var id = $(this).val();
        if (this.checked) {
            $(".check" + id).each(function() {
                this.checked = true;
            });
        } else {
            $(".check" + id).each(function() {
                this.checked = false;
            });
        }
    });
    
    $('.check').click(function(){
        var allcheck = document.getElementsByClassName('allcheck');
        var allcheck1 = document.getElementsByClassName('allcheck1');
        for(var i = 0;i<allcheck1.length;i++){
            var id = $('.allcheck1').eq(i).val();
            if($(".check" + id+':checked').length>0){
                allcheck1[i].checked = true;
            }else{
                allcheck1[i].checked = false;
            };
        }
        for(var i = 0;i<allcheck.length;i++){
            var id = $('.allcheck').eq(i).val();
            if($(".check" + id+':checked').length>0){
                allcheck[i].checked = true;
            }else{
                allcheck[i].checked = false;
            };
        }
    });

</script>
