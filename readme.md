# DevStandard #

----------

控制器：modules:  ->  apply.php 查看控制器  applyFill 新增控制器

查询api及表单字段：http://lejubang.com/api
视图：tpl

download方法封装直接下载

progress：
找到路由URL对应的方法及表
前端开发流程：




1. 修改页面名称为flow_set对应的名称；
2. applyfill中注入`$this->isLogin()`方法，渲染被修改页面；
3. 当前主页面注入跳转方法`fill_apply()`；
4. 在页面头写入封装好的组类方法；
5. 表单填充+ajax编写（Tips：URL）


后端：

1. 编写新增/更新方法；（对应app模块）
2. Tips：参数位置和`app/web`端sendUpcoming方法的不同
3. Tips：`index/main`中对OA系统数据的封装
