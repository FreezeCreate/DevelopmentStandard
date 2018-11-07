<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class work extends AppController {
    
    function index(){
        
    }
    
    function lst(){
        $user = $this->islogin();
        $model = spClass('m_work');
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id'=>9));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach($st as $k=>$v){
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $type = (int) htmlentities($this->spArgs('type'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'del = 0 and cid = '.$user['cid'];
        if($name){
            $con .= ' and title like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        switch ($type) {
            case 1:
                $con .= ' and uid = '.$user['id'];
                $page_con['type'] = 1;
                break;
            case 2:
                $con .= ' and distid = ' . $user['id'];
                $page_con['type'] = 2;
                break;
            case 3:
                $con .= ' and distid = ' . $user['id'].' and status = 1';
                $page_con['type'] = 3;
                break;
            default:
                $con .= ' and uid = '.$user['id'];
                $page_con['type'] = 1;
                break;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        foreach($results as $k=>$v){
            $result['results'][$k] = array(
                'id' => $v['id'],
                'title' => $v['title'],
                'uname' => $v['uname'],
                'applydt' => $v['applydt'],
                'distname' => $v['distname'],
                'st' => $status[$v['status']]['text'],
            );
        }
        $this->returnSuccess('成功', $result);
    }

}

?>
