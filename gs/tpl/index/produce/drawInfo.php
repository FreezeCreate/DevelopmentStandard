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
                        <table class="Table TabInp ">
                            <thead class="TabBgBlue">
                                <tr class="">
                                    <th class="textRight" style="border: 0;">领用人</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input  type="text" readonly="true" value="<?php echo empty($result['uname']) ? $admin['name'] : $result['uname'] ?>" /></th>
                                    <th class=" textRight" style="border: 0;">领用部门</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input  type="text" readonly="true" value="<?php echo empty($result['duname']) ? $admin['dname'] : $result['duname'] ?>" /></th>
                                    <th class=" textRight" style="border: 0;">领用时间</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input readonly="true" name="dt" readonly="true" type="text" value="<?php echo $result['dt'] ? $result['dt'] : date('Y年m月d日') ?>" /></th>
                                </tr>
                                <tr class="">
                                    <th class="textCenter">编号</th>
                                    <th class="pdX10" colspan="5"><input class="textLeft" readonly="true" name="number" type="text" value="<?php echo $result['number'] ?>" /></th>
                                </tr>
                            </thead>
                            <tbody class="add textCenter">
                                <?php for ($i = 0; $i <= (count($result['children']) / 5); $i++) { ?>
                                    <tr>
                                        <td class="textCenter TabBgBlue">品名</td>
                                        <td><input type="text" name="name[]" readonly="true" value="<?php echo $result['children'][$i * 5]['name'] ?>" /></td>
                                        <td><input type="text" name="name[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 1]['name'] ?>" /></td>
                                        <td><input type="text" name="name[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 2]['name'] ?>" /></td>
                                        <td><input type="text" name="name[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 3]['name'] ?>" /></td>
                                        <td><input type="text" name="name[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 4]['name'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="textCenter TabBgBlue">数量</td>
                                        <td><input type="text" name="num[]" readonly="true" value="<?php echo $result['children'][$i * 5]['num'] ?>" /></td>
                                        <td><input type="text" name="num[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 1]['num'] ?>" /></td>
                                        <td><input type="text" name="num[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 2]['num'] ?>" /></td>
                                        <td><input type="text" name="num[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 3]['num'] ?>" /></td>
                                        <td><input type="text" name="num[]" readonly="true" value="<?php echo $result['children'][$i * 5 + 4]['num'] ?>" /></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="textCenter TabBgBlue">品名</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">数量</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="textCenter TabBgBlue">领用事由</td>
                                    <td colspan="5" class="pdX10">
                                        <textarea name="explain" readonly="true"><?php echo $result['explain'] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">领取时间</td><td class="pdX10">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <?php echo date('Y年m月d日', strtotime($v['optdt'])) ?>
                                            <?php } ?>
                                            <?php
                                            if ($v['status'] == 1) {
                                                break;
                                            }
                                            ?>
<?php } ?>
                                    </td>
                                    <td class="textCenter TabBgBlue">领用人/经办人签字</td>
                                    <td class="pdX10">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php } ?>
                                            <?php
                                            if ($v['status'] == 1) {
                                                break;
                                            }
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <td class="textCenter TabBgBlue">领用人/经办人联系电话</td>
                                    <td class="pdX10">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php } ?>
    <?php
    if ($v['status'] == 1) {
        break;
    }
    ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">主管审批</td>
                                    <td class="pdX10">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 3) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
    <?php } ?>
                                            <?php
                                            if ($v['status'] == 1) {
                                                break;
                                            }
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <td class="textCenter TabBgBlue">总经理审批</td>
                                    <td class="pdX10">
<?php foreach (array_reverse($log) as $k => $v) { ?>
    <?php if ($v['status'] == 4) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php } ?>
                                            <?php
                                            if ($v['status'] == 1) {
                                                break;
                                            }
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <td class="textCenter TabBgBlue">财务审批</td>
                                    <td class="pdX10">
<?php foreach (array_reverse($log) as $k => $v) { ?>
    <?php if ($v['status'] == 5) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
    <?php } ?>
    <?php
    if ($v['status'] == 1) {
        break;
    }
    ?>
<?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">注意事项</td>
                                    <td colspan="5" class="pdX10">
                                        <p>1、填写此表的要求：领用人必须认真填写此表，物资品名必须写全称、数量必须写大写、事由必须写清楚，特别是领用礼品需详细说明原因、送与何单位、何人及联系电话等事项，否则拒绝审批。</p>
                                        <p>2、本表只适用于公司各部门内部所需物资的领用申请，否则视为无效。</p>

                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
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
                            <?php foreach ($log as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $k + 1; ?></td>
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
                </form>
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
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人签字：</td>
                                        <td>
                                            <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                                <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                                <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                            </div>
                                            <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><?php echo $bill['status'] == 5 ? '手机号' : '说明' ?>：</td>
                                        <td><input type="text" style="display: block;padding: 5px;" name="checksm"></td>
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
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
        </div>
    </div>

</body>
<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };

    });
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm',
            dataType: 'json',
            data: {name: 'fileToUploadQm', id: 'fileToUploadQm'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.UpgrapImg img').attr('src', data.src);
                    $('.UpgrapImg input').val(data.src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }
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
                    Alert(data.msg);
                    parent.window.closHtml();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>
</html>


