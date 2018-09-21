<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript">
    var Use;
    var Pos;
    var Dep;
    var Cust;
    $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
        Use = {}
        Use.status = 2;
        Use.data = data.data[0].children;
    }, 'json');
    //职位
//    $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//        Pos = data;
//    }, 'json');
//    //部门
//    $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//        Dep = data;
//    }, 'json');
    $.get('<?php echo spUrl('main', "findCustomer"); ?>', {}, function(data) {
        Cust = data;
    }, 'json');
</script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">订单编号</td>
                                <td><input class="FrameGroupInput" type="text" readonly="true" value="<?php echo $result['number'] ?>" placeholder="自动生成"/></td>
                                <td class="FrameGroupName">订单名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">客户</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="cname" placeholder="" value="<?php echo $result['cname'] ?>"/>
                                    <input type="hidden" class="uid" name="cid" value="<?php echo $result['cid'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Cust, 'one', '.uname', '.uid', this,findCname)">选择</a>
                                </td>
                                <td class="FrameGroupName">销售人员</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" readonly="true" name="uname" placeholder="" value="<?php echo empty($result['uname']) ? $admin['name'] : $result['uname'] ?>"/>
                                    <input type="hidden" class="uid" name="uid" value="<?php echo empty($result['uid']) ? $admin['id'] : $result['uid'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">客户电话</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $result['phone'] ?>"/></td>
                                <td class="FrameGroupName">地区</td>
                                <td><input class="FrameGroupInput" type="text" name="address" value="<?php echo $result['address'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">说明</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">相关文件</td>
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
                    </form>
                </div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
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
            url: "<?php echo spUrl($c, 'saveOrders'); ?>",
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

