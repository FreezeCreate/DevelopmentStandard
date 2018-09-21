<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>填写工资单</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <style>
    .payinp { display: block; text-align: center; height: 25px; line-height: 25px; border-radius: 3px; border: 1px solid #ccc; width: 90%;}
    .tot { display: block; text-align: center; height: 25px; line-height: 25px; border-radius: 3px; border: 1px solid #ccc; width: 90%;}
    .chufa .payinp,.qingjia .payinp { color: red;}
    .ticheng .payinp,.quanqin .payinp,.jiangjin .payinp,.buzhu .payinp,.jixiao .payinp,.jiben .payinp{ color: green;}
    .table tr td { width: 7%;}
</style>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <form action="" method="post" id="sub_form">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <select class="TablesSerchInput" name="month" id='month'>
                                <?php for ($i=0;$i<12;$i++) { ?>
                                <?php $month = date('Ym',strtotime('-'.$i.'month'));?>
                                    <option <?php echo $page_con['month'] === $month ? 'selected=""' : '' ?> value="<?php echo $month ?>"><?php echo $month ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <div class="TablesAddBtn NewHtml a_05" data-clas="a_05" data-name="填写工资单" data-img="<?php echo SOURCE_PATH; ?>/images/shouye_61.png" data-url="<?php echo spUrl('finance','addpayroll')?>">＋ 填写</div>
                </div>
                <?php if (empty($user)) { ?>
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
                                    <td>职位</td>
                                    <td>工号</td>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user as $k => $v) { ?>
                                    <tr class="money Results<?php echo $v['id'] ?>">
                                        <td><?php echo $v['positionname'];?></td>
                                        <td><?php echo $v['number'];?></td>
                                        <td><?php echo $v['name']; ?><input type='hidden' value='<?php echo $v['name'];?>' name='gongz[<?php echo $v['id']?>][uname]'  /></td>
                                        <td class="jiben"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][jiben]"/></td>
                                        <td class="ticheng"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][ticheng]"/></td>
                                        <td class="jixiao"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][jixiao]"/></td>
                                        <td class="quanqin"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][quanqin]"/></td>
                                        <td class="jiangjin"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][jiangjin]"/></td>
                                        <td class="chufa"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][chufa]"/></td>
                                        <td class="qingjia"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][qingjia]"/></td>
                                        <td class="buzhu"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][buzhu]"/></td>
                                        <td class="chuqin"><input class="payinp" type="text" name="gongz[<?php echo $v['id']?>][chuqin]"/></td>
                                        <td class="total"><input class="tot" type="text" name="gongz[<?php echo $v['id']?>][total]"/></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8"><a class="Btn Btn-info" onclick="do_sub()">保存</a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
                </form>
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

        $('.payinp').keyup(function(){
            for($i=0;$i<$('.money').length;$i++){
                $total = $('.money').eq($i).children('.jiben').children('.payinp').val()*1+$('.money').eq($i).children('.ticheng').children('.payinp').val()*1+$('.money').eq($i).children('.quanqin').children('.payinp').val()*1+$('.money').eq($i).children('.jiangjin').children('.payinp').val()*1-$('.money').eq($i).children('.chufa').children('.payinp').val()*1-$('.money').eq($i).children('.qingjia').children('.payinp').val()*1  +  $('.money').eq($i).children('.buzhu').children('.payinp').val()*1 + $('.money').eq($i).children('.jixiao').children('.payinp').val()*1;
                $('.money').eq($i).children('.total').children('input').val($total.toFixed(2));
            }
        });
        
        function do_sub() {
            Confirm('确认已检查完工资单填入信息?',function(){
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "<?php echo spUrl($c, "savePayroll"); ?>",
                    data: $('#sub_form').serialize(),
                    dataType: "json",
                    async: false,
                    error: function(request) {
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            Alert(data.msg);
                        } else {
                            Alert(data.msg);
                        }

                    }
                });
            });
        }
</script>
