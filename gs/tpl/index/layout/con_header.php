<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>冠晟平台</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
<!--        <script type="text/javascript">
        	setInterval(function(){
        		window.location.reload()
        	},300000)
        </script>-->
    </head>
    <?php
    if ($_SESSION['flow_set']) {
        $flow_set = $_SESSION['flow_set'];
    } else {
        $flow_set = spClass('m_flow_set')->findAll();
        $_SESSION['flow_set'] = $flow_set;
    }
    ?>
    <script>
        
                function fill_apply(mid, id) {
                    var tit;
                            var src;
                            var t;
                            t = id > 0?'编辑':'新增';
                            switch (mid)
                    {
                    <?php foreach ($flow_set as $k => $v) { ?>
                    case <?php echo $v['id'] ?>:
                            tit = t + '<?php echo $v['name'] ?>';
                            src = '/applyFill/<?php echo $v['model'] ?>?id=' + id;
                            break;
                    <?php } ?>
                        default:
                        return false;
                }
                parent.window.newHtml(src, tit);
                }
        function check_apply(mid, id) {
        var tit;
                var src;
                switch (mid)
        {
<?php foreach ($flow_set as $k => $v) { ?>
            case <?php echo $v['id'] ?>:
                    tit = '<?php echo $v['name'] ?>';
                    src = '/apply/<?php echo $v['model'] ?>?mid=' + mid + '&id=' + id;
                    break;
<?php } ?>
        default:
                return false;
        }
        parent.window.newHtml(src, tit);
        }
    </script>