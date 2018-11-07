<?php
require("params.php");
/* config */
$spConfig = array(
    "db" => array(
        'driver' => 'mysql',
        "host" => "localhost",
        "login" => "root",
        "password" => "root",
        "prefix" => "yld_",
        "database" => "guansheng"
    ),
    'view' => array(// 视图配置
        'enabled' => TRUE, // 开启视图
        'config' => array(
            'template_dir' => TPL_DIR // 模板目录
        ),
        'engine_name' => 'speedy', // 模板引擎的类名称
        'engine_path' => SP_PATH . '/Drivers/speedy.php', // 模板引擎主类路径
        'auto_display' => TRUE, // 是否使用自动输出模板功能
        'auto_display_sep' => '/', // 自动输出模板的拼装模式，/为按目录方式拼装，_为按下划线方式，以此类推
        'auto_display_suffix' => '.php', // 自动输出模板的后缀名
    ),
    'dispatcher_error' => "import(APP_PATH.'/404.php');exit();"
);
?>

        
        