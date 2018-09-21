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
            <h2 class="tit"><?php echo ($result['id'])?'修改':'发布'; ?>信息</h2>
            <div class="clear">&nbsp;</div>
            
            <div class="add-right" style="padding-top:10px; width:980px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
                <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
                <table class="reg-table" style="width:900px; float:left;" cellpadding="0" cellspacing="0">
                	<tr>
                    <td class="td-1">联系方式：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:36px;width:100%;">
                                <input type="text" placeholder="" name="phone" value="<?php echo isset($result["phone"])?$result["phone"]:''; ?>" class="txt"  />
                            </div>
                            
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                    <td class="td-1"><b>*</b>标题：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:36px;width:100%;">
                                <input type="text" placeholder="4-10个字" name="shorttitile" value="<?php echo isset($result["shorttitile"])?$result["shorttitile"]:''; ?>" class="txt" maxlength="10" />
                            </div>
                            <p style="color:#999;line-height:20px;padding-top:5px;float:left;">例如：99元起，1折起，满300减100等这类标语</p>
                       
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                    <td class="td-1"><b>*</b>内容：</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="height:36px;width:100%;">
                                <input type="text" placeholder="最多50个字" name="title" value="<?php echo isset($result["title"])?$result["title"]:''; ?>" class="txt" maxlength="50" />
                            </div>
                            <p style="color:#999;line-height:20px;padding-top:5px;float:left;">标题应包含店铺名称、地理位置、活动时间、活动内容等。<br/>例如：金牛万达广场3楼阿玛拉店，情侣夏季新品5-7折特卖，活动时间7月21日到7月23日，全场满300减100。</p>
                       
                        </td>
                    <td class="td-3">&nbsp;</td>
                    </tr>
                    
                    <?php if($result['integral'] >0 && $result['integral'] !=null){?>
                    <tr>
                        <td class="td-1">获得积分:</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" style="width: 110px;" value="<?php echo isset($result["integral"])?$result["integral"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <?php } ?>
                    <?php if(!empty($result['reply'])){?>
                    <tr>
                        <td class="td-1">回复:</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w" style="color:red">
                                <textarea><?php echo $result['reply'] ?></textarea>
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <?php } ?>
                    <style>
                        #brands{width: 100%; max-height: 200px; border: 1px solid #ccc; margin: 5px 0px; display: none; overflow: hidden;}
                        #brands a{margin: 0 5px; line-height: 20px;}
                        #list{width: 100%; max-height: 200px; border: 1px solid #ccc; margin: 5px 0px; display: none; overflow: auto;}
                        #list a{margin: 0 5px; line-height: 20px;}
                    </style>
                    
                    <tr>
                        <td class="td-1"><b>*</b>所在市场/商超</td>
                        <td class="td-2">
                           <input type="text" name="market_name" value="<?php echo isset($market["name"])?$market["name"]:''; ?>" class="txt" id="market_name" />
                           <input type="hidden" name="market" id="market" value="<?php echo isset($result["market"])?$result["market"]:''; ?>"  />
                           
                            <div id="markets1" class="bms" style="">
                            
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <script type="text/javascript">
                               $(function(){
                                   var yuans1 = $("#market_name1").val(); 
                                   $("#market_name1").keyup(function(){
                                      if($(this).val()!=yuans1)
                                      {
                                        market_sub();
                                        yuans1 = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    
                    <tr>
                        <td class="td-1"><b>*</b>经营品牌：</td>
                        <td class="td-2">
                            <input type="text" placeholder="请输入品牌名" class="txt" value="<?php echo $result['brand_name'];?>" id="brand" name="brand_name" /> &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="brand_sub()" id="brandsdg">搜索</a>&nbsp;&nbsp;<a href="Javascript:void(0)" onclick="$('#add_brand').css('display','block');$('#brands').css('display','none')">添加品牌</a>
                            <input type="hidden" value="<?php echo $result['brand']; ?>" id="brand_id" name="brand"/>
                            <div id="brands" style=""></div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                        <script type="text/javascript">
                               $(function(){
                                   var yuan = $("#brand").val(); 
                                   $("#brand").keyup(function(){
                                      if($(this).val()!=yuan)
                                      {
                                        $("#brandsdg").click();
                                        yuan = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    </tr>
                   
            
                    <tr>
                        <td class="td-1"><b>*</b>消息分类:</td>
                        <td class="td-2">
                            <select class="sel" style="width:113px; float:left; margin-right:10px;" id="fcatid" name="category_id">
                                    <option value="" selected="selected">请选择...</option>
                                    <?php foreach ($cat as $key => $value) { ?>
                                    <option value="<?php echo $value["id"]; ?>"  <?php echo ($result["category_id"]&& ($value["id"] == $result["category_id"]))?'selected="selected"':''; ?> ><?php echo $value["name"]; ?></option>
                                    <?php } ?>
                                </select>
                            <?php if(1 ==2 ){?>          <select class="sel" style="width:113px; float:left;margin-right:10px;" id="scatid" name="scatid">
                                    <option value="" selected="selected">请选择...</option>
                                    <?php foreach ($scate as $key => $value) { ?>
                                    <option value="<?php echo $value["id"]; ?>"  <?php echo ($results["category_id"]&&in_array($value["id"], $results["category_id"]))?'selected="selected"':''; ?> ><?php echo $value["name"]; ?></option>
                                    <?php } ?>
                                </select> <?php } ?>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
<!--                     <tr  id="model2" >
                        <td class="td-1"><b>*</b>消息模式:</td>
                        <td class="td-2">
                            <input type="radio" name="model" <?php if($result["model"] == 1 || empty($result['model'])){ ?> checked <?php } ?> value="<?php echo 1; ?>" />新品消息&nbsp;&nbsp;
                            <input type="radio" name="model" <?php if($result["model"] == 2){ ?> checked <?php } ?> value="<?php echo 2; ?>" />特卖消息&nbsp;&nbsp;
                            </td>
                        <td class="td-3">&nbsp;</td>
                    </tr> -->
                <?php if(1 ==2 ){?>   
                    <tr  id="model2">
                        <td class="td-1"><b>*</b>消息模式:</td>
                        <td class="td-2">
                            <input type="radio" name="model2" <?php if($result["model2"] == 10 ){ ?> checked <?php } ?> value="<?php echo 1; ?>" />新&nbsp;&nbsp;
                            <input type="radio" name="model2" <?php if($result["model2"] == 1 ){ ?> checked <?php } ?> value="<?php echo 1; ?>" />折&nbsp;&nbsp;
                            <input type="radio" name="model2" <?php if($result["model2"] == 2 ){ ?> checked <?php } ?> value="<?php echo 2; ?>" />减&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 3 ){ ?> checked <?php } ?> value="<?php echo 3; ?>" />奖&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 4 ){ ?> checked <?php } ?> value="<?php echo 4; ?>" />返&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 5 ){ ?> checked <?php } ?> value="<?php echo 5; ?>" />赠&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 6 ){ ?> checked <?php } ?> value="<?php echo 6; ?>" />抢&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 7 ){ ?> checked <?php } ?> value="<?php echo 7; ?>" />少&nbsp;&nbsp;  
                            <input type="radio" name="model2" <?php if($result["model2"] == 8 ){ ?> checked <?php } ?> value="<?php echo 8; ?>" />换&nbsp;&nbsp; 
                            <input type="radio" name="model2" <?php if($result["model2"] == 9 ){ ?> checked <?php } ?> value="<?php echo 9; ?>" />省&nbsp;&nbsp; 
                          </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
               <?php } ?>  
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
                        <td class="td-1">&nbsp;</td>
                        <td class="td-2">
                            <a href="javascript:void(0);" id="submit_btn" class="btn-m btn-blue br3" switch="1" onclick="do_submit();">保 存</a>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                   
                </table>
            </form>
            <div id="add_brand" class="adds">
            <table>
            <form id="brand_submit" method="post">
                        <tr>
                            <td  class="td-1" style="width: 50px;">
                                <label for="password">品牌名字</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="b_name" name="name" class="w226"/> 
                            </td>
                        </tr> 
                        <tr>
                            <td  class="td-1">
                                <label for="password">品牌级别</label>
                            </td>
                            <td class="td-2">
                                  <input type="radio" name="level" value="A" /> A
                                  <input type="radio" name="level" value="B" checked="checked" /> B
                                  <input type="radio" name="level" value="C" /> C
                            </td>
                        </tr>
                        <tr>
                            <td  class="td-1">
                                <label for="password">品牌分类</label>
                            </td>
                            <td class="td-2">
                                <?php foreach($cat as $k => $v){ ?>
                                  <input type="checkbox" name="category_id[]" value="<?php echo $v['id'] ?>"  /><?php echo $v['name'] ?> 
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-1">&nbsp;</td>
                            <td class="td-2">
                                <a href="javascript:void(0);" id="submit_btn" class="btn-m btn-blue br3" switch="1" onclick="brand_submit();">保 存</a>
                                <a href="javascript:void(0);" class="btn-m btn-blue br3" onclick="$('.adds').css('display','none')">关 闭</a>
                            </td>
                        
                        </tr>
            </form>
            </table>                          
            </div>
             <div id="add_market1"  class="adds">
            <table>
            <form id="market_submit" method="post">
                        <tr>
                            <td  class="td-1" style="width: 50px;">
                                <label for="password">市场/商超名字</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="m_name" name="name" class="w226"/> 
                            </td>
                        </tr> 
                        <tr>
                            <td  class="td-1">
                                <label for="password">所属街道</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="m_street" name="street" class="w226" /> 
                            </td>
                        </tr>
                        <tr>
                            <td  class="td-1">
                                <label for="password">所属类型</label>
                            </td>
                            <td class="td-2">
                                  <input type="radio" name="class" value="1" checked="checked"/> 市场/商场
                                  <input type="radio" name="class" value="2"  /> 街道
                                  <input type="radio" name="class" value="3"  /> 超市
                            </td>
                        </tr>
                        <tr>
                            <td  class="td-1">
                                <label for="password">行政区</label>
                            </td>
                            <td class="td-2">
                                 <?php 
                                $province = isset($result['province']) ? $result['province'] : '';
                                $city     = isset($result['city']) ? $result['city'] : '';
                                $area     = isset($result['area']) ? $result['area'] : '';
                                require_once TPL_DIR . '/layout/address.php'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-1">&nbsp;</td>
                            <td class="td-2">
                                <a href="javascript:void(0);" id="submit_btn" class="btn-m btn-blue br3" switch="1" onclick="market_submit();">保 存</a>
                                <a href="javascript:void(0);" class="btn-m btn-blue br3" onclick="$('.adds').css('display','none')">关 闭</a>
                            </td>
                        
                        </tr>
            </form>
            </table>                          
            </div>
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
<script >
    $(function(){
        var market = $(this).val();
       $('#market_name').keyup(function(){
        
          if($(this).val()!= market){
            market = $(this).val();
            market_sub();
          }
       });
       
       var brand = $(this).val();
       $('#brand_name').keyup(function(){
          if($(this).val()!= brand){
            brand = $(this).val();
            brand_ids2();
          }
       });
       
    });
    
    function d_market1(name,id){
        $('#market_name').val(name);
        $('#market').val(id);
        $('#markets1').css('display','none');
    }
    
    function market_sub(){
        var market = $('#market_name').val();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","markets1"); ?>", //把表单数据发送到ajax.jsp
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
</script>
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
    function model(){
        $('#model2').css('display','none');
    }
    function model(){
        $('#model2').css('display','block');
    }
    function sort1(){
        $('#sort1').addClass('model');
      
    }
    function sort2(){
        $('#sort1').removeClass('model');
    }
    
    
      
        $(function(){
        $(".inp-w input").focus(function(){
            $(this).addClass("bg-f");
        }).blur(function(){
            ($(this).val()=="")&&$(this).removeClass("bg-f");
        });       
        
    });
    var address_name ='';
    $(function(){
    		var p = '<?php echo isset($result['province']) && !empty($result['province'])?$result['province']:0;?>';
    		var c = '<?php echo isset($result['city']) && !empty($result['city'])?$result['city']:0;?>';
    		var a = '<?php echo isset($result['area']) && !empty($result['area'])?$result['area']:0;?>';
    		var m = '<?php echo isset($result['market_id']) && !empty($result['market_id'])?$result['market_id']:0;?>';
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
            
            $('#shop_address_name').keyup(function(){
                var a_name = $('#shop_address_name').val();
                if(address_name == a_name){
                    
                }else{
                    a_name = address_name;
                    $id = $('#brand_id').val();
                    shop_address_name_sub($id);
                }
            })
           
    });
    
    function d_brand(name,id){
        $('#brand').val(name);
        $('#brand_id').val(id);
        $('#brands').css('display','none');
        shop_address_name_sub(id);
    }
    

  
  
    function brand_sub(){
        var brand = $('#brand').val();
        
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","brands2"); ?>", //把表单数据发送到ajax.jsp
            data: {brand:brand}, //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {
                $('#brands').html(data.msg);
                $('#brands').css('display','block');
            	
            }
        });
        return false;
    }

        //提交市场/商超添加
    function market_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_market"); ?>", //把表单数据发送到ajax.jsp
            data: $('#market_submit').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
                
            	if(data.status==1){
            	   $.tip('该市场/商超已经添加完成', 2);
                    $('#market').val(data.msg);
                    $('#market_name').val($('#m_name').val());
                    $('.adds').css('display','none');
            	}else{
            	   	$.tip(data.msg, 2);
            	}
            }
        });
        return false;
    }

    
    //提交注册
    function do_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_news"); ?>", //把表单数据发送到ajax.jsp
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

    //提交品牌添加
    function brand_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_brand3"); ?>", //把表单数据发送到ajax.jsp
            data: $('#brand_submit').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
                
            	if(data.status==1){
            	   $.tip('该品牌已经添加完成', 2);
                    $('#brand_id').val(data.msg);
                    $('#brand').val($('#b_name').val());
                    $('#add_brand').css('display','none');
            	}else{
            	   	$.tip(data.msg, 2);
            	}
            }
        });
        return false;
    }



  $(function(){
     $("#fcatid").change(function(){
            var pid = $("#fcatid option:selected").val();
            $("#scatid").html("");
            if(pid!=0){
                $.post("<?php echo spUrl("main", "get_category");?>", {pid:pid}, function(data){
                    if(data.status==1){
                        var html = '<option value="0">请选择...</option>';
                        $.each(data.data,function(i,item){
                            html += '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $("#scatid").html(html);
                    }else{
                        $("#scatid").html('<option value="0">请选择...</option>');
                    }
                }, "json");
            }else{
                $("#scatid").html('<option value="0">请选择...</option>');
            }
        });
  });
</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>