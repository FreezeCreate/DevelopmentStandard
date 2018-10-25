
<?php

/**
 * Description of checkwork
 * 考勤管理
 * @author IndexController
 */
class checkwork extends AppController {

    //考勤参数列表
    function checkdata() 
    {
        $admin    = $this->islogin();
        $m_kqsjgz = spClass('m_kqsjgz');
        $results  = $m_kqsjgz->findAll('pid = 0 and cid = '.$admin['cid'], 'sort asc');
        foreach ($results as $k => $v) {
            $results[$k]['children'] = $m_kqsjgz->findAll('pid = ' . $v['id'].' and cid = '.$admin['cid'], 'sort asc');
        }
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    //考勤参数详情
    function bjwork() 
    {
        $admin             = $this->islogin();
        $id                = (int) htmlspecialchars($this->spArgs('id'));
        $m_kqsjgz          = spClass('m_kqsjgz');
        $result['results'] = $m_kqsjgz->find(array('id' => $id));
        $this->returnSuccess('成功', $result);
    }
    
    //编辑考勤参数
    function updateBjwork() {
        $user         = $this->islogin();
        $m_kqsjgz     = spClass('m_kqsjgz');
        $id           = (int) htmlspecialchars($this->spArgs('id'));
        
        $data['stime'] = htmlspecialchars($this->spArgs('stime'));
        $data['etime'] = htmlspecialchars($this->spArgs('etime'));
        //表单验证
        $form_data = array(
            'stime'    => '',   //开始时间
            'etime'    => '',   //结束时间
        );
        
        $this->receiveData($form_data);
        $ad = $m_kqsjgz->update(array('id'=>$id),$data);
        
        if ($ad) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    //考勤记录
    function checkrecord() {
        $admin = $this->islogin();
        $model = spClass('m_kqdkjl');
        $start = htmlspecialchars($this->spArgs('start'));
        $end   = htmlspecialchars($this->spArgs('end'));
        $name  = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $con = 'a.cid = ' . $admin['cid'];
        if ($start) {
            $con .= ' and dkdt >= ' . date('Ymd', strtotime($start));
            $page_con['start'] = $start;
        }
        if ($end) {
            $con .= ' and dkdt <= ' . date('Ymd', strtotime($end));
            $page_con['end'] = $end;
        }
        if ($name) {
            $con .= ' and (a.dname like "%' . $name . '%" or name like "%' . $name . '%")';
            $page_con['searchname'] = $name;
        }
        $sql = 'select a.*,b.dname,b.name from '.DB_NAME.'_kqdkjl as a left outer join '.DB_NAME.'_admin as b on a.uid = b.id where ' . $con . ' order by dkdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $model->spPager()->getPager();
        $result['pager']   = $pager;
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 请假新增
     */
    function saveLeaveRecord()
    {
        $admin            = $this->islogin();
        $arg = array(
            'id'      => '',
            'type'    => '请假类型',
            'start'   => '开始时间',
            'end'     => '截止时间',
            'explain' => '请假说明',
        );
        $data  = $this->receiveData($arg);
        $id    = (int) htmlspecialchars($this->spArgs('id'));
        unset($data['id']);
        $model = spClass('m_kqinfo');
        
        if ($id) {
            $re = $model->find(array('id' => $id, 'del' => 0), '', 'id');
            if (empty($re)) $this->returnError('信息有误', 1);
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id' => $re['id']), $data);
            if ($up) $ad = $re['id'];
        } else {
//             $data['status']  = 1;
            $data['optid']   = $admin['id'];
            $data['optname'] = $admin['name'];
            $data['optdt']   = date('Y-m-d H:i:s');
            
            $data['status']  = 1;
            $data['uid']     = $admin['id'];
            $data['uname']   = $admin['name'];
            $data['cid']     = $admin['cid'];
            $data['dname']   = $admin['dname'];
            $data['applydt'] = date('Y-m-d H:i:s');
            $ad = $model->create($data);
        }
        if ($ad) {
            $this->sendMsgNotice($admin, 50, $ad, '[' . $data['type'] . ']' . $data['start'] . '->' . $data['end']);
            $this->sendUpcoming($admin, 50, $ad, '[' . $data['type'] . ']' . $data['start'] . '->' . $data['end']);
            $this->returnSuccess('成功');
        } else {
            $this->returnError('失败');
        }
    }

    //请假记录 
    function leaverecord() {
        $admin = $this->islogin();
        $model = spClass('m_kqinfo');
        $start = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $con = 'a.cid = ' . $admin['cid'];
        if ($start) {
            $con .= ' and applydt >= ' . date('Ymd', strtotime($start));
            $page_con['start'] = $start;
        }
        if ($end) {
            $con .= ' and applydt <= ' . date('Ymd', strtotime($end));
            $page_con['end'] = $end;
        }
        if ($name) {
            $con .= ' and (a.dname like "%' . $name . '%" or uname like "%' . $name . '%")';
            $page_con['searchname'] = $name;
        }
        $sql     = 'select a.*,b.name from '.DB_NAME.'_kqinfo as a left outer join '.DB_NAME.'_admin as b on a.uid = b.id where ' . $con . ' order by applydt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 请假详情
     */
    function kqInfo()
    {
        $admin      = $this->islogin();
        $model      = spClass('m_kqinfo');
        $id         = htmlspecialchars($this->spArgs('id'));
        //check params
        if (empty($id)) $this->returnError('id不存在');
        $results    = $model->find('id='.$id.' and cid='.$admin['cid']);
        if (empty($results)) $this->returnError('id非法');
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 考勤日程新增
     */
    function saveAtdate()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_atdate');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
            'adate'     => '安排日期',
            'astatus'   => '日程安排状态',
            'aname'     => '日程名称',
        );
        $data = $this->receiveData($arg);
        
        if($id){
            $re = $model->find(array('id'=>$id,'del'=>0,'cid'=>$admin['cid']));
            if(empty($re)) $this->returnError('日程不存在');
            
            $data = $this->checkUpdateArr($re, $data);  //更新方法
            
            $up = $model->update(array('id'=>$id),$data);
        }else{
            $data['cid']       = $admin['cid'];
            $data['optid']     = $admin['id'];
            $data['optname']   = $admin['name'];
            $data['optdt']     = date('Y-m-d H:i:s');
            $up = $model->create($data);
        }
        
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 日程列表
     */
    function atdateLst()
    {
        $admin      = $this->islogin();
        $con        = 'del = 0 and cid = ' . $admin['cid'];
        $searchname = urldecode(htmlspecialchars($this->spArgs('searchname')));
        $astatus    = (int)htmlentities($this->spArgs('astatus'));
        $model      = spClass('m_atdate');
        if (!empty($searchname)) {
            $con .= ' and concat(adate,aname) like "%' . $searchname . '%"';
            $page_con['searchname'] = $searchname;
        }
        if (!empty($astatus)){
            $con .= ' and astatus='.$astatus.'';
            $page_con['astatus'] = $astatus;
        }
        
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'optdt desc,id desc');
        $pager   = $model->spPager()->getPager();
        $result['pager'] = $pager;
        
        foreach($results as $k=>$v){
            $result['results'][$k] = $v;
        }
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 日程删除
     */
    function delAtdate()
    {
        $id = htmlspecialchars($this->spArgs('id'));
        $this->delCommon('m_atdate', $id);
    }
    
    /**
     * 打卡新增
     * kqdkjl
     */
    function savePerClock()
    {
        $admin           = $this->islogin();
        $model           = spClass('m_kqdkjl');
        $id              = (int)htmlentities($this->spArgs('id'));
        
        $arg = array(
//             'uid'      => '打卡人',
            'dkdt'     => '',   //打卡时间
//             'type'     => '打卡类型',    //默认为0
            'address'  => '',   //打卡地址
            'lat'      => '',  //维度
            'lng'      => '',  //经度
            'accuracy' => '', //精确范围
            'explain'  => '',  //explain
            'images'   => '',  //images
        );
        $data = $this->receiveData($arg);
        
        $data['uid']       = $admin['id'];
        $data['cid']       = $admin['cid'];
        $data['optid']     = $admin['id'];
        $data['optname']   = $admin['name'];
        $data['ip']        = Common::getIp();
        $data['optdt']     = date('Y-m-d H:i:s');
        $data['type']      = 0;
        //app端时间不统一传值的兼容
        if (empty($data['dkdt'])) $data['dkdt'] = date('Y-m-d H:i:s');
        
        $up = $model->create($data);
        if($up) $this->returnSuccess('成功');
        $this->returnError('失败');
    }
    
    /**
     * 是否打卡
     */
    function isPerClock()
    {
        $admin   = $this->islogin();
        $sql     = 'select * from '.DB_NAME.'_kqdkjl where uid='.$admin['id'].' and dkdt like "%'.date('Y-m-d').'%" order by dkdt desc';
        $results = spClass('m_kqdkjl')->findSql($sql);
        $up      = spClass('m_kqsjgz')->find('cid='.$admin['id'].' and name like "%下班%"');
        $on      = spClass('m_kqsjgz')->find('cid='.$admin['id'].' and name like "%上班%"');
        
        $on_time = $up_time = '未打卡';
        foreach ($results as $k => $v){
            if ($v['dkdt'] < $on['stime']){
                $on_time = '已打卡';
                $on_clo  = $v['dkdt'];
                break;
            }
        }
        foreach ($results as $k => $v){
            if ($v['dkdt'] > $up['etime']){
                $up_time = '已打卡';
                $up_clo  = $v['dkdt'];
                break;
            }
        }
        //data restru
        $all_results = array(
            array('上班', $on_time, $on_clo),
            array('下班', $up_time, $up_clo),
        );
        $result['results'] = $all_results;
        $this->returnSuccess('完成', $result);
    }

    //考勤统计 TODO 查看指定人员的考勤情况
    function checkcount() {
        $admin = $this->islogin();
        $m_user = spClass('m_admin');
        $m_kqanay = spClass('m_kqanay');
        $m_kqerr = spClass('m_kqerr');
        $month = $this->spArgs('month', date('Y-m'));
        $mtime = strtotime($month . '-01 00:00:01');
        $month = date('Y-m', $mtime);
        $page_con['month'] = $month;
        $name = trim(urldecode(htmlspecialchars($this->spArgs('name'))));
        $con = 'status = 1 and cid = ' . $admin['cid'];
        if ($name) {
            $con .= ' and (`name` like "%' . $name . '%" or `departmentname` like "%' . $name . '%" or `positionname` like "%' . $name . '%")';
            $page_con['name'] = $name;
        }
        $results = $m_user->spPager($this->spArgs('page', 1), 20)->findAll($con, '', 'id,name,dname,pname,dir');
        foreach ($results as $k => $v) {
            $cd = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "迟到"');
            $zt = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "早退"');
            $yc = $m_kqerr->findCount('uid = ' . $v['id'] . ' and date like "' . $month . '%" and status >= 4');
            $qj = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and states like "%假%"');
            $ysb = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%"');
            $wdk = $m_kqanay->findCount('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and state = "未打卡"');
            $shi = $m_kqanay->findAll('uid = ' . $v['id'] . ' and dt like "' . $month . '%" and time > 0', '', 'dt');
            $jb = spClass('m_kqdkjb')->findCount('uid = ' . $v['id'] . ' and type = 1 and dkdt like "' . $month . '%" and (dkdt like "%21:%" or dkdt like "%22:%" or dkdt like "%23:%")');
            $r = array();
            foreach ($shi as $k1 => $v1) {
                $r[] = $v1['dt'];
            }
            $ssb = count(array_unique($r));
            $row = array('cd' => $cd, 'zt' => $zt, 'yc' => $yc, 'qj' => $qj / 2, 'ysb' => $ysb / 2, 'ssb' => $ssb, 'wdk' => $wdk,'jb'=>$jb);
            $results[$k]['kqtj'] = $row;
        }
        $this->results = $results;
        $this->pager = $m_user->spPager()->getPager();
        $this->page_con = $page_con;
        $this->month = $month;
    }


}
