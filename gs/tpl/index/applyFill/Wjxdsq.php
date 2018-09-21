<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">文件修订申请</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    
                    <div class="FrameTable">
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textCenter">编号</td>
                                    <td class="pdX10  textLeft" colspan="">
                                        <input type="text" name="number" value="" />
                                    </td>
                                    <td class="textCenter">日期</td>
                                    <td class="pdX10  textLeft" colspan="">
                                        <input type="text" class="dt" name="date" value="" />
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter TabInp add">
                                <tr>
                                    <td class="textCenter">文件名称</td>
                                    <td class="pdX10 textLeft"><input type="text" name="wname" /></td>
                                    <td class="textCenter">编号</td>
                                    <td class="pdX10 textLeft"><input type="text" name="wnumber" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改性质</td>
                                    <td class="pdX10 textLeft">
                                        <label>
                                            <span class="radio active">条款</span>
                                            <input type="radio" class="None" name="type" checked="checked" value="条款" />
                                        </label>
                                        <label>
                                            <span class="radio">页次</span>
                                            <input type="radio" class="None" name="type" value="页次" />
                                        </label>
                                        <label>
                                            <span class="radio">换版</span>
                                            <input type="radio" class="None" name="type" value="换版" />
                                        </label>
                                        <label>
                                            <span class="radio">取消</span>
                                            <input type="radio" class="None" name="type" value="取消" />
                                        </label>
                                    </td>
                                    <td class="textCenter">归口部门</td>
                                    <td class="pdX10 textLeft">
                                        <input type="text" name="dep" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改理由</td>
                                    <td colspan="3" class="textLeft"><textarea rows="3" name="case"></textarea></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改内容</td>
                                    <td colspan="3" class="textLeft"><textarea rows="5" name="content"></textarea></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">附录</td>
                                    <td colspan="3" class="textLeft"><textarea rows="2" name="fulu"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">申请人/日期：</span></p>
                                <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                    <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                    <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                </div>
                                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
        </div>
    </div>
</body>
<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript">
                $(function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    window.onresize = function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    };
                });
</script>
</html>

<script>
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY年MM月DD日",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
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
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveWjxdsq"); ?>",
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
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
</script>