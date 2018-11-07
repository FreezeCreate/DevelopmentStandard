<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['status'])?'active':'';?>"><a href="<?php echo spUrl($c,$a)?>">全部</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==2?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>2))?>">待编辑</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==1?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>1))?>">待审核</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==3?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>3))?>">审核通过</a></li>
                    </ul>
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right NewPop" data-url="/sell/editContract" data-title="新增合同"><i class="icon-add"></i> 新增</span>
                    <!--<span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c, 'addOrders') ?>" data-title="新增订单"><i class="icon-add"></i> 新增</span>-->
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>客户名称</th>
                                <th>电话</th>
                                <th>合同编号</th>
                                <th>合同名称</th>
                                <th>合同金额</th>
                                <th>报价状态</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><a class="menu-item NewPop" data-url="<?php echo spUrl('sell', 'ordersInfo', array('id' => $v['oid'])) ?>" data-title="订单详情"><?php echo $v['onumber']; ?></a></td>
                                    <td><?php echo $v['cname'] ?></td>
                                    <td><?php echo $v['phone'] ?></td>
                                    <td><?php echo $v['number'] ?></td>
                                    <td><?php echo $v['name'] ?></td>
                                    <td><?php echo $v['money'] ?></td>
                                    <td><?php echo $GLOBALS['QUO_STATUS'][$v['status']] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'contractInfo', array('id' => $v['id'])) ?>" data-title="合同详情"><a >详情</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'editContract', array('id' => $v['id'])) ?>" data-title="编辑合同"><a >编辑</a></li>
                                                
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
                $.get('<?php echo spUrl($c, 'delContract') ?>', {id: id}, function(re) {
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


