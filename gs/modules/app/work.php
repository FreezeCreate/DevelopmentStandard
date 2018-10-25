<?php

class work extends AppController
{
    
    /**
     * 待办事项列表
     */
    function upcoming()
    {
        $admin = $this->islogin();
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_set  = spClass('m_flow_set');
        $m_admin = spClass('m_admin');
        $m_depart = spClass('m_department');
        $sid  = (int)htmlspecialchars($this->spArgs('sid'));
        $applydt = htmlentities($this->spArgs('applydt'));
        $name = urldecode(htmlspecialchars($this->spArgs('name')));
        $re = $m_flow_set->findAll();
        foreach ($re as $k => $v) {
            $set[$v['type']][] = $v;
        }
        $this->set = $set;
        $con = 'del = 0 and nowcheckid like "%,'.$admin['id'].',%"';
        if($sid){
            $con .= ' and modelid = '.$sid;
            $page_con['sid'] = $sid;
        }
        if($applydt){
            $con .= ' and applydt = "'.$applydt.'"';
            $page_con['applydt'] = $applydt;
        }
        if($name){
            $con .= ' and (uname like "%'.$name.'%" or udeptname like "%'.$name.'%")';
            $page_con['name'] = $name;
        }
        
        $results = $m_flow_bill->findAll($con,'applydt desc,id desc', '', 10);
        foreach ($results as $k => $v){
            $did  = $m_admin->find('id='.$v['uid'].'', '', 'did');
            $part = $m_depart->find('id='.$did['did'].' and pid='.$admin['cid'].'', '', 'name');
            $results[$k] = $v;
            $results[$k]['depart'] = $part['name'];
        }
        $result['results'] = $results;
        $this->returnSuccess('成功',$result);
    }
    
    /**
     * 订单列表
     */
    function orders()
    {
        $admin = $this->islogin();
        $model = spClass('m_orders');
        $where = 'del = 0 and comid = '.$admin['cid'];
        $results = $model->findAll($where,'adddt desc', '', 10);
        
        $result['results'] = $results;
        $this->returnSuccess('成功', $result);
    }
    
    /**
     * 通知公告列表
     */
    function infoLst()
    {
        $admin     = $this->islogin();
        $con       = 'del = 0 and cid = ' . $admin['cid'];
        $model     = spClass('m_infor');
        
        $results = $model->findAll($con, 'date desc,id desc', '', 7);
        $result['results'] = $results;
        
        $this->returnSuccess('成功', $result);
    }
    
}

