<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">文件分发记录</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl"><input class="textCenter" type="text" name="title" value="文件分发记录" /></div>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="">编号</td>
                                    <td class="pdX10  textLeft" colspan="12">
                                        <input type="text" name="pnumber" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50"rowspan="2">序号</th><th rowspan="2">文件名称</th><th width="100"rowspan="2">版本</th><th rowspan="2">编号</th>
                                    <th rowspan="2">分发号</th><th rowspan="2">分发日期</th><th colspan="6">分发部门签收</th><th rowspan="2">回收记录</th>
                                </tr>
                                <tr>
                                    <th>总经理</th><th>行政部</th><th>质检部</th><th>生产技术部</th><th>质量负责人</th><th>采购部</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter TabInp add">
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td class="row" rowspan="20"></td>
                                    <td class="row" rowspan="20"></td>
                                    <td class="row" rowspan="20"></td>
                                    <td class="row" rowspan="20"></td>
                                    <td class="row" rowspan="20"></td>
                                    <td class="row" rowspan="20"></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>16</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>17</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>18</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>19</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                                <tr>
                                    <td>20</td>
                                    <td><input type="text" name="name[]" value=""/></td>
                                    <td><input type="text" name="banben[]" value=""/></td>
                                    <td><input type="text" name="number[]" value=""/></td>
                                    <td><input type="text" name="num[]" value=""/></td>
                                    <td><input type="text" class="dt" name="date[]" value=""/></td>
                                    <td><input type="text" name="explain[]" value=""/></td>
                                </tr>
                            </tbody>
                            <tfoot class="textCenter">
                                <tr>
                                    <td></td><td></td><td></td><td></td><td></td><td><span class="TabAdd"></span></td><td></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
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
    $('.TabAdd').click(function(e) {
        e.stopPropagation()
        var index = $('.add').children().length + 1;
        $('.add').append(
                '<tr><td>' + index + '</td><td><input type="text" name="name[]" value=""/></td><td><input type="text" name="banben[]" value=""/></td>'
                +'<td><input type="text" name="number[]" value=""/></td><td><input type="text" name="num[]" value=""/></td>'
                + '<td><input type="text" class="dt" name="date[]" value=""/></td><td><input type="text" name="explain[]" value=""/></td></tr>'
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
            url: "<?php echo spUrl($c, "saveWjff"); ?>",
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