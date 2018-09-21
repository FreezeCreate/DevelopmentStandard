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
            <h2 class="tit"><?php echo ($result['id'])?'编辑':'添加'; ?>品牌</h2>
            <div class="clear">&nbsp;</div>
            
            <div class="add-right" style="padding-top:10px; width:980px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
                <table class="reg-table" style="width:900px; float:left;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="td-1"><b>*</b>品牌分类</td>
                        <td class="td-2" colspan="2">
                            <div class=" fl">
                            <?php foreach ($cate as $key => $value) { ?>
                            <div>
                                <input style="vertical-align: middle;" name="category_id[]" id="p-<?php echo $value['id']; ?>" type="checkbox" value="<?php echo $value["id"]; ?>" <?php echo in_array($value["id"], $results["category_id"])?'checked="checked"':''; ?> />  <?php echo $value["name"]; ?>
                                <p style="text-indent: 2em;">
                                    <?php foreach ($value["subcate"] as $k => $v) { ?>
                                        <input style="vertical-align: middle;" name="category_id[]" class="subcate" pid="<?php echo $value['id']; ?>" type="checkbox" value="<?php echo $v["id"]; ?>" <?php echo in_array($v["id"], $results["category_id"])?'checked="checked"':''; ?> />  <?php echo $v["name"]; ?> 
                                    <?php } ?>
                                </p>
                            </div>
                            <?php } ?>
                        </div>
                        </td>
                       
                    </tr>
                
                    <tr>
                        <td class="td-1"><b>*</b>品牌名字</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" name="name" id="b_name" value="<?php echo isset($results["name"])?$results["name"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td class="td-1">品牌产地</td>
                       <td class="td-2">
                            <div class="w120 fl">
                                <select class="w110 sel select-p" name="province">
                                    <option value="">请选择...</option>
                                    <?php foreach ($province as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results['province']) && $v['aid'] == $results['province'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="w120 fl">
                                <select class="w110 sel select-c" name="city">
                                    <option value="">请选择...</option>
                                    <?php foreach ($city as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results['city']) && $v['aid'] == $results['city'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="w130 fl">
                                <select class="w120 sel select-a" name="area">
                                    <option value="">请选择...</option>
                                    <?php foreach ($area as $v) { ?>
                                        <option value="<?php echo $v['aid']; ?>" <?php echo isset($results['area']) && $v['aid'] == $results['area'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
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
                                <input type="text" name="address" value="<?php echo isset($results["address"])?$results["address"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1"><b>*</b>品牌级别</td>
                        <td class="td-2">
                            <input type="radio" name="level" value="A" <?PHP if($results['level'] == 'A'){ ?> checked="checked" <?PHP } ?>/> A
                            <input type="radio" name="level" value="B" <?PHP if($results['level'] == 'B'){ ?> checked="checked" <?PHP } ?>/> B
                            <input type="radio" name="level" value="C" <?PHP if($results['level'] == 'C' || empty($results['level'])){ ?> checked="checked" <?PHP } ?>/> C
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">品牌简介</td>
                        <td class="td-2">
                            
                                <textarea class="txt" name="description" style="width:580px; height:200px; padding:3px; line-height:22px;"><?php echo isset($results["description"])?$results["description"]:''; ?></textarea>
                               
                           
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1"><b>*</b>上传品牌logo</td>
                        <td class="td-2">
                                <div style="float:left;">
                                    <input id="fileToUpload" type="file" name="fileToUpload" style="position:absolute; left:-9999px; top:-9999px;"  onchange='return ajaxFileUpload();' />
                                    <a id="up-a" class="btn-m btn-m-orange" href="javascript:void(0);" onclick="$('#fileToUpload').click();"><?php echo isset($results["image"])&&!empty($results["image"])?'重新上传':'上传图片'; ?></a>
                                    <span id="uploading" style="display:none;">（上传中...）</span>
                                </div>
                                
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <tr>
                        <td class="td-1">&nbsp;</td>
                        <td class="td-2" style="width:500px;">
                            <div style="width:100%;float:left;">
                            <div style="float:left;" id="tr-img1" <?php echo isset($results["logo"])&&!empty($results["logo"])?'':'style="display:none;"'; ?>>
                            <img id="img" src="<?php echo ($results["logo"])?$results["logo"]:''; ?>" width="200" height="100" />
                            <input type="hidden" id="uploaded-image" name="logo" value="<?php echo isset($results["logo"])?$results["logo"]:''; ?>" />
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
                </div>
            </form>
        </div>
            
        </div>
    </div>
</div>

<script>
           

                //上传图片
    function ajaxFileUpload(){
        $("#uploading").show();
        $("#tr-img2").hide();
        $.ajaxFileUpload({
            url:'<?php echo spUrl("uplaodimage","uploadimg"); ?>',
            secureuri:false,
            fileElementId:'fileToUpload',
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

    
    
        //提交剪裁
    
        
    

        $(function(){
        $(".inp-w input").focus(function(){
            $(this).addClass("bg-f");
        }).blur(function(){
            ($(this).val()=="")&&$(this).removeClass("bg-f");
        });       
        
    });
    
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
            //获取省市区下面的市场
            $(".select-a").change(function(){
                var that = $(this);
                var area = that.val();   
                
                $.post("<?php echo spUrl("market", "get_market"); ?>", {area:area}, function(data){
                    var market = new Array();
                    market.push('<option value="">选择市场/商场</option>');
                   if(data.status==1){
                        $.each(data.data,function(i,v){
                        	if(v.id == m){
                            	market.push('<option value="'+v.id+'" selected>'+v.name+'</option>');
                        	}else{
                            	market.push('<option value="'+v.id+'">'+v.name+'</option>');
                        	}
                        });  
                   }
                   market.push('<option value="-1">没有找到，点击添加</option>');
                   $(".get_m").html(market.join(''));
                }, "json");
            });
            
    });
        function brand_name(){
          var b_name = $('#b_name').val();
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl("employees","brand_name"); ?>", //把表单数据发送到ajax.jsp
                data: {b_name:b_name}, //要发送的是ajaxFrm表单中的数据
                dataType: "json",
                async: false,
                error: function(request) {
                    $.tip("数据请求失败！", 5);
                },
                success: function(data) { 
                   
                    if(data.status == 0){
                        $.tip(data.msg, 3);
                    }
                }
            });
            return false;
        }
    
        function do_submit(){
          
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl("employees","save_brand2"); ?>", //把表单数据发送到ajax.jsp
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
                        $.tip(data.msg, 2);
                        setTimeout("window.history.go(-1);", 2000);
                    }
                    
                }
            });
            return false;
        }
    

</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>