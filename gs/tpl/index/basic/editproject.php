<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
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
                        <table class="Table TabInp totalItem">
                            <thead>
                                <tr class="colorGre">
                                    <th>名称</th><th class="textLeft pdX10"><input type="text" name="name" value="<?php echo $result['name']?>"/></th>
                                    <th>规格</th><th class="textLeft pdX10"><input type="text" name="format" value="<?php echo $result['format']?>"/></th>
                                    <th>单位</th><th class="textLeft pdX10"><input type="text" name="unit" value="<?php echo $result['unit']?>"/></th>
                                    <th>成套价</th><th class="textLeft pdX10"><input type="text" name="price" value="<?php echo $result['price']?>"/></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="8">所需元器件</th>
                                </tr>
                                <tr>
                                    <th>序号</th><th>名称</th><th>型号规格</th><th>单位</th><th>数量</th><th>单价</th><th>小计</th><th>操作</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter add">
                                <?php foreach ($result['mater'] as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k+1;?><input type="hidden" name="mid[]" value="<?php echo $v['mid']?>" /></td>
                                        <td class="ChousCs" data-id=""><input type="text" value="<?php echo $v['name']?>" /></td>
                                        <td class="Chousxh"><input type="text" value="<?php echo $v['format']?>" /></td>
                                        <td class="Chousdw"><input type="text" value="<?php echo $v['unit']?>" /></td>
                                        <td class="Choussl total num"><input type="text" name="mnum[<?php echo $v['mid']?>]" value="<?php echo $v['num']?>" /></td>
                                        <td class="Chousdj total price"><input type="text" name="mprice[<?php echo $v['mid']?>]" value="<?php echo $v['price']?>" /></td>
                                        <td class="Chousxj total val"><input type="text" value="<?php echo $v['money']?>" /></td>
                                        <td><span class="colorRed delTr">删除</span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="textCenter"><td></td><td><span class="TabAdd"></span></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                <tr class="textCenter totalMneu"><td>合计</td><td class="hjdx"></td><td></td><td></td><td class="total"></td><td></td><td class="total all"><?php echo $result['total']?></td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
                <div style="height: 50px;"></div>
            </div>
            <div class="ChousCS cs">
                <div class="ChousSerch cs">
                    <input class="ChousSerchItem cs" type="text" name="" id="" />
                    <div class="ChousBox top20 cs">
                        <div class="ChousBoxTit cs">
                            <span class="cs">名称</span><span class="cs">规格</span><span class="cs">单位</span><span class="cs">单价</span>
                        </div>
                        <div class="ChousBoxScroll cs">
                            <table class="cs ids">
                                <thead>

                                </thead>
                                <tbody>
                                    <?php foreach ($mater as $v) { ?>
                                        <tr class="cs tr"data-id="<?php echo $v['id'] ?>">
                                            <td class="cs"><?php echo $v['name'] ?></td>
                                            <td class="cs"><?php echo $v['format'] ?></td>
                                            <td class="cs"><?php echo $v['unit'] ?></td>
                                            <td class="cs"><?php echo $v['price'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
        }
    });
    $('.TabAdd').click(function() {
        var index = $('.add').children().length + 1
        $('.add').append(
                '<tr><td>' + index + '<input type="hidden" name="mid[]" value="" /></td><td class="ChousCs" data-id=""><input type="text"value=""/></td>'
                + '<td class="Chousxh"><input type="text"value=""/></td><td class="Chousdw"><input type="text"value=""/></td>'
                + '<td class="Choussl total num"><input type="text" name="mnum[]" value=""/></td><td class="Chousdj total price"><input type="text" name="mprice[]" value=""/></td>'
                + '<td class="Chousxj total val"><input type="text"value=""/></td><td><span class="colorRed delTr">删除</span></td></tr>'
                )
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
    })
    var ChousCs = null;
    $(document).on('click', '.ChousCs', function(e) {
        e.stopPropagation()
        var that = $(this);
        ChousCs = that;
        var w = 0;
        var h = 0;
        if (that.hasClass('active')) {
            that.removeClass('active');
            $('.ChousCS').removeClass('active');
        } else {
            $('.ChousCs').removeClass('active');
            that.addClass('active');
            $('.ChousCS').addClass('active');
            $('.ChousSerchItem').val('')
            $('.ChousSerchItem').focus()
            var arr_id = []
            $('.ChousCs').each(function(k, v) {
                arr_id.push($(v).attr('data-id'))
            })
            $('.ids .tr').each(function(k, v) {
                var id = $(v).attr('data-id');
                if (Find(arr_id, id)) {
                    $(v).hide()
                } else {
                    $(v).show()
                }
            })
        }

        if (($('.ChousCS').width() + that.offset().left) > $(window).width()) {
            w = that.offset().left - ($('.ChousCS').width() - that[0].offsetWidth + 2);
        } else {
            w = that.offset().left;
        }
        ;

        if (($('.ChousCS').height() + that.offset().top + that[0].offsetHeight - $(window).scrollTop()) > $(window).height()) {
            h = that.offset().top - ($('.ChousCS').height() + 2) - $(window).scrollTop();
        } else {
            h = that.offset().top + that[0].offsetHeight - $(window).scrollTop();
        }
        $('.ChousCS').css({left: w, top: h})
    });
    $(document).on('click', '.ids .tr', function(e) {
        e.stopPropagation()
        var th = $(this)
        var arr_id = []
        $('.ChousCs').each(function(k, v) {
            arr_id.push($(v).attr('data-id'))
        })
        var id = th.attr('data-id');
        if (Find(arr_id, id)) {
            return;
        }
        ChousCs.attr({'data-id': th.attr('data-id')});
        ChousCs.children('input').val(th.children().eq(0).text());
        ChousCs.parent().children('td').eq(0).children('input').val(th.attr('data-id'));
        ChousCs.parent().children('.Chousxh').children('input').val(th.children().eq(1).text());
        ChousCs.parent().children('.Chousdw').children('input').val(th.children().eq(2).text());
        ChousCs.parent().children('.Chousdj').children('input').val(th.children().eq(3).text());
        ChousCs.parent().children('.Choussl').children('input').val('');
        ChousCs.parent().children('.Chousdj').children('input').attr('name', 'mprice[' + id + ']');
        ChousCs.parent().children('.Choussl').children('input').attr('name', 'mnum[' + id + ']');
        ChousCs.parent().children('.Chousxj').children('input').val('');
        ChousCs.removeClass('active');
        $('.ChousCS').removeClass('active');
    })
    $(window).scroll(function() {
        $('.ChousCS').removeClass('active')
        $('.ChousCs').removeClass('active')
    })
    $(document).click(function(e) {
        if (e.target.className.indexOf('cs') == -1) {
            $('.ChousCS').removeClass('active')
            $('.ChousCs').removeClass('active')
        }
    })
    $(document).on('input', '.ChousSerchItem', function() {
        var val = $(this).val()
        $('.ids .tr').each(function(k, v) {
            if ($(v).children().eq(0).text().indexOf(val) != -1 || $(v).children().eq(1).text().indexOf(val) != -1) {
                $(v).show()
            } else {
                $(v).hide()
            }
        })
    })
    function Find(arr, k) {
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] - 0 == k - 0) {
                return true
            }
        }
        return false
    }
    $(document).on('click', '.delTr', function() {
        var that = $(this);
        Confirm('确定删除？', function(e) {
            if (e) {
                that.parent().parent().remove()
                Total()
            }
        })
    })
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveProject'); ?>",
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
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>
</html>


