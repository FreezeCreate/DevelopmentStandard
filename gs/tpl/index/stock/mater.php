<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <!--<span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c, 'addOrders') ?>" data-title="新增订单"><i class="icon-add"></i> 新增</span>-->
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>订单名称</th>
                                <th>元器件是否在合格供应商名单中</th>
                                <th>库存是否充足</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <?php $yn = array(0=>'未检查',1=>'存在',2=>'不存在');$zg = array(0=>'未检查',1=>'充足',2=>'不足')?>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><a class="menu-item NewPop" data-url="<?php echo spUrl('sell', 'ordersInfo', array('id' => $v['oid'])) ?>" data-title="订单详情"><?php echo $v['onumber']; ?></a></td>
                                    <td><?php echo $v['oname']; ?></td>
                                    <td><?php echo $yn[$v['is_have']] ?></td>
                                    <td><?php echo $zg[$v['is_stock']] ?></td>
                                    <td> 
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'editMater', array('id' => $v['id'])) ?>" data-title="元器件详情"><a >详情</a></li>
                                                <?php if($v['is_have']==0){?>
                                                <?php }else if($v['is_have']==1){?>
                                                <?php }else{?>
                                                    <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'bginfo', array('id' => $v['id'])) ?>" data-title="元器件变更申请"><a >元器件变更申请</a></li>
                                                <?php }?>
                                                    <?php if($v['is_stock']==0){?>
                                                    <?php }else if($v['is_stock']==1){?>
                                                    <?php }else{?>
                                                    <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'cginfo', array('id' => $v['id'])) ?>" data-title="采购单申请"><a >采购申请详情</a></li>
                                                    <?php }?>
                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="noMsg">
                    <div class="noMsgCont">
                        <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                        <span>抱歉！暂时没有数据</span>
                    </div>
                </div>
            <?php } ?>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>

        </div>
    </div>
</body>
</html>
<script>
    function del(id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl($c, 'delQuotation') ?>', {id: id}, function(re) {
                    if (re.status == 1) {
                        $('.Results' + id).remove();
                    } else {
                        Alert(re.msg);
                    }
                }, 'json');
            }
        });
    }
</script>


