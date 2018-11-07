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
                <form action="<?php echo spUrl($c, $a) ?>" method="get">
                    <label class="form-group">
                    <input type="text" class="FrameGroupInput" name="uname" value="<?php echo $page_con['uname']?>" placeholder="申请人"/>
                    </label>
					 	<button class="Btn Btn-primary">查询</button>
						<span class="Btn Btn-info TablesSerchReset">重置</span>
						<a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
				</div>
			<a class="btn btn-primary" onclick="fill_apply(19)"><div class="TablesAddBtn">＋添 加</div> </a>
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
                        <th style="width:20px;"></th>
                        <th>申请人</th>
                        <th>申请人部门</th>
                        <th>开始时间</th>
                        <th>截止时间</th>
                        <th>目的地</th>
                        <th>车牌号</th>
                        <th>领车时间</th>
                        <th>归还时间</th>
                        <th>状态</th>
                        <th style="width: 200px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                    <tr class="Results<?php echo $v['id']?>">
                            <td><?php echo $k + 1; ?></td>
                            <td><?php echo $v['uname'] ?></td>
                            <td><?php echo $v['udeptname'] ?></td>
                            <td><?php echo $v['start'] ?></td>
                            <td><?php echo $v['end'] ?></td>
                            <td><?php echo $v['mudi'] ?></td>
                            <td><?php echo $v['gname'] ?></td>
                            <td><?php echo $v['takedt'] ?></td>
                            <td><?php echo $v['redt'] ?></td>
                            <td class="data-status color-<?php echo $status[$v['status']]['color'] ?>"><?php echo $status[$v['status']]['text'] ?></td>
                             <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
									        <a onclick="check_apply(19, <?php echo $v['id'] ?>)">详情</a></li>
                                             <?php if ($admin['id'] == $v['uid']) { ?>
                                             <li><a onclick="fill_apply(19, <?php echo $v['id'] ?>)">编辑</a></li>
                                              <?php if ($v['status'] != 0) { ?><a class="color-gray" onclick="voidBox(<?php echo $v['id'] ?>)">作废</a><?php } ?>
                                            <li><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
                                            <?php } ?>
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
        function voidBox(id) {
            if (confirm('确定作废？')) {
                $.get("<?php echo spUrl($c, "voidCarmsapl"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id + ' .data-status').removeClass('color-green,color-red,color-gray');
                        $('.Results' + id + ' .data-status').addClass('color-gray');
                        $('.Results' + id + ' .data-status').text('已作废');
                        $('.Results' + id + ' .opt .operate ul li.void').remove();
                    }
                    $('.operate').hide();
                }, 'json');
            }
        }
        ;
        // function del(id) {
            // if (confirm('确定删除？')) {
                // $.get("<?php echo spUrl($c, "delCarmsapl"); ?>", {id: id}, function(data) {
                    // if (data.status == 1) {
                        // $('.Results' + id).remove();
                        // table_sort();
                    // }
                // }, 'json');
            // }
        // }
		 function del( id) {
			Confirm('确定删除？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delCarmsapl"); ?>",{id: id}, function(data) {
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
		
		function voidBox( id) {
			Confirm('确定作废？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "voidCarmsapl"); ?>",{id: id}, function(data) {
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
		};
		
		
    </script>
</section>
</body>
</html>





