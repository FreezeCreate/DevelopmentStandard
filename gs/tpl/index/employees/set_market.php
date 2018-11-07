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
            <h2 class="tit">市场管理 
               
            </h2>
           
            <div class="clear">&nbsp;</div>
           
            <div style="padding:0px 30px;">
                    <form action="/employees/set_market" method="post" id="form_addr">
                        类型：<select name="class">
                            <option value="0">全部</option>
                            <option value="1">市场/商超</option>
                            <option value="2">街道</option>
                            <option value="3">超市</option>
                            </select>
                        市场名称：<input type="text" name="name"  />
                           <input type="button" value="查询" onclick="$('#form_addr').submit()" />                           
                    </form>
                    <div class="clear" style="height: 5px;">&nbsp;</div>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>市场名称</td>
                                <td>类型</td>
                                <td>所在位置</td>
                                <td>联系信息</td>
                                <td >操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($reuslt as $v){?>
                            <tr>
                                    <td>
                                        <?php echo $v['name'];?>
                                    </td>
                            		<td>
                                        <?php if($v['class'] == 1){echo '市场/商场';} if($v['class'] == 3){echo '超市';}?>
                                    </td>
                                    <td>
                                        <?php echo $v['address']?>
                                    </td>
                                    <td>
                                        <?php echo $v['phone'];?>/<?php echo $v['tel'];?>
                                    </td>
                                    <td>
                                        <a href="/employees/edit_market_new/id/<?php echo $v['id']?>">市场信息编辑</a>
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