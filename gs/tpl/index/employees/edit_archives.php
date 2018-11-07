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
            <h2 class="tit"><?php echo ($result['id'])?'编辑':'添加'; ?>拜访店铺信息</h2>
            <div class="clear">&nbsp;</div>
            
            <div class="add-right" style="padding-top:10px; width:980px;">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
                <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
                <table class="reg-table" style="width:900px; float:left;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="td-1">对应商家账号</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" name="usercode" value="<?php echo isset($result["usercode"])?$result["usercode"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                	<tr>
                        <td class="td-1"><b>*</b>经营品牌</td>
                        <td class="td-2">
                            <input type="text" placeholder="请输入品牌名" class="txt"  value="" id="brand" /> &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="brand_sub()">搜索</a>&nbsp;&nbsp;<a href="Javascript:void(0)" onclick="$('#add_brand').css('display','block')">添加品牌</a>
                            <div id="brands" class="bms" style="">
                            
                            </div>
                            
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">品牌可多选</td>
                        <td class="td-2" >
                            <div class="brand_ids">
                            <?php if(!empty($brands) || isset($brands)){  ?>
                            <p><input type='hidden' value='<?php echo $brands['id'];?>' name='brand_ids[]'/><span><?php echo $brands['name'];?></span><a>x</a></p>
                            <?php } ?>
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1"><b>*</b>访谈对象</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" name="name" value="<?php echo isset($result["name"])?$result["name"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">访谈对象职位</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" name="position" value="<?php echo isset($result["position"])?$result["position"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                	<tr>
                        <td class="td-1"><b>*</b>经营店铺</td>
                        <td class="td-2" style="width:500px;">
                            <div class="inp-w">
                                <input type="text" name="shop_name" value="<?php echo isset($result["shop_name"])?$result["shop_name"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                	<tr>
                        <td class="td-1">移动电话1</td>
                        <td class="td-2">
                             <div class="inp-w">
                                <input type="text" name="phone1" value="<?php echo isset($result["phone1"])?$result["phone1"]:''; ?>" class="txt" />
                             </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">移动电话2</td>
                        <td class="td-2">
                             <div class="inp-w">
                                <input type="text" name="phone2" value="<?php echo isset($result["phone2"])?$result["phone2"]:''; ?>" class="txt" />
                             </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1">店铺电话</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="tel" value="<?php echo isset($result["tel"])?$result["tel"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="td-1"><b>*</b>所在市场/商超1</td>
                        <td class="td-2">
                           <input type="text" name="market_name1" value="<?php echo isset($market1["name"])?$market1["name"]:''; ?>" class="txt" id="market_name1" />
                           <input type="hidden" name="market1" id="market1" value="<?php echo isset($result["market1"])?$result["market1"]:''; ?>"  />
                            &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="market_sub1()">搜索</a>&nbsp;&nbsp;<a href="Javascript:void(0)" onclick="$('#add_market1').css('display','block')">添加市场/商超</a>
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
                                        market_sub1();
                                        yuans1 = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    <tr>
                        <td class="td-1"><b>*</b>店铺地址1</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="address1" value="<?php echo isset($result["address1"])?$result["address1"]:''; ?>" class="txt" />
                                
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td class="td-1">所在市场/商超2</td>
                        <td class="td-2">
                           <input type="text" name="market_name2" value="<?php echo isset($market2["name"])?$market2["name"]:''; ?>" class="txt" id="market_name2" />
                           <input type="hidden" name="market2" id="market2" value="<?php echo isset($result["market2"])?$result["market2"]:''; ?>"  />
                            &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="market_sub2()">搜索</a>&nbsp;&nbsp;<a href="Javascript:void(0)" onclick="$('#add_market2').css('display','block')">添加市场/商超</a>
                            <div id="markets2" class="bms" style="">
                            
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <script type="text/javascript">
                               $(function(){
                                   var yuans2 = $("#market_name2").val(); 
                                   $("#market_name2").keyup(function(){
                                      if($(this).val()!=yuans2)
                                      {
                                        market_sub2();
                                        yuans2 = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    <tr>
                        <td class="td-1">店铺地址2</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="address2" value="<?php echo isset($result["address2"])?$result["address2"]:''; ?>" class="txt" />
                                
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td class="td-1">所在市场/商超3</td>
                        <td class="td-2">
                           <input type="text" name="market_name3" value="<?php echo isset($market3["name"])?$market3["name"]:''; ?>" class="txt" id="market_name3" />
                           <input type="hidden" name="market3" id="market3" value="<?php echo isset($result["market3"])?$result["market3"]:''; ?>"  />
                            &nbsp;&nbsp;<a href="Javascript:void(0)" onclick="market_sub3()">搜索</a>&nbsp;&nbsp;<a href="Javascript:void(0)" onclick="$('#add_market').css('display','block')">添加市场/商超</a>
                            <div id="markets3" class="bms" style="">
                            
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    <script type="text/javascript">
                               $(function(){
                                   var yuans3 = $("#market_name3").val(); 
                                   $("#market_name3").keyup(function(){
                                      if($(this).val()!=yuans3)
                                      {
                                        market_sub3();
                                        yuans3 = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    <tr>
                        <td class="td-1">店铺地址3</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" name="address3" value="<?php echo isset($result["address3"])?$result["address3"]:''; ?>" class="txt" />
                                
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                    <style>
                        .bms{width: 100%; height: 200px; border: 1px solid #ccc; margin: 5px 0px; display: none; overflow: hidden;}
                        .bms a{margin: 0 5px; line-height: 20px;}
                    </style>

                    
                      <script type="text/javascript">
                               $(function(){
                                   var yuan = $("#brand").val(); 
                                   $("#brand").keyup(function(){
                                      if($(this).val()!=yuan)
                                      {
                                        brand_sub();
                                        yuan = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                    
                    <style>
                        .bms{width: 100%; height: 200px; border: 1px solid #ccc; margin: 5px 0px; display: none; overflow: hidden;}
                        .bms a{margin: 0 5px; line-height: 20px;}
                    </style>
                    
                    
                      <script type="text/javascript">
                               $(function(){
                                   var yuan = $("#brand").val(); 
                                   $("#brand").keyup(function(){
                                      if($(this).val()!=yuan)
                                      {
                                        brand_sub();
                                        yuan = $(this).val();
                                      }
                                   });
                                  
                               });
                            </script>
                     <tr>
                        <td class="td-1"><b>*</b>商家意向</td>
                        <td class="td-2">
                            <input type="radio" name="intention" value="1" <?php if($result["intention"] == 1){ ?> checked <?php } ?> />A&nbsp;&nbsp;
                            <input type="radio" name="intention" value="2" <?php if($result["intention"] == 2){ ?> checked <?php } ?> />B&nbsp;&nbsp;
                            <input type="radio" name="intention" value="3" <?php if($result["intention"] == 3){ ?> checked <?php } ?> />C&nbsp;&nbsp;
	                       </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                     <tr>
                        <td class="td-1"><b>*</b>商家状态</td>
                        <td class="td-2">
                            <input type="radio" name="stauts" value="1" <?php if($result["stauts"] == 1){ ?> checked <?php } ?> />已合作&nbsp;&nbsp;
                            <input type="radio" name="stauts" value="2" <?php if($result["stauts"] == 2){ ?> checked <?php } ?> />跟进中&nbsp;&nbsp;
                            <input type="radio" name="stauts" value="3" <?php if($result["stauts"] == 3){ ?> checked <?php } ?> />拒绝&nbsp;&nbsp;
	                       </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                     <tr>
                        <td class="td-1">回访时间</td>
                        <td class="td-2">
                            <div class="inp-w">
                                <input type="text" id="datetimepicker1" name="vistitime" value="<?php echo isset($result["vistitime"])?$result["vistitime"]:''; ?>" class="txt" />
                            </div>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                     <tr>
                        <td class="td-1"><b>*</b>对商家描述</td>
                        <td class="td-2">
                           <textarea name="content" style="min-height: 100px; min-width: 352px;"><?php echo $value["content"]; ?></textarea>
                        </td>
                        <td class="td-3">&nbsp;</td>
                    </tr>
                    
                   
                    <tr>
                        <td class="td-1">上传店铺图片</td>
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
                            <div style="float:left;" id="tr-img1" <?php echo isset($result["image"])&&!empty($result["image"])?'':'style="display:none;"'; ?>>
                            <img id="img" src="<?php echo ($result["image"])?$result["image"]:''; ?>" width="200" height="100" />
                            <input type="hidden" id="uploaded-image" name="image" value="<?php echo isset($result["image"])?$result["image"]:''; ?>" />
                            </div>
                            
                        </td>
                        <td class="td-3"></td>
                    </tr>
                    <input type="hidden" name="caozuo" value="<?php echo $result['caozuo'];?>"/>
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
                                <?php foreach($category as $k => $v){ ?>
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
            <form id="market_submit1" method="post">
                        <tr>
                            <td  class="td-1" style="width: 50px;">
                                <label for="password">市场/商超名字</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="m_name1" name="name" class="w226"/> 
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
                                  <input type="radio" name="class" value="1" checked="checked"/> 市场/商超
                                  <input type="radio" name="class" value="2"  /> 街道
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
            <div id="add_market2"  class="adds">
            <table>
            <form id="market_submit2" method="post">
                        <tr>
                            <td  class="td-1" style="width: 50px;">
                                <label for="password">市场/商超名字</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="m_name2" name="name" class="w226"/> 
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
                                  <input type="radio" name="class" value="1" checked="checked"/> 市场/商超
                                  <input type="radio" name="class" value="2"  /> 街道
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
            <div id="add_market3"  class="adds">
            <table>
            <form id="market_submit3" method="post">
                        <tr>
                            <td  class="td-1" style="width: 50px;">
                                <label for="password">市场/商超名字</label>
                            </td>
                            <td class="td-2">
                                  <input type="text" id="m_name3" name="name" class="w226"/> 
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
                                  <input type="radio" name="class" value="1" checked="checked"/> 市场/商超
                                  <input type="radio" name="class" value="2"  /> 街道
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

<style>
.adds{position: fixed;width: 450px;background: #FFFFFF;top: 20%; border:1px solid; margin-left: 159px; display: none; }
.adds tr{ line-height: 28px;}
.adds tr td{ line-height: 28px; padding: 5px;}
.adds tr td input{vertical-align: middle; height: 28px; }
.w226{width: 226px;}
.brand_ids p{float:left;padding-right:25px;margin-bottom:10px;position:relative;background:#f3f3f3;color:#333;margin-right:10px;padding-left:15px;line-height:25px;}
.brand_ids p a{position:absolute;display:block;right:0px;top:0px;text-align:center;width:20px;height:20px;color:#666;line-height:20px;}
.brand_ids p a:hover{color:red;}
</style>


<script>
          $(document).ready(function(){
            $(".brand_ids a").each(function(){
                $(this).click(function(){
                    $(this).parent().remove();
                });
            });
        });         
          
            
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
    
    <?php if(empty($brands)){ ?>
    function d_brand(name,id){
            var text = name;
            var oid = id;
            var htmls = "";
            var num = 0;
            $(".brand_ids span").each(function(){
                if($(this).html() == text)
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
                htmls = "<p><input type='hidden' value='"+oid+"' name='brand_ids[]'/><span>"+text+"</span><a>x</a></p>";
                $(".brand_ids").append(htmls);  
            }   
            $(".brand_ids a").click(function(){
                $(this).parent().remove();
            });
            $('#brands').css('display','none');
        
        $('#brands').css('display','none');
    }
    <?php }else{ ?>
        function d_brand(name,id){
            var text = name;
            var oid = id;
            var htmls = "";
            var num = 0;
            $(".brand_ids span").each(function(){
                if($(this).html() != '')
                {   
                    num = 1;
                }
            });
            if(num==1)
            {
                 alert("修改信息只能有1个品牌");$('#brands').css('display','none'); return false;
               
            }
            else
            {
                htmls = "<p><input type='hidden' value='"+oid+"' name='brand_ids[]'/><span>"+text+"</span><a>x</a></p>";
                $(".brand_ids").append(htmls);  
            }   
            $(".brand_ids a").click(function(){
                $(this).parent().remove();
            });
            $('#brands').css('display','none');
        
        $('#brands').css('display','none');
    }
    <?php } ?>

    function d_market1(name,id){
        $('#market_name1').val(name);
        $('#market1').val(id);
        $('#markets1').css('display','none');
    }
    
    function d_market2(name,id){
        $('#market_name2').val(name);
        $('#market2').val(id);
        $('#markets2').css('display','none');
    }
    
    function d_market3(name,id){
        $('#market_name3').val(name);
        $('#market3').val(id);
        $('#markets3').css('display','none');
    }
    
    function brand_sub(){
        var brand = $('#brand').val();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","brands"); ?>", //把表单数据发送到ajax.jsp
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
    
     function market_sub1(){
        var market = $('#market_name1').val();
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
    
    function market_sub2(){
        var market = $('#market_name2').val();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","markets2"); ?>", //把表单数据发送到ajax.jsp
            data: {market:market}, //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {
                $('#markets2').html(data.msg);
                $('#markets2').css('display','block');
            	
            }
        });
        return false;
    }
    
    function market_sub3(){
        var market = $('#market_name3').val();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","markets3"); ?>", //把表单数据发送到ajax.jsp
            data: {market:market}, //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {
                $('#markets3').html(data.msg);
                $('#markets3').css('display','block');
            	
            }
        });
        return false;
    }
    
    //提交注册
    function do_submit(){
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl("employees","save_archives"); ?>", //把表单数据发送到ajax.jsp
            data: $('#submit_form').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
            	$.tip(data.msg, 2);
                
            	if(data.status==1){
	                  window.location.href="<?php echo spUrl('employees','set_addr');?>";
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
            url: "<?php echo spUrl("employees","save_brand"); ?>", //把表单数据发送到ajax.jsp
            data: $('#brand_submit').serialize(), //要发送的是ajaxFrm表单中的数据
            dataType: "json",
            async: false,
            error: function(request) {
                $.tip("数据请求失败！", 5);
            },
            success: function(data) {  
                
            	if(data.status==1){
            	   $.tip('该品牌已经添加完成', 2);
                    var text = $('#b_name').val();
                    var oid = data.msg;
                    var htmls = "";
                    var num = 0;
                    <?php if(empty($brands)){ ?>
                    $(".brand_ids span").each(function(){
                        if($(this).html() == text)
                        {   
                            num = 1;
                        }
                    });
                    if(num==1)
                    {
                        return false;alert("a");
                    }
                    <?php }else{?>
                    $(".brand_ids span").each(function(){
                        if($(this).html() != '')
                        {   
                            num = 1;
                        }
                    });
                    if(num==1)
                    {
                         alert("修改信息只能有1个品牌");$('#brands').css('display','none'); return false;
                       
                    }
                    <?php }?>
                    else
                    {
                        htmls = "<p><input type='hidden' value='"+oid+"' name='brand_ids[]'/><span>"+text+"</span><a>x</a></p>";
                        $(".brand_ids").append(htmls);  
                    }   
                    $(".brand_ids a").click(function(){
                        $(this).parent().remove();
                    });
                    $('#add_brand').css('display','none');
            	}else{
            	   	$.tip(data.msg, 2);
            	}
            }
        });
        return false;
    }
    
        //提交品牌添加
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

</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>