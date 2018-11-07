$(()=>{
    // 打开收起问题框
    $(".question-border").on("click",".que-btn",function(){
        var $this=$(this);
        var queContent=$this.parent()
            .parent().parent()
            .children(".question-content");
        if(queContent.css('height')=='60px'){
            queContent.css({
                'height':0,
                'opacity':0
            });
            $this.html('查看解答 +');
        }else{
            queContent.css({
                'height':60+'px',
                'opacity':1
            })
            $this.html('收起');
        }
    });
    // 点赞
    $(".question-header").on('click','.like',function(){
        var $this=$(this);
        var html=parseInt($this.children(".like-val").html());
        var likeI=$this.children(".like-i");
        if(!$this.hasClass("like-blue")){
            likeI.css({
                'opacity':0,
                'bottom':20,
                'color':'blue'
            });
            html++;
            $this.children(".like-val").html(html);
            $this.addClass("like-blue");
        }
    });
});