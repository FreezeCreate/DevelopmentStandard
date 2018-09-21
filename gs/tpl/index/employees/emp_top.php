<!DOCTYPE html>
<html>
    <head>
        <title>聚库 - 网聚身边商品，服务生意生后</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="<?php echo SOURCE_PATH ?>/img/logo.ico" rel="shortcut icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH;?>/css/base.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH;?>/css/style.css" />
        <link rel="stylesheet" href="<?php echo SOURCE_PATH;?>/dialog/ui-dialog.css">
        <script language="javascript" src="<?php echo SOURCE_PATH;?>/js/jquery.js"></script>
        <script src="<?php echo SOURCE_PATH;?>/dialog/dialog-min.js"></script>
        <script language="javascript" src="<?php echo SOURCE_PATH;?>/js/jquery.extend.js"></script>
        <script language="javascript" src="<?php echo SOURCE_PATH;?>/js/template.js"></script>
        <script language="javascript">
        $(function(){
				//默认错误图片
				$("img").each(function(){
					if($(this).attr("src").length==0){
						$(this).attr("src","/source/img/default-img.png");
					}
				});
				$('img').attr("onerror","javascript:this.src='/source/img/default-img.png'");
        });
        </script>
      
    </head>
    <body class="user-body">
        <div class="user-top-bg">
            <div class="user-top" <?php echo ($c=="passport")?'style="width:1000px;"':''; ?>>
                <div class="welcome">
                    <?php if(!empty($_SESSION['emp']['id'])){ ?>
                        <span><?php echo $_SESSION['emp']['name'] ?></span>
                        <span><a href="/employees/out">退出</a></span>
                    
                    <?php } ?>
                </div>
                <div class="ht-logo" style="width: 460PX;">
                    <p>
                    <a href="<?php echo spUrl("main", "index"); ?>" target="_blank"><img width="200" src="<?php echo SOURCE_PATH; ?>/image/logo2.png"></a>
                    </p>
                    <h2 class="text"><?php echo $title; ?></h2>
                </div>
            </div>
        </div>
        