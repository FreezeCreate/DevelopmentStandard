<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style type="text/css">
    input.note{font-size: 20px;height: auto;}
    .n{font-size: 18px;}
    .Table td, .Table th { padding: 10px;}
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
                <form id="do_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;">电 气 装 配 工 序 流 程 卡</h3>
                        <h3 style="font-size: 18px; line-height: 40px;">编号：<?php echo $result['number'] ?></h3>
                        <table class="Table TabInp textCenter">
                            <thead class="TabBg TabBgBlue">
                                <tr>
                                    <th class=" ">产品名称</th><th class="pdX10"><?php echo $result['name'] ?></th>
                                    <th class=" ">型号规格</th><th class="pdX10"><?php echo $result['format'] ?></th>
                                    <th class=" " style="width:120px;">产品编号</th><th class="pdX10"colspan="2"><?php echo $result['pnumber'] ?></th>
                                </tr>
                                <tr>
                                    <th class=" ">工序名称</th><th class="pdX10"colspan="3">操作要点</th>
                                    <th class=" ">质量情况</th><th>操作者/检验员</th><th>日期</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lcre as $k => $v) { ?>
                                    <?php foreach ($v['children'] as $k1 => $v1) { ?>
                                        <tr>
                                            <?php if ($k1 == 0) { ?>
                                                <td rowspan="<?php echo count($v['children']) ?>">元器件安装</td>
                                            <?php } ?>
                                                <td colspan="3"><?php echo $v1['content'] ?></td>
                                            <td><?php echo $result['children'][$v['sort']]['content'][$v1['sort']] ?></td>
                                            <?php if ($k1 == 0) { ?>
                                                <td rowspan="<?php echo count($v['children']) ?>">
                                                    <div class="Upgrap">
                                                        <div class="UpgrapImg">
                                                            <?php echo empty($result['children'][$v['sort']]) ? '' : '<img class="" src="' . $result['children'][$v['sort']]['sign'] . '"/>' ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td rowspan="<?php echo count($v['children']) ?>">
                                                    <?php echo $result['children'][$v['sort']]['dt'] ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <tr>
                                    <td colspan="7">注：“质量结果”栏处，“√”表示合格，“X”表示不合格，“/”表示无此项。</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
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
                </form>
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
                                        <td class="FrameGroupName">相关文件 ：</td>
                                        <td>
                                            <ul class="FileBox">

                                            </ul>
                                            <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                            <span class="addFile">+添加文件</span>
                                        </td>
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
        $('.addFile').click(function() {
            $(this).prev().click()
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
                    Alert(data.msg);
                    parent.window.closHtml();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>
</html>


