<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_flow_course extends spModel {

    var $pk = "id";
    var $table = "flow_course";
    
    function ress($sid = 0,$pid = 0,$level = 0){
        $con .= 'pid = '.$pid.' and sid = '.$sid;
        $result = $this->findAll($con);
        $level++;
        foreach($result as $v){
            $v['level'] = $level;
            $results[] = $v;
            $re = $this->ress($sid,$v['id'],$level);
            foreach($re as $k1=>$v1){
                $results[] = $v1;
            }
        }
        return $results;
    }

}

?>
