
	<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
		
		<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="MainHtml">
			<div class="framemain">
				<div class="FrameTableTitl dataTitl">修改密码</div>
				<table class="FrameTableCont">
					<tr>
						<td class="FrameGroupName" width="20%"><i class="colorRed">*</i>步骤名称 ：</td>
						<td width="30%"><input class="input" type="text" name="" id="name" value="" /></td>
						<td width="50%" class="FrameGroupName"></td>
					</tr>
					<tr>
						<td class="FrameGroupName"><i class="colorRed">*</i>审核对象 ：</td>
						<td>
							<select class="input" id="checktype" name="checktype">
								<option value="">-类型-</option>
								<option value="super">直属上级</option>
								<option value="rank">职位</option>
								<option value="dept">部门负责人</option>
								<option value="pub">申请发布人</option>
								<option value="admin">指定人员</option>
								<option value="assign">上级分配</option>
								<option value="auto">自定义</option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="FrameGroupName">审核动作 ：</td>
						<td colspan="2"><input class="input long" type="text" placeholder="默认是：通过|3|green,驳回|2|red。多个用,隔开" /></td>
					</tr>
				</table>
			</div>
			<div class="frameFoot">
				<span class="btn btn-success pdX20 mg-r-30"onclick="do_saveCourse()">确定</span>
				<span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('#checktype').change(function() {
		if($(this).val() == 'rank') {
			$('#checktype').parent('td').next('td').html('<input class="text2"type="hidden"/><input class="input mg-r10 text3"readonly="readonly" type="text" id="checktypename" name="checktypename" placeholder="请填写职位"/><input type="hidden" name="checktypeid" class="text4" /><a class="btn btn-sm btn-success InPop get-upBox01" data-boxid="Position">选择</a>');
		} else if($(this).val() == 'admin') {
			$('#checktype').parent('td').next('td').html('<input type="text"readonly="readonly" class="input mg-r10 disabled get-upBox uname nother InPop text3" id="uname" data-boxid="Users" name="uname" value=""/><input type="hidden" class="text4" id="uid" name="uid" value=""/>');
		} else {
			$('#checktype').parent('td').next('td').html('');
		}
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

		
		var courseType = {
			"super": "\u76f4\u5c5e\u4e0a\u7ea7",
			"rank": "\u804c\u4f4d",
			"dept": "\u90e8\u95e8\u8d1f\u8d23\u4eba",
			"pub": "\u7533\u8bf7\u53d1\u5e03\u4eba",
			"admin": "\u6307\u5b9a\u4eba\u5458",
			"assign": "\u4e0a\u7ea7\u5206\u914d",
			"auto": "\u81ea\u5b9a\u4e49"
		};

		function do_saveCourse() {
			//loading();
			$.ajax({
				cache: false,
				type: "POST",
				url: "http://csoa.sem98.com/process/saveCourse",
				data: $('#addCourse_form').serialize(),
				dataType: "json",
				async: false,
				error: function(request) {
					//loading('none');
					Alert('提交失败');
				},
				success: function(data) {
					var courseType = {
						"super": "\u76f4\u5c5e\u4e0a\u7ea7",
						"rank": "\u804c\u4f4d",
						"dept": "\u90e8\u95e8\u8d1f\u8d23\u4eba",
						"pub": "\u7533\u8bf7\u53d1\u5e03\u4eba",
						"admin": "\u6307\u5b9a\u4eba\u5458",
						"assign": "\u4e0a\u7ea7\u5206\u914d",
						"auto": "\u81ea\u5b9a\u4e49"
					};
					if(data.status == 1) {
						var str = '';
						var level = $('.course tr.active').attr('level') * 1 + 1;
						str += '<tr class="Course' + data.data.id + '" itemid="' + data.data.sid + '" level="' + level + '"><td class="data-id" dir="' + data.data.id + '">' + data.data.id + '</td><td style="text-align: left;padding-left:' + level * 14 + 'px;" class="data-name text-left" dir="' + data.data.name + '">' + data.data.name + '</td><td class="data-checktype" dir="' + data.data.checktype + '">' + courseType[data.data.checktype] + '</td><td class="data-checktypename" data-id="' + data.data.checktypeid + '" dir="' + data.data.checktypename + '">' + data.data.checktypename + '</td><td class="hidden None data-courseact" dir="' + data.data.courseact + '"></td><td><button class="btn btn-blue edit-t get-upBox" itemid="' + data.data.id + '" data-bind="addCourse">编辑</button><button class="btn btn-red del-t" itemid="' + data.data.id + '">删除</button></td></tr>';
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

		
		$(document).on('click', '.get-upBox01', function() {
			ChousPerson(Pos, 'one', '.text3', '.text4', this)
		});
		$(document).on('click', '#uname', function() {
			ChousPerson(Use, 'one', '.text5', '.text6', this)
		});
</script>