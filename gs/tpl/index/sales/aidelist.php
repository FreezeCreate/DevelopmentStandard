<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>文化</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>

        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a); ?>" method="get">
                            <label class="form-group">
                                <input type="text" class="TablesSerchInput" name="name" value="<?php echo $page_con['name'] ?>" placeholder=" 主题"/>
                            </label>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn NewPop" data-url="<?php echo spUrl('sales', 'addaide') ?>" data-title="新增销售助手">＋ 新增</div>
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
                        <table class="table table-info table-hover">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>标题</th>
                                    <th>操作人</th>
                                    <th>操作日期</th>
                                    <th style="width: 150px;">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr >
                                        <td><?php echo $k + 1 ?></td>
                                        <td><?php echo $v['title']; ?></td>
                                        <td><?php echo $v['optname'] ?></td>
                                        <td><?php echo $v['optdt'] ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                                操作  ＋
                                                <ul class="menu">
                                                    <li class="menu-item">
                                                        <a class="NewPop" data-url="<?php echo spUrl('sales', 'aideinfo', array('id' => $v['id'])) ?>" data-title="销售助手详情">详情</a>
                                                        <a class="NewPop" data-url="<?php echo spUrl('sales', 'addaide', array('id' => $v['id'])) ?>" data-title="编辑销售助手">编辑</a>
                                                        <a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php require_once TPL_DIR . '/layout/page.php'; ?>
                    </div>
                <?php } ?>
            </div>
        </div>	
        <?php require_once TPL_DIR . '/layout/apply.php'; ?>
        <script type="text/javascript">
            function del(id) {
                Confirm('确定删除该信息吗？', function(e) {
                    if (e) {
                        $.post("<?php echo spUrl($c, "delAide"); ?>", {id: id}, function(data) {
                            if (data.status == 1) {
                                $('man' + id).remove();
                                Alert(data.msg, function() {
                                    window.location.reload();
                                });
                            } else {
                                Alert(data.msg);
                            }
                        }, 'json');
                    }
                });
            }
        </script>
    </section>
</body>
</html>





