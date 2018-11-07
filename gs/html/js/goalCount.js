$(()=>{
    getPagesBox({
        nowUrl:"app.php/salegoal/goalCount",
        addList(data){
            if(data.code!=0){
                console.error(data.msg);
                return false;
            }
            var res=data.results,html='',i=0;
            if(!res)return fasle;
            for(var {id,salename,saledname,optdt,goaltitle,goalstatus} of res){
                i++;
                html+=`<tr>
                        <td>${i}</td>
                        <td>${saledname}</td>
                        <td>${salename}</td>
                        <td>${goaltitle}</td>
                        <td>${optdt}</td>
                        <td>${goalstatus==1?"已完成":"未完成"}</td>
                        <td>
                            <div class="colorBlu list-menu" style="display: inline-block;">
                                操作+
                                <ul class="menu">
                                    <li data-url="salegoal/goalItem.html?id=${id}" class="colorBlu menu-item NewPop" data-title="销售目标详情">
                                        <a href="#">查看详情</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
            }
            $("#dataList").html(html);
            /*total_all:user:(2) [{…}, {…}]user_fact:(2) [2100, 426000]user_goal:(2) [40212, 300500]user_will:(2) [38112, 0]*/
            var total_all=data.total_all,max_mon=0;
            // for(var max of total_all.user_fact){
            //     if(max>max_mon)max_mon=max;                
            // }
            // for(var max of total_all.user_goal){
            //     if(max>max_mon)max_mon=max;                
            // }
            // for(var max of total_all.user_will){
            //     if(max>max_mon)max_mon=max;                
            // }
            // max_mon=toString(max_mon);
            if($(".histogram").length>0){
                var myChart = echarts.init($(".histogram")[0]);
                myChart.setOption({
                    title: {
                        text: '目标统计线形图'
                    },
                    tooltip: {},
                    legend: {
                        data: ['各部门实际支出','各部门预算支出','支出差距']
                    },
                    xAxis: {
                        data: total_all.user,
                    },
                    yAxis: [{
                            type: 'value',
                            scale: true,
                            name: '支出情况',
                            // max: max_mon,
                            min: 0,
                            boundaryGap: [0.2, 0.2]
                        }],
                    series: [{
                        name: '各部门实际支出',
                        type: 'bar',
                        color:'#60c0fd',
                        data: total_all.user_fact
                    },{
                        name: '各部门预算支出',
                        type: 'bar',
                        color:'#ffae14',
                        data: total_all.user_goal
                    },{
                        name: '支出差距',
                        type: 'bar',
                        // yAxisIndex:1,
                        color:'#ef3737',
                        data: total_all.user_will
                    }]
                });
            }
        }
    });
});