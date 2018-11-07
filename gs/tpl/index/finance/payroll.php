<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>工资单</title>
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
                            <select class="TablesSerchInput" name="month" id='month'>
                                <option value="0">请选择月份</option>
                                <?php for ($i=0;$i<12;$i++) { ?>
                                <?php $month = date('Ym',strtotime('-'.$i.'month'));?>
                                    <option <?php echo $page_con['month'] === $month ? 'selected=""' : '' ?> value="<?php echo $month ?>"><?php echo $month ?></option>
                                <?php } ?>
                            </select>
                            <select class="TablesSerchInput" name="bumen" id='bumen'>
                                <option value="0">请选择部门</option>
                                <?php foreach ($dep as $key => $value) { ?>
                                    <option <?php echo $page_con['bumen'] === $value['department'] ? 'selected=""' : '' ?> value="<?php echo $value['department'] ?>"><?php echo $value['department'] ?></option>
                                <?php } ?>
                            </select>
                            <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <div class="TablesAddBtn NewHtml a_05" data-clas="a_05" data-name="填写工资单" data-img="<?php echo SOURCE_PATH; ?>/images/shouye_61.png" data-url="<?php echo spUrl('finance','addpayroll')?>">＋ 填写</div>
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
                                    <td>核算</td>
                                    <td>部门</td>
                                    <td>编号</td>
                                    <td>员工</td>
                                    <td>基本工资</td>
                                    <td>提成</td>
                                    <td>绩效</td>
                                    <td>全勤</td>
                                    <td>奖金</td>
                                    <td>处罚</td>
                                    <td>缺勤</td>
                                    <td>补助</td>
                                    <td>出勤天数</td>
                                    <td>实发工资</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Results<?php echo $v['id'] ?>">
                                        <td><?php echo $v['month']; ?></td>
                                        <td><?php echo $GLOBALS['GRANT_TYPE'][$v['status']];?></td>
                                        <td><?php echo $v['bumen'] ?></td>
                                        <td><?php echo $v['number'] ?></td>
                                        <td><?php echo $v['uname'] ?></td>
                                        <td><?php echo $v['jiben'];?></td>
                                        <td><?php echo $v['ticheng'];?></td>
                                        <td><?php echo $v['jixiao'];?></td>
                                        <td><?php echo $v['quanqin'];?></td>
                                        <td><?php echo $v['jiangjin'];?></td>
                                        <td><?php echo $v['chufa'];?></td>
                                        <td><?php echo $v['qingjia'];?></td>
                                        <td><?php echo $v['buzhu'];?></td>
                                        <td><?php echo $v['chuqin'];?></td>
                                        <td><?php echo $v['total'];?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                                操作  ＋
                                                <ul class="menu">
                                                    <li class="menu-item"><a onclick="fill_apply(27, <?php echo $v['id'] ?>)">编辑</a></li>
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

<script>
$(function(){
        $('.sear').click(function(){
            $("#payRoll_form").attr('action','<?php echo spUrl($c,$a);?>');
            $("#payRoll_form").submit();
        })
        $('.daochu').click(function(){
            $('#payRoll_form').attr('action','<?php echo spUrl($c,'dcPayRoll');?>');
            $("#payRoll_form").submit();
        });
        $('.dayin').click(function(){
            var mon = $('#month').val();
            var bumen = $('#bumen').val();
            url = '<?php echo spUrl($c,'dyPayRoll');?>';
            url = url + '/month/'+mon+'/bumen/'+bumen;
            window.open(url);
        })
    })
</script>
