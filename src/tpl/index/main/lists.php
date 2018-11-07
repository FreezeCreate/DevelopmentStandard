
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<ul class="grpBtn">
					<li class="grpBtnItem active">用户信息</li>
					<li class="grpBtnItem">用户信息</li>
					<li class="grpBtnItem">用户信息</li>
					<li class="grpBtnItem">用户信息</li>
				</ul>
				<input class="input radius" type="text" placeholder="搜索" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<select class="input radius">
					<option value="">本周</option>
					<option value="">本周</option>
					<option value="">本周</option>
				</select>
				<span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
				<span class="btn btn-sm btn-primary pdX20 float-right InPop" data-boxid="tjkh">+ 添加</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b"><td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td><td>进度</td><td>操作</td></tr>
					</thead>
					<tbody class="hover colorGra">
						<tr>
							<td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td>
							<td class="colorBlu">
								<div class="gress"style="height: 6px;width: 80px;"><div class="gresOn"style="width: 10%;"></div></div>10%
							</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item"><a >详情</a></li>
										<li class="menu-item"><a >编辑</a></li>
										<li class="menu-item"><a >作废</a></li>
										<li class="menu-item read"><a >删除</a></li>
									</ul>
								</div>
							</td>
						</tr>
						<tr>
							<td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td>
							<td class="colorBlu">
								<div class="gress"style="height: 6px;width: 80px;"><div class="gresOn"style="width: 20%;"></div></div>20%
							</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item"><a >详情</a></li>
										<li class="menu-item"><a >编辑</a></li>
										<li class="menu-item"><a >作废</a></li>
										<li class="menu-item read"><a >删除</a></li>
									</ul>
								</div>
							</td>
						</tr>
						<tr>
							<td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td>
							<td class="colorBlu">
								<div class="gress"style="height: 6px;width: 80px;"><div class="gresOn"style="width: 30%;"></div></div>30%
							</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item"><a >详情</a></li>
										<li class="menu-item"><a >编辑</a></li>
										<li class="menu-item"><a >作废</a></li>
										<li class="menu-item read"><a >删除</a></li>
									</ul>
								</div>
							</td>
						</tr>
						<tr>
							<td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td>
							<td class="colorBlu">
								<div class="gress"style="height: 6px;width: 80px;"><div class="gresOn"style="width: 40%;"></div></div>40%
							</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item"><a >详情</a></li>
										<li class="menu-item"><a >编辑</a></li>
										<li class="menu-item"><a >作废</a></li>
										<li class="menu-item read"><a >删除</a></li>
									</ul>
								</div>
							</td>
						</tr>
						<tr>
							<td>序号</td><td>客户名称</td><td>项目名称</td><td>项目金额</td><td>创建时间</td><td>负责人</td>
							<td class="colorBlu">
								<div class="gress"style="height: 6px;width: 80px;"><div class="gresOn"style="width: 50%;"></div></div>50%
							</td>
							<td class="colorBlu">
								<div class="list-menu" style="display: inline-block;">
									操作  ＋
									<ul class="menu">
										<li class="menu-item NewPop" data-title="通知详情" data-url="<?php echo spUrl('main', 'details')?>"><a >详情</a></li>
										<li class="menu-item"><a >编辑</a></li>
										<li class="menu-item"><a >作废</a></li>
										<li class="menu-item read"><a >删除</a></li>
									</ul>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php require_once TPL_DIR . '/layout/page.php'; ?>
		</div>
		
		<!--添加客户-->
		<div class="Tan " id="tjkh">
			<div class="TanBox ">
				<div class="TanBoxTit">添加客户 <span class="close OtPop" data-BoxId="tjkh"></span></div>
				<div class="TanBoxCont">
					<div class="FrameTable">
						<div class="FrameTableTitl">添加客户</div>
						<table class="FrameTableCont">
							<tr>
								<td class="FrameGroupName">客户名称 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
								<td class="FrameGroupName">年龄 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
							</tr>
							<tr>
								<td class="FrameGroupName">客户单位 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
								<td class="FrameGroupName">客户类型 ：</td>
								<td>
									<select class="input">
										<option value="">--请选择--</option>
										<option value="">--客户类型--</option>
										<option value="">--客户类型--</option>
										<option value="">--客户类型--</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="FrameGroupName">联系人 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
								<td class="FrameGroupName">邮箱 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
							</tr>
							<tr>
								<td class="FrameGroupName">联系电话 ：</td>
								<td><input class="input" type="text" name="" id="" value="" /></td>
								<td class="FrameGroupName">客户来源 ：</td>
								<td>
									<select class="input">
										<option value="">--请选择--</option>
										<option value="">--客户来源--</option>
										<option value="">--客户来源--</option>
										<option value="">--客户来源--</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="FrameGroupName">地址 ：</td>
								<td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
							</tr>
							<tr>
								<td class="FrameGroupName">备注 ：</td>
								<td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
							</tr>
							<tr>
								<td class="FrameGroupName">相关文件 ：</td>
								<td colspan="3">
									<ul class="FileBox"></ul>
									<input class="None addFileVal" type="file" name="" id="" value="" />
									<span class="addFile">+添加文件</span>
								</td>
							</tr>
						</table>
						<div class="TanBtn">
							<span class="btn btn-success pdX20 mg-r-30">确定</span>
							<span class="btn btn-info pdX20 OtPop"data-boxid="tjkh">取消</span>
						</div>
					</div>
				</div>
			</div>
		</div><!--添加客户-->
	</body>
	<script type="text/javascript">
		$('.addFile').click(function() {
			$(this).prev().click()
		})
		$('.addFileVal').change(function() {
			var val = $(this).val().slice($(this).val().lastIndexOf('\\') + 1);
			$(this).parent().children('.FileBox').append(
				'<li class="FileItem"><span class="FileItemNam">' + val + '</span><span class="DelFile">删除</span></li>'
			)
			$(this).val('')
		})
		$(document).on('click', '.DelFile', function(){ 
			var that = this;
			Confirm('确定删除？', function(e){
				if(e){
					$(that).parent().remove()
				}
			})
		})
	</script>
</html>
