
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/houslist.css"/>
<style type="text/css">
    .house-con p{margin-bottom: 4px;}
</style>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
            <ul class="grpBtn grpBtn-md">
                <li class="grpBtnItem <?php echo $page_con['level']==1?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('level'=>1))?>">一般项目</a></li>
                <li class="grpBtnItem <?php echo $page_con['level']==2?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('level'=>2))?>">优质项目</a></li>
                <li class="grpBtnItem <?php echo $page_con['level']==3?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('level'=>3))?>">合作项目</a></li>
            </ul>
            <span class="btn btn-sm btn-info float-right" onclick="Refresh()">刷新</span>
        </div>
        <div class="clerPd top20">
            <div class="row pdX10">
                <?php foreach ($results as $k=>$v) { ?>
                    <div class="col-4 col-sm-6">
                        <div class="pdX10">
                            <div class="meres-item">
                                <div class="house-img">
                                    <div class="house-imgbox h-center"><img src="<?php echo $v['image']; ?>" alt="" /></div>
                                </div>
                                <div class="house-con" style="margin-top: 0;">
                                    <p class="house-name"><?php echo $v['name']; ?></p>
                                    <p><?php echo $v['address']; ?></p>
                                    <p>佣金：<?php echo $v['brokerage']; ?>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;带看费：<?php echo $v['takelook']; ?>元</p>
                                    <p class="colorRed"><?php echo $v['price']; ?>㎡</p>
                                    <p>
                                        <span class="btn btn-xs btn-primary pdX30 NewHtml"data-url="<?php echo spUrl('release', 'lpadd') ?>"data-name="编辑项目">编辑</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php require_once TPL_DIR . '/layout/page.php'; ?>
    </div>
</body>
</html>