<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>用款分类管理</title>
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
                            <select class="TablesSerchInput" name="type">
                                <option value="0">全部</option>
                                <option <?php echo $page_con['type'] === '用款申请' ? 'selected=""' : '' ?> value="用款申请">用款申请</option>
                                <option <?php echo $page_con['type'] === '报销申请' ? 'selected=""' : '' ?> value="报销申请">报销申请</option>
                                <option <?php echo $page_con['type'] === '收款登记' ? 'selected=""' : '' ?> value="收款登记">收款登记</option>
                            </select>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn InPop" data-BoxId="genjin">＋ 新增</div>
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
                                    <td>序号</td>
                                    <td>类别</td>
                                    <td>分类名称</td>
                                    <td>编号</td>
                                    <td>排序</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td><?php echo $k + 1; ?></td>
                                        <td class="data-type" title="<?php echo $v['type'] ?>"><?php echo $v['type']; ?></td>
                                        <td class="data-name" title="<?php echo $v['name'] ?>"><?php echo $v['name']; ?></td>
                                        <td class="data-number" title="<?php echo $v['number'] ?>"><?php echo $v['number']; ?></td>
                                        <td class="data-sort" title="<?php echo $v['sort'] ?>"><?php echo $v['sort']; ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a class="follow InPop" data-BoxId="genjin" itemid="<?php echo $v['id'] ?>"> 编辑</a></li>
                                                <li class="menu-item"><a class="color-red" onclick="delBox(<?php echo $v['id'] ?>)">删除</a></li>
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
        <div class="Tan" id="genjin">
            <div class="TanBox">
                <div class="TanBoxTit">添加用款分类 <span class="close OtPop"data-BoxId="genjin"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="genjin_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName"><span class="color-red">*</span> 类别</td>
                                <td>
                                    <select class="FrameGroupInput" id="type" name="type">
                                        <option value="用款申请">用款申请</option>
                                        <option value="报销申请">报销申请</option>
                                        <option value="收款登记">收款登记</option>
                                    </select>
                                </td>
                                <td class="FrameGroupName"><span class="color-red">*</span> 分类名称</td>
                                <td><input class="FrameGroupInput" type="text" id="name" name="name"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">编号</td>
                                <td><input class="FrameGroupInput" type="text" id="number" name="number"/></td>
                                <td class="FrameGroupName">排序</td>
                                <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="genjin" onclick="do_genjin()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="genjin">取消</span>
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
<script type="text/javascript">
                                $('.follow').click(function() {
                                    $('#eid').val($(this).attr('itemid'));
                                    $('input[name="explain"]').val('');
                                });
                                function delBox() {
                                    Confirm('确认删除？', function(e) {
                                        if (e) {
                                            $.post("<?php echo spUrl($c, "delCustomer"); ?>", $('#delFincate').serialize(), function(data) {
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
                                ;
                                
                            $(document).on('click', '.TablesAddBtn', function() {
                                $('#addResult .upBox-t h3').text('添加分类');
                                $('#eid').val('');
                                $('#type').val('');
                                $('#number').val('');
                                $('#name').val('');
                                $('#sort').val('');
                            });

                            $(document).on('click', '.follow', function() {
                                $('#addResult .upBox-t h3').text('修改分类');
                                var id = $(this).attr('itemid');
                                $('#eid').val(id);
                                $('#type').val($('.Result' + id + ' .data-type').attr('title'));
                                $('#number').val($('.Result' + id + ' .data-number').attr('title'));
                                $('#name').val($('.Result' + id + ' .data-name').attr('title'));
                                $('#sort').val($('.Result' + id + ' .data-sort').attr('title'));
                            });
                                function do_genjin() {
                                    $.ajax({
                                        cache: false,
                                        type: "POST",
                                        url: "<?php echo spUrl($c, "saveFincate"); ?>",
                                        data: $('#genjin_form').serialize(),
                                        dataType: "json",
                                        async: false,
                                        error: function(request) {
                                            Alert('提交失败');
                                        },
                                        success: function(data) {
                                            if (data.status == 1) {
                                                $('#addResult .close').click();
                                                window.location.reload();
                                            } else if (data.status == 2) {
                                                $('.Result' + data.data.id + ' .data-type').attr('title', data.data.type);
                                                $('.Result' + data.data.id + ' .data-type').text(data.data.type);
                                                $('.Result' + data.data.id + ' .data-number').attr('title', data.data.number);
                                                $('.Result' + data.data.id + ' .data-number').text(data.data.number);
                                                $('.Result' + data.data.id + ' .data-name').attr('title', data.data.name);
                                                $('.Result' + data.data.id + ' .data-name').text(data.data.name);
                                                $('.Result' + data.data.id + ' .data-sort').attr('title', data.data.sort);
                                                $('.Result' + data.data.id + ' .data-sort').text(data.data.sort);
                                                $('#addResult .close').click();
                                            } else {
                                                Alert(data.msg);
                                            }

                                        }
                                    });
                                }

</script>

