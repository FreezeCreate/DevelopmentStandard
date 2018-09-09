
<?php

/**
 * Description of notice
 * 通知公告
 * @author IndexController
 */
class notice extends IndexController {

    //通知公告
    function index() {
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $is_read = (int)htmlentities($this->spArgs('is_read'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = '';
        if($is_read==1){
            $con .= ' and isread = 1';
            $page_con['is_read'] = 1;
        }else if($is_read==2){
            $con .= ' and isread = 0';
            $page_con['is_read'] = 1;
        }
        if(!empty($name)){
            $con .= ' and (a.title like "%'.$name.'%" or a.summary like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        $re = $m_infor->findResult($user['id'],$user['cid'],  $this->spArgs('page',1),$con);
        $this->results = $re['results'];
        $this->page = $re['pager'];
        $this->page_con = $page_con;
    }

    //通知公告详情
    function details() {
        
    }

    //添加通知公告
    function addnotice() {
        
    }

}
