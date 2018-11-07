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
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="<?php echo empty($result['title'])?'生产设备保养记录表':$result['title'] ?>" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="pdX10  textLeft" colspan="18">
                                        <select class="" name="year">
                                            <?php for($y = 0;$y<10;$y++){?>
                                            <option <?php echo $result['year']==(date('Y')-$y)?'selected=""':''?> value="<?php echo date('Y')-$y?>"><?php echo date('Y')-$y?>年</option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td class="textRight" colspan="2">编号</td>
                                    <td class="pdX10  textLeft" colspan="14">
                                        <input type="text" name="pnumber" value="<?php echo empty($result['number'])?'':$result['number'] ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textRight" colspan="5">设备名称/型号</td>
                                    <td class="pdX10  textLeft" colspan="10">
                                        <input type="text" name="name" value="<?php echo empty($result['name'])?'':$result['name'] ?>" />
                                    </td>
                                    <td class="textRight" colspan="7">保养人</td>
                                    <td class="pdX10  textLeft" colspan="10">
                                        <input type="text" name="person" value="<?php echo empty($result['person'])?'':$result['person'] ?>" />
                                    </td>
                                </tr>
                                <tr><th style="width:60px;">日期</th>
                                <?php for($i=1;$i<=31;$i++){?>
                                    <th rowspan="2"><?php echo $i;?></th>
                                <?php }?>
                                </tr><tr><th>月份</th></tr>
                            </thead>
                            <?php $cs = array('√'=>'true','×'=>'false','△'=>'squar')?>
                            <tbody class="TabBg TabInp textCenter Tbody">
                                <?php for($i=1;$i<=12;$i++){?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <?php for($j=1;$j<=31;$j++){?>
                                    <td><label><span class="check <?php echo $cs[$result['content'][$i.'-'.$j]]?>"></span><input type="hidden" name="content[<?php echo $i.'-'.$j?>]" value="<?php echo $result['content'][$i.'-'.$j]?>" /></label></td>
                                    <?php }?>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="2"class="textCenter">异常情况记录</td><td colspan="30"><textarea rows="2" name="case"></textarea></td></tr>
                                <tr><td colspan="2"class="textCenter">备注</td><td colspan="30"class="pdX10">用“<i class="icon-true"></i>”表示日保养；用“<i class="icon-squar"></i>”表示月保养；用“<i class="icon-false"></i>”表示异常，保养项目见设备管理制度或设备操作手册，异常情况应记录在异常情况记录栏。</td></tr>
                            </tfoot>
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