<?php

/**
 * Description of passpost
 *
 * @author Administrator
 */
class moving extends AppController {

    function addmoving() {
        $user = $this->islogin();
        $model = spClass('m_moving');
        $arg = array(
            'content' => '动态内容',
            'images' => '',
            'video' => '',
            'address' => '',
            'lng' => '',
            'lat' => '',
        );
        $data = $this->receiveData($arg);
        $data['dt'] = date('Y-m-d H:i:s');
        $data['uid'] = $user['id'];
        $data['uname'] = $user['name'];
        $images = empty($data['images']) ? array() : explode(',', $data['images']);
        foreach($images as $k=>$v){
            $v = trim($v);
            $images[$k] = Common::copy_upload($v, 'moving/'.date('Ymd'));
        }
        $data['images'] = implode(',', $images);
        $ad = $model->create($data);
        if ($ad) {
            $this->returnSuccess('成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function index() {
        $user = $this->islogin();
        $model = spClass('m_moving');
        $m_moving_look = spClass('m_moving_look');
        $results = $model->spPager($this->spArgs('page', 1), 5)->findAll('del = 0', 'dt desc');
        $ids = 0;
        foreach ($results as $k => $v) {
            $results[$k]['time'] = $this->formatDT(strtotime($v['dt']));
            $u = spClass('m_user')->find(array('id' => $v['uid']), '', 'id,name,head');
            $todos = spClass('m_moving_todos')->findAll('del = 0 and mid = ' . $v['id'], 'dt asc');
            $results[$k]['ourzan'] = 0;
            foreach ($todos as $k1 => $v1) {
                if ($v1['type'] == 1) {
                    $results[$k]['zan'][] = array('id' => $v1['uid'], 'name' => $v1['uname']);
                    if ($v1['uid'] == $user['id']) {
                        $results[$k]['ourzan'] = 1;
                    }
                } else if ($v1['type'] == 2) {
                    $v1['del'] = $v1['uid'] == $user['id'] ? 1 : 0;
                    $results[$k]['comment'][] = $v1;
                }
            }
            $results[$k]['uname'] = $u['name'];
            $results[$k]['uhead'] = $u['head'];
            $results[$k]['del'] = $user['id'] == $v['uid'] ? 1 : 0;
            $results[$k]['video'] = empty($v['video']) ? '' : URL . $v['video'];
            $images = empty($v['images']) ? array() : explode(',', $v['images']);
            foreach ($images as $k1 => $v1) {
                $images[$k1] = URL . $v1;
            }
            $look = $m_moving_look->find(array('mid' => $v['id'], 'uid' => $user['id']));
            if ($look) {
                $m_moving_look->update(array('id' => $look['id']), array('dt' => time()));
            } else {
                $m_moving_look->create(array('mid' => $v['id'], 'uid' => $user['id'], 'dt' => time()));
            }
            $results[$k]['images'] = implode(',', $images);
            $ids .= ',' . $v['id'];
        }
        $model->incrField('id in (' . $ids . ')', 'look');
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    //点赞
    function like() {
        $user = $this->islogin();
        $model = spClass('m_moving_todos');
        $id = (int) htmlentities($this->spArgs('id'));
        $re = $model->find(array('mid' => $id, 'uid' => $user['id']));
        if (empty($re)) {
            $ad = $model->create(array('mid' => $id, 'uid' => $user['id'], 'uname' => $user['name'], 'dt' => date('Y-m-d H:i:s'), 'type' => 1, 'is_new' => 1));
            if ($ad) {
                $this->returnSuccess('点赞成功');
            } else {
                $this->returnError('网络错误', 404);
            }
        } else {
            $this->returnError('您已经点过赞了');
        }
    }

    //评论
    function addword() {
        $user = $this->islogin();
        $m_moving = spClass('m_moving');
        $model = spClass('m_moving_todos');
        $id = (int) htmlentities($this->spArgs('id'));
        $tid = (int) htmlentities($this->spArgs('tid'));
        $content = htmlspecialchars($this->spArgs('content'));
        $re = $m_moving->find(array('id' => $id, 'del' => 0), '', 'id');
        if (empty($re)) {
            $this->returnError('动态不存在或已删除');
        }
        if (empty($content)) {
            $this->returnError('请输入评论内容');
        }
        $todos = $model->find(array('id' => $tid, 'mid' => $id));
        if ($todos) {
            $data['cid'] = $todos['uid'];
            $data['cname'] = $todos['uname'];
        }
        $data['mid'] = $id;
        $data['muid'] = $re['uid'];
        $data['uid'] = $user['id'];
        $data['uname'] = $user['name'];
        $data['content'] = $content;
        $data['dt'] = date('Y-m-d H:i:s');
        $data['type'] = 2;
        $data['is_new'] = 1;
        $ad = $model->create($data);
        if ($ad) {
            $this->returnSuccess('成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function looks() {
        $user = $this->islogin();
        $id = (int)htmlentities($this->spArgs('id'));
        $model = spClass('m_moving_look');
        $con = 'mid = '.$id;
        $sql = 'select a.*,b.name,b.head from '.DB_NAME.'_moving_look as a left outer join '.DB_NAME.'_user as b on a.uid = b.id where '.$con.' order by a.dt desc';
        $results = $model->spPager($this->spArgs('page', 1), 20)->findSql($sql);
        foreach($results as $k=>$v){
            $results[$k]['dt'] = date('Y-m-d H:i',$v['dt']);
            $results[$k]['head'] = URL.$v['head'];
        }
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function delmoving() {
        $user = $this->islogin();
        $id = (int) htmlentities($this->spArgs('id'));
        $model = spClass('m_moving');
        $re = $model->find(array('id' => $id, 'del' => 0));
        if (empty($re)) {
            $this->returnError('动态不存在或已删除');
        }
        if ($re['uid'] !== $user['id']) {
            $this->returnError('您无权删除该动态');
        }
        $del = $model->update(array('id' => $id), array('del' => 1));
        if ($del) {
            $this->returnSuccess('删除成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function deltodos() {
        $user = $this->islogin();
        $id = htmlentities($this->spArgs('id'));
        $model = spClass('m_moving_todos');
        $re = $model->find(array('id' => $id, 'del' => 0));
        if (empty($re)) {
            $this->returnError('评论不存在或已删除');
        }
        if ($re['uid'] !== $user['id']) {
            $this->returnError('您无权删除该评论');
        }
        $del = $model->update(array('id' => $id), array('del' => 1));
        if ($del) {
            $this->returnSuccess('删除成功');
        } else {
            $this->returnError('网络错误', 404);
        }
    }

    function our() {
        $user = $this->islogin();
        $model = spClass('m_moving');
        $m_moving_look = spClass('m_moving_look');
        $results = $model->spPager($this->spArgs('page', 1), 5)->findAll('del = 0 and uid = ' . $user['id'], 'dt desc');
        $ids = 0;
        foreach ($results as $k => $v) {
            $results[$k]['time'] = $this->formatDT(strtotime($v['dt']));
            $u = spClass('m_user')->find(array('id' => $v['uid']), '', 'id,name,head');
            $todos = spClass('m_moving_todos')->findAll('del = 0 and mid = ' . $v['id'], 'dt asc');
            $results[$k]['ourzan'] = 0;
            foreach ($todos as $k1 => $v1) {
                if ($v1['type'] == 1) {
                    $results[$k]['zan'][] = array('id' => $v1['uid'], 'name' => $v1['uname']);
                    if ($v1['uid'] == $user['id']) {
                        $results[$k]['ourzan'] = 1;
                    }
                } else if ($v1['type'] == 2) {
                    $v1['del'] = $v1['uid'] == $user['id'] ? 1 : 0;
                    $results[$k]['comment'][] = $v1;
                }
            }
            $results[$k]['uname'] = $u['name'];
            $results[$k]['uhead'] = $u['head'];
            $results[$k]['del'] = $user['id'] == $v['uid'] ? 1 : 0;
            $results[$k]['video'] = empty($v['video']) ? '' : URL . $v['video'];
            $images = empty($v['images']) ? array() : explode(',', $v['images']);
            foreach ($images as $k1 => $v1) {
                $images[$k1] = URL . $v1;
            }
            $look = $m_moving_look->find(array('mid' => $v['id'], 'uid' => $user['id']));
            if ($look) {
                $m_moving_look->update(array('id' => $look['id']), array('dt' => date('Y-m-d H:i:s')));
            } else {
                $m_moving_look->create(array('mid' => $v['id'], 'uid' => $user['id'], 'dt' => date('Y-m-d H:i:s')));
            }
            $results[$k]['images'] = implode(',', $images);
            $ids .= ',' . $v['id'];
        }
        $model->incrField('id in (' . $ids . ')', 'look');
        $result['results'] = $results;
        $pager = $model->spPager()->getPager();
        $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
        $result['page'] = $page;
        $this->returnSuccess('成功', $result);
    }

    function ourtodos() {
        $user = $this->islogin();
        $model = spClass('m_moving_todos');
        $type = htmlentities($this->spArgs('type'));
        if ($type === 'count') {
            $sum = $model->findCount('del = 0 and is_new = 1 and (muid = ' . $user['id'] . ' or cid = ' . $user['id'] . ')');
            $result['news'] = empty($sum) ? '' : $sum;
            $this->returnSuccess('成功', $result);
        } else {
            $results = $model->spPager($this->spArgs('page', 1), 15)->findAll('del = 0 and is_new = 1 and (muid = ' . $user['id'] . ' or cid = ' . $user['id'] . ')');
            $ids = '0';
            foreach($results as $k=>$v){
                $ids = ','.$v['uid'];
            }
            $users = spClass('m_user')->findAll('id in ('.$ids.')','','id,name,head');
            foreach($users as $k=>$v){
                $u[$v['id']] = $v;
            }
            foreach($results as $k=>$v){
                $results[$k]['uhead'] = $u[$v['uid']]['head'];
                $results[$k]['uname'] = $u[$v['uid']]['name'];
            }
            $result['results'] = $results;
            $pager = $model->spPager()->getPager();
            $page = $pager['current_page'] == $pager['last_page'] ? '0' : $pager['next_page'];
            $result['page'] = $page;
            $this->returnSuccess('成功', $result);
        }
    }
    
    function editsign(){
        $user = $this->islogin();
        $sign = htmlspecialchars($this->spArgs('sign'));
        $model = spClass('m_user');
        if(empty($sign)){
            $this->returnError('请填写个性签名');
        }
        $up = $model->update(array('id'=>$user['id']),array('signature'=>$sign));
        if($up){
            $this->returnSuccess('成功');
        }else{
            $this->returnError('网络错误',404);
        }
    }
    

}

?>
