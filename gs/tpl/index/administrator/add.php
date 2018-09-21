<?php require_once TPL_DIR . '/layout/header.php'; ?>
<section id="content">
    ﻿<?php require_once TPL_DIR . '/layout/left.php'; ?>
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3><?php echo isset($id) ? '编辑' : '添加'; ?>管理员</h3>
            <div class="tool">
                <a class="btn btn-primary" href="<?php echo spUrl($c, 'index') ?>"> 返 回 </a>
            </div>
        </div>
        <!-- DATA TABLES -->
        <div class="row">
                        <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
                            <div class="form-group">
                                <label class="col-label">用户名</label>
                                <div class="col-div">
                                    <input name="username" type="text" class="form-control" placeholder="用户名" value="<?php echo isset($results["username"]) ? $results["username"] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-label">登录密码</label>
                                <div class="col-div">
                                    <input type="password" class="form-control" placeholder="<?php echo isset($results['password']) ? '不填则不修改' : '登录密码' ?>" name="password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-label">确认密码</label>
                                <div class="col-div">
                                    <input type="password" class="form-control" placeholder="<?php echo isset($results['password']) ? '不填则不修改' : '确认密码' ?>" name="confirm_password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-label">拥有权限</label>
                                <div class="col-div">
                                    <?php foreach ($result as $k => $v) { ?>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="auth[]" value="<?php echo $v['id'] ?>" <?php echo in_array($v['id'], $results['role']) ? 'checked=""' : '' ?>> <?php echo $v['name'] ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="btn-toolbar center"><button class="btn btn-red" onclick="do_submit()">保 存</button></p>
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
            url: "<?php echo spUrl($c, "save_auth"); ?>",
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
</script>

