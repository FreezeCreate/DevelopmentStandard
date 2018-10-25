<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
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
<style type="text/css">
	.colorItem{display: inline-block;vertical-align: middle;height: 60px;width: 20px;margin-right: 10px;border: 2px solid #fff;}
	.colorItem.active{border-color: red;}
	.blue{background: linear-gradient(#81b1dd, #0d5781);}
	.gree{background: linear-gradient(#70a672, #45864b);}
</style>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">

                <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                <span class="Btn Btn-blue float-right InPop" data-BoxId="demp"><i class="icon-add"></i> 增加部门</span>
                <?php if($admin['id']==1){?>
                <span class="Btn Btn-blue float-right InPop" data-BoxId="company"><i class="icon-add"></i> 增加公司</span>
                <?php }?>
            </div>
            <div class="top20"style="font-size: 0;">
                <div class="Menu">
                    <div class="MenuTit">公司机构</div>
                    <div class="MenuItems">
                        <?php if($admin['id']==1){?>
                        <div class="MenuFirst">成都冠晟平台</div>
                        <?php }?>
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
                                <td></td><td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 公司LOGO</td>
                                <td style="background:#f0f0f0;">
                                    <img class="userhead" style="width:100px; height: 100px;" onclick="$('#fileToUpload').click();" src="<?php echo SOURCE_PATH;?>/images/logo.png">
	                                <input class="None upfile" type="file" name="fileToUpload" id="fileToUpload" value="" onchange="ajaxFileUpload()">
                                        <input type="hidden" name="logo" id="logo" value="<?php echo SOURCE_PATH;?>/images/logo.png"/>
                            	</td>
                            	<td class="FrameGroupName">主体颜色</td>
                                <td class="colors">
                                    <div class="colorItem blue active"onclick="$('#blue').click()"></div>
                                    <input type="radio" class="None" name="colors" checked="checked" id="blue" value="#81b1dd" />
                                    <div class="colorItem gree"onclick="$('#gree').click()"></div>
                                    <input type="radio" class="None" name="colors" id="gree" value="#45864b" />
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">电话</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value=""/></td>
                                <td class="FrameGroupName">邮箱</td>
                                <td><input class="FrameGroupInput" type="text" name="email" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">传真</td>
                                <td><input class="FrameGroupInput" type="text" name="fax" value=""/></td>
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
                                    <input class="FrameGroupInput uname" style="width: 105px;" type="text" name="uname" placeholder="" value="<?php echo $result['uname'] ?>"/>
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
        $.get('<?php echo spUrl('basic', 'finddemp') ?>', {type: type, id: id}, function(re) {
            $.each(re.data, function(i, v) {
                $('#' + type + ' input[name="' + i + '"]').val(v);
            });
            $('#fileToUpload').parent('td').children('img').attr('src',re.data.logo);
            $('#fileToUpload').parent('td').children('#login').val(re.data.logo);
        }, 'json');
    }

    function del(type, id) {
        Confirm('确定删除该机构及其下所有员工信息？删除后不可恢复！', function(e) {
            if (e) {
                $.get('<?php echo spUrl('basic', 'deldemp') ?>', {type: type, id: id}, function(re) {
                    $('.Results'+id).remove();
                }, 'json');
            }
        })

    }
    
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "upload"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            success: function(data, status) {
                if (data.status == 1) {
                    var src = '/tmp/'+data.src;
                    $('#fileToUpload').parent('td').children('img').attr('src', src);
                    $('#fileToUpload').parent('td').children('#logo').val(src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }

    function do_company() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('basic', "saveCompany"); ?>",
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
            url: "<?php echo spUrl('basic', "saveDemp"); ?>",
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
    $('.colorItem').click(function(){
    	$('.colorItem').removeClass('active')
    	$(this).addClass('active')
    })
</script>
</html>
