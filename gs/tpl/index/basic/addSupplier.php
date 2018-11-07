<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <div class="FrameTableTitl">新增供应商</div>
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName" width="20%">供应商名称：</td>
                                <td class="" width="30%"><input class="FrameGroupInput" type="text" name="company" id="" value="" /></td>
                                <td class="FrameGroupName" width="20%">地址：</td>
                                <td class=""width="30%">
                                    <input class="FrameGroupInput" type="text" name="address" id="" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">联系人：</td>
                                <td><input class="FrameGroupInput" type="text" name="name" id="" value="" /></td>
                                <td class="FrameGroupName">联系电话：</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" id="" value="" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">供货类别：</td>
                                <td><input class="FrameGroupInput" type="text" name="goodstype" id="" value="" /></td>
                                <td class="FrameGroupName"></td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue" colspan="2">是否有工商营业制造和其他合法证明</td>
                                <td colspan="2"class="pdX10">
                                    <label for="checkbox1">
                                        <span class="radio">有</span>
                                        <input class="None" type="radio"id="checkbox1" name="hfzm" value="1"/>
                                    </label> 
                                    <i class="w-50"></i>
                                    <label for="checkbox2">
                                        <span class="radio">没有</span>
                                        <input class="None" type="radio"id="checkbox2" name="hfzm" value="0"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue" colspan="2">质量情况</td>
                                <td colspan="2" class="pdX10">
                                    <label for="zl1">
                                        <span class="radio">强</span>
                                        <input class="None" type="radio"id="zl1" name="zlqk" value="1"/>
                                    </label> 
                                    <i class="w-50"></i>
                                    <label for="zl2">
                                        <span class="radio">一般</span>
                                        <input class="None" type="radio"id="zl2"name="zlqk" value="2"/>
                                    </label>
                                    <i class="w-50"></i>
                                    <label for="zl3">
                                        <span class="radio">弱</span>
                                        <input class="None" type="radio"id="zl3"name="zlqk" value="3"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue" colspan="2">产品价格和服务</td>
                                <td colspan="2" class="pdX10">
                                    <label for="fw1">
                                        <span class="radio">好</span>
                                        <input class="None" type="radio"id="fw1" name="jgfw" value="1"/>
                                    </label> 
                                    <i class="w-50"></i>
                                    <label for="fw2">
                                        <span class="radio">一般</span>
                                        <input class="None" type="radio"id="fw2"name="jgfw" value="2"/>
                                    </label>
                                    <i class="w-50"></i>
                                    <label for="fw3">
                                        <span class="radio">差</span>
                                        <input class="None" type="radio"id="fw3"name="jgfw" value="3"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue" colspan="2">产品相关资质</td>
                                <td colspan="2" class="pdX10">
                                    <label for="zz1">
                                        <span class="radio">有</span>
                                        <input class="None" type="radio"id="zz1" name="xgzz" value="1"/>
                                    </label> 
                                    <i class="w-50"></i>
                                    <label for="zz2">
                                        <span class="radio">没有</span>
                                        <input class="None" type="radio"id="zz2"name="xgzz" value="0"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue" colspan="2">社会信誉是否良好</td>
                                <td colspan="2" class="pdX10">
                                    <label for="xy1">
                                        <span class="radio">好</span>
                                        <input class="None" type="radio"id="v1" name="shxy" value="1"/>
                                    </label> 
                                    <i class="w-50"></i>
                                    <label for="xy2">
                                        <span class="radio">一般</span>
                                        <input class="None" type="radio"id="xy2"name="shxy" value="2"/>
                                    </label>
                                    <i class="w-50"></i>
                                    <label for="xy3">
                                        <span class="radio">差</span>
                                        <input class="None" type="radio"id="xy3"name="shxy" value="3"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="textCenter TabBgBlue">评定建议</td>
                                <td class="textCenter TabBgBlue">参加评定部门</td>
                                <td class="textCenter TabBgBlue">是否作为合格供方</td>
                                <td class="textCenter TabBgBlue">签名</td>
                            </tr>
                            <tr>
                                <td class="textCenter">采购部</td>
                                <td class="textCenter">
                                    <label for="cgst1">
                                        <span class="radio">同意</span>
                                        <input class="None" type="radio"id="cgst1" name="cgst" value="1"/>
                                    </label>
                                    <label for="cgst2">
                                        <span class="radio">不同意</span>
                                        <input class="None" type="radio"id="cgst2"name="cgst" value="2"/>
                                    </label>
                                </td>
                                <td class="textCenter">
                                    <div class="UpgrapImg">
                                        <img class="" src="<?php echo empty($result['cgname']) ? SOURCE_PATH . '/images/qianming.png' : $result['cgname']; ?>"/>
                                        <input type="hidden" name="cgname" value="<?php echo empty($result['cgname']) ? '' : $result['cgname']; ?>"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter">质检部</td>
                                <td class="textCenter">
                                    <label for="zjst1">
                                        <span class="radio">同意</span>
                                        <input class="None" type="radio"id="zjst1" name="zjst" value="1"/>
                                    </label>
                                    <label for="zjst2">
                                        <span class="radio">不同意</span>
                                        <input class="None" type="radio"id="zjst2"name="zjst" value="2"/>
                                    </label>
                                </td>
                                <td class="textCenter">
                                    <div class="UpgrapImg">
                                        <img class="" src="<?php echo empty($result['zjname']) ? SOURCE_PATH . '/images/qianming.png' : $result['zjname']; ?>"/>
                                        <input type="hidden" name="zjname" value="<?php echo empty($result['zjname']) ? '' : $result['zjname']; ?>"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter">生产技术部</td>
                                <td class="textCenter">
                                    <label for="scst1">
                                        <span class="radio">同意</span>
                                        <input class="None" type="radio"id="scst1" name="scst" value="1"/>
                                    </label>
                                    <label for="scst2">
                                        <span class="radio">不同意</span>
                                        <input class="None" type="radio"id="scst2"name="scst" value="2"/>
                                    </label>
                                </td>
                                <td class="textCenter">
                                    <div class="UpgrapImg">
                                        <img class="" src="<?php echo empty($result['scname']) ? SOURCE_PATH . '/images/qianming.png' : $result['scname']; ?>"/>
                                        <input type="hidden" name="scname" value="<?php echo empty($result['scname']) ? '' : $result['scname']; ?>"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue">评定结论</td>
                                <td colspan="3"class="pdX10">
                                    <label for="status1">
                                        <span class="radio">同意作为本公司合格供方</span>
                                        <input class="None" type="radio"id="status1" name="status" value="1"/>
                                    </label> 
                                    <i class="w-100"></i>
                                    <label for="status2">
                                        <span class="radio">不同意作为本公司合格供方</span>
                                        <input class="None" type="radio"id="status2"name="status" value="2"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter TabBgBlue">批准/日期</td>
                                <td colspan="4"class="pdX10">
                                    <div class="UpgrapImg">
                                        <img class="" src="<?php echo empty($result['stdt']) ? SOURCE_PATH . '/images/qianming.png' : $result['stdt']; ?>"/>
                                        <input type="hidden" name="stdt" value="<?php echo empty($result['stdt']) ? '' : $result['stdt']; ?>"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    jeDate({
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
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
            url: "<?php echo spUrl($c, $a); ?>",
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

