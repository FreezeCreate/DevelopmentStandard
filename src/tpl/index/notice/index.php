

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form method="get" action="<?php echo spUrl($c, $a) ?>">
                <ul class="grpBtn">
                    <li class="grpBtnItem <?php echo empty($page_con['is_read']) ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a) ?>">全部</a></li>
                    <li class="grpBtnItem <?php echo $page_con['is_read'] == 1 ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a, array('is_read' => 1)) ?>">已读</a></li>
                    <li class="grpBtnItem <?php echo $page_con['is_read'] == 2 ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a, array('is_read' => 2)) ?>">未读</a></li>
                </ul>
                <input class="input radius" type="text" name="name" placeholder="输入关键字" value="<?php echo $page_con['name'] ?>"/>
                <button class="btn btn-sm btn-primary mg-r-6">查询</button>
                <span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-success pdX20 float-right" onclick="fill_apply(1)">+ 新增</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>标题</td>
                        <td>发送给</td>
                        <td>日期</td>
                        <td>操作人</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Results<?php echo $v['id'] ?> <?php echo $v['isread'] == 1 ? 'isread' : '' ?>">
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['title'] . '<a href="javascript:void(0)" onclick="check_apply(1,' . $v['id'] . ')">[查看]</a>' ?></td>
                            <td><?php echo $v['recename'] ?></td>
                            <td><?php echo $v['date'] ?></td>
                            <td><?php echo $v['optname'] ?></td>
                            <td class="colorGre">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item"><a onclick="check_apply(1,<?php echo $v['id'] ?>)">详情</a></li>
                                        <?php if ($user['id'] == $v['optid']) { ?>
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
        <?php require_once TPL_DIR . '/layout/page.php'; ?>
    </div>
</body>
<script type="text/javascript">
//		$('.renyuan').click(function(){
//			parent.window.
//		})
</script>
</html>
