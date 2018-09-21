<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">通知公告</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">内 审 检 查 表</div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr><th width="50">编号</th><th colspan="4" class="textLeft"><input type="text" name="number" value=""/></th></tr>
                                <tr><th width="50">序号</th><th>检查项目</th><th width="50">标准条款</th><th>检查情况</th><th>判定</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="TabBgBlue textCenter">01</td><td class="pdX10">1．职责、资源是否规定？是否任命质量负责人？有无建立认证标志的管理控制程序？配备资源是否能满足生产需要？</td>
                                    <td class="TabBgBlue textCenter">1.</td><td class="pdX10" style="width: 350px;"><textarea rows="5" name="content[q1-1]"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q1-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="2">02</td><td class="pdX10">1．有无建立《文件控制程序》和《记录控制程序》？</td>
                                    <td class="TabBgBlue textCenter"rowspan="2">2.</td><td class="pdX10"><textarea name="content[q2-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q2-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．有无建立质量计划或类似文件？</td>
                                    <td class="pdX10"><textarea rows="2" name="content[q2-2]"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q2-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="8">03</td><td colspan="4" class="TabBgBlue textCenter">采购和进货检验</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．是否已制定了对关键元器件和材料的供应商选择、评定和日常管理的程序？</td>
                                    <td class="TabBgBlue textCenter"rowspan="7">3.</td><td class="pdX10"><textarea name="content[q3-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q3-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．工厂是否按照文件要求对供应商进行选择、评定和日常管理，并保存对供应商选择和日常管理记录？</td>
                                    <td class="pdX10"><textarea name="content[q3-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-2]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．是否已建立了进货的关键元器件和材料检验/验证程序及定期确认检验的程序？</td>
                                    <td class="pdX10"><textarea name="content[q3-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-3]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">4．工厂是否按照文件要求对供应商的产品进行检验和验证？</td>
                                    <td class="pdX10"><textarea name="content[q3-4]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-4]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">5．记录是否完整有效？</td>
                                    <td class="pdX10"><textarea name="content[q3-5]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-5]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">6．当关键元器件和材料检验由供应商检验时，工厂对供应商是否提出明确的检验要求？</td>
                                    <td class="pdX10"><textarea name="content[q3-6]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-6]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">7．工厂是否保存供应商提供的合格证明及有关检验报告等？</td>
                                    <td class="pdX10"><textarea name="content[q3-7]" rows="2"></textarea></td>
                                    <td class="textCenter"><input name="jieguo[q3-7]" type="text" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="6">04</td><td colspan="4" class="TabBgBlue textCenter">生产过程控制和过程检验</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．如果工序没有文件规定就不能保证质量时，是否制定了工艺作业指导书？</td><td class="TabBgBlue textCenter" rowspan="5">4.</td>
                                    <td class="pdX10"><textarea name="content[q4-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q4-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．工作环境是否满足规定要求（对环境条件有要求时）？</td>
                                    <td class="pdX10"><textarea name="content[q4-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q4-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．是否对适宜的过程参数和产品特性进行监制（可行时）？</td>
                                    <td class="pdX10"><textarea name="content[q4-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q4-3]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">4．是否建立并保持了对生产设备进行维护保养的制度？</td>
                                    <td class="pdX10"><textarea name="content[q4-4]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q4-4]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">5．是否在生产的适当阶段对产品进行检验，确保产品及零部件与认证样品的一致性？</td>
                                    <td class="pdX10"><textarea name="content[q4-5]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q4-5]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="4">05</td><td colspan="4" class="TabBgBlue textCenter">例行检验和确认检验</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．是否制定了文件化的例行检验和确认检验程序？</td><td class="TabBgBlue textCenter" rowspan="3">5.</td>
                                    <td class="pdX10"><textarea name="content[q5-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q5-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．例行检验和确认检验要求是否满足相应产品的认证实施规则要求？</td>
                                    <td class="pdX10"><textarea name="content[q5-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q5-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．是否已按相应的文件正确实施了例行检验和确认检验，并保存检验记录？</td>
                                    <td class="pdX10"><textarea name="content[q5-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q5-3]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="13">06</td><td colspan="4" class="TabBgBlue textCenter">检验试验仪器设备</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．检验试验仪器设备是否与所要求的检验、试验能力一致？</td><td class="TabBgBlue textCenter" rowspan="2">6.</td>
                                    <td class="pdX10"><textarea name="content[q6-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．是否制定检验试验仪器设备的操作规程并按之准确操作？</td>
                                    <td class="pdX10"><textarea name="content[q6-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="TabBgBlue textCenter">校准和检定</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．检验和试验设备是否定期校准或检定并可溯源至国际和国家基准？</td><td class="TabBgBlue textCenter" rowspan="4">6.</td>
                                    <td class="pdX10"><textarea name="content[q6-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-3]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">4．自行校准的检验和试验设备是否规定了校准方法、验收准则和校准周期？</td>
                                    <td class="pdX10"><textarea name="content[q6-4]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-4]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">5．检验和试验设备的校准状态是否能被使用及管理人员方便识别？</td>
                                    <td class="pdX10"><textarea name="content[q6-5]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-5]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">6．是否保存了检验和试验设备的校准记录，并完整有效？</td>
                                    <td class="pdX10"><textarea name="content[q6-6]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-6]" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="TabBgBlue textCenter">功能检查</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">7．对于例行检验和确认检验设备，是否按规定了有效的功能检查要求，并按要求执行？</td><td class="TabBgBlue textCenter" rowspan="4">6.</td>
                                    <td class="pdX10"><textarea name="content[q6-7]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-7]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">8．功能检查结果不能满足规定要求的，是否追溯至已检产品，必要时重新检验？</td>
                                    <td class="pdX10"><textarea name="content[q6-8]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-8]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">9．是否规定了例行检验和确认检验设备功能失效时需采取的措施？</td>
                                    <td class="pdX10"><textarea name="content[q6-9]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-9]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">10．否保存了功能检查结果和调整措施记录？</td>
                                    <td class="pdX10"><textarea name="content[q6-10]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q6-10]" value="不合格"/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="4">07</td><td colspan="4" class="TabBgBlue textCenter">不合格品的控制</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．是否建立了不合格品控制程序，其内容是否符合规定要求？</td>
                                    <td class="TabBgBlue textCenter"rowspan="3">7.</td><td class="pdX10"><textarea name="content[q7-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q7-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．对不合格品的标识，隔离和处置以及采取纠正和预防措施是否符合程序的规定？</td>
                                    <td class="pdX10"><textarea name="content[q7-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q7-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．是否保存了重要部件或组件的返修记录及不合格品的处置记录？</td>
                                    <td class="pdX10"><textarea name="content[q7-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q7-3]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="4">08</td><td colspan="4" class="TabBgBlue textCenter">内部质量审核</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．是否建立并保持了文件化的内部质量审核程序，并记录审核结果；其内容是否符合规定要求？</td>
                                    <td class="TabBgBlue textCenter"rowspan="3">8.</td><td class="pdX10"><textarea name="content[q8-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q8-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．对内审发现的问题是否采取纠正和预防措施并进行记录？</td>
                                    <td class="pdX10"><textarea name="content[q8-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q8-2]" value="合格"/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．对内审发现的问题是否采取纠正和预防措施并进行记录？</td>
                                    <td class="pdX10"><textarea name="content[q8-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q8-3]" value="合格"/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="4">09</td><td colspan="4" class="TabBgBlue textCenter">认证产品的一致性控制</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．是否建立了产品关键元器件和材料、结构等影响产品符合规定要求因素的变更控制程序？是否建立并保持了文件化的内部质量审核程序，并记录审核结果；其内容是否符合规定要求？</td>
                                    <td class="TabBgBlue textCenter"rowspan="3">9.</td><td class="pdX10"><textarea name="content[q9-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q9-1]" value="合格"/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．是否在认证产品变更实施前向认证机构申报并获得批准？</td>
                                    <td class="pdX10"><textarea name="content[q9-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q9-2]" value="合格"/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．核对认证产品的一致性（重点核对铭牌、电流等级、关键元器件）</td>
                                    <td class="pdX10"><textarea name="content[q9-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q9-3]" value="合格"/></td>
                                </tr>
                                <tr>
                                    <td class="TabBgBlue textCenter"rowspan="4">10</td><td colspan="4" class="TabBgBlue textCenter">包装、搬运和贮存</td>
                                </tr>
                                <tr>
                                    <td class="pdX10">1．成品的包装和标志过程（包括所用材料）是否符合规定的要求？</td>
                                    <td class="TabBgBlue textCenter"rowspan="3">10.</td><td class="pdX10"><textarea name="content[q10-1]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q10-1]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">2．所产用的搬运方法是否能防止产品的损坏或变质？</td>
                                    <td class="pdX10"><textarea name="content[q10-2]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q10-2]" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="pdX10">3．产品的贮存环境是否能保证产品符合规定标准要求？</td>
                                    <td class="pdX10"><textarea name="content[q10-3]" rows="2"></textarea></td>
                                    <td class="textCenter"><input type="text" name="jieguo[q10-3]" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="pdX10">
                                        <p>内审总结报告：</p>
                                        <div class="pdX20"><textarea rows="5" name="zongjie"></textarea></div>
                                    </td>
                                </tr>
                            </tbody>
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
                });
</script>
</html>

<script>
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
            url: "<?php echo spUrl($c, "saveNsjc"); ?>",
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