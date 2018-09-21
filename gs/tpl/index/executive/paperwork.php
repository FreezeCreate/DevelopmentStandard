<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>工作日报</title>
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
                
				</div>
      
            <!--            <div class="search">
                            <form action="<?php echo spUrl($c, $a) ?>" method="get">
                                <label class="form-group">
                                    证件名称：<input class="input-text" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="证件名称"/>
                                </label>
                                <label class="form-group">
                                    持证人：<input class="input-text" type="text" name="uname" value="<?php echo $page_con['uname'] ?>" placeholder="持证人姓名"/>
                                </label>
                                <button class="btn btn-sm btn-gray">搜索</button>
                            </form>
                        </div>-->
					<div class="TablesAddBtn" onclick="fill_apply(2)">＋ 添 加 证 件</div>
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
            <table class="table table-info table-lst table-hover">
                <thead>
                    <tr>
                        <th>持证人</th>
                        <th>证件名称</th>
                        <th>证件编号</th>
                        <th>照片</th>
                        <th>操作人</th>
                        <th>备注</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Results<?php echo $v['id'] ?>">
                            <td><?php echo $v['uname'] ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['number'] ?></td>
                            <td><?php echo empty($v['image']) ? '' : '<img style="max-height:60px;" src="' . $v['image'] . '"/>'; ?></td>
                            <td><?php echo $v['optname'] ?></td>
                            <td><?php echo $v['explain'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item"><a onclick="check_apply(2, <?php echo $v['id'] ?>)">详情</a></li>
                                        <li class="menu-item"> <a onclick="fill_apply(2, <?php echo $v['id'] ?>)">编辑</a></li>
                                       <li class="menu-item"> <a class="color-red" onclick="del_form(<?php echo $v['id'] ?>)">删除</a></li>
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
    <!--
    作者：895635200@qq.com
    时间：2017-08-11
    描述：主内容区域end
    -->

</body>

</html>
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
<script>
    function voidBox(id) {
        if (confirm('确定作废？')) {
            $.get("<?php echo spUrl($c, "voidFunds"); ?>", {id: id}, function(data) {
                if (data.status == 1) {
                    $('.Results' + id + ' .data-status').removeClass('color-green,color-red,color-gray');
                    $('.Results' + id + ' .data-status').addClass('color-gray');
                    $('.Results' + id + ' .data-status').text('已作废');
                    $('.Results' + id + ' .opt .operate ul li.void').remove();
                }
                $('.operate').hide();
            }, 'json');
        }
    };
	

    // function del_form() {
        // loading();
        // $.ajax({
            // cache: false,
            // type: "POST",
            // url: "<?php echo spUrl($c, "delPaperwork"); ?>",
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
			Confirm('确定删除该信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delPaperwork"); ?>",{id: id}, function(data) { alert(id)
					$('.Results'+id).remove();
							Alert(data.msg, function() {
								window.location.reload();
							});

						$('.operate').hide();
					}, 'json');
				}
			});
		};
</script>
