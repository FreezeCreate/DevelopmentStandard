<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['type']) ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a) ?>">全部</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">未读</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 2 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">已读</a>
                        </li>
                    </ul>
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
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
                                <th>信息内容</th>
                                <th>时间</th>
                                <th>状态</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Result<?php echo $v['id'] ?> <?php echo $v['isread'] == 1 ? 'isread' : '' ?>">
                                    <td><?php echo $k + 1 ?></td>
                                    <td><?php echo $v['modelname'] ?></td>
                                    <td style="text-align:left;"><?php echo $v['title'] . '<a href="javascript:void(0)" onclick="check_apply(' . $v['modelid'] . ',' . $v['tid'] . ')">[查看]</a>' ?></td>
                                    <td><?php echo $v['adddt'] ?></td>
                                    <td class="opt">
                                        <?php echo $v['isread'] == 1 ? '已读' : '未读' ?>
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


