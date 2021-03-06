

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <input class="input radius" type="text" name="name" placeholder="姓名" value="<?php echo $page_con['name'] ?>" />
                <span class="btn btn-sm btn-primary mg-r-6">搜索</span>
                <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'Hrtransfer') ?>"data-title="添加调动">+ 添加</span>
            </form>

        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>姓名</td>
                        <td>调动前部门</td>
                        <td>调动后部门</td>
                        <td>调动前职位</td>
                        <td>调动后职位</td>
                        <td>调动类型</td>
                        <td>调动说明</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k=>$v) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['uname']?></td>
                            <td><?php echo $v['udept']?></td>
                            <td><?php echo $v['eudept']?></td>
                            <td><?php echo $v['position']?></td>
                            <td><?php echo $v['eposition']?></td>
                            <td><?php echo $v['type']?></td>
                            <td><?php echo $v['explain']?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'Hrtransfer', array('id' => $v['id'])) ?>"data-title="人事调动详情"><a >详情</a></li>
                                        <li class="menu-item"onclick="fill_apply(14, <?php echo $v['id']?>)"data-title="编辑人事调动"><a >编辑</a></li>
                                        <li class="menu-item read deled"><a onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
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
    function del(id) {
        Confirm('确定删除？',function(re){
            if(re){
                $.get("<?php echo spUrl("process", "del"); ?>", {mid: 14, id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id).remove();
                        table_sort();
                    }
                }, 'json');
                Alert('操作成功');
            }

        });
    }
</script>