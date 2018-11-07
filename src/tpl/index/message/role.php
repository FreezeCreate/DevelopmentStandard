

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <input class="input radius" type="text" name="name" placeholder="角色名" value="<?php echo $page_con['name'] ?>" />
                <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
                <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl($c, 'addRole') ?>"data-title="添加角色">+ 添加角色</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>角色名</td>
                        <td>拥有权限</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($role as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['auth'] ?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl($c, 'editRole', array('id' => $v['id'])) ?>"data-title="编辑角色"><a >编辑</a></li>
                                        <li class="menu-item read" onclick="del_form(<?php echo $v['id'] ?>)"><a >删除</a></li>
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

<script>
    function del_form(id) {
        Confirm('确定删除该角色信息吗？', function(e) {
            if (e) {
                $.post("<?php echo spUrl($c, "delRole"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Menu' + id).remove();
                        $('.Branch' + id).remove();
                        Alert(data.msg, function() {
                            window.location.reload();
                        });
                    } else {
                        Alert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    ;
</script>
