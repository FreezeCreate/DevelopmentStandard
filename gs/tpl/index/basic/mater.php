<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <button class="Btn Btn-blue" name="daochu" value="1"><i class="icon-serch"></i> 导出</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <a class="Btn Btn-blue InPop" data-BoxId="daoru"><i class="icon-serch"></i> 导入</a>
                    <span class="Btn Btn-blue float-right InPop add" data-BoxId="mater"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th width="50">编号</th>
                                <th>名称</th>
                                <th>型号规格</th>
                                <th>制造商</th>
                                <th>单位</th>
                                <th>单价</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><?php echo $v['number']; ?></td>
                                    <td><?php echo $v['name'] ?></td>
                                    <td><?php echo $v['format'] ?></td>
                                    <td><?php echo $v['supplier'] ?></td>
                                    <td><?php echo $v['unit'] ?></td>
                                    <td><?php echo $v['price'] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item InPop" data-BoxId="mater" onclick="edit(<?php echo $v['id'] ?>)"><a >编辑</a></li>
                                                <li class="menu-item read" onclick="del(<?php echo $v['id'] ?>)"><a >删除</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="noMsg">
                    <div class="noMsgCont">
                        <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                        <span>抱歉！暂时没有数据</span>
                    </div>
                </div>
            <?php } ?>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>

        </div>
    </div>
    <div class="Tan" id="mater">
        <div class="TanBox">
            <div class="TanBoxTit">元器件 <span class="close OtPop" data-BoxId="mater"></span></div>
            <div class="TanBoxCont">
                <form action="" method="" id="mater_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">编号</td>
                                <td><input class="FrameGroupInput" type="text" name="number" value=""/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">型号规格</td>
                                <td><input class="FrameGroupInput" type="text" name="format" value=""/></td>
                                <td class="FrameGroupName">单位</td>
                                <td><input class="FrameGroupInput" type="text" name="unit" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">单价</td>
                                <td><input class="FrameGroupInput" type="text" name="price" value=""/></td>
                                <td class="FrameGroupName"></td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big Btn-green" onclick="do_mater()">确定</span>
                            <span class="Btn Big Btn-blue OtPop"data-BoxId="mater">取消</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="Tan" id="daoru">
        <div class="TanBox">
            <div class="TanBoxTit">元器件 <span class="close OtPop" data-BoxId="daoru"></span></div>
            <div class="TanBoxCont">
                <form action="" method="" id="daoru_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td>文件</td>
                                <td><input type="file" id="fileToUpload" name="fileToUpload"/></td>
                                <td><a style="color:#007aff;" href="/uploads/template/mater.xlsx">查看模板文件</a></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big Btn-green" onclick="do_daoru()">确定</span>
                            <span class="Btn Big Btn-blue OtPop"data-BoxId="daoru">取消</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>

    $('.add').click(function() {
        $('#mater input').val('');
    });

    function edit(id) {
        $.get('<?php echo spUrl('basic', 'findMater') ?>', {id: id}, function(re) {
            $.each(re.data, function(i, v) {
                $('#mater input[name="' + i + '"]').val(v);
            });
        }, 'json');
    }

    function del(id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl('basic', 'delMater') ?>', {id: id}, function(re) {
                    $('.Results' + id).remove();
                }, 'json');
            }
        })

    }
    function do_mater() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('basic', "saveMater"); ?>",
            data: $('#mater_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        $('#mater .close').click();
                        window.location.reload();
                    });
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
    function do_daoru() {
        loading();
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadExcel"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            error: function(data, status, e) {
                loading('none');
                Alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "<?php echo spUrl($c, "importExcel"); ?>",
                        data: {filename: data.src},
                        dataType: "json",
                        async: false,
                        error: function(request) {
                            loading('none');
                            Alert("数据提交失败！");
                        },
                        success: function(data) {
                            loading('none');
                            if (data.status == 1) {
                                Alert(data.msg);
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    loading('none');
                    Alert(data.msg);
                }
            },
        });
        return false;
    }
</script>
