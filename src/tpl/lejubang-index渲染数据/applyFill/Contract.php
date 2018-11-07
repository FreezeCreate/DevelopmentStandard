<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>合同管理</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/apply.css" />
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="content" style="width: 800px;">
            <div class="ptitle">合同管理</div>
            <div class="info">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <table class="table01">
                        <tbody>
                            <tr>
                                <td>签订人</td>
                                <td><input class="form-control notenter" type="text" value="<?php echo $admin['name']; ?>"/></td>
                                <td><span style="color:red;">*</span> 签订时间</td>
                                <td><input class="form-control" type="text" readonly="true" id="date" name="date" value="<?php echo empty($result['date']) ? date('Y-m-d') : $result['date'] ?>"/></td>
                            </tr>
                            <tr>
                                <td><span style="color:red;">*</span> 合同类型</td>
                                <td><select class="form-control" name="type">
                                        <?php foreach($GLOBALS['PROCONTRACT_TYPE'] as $k=>$v){?>
                                        <option <?php echo $result['type']===$v?'selected=""':''?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                        <?php }?>
                                    </select></td>
                                <td><span style="color:red;">*</span> 合同金额</td>
                                <td><input class="form-control" type="text" name="money" value="<?php echo $result['money']; ?>"/>万元</td>
                            </tr>
                            <tr>
                                <td><span style="color:red;">*</span> 合同名称</td>
                                <td colspan="3"><input class="form-control" style="width: 90%;" type="text" name="name" value="<?php echo $result['name']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>甲方单位</td>
                                <td colspan="3"><input class="form-control" style="width: 90%;" type="text" name="partyA" value="<?php echo $result['partyA']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>开始时间</td>
                                <td><input class="form-control" type="text" readonly="true" id="start" name="start" value="<?php echo empty($result['start']) ? '' : $result['start'] ?>"/></td>
                                <td>结束时间</td>
                                <td><input class="form-control" type="text" readonly="true" id="end" name="end" value="<?php echo empty($result['end']) ? '': $result['end'] ?>"/></td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td colspan="3"><textarea class="form-control" name="remark"><?php echo $result['remark'] ?></textarea></td>
                            </tr>
                            <tr>
                                <td>相关文件</td>
                                <td colspan="3">
                                    <?php foreach ($result['files'] as $v) { ?>
                                        <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="del">删除</span></div>
                                    <?php } ?>
                                    <input class="fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="center">
                        <a class="but but-primary" onclick="do_sub()">提交</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>
    </body>

</html>

<script>
    jeDate({
        dateCell: "#date", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#start", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#end", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });

    $(function() {
        $(document).on('change', '.fileToUpload', function() {
            loading();
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    loading('none');
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
                        loading('none');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });

    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveContract"); ?>",
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
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>