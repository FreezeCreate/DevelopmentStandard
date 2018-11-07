<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var Use;
//        var Pos;
//        var Dep;
    $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
        Use = {}
        Use.status = 2;
        Use.data = data.data[0].children;
    }, 'json');
    //职位
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
    //部门
//            $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');
</script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">

                <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                <span class="Btn Btn-blue float-right InPop" data-BoxId="demp"><i class="icon-add"></i> 新增部门</span>
                <span class="Btn Btn-blue float-right InPop" data-BoxId="company"><i class="icon-add"></i> 新增分公司</span>
            </div>
            <div class="top20"style="font-size: 0;">
                <div class="Menu">
                    <div class="MenuTit">公司机构</div>
                    <div class="MenuItems">
                        <div class="MenuFirst">成都冠晟平台</div>
                        <?php foreach ($results as $v) { ?>
                            <div data-id="<?php echo $v['id'] ?>" class="MenuSecond"><?php echo $v['name'] ?></div>
                            <?php foreach ($v['children'] as $v1) { ?>
                                <div data-id="<?php echo $v1['id'] ?>" class="ItemTherrd"><?php echo $v1['name'] ?></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="MenuCont">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>名称</th>
                                <th>职位</th>
                                <th>电话</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id']?>">
                                    <td><?php echo $v['name'] ?></td>
                                    <td></td>
                                    <td><?php echo $v['phone'] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item InPop" data-BoxId="company" onclick="edit('company',<?php echo $v['id'] ?>)"><a >编辑</a></li>
                                                <li class="menu-item read" onclick="del('company',<?php echo $v['id'] ?>)"><a >删除</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="Tan" id="company">
        <div class="TanBox">
            <div class="TanBoxTit">公司信息 <span class="close OtPop" data-BoxId="company"></span></div>
            <div class="TanBoxCont">
                <form action="" method="" id="company_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 公司名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value=""/></td>
                                <td class="FrameGroupName">电话</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">邮箱</td>
                                <td><input class="FrameGroupInput" type="text" name="email" value=""/></td>
                                <td class="FrameGroupName">传真</td>
                                <td><input class="FrameGroupInput" type="text" name="fax" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><input class="FrameGroupInput" type="text" name="explain" value=""/></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big Btn-green" onclick="do_company()">确定</span>
                            <span class="Btn Big Btn-blue OtPop"data-BoxId="company">取消</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="Tan" id="demp">
        <div class="TanBox">
            <div class="TanBoxTit">部门 <span class="close OtPop" data-BoxId="demp"></span></div>
            <div class="TanBoxCont">
                <form action="" method="" id="demp_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">部门名称</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value=""/></td>
                                <td class="FrameGroupName">电话</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">传真</td>
                                <td><input class="FrameGroupInput" type="text" name="fax" value=""/></td>
                                <td class="FrameGroupName"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">所属公司</td>
                                <td>
                                    <select class="FrameGroupInput" name="pid">
                                        <?php foreach ($results as $k => $v) { ?>
                                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="FrameGroupName">部门负责人</td>
                                <td>
                                    <input class="FrameGroupInput uname" style="width: 110px;" type="text" name="uname" placeholder="" value="<?php echo $result['uname'] ?>"/>
                                    <input type="hidden" class="uid" name="uid" value="<?php echo $result['uid'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><input class="FrameGroupInput" type="text" name="explain" value=""/></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="eid" type="hidden" name="id" value=""/>
                            <span class="Btn Big Btn-green" onclick="do_demp()">确定</span>
                            <span class="Btn Big Btn-blue OtPop"data-BoxId="demp">取消</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).on('click', '.MenuFirst', function() {
        $id = $(this).attr('data-id');
        $('.MenuItems div').removeClass('active');
        $(this).addClass('active');
        $.get('<?php echo spUrl('main', 'findCompany') ?>', {id: $id}, function(re) {
            $txt = '';
            $.each(re.data, function(i, v) {
                $txt += '<tr class="Results' + v.id + '"><td>' + v.name + '</td><td></td><td>' + v.phone + '</td><td>'
                        + '<div class="list-menu" style="display: inline-block;"> 操作  ＋'
                        + '<ul class="menu"><li class="menu-item InPop" data-BoxId="company" onclick="edit(\'company\',' + v.id + ')"><a >编辑</a></li>'
                        + '<li class="menu-item read" onclick="del(\'company\',' + v.id + ')"><a >删除</a></li></ul></div></td></tr>';
            });
            $('.textCenter').html($txt);
        }, 'json');
    });
    $(document).on('click', '.MenuSecond', function() {
        $id = $(this).attr('data-id');
        $('.MenuItems div').removeClass('active');
        $(this).addClass('active');
        $.get('<?php echo spUrl('main', 'findDepartment') ?>', {id: $id}, function(re) {
            $txt = '';
            $.each(re.data, function(i, v) {
                $txt += '<tr class="Results' + v.id + '"><td>' + v.name + '</td><td></td><td>' + v.phone + '</td><td>'
                        + '<div class="list-menu" style="display: inline-block;"> 操作  ＋'
                        + '<ul class="menu"><li class="menu-item InPop" data-BoxId="demp" onclick="edit(\'demp\',' + v.id + ')"><a >编辑</a></li>'
                        + '<li class="menu-item read" onclick="del(\'demp\',' + v.id + ')"><a >删除</a></li></ul></div></td></tr>';
            });
            $('.textCenter').html($txt);
        }, 'json');
    });
    $(document).on('click', '.ItemTherrd', function() {
        $id = $(this).attr('data-id');
        $('.MenuItems div').removeClass('active');
        $(this).addClass('active');
        $.get('<?php echo spUrl('main', 'findPonsenel') ?>', {id: $id}, function(re) {
            $txt = '';
            $.each(re.data, function(i, v) {
                $txt += '<tr><td>' + v.name + '</td><td>' + v.pname + '</td><td>' + v.phone + '</td><td></td></tr>';
            });
            $('.textCenter').html($txt);
        }, 'json');
    });

    function edit(type, id) {
        $.get('<?php echo spUrl('auth', 'finddemp') ?>', {type: type, id: id}, function(re) {
            $.each(re.data, function(i, v) {
                $('#' + type + ' input[name="' + i + '"]').val(v);
            });
        }, 'json');
    }

    function del(type, id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl('auth', 'deldemp') ?>', {type: type, id: id}, function(re) {
                    $('.Results'+id).remove();
                }, 'json');
            }
        })

    }

    function do_company() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('auth', "saveCompany"); ?>",
            data: $('#company_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    window.location.reload();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
    function do_demp() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('auth', "saveDemp"); ?>",
            data: $('#demp_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    Alert(data.msg, function() {
                        $('#demp .close').click();
                    });
                    window.location.reload();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>
</html>
