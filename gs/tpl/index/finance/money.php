<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>公司资金</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <style type="text/css">
    .zijin span{font-size:18px;line-height: 180%;margin-right: 20px}
</style>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class='zijin'>
                        <span>收入资金：<?php echo $results['summoney']?>元</span>
                        <span>支出资金：<?php echo $results['money']?>元</span>
                        <span>余额：<?php echo ($results['summoney']-$results['money']);?>元</span>
                    </div>
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <select class="TablesSerchInput" name="type">
                            <option value="0">请选择类别</option>
                                <option <?php echo $page_con['type'] == '1' ? 'selected=""' : '' ?> value="">全部</option>
                                <option <?php echo $page_con['type'] == '1' ? 'selected=""' : '' ?> value="1">收入</option>
                                <option <?php echo $page_con['type'] == '-1' ? 'selected=""' : '' ?> value="-1">支出</option>
                            </select>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <!--<div class="TablesAddBtn" onclick="fill_apply(17)">＋ 新增</div>-->
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
                                    <td>金额</td>
                                    <td>说明</td>
                                    <td>时间</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results['log'] as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td class="<?php echo $v['type']>0?'color-green':'color-red';?>"><?php echo $v['type']>0?'+'.$v['money']:'-'.$v['money'];?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td><?php echo $v['dt']; ?></td>
                                        <td></td>
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

