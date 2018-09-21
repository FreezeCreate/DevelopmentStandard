<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/jquery.datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/main-min.js"></script>
<script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery.datetimepicker.js"></script>
<style>
.addr-table td{height:30px; padding: 10px 0px 10px 1px; border-bottom:1px solid #e2e2e2; font-size:14px;}
</style>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit">兼职人员管理
                <div style="padding:0px 0px 10px 0px;float: right;">
                    <a style="background: none; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_jianzhi')?>" class="btn-m btn-blue br3">添加兼职人员</a>
                </div>
            </h2>
           
            <div class="clear">&nbsp;</div>
           
            <div style="padding:0px 30px;">
                    <form action="/employees/set_jianzhis" method="post" id="form_addr">
                       
                        兼职人员姓名：<input type="text" name="name"  />
                       
                           <input type="button" value="查询" onclick="$('#form_addr').submit()" />                           
                    </form>
                    <div class="clear" style="height: 5px;">&nbsp;</div>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>名字</td>
                                <td>电话</td>
                                <td >操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($jianzhi as $v){?>
                            <tr>
                                    <td>
                                        <?php echo $v['name'];?>
                                    </td>
                            		<td>
                                        <?php echo $v['phone'];?>
                                    </td>
                                    <td>
                                        <a href="/employees/fnews/userid/<?php echo $v['userid']?>">查看消息</a>
                                        <a href="/employees/set_market/emp_id/<?php echo $v['id']?>">查看市场消息</a>
                                        <a href="/employees/edit_jianzhi/id/<?php echo $v['id']?>">编辑</a>
                                        <a onclick="del_addr(<?php echo $v['id'];?>)" href="javascript:void(0)">删除</a>
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
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
                    url: "<?php echo spUrl("employees","del_jianzhi"); ?>", //把表单数据发送到ajax.jsp
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