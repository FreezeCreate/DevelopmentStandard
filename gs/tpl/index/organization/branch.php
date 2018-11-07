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
                <form action="<?php echo spUrl($c, $a) ?>" method="post">
<!--                    <label class="form-group">
                        分类：<select class="FrameGroupInput" name="typeid">
                            <option value="0">全部</option>
                            <?php foreach ($type as $k => $v) { ?>
                                <option <?php echo $page_con['typeid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </label>-->
                    <label class="form-group">
                       <input class="FrameGroupInput" type="text" name="number" placeholder="编号"  value="<?php echo $page_con['number'] ?>"/>
                    </label>
                    <label class="form-group">
                        <input class="FrameGroupInput" type="text" name="shopname" placeholder="公司名称关键字" value="<?php echo $page_con['shopname'] ?>"/>
                    </label>
                        <button class="Btn Btn-primary">查询</button>
                        <span class="Btn Btn-info TablesSerchReset">重置</span>
                        <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
			<div class="TablesAddBtn addBranch" data-bind="addBranch">添加公司信息</div>
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
                        <th>公司名称</th>
                        <th>电话</th>
                        <th>地址</th>
                        <th>邮箱</th>
                        <th>传真</th>
                        <th>备注</th>
                        <th>排序</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Branch<?php echo $v['id'] ?>">
                            <td class="data-number" title="<?php echo $v['number'] ?>"><?php echo $v['number'] ?></td>
                            <td class="data-shopname" title="<?php echo $v['shopname'] ?>"><?php echo $v['shopname'] ?></td>
                            <td class="data-telphone" title="<?php echo $v['telphone'] ?>"><?php echo $v['telphone'] ?></td>
                            <td class="data-address" title="<?php echo $v['address'] ?>"><?php echo $v['address'] ?></td>
                            <td class="data-email" title="<?php echo $v['email'] ?>"><?php echo $v['email'] ?></td>
                            <td class="data-fax" title="<?php echo $v['fax'] ?>"><?php echo $v['fax'] ?></td>
                            <td class="data-remark" title="<?php echo $v['remark'] ?>"><?php echo $v['remark'] ?></td>
                            <td class="data-sort" title="<?php echo $v['sort'] ?>"><?php echo $v['sort'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
                                         <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v['id'] ?>" data-bind="addBranch">编辑</a>
                                         </li>
                                <?php if($v['id']>1){?>
                                <li class="menu-item">
                                <a class="btn btn-red del-t" onclick="del_form(<?php echo $v['id'];?>)" >删除</a>
                                </li>
                                <?php }?>
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
		<div class="Person upBox add" id="addBranch">
			<div class="PersonBox" style="width:auto;">
				<div class="PersonTit"><a style="color:#ffffff;">添加公司信息</a><span class="close"></span></div>
				<div class="PersonCont">
                <div class="upBox-c">
                    <form id="addBranch_form" method="post" action="" onsubmit="return false;">
						<div class="FrameCont">
						<div class="FrameTable">
						<div class="FrameTableTitl">添加公司信息</div>
                        <input type="hidden" id="Mid" name="id" value=""/>
                        <table class="FrameTableCont">
                            <tbody>
                                <tr>
                                    <td  class="FrameGroupName">公司名称</td>
                                    <td><input class="FrameGroupInput" type="text" id="shopname" name="shopname"/></td>
                                    <td  class="FrameGroupName">编号</td>
                                    <td><input class="FrameGroupInput" type="text" id="number" name="number"/></td>
                                </tr>
                                <tr>
                                    <td  class="FrameGroupName">电话</td>
                                    <td><input class="FrameGroupInput" type="text" id="telphone" name="telphone"/></td>
                                    <td  class="FrameGroupName">邮箱</td>
                                    <td><input class="FrameGroupInput" type="text" id="email" name="email"/></td>
                                </tr>
                                <tr>
                                    <td  class="FrameGroupName">传真</td>
                                    <td><input class="FrameGroupInput" type="text" id="fax" name="fax"/></td>
                                    <td  class="FrameGroupName">排序</td>
                                    <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                                </tr>
                                <tr>
                                    <td  class="FrameGroupName">地址</td>
                                    <td colspan="3"><input style="width:90%;" class="FrameGroupInput" type="text" id="address" name="address"/></td>
                                </tr>
                                <tr>
                                    <td  class="FrameGroupName">备注</td>
                                    <td colspan="3"><input style="width:90%;" class="FrameGroupInput" type="text" id="remark" name="remark"/></td>
                                </tr>
                            </tbody>
                        </table>
						</div>
						</div>
                    </form>
					<div class="PersonFoot">
					<span class="Btn Big"><a class="btn-sm btn-blue" onclick="do_addBranch()">确认</a></span>
					</div>
                </div>
            </div>
            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：添加材料弹出框end
            -->
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
    function do_submit() {
        //loading();
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadExcel"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            error: function(data, status, e) {
                $("#up//loading").hide();
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
                            //loading('none');
                            alert("数据提交失败！");
                        },
                        success: function(data) {
                            //loading('none');
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

    function do_addBranch() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveBranch"); ?>",
            data: $('#addBranch_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
            },
            success: function(data) {
                if (data.status == 1) {
                    $('#addBranch .close').click();
                    window.location.reload();
                } else if (data.status == 2) {
                    $('.Branch' + data.data.id + ' .data-shopname').attr('title', data.data.shopname);
                    $('.Branch' + data.data.id + ' .data-shopname').text(data.data.shopname);
                    $('.Branch' + data.data.id + ' .data-number').attr('title', data.data.number);
                    $('.Branch' + data.data.id + ' .data-number').text(data.data.number);
                    $('.Branch' + data.data.id + ' .data-telphone').attr('title', data.data.telphone);
                    $('.Branch' + data.data.id + ' .data-telphone').text(data.data.telphone);
                    $('.Branch' + data.data.id + ' .data-address').attr('title', data.data.address);
                    $('.Branch' + data.data.id + ' .data-address').text(data.data.address);
                    $('.Branch' + data.data.id + ' .data-email').attr('title', data.data.email);
                    $('.Branch' + data.data.id + ' .data-email').text(data.data.email);
                    $('.Branch' + data.data.id + ' .data-fax').attr('title', data.data.fax);
                    $('.Branch' + data.data.id + ' .data-fax').text(data.data.fax);
                    $('.Branch' + data.data.id + ' .data-remark').attr('title', data.data.remark);
                    $('.Branch' + data.data.id + ' .data-remark').text(data.data.remark);
                    $('.Branch' + data.data.id + ' .data-sort').attr('title', data.data.sort);
                    $('.Branch' + data.data.id + ' .data-sort').text(data.data.sort);
                    $('#addBranch .close').click();
                } else {
                    alert(data.msg);
                }

            }
        });
    }
    ;
    
    $(document).on('click', '.addBranch', function() { 
		$('.Person').show()
		PersonInit();
		$('.PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('添加公司信息');
		$('.FrameTableTitl').text('添加公司信息');
        $('#Mid').val('');
        $('#shopname').val('');
        $('#number').val('');
        $('#telphone').val('');
        $('#address').val('');
        $('#email').val('');
        $('#fax').val('');
        $('#remark').val('');
        $('#sort').val('');
    });

    $(document).on('click', '.edit-t', function() {
		$('.Person').show()
		PersonInit()
		$('.PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('修改公司信息');
		$('.FrameTableTitl').text('修改公司信息');
        var id = $(this).attr('itemid');
        $('#Mid').val(id);
        $('#telphone').val($('.Branch' + id + ' .data-telphone').attr('title'));
        $('#number').val($('.Branch' + id + ' .data-number').attr('title'));
        $('#shopname').val($('.Branch' + id + ' .data-shopname').attr('title'));
        $('#address').val($('.Branch' + id + ' .data-address').attr('title'));
        $('#fax').val($('.Branch' + id + ' .data-fax').attr('title'));
        $('#email').val($('.Branch' + id + ' .data-email').attr('title'));
        $('#remark').val($('.Branch' + id + ' .data-remark').attr('title'));
        $('#sort').val($('.Branch' + id + ' .data-sort').attr('title'));
    });


		// $(document).on('click', '.del-t', function() {
			// if (confirm("确认删除？")) {
				// var id = $(this).attr('itemid');
				// $.get("<?php echo spUrl($c, "delBranch"); ?>", {id: id}, function(data) {
					// if (data.status == 1) {
						// $('.Branch' + id).remove();
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
			Confirm('确定删除该公司信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delBranch"); ?>",{id: id}, function(data) {
						if (data.status == 1) {
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
