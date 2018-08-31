
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form method="get" action="<?php echo spUrl($c, $a) ?>">
                <input class="input radius dates" type="text" readonly="readonly" placeholder="开始日期"/>
                <span class=" mg-r-6">~</span>
                <input class="input radius dates" type="text" readonly="readonly" placeholder="结束日期"/>
                <input class="input radius dates" type="text" placeholder="姓名/部门" />
                <span class="btn btn-sm btn-primary mg-r-6">查询</span>
                <span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>部门</td>
                        <td>姓名</td>
                        <td>类型</td>
                        <td>请假时间</td>
                        <td>申请时间</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $v['dname'] ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['type'] ?></td>
                            <td><?php echo date('Y/m/d', strtotime($v['start'])) . '-' . date('Y/m/d', strtotime($v['end'])) ?></td>
                            <td><?php echo $v['applydt'] ?></td>
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
