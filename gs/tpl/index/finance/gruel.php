<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>罚款</title>
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
                        <span>收入资金：<?php echo $results['summoney'] ?>元</span>
                        <span>支出资金：<?php echo $results['money'] ?>元</span>
                        <span>余额：<?php echo ($results['summoney'] - $results['money']); ?>元</span>
                    </div>
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <select class="TablesSerchInput" name="type">
                                <option value="0">请选择类别</option>
                                <option <?php echo empty($page_con['type']) ? 'selected=""' : '' ?> value="">全部</option>
                                <option <?php echo $page_con['type'] == '1' ? 'selected=""' : '' ?> value="1">收入</option>
                                <option <?php echo $page_con['type'] == '-1' ? 'selected=""' : '' ?> value="-1">支出</option>
                            </select>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <div class="TablesAddBtn InPop" data-boxid="addGruel">＋ 新增</div>
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
                                        <td class="<?php echo $v['type'] > 0 ? 'color-green' : 'color-red'; ?>"><?php echo $v['type'] > 0 ? '+' . $v['money'] : '-' . $v['money']; ?></td>
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
        <div class="Tan " id="addGruel">
            <div class="TanBox ">
                <div class="TanBoxTit">添加罚款 <span class="close OtPop"data-BoxId="addGruel"></span></div>
                <div class="TanBoxCont">
                    <div class="FrameTable">
                        <form id="addResult_form" method="post" action="" onsubmit="return false;">
                            <div class="FrameTableTitl">添加罚款</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">处罚人  ：</td>
                                    <td colspan="3">
                                        <input class="FrameGroupInput uname" type="text" name="uname" placeholder="" value="<?php echo $result['uname'] ?>" placeholder='支出可不填'/>
                                        <input type="hidden" class="uid" name="uid" value="<?php echo $result['uid'] ?>"/>
                                        <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span class="color-red">*</span> 类别</td>
                                    <td>
                                        <select class="FrameGroupInput" name="type">
                                            <option value="1">处罚</option>
                                            <option value="-1">支出</option>
                                        </select>
                                    </td>
                                    <td class="FrameGroupName"><span class="color-red">*</span> 金额</td>
                                    <td><input class="FrameGroupInput" type="text" name="money"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">说明</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain"></textarea></td>
                                </tr>
                            </table>
                            <div class="TanBtn">
                                <span class="Btn Big InPop" onclick="do_sub()">确定</span>
                                <span class="Btn Big Blue OtPop"data-BoxId="addGruel">取消</span>
                            </div>
                        </form>
                    </div>
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
    <script>
            var Use;
//            var Pos;
//            var Dep;
            $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                    Use = {}
                    Use.status = 2;
                    Use.data = data.data[0].children;
            }, 'json');
            //职位
//            $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
            //部门
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveGruel"); ?>",
            data: $('#addResult_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                alert('提交失败');
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
</html>

