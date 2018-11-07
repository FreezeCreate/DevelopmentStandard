<?php require_once TPL_DIR . '/layout/header.php'; ?>
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
            <h3>【<?php echo $results['department']?>】奖金记录</h3>
            <div class="tool">
                <a class="btn btn-primary get-upBox addResult" data-bind="addResult"> 添 加 </a>
            </div>
        </div>
        <div class="content">
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
                    <label class="form-group">收入资金：<?php echo $results['summoney']?></label>
                    <label class="form-group">支出资金：<?php echo $results['money']?></label>
                </form>
            </div>
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-lst table-hover">
                <thead>
                    <tr>
                        <th>金额</th>
                        <th>说明</th>
                        <th>时间</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results['log'] as $k => $v) { ?>
                        <tr class="Result<?php echo $v['id'] ?>">
                            <td class="<?php echo $v['type']>0?'color-green':'color-red';?>"><?php echo $v['type']>0?'+'.$v['money']:'-'.$v['money'];?></td>
                            <td><?php echo $v['explain']; ?></td>
                            <td><?php echo $v['adddt']; ?></td>
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
                        <input type="hidden" id="Mid" name="id" value="<?php echo $results['id']?>"/>
                        <table class="table table-add">
                            <tbody>
                                <tr>
                                    <td><span class="color-red">*</span> 类别</td>
                                    <td>
                                        <select class="form-control" name="type">
                                            <option value="1">奖励</option>
                                            <option value="-1">支出</option>
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
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveBonuslog"); ?>",
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
                    var txt = '<tr class="Result'+data.data.id+'"><td class="'+$class+'">'+$money+'</td><td>'+data.data.explain+'</td><td>'+data.data.adddt+'</td> <td></td></tr>';
                    $('.table-lst tbody').prepend(txt);
                } else {
                    alert(data.msg);
                    loading('none');
                }

            }
        });
    }

    
    </script>
</section>
</body>
</html>





