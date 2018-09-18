<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_auth extends spModel {

    var $pk = "id";
    var $table = "auth";

    function getMenu($where = null,$sort = null, $fields = 'id,title,control,way,img', $limit = null) {
        $menu = $this->findAll($where.' and pid = 0', $sort,$fields,$limit);
        foreach ($menu as $k => $v) {
            $menu[$k]['children'] = $this->findAll($where.' and pid = ' . $v['id'], $sort,$fields,$limit);
            foreach ($menu[$k]['children'] as $k1 => $v1) {
                $menu[$k]['children'][$k1]['children'] = $this->findAll($where.' and pid = ' . $v1['id'], $sort,$fields,$limit);
            }
        }
        return $menu;
    }

}

?>
