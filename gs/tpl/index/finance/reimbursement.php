<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>报销申请</title>
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
                            <select class="TablesSerchInput" name="type">
                                <option value="0">全部</option>
                                <?php foreach ($cate as $k => $v) { ?>
                                    <option <?php echo $page_con['type'] === $v['name'] ? 'selected=""' : '' ?> value="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></option>
                                <?php } ?>
                            </select>
                            <input class="TablesSerchInput" type="text" name="uname" value="<?php echo $page_con['uname'] ?>" placeholder="申请人"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <div class="TablesAddBtn" onclick="fill_apply(16)">＋ 新增</div>
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
                                    <td>申请人</td>
                                    <td>申请日期</td>
                                    <td>报销类别</td>
                                    <td>报销金额</td>
                                    <td>说明</td>
                                    <td>状态</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Results<?php echo $v['id'] ?>">
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['uname'] ?></td>
                                        <td><?php echo $v['applydt'] ?></td>
                                        <td><?php echo $v['type'] ?></td>
                                        <td>￥<?php echo $v['money'] ?></td>
                                        <td><?php echo $v['explain'] ?></td>
                                        <td class="data-status color-<?php echo $status[$v['status']]['color'] ?>"><?php echo $status[$v['status']]['text'] ?></td>
                                        <td>
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(16, <?php echo $v['id'] ?>)">详情</a></li>
                                                <?php if ($admin['id'] == $v['uid']) { ?>
                                                <li class="menu-item"><a onclick="fill_apply(16, <?php echo $v['id'] ?>)">编辑</a></li>
                                                <?php if ($v['status'] != 0) { ?><li class="menu-item void"><a class="color-gray" onclick="voidBox(<?php echo $v['id'] ?>)">作废</a></li><?php } ?>
                                                <li class="menu-item"><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
                                                <?php } ?>
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
function voidBox(id) {
            Confirm('确定作废？',function(){
                $.get("<?php echo spUrl($c, "voidReimbursement"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id + ' .data-status').removeClass('color-green,color-red,color-gray');
                        $('.Results' + id + ' .data-status').addClass('color-gray');
                        $('.Results' + id + ' .data-status').text('已作废');
                        $('.Results' + id + ' .opt .operate ul li.void').remove();
                    }
                    $('.menu').hide();
                }, 'json');
            })
        }
        ;
        function del(id) {
            Confirm('确定删除？',function(){
                $.get("<?php echo spUrl($c, "delReimbursement"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id).remove();
                    }
                }, 'json');
            })
        }

</script>
