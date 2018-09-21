<?php require_once TPL_DIR . '/layout/header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/date_1.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH; ?>/bootstrap/css/bootstrap.min.css">  
<script src="<?php echo SOURCE_PATH; ?>/js/date_1.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/bootstrap/js/bootstrap.min.js"></script>
<section id="content">
    <?php require_once TPL_DIR . '/layout/left.php'; ?>
    <!--
                    作者：895635200@qq.com
                    时间：2017-08-11
                    描述：主内容区域
    -->
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3>工作计划</h3>
        </div>
        <div class="content">
            <div class="row dat">
                <div class="col-sm-12 dat-right">
                    <div class="dat-nav">
                        <div class="dat-nav-left">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default prev"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-default next"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            <button type="button" class="btn btn-default today active">当天</button>
                        </div>
                        <span class="dat-nav-center"></span>
                        <div class="dat-nav-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default active" data-rightNav="month">月</button>
                                <button type="button" class="btn btn-default"data-rightNav="week">周</button>
                                <button type="button" class="btn btn-default"data-rightNav="day">日</button>
                            </div>
                        </div>
                    </div>
                    <table class="dat-month">
                        <tr>
                            <th>周日</th>
                            <th>周一</th>
                            <th>周二</th>
                            <th>周三</th>
                            <th>周四</th>
                            <th>周五</th>
                            <th>周六</th>
                        </tr>
                    </table>
                    <div class="dat-week">
                        <table class="dat-week-head">
                            <tr class="dat-week-nav">
                                <th width="50"></th>
                                <th>周日</th>
                                <th>周一</th>
                                <th>周二</th>
                                <th>周三</th>
                                <th>周四</th>
                                <th>周五</th>
                                <th>周六</th>
                                <th width="17"></th>
                            </tr>
                            <tr class="dat-week-allDay">
                                <td>all-day</td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td><div class="dat-event"></div></td>
                                <td></td>
                            </tr>
                        </table>
                        <div style="height: 4px;background:#eee"></div>
                        <div class="dat-week-scroll">
                            <table class="dat-week-body">

                            </table>
                        </div>
                    </div>
                    <div class="dat-day">
                        <table class="dat-day-head">
                            <tr class="dat-day-nav">
                                <th width="50"></th>
                                <th>周日</th>
                                <th width="17"></th>
                            </tr>
                            <tr class="dat-day-allDay">
                                <td>all-day</td>
                                <td class="date-today"></td>
                                <td></td>
                            </tr>
                        </table>
                        <div style="height: 4px;background:#eee"></div>
                        <div class="dat-day-scroll">
                            <table class="dat-day-body">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<div class="dat-left">
        <div class="dat-left-box">
                <div class="dat-left-tit">添加日程</div>
                <div class="dat-event-add">
                        <div class="form-group">
                            <input type="text" class="form-control form-block title" placeholder="请输入标题">
                        </div>
                        <div class="form-group">
                                <select class="form-control form-block level">
                                        <option value="0">默认优先级</option>
                                        <option value="1">一般优先级</option>
                                        <option value="2">最高优先级</option>
                                </select>
                        </div>
                        <div class="form-group start">
                                <label>
                                        开始时间 ：
                                        <input type="text" class="form-control start-h" placeholder=""> ：
                                        <input type="text" class="form-control start-m" placeholder="">
                                </label>
                        </div>
                        <div class="form-group end">
                                <label>
                                        结束时间 ：
                                        <input type="text" class="form-control end-h" placeholder=""> ：
                                        <input type="text" class="form-control end-m" placeholder="">
                                </label>
                        </div>
                        <span class="btn btn-success btn-block">添加</span>
                </div>
        </div>
