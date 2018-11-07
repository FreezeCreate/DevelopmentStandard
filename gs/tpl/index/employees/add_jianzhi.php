<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/jquery.datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/main-min.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery.datetimepicker.js"></script>

<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit"><?php echo ($result['id'])?'修改':'添加'; ?>信息</h2>
            <div class="clear">&nbsp;</div>
            
            <div class="add-right" style="padding-top:10px; width:980px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
                <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
                <table class="reg-table" style="width:900px; float:left;" cellpadding="0" cellspacing="0">
                	<tr>
                    <td class="td-1"><b>*</b>姓名：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:36px;width:100%;">
                                <input type="text" name="name" value="<?php echo isset($result["name"])?$result["name"]:''; ?>" class="txt"  />
                            </div>
                            
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                    <td class="td-1"><b>*</b>手机号：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:36px;width:100%;">
                                <input type="text"name="phone" value="<?php echo isset($result["phone"])?$result["phone"]:''; ?>" class="txt"  />
                            </div>
                            <p style="color:#999;line-height:20px;padding-top:5px;float:left;">注：该手机号与兼职人员注册会员的手机号相同！</p>
                       
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">查询市场/商超</td>
                        <td class="td-2">
                           <input type="text" name="market_name" value="<?php echo isset($market["name"])?$market["name"]:''; ?>" class="txt" id="market_name" />
                            &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="market_sub1()">搜索</a>
                            <div id="markets1" class="bms" style="">
                            
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <script type="text/javascript">
                               $(function(){
                                   var  yuans1 = $("#market_name").val(); 
								  
                                   $("#market_name").keyup(function(){
                                      if($(this).val()!=yuans1)
                                      {
                                        market_sub();
                                        yuans1 = $(this).val();
                                      }
                                   });
                                  
                                    
                               });
							   
							   function market_sub(){
									var market = $('#market_name').val();
									$.ajax({
										cache: false,
										type: "POST",
										url: "<?php echo spUrl("employees","markets0"); ?>", //把表单数据发送到ajax.jsp
										data: {market:market}, //要发送的是ajaxFrm表单中的数据
										dataType: "json",
										async: false,
										error: function(request) {
											$.tip("数据请求失败！", 5);
										},
										success: function(data) {
											$('#markets1').html(data.msg);
											$('#markets1').css('display','block');
											
										}
									});
									return false;
								}
								
								function d_market1(name,id){
									var num = 0;
									$("#r_market span").each(function(){
										if($(this).html() == name)
										{   
											num = 1;
										}
									});
									if(num==1)
									{
										return false;alert("a");
									}
									else
									{
									  inp = '<p><input type="hidden" value="'+id+'" name="manage_markets[]"/><span>'+name+'</span><a onclick="$(this).parent().remove();">x</a></p>';
									 $("#r_market").append(inp); 
									}   
									
									
								}
								
								
                            </script>
                    
                    <tr>
                    	<td class="td-1">关联商超:</td>
                        <td class="td-2" id='r_market'>
                        	<input type="hidden" value="0" name="manage_markets[]"/>
                        	<?php foreach($manage_markets as $k => $v){?>
                            	<p><input type="hidden" value="<?php echo $v['id'];?>" name="manage_markets[]"/><span><?php echo $v['name'];?></span><a onclick="$(this).parent().remove();">x</a></p>
                            <?php } ?>
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <style>
                    #r_market p{float:left;padding-right:25px;position:relative;background:#f3f3f3;color:#333;margin-right:10px;padding-left:15px;}
            		#r_market p a{position:absolute;display:block;right:0px;top:0px;text-align:center;width:20px;height:20px;color:#666;line-height:20px;}
            		#r_market p a:hover{color:red;}
                    </style>
                    
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
</div>
<style>
.adds{position: fixed;width: 450px;background: #FFFFFF;top: 20%; border:1px solid; margin-left: 159px; display: none; }
.adds tr{ line-height: 28px;}
.adds tr td{ line-height: 28px; padding: 5px;}
.adds tr td input{vertical-align: middle; height: 28px; }
.w226{width: 226px;}
.bms p a{margin: 0px 10px;}
.model{display:none}
</style>

<script>
    
    //提交注册
    function do_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_jianzhi"); ?>", //把表单数据发送到ajax.jsp
            data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
            	$.tip(data.msg, 2);
                
            	if(data.status==1){
	                history.go(-1);
            	}
            }
        });
        return false;
    }

</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>