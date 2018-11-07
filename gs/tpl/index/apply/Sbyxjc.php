<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
    .Table td, .Table th { padding: 6px 4px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">检验和试验设备台账</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;">设备运行检查记录</h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><span style="float:right"><?php echo $result['dt'] ?></span><?php echo $result['number'] ?></h3>
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <td width="50">序号</td><td width="200">检查项目</td><td>检查内容</td><td>实测试值</td><td>结论</td><td>检验员</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="3">1</td>
                                    <td rowspan="3">耐压测试仪的运行检查</td>
                                    <td style="height:100px;">开启电源前，检查各按钮是否有效可靠，查看电压表的指针是否为“0”.</td>
                                    <td><?php echo $result['val1'][1]?></td>
                                    <td rowspan="3" class="pdX10 textLeft"><?php echo $result['val1'][4]?></td>
                                    <td rowspan="3"><?php echo empty($result['val1'][5])?'':'<img src="'.$result['val1'][5].'"/>'?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">开启电源按钮，使仪器处于测试状态，调节电压旋钮，检查电压指针能否由0逐渐上升。</td>
                                    <td><?php echo $result['val1'][2]?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">将仪器的漏电流置于 1mA，加载1MΩ的标准电阻，调节旋钮到要求电压，若报警则表明设备正常。</td>
                                    <td><?php echo $result['val1'][3]?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">2</td>
                                    <td rowspan="3">接地电阻测试仪的运行检查</td>
                                    <td style="height:100px;">检查该设备的工作电源和检流计电源是否正常。</td>
                                    <td><?php echo $result['val2'][1]?></td>
                                    <td rowspan="3" class="pdX10 textLeft"><?php echo $result['val2'][4]?></td>
                                    <td rowspan="3"><?php echo empty($result['val2'][5])?'':'<img src="'.$result['val2'][5].'"/>'?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">各档位调节旋钮是否灵活有效。</td>
                                    <td><?php echo $result['val2'][2]?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">测试1m长、2.5mm2BV线电阻值，误差在±10%内为设备正常。</td>
                                    <td><?php echo $result['val2'][3]?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">3</td>
                                    <td rowspan="3">绝缘电阻表的运行检查</td>
                                    <td style="height:100px;">将摇表放置平衡，检查指针是否处于20MΩ.</td>
                                    <td><?php echo $result['val3'][1]?></td>
                                    <td rowspan="3" class="pdX10 textLeft"><?php echo $result['val3'][4]?></td>
                                    <td rowspan="3"><?php echo empty($result['val3'][5])?'':'<img src="'.$result['val3'][5].'"/>'?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">将摇表开路，摇动手柄达到120r/min的转速，观察指针是否指到“∞”处。</td>
                                    <td><?php echo $result['val3'][2]?></td>
                                </tr>
                                <tr>
                                    <td style="height:100px;">将“地”、“线”端短接，缓缓摇动手柄，观察指针是否指到“0”处。</td>
                                    <td><?php echo $result['val3'][3]?></td>
                                </tr>
                                <tr>
                                    <td>结论</td>
                                    <td colspan="5" class="pdX20 textLeft"><?php echo $result['jielun']?></td>
                                </tr>

                            </tbody>
                        </table>
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
