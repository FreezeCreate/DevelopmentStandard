$(()=>{
    if($(".histogram-trd").length>0){
        var myChart = echarts.init($(".histogram-trd")[0]);
        myChart.setOption({
            title: {
                text: '预算管理'
            },
            tooltip: {},
            legend: {
                data: ['实际情况','预算情况']
            },
            xAxis: {
                data: ["采购支出","其他支出","总收益","总利润"]
            },
            yAxis: [{
                    type: 'value',
                    scale: true,
                    name: '支出情况',
                    max: 60000,
                    min: 0,
                    boundaryGap: [0.2, 0.2]
                },
                {
                    type: 'value',
                    scale: true,
                    name: '同比差距',
                    max: 100,
                    min: -100,
                    boundaryGap: [0.2, 0.2]
            }],
            series: [{
                name: '实际情况',
                type: 'line',
                data: ['54000','40000','14000','5000']
            },{
                name: '预算情况',
                type: 'line',
                data: ['24000','20000','4000','15000']
            },{
                name: '同比减少',
                type: 'line',
                yAxisIndex:1,
                data: ['1','20','-40','50']
            }]
        });
    }
    if($("#histogram-fth").length>0){
        var myChart1 = echarts.init($("#histogram-fth")[0]);
        myChart1.setOption({
            title: {
                text: '预算管理'
            },
            legend: {
                data: ['本月实际采购金额','本月预计采购金额','同比增加金额']
            },
            xAxis: {
                data: ["采购物1","采购物2","采购物3","采购物4"]
            },
            yAxis: [{
                    type: 'value',
                    scale: true,
                    name: '支出情况',
                    max: 80,
                    min: 0,
                    boundaryGap: [0.2, 0.2,0.2]
                },
            ],
            series: [{
                name: '本月实际采购金额',
                type: 'bar',
                color:'#60c0fd',
                data: ['55','55','55','45']
            },{
                name: '本月预计采购金额',
                type: 'bar',
                color:'#ffae14',
                data: ['45','45','45','45']
            },{
                name: '同比增加金额',
                type: 'bar',
                color:'#ef3737',
                data: ['15','15','15','15']
            }]
        });      
    }
});