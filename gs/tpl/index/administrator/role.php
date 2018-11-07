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
            <h3>管理职务</h3>
            <div class="tool">
                <a class="btn btn-primary" href="<?php echo spUrl($c,'addRole')?>"> 添 加 </a>
            </div>
        </div>
        <div class="content">
            <div class="search">
                <form action="" method="get">
                    <label class="form-group">
                        职务名：<input class="input-text" type="text" name="name" placeholder="职务名"/>
                    </label>
                    <button type="submit" class="btn btn-gray">搜索</button>
                </form>
            </div>
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-hover">
                <thead>
                    <tr>
                        <th class="box-tit" colspan="8">职务列表</th>
                    </tr>
                    <tr>
                        <th>id</th>
                        <th>职务名称</th>
                        <th style="width: 70%;">拥有权限</th>
                        <th style="width: 200px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($role as $k => $v) { ?>
                        <tr class="">
                            <td><?php echo $v['id'] ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php echo $v['auth'] ?></td>
                            <td class="center">
                                <?php if ($v['id'] > 1) { ?>
                                    <a class="btn btn-blue" href="<?php echo spUrl($c, 'editRole', array('id' => $v['id'])) ?>"><i class="icon-edit"></i>编辑</a>
                                    <a class="btn btn-red" onclick="del(<?php echo $v['id'] ?>)"><i class="icon-del"></i>删除</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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