<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>客户合同管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>

        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['status']) ? 'active' : '' ?>" ><a href="<?php echo spUrl($c, $a) ?>" class="">全部</a></li>
                        <?php foreach ($GLOBALS['CUSTRACT_TYPE'] as $k => $v) { ?>
                            <li class="TablesHeadItem <?php echo $page_con['status'] == $k ? 'active' : '' ?>" ><a href="<?php echo spUrl($c, $a, array('status' => $k)) ?>"><?php echo $v; ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <div class="topnav-tabbox pull-left">

                            </div>
                            <label class="form-group">
                                客户：<select class="FrameGroupInput" name="comer">
                                    <option value='0'>全部</option>
                                    <?php foreach ($customer as $k => $v) { ?>
                                        <option value="<?php echo $v['id']; ?>" <?php
                                        if ($page_con['comer'] == $v['id']) {
                                            echo 'selected';
                                        }
                                        ?> ><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="form-group">
                                销售人员：<select class="FrameGroupInput" name="uid">
                                    <option value='0'>全部</option>
                                    <?php foreach ($admins as $k => $v) { ?>
                                        <option value="<?php echo $v['id']; ?>" <?php
                                                if ($page_con['uid'] == $v['id']) {
                                                    echo 'selected';
                                                }
                                                ?> ><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="form-group">
                                <input class="FrameGroupInput" placeholder="合同编号" type="text" name="number" value="<?php echo $page_con['number'] ?>"/>
                            </label>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                            <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                        </form>
                    </div>
                    <a class="btn btn-primary" onclick="fill_apply(31)"><div class="TablesAddBtn">＋添 加</div> </a>
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
                        <table class="table table-info table-hover" id="userlst">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>合同编号</th>
                                    <th>客户名称</th>
                                    <th>所属销售</th>
                                    <th>合同总金额</th>
                                    <th>签订时间</th>
                                    <th>生效时间</th>
                                    <th>结束时间</th>
                                    <th>说明</th>
                                    <th style="width: 150px;">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="User<?php echo $v['id'] ?>">
                                        <td></td>
                                        <td><?php echo $v['number']; ?></td>
                                        <td><a onclick="check_apply(21,<?php echo $v['custid'] ?>)"><?php echo $v['custname']; ?></a></td>
                                        <td><?php echo $admins[$v['uid']]['name']; ?></td>
                                        <td><?php echo $v['money']; ?></td>
                                        <td><?php echo $v['signdt']; ?></td>
                                        <td><?php echo $v['startdt']; ?></td>
                                        <td><?php echo $v['enddt']; ?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                                操作  ＋
                                                <ul class="menu">
                                                    <li class="menu-item">
                                                        <a onclick="check_apply(31,<?php echo $v['id'] ?>)">详情</a></li>
                                                    <li class="menu-item"><a onclick="fill_apply(31,<?php echo $v['id'] ?>)">编辑</a></li>
                                                    <li class="menu-item"><a class="color-red" onclick="del_form(<?php echo $v['id'] ?>)">删除</a></li>
                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php require_once TPL_DIR . '/layout/page.php'; ?>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/apply.php'; ?>
            </div>	
        </div>	
        <div class="Person upBox add" id="addBranch">
            <div class="PersonBox" style="width:auto;">
                <div class="PersonTit"><a style="color:#ffffff;">添加跟进记录</a><span class="close"></span></div>
                <div class="PersonCont">
                    <div class="upBox-c">
                        <form id="genjin_form" method="post" action="" onsubmit="return false;">
                            <div class="FrameCont">
                                <div class="FrameTable">
                                    <div class="FrameTableTitl">添加跟进记录</div>
                                    <table class="FrameTableCont">
                                        <table class="table table-add">
                                            <tbody>
                                                <tr>
                                                    <td>跟进说明</td>
                                                    <td style="text-align: left;">
                                                        <textarea class="FrameGroupInput" name="explain"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>下次联系时间</td>
                                                    <td style="text-align: left;"><input class="FrameGroupInput" id="next" type="text" name="next" value=""/></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="upBox-f">
                                            <input id="eid" type="hidden" name="id" value=""/>
                                            <a class="but but-primary" onclick="do_genjin()">确认</a>
                                            <a class="but but-gray close">关闭</a>
                                        </div>
                                        </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
        作者：895635200@qq.com
        时间：2017-08-11
        描述：主内容区域end
        -->

    </body>

</html>

<script type="text/javascript">
    jeDate({
        dateCell: "#next", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    $('.follow').click(function() {
        $('#eid').val($(this).attr('itemid'));
    });
    function do_genjin() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('cust', "follow"); ?>",
            data: $('#genjin_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    alert(data.msg);
                    $('#genjin .close').click();
                } else {
                    loading('none');
                    alert(data.msg);
                }

            }
        });
    }
    // function del_form(){
    // if (confirm('确定删除该客户项目?')) {
    // $.post("<?php echo spUrl($c, "delSales"); ?>", $('#Delete_form').serialize(), function(data) {
    // if (data.status == 1) {
    // alert(data.msg);
    // window.location.reload();
    // }else{
    // alert(data.msg);
    // }
    // $('.operate').hide();
    // }, 'json');
    // }
    // }

    function del_form(id) {
        Confirm('确定删除信息吗？', function(e) {
            if (e) {
                $.post("<?php echo spUrl($c, "delSales"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.User' + id).remove();
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
</script>
