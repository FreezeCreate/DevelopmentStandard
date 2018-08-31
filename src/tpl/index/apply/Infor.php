
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
</head>
<body>
    <div class="MainHtml">
        <div class="titl">
            <h3 class="detailsTit"><?php echo $result['title'] ?></h3>
            <p class="detailssubtit">[通知公告] <?php echo $result['adddt'].',已读'.$result['isread'].',未读'.$result['noread']?></p>
        </div>
        <div class="datisCont">
            <?php echo html_entity_decode($result['content'])?>
        </div>
        <div class="ends">
<!--            <div class="lk">
                <p>财务部</p>
                <p>2018.02.03</p>
            </div>-->
        </div>
<!--        <div class="pg">
            <div class="pdX20">
                <a href="">上一页：没有啦</a>
                <a href=""class="float-right">下一页：没有啦</a>
            </div>
        </div>-->
    </div>
</body>
</html>
