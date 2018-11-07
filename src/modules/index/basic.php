<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class basic extends IndexController {
    
    function getSessionId(){
        exit(session_id());
    }

    function nowVersion() {
        $version = htmlentities($this->spArgs('version'));
        if ($version == $GLOBALS['VERSION']['num']) {
            $this->returnError('当前版本已是最新版本', 2);
        } else {
            $this->returnSuccess('检测到新版本', $GLOBALS['VERSION']);
        }
    }
    
    function findAddress(){
        $model = spClass('m_pca');
        $pid = (int)htmlentities($this->spArgs('pid'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        if($pid){
            $con = 'pid = '.$pid;
        }else{
            $con = 'pid = 0';
        }
        if(!empty($name)){
            $con .= ' and name like "%'.$name.'%"';
        }
        $results = $model->findAll($con,'','aid,name,level');
        exit(json_encode($results));
    }
    
    function findUserinfo(){
        $token = htmlentities($this->spArgs('token'));
        $m_user = spClass('m_user');
        $m_company = spClass('m_company');
        $result = $m_user->find(array('login'=>$token),'','cid,cname,status,name,head,phone,is_company,dname,pname,dir,is_auth');
        if($result){
            $result['head'] = URL.$result['head'];
            $company = $m_company->find(array('id'=>$result['cid']),'','company,logo,status');
            $result['companylogo'] = URL.$company['logo'];
            $result['company'] = $company['company'];
            unset($result['cid']);
            $this->returnSuccess('成功', $result);
        }else{
            $this->returnError('未找到用户信息');
        }
        
        
    }


}

?>
