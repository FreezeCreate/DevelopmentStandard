<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right InPop" data-BoxId="add"><i class="icon-add"></i> 新增</span>
                    <span class="Btn Btn-blue float-right" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20" id="print">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>设备名称</th>
                                <th>型号规格</th>
                                <th>设备制造厂</th>
                                <th>数量</th>
                                <th>使用单位存放地址</th>
                                <th>备注</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><?php echo $k+1 ?></td>
                                    <td><?php echo $v['name'] ?></td>
                                    <td><?php echo $v['format'] ?></td>
                                    <td><?php echo $v['chang'] ?></td>
                                    <td><?php echo $v['num'] ?></td>
                                    <td><?php echo $v['address'] ?></td>
                                    <td><?php echo $v['explain'] ?></td>
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
        <div class="Tan" id="add">
            <div class="TanBox">
                <div class="TanBoxTit">检验和试验设备台账 <span class="close OtPop" data-BoxId="add"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="add_form" onsubmit="return false">
                        <div class="FrameTable">
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">设备名称</td>
                                    <td><input class="FrameGroupInput" type="text" name="name" value=""/></td>
                                    <td class="FrameGroupName">型号规格</td>
                                    <td><input class="FrameGroupInput" type="text" name="format" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">设备制造厂</td>
                                    <td><input class="FrameGroupInput" type="text" name="chang" value=""/></td>
                                    <td class="FrameGroupName">数量</td>
                                    <td><input class="FrameGroupInput" type="text" name="num" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">使用单位存放地址</td>
                                    <td><input class="FrameGroupInput" type="text" name="address" value=""/></td>
                                    <td class="FrameGroupName"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">备注</td>
                                    <td colspan="3"><input class="FrameGroupInput" type="text" name="explain" value=""/></td>
                                </tr>
                            </table>
                            <div class="TanBtn">
                                <input id="eid" type="hidden" name="id" value=""/>
                                <span class="Btn Big Btn-green" onclick="do_save()">确定</span>
                                <span class="Btn Big Btn-blue OtPop"data-BoxId="add">取消</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    function del(id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl($c, 'delFailed') ?>', {id: id}, function(re) {
                    if (re.status == 1) {
                        $('.Results' + id).remove();
                    } else {
                        Alert(re.msg);
                    }
                }, 'json');
            }
        });
    }
    function do_save() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveSbtz"); ?>",
            data: $('#add_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        $('#add .close').click();
                        window.location.reload();
                    });
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>


