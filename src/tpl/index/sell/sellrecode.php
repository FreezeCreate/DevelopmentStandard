
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
	</head>
	<body>
		<div class="MainHtml">
			<div class="HtmlNav">
				<input class="input radius" type="text" placeholder="输入关键字" />
				<span class="btn btn-sm btn-primary mg-r-6">搜索</span>
				<span class="btn btn-sm btn-info mg-r-6 reset">重置</span>
				<span class="btn btn-sm btn-info mg-r-6" onclick="Refresh()">刷新</span>
			</div>
			<div class="top20">
				<table class="table borderTr textCenter">
					<thead class="border" style="background-color: #f7f7f7;">
						<tr>
							<td rowspan="2">项目名称</td>
							<td rowspan="2">地址</td>
							<td rowspan="2">销售额</td>
							<td colspan="6">户型</td>
						</tr>
						<tr>
							<td>一户</td>
							<td>二户</td>
							<td>三户</td>
							<td>四户</td>
							<td>五户</td>
							<td>五户以上</td>
						</tr>
					</thead>
					<tbody class="hover">
						<?php for($i = 0; $i < 10; $i++){?>
						<tr>
							<td>蓝光长岛国社区</td>
							<td class="colorBlu"><span class="NewPop"data-url="<?php echo spUrl('apply', 'map')?>"data-title="四川省成都市郫都区犀安路" data-type="map" data-jd="103.99751216708" data-wd="30.76463999169">成都市成华区建设路45号</span></td>
							<td>3458.74万</td>
							<td>22</td>
							<td>22</td>
							<td>22</td>
							<td>22</td>
							<td>22</td>
							<td>22</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<?php require_once TPL_DIR . '/layout/page.php'; ?>
		</div>
	</body>
</html>
<script type="text/javascript">
	$('.delete').on('click',function () {
    var del = $("<div id='s_delete'></div>");
    $('body').append(del);
    var czjz = $("<span class='s_czjz'></span>");
    var sure = $("<div class='s_sure'></div>")
    $('#s_delete').append("<span class=\"s_czjz\"></span>",sure);
    var ts = $("<div class='s_sure_title'>提示</div>")
    $('.s_sure').append(ts);
    var s_txt = $("<div class='s_sure_txt'></div>")
    $('.s_sure').append(s_txt);
    $('.s_sure_txt').append(czjz);
    $('.s_sure_txt').append($("<img src=\'image/sure.png\' alt=\'\'>"));
    $('.s_sure_txt').append($("<p>确定要删除此订单？</p>"));
    $('.s_sure').append("<div class=\"s_btn\"></div>");
    $('.s_btn').append("<button class=\"s_qx\">取消<tton>")
    $('.s_btn').append("<button class=\"s_qd\">确定<tton>")
})
</script>