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
                <form id="do_form">
                    <input type="hidden" name="pid" value="<?php echo $presult['id'] ?>"/>
                    <input type="hidden" name="oid" value="<?php echo $oid ?>"/>
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp">
                            <thead>
                                <tr>
                                    <th>文件编号</th>
                                    <th colspan="3"><input class="textLeft" <?php echo empty($result['number'])? '' : 'readonly="true"' ?> name="number" type="text" value="<?php echo $result['number'] ?>"/></th>
                                </tr>
                            </thead>
                            <tbody class="TabBg add">
                                <tr>
                                    <td class="TabBgBlue textCenter">不合格品名称规格</td><td class="pdX10"><input name="name" <?php echo empty($result['name'])? '' : 'readonly="true"' ?> type="text" value="<?php echo $result['name'] ?>"/></td>
                                    <td class="TabBgBlue textCenter">来源</td><td class="pdX10"><input name="laiyuan" <?php echo empty($result['laiyuan'])? '' : 'readonly="true"' ?> type="text" value="<?php echo $result['laiyuan'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter">不合格数量</td><td class="pdX10"><input name="num" <?php echo empty($result['num'])? '' : 'readonly="true"' ?> type="text" value="<?php echo $result['num'] ?>"/></td>
                                    <td class="TabBgBlue textCenter">操作人员/日期</td><td class="pdX10"><input type="text" value="<?php echo $admin['name']?>"/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter">合同号或厂商</td><td class="pdX10"><input name="hetong" <?php echo empty($result['hetong'])? '' : 'readonly="true"' ?> type="text" value="<?php echo $result['hetong'] ?>"/></td>
                                    <td class="TabBgBlue textCenter">发现人员</td><td class="pdX10"><input name="faxian" <?php echo empty($result['faxian'])? '' : 'readonly="true"' ?> type="text" value="<?php echo $result['faxian'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>不合格品描述：</p>
                                        <div class="pdX20"><textarea rows="3" name="miaoshu" <?php echo empty($result['miaoshu'])? '' : 'readonly="true"' ?>><?php echo $result['miaoshu'] ?></textarea></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>处置要求：</p>
                                        <div class="pdX20"><textarea rows="3" name="yaoqiu" <?php echo empty($result['yaoqiu'])? '' : 'readonly="true"' ?>><?php echo $result['yaoqiu'] ?></textarea></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>原因分析：</p>
                                        <div class="pdX20"><textarea rows="3" name="case" <?php echo empty($result['case'])? '' : 'readonly="true"' ?>><?php echo $result['case'] ?></textarea></div>
                                        <div class="UpgrapImg2 textRight" onclick="$('#fileToUploadQm').click();" style="display: inline-block;float: right;">责任人：
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="zeren" value="<?php echo empty($result['zeren']) ? $admin['qianming']:$result['zeren']; ?>"/>
                                        </div>
                                        <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>纠正措施：</p>
                                        <div class="pdX20"><textarea rows="3" name="cuoshi" <?php echo empty($result['cuoshi'])? '' : 'readonly="true"' ?>><?php echo $result['cuoshi'] ?></textarea></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>纠正措施验证：</p>
                                        <div class="pdX20"><textarea rows="3" name="csyy" <?php echo empty($result['csyy'])? '' : 'readonly="true"' ?>><?php echo $result['csyy'] ?></textarea></div>
                                        <div class="UpgrapImg1 textRight" onclick="$('#fileToUploadQm1').click();" style="display: inline-block;float: right;">验证人员/时间：
                                            <img class="" src="<?php echo empty($result['zeren']) ? SOURCE_PATH . '/images/qianming.png' : $result['zeren']; ?>"/>
                                            <input type="hidden" name="yyuser" value="<?php echo empty($result['yyuser']) ? '':$result['yyuser']; ?>"/>
                                        </div>
                                        <input type="file" class="None UpgrapVal" name="fileToUploadQm1" id="fileToUploadQm1" onchange="ajaxFileUpload1()"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </form>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">保存</span>
        </div>
    </div>

</body>
<script type="text/javascript">
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm',
            dataType: 'json',
            data: {name: 'fileToUploadQm', id: 'fileToUploadQm'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.UpgrapImg2 img').attr('src', data.src);
                    $('.UpgrapImg2 input').val(data.src);
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
    function ajaxFileUpload1() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm1',
            dataType: 'json',
            data: {name: 'fileToUploadQm1', id: 'fileToUploadQm1'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.UpgrapImg1 img').attr('src', data.src);
                    $('.UpgrapImg1 input').val(data.src);
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
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveReport'); ?>",
            data: $('#do_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                     
                    Alert(data.msg);
                    parent.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }
            }
        });
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
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>
</html>


