
		$(()=>{
			var dayArr=['一','二','三','四','五','六','日'];
			var nowDate=new Object();
			function showTime(){
				var newDate=new Date();
				nowDate.year=newDate.getFullYear();
				nowDate.month=newDate.getMonth()+1;
				nowDate.d=newDate.getDate();
				nowDate.day=dayArr[newDate.getDay()-1];
				nowDate.h=newDate.getHours();
				nowDate.m=newDate.getMinutes();
				nowDate.s=newDate.getSeconds();
				if(nowDate.s<10){
					nowDate.s='0'+nowDate.s;
				}
				if(nowDate.m<10){
					nowDate.m='0'+nowDate.m;
				}
				$('.dkDate').html(nowDate.year+'年'+nowDate.month+'月'+nowDate.d+'日 星期'+nowDate.day);
				$('.dkTime').html(nowDate.h+':'+nowDate.m+':'+nowDate.s);
			}
			showTime();
			var timer=setInterval(showTime,1000);
			$('.Lg').click(function(){
				var data=new Object();
				data.token=dataToken;
				data.dkdt=nowDate.year+'-'+nowDate.month+'-'+nowDate.d+' '+nowDate.h+':'+nowDate.m+':'+nowDate.s;
				$.ajax({
					type:'post',
					url:dataURL+'/app.php/checkwork/savePerClock',
					data,
					dataType:'json',
					success(data){
						alert(data.msg);
						if(data.code!=1){
							$('.dkjr span').html('已打卡').removeClass('colorRed').addClass('colorBlu');
						}
					},
					error(){
						console.error('网络错误');
					}
				});
			});
			$('.infor').attr('data-url',dataURL+'/person/infor');
			$('.upcoming').attr('data-url',dataURL+'/person/upcoming');
			showCommonList('/app.php/checkwork/isPerClock',data=>{
				if(data.code!=1){
					var res=data.results;
					for(var i in res){
						for(var k of res[i]){
							if(k){
								$('.dkjr').eq(i).append(`<span>${k}<span>`);
							}else{
								$('.dkjr').addClass('colorRed');
							}
						}
					}
				}else{
					Alert(data.msg);
				}
			});
			showCommonList('/app.php/work/infoLst',data=>{
				var res=data.results,html='';
				for(var {id,title,date,content,recename,receid,table,modelid} of res){
					//{ "id": "id", "title": "标题", "content": "内容", "recename": "接收人", "receid": "接收人id", }
					html+=`<li data-id="${id}" data-url="Infor" data-name="通知公告" data-model="1" class="ListItem upcheck Point" title="${content}"><a><span class="ListItemLeft">【通知】${title}</span><span class="ListItemRight">[${date}]</span></a></li>`;
				}
				$('#workInfo').html(html);
			});
			showCommonList('/app.php/work/upcoming',data=>{
				var res=data.results,html='';
				for(var {table,uname,depart,addtime,optdt,summary,statustext,modelid,tid,modelname,table} of res){
					//{ "id": "id", "depart": "部门", "table": "模块", "uname": "申请人", "addtime": "申请时间", "statustext": "状态", "nowcheckname": "超级管理员", "summary": "摘要" }
					html+=`<tr title="${summary}">
						<td>${table}</td>
						<td>${uname}</td>
						<td>${depart}</td>
						<td>${addtime}</td>
						<td>${statustext}</td>
						<td><a class="upcheck" data-id="${tid}" data-url="${table}" data-name="${modelname}" data-model="${modelid}">详情</a></td>
					</tr>`;
				}
				$('#workUpcoming').html(html);
			});
			showCommonList('/app.php/work/orders',data=>{
				var res=data.results,html='';
				for(var {id,number,name,money,address,adddt,tid,table,modelname,modelid} of res){
					//{ "id": "id", "number": "订单编号", "name": "订单名称", "uid": "订单申请人id", "uname": "订单申请人", "explain": "备注", "address": "地址", "money": "金额", }
					html+=`<tr class="NewPop" data-url="/sell/ordersInfo/id/${id}" data-title="订单详情">
							<td>${number||'空'}</td>
							<td>${name}</td>
							<td>${money}</td>
							<td>${address}</td>
							<td>${adddt}</td>
						</tr>`;
				}
				$('#workOrders').html(html);
			});
			$(document).on('click','.upcheck',function(){
				var that=$(this);
				var tid=that.data('id');
				var modelid=that.data('model');
				var tit=that.data('name');
				var url=that.data('url');
				parent.window.newHtml(dataURL+'/apply/'+url+'?mid=' + modelid + '&id=' + tid, tit);
			});
		});