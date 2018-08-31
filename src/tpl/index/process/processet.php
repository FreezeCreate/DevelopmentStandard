
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<style type="text/css">
    #Position.Person .PersonListName {
        background: #fff;
    }
    .table .btn-danger{margin-left: 10px;}
</style>
</head>
<body>
    <div class="MainHtml">
        <div class="lcmkCont">
            <div class="content clearfix">
                <div class="group-div width-3 lcmkLeft">
                    <div class="tit01 lcmkTit">流程模块(双击显示步骤)</div>
                    <div id="lih" class="TablesBody">
                        <div class="lcmkLeftScroll">
                            <table class="table table-striped table-hover textCenter">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>名称</th>
                                        <th>编号</th>
                                        <th>类型</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $k => $v) { ?>
                                        <tr class="doubleclick" itemid="<?php echo $v['id'] ?>">
                                            <td><?php echo $v['id'] ?></td>
                                            <td><?php echo $v['name'] ?></td>
                                            <td><?php echo $v['table'] ?></td>
                                            <td><?php echo $GLOBALS['PRO_TYPE'][$v['type']]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="group-div width-6 lcmkRight" id="setcourse">
                    <div class="lcmkRightPd">
                        <div class="lcmkRtit">
                            <div class="tit02">
                                <div class="tool">
                                    <button class="btn btn-grey pdX20 float-right but nother" data-url="<?php echo spUrl('process', 'procealert') ?>"data-title="编辑流程" id="add">新增下级</button>
                                </div>
                                <span>设置流程</span>
                            </div>
                        </div>
                        <div class="clear" style="height: 10px;"></div>
                        <div class="TablesBody">
                            <div class="lcmkRightScroll">
                                <table class="table table-striped  table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>名称</th>
                                            <th>审核人类型</th>
                                            <th>审核人</th>
                                            <th style="width: 120px;">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody class="course textCenter">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(function() {

        $('.lcmkCont').height($(window).height() - 40)
        $('.lcmkCont').width($(window).width() - 40)
        $('.lcmkLeftScroll').height($('.lcmkCont').height() - $('.lcmkTit')[0].offsetHeight)
        $('.lcmkRightScroll').height($('.lcmkCont').height() - $('.lcmkRtit')[0].offsetHeight - 2)
//			$.get('http://csoa.sem98.com/main/getPosition', {}, function(data) {
//				Pos = data
//			}, 'json');
//			$.get('http://csoa.sem98.com/main/getUsers', {
//				id: 5
//			}, function(data) {
//				Use = {}
//				Use.status = 2;
//				Use.data = data.data[0].children;
//			}, 'json');
        $(document).on({
            dblclick: function() {
                var id = $(this).attr('itemid');
                $('.table .doubleclick').removeClass('active');
                $(this).addClass('active');
                $.get("<?php echo spUrl($c, "getCourse"); ?>", {
                    id: id
                }, function(data) {
                    if (data.status == 1) {
                        var coursetype = <?php echo json_encode($GLOBALS['COURSE_TYPE']); ?>;
                        var course = new Array();
                        course.push('<tr class="Course0" itemid="' + id + '" level="0"><td class="data-id" dir="0">0</td><td class="data-name text-left0"style="text-align: left;padding-left:' + 0 + 'px;" dir="提交">提交</td><td class="data-checktype" dir=""></td><td class="data-checktypename" dir=""></td><td></td></tr>');
                        $.each(data.data, function(i, v) {
                            course.push('<tr class="Course' + v.id + '" itemid="' + id + '" level="' + v.level + '"><td class="data-id" dir="' + v.id + '">' + v.id + '</td><td style="text-align: left;padding-left:' + v.level * 14 + 'px;"class="data-name text-left' + v.level + '" dir="' + v.name + '">' + v.name + '</td><td class="data-checktype" dir="' + v.checktype + '">' + coursetype[v.checktype] + '</td><td class="data-checktypename" data-id="' + v.checktypeid + '" dir="' + v.checktypename + '">' + v.checktypename + '</td><td class="hidden None data-courseact" dir="' + v.courseact + '">' + v.courseact + '</td><td><button class="btn btn-default btn-sm edit-t NewPop" itemid="' + v.id + '" data-url="<?php echo spUrl('process', 'procealert') ?>"data-title="编辑流程">编辑</button></td></tr>');
                        });
                        $('#setcourse .tit02 span').html('设置【' + data.url + '】的流程');
                        $('#setcourse table tbody.course').html(course);
                        nobtn();
                    } else {
                        Alert(data.msg);
                    }
                }, "json");
                $('#setcourse table tbody.course').html('<tr class="Course0" itemid="1" level="0"><td class="data-id" dir="0">0</td><td class="data-name text-left0"style="text-align: left;padding-left:' + 0 + 'px;" dir="提交">提交</td><td class="data-checktype" dir=""></td><td class="data-checktypename" dir=""></td><td></td></tr>');
            }
        }, '.doubleclick');

        function nobtn() {
            if ($('.course tr.active').length == 1) {
                $('#add').addClass('get-upBox');
                $('#add').addClass('btn-success');
                $('#add').removeClass('nother');
                $('#add').removeClass('btn-gray');
                $('#add').addClass('NewPop');
            } else {
                $('#add').addClass('btn-gray');
                $('#add').removeClass('get-upBox');
                $('#add').removeClass('NewPop');
                $('#add').removeClass('btn-success');
                $('#add').addClass('nother');
            }
        }
        $(document).on('click', '.course tr', function() {
            $('.course tr').removeClass('active');
            $(this).addClass('active');
            nobtn();
        });

        $(document).on('click', '.edit-t', function() {
            var id = $(this).attr('itemid');
            var name = $('.Course' + id + ' .data-name').attr('dir');
            var type = $('.Course' + id + ' .data-checktype').attr('dir');
            var checktypeid = $('.Course' + id + ' .data-checktypename').attr('data-id');
            var checktypename = $('.Course' + id + ' .data-checktypename').attr('dir');
            var courseact = $('.Course' + id + ' .data-courseact').attr('dir');
            $('#addCourse .dataTitl').text('编辑【' + name + '】步骤');
            $('#id').val(id);
            $('#name').val(name);
            $('#checktype').val(type);
            if (type == 'rank') {
                $('#checktype').parent('td').next('td').html('<input class="text2 None"type="hidden"/><input class="FrameGroupInput text1" readonly="readonly" type="text" id="checktypename" name="checktypename" value="' + checktypename + '" placeholder="请填写职位"/><a class="btn btn-sm btn-success get-upBox01 NewPop" data-url="<?php echo spUrl('process', 'procealert') ?>"data-title="编辑流程">选择</a>');
            } else if (type == 'admin') {
                $('#checktype').parent('td').next('td').html('<input type="text"  readonly="readonly" class="FrameGroupInput disabled get-upBox uname nother NewPop text3" id="uname" data-url="<?php echo spUrl('process', 'procealert') ?>"data-title="编辑流程" name="uname" value="' + checktypename + '"/><input type="hidden" class="text4" id="uid" name="uid" value="' + checktypeid + '"/>');
            } else {
                $('#checktype').parent('td').next('td').html('');
            }
            $('#courseact').val(courseact);
        });

    });
</script>
</html>
