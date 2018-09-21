<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">标志发放记录</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title'] ?></h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">购买日期</td>
                                    <td class="pdX10  textLeft">
                                        <?php echo $result['dt'] ?>
                                    </td>
                                    <td class="textRight">标识规格</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <?php echo $result['format'] ?>
                                    </td>
                                    <td class="textRight">购买数量</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <?php echo $result['sum'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">序号</td>
                                    <td class="">产品型号规格</td>
                                    <td class="">发放人</td>
                                    <td class="">发放日期</td>
                                    <td class="">发放数量</td>
                                    <td class="">领用人</td>
                                    <td class="">用户</td>
                                    <td class="">神域数量</td>
                                </tr>
                            </thead>
                            <tbody class="textCenter">
                                <?php for($i=0;$i<29;$i++){?>
                                <tr>
                                    <td class=""><?php echo $i+1?></td>
                                    <td class=""><?php echo $result['children'][$i]['format']?></td>
                                    <td class=""><?php echo $result['children'][$i]['fname']?></td>
                                    <td class=""><?php echo $result['children'][$i]['fdt']?></td>
                                    <td class=""><?php echo empty($result['children'][$i]['fnum'])?'':$result['children'][$i]['fnum']?></td>
                                    <td class=""><?php echo $result['children'][$i]['lname']?></td>
                                    <td class=""><?php echo $result['children'][$i]['yonghu']?></td>
                                    <td class=""><?php echo empty($result['children'][$i]['snum'])?'':$result['children'][$i]['snum']?></td>
                                </tr>
                                <?php }?>
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
