<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">文件分发</span><span class="Close"></span></div>
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
                        <h3 style="font-size: 16px; line-height: 60px;"><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <th width="50"rowspan="2">序号</th>
                                    <th rowspan="2">文件名称</th>
                                    <th width="100"rowspan="2">版本</th>
                                    <th rowspan="2">编号</th>
                                    <th rowspan="2">分发号</th>
                                    <th rowspan="2">分发日期</th>
                                    <th colspan="6">分发部门签收</th>
                                    <th rowspan="2">回收记录</th>
                                </tr>
                                <tr>
                                    <th>总经理</th><th>行政部</th><th>质检部</th><th>生产技术部</th><th>质量负责人</th><th>供应部</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td><?php echo $k+1?></td>
                                    <td><?php echo $v['name']?></td>
                                    <td><?php echo $v['banben']?></td>
                                    <td><?php echo $v['number']?></td>
                                    <td><?php echo $v['num']?></td>
                                    <td><?php echo $v['date']?></td>
                                    <?php if($k==0){?>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <td class="row" rowspan="<?php echo count($result['children'])?>"></td>
                                    <?php }?>
                                    <td class=""><?php echo $v['explain']?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">检查人/日期：</span></p>
                                <div class="UpgrapImg">
                                    <img class="" src="<?php echo $result['uname']; ?>"/>
                                    
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
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY/MM/DD",
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
            url: "<?php echo spUrl($c, "saveWjqd"); ?>",
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