<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/lc.css"/>
    </head>
    <body>
        <div class="ContentBox">
            <div class="boxItem">
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_03.png"/><span>行政</span></div>
                    <ul class="lcItemCont">
                        <?php foreach($results[1] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="boxItem">
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_06.png"/><span>基础</span></div>
                    <ul class="lcItemCont">
                        <?php foreach($results[2] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_16.png"/><span>财务</span></div>
                    <ul class="lcItemCont">
                        
                        <?php foreach($results[6] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="boxItem">
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_08.png"/><span>考勤</span></div>
                    <ul class="lcItemCont">
                        <?php foreach($results[3] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_17.png"/><span>车辆</span></div>
                    <ul class="lcItemCont">
                        <?php foreach($results[7] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="boxItem">
                <div class="lcItem">
                    <div class="lcItemTit"><img src="<?php echo SOURCE_PATH; ?>/images/liy_10.png"/><span>人事</span></div>
                    <ul class="lcItemCont">
                        <?php foreach($results[5] as $k=>$v){?>
                        <li class="lcItemContItem" onclick="fill_apply(<?php echo $v['id']?>)"><?php echo $v['name']?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
</html>