<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style type="text/css">
    input.note{font-size: 20px;height: auto;}
    .n{font-size: 18px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <!--<span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>-->
                </div>
                <p class="n"><i class="colorRed">注</i>：“质量情况”栏可使用快捷键输入，“<i class="colorRed">1</i>”输入“√”，“<i class="colorRed">2</i>”输入“X”，“<i class="colorRed">3</i>”输入“/”。</p>
                <form id="do_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp textCenter">
                            <thead class="TabBg TabBgBlue">
                                <tr>
                                    <th colspan="7">电 气 装 配 工 序 流 程 卡</th>
                                </tr>
                                <tr>
                                    <th>订单</th>
                                    <th colspan="3" class="textLeft">
                                        <select name="oid" class="FrameGroupInput">
                                            <option value="">请选择</option>
                                            <?php foreach ($orders as $k => $v) { ?>
                                                <option <?php echo $result['oid'] == $v['id'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] . '（' . $v['number'] . '）' ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th>模板</th>
                                    <th colspan="2" class="textLeft">
                                        <select name="lid" class="FrameGroupInput">
                                            <?php foreach ($lcex as $k => $v) { ?>
                                                <option <?php echo $result['lid'] == $v['id'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th class=" ">编号</th><th class="pdX10 textLeft"colspan="6"><input type="text" name="number" id="" value="<?php echo $result['number'] ?>" /></th>
                                </tr>
                                <tr>
                                    <th class=" ">产品名称</th><th class="pdX10"><input type="text" name="name" id="" value="<?php echo $result['name'] ?>" /></th>
                                    <th class=" ">型号规格</th><th class="pdX10"><input type="text" name="format" id="" value="<?php echo $result['format'] ?>" /></th>
                                    <th class=" " style="width:120px;">产品编号</th><th class="pdX10"colspan="2"><input type="text" name="pnumber" id="" value="<?php echo $result['pnumber'] ?>" /></th>
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
                                                <td rowspan="<?php echo count($v['children']) ?>"><?php echo $v['name'] ?></td>
                                            <?php } ?>
                                            <td colspan="3"><?php echo $v1['content'] ?></td>
                                            <td><input type="text"class="note"style="ime-mode:disabled" name="content[<?php echo $v['sort'] ?>][<?php echo $v1['sort'] ?>]" id="" /></td>
                                            <?php if ($k1 == 0) { ?>
                                                <td rowspan="<?php echo count($v['children']) ?>">
                                                    <div class="Upgrap">
                                                        <div class="UpgrapImg float-right">
                                                            <img class="" src="<?php echo empty($result['yyuser']) ? SOURCE_PATH . '/images/qianming.png' : $result['yyuser']; ?>"/>
                                                            <input type="hidden" name="sign[<?php echo $v['sort'] ?>]" value="<?php echo empty($result['yyuser']) ? '' : $result['yyuser']; ?>"/>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td rowspan="<?php echo count($v['children']) ?>">
                                                    <input type="text" class="dt" name="date[<?php echo $v['sort'] ?>]" value="<?php echo date('Y-m-d') ?>"/>
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
                    <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
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
    $('select[name="lid"').change(function() {
        var mid = $(this).val();
        window.location.href = '<?php echo spUrl($c, $a, array('id' => $result['id'], 'type' => $type)) ?>' + '?lid=' + mid;
    });
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
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
        $('.note').keydown(function(e) {
            var that = $(this);
            if (e.keyCode == 49 || e.keyCode == 97) {
                that.val('√')
                return false;
            } else if (e.keyCode == 50 || e.keyCode == 98) {
                that.val('×')
                return false;
            } else if (e.keyCode == 51 || e.keyCode == 99) {
                that.val('/')
                return false;
            } else if (e.keyCode == 52 || e.keyCode == 100) {

            } else {
                return false;
            }
        })
        $(document).on('input', '.note', function() {
            var that = $(this);
            if (that.val() == '√' || that.val() == '×' || that.val() == '/') {

            } else {
                that.val('')
            }
        });
        jeDate({
            dateCell: ".dt",
            format: "YYYY-MM-DD",
            isinitVal: false,
            isTime: false, //isClear:false,
            minDate: "2014-09-19",
        });
    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveLiucheng'); ?>",
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

</script>
</html>


