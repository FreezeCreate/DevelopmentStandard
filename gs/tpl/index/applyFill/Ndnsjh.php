<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">年度内审计划</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="年度内审计划" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">编号</td>
                                    <td class="pdX10  textLeft" colspan="5">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">月份</th><th colspan="5">部门</th>
                                </tr>
                                <tr>
                                    <th>管理层</th><th>行政部</th><th>生产技术部</th><th>采购部</th><th>质检部</th>
                                </tr>
                            </thead>
                            <tbody class="add textCenter">
                                <tr>
                                    <td>01</td>
                                    <td><label for="gl1"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl1" value="1"/></label></td>
                                    <td><label for="xz1"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz1" value="1"/></label></td>
                                    <td><label for="sc1"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc1" value="1"/></label></td>
                                    <td><label for="cg1"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg1" value="1"/></label></td>
                                    <td><label for="zj1"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj1" value="1"/></label></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td><label for="gl2"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl2" value="1"/></label></td>
                                    <td><label for="xz2"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz2" value="1"/></label></td>
                                    <td><label for="sc2"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc2" value="1"/></label></td>
                                    <td><label for="cg2"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg2" value="1"/></label></td>
                                    <td><label for="zj2"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj2" value="1"/></label></td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td><label for="gl3"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl3" value="3"/></label></td>
                                    <td><label for="xz3"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz3" value="3"/></label></td>
                                    <td><label for="sc3"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc3" value="3"/></label></td>
                                    <td><label for="cg3"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg3" value="3"/></label></td>
                                    <td><label for="zj3"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj3" value="3"/></label></td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td><label for="gl4"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl4" value="4"/></label></td>
                                    <td><label for="xz4"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz4" value="4"/></label></td>
                                    <td><label for="sc4"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc4" value="4"/></label></td>
                                    <td><label for="cg4"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg4" value="4"/></label></td>
                                    <td><label for="zj4"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj4" value="4"/></label></td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td><label for="gl5"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl5" value="5"/></label></td>
                                    <td><label for="xz5"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz5" value="5"/></label></td>
                                    <td><label for="sc5"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc5" value="5"/></label></td>
                                    <td><label for="cg5"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg5" value="5"/></label></td>
                                    <td><label for="zj5"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj5" value="5"/></label></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td><label for="gl6"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl6" value="6"/></label></td>
                                    <td><label for="xz6"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz6" value="6"/></label></td>
                                    <td><label for="sc6"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc6" value="6"/></label></td>
                                    <td><label for="cg6"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg6" value="6"/></label></td>
                                    <td><label for="zj6"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj6" value="6"/></label></td>
                                </tr>
                                <tr>
                                    <td>07</td>
                                    <td><label for="gl7"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl7" value="7"/></label></td>
                                    <td><label for="xz7"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz7" value="7"/></label></td>
                                    <td><label for="sc7"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc7" value="7"/></label></td>
                                    <td><label for="cg7"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg7" value="7"/></label></td>
                                    <td><label for="zj7"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj7" value="7"/></label></td>
                                </tr>
                                <tr>
                                    <td>08</td>
                                    <td><label for="gl8"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl8" value="8"/></label></td>
                                    <td><label for="xz8"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz8" value="8"/></label></td>
                                    <td><label for="sc8"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc8" value="8"/></label></td>
                                    <td><label for="cg8"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg8" value="8"/></label></td>
                                    <td><label for="zj8"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj8" value="8"/></label></td>
                                </tr>
                                <tr>
                                    <td>09</td>
                                    <td><label for="gl9"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl9" value="9"/></label></td>
                                    <td><label for="xz9"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz9" value="9"/></label></td>
                                    <td><label for="sc9"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc9" value="9"/></label></td>
                                    <td><label for="cg9"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg9" value="9"/></label></td>
                                    <td><label for="zj9"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj9" value="9"/></label></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td><label for="gl10"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl10" value="10"/></label></td>
                                    <td><label for="xz10"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz10" value="10"/></label></td>
                                    <td><label for="sc10"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc10" value="10"/></label></td>
                                    <td><label for="cg10"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg10" value="10"/></label></td>
                                    <td><label for="zj10"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj10" value="10"/></label></td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td><label for="gl11"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl11" value="11"/></label></td>
                                    <td><label for="xz11"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz11" value="11"/></label></td>
                                    <td><label for="sc11"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc11" value="11"/></label></td>
                                    <td><label for="cg11"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg11" value="11"/></label></td>
                                    <td><label for="zj11"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj11" value="11"/></label></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td><label for="gl12"><span class="checkbox"></span><input class="None"type="checkbox"name="gl[]"id="gl12" value="12"/></label></td>
                                    <td><label for="xz12"><span class="checkbox"></span><input class="None"type="checkbox"name="xz[]"id="xz12" value="12"/></label></td>
                                    <td><label for="sc12"><span class="checkbox"></span><input class="None"type="checkbox"name="sc[]"id="sc12" value="12"/></label></td>
                                    <td><label for="cg12"><span class="checkbox"></span><input class="None"type="checkbox"name="cg[]"id="cg12" value="12"/></label></td>
                                    <td><label for="zj12"><span class="checkbox"></span><input class="None"type="checkbox"name="zj[]"id="zj12" value="12"/></label></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">检查人/日期：</span></p>
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
        format: "YYYY/MM/DD",
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
            url: "<?php echo spUrl($c, "saveNdnsjh"); ?>",
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