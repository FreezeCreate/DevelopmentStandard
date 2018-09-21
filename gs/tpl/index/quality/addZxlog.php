<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <!--                <div class="textRight">
                                    <span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>
                                    <span class="Btn Btn-blue"><i class="icon-print"></i>打印</span>
                                </div>-->
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <input type="hidden" name="sid" value="<?php echo $shebei['id'] ?>"/>
                    <div class="top20">
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th colspan="12">自制设备自校准记录表</th>
                                </tr>
                                <tr>
                                    <th>编号：</th>
                                    <th colspan="11" class="textLeft"><?php echo $shebei['number']?></th>
                                </tr>
                            </thead>
                            <tbody class="TabBg add">
                                <tr>
                                    <td colspan="12" class="pdX20 textLeft">
                                        <span>设备名称：<?php echo $shebei['name']?></span>
                                        <i class="w-100"></i>
                                        <span>检测周期：<?php echo $shebei['day']?>天</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2">型号规格</td><td rowspan="2">设备编号</td><td colspan="6">检验要求</td>
                                    <td rowspan="2">判定结果</td><td rowspan="2">检测人员</td><td rowspan="2" style="width: 80px;">检测时间</td><td rowspan="2">备注</td>
                                </tr>
                                <tr>
                                    <td><?php echo $shebei['yaoqiu'][0]?></td>
                                    <td><?php echo $shebei['yaoqiu'][1]?></td>
                                    <td><?php echo $shebei['yaoqiu'][2]?></td>
                                    <td><?php echo $shebei['yaoqiu'][3]?></td>
                                    <td><?php echo $shebei['yaoqiu'][4]?></td>
                                    <td><?php echo $shebei['yaoqiu'][5]?></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="format[]"/></td>
                                    <td><input type="text" name="number[]"/></td>
                                    <td><input type="text" name="content[q1][]"/></td>
                                    <td><input type="text" name="content[q2][]"/></td>
                                    <td><input type="text" name="content[q3][]"/></td>
                                    <td><input type="text" name="content[q4][]"/></td>
                                    <td><input type="text" name="content[q5][]"/></td>
                                    <td><input type="text" name="content[q6][]"/></td>
                                    <td><input type="text" name="jieguo[]"/></td>
                                    <td><div class="UpgrapImg">
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="sign[]" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                        </div></td>
                                    <td><input type="text" class="dt" name="dt[]"/></td>
                                    <td><input type="text" name="explain[]"/></td>
                                </tr>
                                <tr>
                                    <td></td><td><span class="TabAdd add-1"></span></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>备注</td>
                                    <td colspan="11"class="textLeft pdX10">符合要求的用“√”表示，不符合要求的用“×”表示，并备注不合格原因；有实测数据时应记录实测数据；</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
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
    var UpgrapImg;
    $(function() {

        $('.TabAdd').click(function() {
            var that = $(this);
            var str = that.parent().parent().prev().clone();
            that.parent().parent().before(str)
        });
        $(document).on('click', '.UpgrapImg', function() {
            UpgrapImg = $(this);
            $('#fileToUploadQm').click();
        });
        
    })
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm',
            dataType: 'json',
            data: {name: 'fileToUploadQm', id: 'fileToUploadQm'},
            success: function(data, status) {
                if (data.status == 1) {
                    UpgrapImg.children('img').attr('src', data.src);
                    UpgrapImg.children('input').val(data.src);
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
        $('body').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        $('body').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.addFile').click(function() {
            $(this).prev().click();
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
            url: "<?php echo spUrl($c, 'saveZxlog'); ?>",
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


