<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_purchase_caigou extends spModel {

    var $pk = "id";
    var $table = "purchase_caigou";
    
    public function update($conditions = null, $data = null) { // 参数和update相同
        $this->query('START TRANSACTION');
        $results = parent::update($conditions, $data); // 调用spModel的update来进行查找
        if (!$results) {
            $this->query('ROLLBACK');
            return false; // 无返回结果则直接返回FALSE
        }
        $tmp = $this->find($conditions);
        if ($tmp['status'] == 4 && $tmp['del'] == 0) {
            $con['id'] = $tmp['oid'];
            $data['mid'] = 5;
            $up2 = spClass('m_orders')->update($con,$data);
            if ($up2 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $data2['comid'] = $tmp['cid'];
            $data2['oid'] = $tmp['oid'];
            $data2['cid'] = $tmp['id'];
            $data2['optid'] = $tmp['optid'];
            $data2['optname'] = $tmp['optname'];
            $data2['optdt'] = $tmp['optdt'];
            $data2['status'] = 0;
            $up3 = spClass('m_qualitylog')->create($data2);
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
