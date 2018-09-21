<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
    .Table td, .Table th { min-width: 10px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">年度培训计划</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="年度培训计划表" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight" colspan="2">编号</td>
                                    <td class="pdX10  textLeft" colspan="17">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">序号</th><th rowspan="2">部门</th><th rowspan="2">培训课程内容</th><th rowspan="2">参加对象</th>
                                    <th colspan="2">培训方式</th><th colspan="12">计 划 实 施 月 份</th><th rowspan="2" style="width:80px;">备注</th>
                                </tr>
                                <tr>
                                    <th>内训</th><th>外训</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th>
                                    <th>8</th><th>9</th><th>10</th><th>11</th><th>12</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg TabInp textCenter add">
                                <tr>
                                    <td>1</td><td><input type="text" name="dep[1]" value=""/></td><td><input type="text" name="content[1]" value=""/></td>
                                    <td><input type="text" name="duixiang[1]" value=""/></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="内训"name="type[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="外训"name="type[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="1"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="2"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="3"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="4"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="5"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="6"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="7"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="8"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="9"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="10"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="11"name="month[1]" /></label></td>
                                    <td><label><span class="radio no"></span><input type="radio"class="None"value="12"name="month[1]" /></label></td>
                                    <td><input type="text" name="explain[1]" /></td>
                                </tr>
                            </tbody>
                            <tfoot class="textCenter">
                                <tr>
                                    <td></td><td></td><td><span class="TabAdd"></span></td><td></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td>
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
                                '<tr><td>' + index + '</td><td><input type="text" name="dep[' + index + ']" value=""/></td><td><input type="text" name="content[' + index + ']" value=""/></td>'
                                +'    <td><input type="text" name="duixiang[' + index + ']" value=""/></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="内训"name="type[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="外训"name="type[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="1"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="2"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="3"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="4"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="5"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="6"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="7"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="8"name="month[' + index + ']" /></label></td>'
                                +'    <td><label><span class="radio no"></span><input type="radio"class="None"value="9"name="month[' + index + ']" /></label></td>'
                                 +'   <td><label><span class="radio no"></span><input type="radio"class="None"value="10"name="month[' + index + ']" /></label></td>'
                                 +'   <td><label><span class="radio no"></span><input type="radio"class="None"value="11"name="month[' + index + ']" /></label></td>'
                                 +'   <td><label><span class="radio no"></span><input type="radio"class="None"value="12"name="month[' + index + ']" /></label></td>'
                                 +'   <td><input type="text" name="explain[' + index + ']" /></td>>'
                                )
                    })
                });
</script>
</html>

<script>
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY/MM/DD",
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
            url: "<?php echo spUrl($c, "saveNdpxjh"); ?>",
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