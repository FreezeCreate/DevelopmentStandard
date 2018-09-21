<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
    .Table td, .Table th { padding: 6px 4px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">检验和试验设备台账</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title']; ?></h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><span style="float:right"><?php echo $result['dt'] ?></span><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textCenter" style="width:60px;">序号</td>
                                    <td class="textCenter">设备名称</td>
                                    <td class="textCenter">型号规格</td>
                                    <td class="textCenter">设备制造厂</td>
                                    <td class="textCenter">数量</td>
                                    <td class="textCenter">使用单位存放地址</td>
                                    <td class="textCenter">备  注</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td class="textCenter"><?php echo $k+1;?></td>
                                    <td class="textCenter"><?php echo $v['name']?></td>
                                    <td class="textCenter"><?php echo $v['model']?></td>
                                    <td class="textCenter"><?php echo $v['shang']?></td>
                                    <td class="textCenter"><?php echo $v['num']?></td>
                                    <td class="textCenter"><?php echo $v['address']?></td>
                                    <td class="textCenter"><?php echo $v['note']?></td>
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
            url: "<?php echo spUrl($c, "saveBdly"); ?>",
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