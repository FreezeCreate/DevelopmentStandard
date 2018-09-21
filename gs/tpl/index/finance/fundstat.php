<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css" />
        <style type="text/css">
            .jedatebox .jedaym li {
                width: auto!important;
                margin: 0 10px;
            }

            .bmtjTit {
                padding: 10px 0;
                text-align: center;
            }
            .yftjFoot{
                padding: 30px 0;
                text-align: center;
            }
            .yftjFootItem{display: inline-block;margin-right: 20px;}
            .yftjFootItemB{display: inline-block;height: 14px;width: 14px;margin-right: 10px;vertical-align: top;}
            .TablesBody tbody tr:last-child{background-color: #b7c8b6;}
        </style>
    </head>

    <body style="min-width: 930px;">
        <div class="ContentBox">
            <div class="">
                <form action="<?php echo spUrl($c, $a) ?>" method="get">
                <input type="text" class="FrameDatGroup" readonly="true" id="start" name="start" value="<?php echo $page_con['start']?>"/>
                ~
                <input type="text" class="FrameDatGroup" readonly="true" id="end" name="end" value="<?php echo $page_con['end']?>"/>
                <button class="Btn Btn-primary">查询</button>
                <span class="Btn Btn-info TablesSerchReset">重置</span>
                <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
            <div class="TablesBody top20">
                <div class="lcItemTit textCenter">按部门统计</div>
                <table>
                    <thead style="background: #eeeeee;font-weight: bold;">
                        <tr>
                            <td>序号</td>
                            <td>部门</td>
                            <td>金额</td>
                            <td>比例</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($udept as $k => $v) { ?>
                            <tr class="ListData">
                                <td><?php echo $i ?></td>
                                <td><?php echo $k ?></td>
                                <td><?php echo $v ?></td>
                                <td class="percentage"><?php echo sprintf("%.2f", $v / $money * 100) ?>%</td>
                            </tr>
                            <?php $i++;
                        } ?>
                        <tr>
                            <td>-</td>
                            <td>合计</td>
                            <td><?php echo $money; ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="bmtjCont">
                    <div class="bmtjTit">部门统计图</div>
                    <div class="GraphMap" style="height: 200px; ">
                        <ul class="GraphMapY colorGre ">
                            <li></li>
                        </ul>
                        <ul class="GraphMapX"></ul>
                    </div>
                </div>
            </div>
            <div class="TablesBody" style="margin-top: 50px;">
                <div class="lcItemTit textCenter">按月份统计</div>
                <table>
                    <thead style="background: #eeeeee;font-weight: bold;">
                        <tr>
                            <td>序号</td>
                            <td>部门</td>
                            <td>金额</td>
                            <td>比例</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
<?php foreach ($month as $k => $v) { ?>
                            <tr>
                                <td><?php echo $j ?></td>
                                <td><?php echo $k ?></td>
                                <td><?php echo $v['money'] ?></td>
                                <td><?php echo sprintf("%.2f", $v['money'] / $money * 100) ?>%</td>
                            </tr>
    <?php $j++;
} ?>
                        <tr>
                            <td>-</td>
                            <td>合计</td>
                            <td><?php echo $money; ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="yftjCont">
                    <div class="bmtjTit">部门统计图</div>
                    <div class="GraphMap" style="height: 200px; ">
                        <ul class="GraphMapY colorGre ">
                            <li></li>
                        </ul>
                        <ul class="GraphMapX"></ul>
                    </div>
                </div>
                <div class="yftjFoot">
                    <?php foreach($udept as $k=>$v){?>
                    <div class="yftjFootItem"><i class="yftjFootItemB" data-name="<?php echo $k;?>"></i><?php echo $k;?></div>
                    <?php }?>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/yktj.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script type="text/javascript">
        $(function() {

            jeDate({
                dateCell: "#start",
                format: "YYYY-MM-DD",
                isinitVal: false,
                isTime: false, //isClear:false,
                minDate: "2014-09-19 00:00:00",
            });
            jeDate({
                dateCell: "#end",
                format: "YYYY-MM-DD",
                isinitVal: false,
                isTime: false, //isClear:false,
                minDate: "2014-09-19 00:00:00",
            });

            var Bg = ['#b7c8b6', '#745a67', '#d18a6e', '#5d5653', '#ad998e', '#876a5c', '#d1756e', ]

            graphbm({
                "results": [
                    <?php foreach($udept as $k=>$v){?>
                    {
                        name: '<?php echo $k;?>', //name
                        y: <?php echo $v;?>,
                    },
                    <?php }?>]
            }, '.bmtjCont', 5)
            graphyf({
                "results": [
                    <?php foreach($month as $k=>$v){?>
                    {
                        'month': '<?php echo $k;?>',
                        'data': [
                    <?php foreach($v['children'] as $k1=>$v1){?>
                            {
                                "succ": <?php echo $v1;?>,
                                "name": "<?php echo $k1;?>"
                            },
                        <?php }?>]
                    },
                        <?php }?>]
            }, '.yftjCont', 5)
            $('.GraphMapGrap').css({
                'background': 'top'
            })
            $('.bmtjCont .GraphMapSucc').each(function(k, v) {
                    $(v).css({
                            'background': Bg[k]
                    })
            })
            $('.yftjFootItemB').each(function(k, v) {
                    $(v).css({
                            'background': Bg[k]
                    })
                    $(v).attr({'data-bg': Bg[k] })
            })
            $('.yftjCont .GraphMapSucc').each(function(k, v) {
                    $('.yftjFootItemB').each(function(k1, v1) {
                            if($(v).attr('data-name') == $(v1).attr('data-name')){
                                    $(v).css({
                                            'background': $(v1).attr('data-bg')
                                    })
                            }
                    })
            })
        })
    </script>

</html>