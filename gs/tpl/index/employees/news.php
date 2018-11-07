<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">消息管理<a style="background: none;float:right;margin-top:8px; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_news')?>" class="btn-m btn-blue br3">发布信息</a></h2>
            <div class="clear">&nbsp;</div>
           
            <div style="padding:20px 30px;">
            <?php if($_SESSION['emp']['effective'] ==1){?>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>标题</td>
                                <td style="width:80px">上传时间</td>
                                <td style="width:80px">电话</td>
                                <td style="width:80px">图片</td>
                                <td style="width:80px">分类</td>
                                <td style="width:80px">品牌</td>
                                <td style="width:80px">市场/商超</td>
                                <td style="width:80px">街道</td>
                                <td style="width:50px">状态</td>
                                <td style="width:70px">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($news as $v){?>
                            <tr>
                            		<td>
                                        <?php echo $v['title'];?>
                                    </td>
                                     <td>
                                        <?php echo date('Y-m-d',$v['addtime']);?>
                                    </td>
                                    <td>
                                        <?php echo $v['phone'];?>
                                    </td>
                                    <td>
                                        <img src=" <?php echo $v['image'];?>" width="80" height="80" />
                                    </td>
                                    <td>
                                        <?php echo $v['c_name'];?>
                                    </td>
                                    <td>
                                        <?php echo $v['brand_name'];?>
                                    </td>
                                    <td><?php echo $v['m_name'] ?></td>
                                    <td><?php echo $v['street'] ?></td>
                                    
                                    <td>
                                        <?php if($v['status'] == 1){ echo '审核通过';} 
                                              if($v['status'] == 2){ echo '未通过' ;} 
                                              if($v['status'] == 0 || $v['status'] == 3){ echo '审核中';} ?>/
                                               
                                    </td>
                                    <td>
                                    <?php if($v['status'] != 1){?><a href="<?php echo spUrl('employees','edit_news',array('id'=>$v['id']))?>">编辑</a><?php } ?>
                                     <?php if($_SESSION['emp']['effective'] ==1){?><a onclick="del_news(<?php echo $v['id'];?>)" href="javascript:void(0)">删除</a><?php }?>
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
            <?php } ?>
            <?php if($_SESSION['emp']['effective'] ==2){?>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>标题</td>
                                <td style="width:80px">上传时间</td>
                                <td style="width:80px">电话</td>
                                <td style="width:80px">图片</td>
                                <td style="width:80px">品牌</td>
                                <td style="width:80px">市场/商超</td>
                                <td style="width:50px">状态</td>
                                <td style="width:50px">级别</td>
                                <td style="width:50px">奖励</td>
                                <td style="width:70px">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($news as $v){?>
                            <tr>
                            		<td>
                                        <?php echo $v['title'];?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d',$v['addtime']);?>
                                    </td>
                                    <td>
                                        <?php echo $v['phone'];?>
                                    </td>
                                    <td>
                                        <img src=" <?php echo $v['image'];?>" width="80" height="80" />
                                    </td>
                                    <td>
                                        <?php echo $v['brand_name'];?>
                                    </td>
                                    <td><?php echo $v['m_name'] ?></td>
                                   
                                    <td>
                                        <?php if($v['status'] == 1){ echo '审核通过';} 
                                              if($v['status'] == 2){ echo '未通过' ;} 
                                              if($v['status'] == 0 || $v['status'] == 3){ echo '审核中';} ?>
                                               
                                    </td>
                                    <td>
                                        <?php echo $v['level'];?>
                                    </td>
                                     <td>
                                        <?php echo $v['reward'];?>
                                    </td>
                                    <td>
                                    <?php if($v['status'] != 1){?><a href="<?php echo spUrl('employees','edit_news',array('id'=>$v['id']))?>">编辑</a><?php } ?>
                                    
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
            <?php } ?>
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

<script>
    //提交注册
        function del_news(id){
            if(confirm("确定删除吗？")){
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "<?php echo spUrl("employees","del_news"); ?>", //把表单数据发送到ajax.jsp
                    data: {id:id},
                    dataType: "json",
                    async: false,
                    error: function(request) {
                        $.tip("数据请求失败！", 5);
                    },
                    success: function(data) {  
                        $.tip(data.msg, 1);
                        if(data.status==1){
                            setTimeout("window.location.reload();", 1000);
                        }
                    }
                });
            }
        }


</script>


<?php require_once TPL_DIR.'/layout/user_footer.php';?>