<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>基金支出记录</title>
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
                            <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <label class="form-group">累计支出：<?php echo $sum['money']*1?></label>
                    <div class="TablesAddBtn InPop" data-BoxId="genjin">＋ 新增</div>
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
                                    <td>支出对象</td>
                                    <td>简介</td>
                                    <td>支出金额</td>
                                    <td>支出时间</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td class="data-name"><?php echo $v['name'] ?></td>
                                        <td class="data-name"><?php echo $v['explain'] ?></td>
                                        <td class="data-optname"><?php echo $v['money'] ?></td>
                                        <td class="data-optname"><?php echo $v['adddt'] ?></td>
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
        <div class="Tan" id="genjin">
            <div class="TanBox">
                <div class="TanBoxTit">基金支出 <span class="close OtPop"data-BoxId="genjin"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="genjin_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">支出对象</td>
                                <td>
                                    <select class="FrameGroupInput" name="objid">
                                        <option value="">请选择...</option>
                                        <?php foreach($objs as $v){?>
                                        <option value="<?php echo $v['id']?>"><?php echo $v['name'].'（'.$GLOBALS['DONATION_TYPE'][$v['type']].'）'?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="FrameGroupName">支出金额</td>
                                <td><input class="FrameGroupInput" type="text" name="money"/></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="genjin" onclick="do_genjin()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="genjin">取消</span>
                        </div>
                    </div>
                    </form>
                </div>
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
function do_genjin() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savePay"); ?>",
            data: $('#genjin_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.location.reload();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }

</script>





