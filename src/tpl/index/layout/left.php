<!--导航开始-->
<div class="LeftMenu noChoice">
    <div class="LeftMenuHead">
        <img class="userhead" src="<?php echo empty($admin['head']) ? SOURCE_PATH . '/images/head.png' : $admin['head']; ?>"/>
        <div class="userNames">
            <p><?php echo $admin['name'] ?></p>
            <p><?php echo $admin['pname'] ?></p>
        </div>
    </div>
    <div class="LeftMenuBox">
        <ul class="">
            <li>
                <a class="MenuItem <?php echo $c == 'main' && $a == 'index' ? 'active' : '' ?> on NewHtml a_01" data-url="<?php echo spUrl('main','bench')?>" data-clas="a_01" data-img="<?php echo SOURCE_PATH; ?>/images/shouye_16.png" data-name="首页">
                    <i class="firstImg home_1"></i>
                    <span class="firstText">首页</span>
                </a>
            </li>
            <?php foreach ($menu as $k => $v) { ?>
            <li class="MenuGroup">
                <div class="GroupFirst">
                    <i class="firstImg home_<?php echo $v['img']; ?>"></i>
                    <span class="firstText"><?php echo $v['title']; ?></span>
                </div>
                <div class="GroupFirstBox">
                    <?php foreach ($v['children'] as $k1 => $v1) { ?>
                    <a class="Second NewHtml a_<?php echo $v1['id']; ?>"data-url="<?php echo spUrl($v1['control'],$v1['way']);?>"data-clas="a_<?php echo $v1['id']; ?>"data-img="<?php echo SOURCE_PATH; ?>/images/gai_62.png"data-name="<?php echo $v1['title']; ?>">
                        <i class="firstImg home_01"></i>
                        <span class="firstText"><?php echo $v1['title']; ?></span>
                    </a>
                    <?php } ?>
                </div>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<!--导航结束-->