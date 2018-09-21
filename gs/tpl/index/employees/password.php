<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">密码设置</h2>
            <form method="post" action="" onsubmit="return false;" id="submit_form">
                <table class="reg-table" style="width:500px; float:left;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="td-1">原密码</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="password" name="password" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">新密码</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="password" name="newpassword" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">确认密码</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="password" name="repassword" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">&nbsp;</td>
                        <td class="td-2">
                            <a href="javascript:void(0);" id="submit_btn" class="btn-m btn-blue br3" switch="1" onclick="do_submit();">保 存</a>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
       
    });

    //提交
        function do_submit(){
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl("employees","edit_password"); ?>", //把表单数据发送到ajax.jsp
                data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
                dataType: "json",
                async: false,
                error: function(request) {
                    $.tip("数据请求失败！", 1);
                },
                success: function(data) {  
                    if(data.status==0){
                        $.tip(data.msg, 1);
                    }
                    if(data.status==1){
                        $.tip(data.msg, 1);
                        setTimeout("window.location.reload();", 2000);
                    }
                }
            });
            return false;
        }


</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>