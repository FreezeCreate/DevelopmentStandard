<?php require_once TPL_DIR . '/layout/header.php'; ?>
<style type="text/css">
    .zijin span{font-size:18px;color:#FFF;line-height: 180%;margin-right: 20px}
</style>
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
            <h3>押金管理</h3>
            <div class="tool">
                <a class="btn btn-primary get-upBox addResult" data-bind="addResult"> 添 加 </a>
            </div>
        </div>
        <div class="content">
            <div class='zijin'>
                <span>收入资金：<?php echo $results['summoney']?>元</span>
                <span>支出资金：<?php echo $results['money']?>元</span>
                <span>余额：<?php echo ($results['summoney'] - $results['money']);?>元</span>
            </div>
            <div class="search">
                <form action="<?php echo spUrl($c, $a) ?>" method="get">
                    <label class="form-group">
                        类别：<select class="form-control" name="type">
                            <option value="0">全部</option>
                            <option <?php echo $page_con['type'] === '1' ? 'selected=""' : '' ?> value="1">收入</option>
                            <option <?php echo $page_con['type'] === '-1' ? 'selected=""' : '' ?> value="-1">支出</option>
                        </select>
                    </label>
                    <button class="btn btn-sm btn-gray">搜索</button>
                </form>
            </div>
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-lst table-hover">
                <thead>
                    <tr>
                        <th>处罚人</th>
                        <th>金额</th>
                        <th>说明</th>
                        <th>时间</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results['log'] as $k => $v) { ?>
                        <tr class="Result<?php echo $v['id'] ?>">
                            <td><?php echo $v['uname']; ?></td>
                            <td class="<?php echo $v['type']>0?'color-green':'color-red';?>"><?php echo $v['type']>0?'+'.$v['money']:'-'.$v['money'];?></td>
                            <td><?php echo $v['explain']; ?></td>
                            <td><?php echo $v['dt']; ?></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
            <div class="upBox add" id="addResult">
                <div class="upBox-t">
                    <h3>添加资金记录</h3>
                    <a class="close"><i class="icon-del"></i></a>
                </div>
                <div class="upBox-c" style="height:900px;">
                    <form id="addResult_form" method="post" action="" onsubmit="return false;">
                        <input type="hidden" id="Mid" name="id" value=""/>
                        <table class="table table-add">
                            <tbody>
                                <tr>
                                    <td>相关员工</td>
                                    <td colspan="3"><input type="hidden" id="uid" name="uid" value=""/><input class="form-control get-upBox01 notenter" data-bind="Users" type="text" id="uname" name="uname" placeholder="请选择对应员工"/></td>
                                </tr>
                                <tr>
                                    <td><span class="color-red">*</span> 类别</td>
                                    <td>
                                        <select class="form-control" name="type">
                                            <option value="1">交付</option>
                                            <option value="-1">退回</option>
                                        </select>
                                    </td>
                                    <td><span class="color-red">*</span> 金额</td>
                                    <td><input class="form-control" type="text" name="money"/></td>
                                </tr>
                                <tr>
                                    <td>说明</td>
                                    <td colspan="3"><textarea class="form-control" name="explain"></textarea></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="upBox-f">
                            <a class="but but-primary" onclick="do_sub()">确认</a>
                            <a class="but but-gray close">关闭</a>
                        </div>
                    </form>
                    <div class="mark01"></div>
                    <div class="upBox01" id="Users">
                        <div class="upBox-t">
                            <h3>处罚人</h3>
                            <a class="close01"><i class="icon-del"></i></a>
                        </div>
                        <div class="upBox-s">
                            <input id="up-search01" type="text" placeholder="职位/姓名"/>
                        </div>
                        <div class="upBox-cc">
                            <ul class="all-li">
<!--                                <li><a><i class="icon-company"></i> </a>
                                    <ul>
                                        <li><a><i class="icon-branch"></i> </a>
                                            <ul>
                                                <li><a class="active" lang="" title=""><i class="icon-user"></i> </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                            </ul>
                            <ul class="th-li">
                                <li><a></a></li>
                            </ul>
                        </div>
                        <div class="upBox-f">
                            <a class="but but-primary" onclick="getUser()">确定</a>
                            <a class="but but-red" onclick="findUser()">刷新</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    $(document).on('click', '#Users .upBox-cc .all-li li ul li ul li a', function() {
        $('#Users .upBox-cc .all-li li a').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('click', '#Users .upBox-cc .th-li li a', function() {
        $('#Users .upBox-cc .all-li ul li a').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('keyup', '#up-search01', function() {
        var seatxt = $(this).val();
        if (seatxt != '') {
            var sea = $('#Users .upBox-cc .all-li li ul li ul li a:contains("' + seatxt + '")');
            var txt = '';
            for (var i = 0; i < sea.length; i++) {
                txt += '<li>'+sea.eq(i).parent('li').html()+'</li>';
            }
            $('#Users .upBox-cc .all-li ul li a').removeClass('active');
            $('#Users .upBox-cc .th-li').html(txt);
            $('#Users .upBox-cc .all-li').hide();
            $('#Users .upBox-cc .th-li').show();
        }else{
            $('#Users .upBox-cc .all-li ul li a').removeClass('active');
            $('#Users .upBox-cc .th-li').hide();
            $('#Users .upBox-cc .all-li').show();
        }
    });
    
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveDeposit"); ?>",
            data: $('#addResult_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    $('.close').click();
                    $class = data.data.type>0?'color-green':'color-red';
                    $money = data.data.type>0?'+'+data.data.money:'-'+data.data.money;
                    var txt = '<tr class="Result'+data.data.id+'"><td>'+data.data.uname+'</td><td class="'+$class+'">'+$money+'</td><td>'+data.data.explain+'</td><td>'+data.data.dt+'</td> <td></td></tr>';
                    $('.table-lst tbody').prepend(txt);
                } else {
                    alert(data.msg);
                    loading('none');
                }

            }
        });
    }


    function getUser() {
        var id = $('#Users .upBox-cc ul li a.active').attr('lang');
        var name = $('#Users .upBox-cc ul li a.active').attr('title');
        $('#uid').val(id);
        $('#uname').val(name);
        $('.close01').click();
    }
    
    findUser();
    function findUser(){
        $.get('<?php echo spUrl('main', 'getUsers'); ?>', {id: 5}, function(data) {
            if (data.status == 1) {
                var results = new Array();
                $.each(data.data, function(i, v) {
                    results.push('<li><a><i class="icon-company"></i> ' + v.shopname + '</a><ul>');
                    $.each(v.children, function(i1, v1) {
                        results.push('<li><a><i class="icon-branch"></i> ' + v1.department + '</a><ul>');
                        $.each(v1.children, function(i2, v2) {
                            var positionname = v2.positionname ? v2.positionname : '无';
                            results.push('<li><a lang="' + v2.id + '" title="' + v2.name + '"><i class="icon-user"></i> ' + v2.name + '（' + positionname + '）</a></li>');
                        });
                        results.push('</ul></li>');
                    });
                    results.push('</ul></li>');
                });
                $('#Users .upBox-cc .all-li').html(results.join(''));
                loading('none');
            } else {
                loading('none');
                alert(data.msg);
            }
        }, 'json');
    }
    </script>
</section>
</body>
</html>





