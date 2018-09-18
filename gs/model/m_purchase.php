<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_purchase extends spModel {

    var $pk = "id";
    var $table = "purchase";
    
    public function update($conditions = null, $data = null) { // 参数和update相同
        $this->query('START TRANSACTION');
        $results = parent::update($conditions, $data); // 调用spModel的update来进行查找
        if (!$results) {
            $this->query('ROLLBACK');
            return false; // 无返回结果则直接返回FALSE
        }
        $tmp = $this->find($conditions);
        if ($tmp['is_stock'] == 1 && $tmp['del'] == 0) {
            $con['id'] = $tmp['oid'];
            $data['mid'] = 6;
            $up2 = spClass('m_orders')->update($con,$data);
            if ($up2 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $data2['cid'] = $tmp['cid'];
            $data2['oid'] = $tmp['oid'];
            $data2['status'] = 0;
            $up3 = spClass('m_draw')->create($data2);
            if ($up3 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $this->query("COMMIT");
            return $results;
        }
        $this->query("COMMIT");
        return $results;
    }

}

?>
