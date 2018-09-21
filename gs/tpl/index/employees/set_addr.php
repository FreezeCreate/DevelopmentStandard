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
            <h2 class="tit">店铺管理 
                <div style="padding:0px 0px 10px 0px;float: right;">
                    <a style="background: none; width: 110px; background-color: #7CBAE5;" href="<?php echo spUrl('employees','add_addr')?>" class="btn-m btn-blue br3">添加拜访店铺信息</a>
                </div>
            </h2>
           
            <div class="clear">&nbsp;</div>
           
            <div style="padding:0px 30px;">
                    <form action="/employees/set_addr" method="post" id="form_addr">
                        意向：<select name="intention">
                            <option >全部</option>
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                            </select>
                        品牌名称：<input type="text" name="b_name"  />
                        开始时间：<input type="text" id="datetimepicker3" name="stime" value="" class="txt" />
                           结束时间：<input type="text" id="datetimepicker4" name="etime" value="" class="txt" />
                           <input type="button" value="查询" onclick="$('#form_addr').submit()" />                           
                    </form>
                    <div class="clear" style="height: 5px;">&nbsp;</div>
                    <table class="addr-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>品牌</td>
                                <td>店铺</td>
                                <td>名字</td>
                                <td>电话</td>
                                <td style="width:50px;">意向</td>
                                <td>商家地址</td>
                                <td>相关时间</td>
                                <td style="width: 200px;">对商家描述</td>
                                <td style="width: 80px;">操作</td>
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
                                        <p><?php echo $v['name'];?></p>
                                        <p><?php echo $v['usercode'];?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $v['phone1'];?></p>
                                        <p><?php echo $v['phone2'];?></p>
                                    </td>
                                    <td>
                                        <p><?php if($v['intention'] == 1) echo 'A'; if($v['intention'] == 2) echo 'B'; if($v['intention'] == 3) echo 'C';?></p>
                                        <p><?php if($v['stauts'] == 1) echo '合作'; if($v['stauts'] == 2) echo '跟进中'; if($v['stauts'] == 3) echo '拒绝';?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $v['address1']?></p>
                                        <p><?php echo $v['address2']?></p>
                                        <p><?php echo $v['address3']?></p>
                                    </td>
                                    <td>
                                        <p>记录：<?php echo date('m-d',$v['addtime']);?></p>
                                        <p>回访：<?php echo date('m-d',$v['vistitime']);?></p>
                                    </td>
                                    <td>
                                        <?php echo $v['content'];?>
                                    </td>
                                    <td>
                                        <a href="/employees/edit_addr/id/<?php echo $v['id']?>">编辑</a>
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