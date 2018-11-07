<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class aaa extends IndexController {
    
    function index(){
        //setcookie('token','',time()-1,'/');
        echo $_COOKIE['token'];
    }
}
