<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">表单领用</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="表单领用/复印记录表" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="">编号</td>
                                    <td class="pdX10  textLeft" colspan="6">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">序号</td>
                                    <td class="">表格名称</td>
                                    <td class="">编号</td>
                                    <td class="">版本</td>
                                    <td class="">复印/领用份数</td>
                                    <td class="">复印/领用人</td>
                                    <td class="">备  注</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="">1</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">2</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">3</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">4</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">5</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">6</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">7</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">8</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">9</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">10</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">11</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">12</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">13</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">14</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">15</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">16</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">17</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">18</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">19</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">20</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">21</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">22</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">23</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">24</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">25</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">26</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">27</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">28</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">29</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="">30</td>
                                    <td class=""><input type="text" name="name[]" value="" /></td>
                                    <td class=""><input type="text" name="number[]" value="" /></td>
                                    <td class=""><input type="text" name="banben[]" value="" /></td>
                                    <td class=""><input type="text" name="sum[]" value="" /></td>
                                    <td class=""><input type="text" name="uname[]" value="" /></td>
                                    <td class=""><input type="text" name="explain[]" value="" /></td>
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