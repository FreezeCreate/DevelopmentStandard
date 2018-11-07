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
						<ul class="TablesHeadNav">
							<li class="TablesHeadItem active"><a style="color:#ffffff;">菜单角色管理</a></li>
						</ul>	
				
				<div class="TablesSerch">
                <form action="" method="post">
                    <label class="form-group">
                        角色名：<input class="FrameGroupInput" type="text" name="username" placeholder="角色名"/>
                    </label>
                        <button class="Btn Btn-primary">查询</button>
                        <span class="Btn Btn-info TablesSerchReset">重置</span>
                        <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
			<div class="TablesAddBtn addMenu" data-bind="addMenu" ><a  style="color:#ffffff;" class="btn btn-primary" href="<?php echo spUrl($c,'addRole')?>">＋ 添 加 菜 单 角 色</a></div>
			</div>
             <div class="TablesBody top20">
            <table class="table table-info table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>角色名称</th>
                        <th style="width: 70%;">拥有权限</th>
                        <th style="width: 200px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($role as $k => $v) { ?>
                        <tr class="">
                            <td><?php echo $v['id'] ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['auth'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         
                                <?php if ($v['id'] > 1) { ?>
                                   <li class="menu-item"> <a class="btn btn-blue" href="<?php echo spUrl($c, 'editRole', array('id' => $v['id'])) ?>">编辑</a></li>
                                   <li class="menu-item"> <a class="btn btn-red del-t" itemid="<?php echo $v['id'] ?>" onclick="del_form(<?php echo $v['id'];?>)"> 删除</a></li>
                                <?php } ?>
                                </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
		</div>
    </div>
    <!--
    作者：895635200@qq.com
    时间：2017-08-11
    描述：主内容区域end
    -->

</body>

</html>

<script>
    // $(document).on('click', '.del-t', function() {
    // if (confirm("确认删除？")) {
            // var id = $(this).attr('itemid');
            // $.get("<?php echo spUrl($c, "delRole"); ?>", {id: id}, function(data) {
                // if (data.status == 1) {
                    // $('.Branch' + id).remove();
                // } else {
                    // alert(data.msg);
                // }
            // }, "json");
        // }
        // });
		 function del_form( id) {
			Confirm('确定删除该公司信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delRole"); ?>",{id: id}, function(data) {
						if (data.status == 1) {
							$('.Menu' + id).remove();
							$('.Branch' + id).remove();
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