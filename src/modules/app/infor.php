<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class infor extends AppController {
    
    function index(){
        
    }
    
    function add(){
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $arg = array(
            'title' => '标题',
            'content' => '内容',
            'receid' => '',
            'recename' => '',
        );
        $data = $this->receiveData($arg);
        $m_infor->save($data,$user);
    }
    
    function lst(){
        $user = $this->islogin();
        $m_infor = spClass('m_infor');
        $is_read = (int)htmlentities($this->spArgs('is_read'));
        if($is_read==1){
            $con = ' and isread = 1';
        }else if($is_read==2){
            $con = ' and isread = 0';
        }
        $re = $m_infor->findResult($user['id'],$user['cid'],  $this->spArgs('page',1),$con);
        if(empty($re['results'])){
            $this->returnError('暂无数据');
        }
        $page = $re['pager']['current_page'] == $re['pager']['last_page'] ? '0' : $re['pager']['next_page'];
        $result['page'] = $page;
        foreach($re['results'] as $k=>$v){
            $result['results'][$k] = array(
                'id' => $v['id'],
                'title' => $v['title'],
                'isread' => $v['isread'],
                'summary' => $v['summary'],
                'dt' => date('Y.m.d',  strtotime($v['date'])),
            );
        }
        $this->returnSuccess('成功', $result);
    }

}

?>
