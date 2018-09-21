<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>我的目标绩效</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                        </form>
                    </div>
                    <div class="TablesAddBtn InPop" data-BoxId="mubiao">＋ 制定下月目标</div>
                </div>
                <?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="TablesBody top20">
                        <table>
                            <thead>
                                <tr>
                                    <td>月份</td>
                                    <td>销售人员</td>
                                    <td>目标签单数</td>
                                    <td>目标签单金额</td>
                                    <td>目标回款金额</td>
                                    <td>已签单金额</td>
                                    <td>已回款金额</td>
                                    <td>备注</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td><?php echo $v['month']; ?></td>
                                        <td><?php echo $v['uname']; ?></td>
                                        <td><?php echo $v['qiandan']; ?></td>
                                        <td><?php echo $v['money']; ?></td>
                                        <td><?php echo $v['huikuan']; ?></td>
                                        <td><?php echo $v['wmoney']; ?></td>
                                        <td><?php echo $v['whuikuan']; ?></td>
                                        <td><?php echo $v['content']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
<?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <div class="Tan" id="mubiao">
            <div class="TanBox">
                <div class="TanBoxTit">制定月目标 <span class="close OtPop"data-BoxId="mubiao"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="mubiao_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">月份</td>
                                <td>
                                    <select class="FrameGroupInput" name="month">
                                        <?php for($i=0;$i<5;$i++){?>
                                        <option <?php echo $i==1?'selected=""':''?> value="<?php echo date('Ym',  strtotime($i.'month'))?>"><?php echo date('Y年m月',strtotime($i.'month'))?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="FrameGroupName">目标签单数</td>
                                <td>
                                    <input class="FrameGroupInput" type="text" name="qiandan" value=""/>单
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">目标签单金额</td>
                                <td>
                                    <input class="FrameGroupInput" type="text" name="money" value=""/>元
                                </td>
                                <td class="FrameGroupName">目标回款金额</td>
                                <td>
                                    <input class="FrameGroupInput" type="text" name="huikuan" value=""/>元
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3">
                                    <textarea class="FrameGroupInput" name="content"></textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="mubiao" onclick="do_mubiao()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="mubiao">取消</span>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>

</html>
<script>
    function do_mubiao() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveQuotas"); ?>",
            data: $('#mubiao_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        window.location.reload();
                    });
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>

