<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>销售助手</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/artic.css"/>
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">销售助手</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="Cont">
                        <p class="ContTit"><?php echo $result['title']?></p>
                        <p class="ContTitSe"><?php echo $result['optdt']?></p>
                        <div class="ContCont">
                            <?php echo html_entity_decode($result['content'])?>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="FrameTableFoot">
                    <span class="Btn Big">提交</span>
            </div>-->
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {

            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            }
        })
    </script>
</html>