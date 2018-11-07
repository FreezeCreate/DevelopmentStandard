<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form id="check_form">
                <input type="hidden" name="id" value="<?php echo $result['id']?>"/>
            <div class="FrameCont">
                <div class="top20">
                    <div class="Item">
                        <table class="Table TabInp">
                            <tbody class="add">
                                <tr>
                                    <td width="150" class="textCenter TabBgBlue">文件编号</td>
                                    <td colspan="2" class="pdX10"><input type="text" name="number" value="<?php echo $result['number']?>" /></td>
                                </tr>
                                <tr>
                                    <td width="150" class="textCenter TabBgBlue">标题</td>
                                    <td colspan="2" class="pdX10"><input type="text" name="title" value="<?php echo $result['title']?>" placeholder="XXXX变更审批表"/></td>
                                </tr>
                                <tr>
                                    <td width="150" class="textCenter TabBgBlue">适用产品</td>
                                    <td colspan="2" class="pdX10"><input type="text" name="project" value="<?php echo $result['project']?>" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">变更原因</td>
                                    <td colspan="2"class="pdX10"><textarea  rows="5" name="case" ><?php echo $result['case']?></textarea></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" class="textCenter TabBgBlue">变更内容</td>
                                    <td class="textCenter TabBgBlue">变更前</td>
                                    <td class="textCenter TabBgBlue">变更后</td>
                                </tr>
                                <tr>
                                    <td class="pdX10"><textarea  rows="10" name="start"><?php echo $result['start']?></textarea></td>
                                    <td class="pdX10"><textarea  rows="10" name="end" ><?php echo $result['end']?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">变更依据</td>
                                    <td colspan="2"class="pdX10"><textarea  rows="5" name="yiju" ><?php echo $result['yiju']?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">质量负责人意见</td>
                                    <td colspan="2"class="pdX10"><textarea  rows="5" name="zlyijian" ><?php echo $result['zlyijian']?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">技术负责人意见</td>
                                    <td colspan="2"class="pdX10"><textarea  rows="5" name="jsyijian" ><?php echo $result['jsyijian']?></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
            <div style="height: 50px;"></div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">保存</span>
        </div>
    </div>

</body>
<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.che label').click(function() {
            var that = $(this);
            $('.Item').removeClass('active')
            $('.Item').eq(that.index()).addClass('active')
        });
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
            url: "<?php echo spUrl($c, 'saveBiangeng'); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                Alert(data.msg);
                if (data.status == 1) {
                    loading('none');
                     
                    parent.closHtml();
                    Refresh();
                } else {
                    loading('none');
                }
            }
        });
    }
</script>
</html>


