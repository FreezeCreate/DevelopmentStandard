<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript">
    var Cust;
    $.get('<?php echo spUrl('main', "findCustomer"); ?>', {}, function(data) {
        Cust = data;
    }, 'json');
</script>
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
                        <table class="FrameTableCont">
                        <tr>
                        
                    <?php 
                        if (empty($result)){ echo '<td class="FrameGroupName">订单选择： </td>';?>
                        <td colspan="3"><select name="oid" class="FrameGroupInput">
                        <?php 
                            foreach ($all_orders as $ak => $av){
                                echo '<option value="'.$av['id'].'">'.$av['name'].'</option>';
                            }
                        ?>
</select>
                      <?php   }
                    
                    ?>
                    </td>
                        </tr>
                            <tr>
                                <td class="FrameGroupName">合同编号</td>
                                <td><input class="FrameGroupInput" type="text" readonly="true" value="<?php echo $result['number'] ?>" placeholder="自动生成"/></td>
                                <td class="FrameGroupName">合同名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">生效日期</td>
                                <td><input class="FrameGroupInput" id="startdt" type="text" name="startdt" value="<?php echo $result['startdt'] ?>"/></td>
                                <td class="FrameGroupName">截止日期</td>
                                <td><input class="FrameGroupInput" id="enddt" type="text" name="enddt" value="<?php echo $result['enddt'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">签约日期</td>
                                <td><input class="FrameGroupInput" id="signdt" type="text" name="signdt" value="<?php echo $result['signdt'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">客户名称</td>
                                <td><input class="FrameGroupInput uname" type="text" name="cname" value="<?php echo $result['cname'] ?>"/>
                                <a class="Btn Btn-blue" onclick="ChousPerson(Cust, 'one', '.uname', '.uid', this,findCname)">选择</a>
                                </td>
                                
                                <td class="FrameGroupName">联系电话</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $result['phone'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">合同金额</td>
                                <td><input class="FrameGroupInput" type="text" name="money" value="<?php echo $result['money'] ?>" /></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注：</td>
                                <td colspan="7">
                                    <textarea class="FrameGroupInput Lang" name="explain"><?php echo $result['explain'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">相关文件</td>
                                <td colspan="7">
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
        dateCell: "#startdt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    jeDate({
        dateCell: "#enddt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    jeDate({
        dateCell: "#signdt", //isinitVal:true,
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
        $('.addFile').click(function() {
            $(this).prev().click();
        });
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


    });
    function findCname(e){
        $.get('<?php echo spUrl($c,'findCust')?>',{id:e},function(re){
            if(re.status==1){
                $('input[name="phone"]').val(re.data.phone);
                $('input[name="address"]').val(re.data.address);
            }
        },'json');
    }
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveContract'); ?>",
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


