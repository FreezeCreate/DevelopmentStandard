<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/jquery.datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/main-min.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo SOURCE_PATH; ?>/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="<?php echo SOURCE_PATH; ?>/kindeditor/plugins/code/prettify.css" />
<script type="text/javascript" charset="utf-8" src="<?php echo SOURCE_PATH; ?>/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SOURCE_PATH; ?>/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?php echo SOURCE_PATH; ?>/kindeditor/plugins/code/prettify.js"></script>
<script>
    KindEditor.ready(function(K) {
        var editor1=K.create('textarea[name="content"]',{//name=form中textarea的name属性
            cssPath : '<?php echo SOURCE_PATH; ?>/kindeditor/plugins/code/prettify.css',
            uploadJson : '<?php echo SOURCE_PATH; ?>/kindeditor/php/upload_json.php',
            fileManagerJson : '<?php echo SOURCE_PATH; ?>/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
            afterCreate : function() {
            },
            afterBlur: function(){this.sync()},
        });
        prettyPrint();
    });
</script>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit"><?php echo ($result['id'])?'修改':'发布'; ?>信息</h2>
            <div class="clear">&nbsp;</div>
            
            <div class="add-right" style="padding-top:10px; width:980px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
	<input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
    <input type="hidden" name="market_id" value="<?php echo isset($market_id) ? $market_id: 0; ?>">
                <table class="reg-table" style="width:900px; float:left;" cellpadding="0" cellspacing="0">
                	 <tr>
                        <td class="td-1"><b>*</b>活动时间：</td>
                        <td  class="td-2">
                            <input type="text" id="datetimepicker1" name="starttime" value="<?php echo isset($result["starttime"])?date('Y-m-d H:i:s',$result["starttime"]):''; ?>" class="txt" style="margin:0px 5px 0px 0px;width:150px; float: none;" />开始<input type="text" id="datetimepicker2" name="endtime" value="<?php echo isset($result["endtime"])?date('Y-m-d H:i:s',$result["endtime"]):''; ?>" class="txt" style="margin:0px 5px 0px 20px;width:150px;float:none"/>结束
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1"><b>*</b>消息标题：</td>
                        <td class="td-2" style="width:500px;">
                                <div class="inp-w" style="height:36px;width:100%;">
                                    <input type="text" style="width:391px;" placeholder="最多50个字" name="title" value="<?php echo isset($result["title"])?$result["title"]:''; ?>" class="txt" maxlength="50" />
                                </div>
                                 <p style="color:#999;line-height:20px;padding-top:5px;float:left;">该标题为市场，商超，超市的主标题！</p>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                    <td class="td-1"><b>*</b>主描述：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:100px;width:100%; padding:0px">
                            	<textarea name="description" style="min-height:90px; min-width:395px"><?php echo isset($result["description"])?$result["description"]:''; ?></textarea>
                            </div>
                            <p style="color:#999;line-height:20px;padding-top:5px;float:left;">该描述主要用于对该次活动整体信息的简单描述,最多200个字</p>
                       
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">活动消息1：</td>
                        <td class="td-2">
                            <div style="margin-bottom:5px;" >标题：<input class="txt" name="title1" style="float: none;" value="<?php echo isset($result['title1']) ? $result['title1'] : ''; ?>" type="text" maxlength="30"/></div>
                            <div class="inp-w" style="height:100px;width:100%; padding:0px">
                            	内容：<textarea  name="content1" style="min-height:90px; min-width:395px"><?php echo isset($result["content1"])?$result["content1"]:''; ?></textarea>
                            </div>
                         </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">活动消息2：</td>
                        <td class="td-2" >
                            <div style="margin-bottom:5px;" >标题：<input class="txt" name="title2" style="float: none;" value="<?php echo isset($result['title2']) ? $result['title2'] : ''; ?>" type="text" maxlength="30"/></div>
                           <div class="inp-w" style="height:100px;width:100%; padding:0px">
                            	内容：<textarea  name="content2" style="min-height:90px; min-width:395px"><?php echo isset($result["content2"])?$result["content2"]:''; ?></textarea>
                            </div> </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">活动消息3：</td>
                        <td class="td-2">
                            <div style="margin-bottom:5px;" >标题：<input class="txt" name="title3" style="float: none;" value="<?php echo isset($result['title3']) ? $result['title3'] : ''; ?>" type="text" maxlength="30"/></div>
                          <div class="inp-w" style="height:100px;width:100%; padding:0px">
                            	内容：<textarea  name="content3" style="min-height:90px; min-width:395px"><?php echo isset($result["content3"])?$result["content3"]:''; ?></textarea>
                            </div></td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                   <tr>
                        <td class="td-1">查询市场/商超</td>
                        <td class="td-2">
                           <input type="text" name="market_name" value="<?php echo isset($market["name"])?$market["name"]:''; ?>" class="txt" id="market_name" />
                           <input type="hidden" name="market" id="market" value="<?php echo isset($result["market"])?$result["market"]:''; ?>"  />
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
									  inp = '<p><input type="hidden" value="'+id+'" name="r_markets[]"/><span>'+name+'</span><a onclick="$(this).parent().remove();">x</a></p>';
									 $("#r_market").append(inp); 
									}   
									
									
								}
								
								
                            </script>
                    
                    <tr>
                    	<td class="td-1">关联商超:</td>
                        <td class="td-2" id='r_market'>
                        	<input type="hidden" value="<?php echo $result['market_id']?>" name="r_markets[]"/>
                        	<?php foreach($r_markets as $k => $v){?>
                            	<p><input type="hidden" value="<?php echo $v['id'];?>" name="r_markets[]"/><span><?php echo $v['name'];?></span><a onclick="$(this).parent().remove();">x</a></p>
                            <?php } ?>
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <style>
                    #r_market p{float:left;padding-right:25px;margin-bottom:10px;position:relative;background:#f3f3f3;color:#333;margin-right:10px;padding-left:15px;line-height:25px;}
            		#r_market p a{position:absolute;display:block;right:0px;top:0px;text-align:center;width:20px;height:20px;color:#666;line-height:20px;}
            		#r_market p a:hover{color:red;}
                    </style>
                     <tr>
                        <td class="td-1"><b>*</b>上传消息图片:</td>
                        <td class="td-2">
                                <div style="float:left;">
                                    <input id="fileToUpload_news" type="file" name="fileToUpload" style="position:absolute; left:-9999px; top:-9999px;"  onchange='return ajaxFileUpload_news();' />
                                    <a id="up-a" class="btn-m btn-m-orange" href="javascript:void(0);" onclick="$('#fileToUpload_news').click();"><?php echo isset($results["image"])&&!empty($results["image"])?'重新上传':'上传图片'; ?></a>
                                    <span id="uploading" style="display:none;">（上传中...）</span>
                                </div>
                                
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <tr>
                        <td class="td-1">&nbsp;</td>
                        <td class="td-2" style="width:500px;">
                            <div style="width:100%;float:left;">
                            <div style="float:left;" id="tr-img1" <?php echo isset($result["image"])&&!empty($result["image"])?'':'style="display:none;"'; ?>>
                            <img id="img" src="<?php echo ($result["image"])?$result["image"]:''; ?>" width="200" height="200" />
                            <input type="hidden" id="uploaded-image" name="image" value="<?php echo isset($result["image"])?$result["image"]:''; ?>" />
                            </div>
                            </div>
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <tr>
                    	 <td class="td-1">活动海报：</td>
                         <td colspan="2">  <textarea name="content" style="width:700px;height:200px;" id="content"><?php echo $result['content'];?></textarea></td>
                    </tr>
                    <?php if($_SESSION['emp']['effective'] == 1){?>
                    <tr>
                    	<td class="td-1">是否通过审核：</td>
                        <td class="td-2">
                            <input type="radio" name="status" value="0" <?php if($result['status'] == 0){?> checked="checked"<?php } ?>/>未审核
                            <input type="radio" name="status" value="1"  <?php if($result['status'] == 1){?> checked="checked"<?php } ?>/>通过
                            <input type="radio" name="status" value="-1" <?php if($result['status'] == -1){?> checked="checked"<?php } ?> />未通过
                        </td>
                    </tr>
                    <?php } ?>
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
    //上传图片
   function ajaxFileUpload_news(){
        $("#uploading").show();
        $("#tr-img2").hide();
        $.ajaxFileUpload({
            url:'<?php echo spUrl("uplaodimage","uploadimg"); ?>',
            secureuri:false,
            fileElementId:'fileToUpload_news',
            dataType: 'json',
            data:{name:'logan', id:'id'},
            success: function(data, status){
                $("#uploading").hide();
                if(data.status==1){
                    $("#up-a").text("重新上传");
                    $("#img").attr("src", "/tmp/"+data.src);
                    $("#uploaded-image").val("/tmp/"+data.src);
                    $("#tr-imgl").show();
                     $.tip('上传成功',3);
                }else{
                    $.tip(data.msg,3);
                }
            },
            error: function (data, status, e){
                $.tip(e,3);
            }
        });
        return false;
    }
    
    
    
  
    
    //提交注册
    function do_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_market_news"); ?>", //把表单数据发送到ajax.jsp
            data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
            	$.tip(data.msg, 2);
                
            	if(data.status==0){
	                 history.go(-1);
           		}
            }
        });
        return false;
    }

</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>