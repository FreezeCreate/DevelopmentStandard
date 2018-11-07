<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>业绩排行</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <style type="text/css">
            .yjphbName{text-align: center;margin-top: 50px;}
        </style>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <form action="<?php echo spUrl($c, $a,array('type'=>$page_con['type'])) ?>" method="get">
                    <ul class="TablesHeadNav" style="margin-right: 10px;">
                        <li class="TablesHeadItem <?php echo $page_con['type']=='comp'?'active':'';?>"><a href="<?php echo spUrl($c, 'quotas',array('type' => 'comp')); ?>">总览</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['type']=='dept'?'active':'';?>"><a href='<?php echo spUrl($c, 'quotas', array('type' => 'dept')); ?>'>部门绩效</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['type']=='person'?'active':'';?>"><a href='<?php echo spUrl($c, 'quotas', array('type' => 'person')); ?>'>个人绩效</a></li>
                    </ul>
                    <div class="FrameSelectGroup">
                        <input class="FrameSelectVal" type="text"  placeholder="本月" />
                        <input class="FrameSelectValue" type="hidden" name="t" value="tm" data-type="t"/>
                        <ul class="FrameSelectMenu">
                            <li class="FrameSelectItem" data-val="tw">本周</li>
                            <li class="FrameSelectItem" data-val="lw">上周</li>
                            <li class="FrameSelectItem" data-val="tm">本月</li>
                            <li class="FrameSelectItem" data-val="lm">上月</li>
                            <li class="FrameSelectItem" data-val="ts">本季度</li>
                            <li class="FrameSelectItem" data-val="ls">上季度</li>
                        </ul>
                    </div>
                    <button class="Btn Btn-primary">查询</button>
                    <span class="Btn Btn-info TablesSerchReset">重置</span>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    </form>
                </div>
                <div class="TablesBody top20">
                    <table>
                        <thead>
                            <tr>
                                <td>序号</td>
                                <td>名称</td>
                                <td>目标绩效</td>
                                <td>完成绩效</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results['results'] as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $k+1;?></td>
                                    <td><?php echo $v['name'];?></td>
                                    <td><?php echo $v['expe'];?></td>
                                    <td><?php echo $v['succ'];?></td>
                                </tr>
                                <?php $mubiao += $v['expe'];$money += $v['succ'];?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr style="background:#ccc;">
                                <td>合计</td>
                                <td></td>
                                <td><?php echo $mubiao; ?></td>
                                <td><?php echo $money; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="yjphb">
                    <div class="GraphMap"style="height: 300px; ">
                        <ul class="GraphMapY colorGre colorRed">
                            <li class="GraphMapYText ">成交额/万元</li>
                        </ul>
                        <ul class="GraphMapX"></ul>
                    </div>
                    <!--<p class="yjphbName">个人业绩目排行状图/年</p>-->
                </div>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script type="text/javascript">
        $(function() {
//			parent.window.iframeHtml($('.ContentBox')[0].offsetHeight)

            //业绩排行
            Graph(<?php echo json_encode($results)?>, '.yjphb', 5, 1);

        })
    </script>
</html>