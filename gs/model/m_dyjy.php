<?php

/**
 * Description of m_user
 *
 * @author Administrator
 */
class m_dyjy extends spModel {

    var $pk = "id";
    var $table = "dyjy";

    public function update($conditions = null, $data = null) { // 参数和update相同
        $this->query('START TRANSACTION');
        $results = parent::update($conditions, $data); // 调用spModel的update来进行查找
        if (!$results) {
            $this->query('ROLLBACK');
            return false; // 无返回结果则直接返回FALSE
        }
        $tmp = $this->find($conditions);
        if ($tmp['status'] >= 2 && $tmp['del'] == 0) {
            if ($tmp['type'] == 1) {
            $data2['cid'] = $tmp['cid'];
                $data2['oid'] = $tmp['oid'];
                $data2['name'] = $tmp['name'];
                $data2['format'] = $tmp['format'];
                $data2['num'] = $tmp['num'];
                $data2['type'] = 2;
                $data2['status'] = 0;
                if ($tmp['oid']) {
                    $up3 = $this->create($data2);
                    if ($up3 == false) {
                        $this->query('ROLLBACK');
                        return false; // 无返回结果则直接返回FALSE
                    }
                }
            } else {
                $con['id'] = $tmp['oid'];
                $data['mid'] = 9;
                $up2 = spClass('m_orders')->update($con, $data);
                if ($up2 == false) {
                    $this->query('ROLLBACK');
                    return false; // 无返回结果则直接返回FALSE
                }
            $data2['cid'] = $tmp['cid'];
                $data2['oid'] = $tmp['oid'];
                $data2['name'] = '成品入库单';
                $data2['status'] = 0;
                if ($tmp['oid']) {
                    $up3 = spClass('m_ruku')->create($data2);
                    if ($up3 == false) {
                        $this->query('ROLLBACK');
                        return false; // 无返回结果则直接返回FALSE
                    }
                }
            }
            $this->query("COMMIT");
            return $results;
        }
        $this->query("COMMIT");
        return $results;
    }

}

?>
