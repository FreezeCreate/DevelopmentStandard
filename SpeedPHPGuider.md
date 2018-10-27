# SpeedPHP-Guider #

----------

10/27/2018 9:20:58 AM Update

## MVC structure
### Controller常用方法：
* jump($url, $delay = 0)
>@param $url  需要前往的地址
     * @param $delay   延迟时间<br />
     * Tips:SpeedPHP里封装的HTML跳转方法

* display($tplname, $output = TRUE)
>* @param $tplname   模板路径及名称
* @param $output   是否直接显示模板，设置成FALSE将返回HTML而不输出
* Tip:输出模板：使用根路径地址：如：`$this->display('tpl/app/keep/index.html', TRUE);`，当第二个参数为TRUE时可以渲染变量至模板

### Model常用方法
* `find($conditions = null, $sort = null, $fields = null)`
> 和其他框架的find方法相似，查找单条符合条件的数据
> Tips：conditions的格式最好为数组格式，以免查询出错，如：`find(array('id' => $id));`而不是：`find('id='.$id.'');`

* `findAll($conditions = null, $sort = null, $fields = null, $limit = null)`

* `create($row)`
> @param row 数组形式，数组的键是数据表中的字段名，键对应的值是需要新增的数据。

* `createAll` 新增多条数据
> @param rows 数组形式，每项均为create的$row的一个数组

* `delete($conditions)` 
> @param conditions 数组形式，查找条件，此参数的格式用法与find/findAll的查找条件参数是相同的。

* `findBy($field, $value)` 不常用,按字段值查找一条记录
> @param field 字符串，对应数据表中的字段名
	 * @param value 字符串，对应的值

* `updateField($conditions, $field, $value)`
> 按字段值修改一条记录

* <font color=#6495ED> `findSql($sql)` 常用,使用原生sql查询</font>

* <font color=#6495ED>`runSql($sql)`常用,使用原生sql查询</font>
> 执行SQL语句，相等于执行新增，修改，删除等操作。

* <font color=#6495ED>`dumpSql()` 常用,调试使用打印最后执行的sql语句</font>

* `findCount($conditions = null)`
> 计算符合条件的记录数量

* `($conditions, $row)`
> 修改数据，该函数将根据参数中设置的条件而更新表中数据$row为数组形式

