<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class aaa extends IndexController {
    
    function index(){
        $model = spClass('m_jyexamples');
        $array = array(
            'q2' => '<textarea name="q2"></textarea>',
            'w2' => '<textarea name="w2"></textarea>',
            'e2' => '<textarea name="e2"></textarea>',
            'q3' => '<textarea name="q3"></textarea>',
            'w3' => '<textarea name="w3"></textarea>',
            'e3' => '<textarea name="e3"></textarea>',
            'q4' => '<textarea name="q4"></textarea>',
            'w4' => '<textarea name="w4"></textarea>',
            'e4' => '<textarea name="e4"></textarea>',
            'q5' => '<textarea name="q5"></textarea>',
            'w5' => '<textarea name="w5"></textarea>',
            'e5' => '<textarea name="e5"></textarea>',
            'q6' => '<textarea name="q6"></textarea>',
            'w6' => '<textarea name="w6"></textarea>',
            'e6' => '<textarea name="e6"></textarea>',
            'q7' => '<textarea name="q7"></textarea>',
            'w7' => '<textarea name="w7"></textarea>',
            'e7' => '<textarea name="e7"></textarea>',
            'q8' => '<textarea name="q8"></textarea>',
            'w8' => '<textarea name="w8"></textarea>',
            'e8' => '<textarea name="e8"></textarea>',
            'q9' => '<textarea name="q9"></textarea>',
            'w9' => '<textarea name="w9"></textarea>',
            'e9' => '<textarea name="e9"></textarea>',
            'q10' => '<textarea name="q10"></textarea>',
            'w10' => '<textarea name="w10"></textarea>',
            'e10' => '<textarea name="e10"></textarea>',
        );
        $model->update(array('id'=>1),$array);
    }
}
