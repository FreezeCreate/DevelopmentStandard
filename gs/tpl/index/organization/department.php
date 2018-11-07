<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>部门管理</title>
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
                    <label class="form-group">
                        公司：<select class="FrameGroupInput" name="pid">
                            <option value="0">全部</option>
                            <?php foreach ($shops as $k => $v) { ?>
                                <option <?php echo $page_con['pid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label class="form-group">
                        <input class="FrameGroupInput" type="text" name="number" placeholder="编号"  value="<?php echo $page_con['number'] ?>"/>
                    </label>
                    <label class="form-group">
                        <input class="FrameGroupInput" type="text" name="department" placeholder="部门名称关键字"  value="<?php echo $page_con['department'] ?>"/>
                    </label>
                             <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                            <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
			<div class="TablesAddBtn addDepartment" data-bind="addDepartment">添加部门信息</div>
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
                        <th>部门名称</th>
                        <th>所属公司</th>
                        <th>负责人</th>
                        <th>电话</th>
                        <th>传真</th>
                        <th>备注</th>
                        <th>排序</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Department<?php echo $v['id'] ?>">
                            <td class="data-number" title="<?php echo $v['number'] ?>"><?php echo $v['number'] ?></td>
                            <td class="data-department" title="<?php echo $v['department'] ?>"><?php echo $v['department'] ?></td>
                            <td class="data-pid" title="<?php echo $v['pid'] ?>"><?php echo $shops[$v['pid']] ?></td>
                            <td class="data-principal" lang="<?php echo $v['principalid'] ?>" title="<?php echo $v['principalname'] ?>"><?php echo $v['principalname'] ?></td>
                            <td class="data-phone" title="<?php echo $v['phone'] ?>"><?php echo $v['phone'] ?></td>
                            <td class="data-fax" title="<?php echo $v['fax'] ?>"><?php echo $v['fax'] ?></td>
                            <td class="data-remark" title="<?php echo $v['remark'] ?>"><?php echo $v['remark'] ?></td>
                            <td class="data-sort" title="<?php echo $v['sort'] ?>"><?php echo $v['sort'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
                                        <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v['id'] ?>" data-bind="addDepartment"> 编辑</a></li>
                                        <li class="menu-item"> <a class="btn btn-red del-t" onclick="del_form(<?php echo $v['id'];?>)">删除</a></li>
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
		<div class="Person upBox add x" id="addDepartment">
			<div class="PersonBox" style="width:auto;margin-left: -400px;">
				<div class="PersonTit"><a style="color:#ffffff;">添加部门信息</a><span class="close"></span></div>
				<div class="PersonCont">
                    <form id="addDepartment_form" method="post" action="" onsubmit="return false;">
						<div class="FrameCont">
						<div class="FrameTable">
						<div class="FrameTableTitl">添加部门信息</div>
                        <input type="hidden" id="Mid" name="id" value=""/>
                        <table class="FrameTableCont">
                            <tbody>
                                <tr>
                                    <td class="FrameGroupName" ><span class="color-red">*</span>部门名称</td>
                                    <td><input class="FrameGroupInput" type="text" id="department" name="department"/></td>
                                    <td class="FrameGroupName">编号</td>
                                    <td><input class="FrameGroupInput" type="text" id="number" name="number"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span class="color-red">*</span> 所属公司</td>
                                    <td><select class="FrameGroupInput" id="pid" name="pid">
                                            <?php foreach ($shops as $k => $v) { ?>
                                                <option <?php echo $page_con['pid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="FrameGroupName">电话</td>
                                    <td><input class="FrameGroupInput" type="text" id="phone" name="phone"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">传真</td>
                                    <td><input class="FrameGroupInput" type="text" id="fax" name="fax"/></td>
                                    <td class="FrameGroupName">排序</td>
                                    <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">部门负责人</td>
                                    <td><input type="hidden" id="uid" name="uid" value=""/><input class="FrameGroupInput get-upBox01 notenter" data-bind="Users" type="text" id="uname" name="uname"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">备注</td>
                                    <td colspan="3"><input style="width:600px;" class="FrameGroupInput" type="text" id="remark" name="remark"/></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="3"><span class="Btn Big"><a class="btn-sm btn-blue" onclick="do_addDepartment()">确认</a></span></td>
                                </tr>
                            </tfoot>
                        </table>
						</div>
						</div>
                    </form>


            <!--
            作者：895635200@qq.com
            时间：2017-08-11
            描述：添加材料弹出框end
            -->
        </div>

    </div>
   </div>	

			<div class="Person y">
			<div class="PersonBox" style="left:58%;" >
				<div class="PersonTit"><b>请选择</b><span class="Close"></span></div>
				   <div class="PersonCont">
					  <div class="PersonSerch">
                        <div class="PersonSerchGroup">
                            			<input class="PersonSerchVal" type="text" name="" id="" value="" placeholder="部门/姓名"/>
										<span class="PersonSerchBtn noChoice">搜索</span>
                        </div>
					  </div>
				<div class="PersonScroll">
<!--                         <div class="upBox-cc PersonList">
                            <ul class="all-li PersonListBox">
                               <li><a><i class="icon-company"></i> </a>
                                    <ul>
                                        <li><a><i class="icon-branch"></i> </a>
                                            <ul>
                                                <li><a class="active" lang="" title=""><i class="icon-user"></i> </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                          </ul>
                            <ul class="th-li">
                                <li><a></a></li>
                            </ul>
                        </div>-->
                        <div class="upBox-f">
                            <a class="but but-primary" onclick="getUser()">确定</a>
                        </div>
					</div>
				</div>
				<div class="PersonFoot">
					<span class="Btn Big">确认</span>
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

    function do_addDepartment() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveDepartment"); ?>",
            data: $('#addDepartment_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
            },
            success: function(data) {
                if (data.status == 1) {
                    $('#addDepartment .close').click();
                    window.location.reload();
                } else if (data.status == 2) {
                    $('.Department' + data.data.id + ' .data-department').attr('title', data.data.department);
                    $('.Department' + data.data.id + ' .data-department').text(data.data.department);
                    $('.Department' + data.data.id + ' .data-number').attr('title', data.data.number);
                    $('.Department' + data.data.id + ' .data-number').text(data.data.number);
                    $('.Department' + data.data.id + ' .data-pid').attr('title', data.data.pid);
                    $('.Department' + data.data.id + ' .data-pid').text(data.data.shopname);
                    $('.Department' + data.data.id + ' .data-principal').attr('title', data.data.principalname);
                    $('.Department' + data.data.id + ' .data-principal').attr('lang', data.data.principalid);
                    $('.Department' + data.data.id + ' .data-principal').text(data.data.principalname);
                    $('.Department' + data.data.id + ' .data-phone').attr('title', data.data.phone);
                    $('.Department' + data.data.id + ' .data-phone').text(data.data.phone);
                    $('.Department' + data.data.id + ' .data-fax').attr('title', data.data.fax);
                    $('.Department' + data.data.id + ' .data-fax').text(data.data.fax);
                    $('.Department' + data.data.id + ' .data-remark').attr('title', data.data.remark);
                    $('.Department' + data.data.id + ' .data-remark').text(data.data.remark);
                    $('.Department' + data.data.id + ' .data-sort').attr('title', data.data.sort);
                    $('.Department' + data.data.id + ' .data-sort').text(data.data.sort);
                    $('#addDepartment .close').click();
                } else {
                    alert(data.msg);
                }

            }
        });
    }
    ;
    
    $(document).on('click', '.addDepartment', function() {
		$('.x').show();
		PersonInit();
		$('.x .PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('添加部门信息');
		 $('.FrameTableTitl').text('添加部门信息');
        $('#Mid').val('');
        $('#department').val('');
        $('#number').val('');
        $('#pid').val('');
        $('#phone').val('');
        $('#fax').val('');
        $('#uid').val('');
        $('#uname').val('');
        $('#remark').val('');
        $('#sort').val('');
    });

    $(document).on('click', '.edit-t', function() {
		$('.x').show()
		PersonInit()
		$('.x .PersonBox').animate({'top': 80},300);
        $('.PersonTit').children('a').text('修改部门信息');
		 $('.FrameTableTitl').text('修改部门信息');
        var id = $(this).attr('itemid');
        $('#Mid').val(id);
        $('#department').val($('.Department' + id + ' .data-department').attr('title'));
        $('#number').val($('.Department' + id + ' .data-number').attr('title'));
        $('#pid').val($('.Department' + id + ' .data-pid').attr('title'));
        $('#uid').val($('.Department' + id + ' .data-principal').attr('lang'));
        $('#uname').val($('.Department' + id + ' .data-principal').attr('title'));
        $('#phone').val($('.Department' + id + ' .data-phone').attr('title'));
        $('#fax').val($('.Department' + id + ' .data-fax').attr('title'));
        $('#remark').val($('.Department' + id + ' .data-remark').attr('title'));
        $('#sort').val($('.Department' + id + ' .data-sort').attr('title'));
    });


    // $(document).on('click', '.del-t', function() {
        // if (confirm("确认删除？")) {
            // var id = $(this).attr('itemid');
            // $.get("<?php echo spUrl($c, "delDepartment"); ?>", {id: id}, function(data) {
                // if (data.status == 1) {
                    // $('.Department' + id).remove();
                // } else {
                    // alert(data.msg);
                // }
            // }, "json");
        // }
    // });
    

    $(document).on('click', '#uname', function() {
      //  loading();
        $.get('<?php echo spUrl('main', 'getUsers'); ?>', {id: 5}, function(data) {//console.log(data.data[0]['children']);//return false;
            if (data.status == 1) {
                var results = new Array();
                $.each(data.data[0]['children'], function(i, v) { //console.log(v);
                    results.push('<div class="PersonList"><div class="PersonListName"><div class="checkGroup Big"><span class="" data-val="' + v.department + '全体人员">'+v.department+'</span><input type="hidden" name="" id="" value="" /></div></div><ul class="PersonListBox">');
                    $.each(v.children, function(i1, v1) {
						var positionname = v1.positionname ? v1.positionname : '无';
                        results.push('<li class="PersonListItem" data-id="' + v1.id + '" data-val="'+ v1.name +'"><img src="/source/images/shouoye_36.png"/><span>' + v1.name + '（' + positionname + '）</span></li>');
                    });
					results.push('</ul>');
                    results.push('</div>');
                });
				//console.log(results);
                $('.PersonScroll').html(results.join(''));
                $('#Users .upBox-cc .all-li').html(results.join(''));
				$('.y').show()
				PersonInit()
				$('.y .PersonBox').animate({'top': 80},300)
                //loading('none');
            } else {
                //loading('none');
                alert(data.msg);
            }
        }, 'json');
    });

    $(document).on('click', '#Users .upBox-cc .all-li li ul li ul li a', function() {
        $('#Users .upBox-cc .all-li li a').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('click', '#Users .upBox-cc .th-li li a', function() {
        $('#Users .upBox-cc .all-li ul li a').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('keyup', '#up-search01', function() {
        var seatxt = $(this).val();
        if (seatxt != '') { alert(seatxt);
            var sea = $('#Users .upBox-cc .all-li li ul li ul li a:contains("' + seatxt + '")');  alert(sea);
            var txt = '';
            for (var i = 0; i < sea.length; i++) {
                txt += '<li>'+sea.eq(i).parent('li').html()+'</li>';
            }
            $('#Users .upBox-cc .all-li ul li a').removeClass('active');
            $('#Users .upBox-cc .th-li').html(txt);
            $('#Users .upBox-cc .all-li').hide();
            $('#Users .upBox-cc .th-li').show();
        }else{
            $('#Users .upBox-cc .all-li ul li a').removeClass('active');
            $('#Users .upBox-cc .th-li').hide();
            $('#Users .upBox-cc .all-li').show();
        }
    });


    function getUser() {
        var id = $('#Users .upBox-cc ul li a.active').attr('lang');
        var name = $('#Users .upBox-cc ul li a.active').attr('title');
        $('#uid').val(id);
        $('#uname').val(name);
        $('.close01').click();
    }
	
	$('.close').click(function(){
		$('.PersonBox').animate({'top': '-500px'},300,function(){
			$('.Person').hide()
		})
	})
    $("#Close").click(function(){
		$(this).parent().parent().parent().hide();
	});
	
		$('.PersonFoot .Btn').click(function(){
				var str = '';
				var uid='';
				$('.PersonListName').each(function(k,v){
					if($(v).children('.checkGroup').children('.checkItem').hasClass('active')){
						str += $(v).children('.checkGroup').children('.checkItem').attr('data-val') + ', '
						
					}else{
						$(v).next().children('.PersonListItem').each(function(k1,v1){
							if($(v1).hasClass('active')){
								str += $(v1).attr('data-val') + ', ';
							    uid=$(v1).attr('data-id');
							}
						})
					}
				})
				
				if(str == ''){
					
				}else{
					$("#uid").val(uid);
					$('#uname').val(str)
					$('.y .PersonBox').animate({'top': '-500px'},300,function(){
						$('.y').hide()
					})
				}
			})
			
		   function del_form( id) {
			Confirm('确定删除该公司信息吗？', function(e) {
				if (e) {
					$.post("<?php echo spUrl($c, "delDepartment"); ?>",{id: id}, function(data) {
						if (data.status == 1) {
							$('.Department' + id).remove();
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
