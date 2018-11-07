<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style type="text/css">
    .Item{display: none}
    .Item.active{display: block;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form id="check_form">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue"onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="top20" id="print">
                        <table class="Table textCenter">
                            <thead>
                                <tr><th colspan="7">所需元器件</th></tr>
                                <tr><th width="150">序号</th><th>原件名称</th><th>型号规格</th><th>单位</th><th>数量</th><th>单价</th><th>合计</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result['children'] as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['format'] ?></td>
                                        <td><?php echo $v['unit'] ?></td>
                                        <td><?php echo $v['num'] ?></td>
                                        <td><?php echo $v['price'] ?></td>
                                        <td><?php echo $v['price'] * $v['num'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <?php if ($result['is_have'] == 0) { ?>
                                    <tr>
                                        <td colspan="2">元器件是否在合格供应商名单中</td>
                                        <td colspan="5"class="pdX20 textLeft che">
                                            <label><span class="radio">全部存在</span><input type="radio" class="None" name="is_have" value="1" /></label>
                                            <label><span class="radio">不存在</span><input type="radio" class="None" name="is_have" value="2" /></label>
                                        </td>
                                    </tr>
                                <?php } else if ($result['is_stock'] == 0) { ?>
                                    <tr>
                                        <td colspan="2">库存是否充足</td>
                                        <td colspan="5"class="pdX20 textLeft che">
                                            <label><span class="radio">足够</span><input type="radio" class="None" name="is_stock" value="1" /></label>
                                            <label><span class="radio">不足</span><input type="radio" class="None" name="is_stock" value="2" /></label>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tfoot>
                        </table>
                        <div></div>
                    </div>
                    <div class="FrameListTable">
                        <p class="FrameListTableTit">处理记录</p>
                        <table class="FrameListTableItem">
                            <thead>
                                <tr>
                                    <td class="tit01">序号</td>
                                    <td class="tit01">操作人</td>
                                    <td class="tit01">操作状态</td>
                                    <td class="tit01">说明</td>
                                    <td class="tit01">时间</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['checkname']; ?></td>
                                        <td><?php echo $v['statusname']; ?></td>
                                        <td>
                                            <?php echo $v['explain']; ?>
                                            <?php foreach ($v['files'] as $v1) { ?>
                                                <div class="download"><a class="download-a" href="javascript:void(0)" style="color: #007aff;" itemid="<?php echo $v1['id'] ?>" title="点击下载"><?php echo $v1['filename'] ?></a>
                                                <?php } ?>
                                        </td>
                                        <td><?php echo $v['optdt']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="top20">
                        <div class="Item">
                            <div class="End top20 pdX20">
                                <div class="EndItem">
                                    <div>
                                        <span class="w-100">检查人：</span>
                                        <div class="Upgrap">
                                            <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                                <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                                <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                            </div>
                                            <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($result['is_have'] == 0) { ?>
                            <div class="Item">
                                <table class="Table TabInp">
                                    <tbody class="add">
                                        <tr>
                                            <td width="150" class="textCenter TabBgBlue">文件编号</td>
                                            <td colspan="2" class="pdX10"><input type="text" name="number" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td width="150" class="textCenter TabBgBlue">标题</td>
                                            <td colspan="2" class="pdX10"><input type="text" name="title" value="" placeholder="XXXX变更审批表"/></td>
                                        </tr>
                                        <tr>
                                            <td width="150" class="textCenter TabBgBlue">适用产品</td>
                                            <td colspan="2" class="pdX10"><input type="text" name="project" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td class="textCenter TabBgBlue">变更原因</td>
                                            <td colspan="2"class="pdX10"><textarea  rows="5" name="case" ></textarea></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="textCenter TabBgBlue">变更内容</td>
                                            <td class="textCenter TabBgBlue">变更前</td>
                                            <td class="textCenter TabBgBlue">变更后</td>
                                        </tr>
                                        <tr>
                                            <td class="pdX10"><textarea  rows="10" name="start"></textarea></td>
                                            <td class="pdX10"><textarea  rows="10" name="end" ></textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="textCenter TabBgBlue">变更依据</td>
                                            <td colspan="2"class="pdX10"><textarea  rows="5" name="yiju" ></textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="textCenter TabBgBlue">质量负责人意见</td>
                                            <td colspan="2"class="pdX10"><textarea  rows="5" name="zlyijian" ></textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="textCenter TabBgBlue">技术负责人意见</td>
                                            <td colspan="2"class="pdX10"><textarea  rows="5" name="jsyijian" ></textarea></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($result['is_stock'] == 0) { ?>
                            <div class="Item ">
                                <table class="Table TabInp">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="textCenter TabBgBlue">请购单</th>
                                        </tr>
                                        <tr>
                                            <th class="textCenter TabBgBlue">编号</th>
                                            <th colspan="5" class="pdX10 textLeft"><input type="text" name="number" value="" /></th>
                                        </tr>
                                        <tr class="TabBgBlue">
                                            <th>序号</th><th>产品名称</th><th>型号规格</th><th>供应商名称</th><th>请购数量</th><th>备注</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add textCenter">
                                        <tr>
                                            <td>1</td><td><input type="text" name="name[]" id="" value="" /></td>
                                            <td><input type="text" name="format[]" id="" value="" /></td><td><input type="text" name="supplier[]" id="" value="" /></td>
                                            <td><input type="text" name="num[]" id="" value="" /></td><td><input type="text" name="explain[]" id="" value="" /></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    <td></td><td><span class="TabAdd"></span></td><td></td><td></td><td></td><td></td>
                                    </tfoot>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
            <div style="height: 50px;"></div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">保存</span>
        </div>
    </div>

</body>
<script type="text/javascript">
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
        $('.che label').click(function() {
            var that = $(this);
            $('.Item').removeClass('active')
            $('.Item').eq(that.index()).addClass('active')
        });
        $('.TabAdd').click(function() {
            $('.add').append(
                    '<tr><td>' + ($('.add').children().length + 1) + '</td><td><input type="text" name="name[]" id="" value="" /></td>'
                    + '<td><input type="text" name="format[]" id="" value="" /></td><td><input type="text" name="supplier[]" id="" value="" /></td>'
                    + '<td><input type="text" name="num[]" id="" value="" /></td><td><input type="text" name="explain[]" id="" value="" /></td></tr>'
                    )
        })
        $('.addFile').click(function() {
            $(this).prev().click();
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
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveMater'); ?>",
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
                     
                    Alert(data.msg);
                    parent.closHtml();
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


