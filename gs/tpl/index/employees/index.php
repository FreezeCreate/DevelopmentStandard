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
                                <td colspan='6'>消息信息统计</td>
                            </tr>
                        </thead>
                    <tr>
                        <td colspan="6">
                             <?php 
                                $m_news = spClass('m_news');
                                $m_cat = spClass('m_category');
                                $cat = $m_cat->get_category(0);
                                 foreach($cat as $k => $v){
                                    $count = $m_news->get_new_cat_count($v['id']);?>
                                    <a style="margin: 0px 10px;" ><?php echo $v['name'];?>(<?php echo $count;?>)</a>
                                 <?php } ?>  
                        </td>
                    </tr>
                  
                    <tr>
                        <td style="width:150px">消息上传总数：</td>
                        <td></p>
                            <p>总数（<?php echo $z_count_1+$z_count_2+$z_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $z_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php echo $z_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $z_count_2; ?>）</a></p>
                        </td>
                        <td style="width:150px">上月消息上传数：</td>
                        <td>
                            <p>总数（<?php echo $z_s_count_1+$z_s_count_2+$z_s_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $z_s_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php echo $z_s_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $z_s_count_2; ?>）</a></p>
                        </td>
                        <td style="width:150px">当月消息上传数：</td>
                        <td> 
                            <p>总数（<?php echo $z_d_count_1+$z_d_count_2+$z_d_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $z_d_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php  echo $z_d_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $z_d_count_2; ?>）</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:130px">本人消息上传总数：</td>
                        <td> 
                            <p>总数（<?php echo $my_count_1+$my_count_2+$my_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $my_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php echo $my_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $my_count_2; ?>）</a></p>
                        </td>
                        <td style="width:130px">上月本人消息上传数：</td>
                        <td>
                            <p>总数（<?php echo $my_s_count_1+$my_s_count_2+$my_s_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $my_s_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php echo $my_s_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $my_s_count_2; ?>）</a></p>
                        </td>
                        <td style="width:130px">当月本人消息上传数：</td>
                        <td>
                            <p>总数（<?php echo $my_d_count_1+$my_d_count_2+$my_d_count_3; ?>）</p>
                            <p><a href="/employees/news?status=1">通过审核（<?php echo $my_d_count_1; ?>）</a></p>
                            <p><a href="/employees/news?status=3">审核中（<?php echo $my_d_count_3; ?>）</a></p>
                            <p><a href="/employees/news?status=2">无效（<?php echo $my_d_count_2; ?>）</a></p>
                        </td>
                    </tr>
                    
                </table>
                <div class="clear" style="height: 20px;">&nbsp;</div>
                <table  class="addr-table" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                <td colspan='7'>兼职消息信息统计</td>
                            </tr>
                        </thead>
                    <tr>
                        <td style="width:45px">姓名：</td>
                        <td>上传消息总数</td>
                        <td>近3月消息上传数</td>
                        <td>上月消息上传数</td>
                        <td>当月消息上传数</td>
                        <td>上周消息上传数</td>
                        <td>本周消息上传数</td>
                    </tr>
                    <?php if($_SESSION['emp']['id'] == 6){?>
                    <?php foreach($jz as $k => $v){?>
                    <tr>
                        <td><?php echo $v['name']?></td>
                        <td > 
                            <p>总数：<b><?php echo  $v['z_count1']+$v['z_count2']+$v['z_count3']+$v['z_count4']+$v['z_count5']; ?></b>
                            /金额：<b><?php echo  $v['z_count1']+$v['z_count2']*2+$v['z_count3']*3 ?></b></p>
                            <p>1级：<b><?php echo $v['z_count1']; ?></b>/金额：<b><?php echo $v['z_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['z_count2']; ?></b>/金额：<b><?php echo $v['z_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['z_count3']; ?></b>/金额：<b><?php echo $v['z_count3']*3; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['z_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['z_market_new_1']*10; ?></b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['m3_count']+$v['m3_count2']+$v['m3_count3']+$v['m3_count4']+$v['m3_count5']; ?></b>
                            /金额：<b><?php echo  $v['m3_count']+$v['m3_count2']*2+$v['m3_count3']*3; ?></b>
                            </p>
                            <p>1级：<b><?php echo $v['m3_count1']; ?></b>/金额：<b><?php echo $v['m3_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['m3_count2']; ?></b>/金额：<b><?php echo $v['m3_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['m3_count3']; ?></b>/金额：<b><?php echo $v['m3_count3']*3; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['m3_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['m3_market_new_1']*10; ?></b></p>
                        </td>
                        <td >
                            <p>总数：<b><?php echo  $v['m1_count1']+$v['m1_count2']+$v['m1_count3']+$v['m1_count4']+$v['m1_count5']; ?></b>
                            /金额：<b><?php echo  $v['m1_count1']+$v['m1_count2']*2+$v['m1_count3']*3; ?></b>
                            </p>
                            <p>1级：<b><?php echo $v['m1_count1']; ?></b>/金额：<b><?php echo $v['m1_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['m1_count2']; ?></b>/金额：<b><?php echo $v['m1_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['m1_count3']; ?></b>/金额：<b><?php echo $v['m1_count3']*3; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['m1_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['m1_market_new_1']*10; ?></b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['d1_count1']+$v['d1_count2']+$v['d1_count3']+$v['d1_count4']+$v['d1_count5']; ?></b>
                            /金额：<b><?php echo  $v['d1_count1']+$v['d1_count2']*2+$v['d1_count3']*3; ?></b>
                            </p>
                            <p>1级：<b><?php echo $v['d1_count1']; ?></b>/金额：<b><?php echo $v['d1_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['d1_count2']; ?></b>/金额：<b><?php echo $v['d1_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['d1_count3']; ?></b>/金额：<b><?php echo $v['d1_count3']*3; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['d1_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['d1_market_new_1']*10; ?></b></p>
                        </td>
                        <td >
                        <p>总数：<b><?php echo  $v['t2_count1']+$v['t2_count2']+$v['t2_count3']+$v['t2_count4']+$v['t2_count5']; ?></b>
                        /金额：<b><?php echo  $v['t2_count1']+$v['t2_count2']*2+$v['t2_count3']*3; ?></b>
                        </p>
                            <p>1级：<b><?php echo $v['t2_count1']; ?></b>/金额：<b><?php echo $v['t2_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['t2_count2']; ?></b>/金额：<b><?php echo $v['t2_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['t2_count3']; ?></b>/金额：<b><?php echo $v['t2_count3']*3; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['t2_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['t2_market_new_1']*10; ?></b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['t_count1']+$v['t_count2']+$v['t_count3']+$v['t_count4']+$v['t_count5']; ?></b>
                            /金额：<b><?php echo  $v['t_count1']+$v['t_count2']*2+$v['t_count3']*3; ?></b>
                            </p>
                            <p>1级：<b><?php echo $v['t_count1']; ?></b>/金额：<b><?php echo $v['t_count1']; ?></b></p>
                            <p>2级：<b><?php echo $v['t_count2']; ?></b>/金额：<b><?php echo $v['t_count2']*2; ?></b></p>
                            <p>3级：<b><?php echo $v['t_count3']; ?></b>/金额：<b><?php echo $v['t_count3']*3; ?></b></p>
                          	<p>奖励金额：<b><?php echo $v['t_reward']; ?></b></p>
                            <p>市场消息金额：<b><?php echo $v['t2_market_new_1']*10; ?></b></p>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php }else{ ?>
                          <?php foreach($jz as $k => $v){?>
                    <tr>
                        <td style="width:130px"><?php echo $v['name']?></td>
                        <td > 
                            <p>总数：<b><?php echo  $v['z_count1']+$v['z_count2']+$v['z_count3']+$v['z_count4']+$v['z_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['z_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['z_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['z_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['z_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['z_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['z_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['z_market_new_1']; ?>条</b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['m3_count']+$v['m3_count2']+$v['m3_count3']+$v['m3_count4']+$v['m3_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['m3_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['m3_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['m3_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['m3_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['m3_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['m3_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['m3_market_new_1']; ?>条</b></p>
                        </td>
                        <td >
                            <p>总数：<b><?php echo  $v['m1_count1']+$v['m1_count2']+$v['m1_count3']+$v['m1_count4']+$v['m1_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['m1_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['m1_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['m1_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['m1_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['m1_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['m1_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['m1_market_new_1']; ?>条</b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['d1_count1']+$v['d1_count2']+$v['d1_count3']+$v['d1_count4']+$v['d1_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['d1_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['d1_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['d1_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['d1_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['d1_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['d1_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['d1_market_new_1']; ?>条</b></p>
                        </td>
                        <td >
                        <p>总数：<b><?php echo  $v['t2_count1']+$v['t2_count2']+$v['t2_count3']+$v['t2_count4']+$v['t2_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['t2_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['t2_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['t2_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['t2_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['t2_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['t2_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['t2_market_new_1']; ?>条</b></p>
                        </td>
                        <td>
                            <p>总数：<b><?php echo  $v['t_count1']+$v['t_count2']+$v['t_count3']+$v['t_count4']+$v['t_count5']; ?></b></p>
                            <p>1级总数：<b><?php echo $v['t_count1']; ?></b></p>
                            <p>2级总数：<b><?php echo $v['t_count2']; ?></b></p>
                            <p>3级总数：<b><?php echo $v['t_count3']; ?></b></p>
                            <p>审核中：<b><?php echo $v['t_count4']; ?></b></p>
                            <p>未通过：<b><?php echo $v['t_count5']; ?></b></p>
                            <p>奖励金额：<b><?php echo $v['t_reward']; ?></b></p>
                            <p>通过市场消息：<b><?php echo $v['t_market_new_1']; ?>条</b></p>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </table>
                <div class="clear" style="height: 20px;">&nbsp;</div>
                <table  class="addr-table" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                <td colspan='6'>拜访店铺信息统计</td>
                            </tr>
                        </thead>
                    <tr>
                        <td style="width:150px">店铺上传总数：</td>
                        <td><?php echo $z_shop_count; ?></td>
                        <td style="width:150px">上月店铺上传数：</td>
                        <td><?php echo $z_shop_s_count; ?></td>
                        <td style="width:150px">当月店铺上传数：</td>
                        <td><?php echo $z_shop_d_count; ?></td>
                    </tr>
                    <tr>
                        <td style="width:150px">本人店铺上传总数：</td>
                        <td><?php echo $my_shop_count; ?></td>
                        <td style="width:150px">上月本人店铺上传数：</td>
                        <td><?php echo $my_shop_s_count; ?></td>
                        <td style="width:150px">当月本人店铺上传数：</td>
                        <td><?php echo $my_shop_d_count; ?></td>
                    </tr>
                    
                    <tr>
                        <td style="width:150px">绑定商家信息：</td>
                        <td><a href="/employees/set_addr?usercode=1">总会员数：<?php echo $vcount+$nvcount; ?></a><br/><a href="/employees/set_addr?usercode=2">总付费会员：<?php echo $vcount; ?></a></td>
                        <td style="width:150px">上月绑定商信息：</td>
                        <td><a href="/employees/set_addr?usercode=1&stime=<?php echo date('Y-m-d',$fir); ?>&etime=<?php echo date('Y-m-d',$las); ?>">会员数：<?php echo $vcount1+$nvcount1; ?></a><br/><a href="/employees/set_addr?usercode=2&stime=<?php echo date('Y-m-d',$fir); ?>&etime=<?php echo date('Y-m-d',$las); ?>">付费会员：<?php echo $vcount1; ?></a></td>
                        <td style="width:150px">当月绑定商信息：</td>
                        <td><a href="/employees/set_addr?usercode=1&stime=<?php echo date('Y-m-d',$dan); ?>">会员数：<?php echo $vcount2+$nvcount2; ?></a><br/><a href="/employees/set_addr?usercode=2&stime=<?php echo date('Y-m-d',$dan); ?>">付费会员：<?php echo $vcount2; ?></a></td>
                    </tr>
                     <tr>
                        <td style="width:150px">本人A类店铺数：</td>
                        <td><a href="/employees/set_addr?intention=1" target="_blank"><?php echo $my_a; ?></a></td>
                        <td style="width:150px">本人B类店铺数：</td>
                        <td><a href="/employees/set_addr?intention=2" target="_blank"><?php echo $my_b; ?></a></td>
                        <td style="width:150px">本人C类店铺数：</td>
                        <td><a href="/employees/set_addr?intention=3" target="_blank"><?php echo $my_c; ?></a></td>
                    </tr>
                </table>
            </div>
            <div class="clear">&nbsp;</div>
            <div style="padding:20px 10px;" >
                   <p style="padding: 5px;font-size: 16px;" >3天内计划回访列表</p>
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
                                        <p style="color: red; font-size: 16px; font-weight: bold;">回访：<?php echo date('m-d',$v['vistitime']);?></p>
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