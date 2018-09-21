<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">供应商管理报表</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="供应商管理报表" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">编号</td>
                                    <td class="pdX10  textLeft" colspan="8">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textRight">供应商名称</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <input type="text" name="name" value="" />
                                    </td>
                                    <td class="textRight">主要供货产品</td>
                                    <td class="pdX10  textLeft" colspan="4">
                                        <input type="text" name="produce" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th width="70">序号</th><th>考评内容</th><th>满分</th><th>实得分</th>
                                    <th>考核人</th><th>总送货次数</th><th>合格次数</th><th>不合格次数</th><th>评分等级</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter TabInp add">
                                <tr>
                                    <td>1</td>
                                    <td>供货质量</td>
                                    <td>60</td>
                                    <td class="colorRed totalVal"><input type="text" name="zhiliang[1]" value=""/></td>
                                    <td class="colorGre"><input type="text" name="zhiliang[2]" value=""/></td>
                                    <td class="totalVal"><input type="text" name="zhiliang[3]" value=""/></td>
                                    <td class="totalVal"><input type="text" name="zhiliang[4]" value=""/></td>
                                    <td class="totalVal"><input type="text" name="zhiliang[5]" value=""/></td>
                                    <td class=""><input type="text" name="zhiliang[6]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>服务</td>
                                    <td>5</td>
                                    <td class="colorRed totalVal"><input type="text" name="fuwu[1]" value=''/></td>
                                    <td class="colorGre"><input type="text" name="fuwu[2]" value=""/></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>投诉回复</td>
                                    <td>5</td>
                                    <td class="colorRed totalVal"><input type="text" name="tousu[1]" value=""/></td>
                                    <td class="colorGre"><input type="text" name="tousu[2]" value=""/></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>交货期</td>
                                    <td>20</td>
                                    <td class="colorRed totalVal"><input type="text" name="jiaohuo[1]" value=""/></td>
                                    <td class="colorGre"><input type="text" name="jiaohuo[2]" value=""/></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>价格</td>
                                    <td>10</td>
                                    <td class="colorRed totalVal"><input type="text" name="jiage[1]" value=""/></td>
                                    <td class="colorGre"><input type="text" name="jiage[2]" value=""/></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="totalMneu">
                                    <td></td><td>总计</td><td>100</td><td class="colorRed"></td><td></td>
                                    <td></td><td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">综合考评：</td><td colspan="7" class="pdX10"><input class="textLeft" name="kaopin" type="text" value="" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">采购：</td><td class="pdX10" colspan="3"><input  class="textLeft" type="text" name="cg" value="" placeholder="采购人"/></td>
                                    <td>日期：</td><td colspan="3"class="textLeft"><input type="text" class="dt" name="cgdt" value="" placeholder="日期"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2">质量负责人：</td><td class="pdX10" colspan="3"><input class="textLeft" type="text" name="zl" value="" placeholder="质量负责人" /></td>
                                    <td>日期：</td><td colspan="3"class="textLeft"><input type="text" class="dt" name="zldt" value="" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="top20">
                        <div class="TableHead pdX10 TableHdBg textLeft">
                            <span class="">评分标准：</span>
                        </div>
                        <table class="Table textCenter TabBg">
                            <tbody>
                                <tr>
                                    <td>1</td><td>供货质量（60分）</td><td>优（55-60分）</td><td>良（50-55分）</td><td>中（45-50分）</td><td>差（45分以下）</td>
                                </tr>
                                <tr>
                                    <td>2</td><td>服    务（5分）</td><td>优（4.5-5分）</td><td>良（4-4.5分）</td><td>中（3-4分）</td><td>差（3分以下）</td>
                                </tr>
                                <tr>
                                    <td>3</td><td>投诉回复（5分）</td><td>优（4.5-5分）</td><td>良（4-4.5分）</td><td>中（3-4分）</td><td>差（3分以下）</td>
                                </tr>
                                <tr>
                                    <td>4</td><td>交货期（20分）</td><td>优（18-20分）</td><td>良（15-18分）</td><td>中（12-15分）</td><td>差（12分以下）</td>
                                </tr>
                                <tr>
                                    <td>5</td><td>价格（10分）</td><td>优（9-10分）</td><td>良（8-9分）</td><td>中（7-8分）</td><td>差（7分以下）</td>
                                </tr>
                                <tr>
                                    <td>说明：</td><td colspan="5" class="pdX10 textLeft">得分90分或以上可以保持合格供应商资格，90分以下取消合格供应商资格。</td>
                                </tr>
                            </tbody>
                        </table>
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
            url: "<?php echo spUrl($c, "saveGysgl"); ?>",
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