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
                <form action="<?php echo spUrl($c,$a);?>" method="get">
                <label class="form-group">
                   <input type="text" class="TablesSerchInput" name="name" value="<?php echo $page_con['name']?>" placeholder=" 主题"/>
                </label>
                    <button class="Btn Btn-primary">查询</button>
                    <span class="Btn Btn-info TablesSerchReset">重置</span>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
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
                        <th>编号</th>
                        <th>主题</th>
                        <th>类型</th>
                        <th>日期</th>
                        <th>操作人</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr >
                            <td><?php echo $k ?></td>
                            <td><?php echo $v['name']; ?></td>
                            <td><?php echo $GLOBALS['CULSYS_TYPE'][$v['type']] ?></td>
                            <td><?php echo $v['zddt'] ?></td>
                            <td><?php echo $v['optname'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
									<a onclick="check_apply(39, <?php echo $v['id'] ?>)">详情</a>
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
	  <?php }?>
    </div>
</div>	
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
    <script type="text/javascript">
        function del_form() {
            loading();
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "delInfor"); ?>",
                data: $('#Delete_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    loading('none');
                    alert('提交失败');
                },
                success: function(data) {
                    if (data.status == 1) {
                        $('.Results' + data.data).remove();
                        $('#Delete_upBox .close').click();
                        table_sort();
                        loading('none');
                    } else {
                        loading('none');
                        alert(data.msg);
                    }

                }
            });
        }
    </script>
</section>
</body>
</html>





