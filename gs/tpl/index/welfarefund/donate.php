<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>基金捐献记录</title>
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
                            <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="捐赠人"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <label class="form-group">累计捐赠：<?php echo $sum['money']*1?></label>
                    <label class="form-group">累计支出：<?php echo $sum['pay']*1?></label>
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
                                    <td>捐赠人</td>
                                    <td>捐赠对象</td>
                                    <td>捐赠金额</td>
                                    <td>捐赠时间</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td class="data-name"><?php echo $v['uname'] ?></td>
                                        <td class="data-name"><?php echo $v['objname'] ?></td>
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
                <div class="TanBoxTit">捐献记录 <span class="close OtPop"data-BoxId="genjin"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="genjin_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">捐献人</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="recorder" placeholder="" value="<?php echo $result['recorder'] ?>"/>
                                    <input type="hidden" class="uid" name="rid" value="<?php echo $result['rid'] ?>"/>
                                    <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                                <td class="FrameGroupName">捐献金额</td>
                                <td><input class="FrameGroupInput" type="text" name="money"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">捐献对象</td>
                                <td>
                                    <select class="FrameGroupInput" name="objid">
                                        <option value="">请选择...</option>
                                        <?php foreach($objs as $v){?>
                                        <option value="<?php echo $v['id']?>"><?php echo $v['name'].'（'.$GLOBALS['DONATION_TYPE'][$v['type']].'）'?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
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

function do_genjin() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveDonate"); ?>",
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





