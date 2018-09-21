<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<!--<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>-->
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">内部审核计划</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <div class="FrameCont">
                    <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title']?></h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <tbody class="">
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20" width="120">审核性质</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <label for="checkbox1">
                                            <span class="radio <?php  echo $result['type']=='例行内部质量审核'?'active':''?>">例行内部质量审核</span>
                                        </label> 
                                        <i class="w-100"></i>
                                        <label for="checkbox2">
                                            <span class="radio <?php  echo $result['type']=='临时内部质量审核'?'active':''?>">临时内部质量审核</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核目的</td>
                                    <td class="pdX10 pdY20" colspan="5"><?php echo $result['mudi'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核范围</td>
                                    <td class="pdX10 pdY20" colspan="5"><?php echo $result['fanwei'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核依据</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <?php echo $result['yiju'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核组成员</td>
                                    <td class="pdX10 pdY20" colspan="5">
                                        <?php echo $result['zu'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核日期</td>
                                    <td class="pdX10 pdY20" colspan="5"><?php echo $result['date'] ?></td>
                                </tr>
                                <tr>
                                    <td rowspan="7" class="textCenter TabBgBlue pdY20">审核安排</td>
                                    <td class="textCenter TabBgBlue pdY20">时间</td>
                                    <td class="textCenter TabBgBlue pdY20">审核部门</td>
                                    <td class="textCenter TabBgBlue pdY20">条款</td>
                                    <td class="textCenter TabBgBlue pdY20">部门负责人</td>
                                    <td class="textCenter TabBgBlue pdY20">审核员</td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][0]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][0]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][0]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][0]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][0]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][1]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][1]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][1]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][1]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][1]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][2]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][2]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][2]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][2]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][2]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][3]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][3]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][3]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][3]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][3]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][4]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][4]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][4]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][4]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][4]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter pdY20"><?php echo $result['anpai'][5]['time'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][5]['dep'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][5]['tiaokuan'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][5]['fuze'] ?></td>
                                    <td class="textCenter"><?php echo $result['anpai'][5]['shenhe'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">备注</td>
                                    <td class="pdX10" colspan="5"><?php echo $result['explain'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue pdY20">审核报告分发时间</td>
                                    <td class="pdX10" colspan="5"><?php echo $result['baogao'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-200">审核组长/日期：</span></p>
                                <div class="UpgrapImg">
                                    <img class="" src="<?php echo $result['uname'] ?>"/>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="FrameTableFoot">
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
    jeDate({
        dateCell: "#dt", //isinitVal:true,
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
            url: "<?php echo spUrl($c, "saveNbshjh"); ?>",
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