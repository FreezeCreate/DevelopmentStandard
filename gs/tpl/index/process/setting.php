<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css" />
        <style type="text/css">
            #Position.Person .PersonListName{background: #fff;}
        </style>
    </head>

    <body>
        <div class="ContentBox">
            <div class="lcmkCont">
                <div class="content clearfix">
                    <div class="group-div width-3 lcmkLeft">
                        <div class="tit01 lcmkTit">流程模块(双击显示步骤)</div>
                        <div id="lih" class="TablesBody">
                            <div class="lcmkLeftScroll">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>名称</th>
                                            <th>表名</th>
                                            <th>类型</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $k => $v) { ?>
                                            <tr class="doubleclick" itemid="<?php echo $v['id'] ?>">
                                                <td><?php echo $v['id']; ?></td>
                                                <td><?php echo $v['name'] ?></td>
                                                <td><?php echo $v['table'] ?></td>
                                                <td><?php echo $GLOBALS['PRO_TYPE'][$v['type']]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="group-div width-6 lcmkRight" id="setcourse">
                        <div class="lcmkRightPd">
                            <div class="lcmkRtit">
                                <div class="tit02">
                                    <div class="tool">
                                        <button class="Btn Btn-grey float-right but nother" data-BoxId="addCourse" id="add">新增下级</button>
                                    </div>
                                    <span>设置流程</span>
                                </div>
                            </div>
                            <div class="clear" style="height: 10px;"></div>
                            <div class="TablesBody">
                                <div class="lcmkRightScroll">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>名称</th>
                                                <th>审核人类型</th>
                                                <th>审核人</th>
                                                <th style="width: 100px;">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody class="course">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Tan Chang" id="addCourse">
            <div class="TanBox ChangBox">
                <div class="TanBoxTit"><span class="dataTitl">修改密码</span> <span class="close OtPop"data-BoxId="addCourse"></span></div>
                <div class="TanBoxCont">
                    <form id="addCourse_form">
                        <input type="hidden" id="sid" name="sid" value="2">
                        <input type="hidden" id="pid" name="pid" value="0">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="FrameTable">
                            <div class="FrameTableTitl dataTitl">修改密码</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName" width="20%"><i class="colorRed">*</i>步骤名称  ：</td>
                                    <td width="30%"><input class="FrameGroupInput " type="text" name="name" id="name" value="" /></td>
                                    <td width="50%" class="FrameGroupName"></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><i class="colorRed">*</i>审核对象  ：</td>
                                    <td>
                                        <select class="FrameGroupInput" id="checktype" name="checktype">
                                            <option value="">-类型-</option>
                                            <?php foreach ($GLOBALS['COURSE_TYPE'] as $k => $v) { ?>
                                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">审核动作  ：</td>
                                    <td colspan="2"><input class="FrameGroupInput Lang" type="text" placeholder="默认是：通过|3|green,驳回|2|red。多个用,隔开"/></td>
                                </tr>
                            </table>
                            <div class="TanBtn">
                                <span class="Btn Big" onclick="do_saveCourse()">确定</span>
                                <span class="Btn Big Blue OtPop"data-BoxId="addCourse">取消</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="Tan Person one" id="Position">
            <div class="TanBox PersonBox ">
                <div class="PersonTit">请选择<span class="close OtPop"data-BoxId="Position"></span></div>
                <div class="PersonCont">
                    <div class="PersonScroll">
                    </div>
                </div>
                <div class="PersonFoot">
                    <span class="Btn Big" onclick="getPosition()">确认</span>
                </div>
            </div>
        </div>
        <div class="Person Tan one"id="Users">
            <div class="PersonBox TanBox">
                <div class="PersonTit">请选择<span class="close OtPop" data-boxid="Users"></span></div>
                <div class="PersonCont">
                    <div class="PersonScroll">

                    </div>
                </div>
                <div class="PersonFoot">
                    <span class="Btn Big" onclick="getUser()">确认</span>
                </div>
            </div>
        </div>
    </body>

    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script type="text/javascript">
		$(function() {

			$('.lcmkCont').height($(window).height() - 40)
			$('.lcmkCont').width($(window).width() - 40)
			$('.lcmkLeftScroll').height($('.lcmkCont').height() - $('.lcmkTit')[0].offsetHeight)
			$('.lcmkRightScroll').height($('.lcmkCont').height() - $('.lcmkRtit')[0].offsetHeight - 2)
		})
	</script>
	<script type="text/javascript">
		$(function() {
			$.get('<?php echo spUrl('main', "getPosition"); ?>', {}, function(data) {
                            if(data.status == 1) {
                                var results = new Array();
                                $.each(data.data, function(i, v) {
                                    //									results.push('<li><a lang="' + v.id + '" title="' + v.name + '"><i class="icon-branch"></i> ' + v.name + '</a></li>');
                                    results.push('<div class="PersonList"><div class="PersonListName"><div class="checkGroup Big">' +
                                            '<span lang="' + v.id + '" title="' + v.name + '" class="checkItem" data-val="技术部全体成员">' + v.name + '</span><input type="hidden" name="" id="" value="" />' +
                                            '</div></div></div>');
                                });
                                $('#Position .PersonScroll').html(results.join(''));
                            }
			}, 'json');
			$.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
				if(data.status == 1) {
					var results = new Array();
					var str = ''
					$.each(data.data, function(i, v) {
						$.each(v.children, function(i1, v1) {
							str += '<div class="PersonList"><div class="PersonListName">' + v1.department + 
								'</div><ul class="PersonListBox">'
							$.each(v1.children, function(i2, v2) {
								var positionname = v2.positionname ? v2.positionname : '无';
								str += '<li class="PersonListItem"lang="' + v2.id + '" title="' + v2.name + '" data-val="顾曾剑"><img src="<?php echo SOURCE_PATH; ?>/images/shouoye_36.png"/><span>' + v2.name + '（' + positionname + '）</span></li>'
							});
							str += '</ul></div>'
						});
					});
					$('#Users .PersonScroll').html(str);
				}
			}, 'json');
			$(document).on({
				dblclick: function() {
					var id = $(this).attr('itemid');
					$('.table .doubleclick').removeClass('active');
					$(this).addClass('active');
					$.get("<?php echo spUrl($c, "getCourse"); ?>", {
						id: id
					}, function(data) {
						if(data.status == 1) {
							var coursetype = <?php echo json_encode($GLOBALS['COURSE_TYPE']); ?>;
							var course = new Array();
							course.push('<tr class="Course0" itemid="' + id + '" level="0"><td class="data-id" dir="0">0</td><td class="data-name text-left0"style="text-align: left;padding-left:' + 0 + 'px;" dir="提交">提交</td><td class="data-checktype" dir=""></td><td class="data-checktypename" dir=""></td><td></td></tr>');
							$.each(data.data, function(i, v) {
								course.push('<tr class="Course' + v.id + '" itemid="' + id + '" level="' + v.level + '"><td class="data-id" dir="' + v.id + '">' + v.id + '</td><td style="text-align: left;padding-left:' + v.level * 14 + 'px;"class="data-name text-left' + v.level + '" dir="' + v.name + '">' + v.name + '</td><td class="data-checktype" dir="' + v.checktype + '">' + coursetype[v.checktype] + '</td><td class="data-checktypename" data-id="' + v.checktypeid + '" dir="' + v.checktypename + '">' + v.checktypename + '</td><td class="hidden None data-courseact" dir="' + v.courseact + '">' + v.courseact + '</td><td><button class="Btn Blue edit-t InPop" itemid="' + v.id + '" data-boxid="addCourse">编辑</button><button class="Btn Red del-t" itemid="' + v.id + '">删除</button></td></tr>');
							});
							$('#setcourse .tit02 span').html('设置【' + data.url + '】的流程');
							$('#setcourse table tbody.course').html(course);
							nobtn();
						} else {
							Alert(data.msg);
						}
					}, "json");
					$('#setcourse table tbody.course').html('<tr class="Course0" itemid="1" level="0"><td class="data-id" dir="0">0</td><td class="data-name text-left0"style="text-align: left;padding-left:' + 0 + 'px;" dir="提交">提交</td><td class="data-checktype" dir=""></td><td class="data-checktypename" dir=""></td><td></td></tr>');
				}
			}, '.doubleclick');

			$(document).on('click', '.course tr', function() {
				$('.course tr').removeClass('active');
				$(this).addClass('active');
				nobtn();
			});

			$(document).on('click', '.edit-t', function() {
				var id = $(this).attr('itemid');
				var name = $('.Course' + id + ' .data-name').attr('dir');
				var type = $('.Course' + id + ' .data-checktype').attr('dir');
				var checktypeid = $('.Course' + id + ' .data-checktypename').attr('data-id');
				var checktypename = $('.Course' + id + ' .data-checktypename').attr('dir');
				var courseact = $('.Course' + id + ' .data-courseact').attr('dir');
				$('#addCourse .dataTitl').text('编辑【' + name + '】步骤');
				$('#id').val(id);
				$('#name').val(name);
				$('#checktype').val(type);
				if(type == 'rank') {
					$('#checktype').parent('td').next('td').html('<input class="FrameGroupInput" type="text" id="checktypename" name="checktypename" value="' + checktypename + '" placeholder="请填写职位"/><a class="Btn btn-sm Btn-primary get-upBox01 InPop" data-BoxId="Position">选择</a>');
				} else if(type == 'admin') {
					$('#checktype').parent('td').next('td').html('<input type="text" class="FrameGroupInput disabled get-upBox uname nother InPop" id="uname" data-boxid="Users" name="uname" value="' + checktypename + '"/><input type="hidden" id="uid" name="uid" value="' + checktypeid + '"/>');
				} else {
					$('#checktype').parent('td').next('td').html('');
				}
				$('#courseact').val(courseact);
			});

			$(document).on('click', '.get-upBox01', function() {
				PersonInit()
			});

			$(document).on('click', '.del-t', function() {
                            var id = $(this).attr('itemid');
                            Confirm("确认删除该步骤？", function(e) {
                                if(e) {
                                    $.get("<?php echo spUrl($c, "delCourse"); ?>", {id: id}, function(data) {
                                        if(data.status == 1) {
                                                $('.Course' + id).remove();
                                        } else {
                                                Alert(data.msg);
                                        }
                                        nobtn();
                                    }, "json");
                                }
                            })
			});

		});

		$('#add').click(function() {
			var sid = $('.course tr.active').attr('itemid');
			var pid = $('.course tr.active .data-id').attr('dir');
			var pname = $('.course tr.active .data-name').attr('dir');
			$('#addCourse .dataTitl').html('新增【' + pname + '】下的步骤');
			$('#sid').val(sid);
			$('#pid').val(pid);
			$('#id').val('');
			$('#name').val('');
			$('#checktype').val('');
			$('#checktype').parent('td').next('td').html('');
			$('#courseact').val('');
		});

		$('#checktype').change(function() {
			if($(this).val() == 'rank') {
				$('#checktype').parent('td').next('td').html('<input class="FrameGroupInput" type="text" id="checktypename" name="checktypename" placeholder="请填写职位"/><a class="Btn btn-sm btn-primary InPop get-upBox01" data-BoxId="Position">选择</a>');
			} else if($(this).val() == 'admin') {
				$('#checktype').parent('td').next('td').html('<input type="text" class="FrameGroupInput disabled get-upBox uname nother InPop" id="uname" data-boxid="Users" name="uname" value=""/><input type="hidden" id="uid" name="uid" value=""/>');
			} else {
				$('#checktype').parent('td').next('td').html('');
			}
		});
		var courseType = <?php echo json_encode($GLOBALS['COURSE_TYPE']); ?>;

		function do_saveCourse() {
			//loading();
			$.ajax({
				cache: false,
				type: "POST",
				url: "<?php echo spUrl($c, "saveCourse"); ?>",
				data: $('#addCourse_form').serialize(),
				dataType: "json",
				async: false,
				error: function(request) {
					//loading('none');
					Alert('提交失败');
				},
				success: function(data) {
					var courseType = <?php echo json_encode($GLOBALS['COURSE_TYPE']); ?>;
					if(data.status == 1) {
						var str = '';
						var level = $('.course tr.active').attr('level') * 1 + 1;
						str += '<tr class="Course' + data.data.id + '" itemid="' + data.data.sid + '" level="' + level + '"><td class="data-id" dir="' + data.data.id + '">' + data.data.id + '</td><td style="text-align: left;padding-left:' + level * 14 + 'px;" class="data-name text-left" dir="' + data.data.name + '">' + data.data.name + '</td><td class="data-checktype" dir="' + data.data.checktype + '">' + courseType[data.data.checktype] + '</td><td class="data-checktypename" data-id="' + data.data.checktypeid + '" dir="' + data.data.checktypename + '">' + data.data.checktypename + '</td><td class="hidden None data-courseact" dir="' + data.data.courseact + '"></td><td><button class="Btn Blue edit-t InPop" itemid="' + data.data.id + '" data-boxid="addCourse">编辑</button><button class="Btn Red del-t" itemid="' + data.data.id + '">删除</button></td></tr>';
						$('.course tr.active').after(str);
						$('.course tr.active').removeClass('active');
						//loading('none');
						$('#addCourse .close').click();
					} else if(data.status == 2) {
						$('.Course' + data.data.id + ' .data-name').attr('dir', data.data.name);
						$('.Course' + data.data.id + ' .data-name').text(data.data.name);
						$('.Course' + data.data.id + ' .data-checktype').attr('dir', data.data.checktype);
						$('.Course' + data.data.id + ' .data-checktype').text(courseType[data.data.checktype]);
						$('.Course' + data.data.id + ' .data-checktypename').attr('data-id', data.data.checktypeid);
						$('.Course' + data.data.id + ' .data-checktypename').attr('dir', data.data.checktypename);
						$('.Course' + data.data.id + ' .data-checktypename').text(data.data.checktypename);
						$('.Course' + data.data.id + ' .data-courseact').attr('dir', data.data.courseact);
						//loading('none');
						$('#addCourse .close').click();
					} else {
						//loading('none');
						Alert(data.msg);
					}

				}
			});
		};

		function getPosition() {
			var id = $('#Position .PersonScroll .checkItem.active').attr('lang');
			var name = $('#Position .PersonScroll .checkItem.active').attr('title');
			$('#checktypeid').val(id);
			$('#checktypename').val(name);
			$('#Position .close').click();
		}

		function nobtn() {
			if($('.course tr.active').length == 1) {
				$('#add').addClass('get-upBox');
				$('#add').addClass('but-primary');
				$('#add').removeClass('nother');
				$('#add').removeClass('Btn-grey');
				$('#add').addClass('InPop');
			} else {
				$('#add').addClass('Btn-grey');
				$('#add').removeClass('get-upBox');
				$('#add').removeClass('InPop');
				$('#add').removeClass('but-primary');
				$('#add').addClass('nother');
			}
		}

		$(document).on('click', '#uname', function() {
			PersonInit()
		});

		function getUser() {
			var id = $('#Users .PersonListItem.active').attr('lang');
			var name = $('#Users .PersonListItem.active').attr('title');
			$('#uid').val(id);
			$('#uname').val(name);
			$('#Users .close').click();
		}
	</script>