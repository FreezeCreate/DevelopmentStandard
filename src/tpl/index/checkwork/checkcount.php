
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <select class="input radius" id="mont">
            </select>
            <input class="input radius" type="text" placeholder="姓名/部门" />
            <span class="btn btn-sm btn-primary mg-r-6">查询</span>

            <span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
            <span class="btn btn-sm btn-info mg-r-6">全部重新分析</span>
            <span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>姓名</td>
                        <td>部门</td>
                        <td>职位</td>
                        <td>人员状态</td>
                        <td>迟到（次）</td>
                        <td>早退（次）</td>
                        <td>异常（次）</td>
                        <td>请假（天）</td>
                        <td>应上班（天）</td>
                        <td>实上班（天）</td>
                        <td>加班（天）</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover ">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['dname'] ?></td>
                            <td><?php echo $v['pname'] ?></td>
                            <td><?php echo $GLOBALS['USER_DIR'][$v['dir']] ?></td>
                            <td><?php echo $v['kqtj']['cd'] ?></td>
                            <td><?php echo $v['kqtj']['zt'] ?></td>
                            <td><?php echo $v['kqtj']['yc'] ?></td>
                            <td><?php echo $v['kqtj']['qj'] ?></td>
                            <td><?php echo $v['kqtj']['ysb'] ?></td>
                            <td><?php echo $v['kqtj']['ssb'] ?></td>
                            <td><?php echo $v['kqtj']['jb'] ?></td>
                            <td>
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewHtml" data-clas="a_001" data-url="<?php echo spUrl('checkwork', 'cardjl') ?>" data-name="打卡记录"><a >打卡记录</a></li>
                                        <li class="menu-item"><a >重新分析</a></li>
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
    $(function() {
        var str = '';
        var dt = new Date();

        for (var i = 0; i < 10; i++) {
            var y = dt.getFullYear();
            var m = dt.getMonth();
            str += '<option value="' + y + '-' + ((m + 1) < 10 ? '0' + (m + 1) : (m + 1)) + '">' + y + '' + ((m + 1) < 10 ? '0' + (m + 1) : (m + 1)) + '</option>'
            dt = new Date(y, --m);
        }
        $('#mont').append(str)
    })
</script>
</html>
