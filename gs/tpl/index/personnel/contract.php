<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>员工合同</title>
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
                            <select class="TablesSerchInput" name="status">
                                <option value="0">合同状态</option>
                                <?php foreach ($GLOBALS['CONTRACT_STATUS'] as $k => $v) { ?>
                                    <option <?php echo $page_con['status'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                <?php } ?>
                            </select>
                            <?php if($admin['shopid']==1){?>
                            <select class="TablesSerchInput" name="cid">
                                <option value="0">签署单位</option>
                                <?php foreach ($company as $k => $v) { ?>
                                    <option <?php echo $page_con['cid'] == $v['id'] ? 'selected=""' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['shopname'] ?></option>
                                <?php } ?>
                            </select>
                            <?php }?>
                            <input class="TablesSerchInput" type="text" name="name" placeholder="合同名称" value="<?php echo $page_con['name'] ?>"/>
                            <input class="TablesSerchInput" name="uname" type="text"  placeholder="签署人" value="<?php echo $page_con['uname'] ?>"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <div class="TablesAddBtn">＋ 新增合同</div>
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
                                    <td>签署人</td>
                                    <td>合同名称</td>
                                    <td>签署单位</td>
                                    <td>合同类型</td>
                                    <td>人员状态</td>
                                    <td>开始日期</td>
                                    <td>截止日期</td>
                                    <td>状态</td>
                                    <td>提前终止日期</td>
                                    <td>说明</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Contract<?php echo $v['id'] ?>">
                                        <td class="data-uname" title="<?php echo $v['uname'] ?>"><?php echo $v['uname'] ?></td>
                                        <td class="data-name" title="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></td>
                                        <td class="data-company" title="<?php echo $v['company'] ?>"><?php echo $v['company'] ?></td>
                                        <td class="data-type" title="<?php echo $v['type'] ?>"><?php echo $v['type'] ?></td>
                                        <td class="data-start" title="<?php echo $v['start'] ?>"><?php echo $v['start'] ?></td>
                                        <td class="data-end" title="<?php echo $v['end'] ?>"><?php echo $v['end'] ?></td>
                                        <td class="data-status" title="<?php echo $v['status'] ?>"><?php echo $v['status'] == 3 ? '<a style="color:red;">'.$GLOBALS['CONTRACT_STATUS'][$v['status']].' </a>' : '<a style="color:green;"> '.$GLOBALS['CONTRACT_STATUS'][$v['status']].' </a>' ?></td>
                                        <td class="data-closure" title="<?php echo $v['closure'] ?>"><?php echo $v['closure'] ?></td>
                                        <td class="data-explains" title="<?php echo $v['explains'] ?>"><?php echo $v['explains'] ?></td>
                                        <td>
                                            <a class="Btn Btn-primary edit-t get-upBox" itemid="<?php echo $v['id'] ?>" data-bind="addContract"><i class="icon-edit"></i> 编辑</a>
                                            <a class="Btn Btn-danger del-t" itemid="<?php echo $v['id'] ?>"><i class="icon-del"></i> 删除</a>
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

    $(document).on('change', '.fileToUpload', function() {
        var name = $(this).attr('name');
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
            secureuri: false,
            fileElementId: name,
            dataType: 'json',
            data: {name: name, id: name},
            error: function(data, status, e) {
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    var txt = '<div class="download"><a class="download-a" href="javascript:void(0)" itemid="' + data.data.id + '">' + data.data.filename + '</a><span class="del">删除</span></div>';
                    $('#' + name).val('');
                    $('#' + name).before(txt);
                } else {
                    $('#' + name).val('');
                    alert(data.msg);
                }
            },
        });
        return false;
    });

    $(document).on('click', '.download .del', function() {
        if (confirm("确认删除？")) {
            $(this).parent('.download').remove();
        }
    });

    function do_addContract() {
        var files = new Array();
        for (var i = 0; i < $('.download .download-a').length; i++) {
            files[i] = $('.download .download-a').eq(i).attr('itemid');
        }
        var status = <?php echo json_encode($GLOBALS['CONTRACT_STATUS']); ?>;
        $('#files').val(JSON.stringify(files));
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveContract"); ?>",
            data: $('#addContract_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    var txt = '';
                    txt += '<tr class="Contract' + data.data.id + '"><td class="data-uname" title="' + data.data.uname + '">' + data.data.uname + '</td><td class="data-name" title="' + data.data.name + '">' + data.data.name + '</td><td class="data-company" title="' + data.data.company + '">' + data.data.company + '</td><td class="data-type" title="' + data.data.type + '">' + data.data.type + '</td><td class="data-start" title="' + data.data.start + '">' + data.data.start + '</td><td class="data-end" title="' + data.data.end + '">' + data.data.end + '</td><td class="data-status" title="' + data.data.status + '">';
                    txt += data.data.status == 3?'<a style="color:red;">' + status[data.data.status] + ' </a>' : '<a style="color:green;"> ' + status[data.data.status] + ' </a>';                 
                    txt += '</td><td class="data-closure" title="' + data.data.closure + '">' + data.data.closure + '</td><td class="data-explains" title="' + data.data.explains + '">' + data.data.explains + '</td><td><a class="btn btn-blue edit-t get-upBox" itemid="' + data.data.id + '" data-bind="addContract"><i class="icon-edit"></i> 编辑</a><a class="btn btn-red del-t" itemid="' + data.data.id + '"><i class="icon-del"></i> 删除</a></td></tr>';
                    $('.content table.table-lst tbody').prepend(txt);
                    $('#addContract .close').click();
                } else if (data.status == 2) {
                    $('.Contract' + data.data.id + ' .data-uname').attr('title', data.data.uname);
                    $('.Contract' + data.data.id + ' .data-name').attr('title', data.data.name);
                    $('.Contract' + data.data.id + ' .data-name').text(data.data.name);
                    $('.Contract' + data.data.id + ' .data-company').attr('title', data.data.cid);
                    $('.Contract' + data.data.id + ' .data-company').text(data.data.company);
                    $('.Contract' + data.data.id + ' .data-type').attr('title', data.data.type);
                    $('.Contract' + data.data.id + ' .data-type').text(data.data.type);
                    $('.Contract' + data.data.id + ' .data-status').attr('title', data.data.status);
                    $('.Contract' + data.data.id + ' .data-status').html(data.data.status == 3?'<a style="color:red;">' + status[data.data.status] + ' </a>' : '<a style="color:green;"> ' + status[data.data.status] + ' </a>');
                    $('.Contract' + data.data.id + ' .data-closure').attr('title', data.data.closure);
                    $('.Contract' + data.data.id + ' .data-closure').text(data.data.closure);
                    $('.Contract' + data.data.id + ' .data-explains').attr('title', data.data.explains);
                    $('.Contract' + data.data.id + ' .data-explains').text(data.data.explains);
                    $('#addContract .close').click();
                } else {
                    alert(data.msg);
                }

            }
        });
    }
    ;

    $(document).on('click', '.edit-t', function() {
        $('#addContract .upBox-t h3').text('修改合同');
        var id = $(this).attr('itemid');
        $.get('<?php echo spUrl($c, 'editContract'); ?>', {id: id}, function(data) {
            if (data.status == 1) {
                $('#Mid').val(id);
                $('#uid').val(data.data.uid);
                $('#uname').val(data.data.uname);
                $('#name').val(data.data.name);
                $('#cid').val(data.data.cid);
                $('#type').val(data.data.type);
                $('#start').val(data.data.start);
                $('#end').val(data.data.end);
                $('#closure').val(data.data.closure);
                $('#explains').val(data.data.explains);
                $('#files').val(data.data.files);
                $('#fileToUpload1').prevAll('.download').remove();
                for(var i=0;i<data.data.filesname.length;i++){
                    $('#fileToUpload1').before('<div class="download"><a class="download-a" href="javascript:void(0)" itemid="' + data.data.filesname[i].id + '">' + data.data.filesname[i].filename + '</a><span class="del">删除</span></div>');
                }
            } else {
                alert(data.msg);
            }
        }, 'json');

    });
    
    $(document).on('click', '.addContract', function() {
        $('#addContract .upBox-t h3').text('添加合同');
        $('#Mid').val('');
        $('#uid').val('');
        $('#uname').val('');
        $('#name').val('');
        $('#cid').val('');
        $('#type').val('');
        $('#start').val('');
        $('#end').val('');
        $('#closure').val('');
        $('#explains').val('');
        $('#files').val('');
        $('#fileToUpload1').prevAll('.download').remove();
    });

    $(document).on('click', '#uname', function() {
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
            }
        }, 'json');
    });

    $(document).on('click', '#Users .upBox-cc .all-li li ul li ul li a', function() {
        $('#Users .upBox-cc ul li a').removeClass('active');
        $(this).addClass('active');
    });
    $(document).on('click', '#Users .upBox-cc .th-li li a', function() {
        $('#Users .upBox-cc ul li a').removeClass('active');
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


    $(document).on('click', '.del-t', function() {
        if (confirm("确认删除？")) {
            var id = $(this).attr('itemid');
            $.get("<?php echo spUrl($c, "delContract"); ?>", {id: id}, function(data) {
                if (data.status == 1) {
                    $('.Contract' + id).remove();
                } else {
                    alert(data.msg);
                }
            }, "json");
        }
    });

    function getUser() {
        var id = $('#Users .upBox-cc ul li a.active').attr('lang');
        var name = $('#Users .upBox-cc ul li a.active').attr('title');
        $('#uid').val(id);
        $('#uname').val(name);
        $('.close01').click();
    }

</script>
