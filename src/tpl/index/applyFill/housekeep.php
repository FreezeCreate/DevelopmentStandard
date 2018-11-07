
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/houscont.css"/>
</head>
<body>
	<div class="Mark">
	    <div class="houskeep">
	    	<div class="houskeep-tit"><span>选择客户</span><span class="houskeep-clos"></span></div>
	    	<div class="hous-cont">
	    		<div class="hous-serch">
	    			<i class="hous-ser"></i>
	    			<input class="hous-inp" type="text" name="" id="" value="" placeholder="客户名称"/>
	    			<span class="hous-btn">搜索</span>
	    		</div>
	    		<div class="clerPd top20">
		    		<div class="hous-scroll">
		    			<table class="table borderTr textCenter">
		    				<thead>
		    					<tr><th>姓名</th><th>电话</th><th>选择</th></tr>
		    				</thead>
		    				<tbody class="hover">
		    					<?php for($i = 0; $i < 30; $i++){?>
		    					<tr><td>张三</td><td>13333333333</td><td><span class="checkbox"></span></td></tr>
		    					<?php }?>
		    				</tbody>
		    			</table>
		    		</div>
	    		</div>
	    	</div>
	    	<ul class="hous-foot">
	    		<li class="qx" onclick="$('.houskeep-clos').click()">取消</li>
	    		<li class="qd">确定</li>
	    	</ul>
	    </div>
	</div>
</body>
</html>
<script type="text/javascript">
	$('.houskeep').css({'animation': 'zoomIn .3s forwards'})
		
	$('.houskeep-clos').click(function(){
		
		$('.houskeep').css({'animation': 'zoomOut .3s forwards'})
		setTimeout(function(){ parent.window.closPop() }, 300)
	})
	$('.hous-btn').click(function(){
		var val = $('.hous-inp').val().trim();
		if(val == ''){
			$('.hover tr').show()
		}else{
			$('.hover tr').each(function(k,v){
				if($(v).children('td').eq(0).text().indexOf(val) != -1){
					$(v).show()
				}else{
					$(v).hide()
				}
			})
		}
	})
</script>
