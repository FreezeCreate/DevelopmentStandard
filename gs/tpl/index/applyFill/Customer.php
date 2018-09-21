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
                                <td class="FrameGroupName"><span style="color:red;">*</span> 客户名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name']; ?>" /></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 来源</td>
                                <td>
                                    <select class="FrameGroupInput" name="laiyuan">
                                        <option value="">-请选择-</option>
                                        <?php foreach($GLOBALS['CUST_LAIYUAN'] as $k=>$v){?>
                                        <option <?php echo $k==$result['laiyuan']?'selected=""':''?> value="<?php echo $k;?>"><?php echo $v;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 客户单位</td>
                                <td colspan='3'><input class="FrameGroupInput" type="text" name="unitname" style='width:90%'  value="<?php echo $result['unitname']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 客户类型</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">-请选择-</option>
                                        <?php foreach($GLOBALS['CUST_TYPE'] as $k=>$v){?>
                                        <option <?php echo $k==$result['type']?'selected=""':''?> value="<?php echo $k;?>"><?php echo $v;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="FrameGroupName">职位</td>
                                <td>
                                    <select class="FrameGroupInput" name="position">
                                        <option value="">-请选择-</option>
                                        <?php foreach($GLOBALS['CUST_POSIT'] as $k=>$v){?>
                                        <option <?php echo $k==$result['position']?'selected=""':''?> value="<?php echo $k;?>"><?php echo $v;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span>联系手机</td>
                                <td><input class="FrameGroupInput" type="text" name="mobile" value="<?php echo $result['mobile']; ?>"/></td>
                                <td class="FrameGroupName">联系座机</td>
                                <td><input class="FrameGroupInput" type="text" name="tel" value="<?php echo $result['tel']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 地址</td>
                                <td colspan="3"><input class="FrameGroupInput" style="width: 90%;" type="text" name="address" value="<?php echo $result['address']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span>交通路线</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="routeline"><?php echo $result['routeline'] ?></textarea></td>
                            </tr>
                             <tr>
                                <td class="FrameGroupName">邮箱</td>
                                <td colspan="3"><input class="FrameGroupInput" style="width: 90%;" type="text" name="email" value="<?php echo $result['email']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                           
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 是否标★</td>
                                <td>
                                    <select class="FrameGroupInput" name="isstat">
                                        <option value="">-请选择-</option>
                                        <option <?php echo 0==$result['isstat']?'selected=""':''?> value="0">否</option>
                                        <option <?php echo 1==$result['isstat']?'selected=""':''?> value="1">是</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
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
    <script type="text/javascript">
        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            };
        });
    </script>
</html>
<script>
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
                        var txt = '<div class="download"><a class="download-a" itemid="' + data.data.id + '" href="javascript:void(0)">' + data.data.filename + '</a><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="del">删除</span></div>';
                        $('#' + name).val('');
                        $('#' + name).before(txt);
                        loading('none');
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
            url: "<?php echo spUrl($c, "saveCustomer"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                     
                    Refresh();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>