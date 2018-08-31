
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
            <span class="btn btn-sm btn-success pdX20 float-right" onclick="$('#fail').click()">导入</span>
            <input type="file" class="None" name="fail" id="fail" value="" />
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>部门</td>
                        <td>姓名</td>
                        <td>打卡时间</td>
                        <td>IP</td>
                        <td>地址</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach($results as $k=>$v){?>
                    <tr>
                        <td><?php echo $v['dname']?></td>
                        <td><?php echo $v['name']?></td>
                        <td><?php echo $v['dkdt']?></td>
                        <td><?php echo $v['ip']?></td>
                        <td><?php echo $v['address']?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <?php require_once TPL_DIR . '/layout/page.php'; ?>
    </div>
</body>
</html>
