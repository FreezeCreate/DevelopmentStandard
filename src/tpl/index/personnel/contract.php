
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c,$a)?>">
            <select class="input radius" name="type">
                <option value="">合同状态</option>
                <?php foreach($GLOBALS['CONTRACT_TYPE'] as $k=>$v){?>
                <option value="<?php echo $v;?>"><?php echo $v;?></option>
                <?php }?>
            </select>
            <input class="input radius" type="text" name="name" placeholder="签署人" value="<?php echo $page_con['name']?>" />
            <button class="btn btn-sm btn-primary mg-r-6">搜索</button>
            <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
            <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
            <span class="btn btn-sm btn-primary pdX20 float-right NewPop"data-url="<?php echo spUrl('applyFill', 'addpersonnel') ?>"data-title="新增合同">+ 新增合同</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>合同名称</td>
                        <td>签署人</td>
                        <td>开始日期</td>
                        <td>签署单位</td>
                        <td>备注</td>
                        <td>合同状态</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach($results as $k=>$v){ ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['name']?></td>
                            <td><?php echo $v['uname']?></td>
                            <td><?php echo $v['startdt']?></td>
                            <td><?php echo $v['company']?></td>
                            <td><?php echo $v['explain']?></td>
                            <td><?php echo $GLOBALS['CONTRACT_STATUS'][$v['status']]?></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('apply', 'personnelcont') ?>"data-title="合同详情"><a >详情</a></li>
                                        <li class="menu-item NewPop"data-url="<?php echo spUrl('applyFill', 'addpersonnel') ?>"data-title="新增合同"><a >编辑</a></li>
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
