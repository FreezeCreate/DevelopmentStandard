<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_filesr extends spModel {

    var $pk = "id";
    var $table = "filesr";
    // 由spModel的变量$linker来设置表间关联
    var $linker = array(
        array(
            'type' => 'hasone', // 关联类型，这里是一对一关联
            'map' => 'detail', // 关联的标识
            'mapkey' => 'file', // 本表与对应表关联的字段名
            'fclass' => 'm_file', // 对应表的类名
            'fkey' => 'id', // 对应表中关联的字段名
            'field' => 'id,filename,filesizecn',
            'enabled' => true     // 启用关联
        )
    );

}

?>
