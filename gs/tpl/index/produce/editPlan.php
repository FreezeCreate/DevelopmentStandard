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
                    <div class="top20">
                    <?php 
                    if (empty($result) && !empty($all_orders)){ echo '<td class="FrameGroupName" style="margin-bottom: 20px;">订单选择： </td>';?>
                        <td colspan="3"><select name="oid" class="FrameGroupInput">
                        <?php 
                            foreach ($all_orders as $ak => $av){
                                echo '<option value="'.$av['id'].'">'.$av['name'].'</option>';
                            }
                        ?>
</select>
                      <?php   }
                    
                    ?>
                        <table class="Table TabInp ">
                            <thead>
                                <tr>
                                    <th>文件编号</th>
                                    <th colspan="2" class="pdX10 textLeft"><input type="text" name="number" value="<?php echo $result['number'] ?>"/></th>
                                    <th>No</th>
                                    <th class="pdX10 textLeft"><input type="text" name="No" value="<?php echo $result['No'] ?>"/></th>
                                </tr>
                                <tr><th>车间</th><th colspan="4"class="pdX10 textLeft"><input type="text" name="workshop" value="<?php echo $result['workshop'] ?>"/></th></tr>
                                <tr><th>产品名称</th><th>型号、规格</th><th>生产数量</th><th>要求完成时间</th><th>备注</th></tr>
                            </thead>
                            <tbody class="TabBg textCenter add">
                                <?php foreach ($result['children'] as $v) { ?>
                                    <tr>
                                        <td><input type="text" name="name[]" value="<?php echo $v['name']?>" /></td>
                                        <td><input type="text" name="format[]" value="<?php echo $v['format']?>" /></td>
                                        <td><input type="text" name="num[]" value="<?php echo $v['num']?>" /></td>
                                        <td><input class="dt" type="text" name="dt[]" value="<?php echo $v['dt']?>" /></td>
                                        <td><input type="text" name="explain[]" value="<?php echo $v['explain']?>" /></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="format[]" value="" /></td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                    <td><input class="dt" type="text" name="dt[]" value="" /></td>
                                    <td><input type="text" name="explain[]" value="" /></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="textCenter"><td></td><td></td><td><span class="TabAdd"></span></td><td></td><td></td></tr>
                                <tr>
                                    <td class="textCenter">备注</td>
                                    <td colspan="4"class="pdX10"><textarea rows="2" name="pexplain"><?php echo $result['explain'] ?></textarea></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.TabAdd').click(function() {
            $('.add').append(
                    '<tr><td><input type="text" name="name[]" value="" /></td><td><input type="text" name="format[]" value="" /></td><td><input type="text" name="num[]" value="" /></td>'
                    + '<td><input class="dt" type="text" name="dt[]" value="" /></td><td><input type="text" name="explain[]" value="" /></td></tr>'
                    )
        });
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'savePlan'); ?>",
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


