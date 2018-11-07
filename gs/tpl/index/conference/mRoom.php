<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>会议记录</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <?php if ($shop_count > 1) { ?>
                                <select class="TablesSerchInput" name="shopid">
                                    <option value='0'>全部</option>
                                    <?php foreach ($shop as $k => $v) { ?>
                                        <option value="<?php echo $v['id']; ?>" <?php
                                        if ($page_con['shopid'] == $v['id']) {
                                            echo 'selected';
                                        }
                                        ?> ><?php echo $v['shopname']; ?></option>
                                            <?php } ?>
                                </select>
                                <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="会议主题"/>
                                <button class="Btn Btn-primary">查询</button>
                                <span class="Btn Btn-info TablesSerchReset">重置</span>
                            <?php } ?>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn InPop" data-BoxId="room">＋ 新增</div>
                </div>
                <?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="TablesBody top20">
                        <table>
                            <thead>
                                <tr>
                                    <td>会议室名称</td>
                                    <td>所属公司</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr id='room<?php echo $v['id']; ?>'>
                                        <td><?php echo $v['name']; ?></td>
                                        <td shopid='<?php echo $v['shopid'] ?>'><?php echo $v['shopname']; ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                                操作  ＋
                                                <ul class="menu">
                                                    <li class="menu-item"><a class="follow InPop" data-BoxId="room" itemid="<?php echo $v['id'] ?>">编辑</a></li>
                                                    <li class="menu-item"><a class="color-red" onclick="del_form(<?php echo $v['id'] ?>)">删除</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <div class="Tan" id="room">
            <div class="TanBox">
                <div class="TanBoxTit">会议室信息 <span class="close OtPop"data-BoxId="room"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="room_form" onsubmit="return false">
                        <div class="FrameTable">
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">会议室名称</td>
                                    <td>
                                        <input class='FrameGroupInput' value='' name='name' />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">所属公司</td>
                                    <td>
                                        <?php if ($shop_count > 1) { ?>
                                            <select class="FrameGroupInput selectShop" >
                                                <option value='0'>请选择公司</option>
                                                <?php foreach ($shop as $k => $v) { ?>
                                                    <option value='<?php echo $v['id']; ?>'><?php echo $v['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <span id='shopname'><?php echo $shop['shopname']; ?></span>
                                            <input class='FrameGroupInput' type='hidden' value='<?php echo $shop['id']; ?>' name='shopid' />
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="TanBtn">
                                <input id="eid" type="hidden" name="id" value=""/>
                                <span class="Btn Big InPop" data-BoxId="room" onclick="do_room()">确定</span>
                                <span class="Btn Big Blue OtPop"data-BoxId="room">取消</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>

</html>

<script>
        function del(id) {
            Confirm('确定删除该会议室信息？', function(e) {
                if (e) {
                    $.post("<?php echo spUrl($c, "delRoom"); ?>", {id: id}, function(data) {
                        if (data.status == 1) {
                            Alert(data.msg, function() {
                                window.location.reload();
                            });
                        } else {
                            Alert(data.msg);
                        }
                        $('.operate').hide();
                    }, 'json');
                }
            });
        }
</script>


<script type="text/javascript">
    $('.selectShop').change(function() {
        var shopid = $(this).val();
        var text = $(this).text();
        $('#addRoom_form input[name="shopid"]').val(shopid);
        $('#shopname').text(text);
    });

    $('.addroom').click(function() {
        $('#addRoom').show();
    });

    $('.follow').click(function() {
        var id = $(this).attr('itemid');
        $('#eid').val(id);
        var name = $('#room' + id).children('td').eq(0).text();
        var shopid = $('#room' + id).children('td').eq(1).attr('shopid');
        var shopname = $('#room' + id).children('td').eq(1).text();
        $('#shopname').text(shopname);
        $('#room_form input[name="shopid"]').val(shopid);
        $('#room_form input[name="name"]').val(name);
    });

    function do_room() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'addUpRoom'); ?>",
            data: $('#room_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.location.reload();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }


</script>
