<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .Table td,.Table th{min-width: 15px;font-size: 12px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">检测设备校准计划</span><span class="Close"></span></div>
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
                        <h3 style="font-size: 16px; line-height: 60px;"><span style="float:right;"><?php echo $result['dt']; ?></span><?php echo $result['number'] ?></h3>
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="width:80px;">计量器具名称</th><th rowspan="2" style="width:80px;">使用科室</th><th rowspan="2" style="width:25px;">数量</th><th rowspan="2" style="width:50px;">检定周期</th>
                                    <th colspan="2">一月</th><th colspan="2">二月</th><th colspan="2">三月</th><th colspan="2">四月</th>
                                    <th colspan="2">五月</th><th colspan="2">六月</th><th colspan="2">七月</th><th colspan="2">八月</th>
                                    <th colspan="2">九月</th><th colspan="2">十月</th><th colspan="2">十一月</th><th colspan="2">十二月</th>
                                    <th colspan="2">合计</th>
                                </tr>
                                <tr>
                                    <th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th>
                                    <th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th>
                                    <th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th><th width="25">应检 </th><th width="25">实检 </th>
                                    <th width="25">应检 </th><th width="25">实检 </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td><?php echo $v['name']?></td>
                                    <td><?php echo $v['keshi']?></td>
                                    <td><?php echo $v['sum']?></td>
                                    <td><?php echo $v['zhouqi']?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m1']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m2']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m3']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m4']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m5']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m6']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m7']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m8']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m9']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m10']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m11']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1"><?php $m = explode('/', $v['m12']);echo $m[0];?></td><td class="totalVal num2"><?php echo $m[1];?></td>
                                    <td class="totalVal num1all"><input type="text" name="ms[]" value=""/></td><td class="totalVal num2all"><input type="text" name="msy[]" value=""/></td>
                                </tr>
                                <?php }?>
                                <tr class="totalMneu">
                                    <td>合计</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="totalAllNum1"></td><td class="totalAllNum2"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">编制：</span><input type="text" class="FrameGroupInput" name="bianzhi" value=""/></p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
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

