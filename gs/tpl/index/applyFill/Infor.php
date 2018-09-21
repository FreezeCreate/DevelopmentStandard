<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">通知公告</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">通知公告</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 标题</td>
                                    <td colspan="3"><input class="FrameGroupInput" style="width: 80%;" type="text" name="title" value="<?php echo $result['title'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">发送部门</td>
                                    <td colspan="3">
                                        <input type="hidden" class="did" name="receid" value="<?php echo $result['receid'] ?>"/>
                                        <input class="FrameGroupInput dname" style="width: 80%;" type="text" name="recename" placeholder="不选默认发给全部部门"/>
                                        <a class="Btn Btn-blue" onclick="ChousPerson(Dep, 'two', '.dname', '.did', this)">选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 公告类型</td>
                                    <td><select class="FrameGroupInput" id="type" name="type">
                                            <option <?php echo $result['type'] === '通知公告' ? 'selected=""' : ''; ?> value="通知公告">通知公告</option>
                                            <option <?php echo $result['type'] === '规章制度' ? 'selected=""' : ''; ?> value="规章制度">规章制度</option>
                                            <option <?php echo $result['type'] === '奖惩' ? 'selected=""' : ''; ?> value="奖惩">奖惩</option>
                                        </select></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 来源</td>
                                    <td><input class="FrameGroupInput" type="text" name="zuozhe" value="<?php echo empty($result['zuozhe'])?$admin['dname']:$result['zuozhe']; ?>"/></td>
                                    <td class="FrameGroupName">时间</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="date" name="date" value="<?php echo empty($result['date'])?date('Y-m-d'):$result['date'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">公告内容</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="content"><?php echo $result['content'] ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <span class="Succ" onclick="do_sub()">提交</span>
            </div>
        </div>
        <div class="Tan Person more" id="Department">
            <div class="TanBox PersonBox ">
                <div class="PersonTit">请选择<span class="close OtPop"data-BoxId="Department"></span></div>
                <div class="PersonCont">
                    <div class="PersonScroll">
                    </div>
                </div>
                <div class="PersonFoot">
                    <span class="Btn Big" onclick="getDepartment()">确认</span>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript">
//        var Use;
//        var Pos;
        var Dep;
//        $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
//        Use = {}
//            Use.status = 2;
//                    Use.data = data.data[0].children;
//            }, 'json');
            //职位
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
            //部门
            $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
                    Dep = data;
            }, 'json');
        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            };
        });
    </script>
</html>

<script>

    KindEditor.ready(function(K) {
        K.create('textarea[name="content"]', {
            width: 500,
            autoHeightMode: true,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            afterCreate: function() {
            },
            afterBlur: function() {
                this.sync()
            },
        });
    });

    jeDate({
        dateCell: "#date", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveInfor"); ?>",
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
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
</script>