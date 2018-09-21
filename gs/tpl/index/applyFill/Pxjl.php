<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">培训记录</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="培训记录" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">编号</td>
                                    <td class="pdX10  textLeft" colspan="5">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textRight">培训时间</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <input type="text" class="dt" name="date" value="" />
                                    </td>
                                    <td class="textRight">讲师</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <input type="text" name="lector" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>主题</th><th colspan="4"class="textLeft pdX10"><input type="text" name="theme" value="" /></th>
                                </tr>
                                <tr>
                                    <th>姓名</th><th>部门</th><th>签到</th><th>考核方式</th><th>考核结果</th>
                                </tr>
                            </thead>
                            <tbody class="add">
                                <tr>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="dep[]" value="" /></td>
                                    <td class=""><input type="text" name="diandao[]" value="" /></td>
                                    <td class=""><input type="text" name="type[]" value="" /></td>
                                    <td class=""><input type="text" name="result[]" value="" /></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td><span class="TabAdd"></span></td><td></td><td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">检查人/日期：</span></p>
                                <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                    <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                    <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                </div>
                                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
        </div>
    </div>
</body>
<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript">
                $(function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    window.onresize = function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    };
                    $('.TabAdd').click(function() {
                        var index = $('.add').children().length + 1
                        $('.add').append(
                                '<tr><td class=""><input type="text" name="name[]" value="" /></td>'
                                 +' <td class=""><input type="text" name="dep[]" value="" /></td>'
                                 +'   <td class=""><input type="text" name="diandao[]" value="" /></td>'
                                 +'   <td class=""><input type="text" name="type[]" value="" /></td>'
                                 +'  <td class=""><input type="text" name="result[]" value="" /></td>'
                                )
                    })
                });
</script>
</html>

<script>
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm',
            dataType: 'json',
            data: {name: 'fileToUploadQm', id: 'fileToUploadQm'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.UpgrapImg img').attr('src', data.src);
                    $('.UpgrapImg input').val(data.src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savePxjl"); ?>",
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