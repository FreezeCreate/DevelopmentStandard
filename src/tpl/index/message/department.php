

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <input class="input radius" type="text" name="name" placeholder="部门名称" value="<?php echo $page_con['name'] ?>" />
                <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
                <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'addbm') ?>"data-title="添加部门">+ 添加</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <tbody class="hover colorGra">
                <thead class="bg">
                    <tr>
                        <td>序号</td>
                        <td width="300">名称</td>
                        <td>负责人</td>
                        <td>电话</td>
                        <td>备注</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tr>
                    <?php foreach ($results as $k => $v) { ?>
                    <tr>
                        <td><?php echo $k + 1 ?></td>
                        <td><?php echo $v['name'] ?></td>
                        <td><?php echo $v['principalname'] ?></td>
                        <td><?php echo $v['phone'] ?></td>
                        <td><?php echo $v['remark'] ?></td>
                        <td class="colorBlu">
                            <div class="list-menu" style="display: inline-block;">
                                操作  ＋
                                <ul class="menu">
                                    <li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'addbm') ?>"data-title="添加部门"><a >编辑</a></li>
                                    <li class="menu-item read deled"><a >删除</a></li>
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
</html>
<script type="text/javascript">
    $(document).on('click', '.deled', function() {
        var that = $(this);
        parent.window.Confirm('确定删除？', function(e) {
            if (e) {
                that.parent().parent().parent().parent().remove()
            }
        })
    })
</script>