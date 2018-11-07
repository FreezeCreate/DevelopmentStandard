<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">品牌管理</h2>
            
            <div class="clear">&nbsp;</div>
           
            <div style="padding:20px 30px;">
            <div style="padding:0px 0px 10px 0px;">
                    <a style="background: none; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_brand')?>" class="btn-m btn-blue br3">添加品牌信息</a>
                </div>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:50px;">ID</th>
                                <th style="width:100px;">品牌logo</th>
                                <th>品牌名称</th>
                                <th style="width:250px;">所属分类</th>
                                <th>产地</th>
                                <th>状态</th>
                                <th style="width:200px;" class="br0">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($results as $v){?>
                        	<tr>
                                <td><?php echo $v['id'];?></td>
                                <td><img src="<?php echo $v['logo'];?>"  height="100px"/></td>
                                <td><?php echo $v['name'];?></td>
                                <td><?php echo $v['category'];?></td>
                                <td>
                                    <?php echo $v['province']?$v['province']["name"]:'';?> 
                                    <?php echo $v['city']?$v['city']["name"]:'';?> 
                                    <?php echo $v['area']?$v['area']["name"]:'';?> 
                                    <?php echo $v['address'];?>
                                </td>
                                <td>
                                    <?php echo ($v['status']==1)?'已审核':'未审核';?>
                                </td>
                                <td>
                                    <a href="<?php echo spUrl($c,'edit_brand',array('id'=>$v['id']));?>">编辑</a> 
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <?php require_once TPL_DIR.'/layout/pager.php';?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                
                </div>
        </div>
    </div>
</div>
<style>
.div_sty{ overflow: hidden; margin-top:15px;border: 1px solid #CCCCCC;border-radius: 0 0 5px 5px;border-bottom:0px;}

.addr-table thead th{ border:#ccc 1px solid; text-align: left; padding: 0px 5px;color: #004992;font-size: 14px;font-weight: normal;line-height: 30px;height:30px;border-bottom: 1px solid #CCCCCC; background:#f1f2f4 url(../images/thead.png) repeat-x;}
.addr-table td{height:30px; padding:10px 0px 10px 5px; border: 1px solid #e2e2e2;font-size:14px;}
</style>
<script>
    $(function(){
        $(".inp-w input").focus(function(){
            $(this).addClass("bg-f");
        }).blur(function(){
            ($(this).val()=="")&&$(this).removeClass("bg-f");
        });
        
        $(".upload-img-box").hover(function(){
            if($("#uploaded-image").val()!=""){
                $("#re-up-a").show();
            }
        }, function(){
            $("#re-up-a").hide();
        });
        
        
    });
    
    //上传图片
    function ajaxFileUpload(){
        $("#up-a,#re-up-a,#uploaded-div").hide();
        $("#uploading-div").show();
        $.ajaxFileUpload({
            url:'<?php echo spUrl("uplaodimage","upload"); ?>',
            secureuri:false,
            fileElementId:'fileToUpload',
            dataType: 'json',
            data:{name:'logan', id:'id',w:200,h:200},
            success: function(data, status){
                 $("#uploading-div").hide();
                if(data.status==1){
                    $("#uploaded-img").attr("src", "/tmp/"+data.src);
                    $("#uploaded-image").val("/tmp/"+data.src);
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
                url: "<?php echo spUrl("mybrand","save_brand"); ?>", //把表单数据发送到ajax.jsp
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
                        setTimeout("window.location.reload();", 1000);
                    }
                    
                }
            });
            return false;
        }


</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>