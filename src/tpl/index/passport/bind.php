
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>绑定公司</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/regist.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/bind.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div class="regist"></div>
        <div class="header">
            <div class="log"><img style="height: 50px;" src="<?php echo SOURCE_PATH; ?>/images/regist/logo.png"/></div>
            <span class="intus">管理=正确指引＋有效执行力</span>
        </div>
        <div class="main">
            <ul class="lineBox">
                <li class="lineItem active"></li>
                <li class="lineItem "></li>
            </ul>
            <?php if (empty($i)) { ?>
                <div class="cont active">
                    <h3>入职选择</h3>
                    <div class="regBox">
                        <form id="retForm">
                            <div class="sel_item">
                                <div class="select_box fist">
                                    <input class="serch_inp" type="text" name="" id="" value="" placeholder="公司名称"/>
                                    <input class="serch_val" type="hidden" name="cid" id="" value="" />
                                    <span class="serch_btn"></span>
                                </div>
                                <div class="select_menu">
                                    <div class="select_menu_box">
                                        <ul class="select_scrol">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sel_item">
                                <div class="select_box">
                                    <span class="select_text">所在部门</span>
                                    <input type="hidden" class="select_val" name="did" id="" value="" />
                                </div>
                                <div class="select_menu">
                                    <div class="select_menu_box">
                                        <ul class="select_scrol bm">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sel_item">
                                <div class="select_box">
                                    <span class="select_text">所在职位</span>
                                    <input type="hidden" class="select_val" name="pid" id="" value="" />
                                </div>
                                <div class="select_menu">
                                    <div class="select_menu_box">
                                        <ul class="select_scrol zw">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="subm comp">提交</div>
                        </form>
                    </div>
                </div>
            <?php } else if ($i == 1) { ?>
                <div class="cont active">
                    <h3>审核状态</h3>
                    <div class="regBox">
                        <img class="weitimg" src="<?php echo SOURCE_PATH ?>/images/regist/weit.png"/>
                        <p class="tit_">正在审核，请等待…</p>
                        <ul class="cont_boxs">
                            <li class="cont_boxs_item on">申请信息</li>
                            <li class="cont_boxs_item">申请公司：<?php echo $apply['cname']?></li>
                            <li class="cont_boxs_item">申请职位：<?php echo $apply['pname']?></li>
                            <li class="cont_boxs_item">申请部门：<?php echo $apply['dname']?></li>
                            <li class="cont_boxs_item">申请时间：<?php echo $apply['applydt']?></li>
                        </ul>
                    </div>
                </div>
            <?php } else if ($i == 3) { ?>
                <div class="cont active">
                    <h3>审核状态</h3>
                    <div class="regBox">
                        <img class="weitimg" src="<?php echo SOURCE_PATH ?>/images/regist/succ.png"/>
                        <p class="tit_ on">注册成功！</p>
                        <ul class="cont_boxs">
                            <li class="cont_boxs_item on">申请信息</li>
                            <li class="cont_boxs_item">申请公司：<?php echo $apply['cname']?></li>
                            <li class="cont_boxs_item">申请职位：<?php echo $apply['pname']?></li>
                            <li class="cont_boxs_item">申请部门：<?php echo $apply['dname']?></li>
                            <li class="cont_boxs_item">申请时间：<?php echo $apply['applydt']?></li>
                        </ul>
                        <a class="inner" href="<?php echo spUrl('main','index',array('reg'=>1))?>">进入主页</a>
                    </div>
                </div>
            <?php } else if ($i == 2) { ?>
                <div class="cont active">
                    <h3>审核状态</h3>
                    <div class="regBox">
                        <img class="weitimg" src="<?php echo SOURCE_PATH ?>/images/regist/erro.png"/>
                        <p class="tit_ of">注册失败！</p>
                        <div class="textss">
                            <p>失败原因</p>
                            <div class="textbox">
                                <p><?php echo $apply['explain']?></p>
                                <span class="texttime">时间：<?php echo $apply['checkdt']?></span>
                            </div>
                        </div>
                        <ul class="cont_boxs">
                            <li class="cont_boxs_item on">申请信息</li>
                            <li class="cont_boxs_item">申请公司：<?php echo $apply['cname']?></li>
                            <li class="cont_boxs_item">申请职位：<?php echo $apply['pname']?></li>
                            <li class="cont_boxs_item">申请部门：<?php echo $apply['dname']?></li>
                            <li class="cont_boxs_item">申请时间：<?php echo $apply['applydt']?></li>
                        </ul>
                        <a class="inner" href="<?php echo spUrl($c,$a,array('i'=>1))?>">重新申请</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(function() {
        $.ajax({
            type: "POST",
            url: "/app.php/basic/findPosition",
            data: {},
            dataType: "json",
            success: function(res) {
                var str = '';
                $.each(res.data, function(k, v) {
                    str += '<li class="select_item"data-val="' + v.id + '">' + v.name + '</li>'
                });
                $('.select_scrol.zw').append(str)
            }
        });
    })
    $('.select_box').click(function() {
        if ($(this).next().children('.select_menu_box').children('.select_serch')[0]) {
            $(this).next().children('.select_menu_box').animate({'height': '250px'}, 300)
        } else {
            $(this).next().children('.select_menu_box').animate({'height': '200px'}, 300)
        }
    })
    $(document).on('click', '.select_item', function() {
        $(this).parent().parent().parent().prev().children('.select_val').val($(this).attr('data-val'))
        $(this).parent().parent().parent().prev().children('.select_text').text($(this).text())
        $(this).parent().parent().parent().prev().children('.serch_val').val($(this).attr('data-val'))
        $(this).parent().parent().parent().prev().children('.serch_inp').val($(this).text())
    })
    $(document).on('click', '.subm', function() {
        $.ajax({
            type: "POST",
            url: "<?php echo spUrl('passport','boundCompany')?>",
            data: $('#retForm').serialize(),
            dataType: "json",
            success: function(res) {
                Alert(res.msg,function(){
                    window.location.href='<?php echo spUrl($c,$a)?>';
                });
            }
        });
    });
    $(document).on('click', '.select_item.gs', function() {
        var id = $(this).attr('data-val');
        $.ajax({
            type: "POST",
            url: "/app.php/basic/findPosition",
            data: {cid: id},
            dataType: "json",
            success: function(res) {
                var str = '';
                $.each(res.data, function(k, v) {
                    str += '<li class="select_item"data-val="' + v.id + '">' + v.name + '</li>'
                });
                $('.select_scrol.bm').append(str)
            }
        });
    });
    $('.serch_btn').click(function() {
        var val = $('.serch_inp').val().trim();
        var that = $(this);
        if (val) {
            $.ajax({
                type: "POST",
                url: "/app.php/basic/findCompany",
                data: {name: val},
                dataType: "json",
                success: function(res) {
                    var str = '';
                    $.each(res.data, function(k, v) {
                        str += '<li class="select_item gs"data-val="' + v.id + '">' + v.companyinfo + '</li>'
                    });
                    that.parent().next().children('.select_menu_box').children('.select_scrol').children().remove()
                    that.parent().next().children('.select_menu_box').children('.select_scrol').append(str)
                }
            });
        }
    })
    $(document).click(function(e) {
        if (
                e.target.className == 'select_box' ||
                e.target.className == 'serch_inp' ||
                e.target.className == 'serch_btn' ||
                e.target.className == 'select_serch' ||
                e.target.className == 'select_menu_box' ||
                e.target.className == 'select_text'
                ) {

        } else {
            $('.select_menu_box').animate({'height': '0'}, 300)
        }
    })
</script>