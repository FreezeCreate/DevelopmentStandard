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
                                <th>产品型号规格</th>
                                <th>发放人</th>
                                <th>发放日期</th>
                                <th>发放数量</th>
                                <th>领用人</th>
                                <th>用户</th>
                                <th>剩余数量</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><?php echo $k+1 ?></td>
                                    <td><?php echo $v['format'] ?></td>
                                    <td><?php echo $v['fname'] ?></td>
                                    <td><?php echo $v['fdt'] ?></td>
                                    <td><?php echo $v['fnum'] ?></td>
                                    <td><?php echo $v['lname'] ?></td>
                                    <td><?php echo $v['yonghu'] ?></td>
                                    <td><?php echo $v['snum'] ?></td>
                                    
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
                                    <td class="FrameGroupName">产品型号规格</td>
                                    <td><input class="FrameGroupInput" type="text" name="format" value=""/></td>
                                    <td class="FrameGroupName">发放人</td>
                                    <td><input class="FrameGroupInput" type="text" name="fname" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">发放日期</td>
                                    <td><input class="FrameGroupInput dt" type="text" name="fdt" value=""/></td>
                                    <td class="FrameGroupName">发放数量</td>
                                    <td><input class="FrameGroupInput" type="text" name="fnum" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">领用人</td>
                                    <td><input class="FrameGroupInput" type="text" name="lname" value=""/></td>
                                    <td class="FrameGroupName">用户</td>
                                    <td><input class="FrameGroupInput" type="text" name="yonghu" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">剩余数量</td>
                                    <td><input class="FrameGroupInput" type="text" name="snum" value=""/></td>
                                    <td class="FrameGroupName"></td>
                                    <td></td>
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
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY年MM月DD日",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    function do_save() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveBzffjl"); ?>",
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


