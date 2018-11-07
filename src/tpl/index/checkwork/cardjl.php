
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<select class="input radius" id="mont">
				</select>
				<select class="input radius">
					<option value="张三">张三</option>
					<option value="张三">张三</option>
					<option value="张三">张三</option>
					<option value="张三">张三</option>
				</select>
				<span class="btn btn-sm btn-primary mg-r-6">查询</span>
				
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead>
						<tr class="b"><td>部门</td><td>姓名</td><td>打卡时间</td><td>添加时间</td><td>IP</td><td>打卡地址</td><td>图片</td></tr>
					</thead>
					<tbody class="hover colorGra">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>商务三部</td><td>席凡</td><td>2018-07-03 08:14:02</td><td>2018-07-03 08:14:02</td><td>171.210.187.81</td>
							<td><p class="colorBlu NewPop" data-url="<?php echo spUrl('apply', 'map')?>" data-title="四川省成都市郫都区犀安路" data-type="map" data-jd="103.99751216708"data-wd="30.76463999169">四川省成都市郫都区犀安路</p></td>
							<td><p class="colorBlu NewPop" data-url="<?php echo spUrl('apply', 'img')?>" data-title="查看大图" data-type="img" data-src="<?php echo SOURCE_PATH; ?>/images/login/login_bg.png">temp.jpg</p></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<?php require_once TPL_DIR . '/layout/page.php'; ?>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			var str = '';
			var dt = new Date();
			
			for(var i = 0; i < 10; i++){
				var y = dt.getFullYear();
				var m = dt.getMonth();
				str += '<option value="'+y+'-'+( (m+1)<10?'0'+(m+1):(m+1) )+'">'+y+''+( (m+1)<10?'0'+(m+1):(m+1) )+'</option>'
				dt = new Date(y,--m);
			}
			$('#mont').append(str)
		})
	</script>
</html>
