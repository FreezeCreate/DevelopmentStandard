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
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="检测设备校准计划" /></div> 
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <td class="">编号</td>
                                    <td class="pdX10  textLeft" colspan="12">
                                        <input type="text" name="number" value="<?php echo $result['number']; ?>" />
                                    </td>
                                    <td class="" colspan="5">日期</td>
                                    <td class="pdX10  textLeft" colspan="13">
                                        <input type="text" class="dt" readonly="" name="dt" value="<?php echo $result['dt']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width:80px;">计量器具名称</th><th rowspan="2" style="width:80px;">使用科室</th><th rowspan="2">数量</th><th rowspan="2">检定周期</th>
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
                                <?PHP for($i=0;$i<10;$i++){?>
                                <tr>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="keshi[]" value=""/></td>
                                    <td><input type="text" name="sum[]" value=""/></td>
                                    <td><input type="text" name="zhouqi[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m1[]" value=""/></td><td class="totalVal num2"><input type="text" name="my1[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m2[]" value=""/></td><td class="totalVal num2"><input type="text" name="my2[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m3[]" value=""/></td><td class="totalVal num2"><input type="text" name="my3[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m4[]" value=""/></td><td class="totalVal num2"><input type="text" name="my4[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m5[]" value=""/></td><td class="totalVal num2"><input type="text" name="my5[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m6[]" value=""/></td><td class="totalVal num2"><input type="text" name="my6[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m7[]" value=""/></td><td class="totalVal num2"><input type="text" name="my7[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m8[]" value=""/></td><td class="totalVal num2"><input type="text" name="my8[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m9[]" value=""/></td><td class="totalVal num2"><input type="text" name="my9[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m10[]" value=""/></td><td class="totalVal num2"><input type="text" name="my10[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m11[]" value=""/></td><td class="totalVal num2"><input type="text" name="my11[]" value=""/></td>
                                    <td class="totalVal num1"><input type="text" name="m12[]" value=""/></td><td class="totalVal num2"><input type="text" name="my12[]" value=""/></td>
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
            url: "<?php echo spUrl($c, "saveSbxzjh"); ?>",
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