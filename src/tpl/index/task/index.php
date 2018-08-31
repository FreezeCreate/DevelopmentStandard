

<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <ul class="grpBtn">
                    <li class="grpBtnItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>">
                        <a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">我发布的任务</a>
                    </li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 2 ? 'active' : '' ?>">
                        <a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">我执行的任务</a>
                    </li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 3 ? 'active' : '' ?>">
                        <a href="<?php echo spUrl($c, $a, array('type' => 3)) ?>">未完成的任务</a>
                    </li>
                </ul>
                <input class="input radius" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="输入关键字"/>
                <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
                <span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
                <span class="btn btn-sm btn-success pdX20 float-right" onclick="fill_apply(9)">+ 新增</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr>
                        <td>序号</td>
                        <td>发布人</td>
                        <td>执行人</td>
                        <td>标题</td>
                        <td>发布时间</td>
                        <td>开始时间</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['uname'] ?></td>
                            <td><?php echo $v['distname'] ?></td>
                            <td><?php echo $v['title'] ?></td>
                            <td><?php echo $v['applydt'] ?></td>
                            <td><?php echo $v['start'] ?></td>
                            <td class="data-status color-<?php echo $status[$v['status']]['color'] ?>"><?php echo $status[$v['status']]['text'] ?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop" data-title="任务详情" data-url="<?php echo spUrl('apply', 'Work', array('id' => $v['id'])) ?>"><a >详情</a></li>
                                        <li class="menu-item" data-title="编辑任务"><a onclick="fill_apply(9, <?php echo $v['id']?>)">编辑</a></li>
                                        <li class="menu-item read del"><a onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
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
                $.get("<?php echo spUrl("applyFill", "delTask"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id).remove();
                        table_sort();
                    }
                }, 'json');
                Alert('操作成功');
            }

        });
    }
//    $(document).on('click', '.del', function() {
//        var that = $(this);
////        var get_id =
//        parent.window.Confirm('确定删除？', function(e) {
//            if (e) {
//
//                that.parent().parent().parent().parent().remove()
//            }
//        })
//    })
</script>
