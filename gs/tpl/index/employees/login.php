<?php require_once TPL_DIR.'/employees/emp_top.php';?>
         
<div class="wrap-bg">
    <div class="reg-wrap">
        
        <div class="reg-con">
            <form method="post" action="" onsubmit="return false;" id="submit_form" autocomplete="off">
                <table class="reg-table">
                     <tr>
                        <td class="td-1">用户名</td>
                        <td class="td-2">
                            <div class="inp-w">
                                姓名/人员ID/手机号码
                                <input type="text" name="name" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">密码</td>
                        <td class="td-2">
                            <div class="inp-w">
                                请输入您的登录密码
                                <input type="password" name="password" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">&nbsp;</td>
                        <td class="td-2">
                            <a href="javascript:void(0);" id="submit_btn" class="btn-m btn-m-orange br3" switch="1" onclick="do_submit();">登 录</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

    <script>
        $(function(){
            $(".inp-w input").focus(function(){
                $(this).addClass("bg-f");
            }).blur(function(){
                ($(this).val()=="")&&$(this).removeClass("bg-f");
            });
        });
      
        
        //提交注册
        function do_submit(){
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl("employees","do_login"); ?>", //把表单数据发送到ajax.jsp
                data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
                dataType: "json",
                async: false,
                error: function(request) {
                    $.tip("数据请求失败！", 5);
                },
                success: function(data) {   
                    if(data.status==0){
                        $.tip(data.msg, 3);
                    }
                    if(data.status==1){
                        $.tip(data.msg, 1);
                        setTimeout("window.location.href='<?php echo spUrl("employees", "index"); ?>';", 1000);
                    }
                    
                }
            });
            return false;
        }
 
        
     
    </script>
    
    
    <p style="margin-top:10px; text-align:center; font-size:12px; font-family:宋体; color:#666;">Copyright (c) 2015 JOKU.COM All rights reserved 蜀ICP备15010236号</p>
        
    </body>
</html>