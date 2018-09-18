<?php
/**
 * Description of m_user
 *
 * @author Administrator
 */
class m_ruku extends spModel{
    var $pk = "id";
    var $table = "ruku";
    
    // 参数和update相同
    public function update($conditions = null, $data = null)
    {
        $this->query('START TRANSACTION');
        $results = parent::update($conditions, $data); // 调用spModel的update来进行查找
        if (!$results) {
            $this->query('ROLLBACK');
            return false; // 无返回结果则直接返回FALSE
        }
        $tmp = $this->find($conditions);
        if ($tmp['status'] >= 4 && $tmp['del'] == 0) {
            $orders  = spClass('m_goods_order')->find('id='.$tmp['goods_id']);
            $now_num = $orders['order_num'] + $tmp['ru_num'];
            $up2     = spClass('m_goods_order')->update(array('id' => $tmp['goods_id']),array('order_num' => $now_num));
            
//             $up2 = spClass('m_goods_order')->update(array('id' => $data['goods_id']),array('order_num' => $data['order_num']));
            if ($up2 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $this->query("COMMIT");
            return $results;
        }
        $this->query("COMMIT");
        return $results;
    }
    
//     public function create($data)
//     {
//         $this->query('START TRANSACTION');
//         $results = parent::create($data);
//         if (!$results) {
//             $this->query('ROLLBACK');
//             return false;
//         }
//         $tmp = $this->find($data['goods_id']);
//         if ($tmp['status'] >= 3 && $tmp['del'] == 0) {
//             $up2 = spClass('m_goods_order')->update(array('id' => $data['goods_id']),array('order_num' => $data['order_num']));
//             if ($up2 == false) {
//                 $this->query('ROLLBACK');
//                 return false;
//             }
//             $this->query("COMMIT");
//             return $results;
//         }
//         $this->query("COMMIT");
//         return $results;
//     }
    
}

?>
