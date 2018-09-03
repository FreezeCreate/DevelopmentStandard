
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <select class="input radius" name="did">
                    <option value="0">全部</option>
                    <?php foreach ($department as $v) { ?>
                        <option <?php echo $page_con['did']==$v['id']?'selected=""':'';?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                    <?php } ?>
                </select>
                <input class="input radius" type="text" name="name" placeholder="姓名" value="<?php echo $page_con['name'] ?>" />
                <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
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
                        <td>人员状态</td>
                        <td>手机号</td>
                        <td>入职日期</td>
                        <td>转正日期</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['dname'] ?></td>
                            <td><?php echo $v['pname'] ?></td>
                            <td><?php echo $GLOBALS['USER_DIR'][$v['dir']] ?></td>
                            <td><?php echo $v['phone'] ?></td>
                            <td><?php echo $v['entrydt'] ?></td>
                            <td><?php echo $v['positivedt'] ?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'User', array('id' => $v['id'])) ?>"data-title="员工详情"><a >详情</a></li>
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'Personel', array('id' => $v['id'])) ?>"data-title="编辑员工"><a >编辑</a></li>
                                        <li class="menu-item read delled"><a onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
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
                $.get("<?php echo spUrl($c, "del"); ?>", {id: id}, function(data) {
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