</div>-->
</body>
</html>
<script type="text/javascript">
    var colors = ['bg-red', 'bg-green', 'bg-primary'];
    //获取数据
    function reQ(req) {
        $('.event-item').remove()
        $.ajax({
            type: 'GET',
            url: '<?php echo spUrl('sales','findWorkplan')?>',
            data: req.req_data,
            dataType: "json",
            success: function(msg) {
                if (!msg) {
                    return
                }
                //console.log(msg)
                for (var i = 0; i < msg.length; i++) {
                    req.req_obj.each(function(k, v) {
                        for (var j = 0; j < msg[i].result.length; j++) {
                            if ($(v).attr('data-d') == msg[i].result[j].day && $(v).attr('data-y') == msg[i].result[j].year && $(v).attr('data-m') == (msg[i].result[j].month - 1) && $(v).attr('data-d') == (msg[i].result[j].day) && (req.req_boo ? $(v).attr('data-time') == (msg[i].result[j].start) : true)) {
                                var wid = $(v).width()
                                var dom = document.createElement('div');
                                dom.style.zIndex = msg[i].result[j].start.split(':')[0] - 0
                                dom.className = 'event-item ' + colors[msg[i].result[j].level - 1]
                                !req.req_boo ? $(v).children('.dat-week-body').children('.dat-event').append(dom) : $(v).children('.dat-event').append(dom);

                                $(v).width(wid)
                                var p = document.createElement('p');
                                p.innerHTML = msg[i].result[j].start + ' - ' + msg[i].result[j].end
                                $(dom).append(p);
                                var p_1 = document.createElement('p');
                                p_1.innerHTML = msg[i].result[j].title;
                                $(dom).append(p_1);
                                if (msg[i].result[j].fankui) {
                                    for (var f = 0; f < msg[i].result[j].fankui.length; f++) {
                                        var p_2 = document.createElement('p');
                                        p_2.innerHTML = '反馈 : ' + msg[i].result[j].fankui[f].content;
                                        $(dom).append(p_2);
                                    }
                                }
                                addSpeed(msg[i].result[j], dom)
                            }
                        }
                    })
                }
                ;
            }
        });
    }
    ;
    //添加日程
    function reA(that, reA_obj, boo) {
        $('body').append(
                '<div class="dat-left"><div class="dat-left-box"><div class="dat-left-tit">添加日程<small class="dat-left-close"><i class="fa fa-times"></i></small></div><p class="text-center"></p><div class="dat-event-add">'
                + '<div class="form-group"><input type="text" class="form-control form-block title" placeholder="请输入标题">'
                + '</div><div class="form-group"><select class="form-control form-block level"><option value="3">默认优先级</option>'
                + '<option value="2">一般优先级</option><option value="1">最高优先级</option></select></div><div class="form-group start">'
                + '<label>开始时间 ：<input type="text" class="form-control start-h"> ：<input  type="text" class="form-control start-m"></label></div><div class="form-group end">'
                + '<label>结束时间 ：<input type="text" class="form-control end-h" placeholder=""> ：<input type="text" class="form-control end-m" placeholder=""></label></div><span class="btn btn-success btn-block">添加</span>'
                + '</div></div></div>'
                )
        $('.dat-left-close').click(function() {
            $('.dat-left').remove()
        })
        $('.dat-left').click(function(e) {
            if (e.target == this) {
                $('.dat-left').remove()
            }
        })
        if (boo) {
            var a = that[0].dataset.time.split(':');
            $('.start-h').val(a[0])
            $('.start-h')[0].disabled = true;
            $('.start-m').val(a[1].slice(0, 2))
            $('.start-m')[0].disabled = true;
        }
        var y = that.attr('data-y');
        var m = that.attr('data-m');
        var d = that.attr('data-d');
        $('.text-center').text(y + ' / ' + (m - 0 + 1) + ' / ' + d)
        var event_lists = $('.event-lists');
        $('.dat-event-add .btn-success').click(function() {
            var obj = new Object();
            obj.date = Format(new Date(y, m, d), 'yyyy-MM-dd');
            if ($('.dat-event-add .title').val().length == 0) {
                alert('请填写标题!')
                return
            } else {
                obj.title = $('.dat-event-add .title').val().trim();
            }


            var start_h = $('.start-h').val() - 0;
            var start_m = $('.start-m').val() - 0;
            if (start_m >= 0 && start_m < 30) {
                start_m = 0
            }
            ;
            if (start_m >= 30 && start_m < 60) {
                start_m = 30
            }
            ;

            var end_h = $('.end-h').val() - 0;
            var end_m = $('.end-m').val() - 0;
            if (end_m >= 0 && end_m < 30) {
                end_m = 0
            }
            ;
            if (end_m >= 30 && end_m < 60) {
                end_m = 30
            }
            ;

            var str_s = Format(new Date(y, m, d, start_h, start_m), 'yy-MM-dd HH:mm');
            var str_e = Format(new Date(y, m, d, end_h, end_m), 'yy-MM-dd HH:mm');
            var s_str = str_s.slice(9, 10).indexOf(':') == -1 ? str_s.slice(9, 14) : str_s.slice(9, 13);
            var e_str = str_e.slice(9, 10).indexOf(':') == -1 ? str_e.slice(9, 14) : str_e.slice(9, 13);
            var k1 = 0, k2 = 0;
            reA_obj.each(function(k, v) {
                if ($(v).attr('data-time') == s_str) {
                    k1 = $(v).offset().top;
                }
                ;
            })

            if ($('.start-h').val().length != 0) {
                var p_1 = document.createElement('p')
                p_1.innerHTML = s_str;
            } else {
                alert('请填写开始时间!')
                return
            }
            if ($('.end-h').val().length != 0 && p_1) {
                p_1.innerHTML += ' - ' + e_str;
            } else {
                alert('请填写结束时间!')
                return
            }
            obj.level = $('.dat-event-add .level').val();
            obj.fankui = [];
            obj.start = s_str
            obj.end = e_str

            $.ajax({
                type: "POST",
                url: '<?php echo spUrl('sales','savePlan')?>',
                data: obj,
                dataType: "json",
                success: function(msg) {
                    if (msg.status == 1) {
                        obj.id = msg.data.id;
                        var wid = that.width();
                        var dom = document.createElement('div');
                        dom.className = 'event-item ' + colors[obj.level - 1];
                        $(that[0].childNodes[0]).append(dom);
                        that.width(wid)
                        $(dom).parent().css({'z-index': k1})
                        p_1 ? $(dom).append(p_1) : '';
                        var p = document.createElement('p')
                        p.innerHTML = obj.title;
                        $(dom).append(p);
                        $('.dat-left').remove()
                    } else {
                        alert(msg.msg)
                    }
                }
            });
        })
    }
    ;

    //添加进度
    function innerText(obj, dom) {
        $('body').append(
                '<div class="innerText"><div class="innerText-box">'
                + '<div class="innerText-title">进度反馈<small class="innerText-close"><i class="fa fa-times"></i></small></div>'
                + '<div class="innerText-text"><textarea class="innerText-area" placeholder="点击输入进度反馈"></textarea></div>'
                + '<div class="innerText-btn"><span class="btn btn-success">添加</span><span class="btn btn-default">取消</span></div></div></div>'
                )
        var that = $(dom);
        $('.innerText .btn-default').click(function() {
            $('.innerText').remove();
        })
        var str = ''
        $('.innerText .btn-success').click(function() {
            if ($('.innerText-area').val().length != 0) {
                str = $('.innerText-area').val()
            } else {
                alert('请填写反馈')
            }
            $.ajax({
                type: "POST",
                url: '<?php echo spUrl('sales','saveFankui')?>',
                data: {'id': obj.id, 'fankui': str},
                dataType: "json",
                success: function(msg) {
                    //console.log(msg)
                    if (msg.status == 1) {
                        that.append('<p>反馈：' + str + '</p>')
                        $('.innerText-area').val('')
                        $('.innerText').remove();
                    } else {
                        alert(msg.msg)
                    }
                }
            });
        })
        $('.innerText .innerText-close').click(function() {
            $('.innerText').remove();
        })
    }
    ;
</script>

