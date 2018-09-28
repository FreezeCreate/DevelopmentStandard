<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo $page_con['oid']==0?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>0))?>">生产管理</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['oid']==1?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>1))?>">销售管理</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['oid']==2?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>2))?>">仓库管理</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['oid']==3?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>3))?>">财务管理</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['oid']==4?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>4))?>">售后服务</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['oid']==5?'active':''?>"><a href="<?php echo spUrl($c,$a,array('oid'=>5))?>">企业办公</a></li>
                    </ul>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <div class="Btn Btn-blue float-right addMenu " data-bind="addMenu" >＋添加菜单</div>
                </div>
                <?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="top20">
                        <table class="Table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">ID</th>
                                    <th>菜单名称</th>
                                    <th>控制器</th>
                                    <th>方法</th>
                                    <th>PID</th>
                                    <th>图标标识</th>
                                    <th>排序</th>
                                    <th style="width: 150px;">操作</th>
                                </tr>
                            </thead>
                            <tbody class="textCenter TabBg">
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Menu<?php echo $v['id'] ?>">
                                        <td class="data-id" title="<?php echo $v['id'] ?>"><?php echo $v['id'] ?></td>
                                        <td style="text-align:left;" class="data-title" title="<?php echo $v['title'] ?>"><?php echo $v['title'] ?></td>
                                        <td class="data-control" title="<?php echo $v['control'] ?>"><?php echo $v['control'] ?></td>
                                        <td class="data-way" title="<?php echo $v['way'] ?>"><?php echo $v['way'] ?></td>
                                        <td class="data-pid" title="<?php echo $v['pid'] ?>"><?php echo $v['pid'] ?></td>
                                        <td class="data-img" title="<?php echo $v['img'] ?>"><?php echo $v['img']; ?></td>
                                        <td class="data-sort" title="<?php echo $v['sort'] ?>"><?php echo $v['sort'] ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                                操作  ＋
                                                <ul class="menu">
                                                    <li class="menu-item">
                                                        <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v['id'] ?>" data-bind="addMenu">编辑</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a class="btn btn-red del-t" itemid="<?php echo $v['id'] ?>">删除</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php foreach ($v['children'] as $k1 => $v1) { ?>
                                        <tr class="Menu<?php echo $v1['id'] ?>">
                                            <td class="data-id" title="<?php echo $v1['id'] ?>"><?php echo $v1['id'] ?></td>
                                            <td style="text-align:left;" class="data-title" title="<?php echo $v1['title'] ?>"> &nbsp;&nbsp;&nbsp;&nbsp;𠃊 <?php echo $v1['title'] ?></td>
                                            <td class="data-control" title="<?php echo $v1['control'] ?>"><?php echo $v1['control'] ?></td>
                                            <td class="data-way" title="<?php echo $v1['way'] ?>"><?php echo $v1['way'] ?></td>
                                            <td class="data-pid" title="<?php echo $v1['pid'] ?>"><?php echo $v1['pid'] ?></td>
                                            <td class="data-branch" title="<?php echo $v1['branch'] ?>"><?php echo $v['branch'] == 1 ? '<a class="btn btn-blue"><i class="icon-yes"> </i> </a>' : '<a class="btn btn-red"> <i class="icon-del"></i> </a>' ?></td>
                                            <td class="data-sort" title="<?php echo $v1['sort'] ?>"><?php echo $v1['sort'] ?></td>
                                            <td class="colorGre">
                                                <div class="list-menu" style="display: inline-block;">
                                                    操作  ＋
                                                    <ul class="menu">
                                                        <li class="menu-item">
                                                            <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v1['id'] ?>" data-bind="addMenu">编辑</a>
                                                        </li>
                                                        <li class="menu-item">
                                                            <a class="btn btn-red del-t" itemid="<?php echo $v1['id'] ?>">删除</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php foreach ($v1['children'] as $k2 => $v2) { ?>
                                            <tr class="Menu<?php echo $v2['id'] ?>">
                                                <td class="data-id" title="<?php echo $v2['id'] ?>"><?php echo $v2['id'] ?></td>
                                                <td style="text-align:left;" class="data-title" title="<?php echo $v2['title'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;𠃊 <?php echo $v2['title'] ?></td>
                                                <td class="data-control" title="<?php echo $v2['control'] ?>"><?php echo $v2['control'] ?></td>
                                                <td class="data-way" title="<?php echo $v2['way'] ?>"><?php echo $v2['way'] ?></td>
                                                <td class="data-pid" title="<?php echo $v2['pid'] ?>"><?php echo $v2['pid'] ?></td>
                                                <td class="data-branch" title="<?php echo $v2['branch'] ?>"><?php echo $v['branch'] == 1 ? '<a class="btn btn-blue"><i class="icon-yes"> </i> </a>' : '<a class="btn btn-red"> <i class="icon-del"></i> </a>' ?></td>
                                                <td class="data-sort" title="<?php echo $v2['sort'] ?>"><?php echo $v2['sort'] ?></td>
                                                <td class="colorGre">
                                                    <div class="list-menu" style="display: inline-block;">
                                                        操作  ＋
                                                        <ul class="menu">
                                                            <li class="menu-item">
                                                                <a class="btn btn-blue edit-t get-upBox" itemid="<?php echo $v2['id'] ?>" data-bind="addMenu">编辑</a>
                                                            </li>
                                                            <li class="menu-item">
                                                                <a class="btn btn-red del-t" itemid="<?php echo $v2['id'] ?>">删除</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php require_once TPL_DIR . '/layout/page.php'; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!--
        作者：895635200@qq.com
        时间：2017-08-11
        描述：添加材料弹出框start
        -->
        <div class="Person">
            <div class="upBox add PersonBox" id="addMenu" style="width:auto;">
                <div class="upBox-t">
                    <div class="PersonTit"><a style="color:#ffffff;">添加菜单</a><span class="close"></span></div>
                </div>
                <div class="upBox-c">
                    <form id="addMenu_form" method="post" action="" onsubmit="return false;">
                        <input type="hidden" id="Mid" name="id" value=""/>
                        <table class="table table-add FrameTableCont">
                            <tbody>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 菜单名称</td>
                                    <td><input class="FrameGroupInput" type="text" id="title" name="title"/></td>
                                    <td class="FrameGroupName">PID</td>
                                    <td><input class="FrameGroupInput" type="text" id="pid" name="pid" placeholder="0为顶级，不填则默认为0"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">控制器</td>
                                    <td><input class="FrameGroupInput" type="text" id="control" name="control"/></td>
                                    <td class="FrameGroupName">方法</td>
                                    <td><input class="FrameGroupInput" type="text" id="way" name="way"/></td>
                                </tr>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">图标标识</td>
                                    <td><input class="FrameGroupInput" type="text" id="img" name="img"/></td>
                                    <td class="FrameGroupName"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">排序</td>
                                    <td><input class="FrameGroupInput" type="text" id="sort" name="sort"/></td>
                                    <td class="FrameGroupName">模块</td>
                                    <td><select class="FrameGroupInput" name="oid">
                                            <option <?php echo $page_con['oid']==1?'selected=""':''?> value="1">销售管理</option>
                                            <option <?php echo $page_con['oid']==2?'selected=""':''?> value="2">仓库管理</option>
                                            <option <?php echo $page_con['oid']==3?'selected=""':''?> value="3">财务管理</option>
                                            <option <?php echo $page_con['oid']==4?'selected=""':''?> value="4">售后服务</option>
                                            <option <?php echo $page_con['oid']==5?'selected=""':''?> value="5">企业办公</option>
                                        </select></td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </form>
                    <div class="PersonFoot">
                        <span class="Btn Big"><a class="btn-sm btn-blue" onclick="do_addMenu()">确认</a></span>
                    </div>
                </div>
            </div>
        </div>
        <!--
        作者：895635200@qq.com
        时间：2017-08-11
        描述：添加材料弹出框end
        -->

        <!--
        作者：895635200@qq.com
        时间：2017-08-11
        描述：主内容区域end
        -->

    </body>

</html>

<script>

    function do_addMenu() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveMenu"); ?>",
            data: $('#addMenu_form').serialize(),
            dataType: "json",
            async: false,
            error: function (request) {
            },
            success: function (data) {
                if (data.status == 1) {
                    $('#addMenu .close').click();
                    window.location.reload();
                } else if (data.status == 2) {
                    $('.Menu' + data.data.id + ' .data-title').attr('title', data.data.title);
                    $('.Menu' + data.data.id + ' .data-title').text(data.data.title);
                    $('.Menu' + data.data.id + ' .data-control').attr('title', data.data.control);
                    $('.Menu' + data.data.id + ' .data-control').text(data.data.control);
                    $('.Menu' + data.data.id + ' .data-way').attr('title', data.data.way);
                    $('.Menu' + data.data.id + ' .data-way').text(data.data.way);
                    $('.Menu' + data.data.id + ' .data-pid').attr('title', data.data.pid);
                    $('.Menu' + data.data.id + ' .data-pid').text(data.data.pid);
                    $('.Menu' + data.data.id + ' .data-img').attr('title', data.data.img);
                    $('.Menu' + data.data.id + ' .data-img').text(data.data.img);
                    $('.Menu' + data.data.id + ' .data-sort').attr('title', data.data.sort);
                    $('.Menu' + data.data.id + ' .data-sort').text(data.data.sort);
                    $('#addMenu .close').click();
                } else {
                    alert(data.msg);
                }

            }
        });
    }
    ;

    $(document).on('click', '.addMenu', function () {
        $('.Person').show()
        PersonInit();
        $('.PersonBox').animate({'top': 80}, 300);
        $('.PersonTit').children('a').text('添加菜单');
        $('#Mid').val('');
        $('#title').val('');
        $('#control').val('');
        $('#way').val('');
        $('#pid').val('');
        $('#img').val('');
        $('#sort').val('');
    });

    $(document).on('click', '.edit-t', function () {
        $('.Person').show()
        PersonInit();
        $('.PersonBox').animate({'top': 80}, 300);
        $('.PersonTit').children('a').text('修改菜单');
        var id = $(this).attr('itemid');
        $('#Mid').val(id);
        $('#title').val($('.Menu' + id + ' .data-title').attr('title'));
        $('#control').val($('.Menu' + id + ' .data-control').attr('title'));
        $('#way').val($('.Menu' + id + ' .data-way').attr('title'));
        $('#img').val($('.Menu' + id + ' .data-img').attr('title'));
        $('#pid').val($('.Menu' + id + ' .data-pid').attr('title'));
        $('#sort').val($('.Menu' + id + ' .data-sort').attr('title'));
    });


    $(document).on('click', '.del-t', function () {
        if (confirm("确认删除？")) {
            var id = $(this).attr('itemid');
            $.get("<?php echo spUrl($c, "delMenu"); ?>", {id: id}, function (data) {
                if (data.status == 1) {
                    $('.Menu' + id).remove();
                } else {
                    alert(data.msg);
                }
            }, "json");
        }
    });
    $('.close').click(function () {
        $('.PersonBox').animate({'top': '-500px'}, 300, function () {
            $('.Person').hide()
        })
    })

</script>
