<?php

class budgetcount extends AppController
{

    /**
     * 因采购货物时，款项分期，因此每次需填写支付申请表,付款则在custpay_mon中查询
     * 预算管理折线图
     */
    function budgetLine()
    {
        $admin = $this->islogin();
        $m_pay = spClass('m_custpay_mon');
        //预算自己填写budge里
        
        //部门预算循环列表
        $budge  = spClass('m_budge')->findAll('cid='.$admin['cid'].' and del=0');
        $depart = $depart_mon = $count_mon = $will_mon = $sum_mon = array();
        $sum    = $will = 0;
        foreach ($budge as $b_k => $b_v){
            $depart_mon[] = $m_pay->findAll('cid='.$admin['cid'].' and did='.$b_v['did']);
            //计算该部门的实际支出情况
            foreach ($depart_mon[$b_k] as $mon_v){
                $sum  = $sum + $mon_v['paymoney'];
            }
            $count_mon[]  = $sum;
            $will         = $b_v['budge_money'] - $sum;
            $will_mon[]   = $will;
            $sum_mon[]    = (int)$b_v['budge_money'];
            
            $depart[]     = $b_v['dname'];
            $sum          = 0;
            $will         = 0;
        }
        
        $result['sum_mon']   = $sum_mon;  //预算支出情况
        $result['count_mon'] = $count_mon;  //实际支出情况
        $result['will_mon']  = $will_mon;   //差距
        
        $result['depart']    = $depart; //所有存在预算的部门
//         $result['budge']     = $budge;  //预算支出情况
        
        $this->returnSuccess('成功', $result);
        //各部门实际支出情况，无收益情况
    }
    
    
    
    
}

