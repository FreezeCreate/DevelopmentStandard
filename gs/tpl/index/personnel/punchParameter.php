<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>考勤参数</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <style>
            .dep td { line-height: 30px; background: #83b266 !important; border-left: 0 !important; border-right: 0 !important; color: #fff !important; cursor: pointer;}
            .deps { display: none;}
        </style>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <input type="text" class="TablesSerchInput" name="name" value="<?php echo $page_con['name'] ?>" placeholder="申请人"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn" onclick="fill_apply(15)">＋ 新增</div>
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
                                    <td>名称</td>
                                    <td>开始时间</td>
                                    <td>结束时间</td>
                                    <td>取值类型</td>
                                    <td>排序</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr data-id="<?php echo $v['id']?>" class="Menu dep">
                                        <td></td>
                                        <td style="text-align:left;" title="<?php echo $v['name'] ?>"><?php echo $v['name'] ?> ∨</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php foreach($v['kqsjgz'] as $k1=>$v1){?>
                                    <tr class="Menu<?php echo $v1['id'] ?> deps dep<?php echo $v['id']?>">
                                        <td class="data-id" title="<?php echo $v1['id'] ?>"><?php echo $v1['id'] ?></td>
                                        <td style="text-align:left;" class="data-name" title="<?php echo $v1['name'] ?>"><?php echo $v1['name'] ?></td>
                                        <td class="data-stime" title="<?php echo $v1['stime'] ?>"><?php echo $v1['stime'] ?></td>
                                        <td class="data-etime" title="<?php echo $v1['etime'] ?>"><?php echo $v1['etime'] ?></td>
                                        <td class="data-qtype" title="<?php echo $v1['qtype'] ?>"><?php echo $v1['qtype'] == 1 ? '<a class="color-green">最大值 </a>' : '<a class="color-pary">最小值</a>' ?></td>
                                        <td class="data-sort" title="<?php echo $v1['sort'] ?>"><?php echo $v1['sort'] ?></td>
                                        <td style="text-align:left;">
                                            <a class="Btn Btn-info edit-t InPop" itemid="<?php echo $v1['id'] ?>" data-BoxId="addMenu"><i class="icon-edit"></i> 编辑</a>
                                        </td>
                                    </tr>
                                    <?php foreach ($v1['children'] as $k2 => $v2) { ?>
                                        <tr class="Menu<?php echo $v2['id'] ?> deps dep<?php echo $v['id']?>">
                                            <td class="data-id" title="<?php echo $v2['id'] ?>"><?php echo $v2['id'] ?></td>
                                            <td style="text-align:left;" class="data-name" title="<?php echo $v2['name'] ?>"> &nbsp;&nbsp;&nbsp;&nbsp;𠃊 <?php echo $v2['name'] ?></td>
                                            <td class="data-stime" title="<?php echo $v2['stime'] ?>"><?php echo $v2['stime'] ?></td>
                                            <td class="data-etime" title="<?php echo $v2['etime'] ?>"><?php echo $v2['etime'] ?></td>
                                            <td class="data-qtype" title="<?php echo $v2['qtype'] ?>"><?php echo $v2['qtype'] == 1 ? '<a class="color-green">最大值 </a>' : '<a class="color-pary">最小值</a>' ?></td>
                                            <td class="data-sort" title="<?php echo $v2['sort'] ?>"><?php echo $v2['sort'] ?></td>
                                            <td style="text-align:left;">
                                                <a class="Btn Btn-info edit-t InPop" itemid="<?php echo $v2['id'] ?>" data-BoxId="addMenu"><i class="icon-edit"></i> 编辑</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <div class="Tan" id="addMenu">
            <div class="TanBox">
                <div class="TanBoxTit">编辑 <span class="close OtPop" data-BoxId="addMenu"></span></div>
                <div class="TanBoxCont">
                    <form action="" method="" id="addMenu_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 名称</td>
                                <td><input class="FrameGroupInput" type="text" id="name" name="name"/></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">开始时间</td>
                                <td><input class="FrameGroupInput" type="text" id="stime" name="stime"/></td>
                                <td class="FrameGroupName">结束时间</td>
                                <td><input class="FrameGroupInput" type="text" id="etime" name="etime"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">排序</td>
                                <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                                <td class="FrameGroupName">取值类型</td>
                                <td><select class="FrameGroupInput" id="qtype" name="qtype">
                                        <option value="0">最小值</option>
                                        <option value="1">最大值</option>
                                    </select></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big InPop" data-BoxId="addMenu" onclick="do_addMenu()">确定</span>
                            <span class="Btn Big Blue OtPop"data-BoxId="addMenu">取消</span>
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
    
    $('.dep').click(function(){
        var id = $(this).attr('data-id');
        $('.dep'+id).toggle();
    });
    
    function do_addMenu() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "savepunch"); ?>",
            data: $('#addMenu_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
            },
            success: function(data) {
                if (data.status == 1) {
                    $('.Menu' + data.data.id + ' .data-stime').attr('title', data.data.stime);
                    $('.Menu' + data.data.id + ' .data-stime').text(data.data.stime);
                    $('.Menu' + data.data.id + ' .data-etime').attr('title', data.data.etime);
                    $('.Menu' + data.data.id + ' .data-etime').text(data.data.etime);
                    $('#addMenu .close').click();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
    ;
    $(document).on('click', '.addMenu', function() {
        $('#addMenu .upBox-t h3').text('添加');
        $('#Mid').val('');
        $('#name').val('');
        $('#stime').val('');
        $('#etime').val('');
        $('#qtype').val('');
        $('#sort').val('');
    });
    $(document).on('click', '.edit-t', function() {
        $('#addMenu .upBox-t h3').text('编辑');
        var id = $(this).attr('itemid');
        $('#Mid').val(id);
        $('#name').val($('.Menu' + id + ' .data-name').attr('title'));
        $('#stime').val($('.Menu' + id + ' .data-stime').attr('title'));
        $('#etime').val($('.Menu' + id + ' .data-etime').attr('title'));
        $('#qtype').val($('.Menu' + id + ' .data-qtype').attr('title'));
        $('#sort').val($('.Menu' + id + ' .data-sort').attr('title'));
    });
</script>

