<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['type']) ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a) ?>">待办/处理</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">经我处理</a>
                        </li>
                    </ul>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th style="width:40px;">序号</th>
                                <th>模块</th>
                                <th>申请人</th>
                                <th>申请日期</th>
                                <th>操作时间</th>
                                <th>摘要</th>
                                <th>状态</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Result<?php echo $v['id'] ?> <?php echo $v['status'] == 0 ? 'isread' : '' ?>">
                                        <td><?php echo $k+1;?></td>
                                        <td><?php echo $v['modelname'];?></td>
                                        <td><?php echo $v['uname'];?></td>
                                        <td><?php echo $v['applydt'];?></td>
                                        <td><?php echo $v['optdt'];?></td>
                                        <td><?php echo $v['summary'];?></td>
                                        <td><span class="color-green"><?php echo $v['statustext'];?></span></td>
                                        <td>
                                            <a class="Btn Btn-info" onclick="check_apply(<?php echo $v['modelid'].','.$v['tid']?>)">详情</a>
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
                $.get('<?php echo spUrl($c, 'delDraw') ?>', {id: id}, function(re) {
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


