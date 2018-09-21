<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">顾客反馈处理</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="顾客反馈处理" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">编号</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="TabBg TabInp">
                                <tr>
                                    <td width="200" class="textCenter TabBgBlue">顾客名称</td><td class="pdX10"><input type="text" name="name" value="" /></td>
                                    <td width="200" class="textCenter TabBgBlue">反馈时间</td><td class="pdX10"><input type="text" name="fkdt" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">产品名称</td><td class="pdX10"><input type="text" name="cpname" value="" /></td>
                                    <td class="textCenter TabBgBlue">订单号</td><td class="pdX10"><input type="text" name="onumber" value="" /></td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>投诉内容（简略）：</p>
                                        <div class="pdX20"><textarea rows="3" name="content"></textarea></div>
                                        <div class="over pdX20">
                                            <div class="float-right" style="line-height:50px;">接获人： <div class="UpgrapImg float-right" onclick="$('#fileToUploadQm').click();">
                                                    <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                                    <input type="hidden" name="cname" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                                </div>
                                                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>原因分析：</p>
                                        <div class="pdX20"><textarea rows="3" name="case"></textarea></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                责任部门： 
                                                <input class="FrameGroupInput" type="text" name="cdep" value="" placeholder="部门名称"/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>投诉最终解决处理方案：</p>
                                        <div class="pdX20"><textarea rows="3" name="jiejue"></textarea></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                负责部门： 
                                                <input class="FrameGroupInput" type="text" name="jdep" value="" placeholder="部门名称"/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pdX20"colspan="4">
                                        是否需要采取纠正、预防、巩固措施？
                                        <i class="w-100"></i>
                                        <label><span class="radio">是</span><input type="radio" value="" name="need"class="None"/></label>
                                        <i class="w-50"></i>
                                        <label><span class="radio">否</span><input type="radio" value="" name="need"class="None"/></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>
                                            <label><span class="radio">纠正</span><input type="radio" value="1" name="cstype"class="None" /></label>
                                            <label><span class="radio">预防</span><input type="radio" value="2" name="cstype"class="None" /></label>
                                            <label><span class="radio">巩固</span><input type="radio" value="3" name="cstype"class="None" /></label>
                                            措施：
                                        </p>
                                        <div class="pdX20"><textarea rows="3" name="cuoshi"></textarea></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                <label>
                                                    责任部门： 
                                                    <input class="FrameGroupInput" type="text" name="csdep" value="" placeholder="部门名称"/>
                                                </label>
                                                <label>
                                                    质量负责人： 
                                                    <input class="FrameGroupInput" type="text" name="csname" value="" placeholder="质量负责人"/>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>顾客意见和验证跟踪：</p>
                                        <div class="pdX20"><textarea rows="3" name="yygz"></textarea></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                <label style="display:inline-block; float: left;line-height: 50px;">
                                                    记录人： 
                                                    <div class="UpgrapImg float-right">
                                                        <img class="" src="<?php echo empty($result['jluser']) ? SOURCE_PATH . '/images/qianming.png' : $result['jluser']; ?>"/>
                                                        <input type="hidden" name="jluser" value="<?php echo empty($result['jluser']) ? '' : $result['jluser']; ?>"/>
                                                    </div>
                                                </label>
                                                <label style="display:inline-block; float: left; line-height: 50px;">
                                                    验证人： 
                                                    <div class="UpgrapImg float-right">
                                                        <img class="" src="<?php echo empty($result['yyuser']) ? SOURCE_PATH . '/images/qianming.png' : $result['yyuser']; ?>"/>
                                                        <input type="hidden" name="yyuser" value="<?php echo empty($result['yyuser']) ? '' : $result['yyuser']; ?>"/>
                                                    </div>
                                                </label>
                                                <label style="display:inline-block; float: left; line-height: 50px;">
                                                    验证时间： 
                                                    <input type="text" name="yydt" value=""class="FrameGroupInput dt"/>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">附件</td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
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
                var UpgrapImg;
                $(function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    window.onresize = function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    };
                    $('.addFile').click(function() {
                        $(this).prev().click();
                    });
                    $(document).on('click', '.UpgrapImg', function() {
                        UpgrapImg = $(this);
                        $('#fileToUploadQm').click();
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
</script>
</html>

<script>
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY.MM.DD",
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
                    UpgrapImg.children('img').attr('src', data.src);
                    UpgrapImg.children('input').val(data.src);
                    $('#fileToUploadQm').val('');
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
            url: "<?php echo spUrl($c, "saveFankui"); ?>",
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