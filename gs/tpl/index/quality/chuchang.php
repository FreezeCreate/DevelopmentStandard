<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    
                    <input type="text"class="FrameGroupInput radius" name="number" id="" value="<?php echo $page_con['number'] ?>" placeholder="文件编号"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c, 'editChuchang') ?>" data-title="添加出厂检验"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>文件编号</th>
                                <th>产品名称</th>
                                <th>型号规格</th>
                                <th>检验数量</th>
                                <th>检验日期</th>
                                <th>产品编号</th>
                                <th>检验员</th>
                                <th>状态</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><a class="menu-item NewPop" data-url="<?php echo spUrl('sell', 'ordersInfo', array('id' => $v['oid'])) ?>" data-title="订单详情"><?php echo $v['onumber']; ?></a></td>
                                    <td><?php echo $v['number']; ?></td>
                                    <td><?php echo $v['name'] ?></td>
                                    <td><?php echo $v['format'] ?></td>
                                    <td><?php echo $v['num'] ?></td>
                                    <td><?php echo $v['dt'] ?></td>
                                    <td><?php echo $v['pnumber'] ?></td>
                                    <td><?php echo empty($v['sign'])?'':'<img src="'.$v['sign'].'"' ?></td>
                                    <td><?php echo $status[$v['status']]['text'] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'chuchangInfo', array('id' => $v['id'])) ?>" data-title="出厂检验详情"><a >详情</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'editChuchang', array('id' => $v['id'])) ?>" data-title="编辑出厂检验"><a >编辑</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'editReport', array('oid' => $v['oid'])) ?>" data-title="不合格品报告"><a >+不合格品报告</a></li>
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


