<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
    .Table td, .Table th { min-width: 20px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">生产设备保养记录</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title'] ?></h3>
                        <h3 style="text-align:center; font-size: 16px; line-height: 40px;"><u><?php echo $result['year'] ?></u>年</h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><span style="float:right;"><?php echo $result['number'] ?></span>设备名称/型号：<u><?php echo $result['name'] ?></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;保养人：<u><?php echo $result['person'] ?></u></h3>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr><th style="width:60px;">日期</th>
                                <?php for($i=1;$i<=31;$i++){?>
                                    <th rowspan="2"><?php echo $i;?></th>
                                <?php }?>
                                </tr><tr><th>月份</th></tr>
                            </thead>
                            <tbody class="TabBg TabInp textCenter Tbody">
                                <?php for($i=1;$i<=12;$i++){?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <?php for($j=1;$j<=31;$j++){?>
                                    <td><span style="font-size:18px;"><?php echo $result['content'][$i.'-'.$j]?></span></td>
                                    <?php }?>
                                </tr>
                                <?php }?>
                                <tr><td colspan="2"class="textCenter">异常情况记录</td><td colspan="30"><?php echo $result['case'] ?></td></tr>
                                <tr><td colspan="2"class="textCenter">备注</td><td colspan="30"class="pdX10">用“√”表示日保养；用“×”表示月保养；用“△”表示异常，保养项目见设备管理制度或设备操作手册，异常情况应记录在异常情况记录栏。</td></tr>
                            </tbody>
                        </table>
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
    $('.TabAdd').click(function(e) {
        e.stopPropagation()
        var index = $('.add').children().length + 1;
        $('.add').append(
                '<tr><td>' + index + '</td><td><input type="text" name="name[]" value=""/></td>'
                + '   <td><input type="text" name="number[]" value=""/></td>'
                + '   <td><input type="text" name="num[]" value=""/></td>'
                + '  <td><input type="text" name="type[]" value=""/></td>'
                + ' <td><input type="text" name="ffdep[]" value=""/></td>'
                + ' <td><input type="text" name="qianshou[]" value=""/></td>'
                + '<td><input type="text" class="dt" name="dt[]" value=""/></td></tr>'
                )
        $('.row').attr({'rowspan': index})
    });
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
            url: "<?php echo spUrl($c, "saveSbbyjl"); ?>",
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