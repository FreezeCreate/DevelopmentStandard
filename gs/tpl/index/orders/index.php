<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name']?>" placeholder="关键字"/>
                <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c,'addOrders')?>" data-title="新增订单"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if($results){?>
            <div class="top20">
                <table class="Table">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>订单名称</th>
                            <th>客户</th>
                            <th>相关文件</th>
                            <th>备注</th>
                            <th>订单状态</th>
                            <th width="100">操作</th>
                        </tr>
                    </thead>
                    <tbody class="textCenter TabBg">
                        <?php foreach($results as $k=>$v){?>
                        <tr class="Results<?php echo $v['id']?>">
                            <td><?php echo $v['number'];?></td>
                            <td><?php echo $v['name']?></td>
                            <td><?php echo $v['cname']?></td>
                            <td>
                                <?php foreach($v['files'] as $v1){?>
                                <a class="download" itemid="<?php echo $v1['id']?>"><?php echo $v1['filename']?></a><br/>
                                <?php }?>
                            </td>
                            <td><?php echo $v['explain']?></td>
                            <td><?php echo $v['status']?></td>
                            <td>
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop" data-url="<?php echo spUrl($c,'ordersInfo',array('id'=>$v['id']))?>" data-title="订单详情"><a >详情</a></li>
                                        <!--<li class="menu-item NewPop" data-url="<?php echo spUrl($c,'editproject',array('id'=>$v['id']))?>" data-title="编辑<?php echo $v['name']?>"><a >编辑</a></li>-->
                                        <li class="menu-item read"><a onclick="del(<?php echo $v['id']?>)">删除</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <?php }else{?>
            <div class="noMsg">
                <div class="noMsgCont">
                    <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                    <span>抱歉！暂时没有数据</span>
                </div>
            </div>
            <?php }?>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
            
        </div>
    </div>
</body>
</html>
<script>
    function del(id){
        Confirm('确定删除？',function(e){
            if(e){
                $.get('<?php echo spUrl($c,'delOrders')?>',{id:id},function(re){
                    if(re.status==1){
                        $('.Results'+id).remove();
                    }else{
                        Alert(re.msg);
                    }
                },'json');
            }
        });
    }
</script>


