<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>客户信息</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">客户信息</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">资料详情</div>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">活动名称：</td>
                                <td><?php echo $result['name'] ?></td>
                                <td class="FrameGroupName">类别：</td>
                                <td><?php echo $GLOBALS['ACTIVITY'][$result['cate']] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 开始日期</td>
                                <td><?php echo $result['statdt'] ?></td>
                                <td class="FrameGroupName"> 结束日期</td>
                                <td><?php echo $result['enddt'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 活动地点</td>
                                <td colspan='3'><?php echo $result['address'] ?></td>   
                            </tr>
                            <tr>
                                <td class="FrameGroupName">活动所需</td>
                                <td colspan='3'><?php echo $result['prepare']?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">活动背景</td>
                                <td colspan='3'><?php echo $result['content']?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">路线说明</td>
                                <td colspan='3'><?php echo $result['luxian']?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 预算费用</td>
                                <td><?php echo $result['ymoney'] ?></td>
                                <td class="FrameGroupName"> 实际费用</td>
                                <td><?php echo $result['money'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">相关文件 ：</td>
                                <td colspan="3">
                                    <ul class="FileBox">
                                        <?php foreach ($result['files'] as $v) { ?>
                                        <li class="FileItem colorGre download-a" itemid="<?php echo $v['id'] ?>"><span class="FileItemNam"><?php echo $v['filename'] ?></span></li>
                                        <?php }?>
                                    </ul>
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