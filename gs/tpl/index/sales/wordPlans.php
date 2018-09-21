<?php require_once TPL_DIR . '/layout/header.php'; ?>
<section id="content">
    <?php require_once TPL_DIR . '/layout/left.php'; ?>
    <!--
                    作者：895635200@qq.com
                    时间：2017-08-11
                    描述：主内容区域
    -->
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3>我的下属工作计划</h3>
        </div>
        <div class="content">
            <div class="search">
                <form action="<?php echo spUrl($c, $a) ?>" method="get">
                    <label class="form-group">
                        时间：
                        <input type="text" class="input-text notenter" name="start" id="begin" value="<?php echo $page_con['start'] ?>"/>
                        ~
                        <input type="text" class="input-text notenter" name="end" id="end" value="<?php echo $page_con['end'] ?>"/>
                    </label>
                    <label class="form-group">
                        关键字：<input class="input-text" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="姓名/计划"/>
                    </label>
                    <button class="btn btn-sm btn-gray">搜索</button>
                </form>
            </div>
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-hover" id="userlst">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>时间</th>
                        <th>姓名</th>
                        <th>计划</th>
                        <th>反馈</th>
                        <th>优先级</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Result<?php echo $v['id'] ?>">
                            <td class="data-id"><?php echo $v['stdt'] ?></td>
                            <td class="data-id"><?php echo $v['start'] . '-' . $v['end'] ?></td>
                            <td class="data-name"><?php echo $v['uname'] ?></td>
                            <td class="data-optname"><?php echo $v['title'] ?></td>
                            <td class="data-optname" style="text-align:left;"><?php echo $v['fankui'] ?></td>
                            <td class="data-optname"><?php echo $v['level'] ?></td>
                            <td>
<!--                                <a class="getOper" itemid="<?php echo $v['id'] ?>">操作 ∨</a>
                                <div class="operate" itemid="">
                                    <ul>
                                        <li><a>详情</a></li>
                                    </ul>
                                </div>-->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
        </div>
    </div>
    <!--
    作者：895635200@qq.com
    时间：2017-08-11
    描述：主内容区域end
    -->
</section>
</body>

</html>

<script>
    jeDate({
            dateCell: "#begin", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        })
        jeDate({
            dateCell: "#end", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        })
</script>

