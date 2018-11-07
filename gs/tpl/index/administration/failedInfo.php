<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    label { margin-right: 60px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <div class="top20"id="print">
                    <h3 style="text-align:center; font-size: 18px; line-height: 60px;">不  合  格  项  报  告</h3>
                    <div class="TableHead" style="border:0;">
                        <span class="TableHeadRightTex">不合格项报告编号 ：<?php echo $result['number'] ?></span>
                    </div>
                    <table class="Table  TabBg TabInp">
                        <tbody>
                            <tr class="textCenter">
                                <td>受审核部门</td>
                                <td><?php echo $result['dname'] ?></td>
                                <td>受审核地点</td>
                                <td><?php echo $result['address'] ?></td>
                                <td>审核日期</td>
                                <td><?php echo $result['dt'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="6"class="pdX20">
                                    <p>不合格事实描述：</p>
                                    <div class="pdX20 pdY20">
                                        <?php echo $result['miaoshu'] ?>
                                    </div>
                                    <p class="pdY10">不符合条款号：<?php echo $result['tiaokuan'] ?></p>
                                    <p class="pdY10">
                                        不合格程度：
                                        <label><span class="radio <?php echo $result['chengdu'] == 1 ? 'active' : '' ?>">严重</span></label>
                                        <label><span class="radio <?php echo $result['chengdu'] == 2 ? 'active' : '' ?>">一般</span></label>
                                        <label><span class="radio <?php echo $result['chengdu'] == 3 ? 'active' : '' ?>">观察项</span></label>
                                    </p>
                                    <div class="pdX20 textRight">
                                        <label class="float-left">审核员： <img class="" src="<?php echo $result['uname'] ?>"/></label>
                                        <label>负责人确认： 
                                            <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 3) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"class="pdX20">
                                    <p>原因分析：</p>
                                    <div class="pdX20 pdY20" style="height:80px;">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 4) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                    </div>
                                    <div class="pdX20 textRight">
                                        <label>负责人： 
                                            <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 4) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"class="pdX20">
                                    <p>纠正措施：</p>
                                    <div class="pdX20 pdY20" style="height:80px;">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 5) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                    </div>
                                    <div class="pdX20 textRight">
                                        <label>负责人： 
                                            <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 5) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"class="pdX20">
                                    <p>纠正措施验证：</p>
                                    <div class="pdX20 pdY20" style="height:80px;">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 7) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                    </div>
                                    <div class="pdX20 textRight">
                                        <label>验证人： 
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 7) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?></label>
                                        <label>验证时间： 
                                            <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 6) { ?>
                                                <?php echo date('Y/m/d',strtotime($v['optdt'])) ?>
                                            
                                            <?php $s = 6;break;} ?>
                                            <?php if ($v['status'] == 7) { ?>
                                                <?php echo date('Y/m/d',strtotime($v['optdt'])) ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"class="pdX20">
                                    <p>无效纠正措施的纠正和再验证：</p>
                                    <div class="pdX20 pdY20" style="height:80px;">
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 7&&$s = 6) { ?>
                                                <?php echo $v['explain'] ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?>
                                    </div>
                                    <div class="pdX20 textRight">
                                        <label>验证人： 
                                            <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 7&&$s = 6) { ?>
                                                <img src="<?php echo $v['sign'] ?>">
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?></label>
                                        <label>验证时间： 
                                        <?php foreach (array_reverse($log) as $k => $v) { ?>
                                            <?php if ($v['status'] == 7&&$s = 6) { ?>
                                                <?php echo date('Y/m/d',strtotime($v['optdt'])) ?>
                                            <?php break;} ?>
                                            <?php if ($v['status'] == 1) { break;}?>
                                        <?php } ?></label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                    <div class="FrameListTable">
                        <p class="FrameListTableTit">审核处理</p>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table  class="FrameTableCont">
                                <thead>
                                    <tr>
                                        <td class="FrameGroupName">状态：</td>
                                        <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="FrameGroupName">处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人签字：</td>
                                        <td>
                                            <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                                <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                                <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                            </div>
                                            <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                        </td>
                                    </tr>
                                    <?php $explain = array(1 => '说明', 3 => '原因分析', 4 => '纠正措施', 5 => '纠正措施验证', 6 => '无效纠正措施的纠正和再验证') ?>
                                    <tr>
                                        <td class="FrameGroupName"><?php echo $explain[$result['status']] ?>：</td>
                                        <td><textarea class="FrameGroupInput" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="Btn Btn-blue" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                <?php } ?>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
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
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('apply', "saveCheck",array('sid'=>7)); ?>",
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


