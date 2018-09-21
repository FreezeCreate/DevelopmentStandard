<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
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
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;">文件修订清单</h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><span style="float:right"><?php echo $result['date'] ?></span><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <tbody class="TabBg textCenter TabInp add">
                                <tr>
                                    <td class="textCenter">文件名称</td>
                                    <td class="pdX10 textLeft"><?php echo $result['wname'] ?></td>
                                    <td class="textCenter">编号</td>
                                    <td class="pdX10 textLeft"><?php echo $result['wnumber'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改性质</td>
                                    <td class="pdX10 textLeft">
                                        <label>
                                            <span class="radio <?php echo $result['type']=='条款'?'active':'' ?>">条款</span>
                                        </label>
                                        <label>
                                            <span class="radio <?php echo $result['type']=='页次'?'active':'' ?>">页次</span>
                                        </label>
                                        <label>
                                            <span class="radio <?php echo $result['type']=='换版'?'active':'' ?>">换版</span>
                                        </label>
                                        <label>
                                            <span class="radio <?php echo $result['type']=='取消'?'active':'' ?>">取消</span>
                                        </label>
                                    </td>
                                    <td class="textCenter">归口部门</td>
                                    <td class="pdX10 textLeft"><?php echo $result['dep'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改理由</td>
                                    <td colspan="3" class="textLeft"><div style="height:400px;"><?php echo $result['case'] ?></div></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">修改内容</td>
                                    <td colspan="3" class="textLeft"><div style="height:400px;"><?php echo $result['content'] ?></div></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">附录</td>
                                    <td colspan="3" class="textLeft"><div style="height:50px;"><?php echo $result['fulu'] ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">申请人/日期：</span></p>
                                <div class="UpgrapImg">
                                    <img class="" src="<?php echo $result['uname']; ?>"/>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="FrameTableFoot">
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