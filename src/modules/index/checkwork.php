
<?php

/**
 * Description of checkwork
 * 考勤管理
 * @author IndexController
 */
class checkwork extends IndexController {

    //考勤参数
    function checkdata() {
        $user = $this->islogin();
        $m_kqsjgz = spClass('m_kqsjgz');
        $results = $m_kqsjgz->findAll('pid = 0 and cid = '.$user['cid'], 'sort asc');
        foreach ($results as $k => $v) {
            $results[$k]['children'] = $m_kqsjgz->findAll('pid = ' . $v['id'].' and cid = '.$user['cid'], 'sort asc');
        }
        $this->results = $results;
    }

    //考勤记录
    function checkrecord() {
        $user = $this->islogin();
        $model = spClass('m_kqdkjl');
        $start = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'a.cid = ' . $user['cid'];
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
            $page_con['name'] = $name;
        }
        $sql = 'select a.*,b.dname,b.name from '.DB_NAME.'_kqdkjl as a left outer join '.DB_NAME.'_user as b on a.uid = b.id where ' . $con . ' order by dkdt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //请假记录
    function leaverecord() {
        $user = $this->islogin();
        $model = spClass('m_kqinfo');
        $start = htmlspecialchars($this->spArgs('start'));
        $end = htmlspecialchars($this->spArgs('end'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $con = 'a.cid = ' . $user['cid'];
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
            $page_con['name'] = $name;
        }
        $sql = 'select a.*,b.name from '.DB_NAME.'_kqinfo as a left outer join '.DB_NAME.'_user as b on a.uid = b.id where ' . $con . ' order by applydt desc';
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findSql($sql);
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    //考勤统计
    function checkcount() {
        $user = $this->islogin();
        $m_user = spClass('m_user');
        $m_kqanay = spClass('m_kqanay');
        $m_kqerr = spClass('m_kqerr');
        $month = $this->spArgs('month', date('Y-m'));
        $mtime = strtotime($month . '-01 00:00:01');
        $month = date('Y-m', $mtime);
        $page_con['month'] = $month;
        $name = trim(urldecode(htmlspecialchars($this->spArgs('name'))));
        $con = 'status = 1 and cid = ' . $user['cid'];
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

    //编辑考勤参数
    function bjwork() {
        
    }

    //新增奖惩处罚
    function addwork() {
        
    }

    //打卡记录
    function cardjl() {
        
    }

}
