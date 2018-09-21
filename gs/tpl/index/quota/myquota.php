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
                            <input class="FrameDatGroup" name="stime" id="start" value="<?php echo $page_con['stime'] ?>" placeholder="开始时间"/> ~
                            <input class="FrameDatGroup" name="etime" id="end" value="<?php echo $page_con['etime'] ?>" placeholder="结束时间"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                            <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                        </form>
                    </div>
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
                                    <td>序号</td>
                                    <td>时间</td>
                                    <td>绩效</td>
                                    <td>提成</td>
                                    <td>合同</td>
                                    <td>客户</td>
                                    <td>备注</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k+1;?></td>
                                        <td><?php echo $v['adddt'];?></td>
                                        <td><?php echo $v['money'];?></td>
                                        <td><?php echo $v['money']*$custract[$v['cid']]['unit'];?></td>
                                        <td><?php echo $custract[$v['cid']]['number'];?></td>
                                        <td><?php echo $custract[$v['cid']]['custname'];?></td>
                                        <td><?php echo $custract[$v['cid']]['explain'];?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
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
    jeDate({
        dateCell: "#start",
        format: "YYYY-MM-DD",
        isTime: false,
    })
    jeDate({
        dateCell: "#end",
        format: "YYYY-MM-DD",
        isTime: false,
    })
</script>

