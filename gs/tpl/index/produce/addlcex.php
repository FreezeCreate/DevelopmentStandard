<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <form id="do_form">
                    <input type="hidden" name="id"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp">
                            <tbody class="addbd">
                                <tr>
                                    <td class="textCenter">模板名称</td><td colspan="3"><input type="text" name="name" value="" /></td>
                                </tr>
                                <tr id="p1">
                                    <td class="textCenter" rowspan="1">工序名称</td>
                                    <td rowspan="1">
                                        <input type="text" name="gname[1]" class="FrameGroupInput" id="" value="" />
                                        <span class="Btn Btn-green addgx" data-pid="1">添加工序</span>
                                    </td>
                                    <td class="textCenter" rowspan="1">操作要点</td>
                                    <td>
                                        <input type="text" class="FrameGroupInput" name="content[1][]" id="" value="" />
                                        <span class="Btn Btn-green addyd"data-pid="1">添加要点</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_subcheck()">保存</span>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(document).on('click', '.addgx', function() {
        var id = $(this).attr('data-pid')*1;
        $('.addbd').append(
                '<tr id="p' + (id + 1) + '"><td class="textCenter"rowspan="1">工序名称</td><td rowspan="1">'
                + '<input type="text" name="gname[' + (id + 1) + ']" class="FrameGroupInput" id="" value="" />'
                + '<span class="Btn Btn-green addgx"data-pid="' + (id + 1) + '">添加工序</span></td>'
                + '<td class="textCenter" rowspan="1">操作要点</td><td>'
                + '<input type="text" class="FrameGroupInput" name="content[' + (id + 1) + '][]" id="" value="" />'
                + '<span class="Btn Btn-green addyd"data-pid="' + (id + 1) + '">添加要点</span></td></tr>'
                )
        $(this).remove()
    })

    $(document).on('click', '.addyd', function() {
        var that = $(this).parent().parent();
        var id = $(this).attr('data-pid')
        that.after(
                '<tr><td><input type="text" class="FrameGroupInput" name="content[' + id + '][]" id="" value="" />'
                + '<span class="Btn Btn-green addyd"data-pid="' + id + '">添加要点</span></td></tr>'
                )
        $('#p' + id).children('td').eq(0).attr({'rowspan': $('#p' + id).children('td').eq(0).attr('rowspan') - 0 + 1})
        $('#p' + id).children('td').eq(1).attr({'rowspan': $('#p' + id).children('td').eq(1).attr('rowspan') - 0 + 1})
        $('#p' + id).children('td').eq(2).attr({'rowspan': $('#p' + id).children('td').eq(2).attr('rowspan') - 0 + 1})
        $(this).remove()
    })
    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
    window.onresize = function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
    };
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, $a); ?>",
            data: $('#do_form').serialize(),
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
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>


