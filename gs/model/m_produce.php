<?php

/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_produce extends spModel {

    var $pk = "id";
    var $table = "produce";

    public function update($conditions = null, $data = null) { // 参数和update相同
        $this->query('START TRANSACTION');
        $results = parent::update($conditions, $data); // 调用spModel的update来进行查找
        if (!$results) {
            $this->query('ROLLBACK');
            return false; // 无返回结果则直接返回FALSE
        }
        $tmp = $this->find($conditions);
        if ($tmp['status'] == 3 && $tmp['del'] == 0) {
            $con['id'] = $tmp['oid'];
            $data['mid'] = 4;
            $up2 = spClass('m_orders')->update($con,$data);
            if ($up2 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $data2['oid'] = $tmp['oid'];
            $data2['cid'] = $tmp['cid'];
            $up3 = spClass('m_purchase')->create($data2);
            if ($up3 == false) {
                $this->query('ROLLBACK');
                return false; // 无返回结果则直接返回FALSE
            }
            $quo = spClass('m_quotation')->find(array('oid'=>$tmp['oid']),'','id');
            $pro = spClass('m_quo_project')->findAll(array('pid'=>$quo['id']));
            $ids = '0';
            foreach($pro as $v){
                $ids .= ','.$v['qid'];
            }
            $mater = spClass('m_pro_mater')->findAll('pid in('.$ids.')');
            foreach($mater as $v){
                $data_mater[$v['mid']]['pid'] = $up3;
                $data_mater[$v['mid']]['number'] = $v['number'];
                $data_mater[$v['mid']]['name'] = $v['name'];
                $data_mater[$v['mid']]['format'] = $v['format'];
                $data_mater[$v['mid']]['unit'] = $v['unit'];
                $data_mater[$v['mid']]['price'] = $v['price'];
                $data_mater[$v['mid']]['mid'] = $v['mid'];
                $data_mater[$v['mid']]['num'] += $v['num'];
            }
            $up4 = spClass('m_purchase_mater')->createAll($data_mater);
            $this->query("COMMIT");
            return $results;
        }
        $this->query("COMMIT");
        return $results;
    }

}

?>
