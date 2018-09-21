<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">店铺管理</h2>
            
            <div class="clear">&nbsp;</div>
           
            <div style="padding:20px 30px;">
            <div style="padding:0px 0px 10px 0px;">
                    <a style="background: none; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_card')?>" class="btn-m btn-blue br3">添加名片</a>
                </div>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>店铺名称</td>
                                <td>商家名字</td>
                                <td>商家电话</td>
                                <td>商家品牌</td>
                                <td>商家地址</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($shop_address as $v){?>
                            <tr>
                            		<td>
                                        <?php echo $v['shop_name'];?>
                                    </td>
                                 
                                    <td>
                                        <?php echo $v['name'];?>
                                    </td>
                                    <td>
                                        <p><?php echo $v['phone1'];?></p>
                                        <p><?php echo $v['phone2'];?></p>
                                    </td>
                                    <td>
                                        <?php echo $v['b_name'];?>
                                    </td>
                                  
                                    <td>
                                        <p><?php echo $v['m_name1'].$v['address1']?></p>
                                        <p><?php echo $v['m_name2'].$v['address2']?></p>
                                        <p><?php echo $v['m_name3'].$v['address3']?></p>
                                    </td>
                                    
                                    <td>
                                        <a href="/employees/edit_card/id/<?php echo $v['id']?>">编辑</a>
                                        <a onclick="del_addr(<?php echo $v['id'];?>)" href="javascript:void(0)">删除</a>
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

<script>
    //提交注册
        function del_addr(id){
            if(confirm("确定删除吗？")){
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "<?php echo spUrl("employees","del_addr"); ?>", //把表单数据发送到ajax.jsp
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