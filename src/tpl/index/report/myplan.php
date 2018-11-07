
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <input class="input radius" type="text" name="name" placeholder="搜索" value="<?php echo $page_con['name'] ?>" />
                <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
                <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-primary pdX20 float-right" onclick="fill_apply(8)"  data-title="添加工作日报">+ 添加</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>姓名</td>
                        <td>类型</td>
                        <td>日期</td>
                        <td>内容</td>
                        <td>填写时间</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['uname'] ?></td>
                            <td><?php echo $v['type'] ?></td>
                            <td><?php echo $v['date'] ?></td>
                            <td><?php echo $v['content'] ?></td>
                            <td class="colorBlu"><?php echo $v['adddt'] ?></td>
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