<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>工资单</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">工资单</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">工资单</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 日期：</td>
                                    <td><?php echo $result['month']; ?></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 员工：</td>
                                    <td><?php echo $result['uname']; ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">基本工资</td>
                                    <td><input type="text" class="FrameGroupInput" name="jiben" value="<?php echo $result['jiben'] ?>"/></td>
                                    <td class="FrameGroupName">提成</td>
                                    <td><input type="text" class="FrameGroupInput" name="ticheng" value="<?php echo $result['ticheng'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">全勤</td>
                                    <td><input type="text" class="FrameGroupInput" name="quanqin" value="<?php echo $result['quanqin'] ?>"/></td>
                                    <td class="FrameGroupName">奖金</td>
                                    <td><input type="text" class="FrameGroupInput" name="jiangjin" value="<?php echo $result['jiangjin'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">补助</td>
                                    <td><input type="text" class="FrameGroupInput" name="buzhu" value="<?php echo $result['buzhu'] ?>"/></td>
                                    <td class="FrameGroupName">绩效</td>
                                    <td><input type="text" class="FrameGroupInput" name="jixiao" value="<?php echo $result['jixiao'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">处罚</td>
                                    <td><input type="text" class="FrameGroupInput" name="chufa" value="<?php echo $result['chufa'] ?>"/></td>
                                    <td class="FrameGroupName">缺勤</td>
                                    <td><input type="text" class="FrameGroupInput" name="qingjia" value="<?php echo $result['qingjia'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">出勤天数</td>
                                    <td><input type="text" class="FrameGroupInput" name="chuqin" value="<?php echo $result['chuqin'] ?>"/></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">实发</td>
                                    <td colspan="3" id='total'><?php echo $result['total']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <?php if ($result['status'] == 1) { ?>
                    <a class="Btn Big" onclick="fafang()">已发</a>
                    <a class="Btn Big" onclick="do_sub()"><?php echo empty($result['id']) ? '提交' : '更新'; ?></a>
                <?php } ?>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>

    <script>

                        $(function() {
                            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                            window.onresize = function() {
                                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                            };
                        });

                        $(function() {
                            $('.FrameTableCont input').keyup(function() {
                                var total = $('.FrameTableCont  input[name="jiben"]').val() * 1 + $('.FrameTableCont  input[name="ticheng"]').val() * 1 + $('.FrameTableCont  input[name="quanqin"]').val() * 1 + $('.FrameTableCont  input[name="jiangjin"]').val() * 1 + $('.FrameTableCont  input[name="buzhu"]').val() * 1 + $('.FrameTableCont  input[name="jixiao"]').val() * 1 - $('.FrameTableCont  input[name="chufa"]').val() * 1 - $('.FrameTableCont  input[name="qingjia"]').val() * 1
                                $('#total').text(total.toFixed(2));
                            })
                        });

                        function fafang() {
                            loading();
                            $.ajax({
                                cache: false,
                                type: "POST",
                                url: "<?php echo spUrl($c, "grantPayroll"); ?>",
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
                                        parent.window.closHtml();
                                        Refresh();
                                    } else {
                                        Alert(data.msg);
                                        loading('none');
                                    }

                                }
                            });
                        }

                        function do_sub() {
                            loading();
                            $.ajax({
                                cache: false,
                                type: "POST",
                                url: "<?php echo spUrl($c, "savePayroll"); ?>",
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
                                        parent.window.closHtml();
                                        Refresh();
                                    } else {
                                        Alert(data.msg);
                                        loading('none');
                                    }

                                }
                            });
                        }
    </script>