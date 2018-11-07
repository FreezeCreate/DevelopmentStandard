$(()=>{
    console.log('login');
    $.ajax({
        type:"get",
        url:dataURL+"dailywork/dailyworkinfo",
        dataType:"json",
        data:{id:1,token:dataToken},
        success:function(data){
            console.log(data);
        },
        error:function(){
            alert("网络错误");
        }        
    });
    // 5523cbad2881cc1ea54a6b55083547c6a932eef2
});