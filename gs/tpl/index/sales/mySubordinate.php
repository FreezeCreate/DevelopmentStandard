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
            <h3>我的下属</h3>
        </div>
        <div class="content">
            <div class="search">
                <form action="<?php echo spUrl($c, $a) ?>" method="get">
                    <div class="topnav-tabbox pull-left">
                        <a href="<?php echo spUrl($c,$a)?>" class="<?php echo empty($page_con['status'])?'topnav-tabbox-active':''?>">全部</a>
                    </div>
                    <label class="form-group">
                        关键字：<input class="input-text" type="text" name="name" value="<?php echo $page_con['name'] ?>" placeholder="姓名/手机号/邮箱等"/>
                    </label>
                    <button class="btn btn-sm btn-gray">搜索</button>
                </form>
            </div>
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-hover" id="userlst">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>职位</th>
                        <th>人员状态</th>
                        <th>手机号</th>
                        <th>邮箱</th>
                        <th>生日</th>
                        <th>入职日期</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Result<?php echo $v['id'] ?>">
                            <td class="data-id"><?php echo $v['number'] ?></td>
                            <td class="data-name"><?php echo $v['name'] ?></td>
                            <td class="data-optname"><?php echo $v['positionname'] ?></td>
                            <td class="data-type"><?php echo $GLOBALS['USER_DIR'][$v['dir']] ?></td>
                            <td class="data-unitname"><?php echo $v['phone'] ?></td>
                            <td class="data-linkname"><?php echo $v['email'] ?></td>
                            <td class="data-tel"><?php echo $v['birthday'] ?></td>
                            <td class="data-mobile"><?php echo $v['workdate'] ?></td>
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

