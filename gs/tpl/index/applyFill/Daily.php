<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>工作日报</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">工作日报</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <form id="check_form">
                            <input type="hidden" id="id" name="id" value="<?php echo $result['id'] ?>"/>
                            <table  class="FrameTableCont">
                                <tbody>
                                    <tr>
                                        <td class="FrameGroupName">我的目标业绩</td>
                                        <td><?php echo $mubiao ?></td>
                                        <td class="FrameGroupName">本月业绩</td>
                                        <td <?php echo $mubiao > $yeji['money'] ? 'style="color:red"' : '' ?>><?php echo $yeji['money'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 类型</td>
                                        <td><select class="FrameGroupInput" id="type" name="type">
                                                <option <?php echo $result['type'] == '日报' ? 'selected=""' : ''; ?> value="日报">日报</option>
                                                <option <?php echo $result['type'] == '周报' ? 'selected=""' : ''; ?> value="周报">周报</option>
                                                <option <?php echo $result['type'] == '月报' ? 'selected=""' : ''; ?> value="月报">月报</option>
                                                <option <?php echo $result['type'] == '年报' ? 'selected=""' : ''; ?> value="年报">年报</option>
                                            </select></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName" style="width: 150px;"><span style="color:red;">*</span> 时间</td>
                                        <td ><input class="FrameGroupInput" readonly="readonly" type="text" id="date" name="date" value="<?php echo empty($result['date']) ? date('Y-m-d') : $result['date'] ?>"/></td>
                                        <td class="FrameGroupName" style="width: 150px;">截止时间</td>
                                        <td><input class="FrameGroupInput" readonly="readonly" type="text" id="enddt" name="enddt" value="<?php echo $result['enddt'] ?>"/></td>
                                    </tr>

                                    <tr class="show1">
                                        <td class="FrameGroupName" style="width: 150px;">实际电话量</td>
                                        <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $result['phone'] ?>"/></td>
                                        <td class="FrameGroupName" style="width: 150px;">实际意向客户数量</td>
                                        <td><input class="FrameGroupInput" type="text" name="yixiang" value="<?php echo $result['yixiang'] ?>"/></td>
                                    </tr>
                                    <tr class="show1">
                                        <td class="FrameGroupName" style="width: 150px;">面见客户</td>
                                        <td><select class="FrameGroupInput" id="mianjian">
                                                <option value="">请选择...</option>
                                                <?php foreach ($customer as $v) { ?>
                                                    <option data-name="<?php echo $v['name'] ?>" data-tel="<?php echo $v['mobile'] ?>" data-address="<?php echo $v['address'] ?>" value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                                <?php } ?>
                                            </select></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
        <!--                            <tr class="show1">
                                        <td></td>
                                        <td colspan="3"><input type="hidden" name="mianjian[]" value=""/>啊啊，156223264，啊啊啊啊啊啊啊啊</td>
                                    </tr>-->
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 总结</td>
                                        <td colspan="3"><textarea class="FrameGroupInput" name="zongjie"><?php echo $result['zongjie'] ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td class="plant FrameGroupName"><span style="color:red;">*</span> 明日计划</td>
                                        <td colspan="3"><textarea class="FrameGroupInput" name="plan"><?php echo $result['plan'] ?></textarea></td>
                                    </tr>
                                    <tr class="show1">
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 预计电话量</td>
                                        <td class="yujiphone"><input class="FrameGroupInput" type="text"  name="yjphone" value=""/></td>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 预计意向客户数量</td>
                                        <td class="yujiyixiang"><input class="FrameGroupInput" type="text" name="yjyixiang" value=""/></td>
                                    </tr>

                                </tbody>
                            </table>
                        </form>
                    </div>

                </div>
                <!--  <div class="clear" style="height: 80px;"></div>
                  <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
                  <div class="mark"></div>-->
            </div>
            <div class="FrameTableFoot">
                <a class="but but-primary" onclick="do_sub()"><span class="Btn Big">保存</span></a>
            </div>
        </div>
    </body>

</html>

<script>
    // jeDate({
    // dateCell: "#begin", //isinitVal:true,
    // format: "YYYY-MM-DD",
    // isTime: false, //isClear:false,
    // minDate: "2015-10-19 00:00:00",
    // maxDate: "2016-11-8 00:00:00"
    // })
    // jeDate({
    // dateCell: "#end", //isinitVal:true,
    // format: "YYYY-MM-DD",
    // isTime: false, //isClear:false,
    //minDate: "2015-10-19 00:00:00",
    //maxDate: "2016-11-8 00:00:00"
    // })
$(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        };
    });
    $('#type').change(function() {
        $type = $('#type').val();
        if ($type === '日报') {
            $('.show1').show();
            $('.show2').hide();
//            if($('#id').val()==''){
//                $('.shiji').hide();
//            }
            $('.plant').html('<span style="color:red;">*</span> 明日计划');
        } else if ($type === '周报') {
            $('.show1').show();
            $('.show2').show();
            $('.plant').html('<span style="color:red;">*</span> 下周计划');
        } else if ($type === '月报') {
            $('.show1').show();
            $('.show2').show();
            $('.plant').html('<span style="color:red;">*</span> 下月计划');
        } else if ($type === '年报') {
            $('.show1').show();
            $('.show2').show();
            $('.plant').html('<span style="color:red;">*</span> 明年计划');
        }
        findType($type);
    });

    function findType(type) {
        if (type === '日报') {
            $('#date').val('<?php echo date('Y-m-d') ?>');
            $('#enddt').val('');
            datechange();
        } else {
            $.post('<?php echo spUrl('sales', 'findType'); ?>', {type: type}, function(data) {
                $('#date').val(data.data.start);
                $('#enddt').val(data.data.end);
                $('.yujiphone').html('<input class="FrameGroupInput" type="text" name="yjphone" value="' + data.data.yjphone + '"/>');
                $('.yujiyixiang').html('<input class="FrameGroupInput" type="text" name="yjyixiang" value="' + data.data.yjyixiang + '"/>');
                $('input[name="phone"]').val(data.data.phone);
                $('input[name="yixiang"]').val(data.data.yixiang);
                $('.shiji').show();
                $('.mianjian').hide();
            }, 'json');
        }
    }

    $('#mianjian').change(function() {
        $id = $(this).val();
        if ($id > 0) {
            $name = $('#mianjian option[value="' + $id + '"]').attr('data-name');
            $tel = $('#mianjian option[value="' + $id + '"]').attr('data-tel');
            $address = $('#mianjian option[value="' + $id + '"]').attr('data-address');
            var txt = '<tr class="show1"><td></td><td colspan="3"><input type="hidden" name="mianjian[]" value="' + $id + '"/>' + $name + '，' + $tel + '，' + $address + '</td></tr>';
            $('.show1:last').after(txt);
        }
    });

    function datechange() {
        $.post('<?php echo spUrl($c, $a); ?>', {date: $('#date').val()}, function(data) {
            if (data.status == 1 && $('#type').val() === '日报') {
                $('#id').val(data.data.id);
                $('.yujiphone').html('<input class="FrameGroupInput" type="text" name="yjphone" value=""/>');
                $('.yujiyixiang').html('<input class="FrameGroupInput" type="text" name="yjyixiang" value=""/>');
                $('.shiji').show();
            } else {
                $('#id').val('');
                $('.yujiphone').html('<input class="FrameGroupInput" type="text" name="yjphone" value=""/>');
                $('.yujiyixiang').html('<input class="FrameGroupInput" type="text" name="yjyixiang" value=""/>');
                $('.shiji').hide();
                if ($('#type').val() !== '日报') {
                    $('.xinde').show();
                }
            }
        }, 'json');
    }
    ;
    $('#type').change();
    datechange();

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveDaily"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //loading('none');
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