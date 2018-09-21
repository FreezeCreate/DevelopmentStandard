<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem "><a href="<?php echo spUrl($c, 'zxlog') ?>">自校记录</a></li>
                        <li class="TablesHeadItem active"><a href="<?php echo spUrl($c, 'shebei') ?>">设备管理</a></li>
                    </ul>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right InPop"data-boxid="tjsb"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>文件编号</th>
                                <th>设备名称</th>
                                <th>检验周期</th>
                                <th>检验要求</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><?php echo $v['number']; ?></td>
                                    <td><?php echo $v['name']; ?></td>
                                    <td><?php echo $v['day'] ?></td>
                                    <td><?php echo $v['yaoqiu'] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'zxloginfo', array('sid' => $v['id'])) ?>" data-title="自校记录详情"><a >查看自校记录</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'addZxlog', array('sid' => $v['id'])) ?>" data-title="新增自校记录"><a >新增自校记录</a></li>
                                                <li class="menu-item"><a class="textRed" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
                                                
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
    <div class="Tan " id="tjsb">
        <div class="TanBox ">
            <div class="TanBoxTit">添加检验设备 <span class="close OtPop" data-BoxId="tjsb"></span></div>
            <div class="TanBoxCont">
                <form id="sub_form" method="post" action="" onsubmit="return false;">
                <div class="FrameTable">
                    <div class="FrameTableTitl">添加检验设备</div>
                    <table class="FrameTableCont">
                        <tr>
                            <td class="FrameGroupName">编号：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="number" value="" /></td>
                            <td class="FrameGroupName"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName"><i class="colorRed">*</i>设备名称：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="name" id="" value="" /></td>
                            <td class="FrameGroupName"><i class="colorRed">*</i>检测周期：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="day" id="" value="" /></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                            <td class="FrameGroupName">检验要求：</td>
                            <td><input class="FrameGroupInput Lang" type="text" name="yaoqiu[]" id="" value="" /></td>
                        </tr>
                    </table>
                    <div class="TanBtn">
                        <span class="Btn Big Btn-green" onclick="do_sub()">确定</span>
                        <span class="Btn Big Btn-blue OtPop"data-BoxId="tjsb">取消</span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    function del(id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl($c, 'delShebei') ?>', {id: id}, function(re) {
                    if (re.status == 1) {
                        $('.Results' + id).remove();
                    } else {
                        Alert(re.msg);
                    }
                }, 'json');
            }
        });
    }
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveShebei"); ?>",
            data: $('#sub_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.location.reload();
                } else {
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
    ;
</script>


