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
        
        $con = 'del = 0 and nowcheckid like "%,'.$admin['id'].',%"';
        
        $results = $m_flow_bill->findAll($con,'applydt desc,id desc', '', 10);
        foreach ($results as $_k => $_v){
            $check_data = spClass('m_'.$_v['table'].'')->find(array('id' => $_v['tid']));
            if (empty($check_data)){
                unset($results[$_k]);
                $limit = ($_k + 1).',1';
                $sql = 'select * from '.DB_NAME.'_flow_bill order by applydt desc,id desc limit '.$limit.'';
                $new_re = $m_flow_bill->findSql($sql);
                $results[$_k] = $new_re[0];
            }
            //解决Linux环境大小写不兼容的问题
            $model_name = spClass('m_flow_set')->find(array('id' => $_v['modelid']), '', 'model');
            $results[$_k]['table'] = $model_name['model'];
        }
        $results = array_values($results);
        foreach ($results as $k => $v){
            $did  = $m_admin->find(array('id' => $v['uid']), '', 'did');
            $part = $m_depart->find(array('id' => $did['did'], 'pid' => $admin['cid']), '', 'name');
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

