$(()=>{
    getPagesBox({
        nowUrl:"app.php/budgetcount/budgetLine",
        addList(data){
            var max_mon=0;
            for(var mon of data.sum_mon){
                if(max_mon<mon){
                    max_mon=mon;
                }
            }
            for(var mon of data.will_mon){
                if(max_mon<mon){
                    max_mon=mon;
                }
            }
            for(var mon of data.count_mon){
                if(max_mon<mon){
                    max_mon=mon;
                }
            }
            console.log(data.depart.length);
            if(!data.depart.length>0){
                $('.histogram-trd').remove();
                console.log(101);
                return false;
            }
            if($(".histogram-trd").length>0){
                var myChart = echarts.init($(".histogram-trd")[0]);
                myChart.setOption({
                    title: {
                        text: '预算管理线形图'
                    },
                    tooltip: {},
                    legend: {
                        data: ['各部门实际支出','各部门预算支出','支出差距']
                    },
                    xAxis: {
                        data: data.depart,
                    },
                    yAxis: [{
                            type: 'value',
                            scale: true,
                            name: '支出情况',
                            // max: max_mon,
                            min: 0,
                            boundaryGap: [0.2, 0.2]
                        },
                        {
                            type: 'value',
                            scale: true,
                            name: '同比差距',
                            // max: max_mon,
                            // min: max_mon*(-1),
                            boundaryGap: [0.2, 0.2]
                    }],
                    series: [{
                        name: '各部门实际支出',
                        type: 'line',
                        color:'#60c0fd',
                        data: data.count_mon
                    },{
                        name: '各部门预算支出',
                        type: 'line',
                        color:'#ffae14',
                        data: data.sum_mon
                    },{
                        name: '支出差距',
                        type: 'line',
                        yAxisIndex:1,
                        color:'#ef3737',
                        data: data.will_mon
                    }]
                });
            }
            if($("#histogram-fth").length>0){
                var myChart1 = echarts.init($("#histogram-fth")[0]);
                var will=data.will_mon;
                for(var i in will){
                    will[i]=will[i]<0?(will[i]*-1):will[i];
                }
                myChart1.setOption({
                    title: {
                        text: '预算管理柱状图'
                    },
                    legend: {
                        data: ['各部门实际支出','各部门预算支出','支出差距']
                    },
                    xAxis: {
                        data: data.depart,
                    },
                    yAxis: [{
                            type: 'value',
                            scale: true,
                            name: '支出情况',
                            // max: max_mon,
                            min: 0,
                            boundaryGap: [0.2, 0.2,0.2]
                        },
                    ],
                    series: [{
                        name: '各部门实际支出',
                        type: 'bar',
                        color:'#60c0fd',
                        data: data.count_mon
                    },{
                        name: '各部门预算支出',
                        type: 'bar',
                        color:'#ffae14',
                        data: data.sum_mon
                    },{
                        name: '支出差距',
                        type: 'bar',
                        color:'#ef3737',
                        data: will,
                    }]
                });      
            }
        }
    });
});