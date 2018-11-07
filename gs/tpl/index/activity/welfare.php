<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>公益活动</title>
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
                            <input class="TablesSerchInput" name="name" type="text"  placeholder="活动名称" value="<?php echo $page_con['name'] ?>"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn" onclick="fill_apply(34)">＋ 新增</div>
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
                                    <td>公益名称</td>
                                    <td>公益对象</td>
                                    <td>活动开始时间</td>
                                    <td>活动结束时间</td>
                                    <td>公益地点</td>
                                    <td>预算</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k+1;?></td>
                                        <td><?php echo $v['name'];?></td>
                                        <td><?php echo $v['objname'];?></td>
                                        <td><?php echo $v['statdt'];?></td>
                                        <td><?php echo $v['enddt'];?></td>
                                        <td><?php echo $v['address'];?></td>
                                        <td><?php echo $v['ymoney'];?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(34,<?php echo $v['id'] ?>)">详情</a></li>
                                                <li class="menu-item"><a onclick="fill_apply(34,<?php echo $v['id'] ?>)">编辑</a></li>
                                                <li class="menu-item"><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
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
    function del(id) {
        Confirm('确定删除该活动？', function(e) {
            if (e) {
                $.post("<?php echo spUrl($c, "delWelfare"); ?>", {id:id}, function(data) {
                    if (data.status == 1) {
                        Alert(data.msg, function() {
                            window.location.reload();
                        });
                    } else {
                        Alert(data.msg);
                    }
                    $('.operate').hide();
                }, 'json');
            }
        });
    }
</script>
