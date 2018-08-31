
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <ul class="grpBtn">
                    <li class="grpBtnItem <?php echo empty($page_con['type']) ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a) ?>">全部</a></li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">已完成</a></li>
                    <li class="grpBtnItem <?php echo $page_con['type'] == 2 ? 'active' : '' ?>"><a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">未通过</a></li>
                </ul>
                <select class="input radius" name="sid">
                    <option value="0">-选择模块-</option>
                    <?php foreach ($set as $k => $v) { ?>
                        <optgroup label="<?php echo $GLOBALS['PRO_TYPE'][$k] ?>">
                            <?php foreach ($v as $v1) { ?>
                                <option <?php echo $page_con['sid'] == $v1['id'] ? 'selected=""' : '' ?> value="<?php echo $v1['id'] ?>"><?php echo $v1['name'] ?></option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
                <input class="input radius dates" readonly="readonly" name="applydt" type="text"  placeholder="申请时间" value="<?php echo $page_con['applydt'] ?>"/>
                <span class="btn btn-sm btn-primary mg-r-6">搜索</span>
                <span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
                <span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
            </form>
        </div>
        <div class="top20">
            <table class="table borderTr textCenter">
                <thead>
                    <tr class="b">
                        <td>序号</td>
                        <td>模块</td>
                        <td>申请人</td>
                        <td>部门</td>
                        <td>申请日期</td>
                        <td>操作时间</td>
                        <td>摘要</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody class="hover colorGra">
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Result<?php echo $v['id'] ?> <?php echo $v['status'] == 0 ? 'isread' : '' ?>">
                            <td><?php echo $k + 1; ?></td>
                            <td><?php echo $v['modelname']; ?></td>
                            <td><?php echo $v['uname']; ?></td>
                            <td><?php echo $v['dname']; ?></td>
                            <td><?php echo $v['applydt']; ?></td>
                            <td><?php echo $v['opttime']; ?></td>
                            <td><?php echo $v['summary']; ?></td>
                            <td><span class="color-green"><?php echo $v['statustext']; ?></span></td>
                            <td class="colorBlu">
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item"><a onclick="check_apply(<?php echo $v['modelid'] . ',' . $v['tid'] ?>)">详情</a></li>
                                        <li class="menu-item"><a onclick="fill_apply(<?php echo $v['modelid'] . ',' . $v['tid'] ?>)">编辑</a></li>
                                        <?php /*if ($v['status'] != 0) { */?><!--<li class="menu-item void"><a class="color-gray" onclick="voidBox(<?php /*echo $v['id'] */?>)">作废</a></li>--><?php /*} */?>
                                        <li class="menu-item"><a class="color-red" onclick="delBox(<?php echo $v['id'] ?>)">删除</a></li>
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
    jeDate({
        dateCell: ".dates",
        format: "YYYY-MM-DD",
        isinitVal: false,
        isTime: true, //isClear:false,
        minDate: "2014-09-19",
        okfun: function(val) {
            alert(val)
        }
    })
    $(document).on('click', '.delled', function() {
        var that = $(this);
        parent.window.Confirm('确定删除？', function(e) {
            if (e) {
                that.parent().parent().parent().parent().remove()
            }
        })
    })
</script>
</html>
