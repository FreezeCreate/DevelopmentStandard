    $(function(){
        var dataURL='http://192.168.1.136/',dataToken='5523cbad2881cc1ea54a6b55083547c6a932eef2';
        let swiperWidth=0;
        $('.swiper-container-ul li').each(function(i,e){
            var that=$(e);
            swiperWidth+=(that.width()+40);
        });
        $('.swiper-container-ul').width(swiperWidth+1);
        $('.content').css('height',$('.right').height()+50);
        $(window).scroll(function(){
            if($(window).scrollTop() >= 400){
                $('.swiper-container-box').css('position','fixed');
                // $('.left').css('position','fixed');
                $('.right').css('margin-left',$('.left').width());
            }else if($(window).scrollTop() <= 350){
                $('.swiper-container-box').css('position','relative');
                // $('.left').css('position','');
                $('.right').css('margin-left','');
            };
            //滚动到标杆位置,左侧导航加active
            var swiperLeft=0;
            $('.right ul li').each(function(){
                var target = parseInt($(this).offset().top-$(window).scrollTop()-350);
                var i = $(this).index();
                var boxWidth=$('.swiper-container-box').width();
                var thisWidth=$('.swiper-container-ul li').eq(i).width();
                swiperLeft+=(thisWidth+40);
                if (target<=0) {
                    $('.swiper-container-ul li').removeClass('actives');
                    $('.swiper-container-ul li').eq(i).addClass('actives');
                    if(i==0){
                        $('.swiper-container-ul').css({'left':0});
                    }else if(i>$('.swiper-container-ul').children().length-3){
                        $('.swiper-container-ul').css({'left':boxWidth-swiperWidth});
                    }else{
                        $('.swiper-container-ul').css({'left':-swiperLeft+200});
                    }
                }
            });
        });
        $('.header ul li').click(function(){
            var i = $(this).index('.header ul li');
            $('body, html').animate({scrollTop:$('.right ul li').eq(i).offset().top-40},500);
        });
        $('.swiper-container-ul-li').click(function(){
            var index = $(this).index();
            // $('.right ul li').eq(index).s;
            $('body, html').animate({scrollTop:$('.right ul li').eq(index).offset().top-230},500);
            if(index == 0){
                $('.swiper-container-ul-li').eq(1).removeClass('actives');
                $('.swiper-container-ul-li').eq(2).removeClass('actives');
            setTimeout(function(){
                $('.swiper-container-ul-li').eq(0).addClass('actives');
            },500);
        }else if(index == 1){
            $('.swiper-container-ul-li').eq(2).removeClass('actives');
            $('.swiper-container-ul-li').eq(0).removeClass('actives');
            setTimeout(() => {
            $('.swiper-container-ul-li').eq(1).addClass('actives');
            }, 500);
        }else if(index == 2){
            $('.swiper-container-ul-li').eq(0).removeClass('actives');
            $('.swiper-container-ul-li').eq(1).removeClass('actives');
            setTimeout(() => {
            $('.swiper-container-ul-li').eq(2).addClass('actives');
            }, 500);
        }
        });
        //订单选择
        $.ajax({
            type : 'get',
            url : dataURL+'/app.php/service/ordersLst',
            data : {token : dataToken},
            dataType : 'json',
            success(data){
                if(data.msg!=1){
                    var res=data.results,html='<option value="">订单选择</option>';
                    if(res){
                        for(var {id,name} of res){
                            html+=`<option value="${id}">${name}</option>`;
                        }
                        $('#oid').html(html);
                    }
                }else{
                    alert(data.msg);
                }
            },
            error(){
                alert('网络错误');
            }
        });
        // $(document).ready(function(){
        //     $('#dtBox').DateTimePicker({
        //         addEventHandlers: function(){
        //             var that=this;
        //             $(".DateTime").click(function(e){
        //                 e.stopPropagation();
        //                 that.showDateTimePicker($(this));
        //             });
        //         }
        //     });
        // });
    });