<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>新增客户管理</title>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/insert/css/public.css"/>
	</head>
	<body style="min-width: 930px;">
		<div class="ContentBox">
			<div class="Tables">
				<div class="TablesHead">
				
                <form action="" method="get">
					<label>
						<input type="text"class="FrameGroupInput radius" name="cust_name" id="searchName" value="<?php echo $page_con['cust_name']?>" placeholder="搜索名称"/>
					</label>
					<label>
						<input type="text"class="FrameGroupInput radius" name="" id="searchState" value="" placeholder="搜索状态"/>
					</label>
					<button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
					<span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
					<span class="Btn Btn-blue float-right InPop" data-boxid="xz"><i class="icon-add"></i>新增</span>
					
                </form>
				
				</div>
				<div class="top20">
				<?php if(!empty($results)){?>
					<table class="Table">
						<thead>
							<tr>
								<th width="50">提醒类型</th>
								<th>客户名称</th>
								<th>客户所在公司</th>
								<th>客户职位</th>
								<th>客户电话</th>
								<th>地址</th>
								<th>提醒时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody class="textCenter TabBg">
						<?php 
						  foreach ($results as $cust){
						      echo '
							<tr>
								<td>'.($cust['type'] == 1 ? '已回访' : '待回访').'</td>
								<td>'.$cust['cust_name'].'</td>
								<td>'.$cust['custcname'].'</td>
								<td>'.$cust['custdname'].'</td>
								<td>'.$cust['phone'].'</td>
								<td>'.$cust['address'].'</td>
								<td>'.$cust['noticetime'].'</td>
								<!--<td>-->
									
                            <td>
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop" data-url="'.spUrl($c,'custInfo',array('id'=>$cust['id'])).'" data-title="新增管理详情"><a >详情</a></li>
                                        <li class="menu-item NewPop" data-url="'.spUrl($c,'saveCustmang',array('id'=>$cust['id'])).'" data-title="编辑'.$cust['name'].'"><a >编辑</a></li>
                                        <li class="menu-item read"><a onclick="del('.$cust['id'].')">删除</a></li>
                                    </ul>
                                </div>
                            </td>
										<!--<span class="delTr">删除</span>-->
									<!--</div>
								</td>-->
							</tr>
';
						  }
						?>
						</tbody>
					</table>
					<?php }?>
				</div>
				<?php 
				if (empty($results)){
				        echo '
                            <div class="noMsg">
            					<div class="noMsgCont">
            						<img class="" src="'.SOURCE_PATH.'/insert/images/noMsg.png"/>
            						<span>抱歉！暂时没有数据</span>
            					</div>
            				</div>
                        ';
				    }
				?>
				<!-- <div class="Pages textRight top20">
					<ul class="PagesBox">
						<li class="PagesItem"><a >&lt;&lt; 首页</a></li>
						<li class="PagesItem"><a >&lt;</a></li>
						<li class="PagesItem"><a >1</a></li>
						<li class="PagesItem active"><a >2</a></li>
						<li class="PagesItem"><a >3</a></li>
						<li class="PagesItem"><a >4</a></li>
						<li class="PagesItem"><a >5</a></li>
						<li class="PagesItem"><a >&gt;</a></li>
						<li class="PagesItem"><a >末页 &gt;&gt;</a></li>
					</ul>
				</div> -->
				<?php require_once TPL_DIR . '/layout/page.php'; ?>
			</div>
		</div>
		<!-- 内容结束 -->
		<div class="Tan" id="xz" style="display:none;">
			<div class="TanBox">
				<div class="TanBoxTit">新增
					<span data-boxid="xz" class="close OtPop"></span>
				</div>
				<div class="TanBoxCont">
                <form method="post" action="" onsubmit="return false;" id="submit_form">
					<div class="FrameTable">
						<div class="FrameTableTitl">新增客户</div>
						<table class="FrameTableCont">
							<tr>
								<td class="FrameGroupName" width="20%">客户名称 ：</td>
								<td class="" width="30%">
									<input type="text" class="search FrameGroupInput" value=''>
								</td>
								<td class="FrameGroupName" width="20%">客户电话 ：</td>
								<td class=""width="30%">
									<input type="text" class="FrameGroupInput" value=""/>
								</td>
							</tr>							
							<tr>
								<td class="FrameGroupName" width="20%">客户所在公司 ：</td>
								<td class=""width="30%">
									<input type="text" class="FrameGroupInput" value=""/>
								</td>
								<td class="FrameGroupName" width="20%">客户职位 ：</td>
								<td class=""width="30%">
									<input type="text" class="FrameGroupInput" value=""/>
								</td>
							</tr>
							<tr>
								<td class="FrameGroupName" width="20%">回访时间设置 ：</td>
								<td class="" width="30%">
									<input type="text" class="FrameDatGroup" id="DatEnd"/>
								</td>
								<td class="FrameGroupName" width="20%">客户生日 ：</td>
								<td class=""width="30%">
									<input type="text" class="FrameDatGroup" id="DatEnd"/>
								</td>
							</tr>
							<tr>
								<td class="FrameGroupName" width="20%">提醒时间设置 ：</td>
								<td class="" width="30%">
									<input type="text" class="FrameDatGroup" id="DatEnd"/>
								</td>
							</tr>
							<tr>
								<td class="FrameGroupName">提醒类型 ：</td>
								<td colspan="3">
									<select name="" id="" class="FrameGroupInput">
										<option value="1">回访类型</option>
										<option value="1">待回访</option>
										<option value="1">已回访</option>
									</select>
								</td>
							</tr>
						</table>
						<div class="TanBtn">
							<span class="Btn Big Btn-green" onclick="do_sub()">确定</span>
							<span class="Btn Big Btn-blue OtPop" data-boxid="xz">取消</span>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	<script src="<?php echo SOURCE_PATH; ?>/insert/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SOURCE_PATH; ?>/insert/js/public.js" type="text/javascript" charset="utf-8"></script>
	<!--日期插件-->
	<script src="<?php echo SOURCE_PATH; ?>/insert/js/jedate.js" type="text/javascript" charset="utf-8"></script>
	<!--日期插件-->
	<script src="<?php echo SOURCE_PATH; ?>/insert/js/table.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		jeDate({
			dateCell:"#DatStr",
			format:"YYYY-MM-DD",
			isinitVal:false,
			isTime:false, //isClear:false,
			minDate:"2014-09-19",
			okfun:function(val){alert(val)}
		})
		jeDate({
			dateCell:"#DatEnd",
			format:"YYYY-MM-DD",
			isinitVal:false,
			isTime:false, //isClear:false,
			minDate:"2014-09-19",
			okfun:function(val){alert(val)}
		})
		
		    function del(id){
                Confirm('确定删除？',function(e){
                    if(e){
                        $.get('<?php echo spUrl($c,'delCustmang')?>',{id:id},function(re){
                            if(re.status==1){
                                $('.Results'+id).remove();
                            }else{
                                Alert(re.msg);
                            }
                        },'json');
                    }
                });
            }

            function do_sub() {
                loading();
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "<?php echo spUrl($c, 'saveCustmang'); ?>",
                    data: $('#check_form').serialize(),
                    dataType: "json",
                    async: false,
                    error: function(request) {
                        loading('none');
                        Alert('提交失败');
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            loading('none');
                             
                            Refresh();
                        } else {
                            Alert(data.msg);
                            loading('none');
                        }

                    }
                });
            }
		
// 		$('.delTr').on('click',function(){
// 			var that = $(this);
// 			Confirm('确定删除？',function(e){
// 				if(e){
// 					that.parent().parent().parent().remove();
// 					Total();
// 				}
// 			},true);
// 		})	
	</script>
</html>
