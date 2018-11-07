<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>跟进客户信息</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">跟进客户信息</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">资料详情</div>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">客户：</td>
                                <td><?php echo $result['custname'] ?></td>
                                <td class="FrameGroupName">项目类型：</td>
                                <td><?php echo $GLOBALS['SALE_TYPE'][$result['type']] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">预计签单概率：</td>
                                <td><?php echo $result['rate'].'%' ?></td>
                                <td class="FrameGroupName">预计金额：</td>
                                <td><?php echo $result['money'];?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">下次联系时间：</td>
                                <td><?php echo date('Y-m-d',$result['nextdt']);?></td>
                                <td class="FrameGroupName">状态：</td>
                                <td><?php echo $GLOBALS['SALE_STATUS'][$result['status']] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 说明：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 相关文件：</td>
                                <td colspan="3">
                                    <?php foreach ($result['files'] as $v) { ?>
                                        <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a>
                                        <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <div class="FrameListTable">
                            <p class="FrameListTableTit">处理记录</p>
                            <table class="FrameListTableItem">
                                <thead>
                                    <tr>
                                        <td class="tit01">序号</td>
                                        <td class="tit01">操作人</td>
                                        <td class="tit01">操作状态</td>
                                        <td class="tit01">说明</td>
                                        <td class="tit01">时间</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($log as $k => $v) { ?>
                                        <tr>
                                            <td><?php echo $k + 1; ?></td>
                                            <td><?php echo $v['optname']; ?></td>
                                            <td><?php echo $v['stname']; ?></td>
                                            <td><?php echo $v['explain']; ?></td>
                                            <td><?php echo $v['dt']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            }
        })
    </script>
</html>
