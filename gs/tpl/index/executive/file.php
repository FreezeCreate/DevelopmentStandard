<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>收发文件管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>

        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                 <div class="TablesSerch">
                <form action="<?php echo spUrl($c,$a);?>" method="get">
                <label class="form-group">
                    <input type="text" class="TablesSerchInput" name="name" value="<?php echo $page_con['name']?>" placeholder="文件名称"/>
                </label>
                    <button class="Btn Btn-primary">查询</button>
                    <span class="Btn Btn-info TablesSerchReset">重置</span>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
				</div>
					<div class=" TablesAddBtn addResult"> ＋ 添 加</div>
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
                        <th>名称</th>
                        <th>文件</th>
                        <th>文件大小</th>
                        <th>添加时间</th>
                        <th>操作人</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                    <tr class="Results<?php echo $v['id']?>">
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><a href="<?php echo spUrl('main', 'download', array('id' => $v['detail']['id'])) ?>"><?php echo $v['detail']['filename'] ?></a></td>
                            <td><?php echo $v['detail']['filesizecn'] ?></td>
                            <td><?php echo $v['optdt'] ?></td>
                            <td><?php echo $v['optname'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                
                                             <li class="menu-item"><a href="<?php echo spUrl('main', 'download', array('id' => $v['detail']['id'])) ?>">下载</a></li>
                                        <?php if ($admin['id'] == $v['optid']) { ?>
                                           <li class="menu-item"><a class="get-upBox edit-t" data-bind="addResult" itemid="<?php echo $v['id'] ?>">编辑</a></li>
                                            <li class="menu-item"><a class="color-red" onclick="del_form(<?php echo $v['id'] ?>)">删除</a></li>
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
	<div class="Person">
		<div class="PersonBox upBox add" id="addResult"  style="left: 33%">
			<div class="Frame" style="width: 50%;height: 50%">
			<div class="FrameTit"><span class="FrameTitName">添加文件</span><span class="close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
					<div class="FrameTable">
                    <form id="addResult_form" method="post" action="" onsubmit="return false;">
                        <input type="hidden" id="Mid" name="id" value=""/>
						<div class="FrameTableTitl">添加文件</div>
						<table class="FrameTableCont">
                                <tr>
                                    <td width="150px" class="FrameGroupName">名称</td>
                                    <td><input class="FrameGroupInput" type="text" id="name" name="name" placeholder="不填则默认为文件名"/></td>
                                    <td width="150px" class="FrameGroupName">查看权限</td>
                                    <td><select class="FrameGroupInput" id="authtype" name="authtype">
                                            <option value="1">所有人可见</option>
                                            <option value="2">公司内部可见</option>
                                            <option value="3">部门内部可见</option>
                                            <option value="4">仅自己可见</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td width="150px" class="FrameGroupName">文件</td>
                                    <td colspan="3">
                                       <ul class="FileBox">

                                        </ul>
                                        <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file"  />
                                        <span class="addFile">+添加文件</span>
									</td>
                                </tr>
                        </table>
                    </form>

                </div>
            </div>
        </div>
		<div class="FrameTableFoot">
            <a class="but but-primary" onclick="do_addResult()"><span class="Btn Big">确认</span></a>
         </div>
    </div>
	</div>
</div>	

<?php require_once TPL_DIR . '/layout/apply.php'; ?>
    <script type="text/javascript">
        $(document).on('click', '.edit-t', function() {
		
			$('.Person').show()
			PersonInit();
			$('.PersonBox').animate({'top': 80},300);
            $('.FrameTitName').text('更新文件');
              $('.FrameTableTitl').text('更新文件');
            var id = $(this).attr('itemid');
            //loading();
            $.get('<?php echo spUrl($c, 'findFile'); ?>', {id: id}, function(data) {
                if (data.status == 1) {
                    $('#Mid').val(id);
                    $('#name').val(data.data.name);
                    $('#authtype').val(data.data.authtype);
                    $('.FileBox').html('<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.detail.id + '">' + data.data.detail.filename + '</span><input type="hidden" name="file" value="' + data.data.detail.id + '"/><span class="DelFile">删除</span></li>');

                    //loading('none');
                } else {
                    //loading('none');
                    alert(data.msg);
                }
            }, 'json');

        });

     $(document).on('click', '.addResult', function() {
		$('.Person').show()
		PersonInit();
		$('.PersonBox').animate({'top': 80},300);
        $('.PersonTit').FrameTit('a').text('添加文件');
            $('.FrameTableTitl').text('添加文件');
            $('#Mid').val('');
            $('#name').val('');
            $('#authtype').val('');
            $('.download').html();
        });

        $('.addFile').click(function(){
            $(this).prev().click()
        });
        $(document).on('change', '.fileToUpload', function() {
            var name = $(this).attr('name');  
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.id + '">' + data.data.filename + '</span><input type="hidden" name="file" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>';
                        $('#' + name).parent().children('.FileBox').append(txt);
                        $('#' + name).val('');
                    } else {
                        $('#' + name).val('');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });

        function do_addResult() {
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "saveFile"); ?>",
                data: $('#addResult_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    //loading('none');
                    alert('提交失败');
                },
                success: function(data) {
                    if(data.status==1){
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
        }
        
        // function del(id) {
            // if (confirm('确定删除？')) {
                // $.get("<?php echo spUrl($c, "delFile"); ?>", {id: id}, function(data) {
                    // if (data.status == 1) {
                        // $('.Results' + id).remove();
                        // table_sort();
                    // }
                // }, 'json');
            // }
        // }
		function del_form( id) {
			Confirm('确定删除信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delFile"); ?>",{id: id}, function(data) {
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
		

	
			$('.close').click(function(){
			$('.PersonBox').animate({'top': '-500px'},300,function(){
				$('.Person').hide()
			})
		})
	
	
	
    </script>
</section>
</body>
</html>





