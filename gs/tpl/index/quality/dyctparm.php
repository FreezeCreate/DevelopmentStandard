<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <select class="TablesSerchInput" name="status">
                        <option value="0">检验分类</option>
                        <?php foreach ($GLOBALS['DYCT_TYPE'] as $k => $v) { ?>
                            <option <?php echo $page_con['status'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c, 'addDyctparm') ?>" data-title="添加例行检验参数"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>检验类别</th>
                                <th>产品</th>
                                <th>参数</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><?php echo $GLOBALS['DYCT_TYPE'][$v['type']]; ?></td>
                                    <td><?php echo $v['name']; ?></td>
                                    <td><?php echo $v['parameter'] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <!-- <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'dyctlogInfo', array('id' => $v['id'])) ?>" data-title="例行检验记录详情"><a >详情</a></li>-->
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'addDyctparm1', array('id' => $v['id'])) ?>" data-title="例行检验记录详情"><a >详情</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'addDyctparm', array('id' => $v['id'])) ?>" data-title="编辑例行检验参数"><a >编辑</a></li>
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
        Confirm('确定删除？', function (e) {
            if (e) {
                $.get('<?php echo spUrl($c, 'delQuotation') ?>', {id: id}, function (re) {
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


