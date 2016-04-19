require.config({
    paths: {
        echarts: 'http://echarts.baidu.com/build/dist'
    }
});
var curTheme;
require(['http://echarts.baidu.com/echarts2/doc/example/theme/macarons'], function(tarTheme){
        curTheme = tarTheme;
        });
// 使用
require(
        [
        'echarts',
        'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
        'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('docker-1') , curTheme); 

            var option = {
                title : {
                    text: '动态监控数据',
    subtext: 'used memory and cpu idle'
                },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['used memory', 'cpu idle']
    },
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            //dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    dataZoom : {
        show : false,
        start : 0,
        end : 100
    },
    xAxis : [
    {
        type : 'category',
        boundaryGap : true,
        data : (function (){
            var now = new Date();
            var res = [];
            var len = 10;
            while (len--) {
                res.unshift(now.toLocaleTimeString().replace(/^\D*/,''));
                now = new Date(now - 2000);
            }
            return res;
        })()
    },
    {
        type : 'category',
        boundaryGap : true,
        data : (function (){
            var res = [];
            var len = 10;
            while (len--) {
                res.push(len + 1);
            }
            return res;
        })()
    }
],
    yAxis : [
    {
        type : 'value',
        scale: true,
        name : 'cpu used per',
        boundaryGap: [0.2, 0.2]
    },
    {
        type : 'value',
        scale: true,
        name : 'memory',
        boundaryGap: [0.2, 0.2]
    }
],
    series : [
    {
        name:'used memory',
        type:'bar',
        xAxisIndex: 1,
        yAxisIndex: 1,
        data:(function (){
            var res = [];
            var len = 10;
            while (len--) {
                res.push(Math.round(Math.random() * 1000));
            }
            return res;
        })()
    },
    {
        name:'cpu idle',
        type:'line',
        data:(function (){
            var res = [];
            var len = 10;
            while (len--) {
                res.push((Math.random()*10 + 5).toFixed(1) - 0);
            }
            return res;
        })()
    }
]
            };
            // 为echarts对象加载数据 
            myChart.setOption(option); 
            var lastData = 11;
            var axisData;
            //clearInterval(timeTicket);
            timeTicket = setInterval(function (){
                lastData += Math.random() * ((Math.round(Math.random() * 10) % 2) == 0 ? 1 : -1);
                lastData = lastData.toFixed(1) - 0;
                axisData = (new Date()).toLocaleTimeString().replace(/^\D*/,'');
                // 动态数据接口 addData
                myChart.addData([
                    [
                    0,        // 系列索引
                    Math.round(Math.random() * 1000), // 新增数据
                    true,     // 新增数据是否从队列头部插入
                    false     // 是否增加队列长度，false则自定删除原有数据，队头插入删队尾，队尾插入删队头
                    ],
                    [
                    1,        // 系列索引
                    lastData, // 新增数据
                    false,    // 新增数据是否从队列头部插入
                    false,    // 是否增加队列长度，false则自定删除原有数据，队头插入删队尾，队尾插入删队头
                    axisData  // 坐标轴标签
                    ]
                    ]);
            }, 2100);
        }
);
