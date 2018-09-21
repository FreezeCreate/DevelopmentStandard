<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">设备运行检查记录</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="设备运行检查记录" /></div> 
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <td class="">编号</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <input type="text" name="pnumber" value="<?php echo $result['number'];?>" />
                                    </td>
                                    <td class="">日期</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <input type="text" class="dt" readonly="" name="dt" value="<?php echo $result['dt'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">序号</td><td width="200">检查项目</td><td>检查内容</td><td>实测试值</td><td>结论</td><td>检验员</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="3">1</td><td rowspan="3">耐压测试仪的运行检查</td><td>开启电源前，检查各按钮是否有效可靠，查看电压表的指针是否为“0”.</td>
                                    <td><input type="text" name="val1[1]" value="<?php echo $result['val1'][1];?>" /></td>
                                    <td rowspan="3" class="pdX10 textLeft"><textarea name="val1[4]" rows="5"><?php echo $result['val1'][4];?></textarea></td>
                                    <td rowspan="3">
                                        <div class="UpgrapImg float-right">
                                            <img class="" src="<?php echo empty($result['val1'][5]) ? SOURCE_PATH . '/images/qianming.png' : $result['val1'][5]; ?>"/>
                                            <input type="hidden" name="val1[5]" value="<?php echo empty($result['val1'][5]) ? '' : $result['val1'][5]; ?>"/>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td>开启电源按钮，使仪器处于测试状态，调节电压旋钮，检查电压指针能否由0逐渐上升。</td>
                                    <td><input type="text" name="val1[2]" value="<?php echo $result['val1'][2];?>" /></td>
                                </tr>
                                <tr>
                                    <td>将仪器的漏电流置于 1mA，加载1MΩ的标准电阻，调节旋钮到要求电压，若报警则表明设备正常。</td>
                                    <td><input type="text" name="val1[3]" value="<?php echo $result['val1'][3];?>" /></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">2</td><td rowspan="3">接地电阻测试仪的运行检查</td><td>检查该设备的工作电源和检流计电源是否正常。</td>
                                    <td><input type="text" name="val2[1]" value="<?php echo $result['val2'][1];?>" /></td>
                                    <td rowspan="3" class="pdX10 textLeft"><textarea name="val2[4]" rows="5"><?php echo $result['val2'][4];?></textarea></td>
                                    <td rowspan="3">
                                        <div class="UpgrapImg float-right">
                                            <img class="" src="<?php echo empty($result['val2'][5]) ? SOURCE_PATH . '/images/qianming.png' : $result['val2'][5]; ?>"/>
                                            <input type="hidden" name="val2[5]" value="<?php echo empty($result['val2'][5]) ? '' : $result['val2'][5]; ?>"/>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td>各档位调节旋钮是否灵活有效。</td>
                                    <td><input type="text" name="val2[2]" value="<?php echo $result['val2'][2];?>" /></td>
                                </tr>
                                <tr>
                                    <td>测试1m长、2.5mm2BV线电阻值，误差在±10%内为设备正常。</td>
                                    <td><input type="text" name="val2[3]" value="<?php echo $result['val2'][3];?>" /></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">3</td><td rowspan="3">绝缘电阻表的运行检查</td><td>将摇表放置平衡，检查指针是否处于20MΩ.</td>
                                    <td><input type="text" name="val3[1]" value="<?php echo $result['val3'][1];?>" /></td>
                                    <td rowspan="3" class="pdX10 textLeft"><textarea name="val3[4]" rows="5"><?php echo $result['val3'][4];?></textarea></td>
                                    <td rowspan="3">
                                        <div class="UpgrapImg float-right">
                                            <img class="" src="<?php echo empty($result['val3'][5]) ? SOURCE_PATH . '/images/qianming.png' : $result['val3'][5]; ?>"/>
                                            <input type="hidden" name="val3[5]" value="<?php echo empty($result['val3'][5]) ? '' : $result['val3'][5]; ?>"/>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td>将摇表开路，摇动手柄达到120r/min的转速，观察指针是否指到“∞”处。</td>
                                    <td><input type="text" name="val3[2]" value="<?php echo $result['val3'][2];?>" /></td>
                                </tr>
                                <tr>
                                    <td>将“地”、“线”端短接，缓缓摇动手柄，观察指针是否指到“0”处。</td>
                                    <td><input type="text" name="val3[3]" value="<?php echo $result['val3'][3];?>" /></td>
                                </tr>
                                <tr>
                                    <td>结论</td>
                                    <td colspan="5" class="pdX20 textLeft"><textarea name="jielun"  rows="3"><?php echo $result['jielun'];?></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
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
    var UpgrapImg;
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        };
        $(document).on('click', '.UpgrapImg', function() {
            UpgrapImg = $(this);
            $('#fileToUploadQm').click();
        });
    });
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY.MM.DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
</script>
</html>

<script>
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
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveSbyxjc"); ?>",
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
                }else{
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
</script>