<?php
require_once TPL_DIR . '/layout/con_header.php';
?>

<script src="<?php echo SOURCE_PATH?>/js/addpower.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
.jsItem {
	overflow: hidden;
	margin-bottom: 10px;
}

.jsItemName {
	float: left;
	text-align: right;
	width: 130px;
	min-height: 14px;
	line-height: 24px;
}

.jsItemVal {
	float: left;
	line-height: 24px;
}
</style>
</head>
<body>
	<div class="MainHtml">
		<div class="jsItem">
			<span class="jsItemName">角色名称：</span>
			<div class="jsItemVal">
				<input type="text" class="input" name="" id="" value="" />
			</div>
		</div>
		<div class="jsItem">
			<span class="jsItemName"></span>
			<label>
				<span class="checkbox all" data-val="1">全选</span>
				<input type="checkbox" class="None" name="all"  value="154" data-type="type" >
			</label>
		</div>
		<?php for($i = 0; $i < 10; $i++){?>
		<div class="jsItem">
			<span class="jsItemName"></span>
			<div class="jsItemVal">
				<label>
					<span class="checkbox itm" data-val="1">个人中心</span>
					<input type="checkbox" class="None" name="auth[]"  value="154" data-type="type" >
				</label>
			</div>
		</div>
		<div class="jsItem">
			<span class="jsItemName">
				<label>
					<span class="checkbox Line" data-val="1">个人办公：</span>
					<input type="checkbox" class="None" name="auth[]"  value="143" data-type="type" >
				</label>
			</span>
			<div class="jsItemVal">
				<label>
					<span class="checkbox itm" data-val="1">个人中心</span>
					<input type="checkbox" class="None" name="auth[]"  value="154" data-type="type" >
				</label>
				<label>
					<span class="checkbox itm " data-val="1">提醒消息</span>
					<input type="checkbox" class="None" name="auth[]"  value="155" data-type="type" >
				</label>
				<label>
					<span class="checkbox itm " data-val="1">通讯录</span>
					<input type="checkbox" class="None" name="auth[]"  value="156" data-type="type" >
				</label>
				<label>
					<span class="checkbox itm " data-val="1">我的工资单</span>
					<input type="checkbox" class="None" name="auth[]"  value="171" data-type="type" >
				</label>
				<label>
					<span class="checkbox itm "data-val="1">通知公告</span>
					<input type="checkbox" class="None" name="auth[]"  value="144" data-type="type" >
				</label>
				<label>
					<span class="checkbox itm " data-val="1">任务</span>
					<input type="checkbox" class="None" name="auth[]"  value="147" data-type="type">
				</label>
			</div>
		</div>
		<?php }?>
		<div class="top20 textCenter">
			<span class="btn btn-success pdX30 mg-r-30">保 存</span>
			<span class="btn btn-info pdX30" onclick="parent.window.closHtml()">取 消</span>
		</div>
	</div>
</body>
</html>