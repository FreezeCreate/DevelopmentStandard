$(()=>{
    $(document).on('click','#showTable .updInvSub',function(){
        var that=$(this);
        that.addClass('l_loading-mini');
        var data=new Object();
        that.parent().parent().children().children('input').each(function(i,e){
            var _that=$(e);
            data[_that.attr('name')]=_that.val();
        });
        data.token=dataToken;
        $.ajax({
            type:'post',
            url:dataURL+'/app.php/invoice/updateWare',
            data,
            dataType:'json',
            success(data){
                that.removeClass('l_loading-mini');
                Alert(data.msg);
            },
            error:function(){
                console.error('网络错误');
            }
        });
    });
    $(document).on('click','#showTable .updHouSub',function(){
        var that=$(this);
        that.addClass('l_loading-mini');
        var data=new Object();
        that.parent().parent().children().children('input').each(function(i,e){
            var _that=$(e);
            data[_that.attr('name')]=_that.val();
        });
        data.token=dataToken;
        $.ajax({
            type:'post',
            url:dataURL+'/app.php/warehouse/updateWare',
            data,
            dataType:'json',
            success(data){
                that.removeClass('l_loading-mini');
                Alert(data.msg);
            },
            error:function(){
                console.error('网络错误');
            }
        });
    });
});