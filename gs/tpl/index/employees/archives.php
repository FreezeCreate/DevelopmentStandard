<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">店铺管理 
                <div style="padding:0px 0px 10px 0px;float: right;">
                    <a style="background: none; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_addr')?>" class="btn-m btn-blue br3">添加拜访店铺信息</a>
                </div>
            </h2>
           
            <div class="clear">&nbsp;</div>
           
            <div style="padding:0px 30px;">
                <form action="/employees/archives" method="post" id="form1">
                <div style="height: 40px;width: 100%; line-height: 40px; font-size: 16px;">
                    品牌名称：<input type="text" name="brand" style="height: 20px; width: 210px;" /><a href="javascript:void(0)" style="padding: 5px 10px;" onclick="$('#form1').submit();" >查&nbsp;询</a>
                </div>
                </form>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>商家品牌</td>
                                <td style="width: 100px;">店铺名称</td>
                                <td>商家账号</td>
                                <td>商家名字</td>
                                <td>商家电话</td>
                                <td>商家意向</td>
                                <td style="width: 200px;" >商家地址</td>
                                <td>下次回访时间</td>
                                <td>对商家描述</td>
                                <td style="width: 50px;">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($shop_address as $v){?>
                            <tr>
                                    <td>
                                        <?php echo $v['b_name'];?>
                                    </td>
                            		<td>
                                        <?php echo $v['shop_name'];?>
                                    </td>
                                    <td>
                                        <?php echo $v['usercode'];?>
                                    </td>
                                    <td>
                                        <?php echo $v['name'];?>
                                    </td>
                                    <td>
                                        <p><?php echo $v['phone1'];?></p>
                                        <p><?php echo $v['phone2'];?></p>
                                    </td>
                                    <td>
                                        <?php if($v['intention'] == 1) echo 'A'; if($v['intention'] == 2) echo 'B'; if($v['intention'] == 3) echo 'C';?>
                                    </td>
                                    <td>
                                        <p><?php echo $v['m_name1'].$v['address1']?></p>
                                        <p><?php echo $v['m_name2'].$v['address2']?></p>
                                        <p><?php echo $v['m_name3'].$v['address3']?></p>
                                    </td>
                                    <td>
                                        <?php echo $v['vistitime'];?>
                                    </td>
                                    <td>
                                        <?php echo $v['content'];?>
                                    </td>
                                    <td>
                                        <a href="/employees/edit_archives/id/<?php echo $v['id']?>">编辑</a>
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