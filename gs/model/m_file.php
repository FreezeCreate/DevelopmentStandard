<?php
/**
 * Description of m_about
 *
 * @author Administrator
 */
class m_file extends spModel{
    var $pk = "id";
    var $table = "file";
    public function findAll($conditions = null, $sort = null, $fields = null, $limit = null) // 参数和findAll相同
	{
		$results = parent::findAll($conditions, $sort, $fields, $limit); // 调用spModel的findAll来进行查找
		if( !$results )return false; // 无返回结果则直接返回FALSE
		$newresults = array();
		foreach( $results as $key => $value ){ 
			$newresults[$value['id']] = $value;
		}
		return $newresults; // 返回处理后的数据
	}
}
?>
