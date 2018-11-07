<?php require_once TPL_DIR.'/employees/emp_top.php';?>
<div class="user-wrap-bg">
    <div class="user-wrap">
        <div class="user-left">
            <?php require_once TPL_DIR.'/employees/nav.php';?>
        </div>
        <div class="user-right">
            <h2 class="tit" style="font-weight: bold;font-size: 18px;">个人中心</h2>
            
            <div style="padding:20px 10px;" >
            <p style="padding: 5px;font-size: 16px;" >信息统计</p>
                <table  class="addr-table" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                <td colspan='7'>消息信息统计</td>
                            </tr>
                        </thead>
                    <tr>
                        <td style="width:130px" rowspan="2">消息上传总数</td>
                        <td colspan="2">发送消息总数：<b><?php echo $z_count1+$z_count2+$z_count3+$z_count4+$z_count5; ?></b> / 金额：<b><?php echo $z_count1+($z_count2*2)+($z_count3*3); ?></b></td>
                        <td>奖励金额：<b><?php echo $z_reward*1; ?></b></td>
                        <td>通过市场消息：<b><?php echo $z_market_new_1*1; ?></b> / 金额：<b><?php echo $z_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                   		<td>1级总数：<b><?php echo $z_count1*1; ?></b> / 金额：<b><?php echo $z_count1*1; ?></b>	</td>
                        <td>2级总数：<b><?php echo $z_count2; ?></b> / 金额：<b><?php echo $z_count2*2; ?></b></td>
                        <td>3级总数：<b><?php echo $z_count3; ?></b> / 金额：<b><?php echo $z_count3*3; ?></b> </td>
                        <td>审核中：<b><?php echo $z_count4*1; ?></b> / 未通过：<b><?php echo $z_count5*1; ?></b> </td>
                    </tr>
                    <tr>
                        <td rowspan="2">最近3月消息上传数</td>
                        <td  colspan="2">发送消息总数：<b><?php echo $m3_count1+$m3_count2+$m3_count3+$m3_count4+$m3_count5; ?></b> / 金额：<b><?php echo $m3_count1+($m3_count2*2)+($m3_count3*3); ?></b></td>
                        <td>奖励金额：<b><?php echo $m3_reward*1; ?></b></td>
                         <td>通过市场消息：<b><?php echo $m3_market_new_1*1; ?></b> / 金额：<b><?php echo $m3_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                    	<td>1级总数：<b><?php echo $m3_count1*1; ?></b> / 金额：<b><?php echo $m3_count1*1; ?></b></td>
                        <td>2级总数：<b><?php echo $m3_count2; ?></b> / 金额：<b><?php echo $m3_count2*2 ?></b></td>
                        <td>3级总数：<b><?php echo $m3_count3; ?></b> / 金额：<b><?php echo $m3_count3*3; ?></b></td>
                        <td>审核中：<b><?php echo $m3_count4*1; ?></b> / 未通过：<b><?php echo $m3_count5*1; ?></b> </td>
                    </tr>
                    <tr>
                       <td rowspan="2">上月消息上传数</td>
                       <td  colspan="2">发送消息总数：<b><?php echo $m1_count1+$m1_count2+$m1_count3+$m1_count4+$m1_count5; ?></b> / 金额：<b><?php echo $m1_count1+($m1_count2*2)+($m1_count3*3); ?></b></td>
                       <td>奖励金额：<b><?php echo $m1_reward*1; ?></b></td>
                        <td>通过市场消息：<b><?php echo $m1_market_new_1*1; ?></b> / 金额：<b><?php echo $m1_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                    	<td>1级总数：<b><?php echo $m1_count1*1; ?></b> / 金额：<b><?php echo $m1_count1*1; ?></b></td>
                        <td>2级总数：<b><?php echo $m1_count2; ?></b> / 金额：<b><?php echo $m1_count2*2; ?></b></td>
                        <td>3级总数：<b><?php echo $m1_count3; ?></b> / 金额：<b><?php echo $m1_count3*3; ?></b></td>
                        <td>审核中：<b><?php echo $m1_count4*1; ?></b> / 未通过：<b><?php echo $m1_count5*1; ?></b> </td>
                    </tr>
                     <tr >
                        <td rowspan="2">当月消息上传数</td>
                        <td  colspan="2">发送消息总数：<b><?php echo $d1_count1+$d1_count2+$d1_count3+$d1_count4+$d1_count5; ?></b> / 金额：<b><?php echo $d1_count1+($d1_count2*2)+($d1_count3*3); ?></b></td>
                        <td>奖励金额：<b><?php echo $d1_reward*1; ?></b></td>
                        <td>通过市场消息：<b><?php echo $d1_market_new_1*1; ?></b> / 金额：<b><?php echo $d1_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                     	<td>1级总数：<b><?php echo $d1_count1*1; ?></b> / 金额：<b><?php echo $d1_count1*1; ?></b>	</td>
                        <td>2级总数：<b><?php echo $d1_count2; ?></b> / 金额：<b><?php echo $d1_count2*2; ?></b></td>
                        <td>3级总数：<b><?php echo $d1_count3; ?></b> / 金额：<b><?php echo $d1_count3*3; ?></b> </td>
                        <td>审核中：<b><?php echo $d1_count4*1; ?></b> / 未通过：<b><?php echo $d1_count5*1; ?></b> </td>
                    </tr>
                    <tr>
                        <td rowspan="2">上周消息上传数</td>
                        <td  colspan="2">发送消息总数：<b><?php echo $t2_count1+$t2_count2+$t2_count3+$t2_count4+$t2_count5; ?></b> / 金额：<b><?php echo $t2_count1+($t2_count2*2)+($t2_count3*3); ?></b></td>
                        <td>奖励金额：<b><?php echo $t2_reward*1; ?></b></td>
                        <td>通过市场消息：<b><?php echo $t2_market_new_1*1; ?></b> / 金额：<b><?php echo $t2_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                      	<td>1级总数：<b><?php echo $t2_count1*1; ?></b> / 金额：<b><?php echo $t2_count1*1; ?>	</td>
                        <td>2级总数：<b><?php echo $t2_count2; ?></b> / 金额：<b><?php echo $t2_count2*2; ?></b>	</td>
                        <td>3级总数：<b><?php echo $t2_count3; ?></b> / 金额：<b><?php echo $t2_count3*3; ?></b> </td>
                        <td>审核中：<b><?php echo $t2_count4; ?></b> / 未通过：<b><?php echo $t2_count5; ?></b> </td>
                    </tr>
                     <tr>
                        <td rowspan="2">本周消息上传数</td>
                        <td  colspan="2">发送消息总数：<b><?php echo $t_count1+$t_count2+$t_count3+$t_count4+$t_count5; ?></b>	 / 金额：<b><?php echo $t_count1+($t_count2*2)+($t_count3*3); ?></b></td>
                       <td>奖励金额：<b><?php echo $t_reward*1; ?></b></td>
                       <td>通过市场消息：<b><?php echo $t_market_new_1*1; ?></b> / 金额：<b><?php echo $t_market_new_1*10; ?></b></td>
                    </tr>
                    <tr>
                     	<td>1级总数：<b><?php echo $t_count1*1; ?></b>/ 金额：<b><?php echo $t_count1*1; ?>	</td>
                        <td>2级总数：<b><?php echo $t_count2; ?></b>/ 金额：<b><?php echo $t_count2*2; ?></b>	</td>
                        <td>3级总数：<b><?php echo $t_count3; ?></b> / 金额：<b><?php echo $t_count3*3; ?></b>  </td>
                        <td>审核中：<b><?php echo $t_count4*1; ?></b> / 未通过：<b><?php echo $t_count5*1; ?></b> </td>
                    </tr>
                </table>
               
            </div>
        </div>
    </div>
</div>
<style>
.addr-table tr td b{color:#F00; font-size:20pxw}
</style>
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