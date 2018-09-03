<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>客户</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">客户</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">客户</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <?php if (empty($result['id'])) { ?>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 客户</td>
                                        <td>
                                            <select class="FrameGroupInput" name="id">
                                                <option value="">-请选择-</option>
                                                <?php foreach ($coustomer as $k => $v) { ?>
                                                    <option <?php echo $v['id'] == $result['custid'] ? 'selected=""' : '' ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <?php } else { ?>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 客户</td>
                                        <td><?php echo $result['custname']; ?></td>
                                    <?php } ?>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 项目类型</td>
                                    <td>
                                        <select class="FrameGroupInput" name="type">
                                            <option value="">-请选择-</option>
                                            <?php foreach ($GLOBALS['SALE_TYPE'] as $k => $v) { ?>
                                                <option <?php echo $k == $result['type'] ? 'selected=""' : '' ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">预计签单概率</td>
                                    <td><input class="FrameGroupInput" type="text" name="rate" value="<?php echo $result['rate']; ?>"/>%</td>
                                    <td class="FrameGroupName"> 预计金额</td>
                                    <td><input class="FrameGroupInput" type="text" name="money" value="<?php echo $result['money']; ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">下次联系时间</td>
                                    <td><input class="FrameGroupInput" id="next" type="text" name="nextdt" value="<?php echo empty($result['nextdt']) ? '' : date('Y-m-d', $result['nextdt']); ?>"/></td>  
                                    <?php if ($result['status'] == 1) { ?>
                                        <td class="FrameGroupName">地址：</td>
                                        <td>
                                            <input class="FrameGroupInput" type="text" name="address" value="" style='width: 99%;' placeholder='第一次完善信息可更改地址'/>
                                        </td>
                                    <?php } else { ?>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">备注</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">相关文件 ：</td>
                                    <td colspan="3">
                                        <ul class="FileBox">
                                            <?php foreach ($result['files'] as $v) { ?>
                                            <li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="DelFile">删除</span></li>
                                        <?php } ?>
                                        </ul>
                                        <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                        <span class="addFile">+添加文件</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <span class="Btn Big" onclick="do_sub()">提交</span>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
    <script type="text/javascript">
            $(function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                window.onresize = function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                };
            });
            $('.addFile').click(function(){
                $(this).prev().click()
            });
    </script>
</html>
<script>
    jeDate({
        dateCell: "#next", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    $(function() {
        $(document).on('change', '.fileToUpload', function() {
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.id + '">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>';
                        $('#' + name).parent().children('.FileBox').append(txt);
                        $('#' + name).val('');
                    } else {
                        $('#' + name).val('');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });

        $(document).on('click', '.download .del', function() {
            $(this).parent('.download').remove();
        });

    });

    function do_sub() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveSales"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>