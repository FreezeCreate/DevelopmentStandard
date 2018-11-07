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
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr><th colspan="5" style="border:0;"><input type="text" name="pname" value="<?php echo empty($result['name'])?'材料入库单':$result['name']?>" /></th></tr>
                                <tr>
                                    <th class="textRight" style="border:0;">文件编号：</th>
                                    <th class="textLeft" style="border:0;"><input type="text" name="number" value="<?php echo $result['number']?>" /></th>
                                    <th style="border:0;"></th>
                                    <th class="textRight" style="border:0;">入库日期：</th>
                                    <th class="textLeft" style="border:0;"><input type="text" class="dt" name="dt" value="<?php echo empty($result['dt'])?date('Y年m月d日'):$result['dt']?>" /></th>
                                </tr>
                                <tr><th>名称</th><th>型号规格</th><th>数量</th><th>制造商/生产厂</th><th>备注</th></tr>
                            </thead>
                            <tbody class="textCenter add">
                                <?php foreach($result['children'] as $v){?>
                                <tr>
                                    <td><input type="text" name="name[]" value="<?php echo $v['name']?>" /></td>
                                    <td><input type="text" name="format[]" value="<?php echo $v['format']?>" /></td>
                                    <td class=""><input name="num[]" type="text" value="<?php echo $v['num']?>" /></td>
                                    <td><input type="text" name="supplier[]" value="<?php echo $v['supplier']?>" /></td>
                                    <td><input type="text" name="explain[]" value="<?php echo $v['explain']?>" /></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="format[]" value="" /></td>
                                    <td class=""><input name="num[]" type="text" value="" /></td>
                                    <td><input type="text" name="supplier[]" value="" /></td>
                                    <td><input type="text" name="explain[]" value="" /></td>
                                </tr>
                            </tbody>
                            <tfoot class="textCenter">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><span class="TabAdd"></span></td>
                                    <td></td>
                                    <td></td>
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
        format: "YYYY年MM月DD日",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $(function() {
            $('.TabAdd').click(function() {
                $('.add').append(
                        '<tr><td><input type="text" name="name[]" value="" /></td><td><input name="format[]" type="text" value="" /></td>'
                        + '<td class=""><input name="num[]" type="text" value="" /></td><td><input name="supplier[]" type="text" value="" /></td>'
                        + '<td><input type="text" name="explain[]" value="" /></td></tr>'
                        )
            })
        })
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveClruku'); ?>",
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


