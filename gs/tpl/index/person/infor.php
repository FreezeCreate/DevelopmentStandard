<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">与我相关</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 2 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">我发布</a>
                        </li>
                        <li class="TablesHeadItem <?php echo $page_con['type'] == 3 ? 'active' : '' ?>">
                            <a href="<?php echo spUrl($c, $a, array('type' => 3)) ?>">我未读</a>
                        </li>
                    </ul>
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right" onclick="fill_apply(1)"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th style="width:40px;">序号</th>
                                <th>标题</th>
                                <th>类型</th>
                                <th>发送给</th>
                                <th>来源</th>
                                <th>日期</th>
                                <th>操作人</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?> <?php echo $v['isread']==1?'isread':''?>">
                                    <td><?php echo $k + 1 ?></td>
                                    <td><?php echo $v['title'].'<a href="javascript:void(0)" onclick="check_apply(1,'.$v['id'].')">[查看]</a>' ?></td>
                                    <td><?php echo $v['type'] ?></td>
                                    <td><?php echo $v['recename'] ?></td>
                                    <td><?php echo $v['zuozhe'] ?></td>
                                    <td><?php echo $v['date'] ?></td>
                                    <td><?php echo $v['optname'] ?></td>
                                    <td class="colorGre">
                                        <div class="list-menu" style="display: inline-block;">
                                        操作  ＋
                                        <ul class="menu">
                                            <li class="menu-item"><a onclick="check_apply(1,<?php echo $v['id'] ?>)">详情</a></li>
                                            <?php if ($admin['id'] == $v['optid']) { ?>
                                                <li class="menu-item"><a onclick="fill_apply(1, <?php echo $v['id'] ?>)">编辑</a></li>
                                                <!--<li class="menu-item"><a class="color-red" onclick="delBox(<?php echo $v['id'] ?>)">删除</a></li>-->
                                            <?php } ?>
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


