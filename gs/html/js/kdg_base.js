"use strict"
$(()=>{
    // 汇报表名称
    $(".liveCateLst").each(function (i, e) {
        var that = $(e);
        showCommonList("app.php/service/liveCateLst", function (data) {
            if (data.code == 0) {
                var res = data.results, html = '<option   value="">--现场知识库类型--</option>';
                for (var {id, catename} of res) {
                    html += `<option   value="${id}">${catename}</option>`;
                }
                that.html(html);

                getPagesBox({
                    nowUrl:"/app.php/service/liveConLst",
                    addList(data){
                        $(".noMsg").hide();
                        if(data.code!=0){
                            console.log(data.msg);
                            return false;
                        }
                        var res=data.results;
                        if(!res)return false;
                        var html='',i=0;
                        for(var {id,live_title,live_desc,catename,live_adddt,optname} of res){
                            //{ "id": "id", "live_title": "标题", "live_desc": "内容", "live_adddt": "添加时间", "optid": "操作人id", "optname": "操作人", "optdt": "操作时间", "cid": "公司id", "del": "是否删除1、删除0、未删除", "cateid": "类型id", "see": "" }
                            i++;
                            html+=`<tr title="${live_desc}">
                                    <td>${i}</td>
                                    <td>${live_title}</td>
                                    <td>${live_adddt}</td>
                                    <td>${optname}</td>
                                    <td>
                                        <div class="colorBlu list-menu" style="display: inline-block;">
                                            操作+
                                            <ul class="menu">
                                                <li data-url="service/liveConItem.html?id=${id}" class="colorBlu menu-item NewPop" data-title="知识库详情">
                                                    <a href="#">详情</a>
                                                </li>
                                                <li data-url="service/updLiveCon.html?id=${id}" class="colorBlu menu-item NewPop" data-title="修改知识库信息">
                                                    <a href="#">修改</a>
                                                </li>
                                                <li class="colorRed delTr menu-item" data-cid="${id}">
                                                    <a href="#">删除</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>`
                            /*html+=`<div class="question-border top20">
                                    <div class="question-header">
                                        <div  class="question-title">
                                            <span>问题 ：</span>
                                            <input type="text" value="${live_title}">
                                            <button class="que-btn">查看解答 +</button>
                                        </div>
                                        <div class="float-right colorBlu list-menu" style="display: inline-block;">
                                            操作+
                                            <ul class="menu">
                                                <li data-url="service/liveConItem.html?id=${id}" class="colorBlu menu-item NewPop" data-title="知识库详情">
                                                    <a href="#">详情</a>
                                                </li>
                                                <li data-url="service/updLiveCon.html?id=${id}" class="colorBlu menu-item NewPop" data-title="修改知识库信息">
                                                    <a href="#">修改</a>
                                                </li>
                                                <li class="colorRed delTr menu-item" data-cid="${id}">
                                                    <a href="#">删除</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="float-right like" style="margin-right: 100px;">
                                            <span class="like-val">222</span>人觉得有效<i class="like-i">+1</i>
                                        </div>
                                        <div class="float-right circle">
                                            创建于 ：<span>${live_adddt}</span>
                                        </div>
                                        <div class="float-right avatar">
                                            创建人 ：<span>${optname}</span>
                                        </div>
                                    </div>
                                    <div class="question-content">解答：${live_desc}</div>
                                    <div class="question-footer">
                                        <div class="que-tag">${live_title}</div>
                                    </div>
                                </div>`;*/
                        }
                        $("#dataList").html(html);
                        // // 打开收起问题框
                        // $(".question-border").on("click",".que-btn",function(){
                        //     var $this=$(this);
                        //     var queContent=$this.parent()
                        //         .parent().parent()
                        //         .children(".question-content");
                        //     if(queContent.css('height')=='60px'){
                        //         queContent.css({
                        //             'height':0,
                        //             'opacity':0
                        //         });
                        //         $this.html('查看解答 +');
                        //     }else{
                        //         queContent.css({
                        //             'height':60+'px',
                        //             'opacity':1
                        //         })
                        //         $this.html('收起');
                        //     }
                        // });
                        // // 点赞
                        // $(".question-header").on('click','.like',function(){
                        //     var $this=$(this);
                        //     var html=parseInt($this.children(".like-val").html());
                        //     var likeI=$this.children(".like-i");
                        //     if(!$this.hasClass("like-blue")){
                        //         likeI.css({
                        //             'opacity':0,
                        //             'bottom':20,
                        //             'color':'blue'
                        //         });
                        //         html++;
                        //         $this.children(".like-val").html(html);
                        //         $this.addClass("like-blue");
                        //     }
                        // });            
                        // $('.delTr').on('click',function(){
                        //     var that = $(this);
                        //     Confirm('确定删除？',function(e){
                        //         if(e){
                        //             that.closest(".question-border").remove();
                        //             var id=that.data("cid");
                        //             $.ajax({
                        //                 type:"post",
                        //                 url:dataURL+"/app.php/service/delLiveCon",
                        //                 dataType:"json",
                        //                 data:{id,token:dataToken},
                        //                 success:function(data){
                        //                     if(data.code==0){
                        //                         // location.reload();
                        //                         console.log("删除成功，此界面仅限于操作人员");
                        //                     }
                        //                 },
                        //                 error(){
                        //                     alert("删除失败！");
                        //                     console.log(this);
                        //                 }
                        //             });                        
                        //         }
                        //     },false);
                        // });
                    }
                });
            } else {
                console.error("网络错误！");
            }
        });
    });
});