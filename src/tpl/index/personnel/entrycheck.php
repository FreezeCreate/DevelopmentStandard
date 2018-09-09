
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <ul class="grpBtn">
                    <li class="grpBtnItem <?php echo empty($page_con['type']) ? 'active' : ''; ?>"><a href="<?php echo spUrl($c, $a) ?>">全部</a></li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 1 ? 'active' : ''; ?>"><a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">已审核</a></li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 2 ? 'active' : ''; ?>"><a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">未审核</a></li>
                </ul>
                <input class="input radius" type="text" name="name" placeholder="姓名" value="<?php echo $page_con['name'] ?>" />
                <span class="btn btn-sm btn-primary mg-r-6">搜索</span>
                <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>姓名</td>
                        <td>部门</td>
                        <td>职位</td>
                        <td>提交日期</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k + 1; ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['dname'] ?></td>
                            <td><?php echo $v['pname'] ?></td>
                            <td><?php echo $v['applydt'] ?></td>
                            <td><?php echo $v['stname'] ?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'checkcont') ?>"data-title="审核详情"><a >详情</a></li>
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'addcheck') ?>"data-title="编辑审核"><a >编辑</a></li>
                                        <li class="menu-item read delled"><a >删除</a></li>
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
    $(document).on('click', '.delled', function() {
        var that = $(this);
        parent.window.Confirm('确定删除？', function(e) {
            if (e) {
                that.parent().parent().parent().parent().remove()
            }
        })
    })
</script>