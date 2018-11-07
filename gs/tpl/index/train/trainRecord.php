<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>培训记录</title>
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
                            <input type="text" class="FrameDatGroup notenter" name="start" id="start" value="<?php echo $page_con['start'] ?>"/>
                        ~
                        <input type="text" class="FrameDatGroup notenter" name="end" id="end" value="<?php echo $page_con['end'] ?>"/>
                        <input class="TablesSerchInput" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="培训主题"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a> 
                    <div class="TablesAddBtn" onclick="fill_apply(37)">＋ 新增</div>
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
                                    <td>培训主题</td>
                                    <td>培训部门</td>
                                    <td>培训开始时间</td>
                                    <td>培训结束时间</td>
                                    <td>培训地址</td>
                                    <td>培训师</td>
                                    <td>培训文件</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="Result<?php echo $v['id'] ?>">
                                        <td><?php echo $k+1;?></td>
                                        <td style='text-align: left'><?php echo $v['name'];?></td>
                                        <td><?php echo $v['participants'];?></td>
                                        <td><?php echo $v['statdt'];?></td>
                                        <td><?php echo $v['enddt'];?></td>
                                        <td><?php echo $v['mRoom'];?></td>
                                        <td><?php echo $v['recorder'];?></td>
                                        <td>
                                            <?php foreach($v['files'] as $k2 => $v2){ ?>
                                                 <div class="download"><a class="download-a color-green" href="javascript:void(0)" itemid="<?php echo $files[$v2]['id']; ?>"><?php echo $files[$v2]['filename'] ?></a></div>
                                            <?php } ?>
                                        </td>
                                        <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="check_apply(37,<?php echo $v['id'] ?>)">详情</a></li>
                                                <li class="menu-item"><a onclick="fill_apply(37,<?php echo $v['id'] ?>)">编辑</a></li>
                                                <!--<li class="menu-item"><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>-->
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
        dateCell: "#start",
        format: "YYYY-MM-DD",
        isTime: false,
    })
    jeDate({
        dateCell: "#end",
        format: "YYYY-MM-DD",
        isTime: false,
    });


</script>
