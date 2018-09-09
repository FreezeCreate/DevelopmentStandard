<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>工作日报</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">工作日报</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">工作日报</div>
                        <table class="FrameTableCont">
                            <tbody>
                                <tr>
                                    <td  class="FrameGroupName" width="100px">人员：</td>
                                    <td><?php echo $result['uname'] ?></td>
                                    <td class="FrameGroupName">日报类型：</td>
                                    <td ><?php echo $result['type'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">日期：</td>
                                    <td><?php echo $result['date'] ?></td>
                                    <td class="FrameGroupName">截止日期：</td>
                                    <td><?php echo $result['enddt'] ?></td>
                                </tr>
                                <?php if ($result['type'] === '日报') { ?>
                                    <tr>
                                        <td class="FrameGroupName">预计电话量：</td>
                                        <td><?php echo $result['yjphone'] ?></td>
                                        <td class="FrameGroupName">预计意向客户：</td>
                                        <td><?php echo $result['yjyixiang'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">实际电话量：</td>
                                        <td <?php echo $result['phone'] < $result['yjphone'] ? 'style="color:red"' : ''; ?>><?php echo $result['phone'] ?></td>
                                        <td class="FrameGroupName">实际意向客户：</td>
                                        <td <?php echo $result['yixiang'] < $result['yjyixiang'] ? 'style="color:red"' : ''; ?>><?php echo $result['yixiang'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">面见客户：</td>
                                        <td colspan="3">
                                            <?php foreach ($result['mianjian'] as $v) { ?>
                                                <p><?php echo $v['name'] . '，' . $v['mobile'] . '，' . $v['address']; ?></p>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="FrameGroupName">总结：</td>
                                    <td colspan="3"><?php echo $result['zongjie'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">计划：</td>
                                    <td colspan="3"><?php echo $result['plan'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--
                                        <div class="title01">处理记录</div>
                                        <table class="table02">
                                            <tbody>
                                                <tr>
                                                    <td class="tit01">序号</td>
                                                    <td class="tit01">处理人</td>
                                                    <td class="tit01">处理状态</td>
                                                    <td class="tit01">说明</td>
                                                    <td class="tit01">时间</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td><?php echo $result['uname'] ?></td>
                                                    <td>提交</td>
                                                    <td></td>
                                                    <td><?php echo $result['adddt'] ?></td>
                                                </tr>
                        <?php foreach ($log as $k => $v) { ?>
                                                        <tr>
                                                            <td><?php echo $k + 2; ?></td>
                                                            <td><?php echo $v['checkname']; ?></td>
                                                            <td><?php echo $v['statusname']; ?></td>
                                                            <td><?php echo $v['explain']; ?></td>
                                                            <td><?php echo $v['optdt']; ?></td>
                                                        </tr>
                        <?php } ?>
                                            </tbody>
                                        </table>-->
                    </div>
                </div>
            </div>

        </div>
        <!--<div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>-->
    </body>

</html>

<script>
    function do_subcheck() {
        // loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //  loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    //loading('none');
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                    // loading('none');
                }

            }
        });
    }
</script>