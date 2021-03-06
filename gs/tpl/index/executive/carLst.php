<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>车辆列表</title>
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
                <label class="form-group">
                    <input type="text" class="FrameGroupInput" placeholder="车牌号"/>
                </label>
				<button class="Btn Btn-primary">查询</button>
				<span class="Btn Btn-info TablesSerchReset">重置</span>
				<a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
            </div>
			<a class="btn btn-primary" onclick="fill_apply(18)"><div class="TablesAddBtn">＋添 加</div> </a>
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
                        <th>车牌号</th>
                        <th>车辆类型</th>
                        <th>车辆品牌</th>
                        <th>型号</th>
                        <th>购买日期</th>
                        <th>购买价格</th>
                        <th>状态</th>
                        <th>说明</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Results<?php echo $v['id'] ?>">
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['type'] ?></td>
                            <td><?php echo $v['brank'] ?></td>
                            <td><?php echo $v['format'] ?></td>
                            <td><?php echo $v['date'] ?></td>
                            <td><?php echo empty($v['money']) ? '' : $v['money'] . '元'; ?></td>
                            <td><?php echo $GLOBALS['CARMS_STATUS'][$v['status']] ?></td>
                            <td><?php echo $v['explain'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item"><a onclick="check_apply(18, <?php echo $v['id'] ?>)">详情</a></li>
                                         <li class="menu-item"><a onclick="fill_apply(18, <?php echo $v['id'] ?>)">编辑</a></li>
                                         <li class="menu-item"><a class="color-red" onclick="del_form(<?php echo $v['id'] ?>)">删除</a></li>
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
        // function del_form() {
            // loading();
            // $.ajax({
                // cache: false,
                // type: "POST",
                // url: "<?php echo spUrl($c, "delCarms"); ?>",
                // data: $('#Delete_form').serialize(),
                // dataType: "json",
                // async: false,
                // error: function(request) {
                    // loading('none');
                    // alert('提交失败');
                // },
                // success: function(data) {
                    // if (data.status == 1) {
                        // $('.Results' + data.data).remove();
                        // $('#Delete_upBox .close').click();
                        // table_sort();
                        // loading('none');
                    // } else {
                        // loading('none');
                        // alert(data.msg);
                    // }

                // }
            // });
        // }
			 function del_form( id) {
			Confirm('确定删除该公司信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delCarms"); ?>",{id: id}, function(data) {
						if (data.status == 1) {
							$('.Results' + id).remove();
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
		};
    </script>

</body>
</html>





