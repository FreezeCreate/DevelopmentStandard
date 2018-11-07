<?php

date_default_timezone_set('PRC');
@header('Content-type: text/html;charset=UTF-8');
/*
  echo "系统维护中，维护时间：2014年9月27日 23:00 至 2014年9月28日 5:00。给你带来的不便，敬请理解！";
  exit;
 */

//前台入口文件
define("APP_PATH", dirname(__FILE__));
define("SP_PATH", dirname(__FILE__) . '/SpeedPHP');

define("SOURCE_PATH_FRONT",  "/source"); //资源文件路径
define("SOURCE_PATH", "/source");
define("UPLOAD_PATH", "/uploads");
define("DB_NAME", "yld");
define("ROOT", $_SERVER['DOCUMENT_ROOT']); //调试
define("URL", "http://192.168.1.136");
// define("URL", "http://gscs.sem98.com");


define("TPL_DIR", APP_PATH . '/tpl/' . basename(__FILE__, ".php")); //模版文件路径

require("config.php");
$spConfig['controller_path'] = APP_PATH . "/modules/" . basename(__FILE__, ".php");

//前台开启path_info
$spConfig['url'] = array(
    "url_path_info" => TRUE, //开启path_info
    "url_path_base" => "/index.php" //url根目录的访问地址
);

$spConfig["launch"] = array(
    'router_prefilter' => array(
        array(
            'spUrlRewrite', 'setReWrite'), // 对路由进行挂靠，处理转向地址
    ),
    'function_url' => array(
        array("spUrlRewrite", "getReWrite"), // 对spUrl进行挂靠，让spUrl可以进行Url_ReWrite地址的生成
    )
);
$spConfig["ext"] = array(
    'spUrlRewrite' => array(
        'suffix' => '',
        'sep' => '/',
        'map' => array(
            
        ),
        'args' => array(
        //  'market' => array('id'),
        )
    )
);


require(SP_PATH . "/SpeedPHP.php");

import('IndexController.php'); //载入自定义的控制器

spRun();
?>