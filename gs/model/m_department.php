<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_department extends spModel {

    var $pk = "id";
    var $table = "department";

    function upmoney($id,$money){
        $re = $this->findBy('id',$id,'','id,summoney,money');
        if($money>0){
            $data['summoney'] = $re['summoney']+$money;
            $data['money'] = $re['summoney']+$money;
        }else if($money<0){
            $data['money'] = $re['summoney']+$money;
        }
        $up = $this->update(array('id'=>$id), $data);
        return $up;
    }
}

?>
