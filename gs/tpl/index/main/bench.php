<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
    <body style="min-width: 930px;">
        <div class="ContentBox">
            <div class="row">
                <div class="Module col6">
                    <div class="ModuleHead BgGreen">
                        <i class="icon-time"></i>待办事项
                        <a class="float-right" id="refresh_text">刷新</a>
                    </div>
                    <div class="ModuleCont">
                        <div class="ModuleScroll">
                            <table class="Table TableBorder">
                                <thead class="TableHd">
                                    <tr>
                                        <th>模块</th>
                                        <th>申请日期</th>
                                        <th>摘要</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody class="textCenter" id="newbill">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="Module col6">
                    <div class="ModuleHead BgGray">
                        <i class="icon-order"></i>查看订单
                        <a class="float-right NewHtml a_240 active" data-url="/sell/orders" data-clas="a_240" data-img="/source/images/gai_.png" data-name="订单列表">更多 >></a>
                    </div>
                    <div class="ModuleCont">
                        <div class="ModuleScroll">
                            <table class="Table TableBorder">
                                <thead class="TableHd">
                                    <tr>
                                        <th>订单编号</th>
                                        <th>客户</th>
                                        <th>价格</th>
                                        <th>时间</th>
                                    </tr>
                                </thead>
                                <tbody class="textCenter" id="orders">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row top20">
                <div class="Module col6">
                    <div class="ModuleHead BgBlue">
                        <i class="icon-radio"></i>通知公告
                        <a class="float-right NewHtml a_261" data-url="/person/infor" data-clas="a_261" data-img="/source/images/gai_62.png" data-name="通知公告">更多 >></a>
                    </div>
                    <div class="ModuleCont">
                        <div class="ModuleScroll">
                            <ul class="ListBox BorderDas" id="infor">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
</html>
<script type="text/javascript">
        var second = 1;
        $(function() {
            $('#refresh_text').click(function() {
                gettotal();
            });
        });
        var total = setInterval(stime, 1000);
        function stime() {
            second--;
            if (second < 1) {
                gettotal();
            }else{
                $('#refresh_text').html(second+'秒后刷新');
            }
        }

        function gettotal() {
            $('#refresh_text').html('刷新统计中...');
            clearTimeout(total);
            $.get("<?php echo spUrl('main', "gettotal"); ?>", {time: <?php echo time(); ?>}, function(data) {
                var newbill = '';
                if(data.newbill){
                    $.each(data.newbill,function(k,v){
                        newbill += '<tr onclick="check_apply('+v.modelid+','+v.tid+')"><td>'+v.modelname+'</td><td>'+v.applydt+'</td><td>'+v.summary+'</td><td><a>详情</a></td></tr>';
                    });
                }
                $('#newbill').html(newbill);
                var infor = '';
                if(data.infor){
                    $.each(data.infor,function(k,v){
                        infor += '<li class="ListItem Point"><a onclick="check_apply(1,'+v.id+')"><span class="ListItemLeft">【'+v.type+'】'+v.title+'</span><span class="ListItemRight">['+v.date+']</span></a></li>';
                    });
                }
                $('#infor').html(infor);
                var orders = '';
                if(data.orders){
                    $.each(data.orders,function(k,v){
                        var money = v.money?v.money:'未报价';
                        orders += '<tr><td class="NewPop" data-url="/sell/ordersInfo/id/'+v.id+'" data-title="订单详情">'+v.number+'</td><td>'+v.cname+'</td><td>'+money+'</td><td>'+v.date+'</td></tr>';
                    });
                }
                $('#orders').html(orders);
                if (data.total.upcoming > 0) {
                    parent.window.$('#hupcoming_badge').html('（'+data.total.upcoming+'）');
                } else {
                    parent.window.$('#hupcoming_badge').html('（0）');
                }
                second = 120;
                $('#refresh_text').html('120秒后刷新');
                total = setInterval(stime, 1000);
            }, "json");
        }

    </script>
