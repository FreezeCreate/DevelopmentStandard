<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>我的申请</title>
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
                            <ul class="TablesHeadNav">
                                <li class="TablesHeadItem <?php echo empty($page_con['type']) ? 'active' : '' ?>">
                                    <a href="<?php echo spUrl($c, $a) ?>">全部</a>
                                </li>
                                <li class="TablesHeadItem <?php echo $page_con['type'] == 1 ? 'active' : '' ?>">
                                    <a href="<?php echo spUrl($c, $a, array('type' => 1)) ?>">已完成</a>
                                </li>
                                <li class="TablesHeadItem <?php echo $page_con['type'] == 2 ? 'active' : '' ?>">
                                    <a href="<?php echo spUrl($c, $a, array('type' => 2)) ?>">未通过</a>
                                </li>
                            </ul>
                            <select class="TablesSerchInput" name="sid">
                                <option value="0">-选择模块-</option>
                                <?php foreach ($set as $k => $v) { ?>
                                    <optgroup label="<?php echo $GLOBALS['PRO_TYPE'][$k] ?>">
                                        <?php foreach ($v as $v1) { ?>
                                            <option <?php echo $page_con['sid'] == $v1['id'] ? 'selected=""' : '' ?> value="<?php echo $v1['id'] ?>"><?php echo $v1['name'] ?></option>
                                        <?php } ?>
                                    </optgroup>

                                <?php } ?>
                            </select>
                            <input class="TablesSerchInput" id="applydt" name="applydt" type="text"  placeholder="申请时间" value="<?php echo $page_con['applydt'] ?>"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
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
                                    <td>模块</td>
                                    <td>申请人</td>
                                    <td>部门</td>
                                    <td>申请日期</td>
                                    <td>操作时间</td>
                                    <td>摘要</td>
                                    <td>状态</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?> <?php echo $v['status'] == 0 ? 'isread' : '' ?>">
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['modelname']; ?></td>
                                        <td><?php echo $v['uname']; ?></td>
                                        <td><?php echo $v['udeptname']; ?></td>
                                        <td><?php echo $v['applydt']; ?></td>
                                        <td><?php echo $v['opttime']; ?></td>
                                        <td><?php echo $v['summary']; ?></td>
                                        <td><span class="color-green"><?php echo $v['statustext']; ?></span></td>
                                        <td>
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(<?php echo $v['modelid'].','.$v['tid'] ?>)">详情</a></li>
                                                <li class="menu-item"><a onclick="fill_apply(<?php echo $v['modelid'].','.$v['tid'] ?>)">编辑</a></li>
                                                <?php if ($v['status'] != 0) { ?><li class="menu-item void"><a class="color-gray" onclick="voidBox(<?php echo $v['id'] ?>)">作废</a></li><?php } ?>
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
        jeDate({
            dateCell: "#applydt", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        });
        function voidBox(id) {
            Confirm('确定作废？',function(){
                $.get("<?php echo spUrl($c, "void"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Results' + id + ' .data-status').removeClass('color-green,color-red,color-gray');
                        $('.Results' + id + ' .data-status').addClass('color-gray');
                        $('.Results' + id).addClass('isread');
                        $('.Results' + id + ' .data-status').text('已作废');
                        $('.Results' + id + ' .opt .operate ul li.void').remove();
                    }
                    $('.operate').hide();
                }, 'json');
            });
        }
        ;
        function delBox(id) {
            Confirm('确定删除？',function(){
                $.get("<?php echo spUrl($c, "del"); ?>", {id: id}, function(data) {
                    if (data.status == 1) {
                        $('.Result' + id).remove();
                    }
                }, 'json');
            });
        }
</script>





