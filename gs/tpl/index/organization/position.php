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
							<li class="TablesHeadItem active"><a style="color:#ffffff;">职位管理</a></li>
						</ul>	
             <div class="TablesSerch">
                <form action="<?php echo spUrl($c, $a) ?>" method="post">
                    <label class="form-group">
                        部门：<select class="TablesSerchInput" name="departmentid">
                            <option value="0">全部</option>
                            <?php foreach ($dresults as $k => $v) { ?>
                                <option <?php echo $page_con['departmentid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label class="form-group">
                        <input class="TablesSerchInput" type="text" placeholder="编号" name="number" value="<?php echo $page_con['number'] ?>"/>
                    </label>
                    <label class="form-group">
                        <input class="TablesSerchInput" type="text" placeholder="职位名称" name="name" value="<?php echo $page_con['name'] ?>"/>
                    </label>
                        <button class="Btn Btn-primary">查询</button>
                        <span class="Btn Btn-info TablesSerchReset">重置</span>
                        <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
				 <a class="btn btn-primary get-upBox addPosition" data-bind="addPosition"><div class="TablesAddBtn">	 添 加 职 位</div></a>
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
                        <th>职位名称</th>
                        <th>所属部门</th>
                        <th>备注</th>
                        <th>排序</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Position<?php echo $v['id'] ?>">
                            <td class="data-number" title="<?php echo $v['number'] ?>"><?php echo $v['number'] ?></td>
                            <td class="data-name" title="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></td>
                            <td class="data-departmentid" title="<?php echo $v['departmentid'] ?>"><?php echo $dresults[$v['departmentid']] ?></td>
                            <td class="data-remark" title="<?php echo $v['remark'] ?>"><?php echo $v['remark'] ?></td>
                            <td class="data-sort" title="<?php echo $v['sort'] ?>"><?php echo $v['sort'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
                                <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v['id'] ?>" data-bind="addPosition">编辑</a></li>
                                <li class="menu-item"> <a class="btn btn-red del-t" itemid="<?php echo $v['id'] ?>" onclick="del_form(<?php  echo $v['id'];?>)" >删除</a>
                                </li>
                                </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
				<?php }?>
		</div>
    </div>
            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：导入excel弹出框start
            -->
  
            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：导入excel弹出框end
            -->
            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：添加材料弹出框start
            -->
 		<div class="Person">
            <div class="upBox add PersonBox" id="addMenu" style="width:auto;">
                <div class="upBox-t">
                    <div class="PersonTit"><a style="color:#ffffff;">添加职位信息</a><span class="close"></span></div>
                </div>
                <div class="upBox-c">
                    <form id="addPosition_form" method="post" action="" onsubmit="return false;">
						<div class="FrameCont">
						<div class="FrameTable">
						<div class="FrameTableTitl">添加职位信息</div>
                        <input type="hidden" id="Mid" name="id" value=""/>
                        <table class="table table-add FrameTableCont">
                            <tbody >
                                <tr>
                                    <td class="FrameGroupName">职位名称</td>
                                    <td><input class="FrameGroupInput" type="text" id="name" name="name"/></td>
                                    <td class="FrameGroupName">编号</td>
                                    <td><input class="FrameGroupInput" type="text" id="number" name="number"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">所属部门</td>
                                    <td><select class="FrameGroupInput" id="departmentid" name="departmentid">
                                            <?php foreach ($dresults as $k => $v) { ?>
                                                <option <?php echo $page_con['pid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="FrameGroupName">排序</td>
                                    <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"> 备注</td>
                                    <td colspan="3"><input style="width:600px;" class="FrameGroupInput" type="text" id="remark" name="remark"/></td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
						</div>
						</div>
                    </form>
						<div class="PersonFoot">
							<a class="btn-sm btn-blue" onclick="do_addPosition()"><span class="Btn Big">确认</span></a>
					</div>
                </div>
            </div>
		</div>
            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：添加材料弹出框end
            -->

    <!--
    作者：895635200@qq.com
    时间：2017-08-11
    描述：主内容区域end
    -->
</section>
</body>

</html>

<script>
    function do_submit() {
        loading();
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadExcel"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            error: function(data, status, e) {
                $("#uploading").hide();
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "<?php echo spUrl($c, "importExcel"); ?>",
                        data: {filename: data.src},
                        dataType: "json",
                        async: false,
                        error: function(request) {
                            loading('none');
                            alert("数据提交失败！");
                        },
                        success: function(data) {
                            loading('none');
                            if (data.status == 1) {
                                alert(data.msg);
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    alert(data.msg);
                }
            },
        });
        return false;

    }

    function do_addPosition() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savePosition"); ?>",
            data: $('#addPosition_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
            },
            success: function(data) {
                if (data.status == 1) {
                    $('#addPosition .close').click();
                    window.location.reload();
                } else if (data.status == 2) {
					$('.PersonBox').animate({'top': '-500px'},300,function(){
					$('.Person').hide();
					});
                    $('.Position' + data.data.id + ' .data-name').attr('title', data.data.name);
                    $('.Position' + data.data.id + ' .data-name').text(data.data.name);
                    $('.Position' + data.data.id + ' .data-number').attr('title', data.data.number);
                    $('.Position' + data.data.id + ' .data-number').text(data.data.number);
                    $('.Position' + data.data.id + ' .data-departmentid').attr('title', data.data.departmentid);
                    $('.Position' + data.data.id + ' .data-departmentid').text(data.data.department);
                    $('.Position' + data.data.id + ' .data-remark').attr('title', data.data.remark);
                    $('.Position' + data.data.id + ' .data-remark').text(data.data.remark);
                    $('.Position' + data.data.id + ' .data-sort').attr('title', data.data.sort);
                    $('.Position' + data.data.id + ' .data-sort').text(data.data.sort);
                    $('#addPosition .close').click();
                } else {
                    alert(data.msg);
                }

            }
        });
    }
    ;
    
    $(document).on('click', '.addPosition', function() {
		$('.Person').show();
		PersonInit();
		$('.PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('添加职位信息');
				 $('.FrameTableTitl').text('添加职位信息');
        $('#Mid').val('');
        $('#name').val('');
        $('#number').val('');
        $('#departmentid').val('');
        $('#remark').val('');
        $('#sort').val('');
    });

    $(document).on('click', '.edit-t', function() {
		$('.Person').show();
		PersonInit();
		$('.PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('修改职位信息');
				 $('.FrameTableTitl').text('修改职位信息');
        var id = $(this).attr('itemid');
        $('#Mid').val(id);
        $('#name').val($('.Position' + id + ' .data-name').attr('title'));
        $('#number').val($('.Position' + id + ' .data-number').attr('title'));
        $('#departmentid').val($('.Position' + id + ' .data-departmentid').attr('title'));
        $('#remark').val($('.Position' + id + ' .data-remark').attr('title'));
        $('#sort').val($('.Position' + id + ' .data-sort').attr('title'));
    });


    // $(document).on('click', '.del-t', function() {
        // if (confirm("确认删除？")) {
            // var id = $(this).attr('itemid');
            // $.get("<?php echo spUrl($c, "delPosition"); ?>", {id: id}, function(data) {
                // if (data.status == 1) {
                    // $('.Position' + id).remove();
                // } else {
                    // alert(data.msg);
                // }
            // }, "json");
        // }
    // });
	
			$('.close').click(function(){
		$('.PersonBox').animate({'top': '-500px'},300,function(){
			$('.Person').hide()
		})
	})
	
		 function del_form( id) {
			Confirm('确认删除该职位？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delPosition"); ?>",{id: id}, function(data) {
						if (data.status == 1) {
							 $('.Position' + id).remove();
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
