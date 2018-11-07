$(function(){
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
			data: data,
			dataType:'json',
			success:function(data){
				alert(data.msg);
				if(data.code!=1){
					Refresh();
				}
			},
			error:function(){
				console.error('网络错误');
			}
		});
	});
	$('.infor').attr('data-url',dataURL+'/person/infor');
	$('.upcoming').attr('data-url',dataURL+'/person/upcoming');
	showCommonList('/app.php/checkwork/isPerClock',function(data){
		if(data.code!=1){
			var res=data.results;
			for(var i in res){
				for(var k in res[i]){
					if(res[i][k]){
						$('.dkjr').eq(i).append('<span>'+res[i][k]+'<span>');
					}else{
						$('.dkjr').addClass('colorRed');
					}
				}
			}
		}else{
			Alert(data.msg);
		}
	});
	showCommonList('/app.php/work/infoLst',function(data){
		var res=data.results,html='';
		for(var i in res){
			//{ "id": "id", "title": "标题", "content": "内容", "recename": "接收人", "receid": "接收人id", }
			html+='<li data-id="'+res[i].id+'" data-url="Infor" data-name="通知公告" data-model="1" class="ListItem upcheck Point" title="'+res[i].content+'"><a><span class="ListItemLeft">【通知】'+res[i].title+'</span><span class="ListItemRight">['+res[i].date+']</span></a></li>';
		}
		$('#workInfo').html(html);
	});
	showCommonList('/app.php/work/upcoming',function(data){
		var res=data.results,html='';
		for(var i in res){
			//{ "id": "id", "depart": "部门", "table": "模块", "uname": "申请人", "addtime": "申请时间", "statustext": "状态", "nowcheckname": "超级管理员", "summary": "摘要" }
			html+='<tr title="'+res[i].summary+'">'+
				'<td>'+res[i].modelname+'</td>'+
				'<td>'+res[i].uname+'</td>'+
				'<td>'+res[i].depart+'</td>'+
				'<td>'+res[i].addtime+'</td>'+
				'<td>'+res[i].statustext+'</td>'+
				'<td><a class="upcheck" data-id="'+res[i].tid+'" data-url="'+res[i].table+'" data-name="'+res[i].modelname+'" data-model="'+res[i].modelid+'">详情</a></td></tr>';
		}
		$('#workUpcoming').html(html);
	});
	showCommonList('/app.php/work/orders',function(data){
		var res=data.results,html='';
		for(var i in res){
			//{ "id": "id", "number": "订单编号", "name": "订单名称", "uid": "订单申请人id", "uname": "订单申请人", "explain": "备注", "address": "地址", "money": "金额", }
			html+= '<tr class="NewPop" data-url="/sell/ordersInfo/id/'+res[i].id+'" data-title="订单详情">'+
					'<td>'+(res[i].number||"空")+'</td>'+
					'<td>'+res[i].name+'</td>'+
					'<td>'+(res[i].money||"0.00")+'</td>'+
					'<td>'+res[i].address+'</td>'+
					'<td>'+res[i].adddt+'</td></tr>';
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