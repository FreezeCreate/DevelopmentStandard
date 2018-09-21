<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <!--<span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>-->
                </div>
                <form id="do_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp">
                            <thead>
                                <tr>
                                    <th>文件编号</th>
                                    <th colspan="6"><input class="textLeft" <?php echo empty($result['number']) ? '' : 'readonly="true"' ?> name="number" type="text" value="<?php echo $result['number'] ?>"/></th>
                                </tr>
                            </thead>
                            <tbody class="TabBg add">
                                <tr>
                                    <td class="textCenter">受审核部门</td>
                                    <td>
                                        <select class="FrameGroupInput" name="dname">
                                            <option value="">--请选择--</option>
                                            <?php foreach($dep as $k=>$v){?>
                                            <option value="<?php echo $v['name']?>"><?php echo $v['name']?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td class="textCenter">受审核地点</td>
                                    <td>
                                        <input type="text" name="address" value="" />
                                    </td>
                                    <td class="textCenter">审核日期</td>
                                    <td>
                                        <input type="text" readonly="true" id="dt" name="dt" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter">不合格事实描述</td>
                                    <td colspan="5" class="pdX20">
                                        <textarea rows="2" name="miaoshu"><?php echo $result['miaoshu']?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter">不合格事实条款</td><td colspan="5" class="pdX10"><input type="text" name="tiaokuan" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter">不合格程度</td>
                                    <td colspan="5" class="pdX10">
                                        <label><span class="radio">严重</span><input class="None" type="radio" name="chengdu" value="1" /></label>
                                        <i class="w-50"></i>
                                        <label><span class="radio">一般</span><input class="None" type="radio" name="chengdu"  value="2" /></label>
                                        <i class="w-50"></i>
                                        <label><span class="radio">观察项</span><input  class="None" type="radio" name="chengdu" value="3" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textLeft" colspan="7">
                                        <div class="UpgrapImg" onclick="$('#fileToUploadQm').click()">审核员：
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="uname" value="<?php echo empty($result['zeren']) ? $admin['qianming']:$result['zeren']; ?>"/>
                                        </div>
                                        <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                    </td>
                                </tr>
                            </tbody>
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
        dateCell: "#dt", //isinitVal:true,
        format: "YYYY/MM/DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
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
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveFailed'); ?>",
            data: $('#do_form').serialize(),
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
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('apply', "saveCheck"); ?>",
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
</html>


