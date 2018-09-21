<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>考勤统计</title>
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
                            <select class="TablesSerchInput" name="month">
                                <?php for($i=0;$i<12;$i++){?>
                                <option <?php echo date('Y-m',strtotime('-'.$i.'month'))==$page_con['month']?'selected=""':'';?> value="<?php echo date('Y-m',strtotime('-'.$i.'month'))?>"><?php echo date('Ym',strtotime('-'.$i.'month'))?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="name" class="TablesSerchInput" value="<?php echo $page_con['name'] ?>" placeholder="姓名/部门/职位"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <button type="button" class="Btn Btn-info" onclick="replace(0)">全部重新分析</button>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
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
                                    <td>姓名</td>
                                    <td>部门</td>
                                    <td>职位</td>
                                    <td>人员状态</td>
                                    <td>迟到（次）</td>
                                    <td>早退（次）</td>
                                    <td>异常（次）</td>
                                    <td>外出（天）</td>
                                    <td>请假（天）</td>
                                    <td>应上班（天）</td>
                                    <td>实上班（天）</td>
                                    <td>加班（天）</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Results<?php echo $v['id'] ?>">
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['departmentname'] ?></td>
                                        <td><?php echo $v['positionname'] ?></td>
                                        <td><?php echo $GLOBALS['USER_DIR'][$v['dir']] ?></td>
                                        <td><?php echo $v['kqtj']['cd'] ?></td>
                                        <td><?php echo $v['kqtj']['zt'] ?></td>
                                        <td><?php echo $v['kqtj']['yc'] ?></td>
                                        <td><?php echo $v['kqtj']['wc'] ?></td>
                                        <td><?php echo $v['kqtj']['qj'] ?></td>
                                        <td><?php echo $v['kqtj']['ysb'] ?></td>
                                        <td><?php echo $v['kqtj']['ssb'] ?></td>
                                        <td><?php echo $v['kqtj']['jb'] ?></td>
                                        <td>
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a class="NewHtml a_02 active" data-clas="a_02" data-url="<?php echo spUrl($c, 'punchMonthList', array('uid' => $v['id'],'month'=>$page_con['month'])) ?>" data-name="打卡记录" data-img="<?php echo SOURCE_PATH; ?>/images/shouye_61.png">打卡记录</a></li>
                                                <li class="menu-item"><a onclick="replace(<?php echo $v['id'] ?>)">重新分析</a></li>
                                            </ul>
                                            </div>
                                        </td>
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

    <script type="text/javascript">
        function replace(id) {
            loading();
            var month = $('#month').val();
            $.get("<?php echo spUrl($c, "replace"); ?>", {uid: id,month:month}, function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.location.href='<?php echo spUrl($c,$a)?>?month='+month;
                }else{
                    loading('none');
                    Alert(data.msg);
                }
            }, 'json');
        }

    </script>


