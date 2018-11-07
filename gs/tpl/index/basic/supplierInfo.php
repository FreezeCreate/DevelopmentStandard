<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<style>
    .FrameTableCont td { line-height: 40px; font-size: 16px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">详情</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <div class="FrameTable" id="print">
                    <h3 style="text-align:center; font-size: 18px; line-height: 60px;">供应商评审表</h3>
                    <table class="FrameTableCont">
                        <tr>
                            <td class="FrameGroupName" width="20%">供应商名称：</td>
                            <td class="" width="30%"><?php echo $result['company'] ?></td>
                            <td class="FrameGroupName" width="20%">地址：</td>
                            <td class=""width="30%"><?php echo $result['address'] ?></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">联系人：</td>
                            <td><?php echo $result['name'] ?></td>
                            <td class="FrameGroupName">联系电话：</td>
                            <td><?php echo $result['phone'] ?></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">供货类别：</td>
                            <td><?php echo $result['goodstype'] ?></td>
                            <td class="FrameGroupName"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="2">是否有工商营业制造和其他合法证明</td>
                            <td colspan="2"class="pdX10">
                                <label for="checkbox1">
                                    <span class="radio <?php echo $result['hfzm'] == 1 ? 'active' : ''; ?>">有</span>
                                </label> 
                                <i class="w-50"></i>
                                <label for="checkbox2">
                                    <span class="radio <?php echo $result['hfzm'] == 0 ? 'active' : ''; ?>">没有</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="2">质量情况</td>
                            <td colspan="2" class="pdX10">
                                <label for="zl1">
                                    <span class="radio <?php echo $result['zlqk'] == 1 ? 'active' : ''; ?>">强</span>
                                </label> 
                                <i class="w-50"></i>
                                <label for="zl2">
                                    <span class="radio <?php echo $result['zlqk'] == 2 ? 'active' : ''; ?>">一般</span>
                                </label>
                                <i class="w-50"></i>
                                <label for="zl3">
                                    <span class="radio <?php echo $result['zlqk'] == 3 ? 'active' : ''; ?>">弱</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="2">产品价格和服务</td>
                            <td colspan="2" class="pdX10">
                                <label for="fw1">
                                    <span class="radio <?php echo $result['jgfw'] == 1 ? 'active' : ''; ?>">好</span>
                                </label> 
                                <i class="w-50"></i>
                                <label for="fw2">
                                    <span class="radio <?php echo $result['jgfw'] == 2 ? 'active' : ''; ?>">一般</span>
                                </label>
                                <i class="w-50"></i>
                                <label for="fw3">
                                    <span class="radio <?php echo $result['jgfw'] == 3 ? 'active' : ''; ?>">差</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="2">产品相关资质</td>
                            <td colspan="2" class="pdX10">
                                <label for="zz1">
                                    <span class="radio <?php echo $result['xgzz'] == 1 ? 'active' : ''; ?>">有</span>
                                </label> 
                                <i class="w-50"></i>
                                <label for="zz2">
                                    <span class="radio <?php echo $result['xgzz'] == 0 ? 'active' : ''; ?>">没有</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="2">社会信誉是否良好</td>
                            <td colspan="2" class="pdX10">
                                <label for="xy1">
                                    <span class="radio <?php echo $result['shxy'] == 1 ? 'active' : ''; ?>">好</span>
                                </label> 
                                <i class="w-50"></i>
                                <label for="xy2">
                                    <span class="radio <?php echo $result['shxy'] == 2 ? 'active' : ''; ?>">一般</span>
                                </label>
                                <i class="w-50"></i>
                                <label for="xy3">
                                    <span class="radio <?php echo $result['shxy'] == 3 ? 'active' : ''; ?>">差</span>
                                </label>
                            </td>
                        </tr>
                    </table>
                    <table class="FrameTableCont">
                        <tr>
                            <td rowspan="5" class="textCenter">评定建议</td>
                            <td class="textCenter" rowspan="2">参加评定部门</td>
                            <td class="textCenter" colspan="2">是否作为合格供方</td>
                            <td class="textCenter" rowspan="2">签名</td>
                        </tr>
                        <tr>
                            <td class="textCenter">同意</td>
                            <td class="textCenter">不同意</td>
                        </tr>
                        <tr>
                            <td class="textCenter">采购部</td>
                            <td class="textCenter"><?php echo $result['cgst'] == 1 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo $result['cgst'] == 2 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo empty($result['cgname']) ? '' : '<img src="' . $result['cgname'] . '"/>' ?></td>
                        </tr>
                        <tr>
                            <td class="textCenter">质检部</td>
                            <td class="textCenter"><?php echo $result['zjst'] == 1 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo $result['zjst'] == 2 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo empty($result['zjname']) ? '' : '<img src="' . $result['zjname'] . '"/>' ?></td>
                        </tr>
                        <tr>
                            <td class="textCenter">生产技术部</td>
                            <td class="textCenter"><?php echo $result['scst'] == 1 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo $result['scst'] == 2 ? '√' : '' ?></td>
                            <td class="textCenter"><?php echo empty($result['scname']) ? '' : '<img src="' . $result['scname'] . '"/>' ?></td>
                        </tr>
                        <tr>
                            <td class="textCenter">评定结论</td>
                            <td colspan="4"class="pdX10">
                                <br/><br/><br/>
                                <label for="tyhz1">
                                    <span class="radio active">同意作为本公司合格供方</span>
                                    <input class="None" type="radio"id="tyhz1"checked="checked" name="tyhz"/>
                                </label> 
                                <i class="w-100"></i>
                                <br/><br/><br/>
                                <label for="tyhz2">
                                    <span class="radio">不同意作为本公司合格供方</span>
                                    <input class="None" type="radio"id="tyhz2"name="tyhz"/>
                                </label>
                                <br/><br/><br/>
                                <div class="UpgrapImg float-right" >批准/日期：
                                    <?php echo empty($result['stdt']) ? '' : '<img src="' . $result['stdt'] . '"/>' ?>
                                </div>
                            </td>
                        </tr>
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
                                    <tr>
                                        <td class="FrameGroupName">说明：</td>
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
            </div>
        </div>
        <div class="FrameTableFoot">
            <!--<span class="Succ" onclick="do_sub()">提交</span>-->
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
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

