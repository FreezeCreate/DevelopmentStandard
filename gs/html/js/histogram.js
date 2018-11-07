(function(){    
    // 柱状图一期
    function getHistogram(){
        $(".histograms").each(function(i,item){
            var that=$(item);
            var newWidth=parseInt(that.attr('width'));
            var newHeight=parseInt(that.attr('height'));
            var newTitle=that.attr("data-title");
            var newVal=parseInt(that.attr("data-val"));
            var his=item.getContext('2d');
            var newX=[],newY=[],newColor=[];
            for(var newItem of item.children[0].children){
                newX.push(newItem.children[0].innerHTML);
                newY.push(newItem.children[1].innerHTML);
                newColor.push(newItem.children[2].innerHTML);
            }
            his.font="18px Arial";
            his.fillText(newTitle,0.05*newWidth,0.1*newHeight);
            // y轴的值
            for(var i=0,nowVal=newVal;i<5;i++){
                var textWidth=0.04*newWidth;
                if(nowVal%10!=0)nowVal=nowVal-nowVal%10;
                if((nowVal+'').length<(newVal+'').length)textWidth+=8;
                his.beginPath();
                his.font="15px Arial";
                his.fillText(nowVal,textWidth,(0.25+i*0.11)*newHeight);
                his.lineWidth=0.1;
                his.moveTo(0.1*newWidth,(0.25+i*0.11)*newHeight-5);
                his.lineTo(newWidth,(0.25+i*0.11)*newHeight-5);
                his.stroke();
                nowVal-=newVal/5;
            }
            // 线条
            his.beginPath();
            his.lineWidth=1;
            his.moveTo(0,0.8*newHeight);
            his.lineTo(newWidth,0.8*newHeight);
            his.moveTo(0.1*newWidth,0.9*newHeight);
            his.lineTo(0.1*newWidth,0.2*newHeight);
            his.stroke();
            // x轴和对应的y轴的值
            for(var i=0,j=0.2*newWidth;i<newX.length;i++,j+=(0.8*newWidth/newX.length)){            
                his.beginPath();
                his.font="15px Arial";
                his.fillText(newX[i],j,0.9*newHeight);
                his.fillStyle=newColor[i];
                var h=(0.55*newHeight*parseInt(newY[i])/newVal);
                // 动画加载柱状图
                // var nowVal=0;
                // function hisTimer(){
                //     his.fillRect(j+20,0.8*newHeight-h,40,h);
                //     his.stroke();
                //     his.fillStyle="black";
                //     his.fillText(newY[i],j+20,0.8*newHeight-h-10);
                //     if(nowVal<h)nowVal++;
                //     else{
                //         return;
                //     }
                //     console.log(nowVal);
                // }
                // setInterval(hisTimer,200/h);
                his.fillRect(j+20,0.8*newHeight-h,40,h);
                his.stroke();
                his.fillStyle="black";
                his.fillText(newY[i],j+20,0.8*newHeight-h-10);
            }
        });
    }
    getHistogram();
    // 柱状图二期工程-部门员工详情表
    function getHistogramSec({casWidth,casHeight,title,value,newName,valueY,newColor,thisI,newClass}){
        if(!casWidth)casWidth=800;
        if(!casHeight)casHeight=300;
        if(!newColor)newColor=['#5094ec','#90de8e','#f4e268'];
        if(!thisI)thisI=0;
        if(newClass.length>0){
            newClass.append(`<canvas data-val="${value}" data-title="${title}" width="${casWidth}" height="${casHeight}" data-x="${newName}" data-y="${valueY}"></canvas>`);
            var that=$(newClass[0].children[0]);
            var newWidth=parseInt(that.attr('width')),newHeight=parseInt(that.attr('height')),newTitle=that.attr("data-title").split(","),newVal=parseInt(that.attr("data-val"));
            var his=that[thisI].getContext('2d');
            var nowX=that.attr("data-x").split(","),dataY=that.attr("data-y").split(",");
            for(var i=0,nowY=[];i<nowX.length;i++){
                nowY[i]=dataY.splice(0,3);
            }
            for(var i=0,j=0;i<newColor.length;i++,j+=150){
                his.font="18px Arial";
                his.fillText(newTitle[i],0.05*newWidth+j,0.1*newHeight);
                his.fillStyle=newColor[i];
                his.fillRect(0.05*newWidth+j-18,0.1*newHeight-15,0.05*newHeight,0.05*newHeight);
                his.stroke();
                his.fillStyle="black";
            }
            // y轴的值
            for(var i=0,nowVal=newVal;i<5;i++){
                var textWidth=0.04*newWidth;
                if(nowVal%10!=0)nowVal=nowVal-nowVal%10;
                if((nowVal+'').length<(newVal+'').length)textWidth+=8;
                his.beginPath();
                his.font="15px Arial";
                his.fillText(nowVal,textWidth,(0.25+i*0.11)*newHeight);
                his.lineWidth=0.1;
                his.moveTo(0.1*newWidth,(0.25+i*0.11)*newHeight-5);
                his.lineTo(newWidth,(0.25+i*0.11)*newHeight-5);
                his.stroke();
                nowVal-=newVal/5;
            }
            // 线条描绘
            his.beginPath();
            his.lineWidth=1;
            his.moveTo(0,0.8*newHeight);
            his.lineTo(newWidth,0.8*newHeight);
            his.moveTo(0.1*newWidth,0.9*newHeight);
            his.lineTo(0.1*newWidth,0.2*newHeight);
            his.stroke();
            // x轴和对应的y轴的值
            for(var i=0,j=0.15*newWidth;i<nowX.length;i++,j+=(0.8*newWidth/nowX.length)){
                his.beginPath();
                his.font="15px Arial";
                his.fillText(nowX[i],j+40,0.9*newHeight);
                his.fillStyle="#fff";
                for(var item=0,h=0,jour=j;item<nowY[i].length;item++,jour+=40){
                    h=(0.55*newHeight*parseInt(nowY[i][item]))/newVal;
                    his.fillStyle=newColor[item];
                    his.fillRect(jour,0.8*newHeight-h,40,h);
                    his.stroke();
                    his.font='12px Arial';
                    his.fillText(nowY[i][item],jour+5,0.8*newHeight-h-8);
                    his.fillStyle="black";
                }
            }
        }
    }
    $(()=>{
        var valueY=[[54000,40000,14000],[20000,20000,0],[20000,10000,10000],[50000,20000,30000]];
        var title=["销售目标",'实际完成金额','未完成金额'];
        var newName=['张三','李四','王五'];
        getHistogramSec({title,value:60000,newName,valueY,thisI:0,newClass:$(".histogram-sec")});
    });
    // 柱状图三期  div布局
    function getHistogramTrd({myClass,title,maxY,valX,valY,myColor,w,h}){
        if(!w)w=900;
        if(!h)h=400;
        if(!myColor)myColor=['#5094ec','#90de8e','#f4e268'];
        var html=`<div></div>`;
        myClass.append(html);
    }
    $(()=>{
        var myClass=$(".histogram-trd");
        var title=["销售目标",'实际完成金额','未完成金额'];
        var maxY='80';
        var valX=['张三','李四','王五'];
        var valY=[[55,45,35],[60,50,70],[80,60,40]];
        getHistogramTrd({title,myClass});
    });
})();