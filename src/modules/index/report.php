
<?php

/**
 * Description of report
 * 工作汇报
 * @author IndexController
 */
class report extends IndexController {

    //我的汇报
    function myplan() {
        $user = $this->islogin();
        $model = spClass('m_daily');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = ' . $user['cid'] . ' and uid = ' . $user['id'];
        if (!empty($name)) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'adddt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //我的下属
    function mylower() {
        $user = $this->islogin();
        $model = spClass('m_daily');
        $m_user = spClass('m_user');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $users = $m_user->findAll('cid = ' . $user['cid'] . ' and superior = ' . $user['id'], '', 'id');
        $us = '0';
        foreach ($users as $k => $v) {
            $us .= ',' . $v['id'];
        }
        $con = 'del = 0 and cid = ' . $user['cid'] . ' and uid in(' . $us . ')';
        if (!empty($name)) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'adddt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //全部汇报
    function allwork() {
        $user = $this->islogin();
        $model = spClass('m_daily');
        $m_user = spClass('m_user');
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = ' . $user['cid'];
        if (!empty($name)) {
            $con .= ' and uname like "%' . $name . '%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con, 'adddt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

}
