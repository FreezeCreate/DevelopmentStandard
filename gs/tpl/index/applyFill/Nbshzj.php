<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">内部审核计划</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <table class="Table TabBg TabInp">
                            <tbody class="">
                                <tr><td colspan="6" class="textCenter pdY10"><input type="text" name="title" value="" placeholder="内部审核计划"/></td></tr>
                                <tr>
                                    <td class="textCenter pdY20">编号</td><td colspan="5"class="pdX10"><input type="text" name="number" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20" width="120">审核性质</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <label for="checkbox1">
                                            <span class="radio active">例行内部质量审核</span>
                                            <input class="None" type="radio" id="checkbox1" name="type" value="例行内部质量审核"/>
                                        </label> 
                                        <i class="w-100"></i>
                                        <label for="checkbox2">
                                            <span class="radio">临时内部质量审核</span>
                                            <input class="None" type="radio" id="checkbox2" name="type" value="临时内部质量审核"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核目的</td><td class="pdX10 pdY20" colspan="5"><input type="text" name="mudi" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核范围</td><td class="pdX10 pdY20" colspan="5"><input type="text" name="fanwei" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核依据</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <textarea rows="4" name="yiju"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核组成员</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <textarea rows="4" name="zu"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核日期</td>
                                    <td class="pdX10 pdY20" colspan="5"><input type="text" name="date" id="date" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">不合格项综述</td>
                                    <td colspan="4" class="pdX10 pdY20">
                                        <textarea rows="3" name="zongshu"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核结论</td>
                                    <td colspan="4" class="pdX10 pdY20">
                                        <textarea rows="3" name="jielun"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核报告分发</td>
                                    <td colspan="4" class="pdX10 pdY20">
                                        <textarea rows="3" name="baogao"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">附件情况</td>
                                    <td colspan="4" class="pdX10 pdY20">
                                        <textarea rows="3" name="fujian"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-200">审核组长/日期：</span></p>
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
                });
</script>
</html>

<script>
    jeDate({
        dateCell: "#date", //isinitVal:true,
        format: "YYYY年MM月DD",
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
            url: "<?php echo spUrl($c, "saveNbshzj"); ?>",
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