<?php require_once TPL_DIR . '/layout/header.php'; ?>
<section id="content">
    ﻿<?php require_once TPL_DIR . '/layout/left.php'; ?>
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3>修改密码</h3>
            <div class="tool">
                <a class="btn btn-primary" onclick="window.history.go(-1);"> 返 回 </a>
            </div>
        </div>
        <!-- DATA TABLES -->
        <div class="row">
            <div class="col-md-9">
                <div class="box border primary">
                    <div class="box-title">
                        <h4><i class="fa fa-pencil"></i>修改密码</h4>
                    </div>
                    <div class="box-body big">
                        <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">原密码</label>
                                <div class="col-sm-3">
                                    <input name="password" type="password" class="form-control" placeholder="原密码" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">新密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" placeholder="新密码" name="new_password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">确认新密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" placeholder="确认新密码" name="confirm_password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="btn-toolbar center col-sm-6"><button class="btn btn-info" onclick="do_submit()">确定修改</button></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
            url: "<?php echo spUrl($c, $a); ?>",
            data: $('#submit_form').serialize(),
            dataType: "json",
            async: false,
            error: function (request) {
                alert("数据提交失败！");
            },
            success: function (data) {
                alert(data.msg);
                if (data.err == 1) {
                    window.location.href = '/admin.php';
                }
            }
        });
    }
</script>