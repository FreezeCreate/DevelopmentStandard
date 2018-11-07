<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp totalItem">
                            <thead>
                                <tr class="colorGre textLeft">
                                    <th colspan="7"><?php echo $result['number'] ?></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="2">工程名称</th>
                                    <th colspan="5" class="textLeft"><?php echo $result['name'] ?></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="2">联系人</th><th class="textLeft pdX10" colspan="2"><input type="text" name="contact" value="<?php echo $result['contact'] ?>"/></th>
                                    <th>报价员</th><th class="textLeft pdX10" colspan="2"><input type="text" name="uname" value="<?php echo $admin['name'] ?>"/></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="2">电话</th><th class="textLeft pdX10" colspan="2"><input type="text" name="tel" value="<?php echo $result['tel'] ?>"/></th>
                                    <th>编号</th><th class="textLeft pdX10" colspan="2"><input type="text" name="unumber" value="<?php echo $admin['number'] ?>"/></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="2">传真</th><th class="textLeft pdX10" colspan="2"><input type="text" name="fax" value="<?php echo $result['fax'] ?>"/></th>
                                    <th>日期</th><th class="textLeft pdX10" colspan="2"><input type="text" name="date" value="<?php echo date('Y-m-d') ?>"/></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="8"><input type="text" name="pname" value="<?php echo $result['pname'] ?>"/></th>
                                </tr>
                                <tr>
                                    <th width="50">序号</th><th>名称</th><th>型号规格</th><th>单位</th><th>数量</th><th>单价</th><th>小计</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter add">
                                <?php foreach ($result['children'] as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td class="ChousCs" data-id=""><?php echo $v['name'] ?></td>
                                        <td class="Chousxh"><?php echo $v['format'] ?></td>
                                        <td class="Chousdw"><?php echo $v['unit'] ?></td>
                                        <td class="Choussl total num"><?php echo $v['num'] ?></td>
                                        <td class="Chousdj total price"><?php echo $v['price'] ?></td>
                                        <td class="Chousxj total val"><?php echo $v['money'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="textCenter totalMneu">
                                    <td>合计</td>
                                    <td class="hjdx" colspan="2"></td>
                                    <td></td>
                                    <td class="total"></td>
                                    <td></td>
                                    <td class="total all"><?php echo $result['money'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">备注：</td>
                                    <td colspan="6"><?php echo $result['explain'] ?></td>
                                </tr>
                                <tr>
                                    <th width="50">序号</th>
                                    <th>元件名称</th>
                                    <th>型号规格</th>
                                    <th>单位</th>
                                    <th>数量</th>
                                    <th>单价</th>
                                    <th>小计</th>
                                </tr>
                                <?php foreach ($result['children'] as $k => $v) { ?>
                                    <tr>
                                        <th width="50"><?php echo $k + 1; ?></th>
                                        <th><?php echo $v['name']; ?></th>
                                        <th><?php echo $v['format']; ?></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($v['children'] as $k1 => $v1) { ?>
                                        <tr class="textCenter">
                                            <td width="50"><?php echo $k1 + 1; ?></td>
                                            <td class="textLeft"><?php echo $v1['name']; ?></td>
                                            <td class="textLeft"><?php echo $v1['format']; ?></td>
                                            <td><?php echo $v1['unit']; ?></td>
                                            <td><?php echo $v1['num']; ?></td>
                                            <td><?php echo $v1['price']; ?></td>
                                            <td><?php echo $v1['money']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr class="textCenter">
                                        <td width="50"><?php echo $k1 + 2; ?></td>
                                        <td class="textLeft">合计</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $v['total']; ?></td>
                                    </tr>
                                    <tr class="textCenter">
                                        <td width="50"><?php echo $k1 + 3; ?></td>
                                        <td class="textLeft">成套价</td>
                                        <td></td>
                                        <td><?php echo $v['unit']; ?></td>
                                        <td><?php echo $v['num']; ?></td>
                                        <td><?php echo $v['price']; ?></td>
                                        <td><?php echo $v['money']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tfoot>
                        </table>
                        
                    </div>
                    <div class="FrameListTable">
                            <p class="FrameListTableTit">处理记录</p>
                            <table class="FrameListTableItem">
                                <thead>
                                    <tr>
                                        <td class="tit01">序号</td>
                                        <td class="tit01">操作人</td>
                                        <td class="tit01">操作状态</td>
                                        <td class="tit01">说明</td>
                                        <td class="tit01">时间</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $result['uname'] ?></td>
                                        <td>提交</td>
                                        <td><?php foreach ($result['files'] as $v1) { ?>
                                                <div class="download"><a class="download-a" href="javascript:void(0)" style="color: #007aff;" itemid="<?php echo $v1['id'] ?>" title="点击下载"><?php echo $v1['filename'] ?></a>
                                                <?php } ?>
                                        </td>
                                        <td><?php echo $result['applydt'] ?></td>
                                    </tr>
                                    <?php foreach ($log as $k => $v) { ?>
                                        <tr>
                                            <td><?php echo $k + 2; ?></td>
                                            <td><?php echo $v['checkname']; ?></td>
                                            <td><?php echo $v['statusname']; ?></td>
                                            <td>
                                                <?php echo $v['explain']; ?>
                                                <?php foreach ($v['files'] as $v1) { ?>
                                                    <div class="download"><a class="download-a" href="javascript:void(0)" style="color: #007aff;" itemid="<?php echo $v1['id'] ?>" title="点击下载"><?php echo $v1['filename'] ?></a>
                                                    <?php } ?>
                                            </td>
                                            <td><?php echo $v['optdt']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                            <div class="FrameListTable">
                                <p class="FrameListTableTit">审核处理</p>
                                <form id="check_form">
                                    <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                                    <table  class="FrameTableCont">
                                        <thead>
                                            <tr>
                                                <td class="FrameGroupName">状态：</td>
                                                <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="FrameGroupName">处理流程：</td>
                                                <td><?php echo $course['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="FrameGroupName"><span style="color:red;">*</span> 处理人：</td>
                                                <td><?php echo $admin['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="FrameGroupName"><span style="color:red;">*</span> 处理动作：</td>
                                                <td>
                                                    <?php foreach ($course['courseact'] as $v) { ?>
                                                        <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="FrameGroupName">说明：</td>
                                                <td><textarea class="FrameGroupInput" name="checksm"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="FrameGroupName">相关文件 ：</td>
                                                <td>
                                                    <ul class="FileBox">

                                                    </ul>
                                                    <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                                    <span class="addFile">+添加文件</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><a class="Btn Btn-blue" onclick="do_subcheck()">提交处理</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        <?php } ?>
                </form>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
        </div>
    </div>

</body>
<script type="text/javascript">
    $('.hjdx').text(changeMoneyToChinese(<?php echo $result['money'] ?>));
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.addFile').click(function() {
            $(this).prev().click()
        });
        $(document).on('change', '.fileToUpload', function() {
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.id + '">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>';
                        $('#' + name).parent().children('.FileBox').append(txt);
                        $('#' + name).val('');
                    } else {
                        $('#' + name).val('');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });
    });
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('apply', "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                     
                    Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>
</html>


