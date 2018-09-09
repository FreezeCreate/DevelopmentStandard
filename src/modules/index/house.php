
<?php

/**
 * Description of house
 * 楼盘管理
 * @author IndexController
 */
class house extends IndexController {

    //楼盘管理
    function index() {
        $user = $this->islogin();
        $model = spClass('m_room');
        $con = 'del = 0 and cid = ' . $user['cid'];
        $level = (int) htmlspecialchars($this->spArgs('level',1));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if (!empty($level)) {
            $con .= ' and level = ' . $level;
            $page_con['level'] = $level;
        }
        if (!empty($name)) {
            $con .= ' and (title like "%' . $name . '%" or name like "%' . $name . '%" or name like "%' . $name . '%" or label like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs('page', 1), 6)->findAll($con, 'optdt desc', 'id,title,type,acreage,image,address,price,money,brokerage,brokeragehide,takelook,takelookhide');
        foreach ($results as $k => $v) {
            $results[$k]['reportsum'] = spClass('m_room_report')->findCount('del = 0 and rid = ' . $v['id']);
        }
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

}
