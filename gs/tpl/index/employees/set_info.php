<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">基本资料-基本信息 <span style="float:right;color:#999;font-size:13px;font-weight:normal;">最后登录时间：<?php echo date('Y-m-d G:i:s',$results['last_log_time']);?>；<span style="margin-left:20px;">最后登录IP：</span><?php echo $results['last_log_ip'];?></span></h2>
            <div style="font-size:13px;" class="tip-div">
                <b>用户名：</b><?php echo $results['username'];?>; <b style="margin-left:20px;">会员ID：</b><?php echo $results['usercode'];?>;<b style="margin-left:20px;">注册手机号：</b><?php echo $results['phone'];?>
            </div>
            <div class="clear">&nbsp;</div>
                  <div class="tis-xs">
                      <p><span><b>*</b>温馨提示：</span>完成企业营业执照上传验证，您的店铺将有机会再首页展示商品，同时在店铺主页增加显示机会哦。</p>
                  </div>
            <div class="add-left">
                <p style="text-align:center; line-height:30px; color:#333; font-size:14px;">商家LOGO</p>
                <div class="upload-img-box">
                    <input id="fileToUpload" type="file" name="fileToUpload"  class="file-btn" onchange='return ajaxFileUpload();' />
                    <a id="up-a" class="up-a" <?php echo $results["shop"]["logo"]?'style="display:none;"':''; ?>  href="javascript:void(0);" onclick="$('#fileToUpload').click();"><!--上传按钮--></a>
                    <div id="uploading-div" class="uploading-div"><div style="width:100%; height:180px; line-height:240px; text-align:center;">上传中...</div></div>
                    <div id="uploaded-div" <?php echo $results["shop"]["logo"]?'style="display:block;"':''; ?> class="uploaded-div"><img id="uploaded-img" width="200" height="200" src="<?php echo $results["shop"]["logo"]?$results["shop"]["logo"]:''; ?>" /></div>
                    <a href="javascript:void(0);" id="re-up-a" class="re-up-a" onclick="$('#fileToUpload').click();"><!--重新上传--></a>
                    <input type="hidden" id="uploaded-image" name="image" value="<?php echo $results["shop"]["logo"]?$results["shop"]["logo"]:''; ?>" />
                </div>
                <p style="text-align:center; line-height:30px; color:#999;">点击上传（大小建议不超过1M）</p>

                <p style="text-align:center;margin-top:20px; line-height:30px; color:#333; font-size:14px;">企业营业执照</p>
                <div class="upload-img-box1">
                    <input id="fileToUpload1" type="file" name="fileToUpload1"  class="file-btn" onchange='return ajaxFileUpload1();' />
                    <a id="up-a1" class="up-a" <?php echo $results["shop"]["license"]?'style="display:none;"':''; ?>  href="javascript:void(0);" onclick="$('#fileToUpload1').click();"><!--上传按钮--></a>
                    <div id="uploading-div1" class="uploading-div"><div style="width:100%; height:180px; line-height:240px; text-align:center;">上传中...</div></div>
                    <div id="uploaded-div1" <?php echo $results["shop"]["license"]?'style="display:block;"':''; ?> class="uploaded-div"><img id="uploaded-img1" width="200" height="200" src="<?php echo $results["shop"]["license"]?$results["shop"]["license"]:''; ?>" /></div>
                    <a href="javascript:void(0);" id="re-up-a1" class="re-up-a" onclick="$('#fileToUpload1').click();"><!--重新上传--></a>
                    <input type="hidden" id="uploaded-image1" name="image" value="<?php echo $results["shop"]["license"]?$results["shop"]["license"]:''; ?>" />
                </div>
                <p style="text-align:center; line-height:30px; color:#999;">点击上传（大小建议不超过1M）</p>
            </div>
            <div class="add-right" style="padding-top:30px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
                <table class="reg-table" style="width:500px; float:left;" cellpadding="0" cellspacing="0">
                
                    <tr>
                        <td class="td-1">商家名称</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="shop_name" value="<?php echo $results["shop"]["shop_name"]?$results["shop"]["shop_name"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">企业名称</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="company_name" value="<?php echo $results["shop"]["company_name"]?$results["shop"]["company_name"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">移动电话</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="phone" value="<?php echo $results["shop"]["phone"]?$results["shop"]["phone"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">座机号码</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="tel" value="<?php echo $results["shop"]["tel"]?$results["shop"]["tel"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr><?php ?>
                    <tr>
                        <td class="td-1">经营地址</td>
                         <td class="td-2">
                            <div class="w120 fl">
                                <select class="w110 sel select-p" name="province">
                                    <option value="">请选择...</option>
                                    <?php  foreach ($province as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results["shop"]['province']) && $v['aid'] == $results['shop']['province'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="w120 fl">
                                <select class="w110 sel select-c" name="city">
                                    <option value="">请选择...</option>
                                    <?php foreach ($city as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results["shop"]['city']) && $v['aid'] == $results['shop']['city'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="w120 fl">
                                <select class="w120 sel select-a" name="area">
                                    <option value="">请选择...</option>
                                    <?php foreach ($area as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results["shop"]['area']) && $v['aid'] == $results['shop']['area'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">详细地址</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="address" value="<?php echo $results["shop"]["address"]?$results["shop"]["address"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1" style="vertical-align:top;"><p style="padding-top:5px; font-size:14px;">商家简介</p></td>
                        <td class="td-2">
                            <textarea name="description" style="width:352px; height:80px; border:1px solid #ccc; padding:3px;"><?php echo $results["shop"]["description"]?$results["shop"]["description"]:''; ?></textarea>   
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
                </div>
                  <div class="clear">&nbsp;</div>


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
        
        $(".upload-img-box").hover(function(){
            if($(this).find("#uploaded-image").val()!=""){
                $(this).find("#re-up-a").show();
            }
        }, function(){
            $(this).find("#re-up-a").hide();
        });

        $(".upload-img-box1").hover(function(){
            if($(this).find("#uploaded-image1").val()!=""){
                $(this).find("#re-up-a1").show();
            }
        }, function(){
            $(this).find("#re-up-a1").hide();
        });

     
    });
    

        //上传图片
    function ajaxFileUpload1(){
        $("#up-a1,#re-up-a1,#uploaded-div1").hide();
        $("#uploading-div1").show();
        $.ajaxFileUpload({
            url:'<?php echo spUrl("uplaodimage","upload_shop_license"); ?>',
            secureuri:false,
            fileElementId:'fileToUpload1',
            dataType: 'json',
            data:{name:'logan', id:'id',w:200,h:200},
            success: function(data, status){
                 $("#uploading-div1").hide();
                if(data.status==1){
                    $("#uploaded-img1").attr("src", data.src);
                    $("#uploaded-image1").val(data.src);
                    $("#uploaded-div1").show();
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

    //上传图片
    function ajaxFileUpload(){
        $("#up-a,#re-up-a,#uploaded-div").hide();
        $("#uploading-div").show();
        $.ajaxFileUpload({
            url:'<?php echo spUrl("uplaodimage","upload_shop_logo"); ?>',
            secureuri:false,
            fileElementId:'fileToUpload',
            dataType: 'json',
            data:{name:'logan', id:'id',w:200,h:200},
            success: function(data, status){
                 $("#uploading-div").hide();
                if(data.status==1){
                    $("#uploaded-img").attr("src", data.src);
                    $("#uploaded-image").val(data.src);
                    $("#uploaded-div").show();
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
                url: "<?php echo spUrl("myshop","save_set"); ?>", //把表单数据发送到ajax.jsp
                data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
                dataType: "json",
                async: false,
                error: function(request) {
                    $.tip("数据请求失败！", 5);
                },
                success: function(data) {  
                    $.tip(data.msg, 2);
                }
            });
            return false;
        }

$(function(){
    		var p = '<?php echo isset($results["shop"]['province']) && !empty($results["shop"]['province'])?$results["shop"]['province']:0;?>';
    		var c = '<?php echo isset($results["shop"]['city']) && !empty($results["shop"]['city'])?$results["shop"]['city']:0;?>';
    		var a = '<?php echo isset($results["shop"]['area']) && !empty($results["shop"]['area'])?$results["shop"]['area']:0;?>';
    		//获取城市
            $('.select-p').change(function(){
                var pid = $(this).val();
                var that = $(this);
                $.post('<?php echo spUrl('main', 'get_address'); ?>',{pid:pid},function(data){
                    if(data.status == 1){
                        var city = new Array();
                        city.push('<option value="">请选择...</option>');
                        $.each(data.data,function(i,v){
                        	if(v.aid == c){
                            	city.push('<option value="'+v.aid+'" selected>'+v.name+'</option>');
                        	}else{
                           	    city.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        	}
                        });
                        $(".select-c").html(city.join(''));
                    }
                },'json');
            });
            //获取区域
            $('.select-c').change(function(){
                var pid = $(this).val();
                $.post('<?php echo spUrl('main', 'get_address'); ?>',{pid:pid},function(data){
                    if(data.status == 1){
                        var city = new Array();
                        city.push('<option value="">请选择...</option>');
                        $.each(data.data,function(i,v){
                        	if(v.aid == a){
                            	city.push('<option value="'+v.aid+'" selected>'+v.name+'</option>');
                        	}else{
                           	 	city.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        	}
                        });
                        $(".select-a").html(city.join(''));
                    }
                },'json');
            });
          
    });
</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>