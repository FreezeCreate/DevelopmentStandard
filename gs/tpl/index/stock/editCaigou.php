<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form id="check_form">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="top20">
                        <div class="Item">
                            <table class="Table TabInp">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="textCenter TabBgBlue">请购单</th>
                                    </tr>
                                    <tr>
                                        <th class="textCenter TabBgBlue">编号</th>
                                        <th colspan="5" class="pdX10 textLeft"><input type="text" name="number" value="<?php echo $result['number'] ?>" /></th>
                                    </tr>
                                    <tr class="TabBgBlue">
                                        <th>序号</th><th>产品名称</th><th>型号规格</th><th>供应商名称</th><th>请购数量</th><th>备注</th>
                                    </tr>
                                </thead>
                                <tbody class="add textCenter">
                                    <?php foreach($result['children'] as $k=>$v){?>
                                    <tr>
                                        <td><?php echo $k+1;?></td>
                                        <td><input type="text" name="name[]" id="" value="<?php echo $v['name']?>" /></td>
                                        <td><input type="text" name="format[]" id="" value="<?php echo $v['format']?>" /></td>
                                        <td><input type="text" name="supplier[]" id="" value="<?php echo $v['supplier']?>" /></td>
                                        <td><input type="text" name="num[]" id="" value="<?php echo $v['num']?>" /></td>
                                        <td><input type="text" name="explain[]" id="" value="<?php echo $v['explain']?>" /></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                <td></td><td><span class="TabAdd"></span></td><td></td><td></td><td></td><td></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            <div style="height: 50px;"></div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">保存</span>
        </div>
    </div>

</body>
<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.TabAdd').click(function() {
            $('.add').append(
                    '<tr><td>' + ($('.add').children().length + 1) + '</td><td><input type="text" name="name[]" id="" value="" /></td>'
                    + '<td><input type="text" name="format[]" id="" value="" /></td><td><input type="text" name="supplier[]" id="" value="" /></td>'
                    + '<td><input type="text" name="num[]" id="" value="" /></td><td><input type="text" name="explain[]" id="" value="" /></td></tr>'
                    )
        });


    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveCaigou'); ?>",
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


