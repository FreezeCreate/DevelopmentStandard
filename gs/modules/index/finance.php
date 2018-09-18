<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class finance extends IndexController {
    /*     * *****
     * 用款分类
     * ***** */
    
    function fincate(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $type = urldecode(htmlspecialchars($this->spArgs('type')));
        $con = 'del = 0';
        if($type){
            $con .= ' and type = "'.$type.'"';
            $page_con['type'] = $type;
        }
        $m_fin_cate = spClass('m_fin_cate');
        
        $results = $m_fin_cate->findAll($con,'sort asc');
        $this->results = $results;
        $this->page_con = $page_con;
    }
    
    function saveFincate(){
        $admin = $this->get_ajax_menu();
        $data['name'] = htmlspecialchars($this->spArgs('name'));
        $data['number'] = htmlspecialchars($this->spArgs('number'));
        $data['sort'] = (int)htmlspecialchars($this->spArgs('sort'));
        $data['type'] = htmlspecialchars($this->spArgs('type'));
        $id = (int)htmlentities($this->spArgs('id'));
        $m_fin_cate = spClass('m_fin_cate');
        if(empty($data['name'])){
            $this->msg_json(0, '分类名称不能为空');
        }
        $data['sort'] = empty($data['sort'])?100:$data['sort'];
        if($id){
            $re = $m_fin_cate->find(array('id'=>$id,'del'=>0));
            if($re){
                $up = $m_fin_cate->update(array('id'=>$id),$data);
                $data['id'] = $id;
                if($up){
                    $this->msg_json(2, '修改成功',$data);
                }else{
                    $this->msg_json(0, '修改失败');
                }
            }else{
                $this->msg_json(0, '分类信息有误，修改失败');
            }
        }else{
            $re = $m_fin_cate->find(array('type'=>$data['type'],'name'=>$data['name'],'del'=>0));
            if($re){
                $this->msg_json(0,'该分类已添加');
            }
            $ad = $m_fin_cate->create($data);
            if($ad){
                $this->msg_json(1, '添加成功');
            }else{
                $this->msg_json(0, '添加失败');
            }
        }
    }
    
    function delFincate(){
        $admin = $this->get_ajax_menu();
        $id = (int)htmlentities($this->spArgs('id'));
        $m_fin_cate = spClass('m_fin_cate');
        $re = $m_fin_cate->find(array('id'=>$id,'del'=>0));
        if($re){
            $del = $m_fin_cate->update(array('id'=>$id),array('del'=>1));
            if($del){
                $this->msg_json(1, '删除成功');
            }else{
                $this->msg_json(0, '删除失败');
            }
        }else{
            $this->msg_json(0, '信息不存在或已删除');
        }
    }
    
    /*     * *****
     * 用款申请
     * ***** */
    
    function funds(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id'=>17));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach($st as $k=>$v){
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_finfunds = spClass('m_finfunds');
        $m_fin_cate = spClass('m_fin_cate');
        $cate = $m_fin_cate->findAll(array('del'=>0,'type'=>'用款申请'));
        $this->cate = $cate;
        $con = 'del = 0 and shopid = '.$admin['shopid'];
        $type = urldecode(htmlspecialchars($this->spArgs('type')));
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        if($type){
            $con .= ' and type = "'.$type.'"';
            $page_con['type'] = $type;
        }
        if($uname){
            $con .= ' and uname like "%'.$uname.'%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_finfunds->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_finfunds->spPager()->getPager();
        $this->page_con = $page_con;
        
    }
    
    //统计
    function fundstat(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $model = spClass('m_finfunds');
        $con = 'del = 0 and status >= 3 and shopid = '.$admin['shopid'];
        if($start){
            $s = date('Ymd',  strtotime($start));
            $con .= ' and applydt >= '.$s;
            $page_con['start'] = $start;
        }
        if($end){
            $e = date('Ymd',  strtotime($end));
            $con .= ' and applydt <= '.$e;
            $page_con['end'] = $end;
        }
        $results = $model->findAll($con,'','id,udeptname,money,applydt');
        $udept = array();
        $month = array();
        foreach($results as $v){
            $udept[$v['udeptname']] += $v['money'];
            $mon = substr($v['applydt'], 0, 7);
            $month[$mon]['money'] += $v['money'];
            $month[$mon]['children'][$v['udeptname']] += $v['money'];
            $money += $v['money'];
        }
        //print_r($udept);die;
        $this->money = $money;
        $this->month = $month;
        $this->udept = $udept;
        $this->page_con = $page_con;
    }
    
    function voidFunds(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowVoid('finfunds', $id,$admin);
    }
    
    function delFunds(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowDel('finfunds', $id,$admin);
    }
    
    /*     * *****
     * 报销申请
     * ***** */
    
    function reimbursement(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_flow_set = spClass('m_flow_set');
        $st = $m_flow_set->find(array('id'=>16));
        $st = explode(',', $st['statusstr']);
        $status = $GLOBALS['PRO_STATUS'];
        foreach($st as $k=>$v){
            $sta = explode('|', $v);
            $status[$sta[1]]['text'] = $sta[0];
            $status[$sta[1]]['color'] = $sta[2];
        }
        $this->status = $status;
        $m_fininform = spClass('m_fininform');
        $m_fin_cate = spClass('m_fin_cate');
        $cate = $m_fin_cate->findAll(array('del'=>0,'type'=>'报销申请'));
        $this->cate = $cate;
        $con = 'del = 0 and shopid = '.$admin['shopid'];
        $type = urldecode(htmlspecialchars($this->spArgs('type')));
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        if($type){
            $con .= ' and type = "'.$type.'"';
            $page_con['type'] = $type;
        }
        if($uname){
            $con .= ' and uname like "%'.$uname.'%"';
            $page_con['uname'] = $uname;
        }
        $results = $m_fininform->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'applydt desc,id desc');
        $this->results = $results;
        $this->pager = $m_fininform->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    //统计
    function reimtat(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $model = spClass('m_fininform');
        $con = 'del = 0 and status >= 3 and shopid = '.$admin['shopid'];
        if($start){
            $s = date('Ymd',  strtotime($start));
            $con .= ' and applydt >= '.$s;
            $page_con['start'] = $start;
        }
        if($end){
            $e = date('Ymd',  strtotime($end));
            $con .= ' and applydt <= '.$e;
            $page_con['end'] = $end;
        }
        $results = $model->findAll($con,'','id,udeptname,money,applydt');
        $udept = array();
        $month = array();
        foreach($results as $v){
            $udept[$v['udeptname']] += $v['money'];
            $mon = substr($v['applydt'], 0, 7);
            $month[$mon]['money'] += $v['money'];
            $month[$mon]['children'][$v['udeptname']] += $v['money'];
            $money += $v['money'];
        }
        //print_r($udept);die;
        $this->money = $money;
        $this->month = $month;
        $this->udept = $udept;
        $this->page_con = $page_con;
    }
    
    //收款记录
    function finreceipt(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $uname = urldecode(htmlspecialchars($this->spArgs('uname')));
        $model = spClass('m_finreceipt');
        $con = 'del = 0 and shopid = '.$admin['shopid'];
        if($admin['position']!=='财务总监'){
            $con .= ' and optid = '.$admin['id'];
        }
        if($start){
            $s = date('Ymd',  strtotime($start));
            $con .= ' and date >= '.$s;
            $page_con['start'] = $start;
        }
        if($end){
            $e = date('Ymd',  strtotime($end));
            $con .= ' and date <= '.$e;
            $page_con['end'] = $end;
        }
        if($uname){
            $con .= ' and optname like "%'.$uname.'%"';
            $page_con['uname'] = $uname;
        }
        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'date desc,id desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }
    
    //统计
    function freimtat(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $start = htmlentities($this->spArgs('start'));
        $end = htmlentities($this->spArgs('end'));
        $model = spClass('m_finreceipt');
        $con = 'del = 0 and shopid = '.$admin['shopid'];
        if($start){
            $s = date('Ymd',  strtotime($start));
            $con .= ' and optdt >= '.$s;
            $page_con['start'] = $start;
        }
        if($end){
            $e = date('Ymd',  strtotime($end));
            $con .= ' and optdt <= '.$e;
            $page_con['end'] = $end;
        }
        $results = $model->findAll($con,'','id,udeptname,money,optdt');
        $udept = array();
        $month = array();
        foreach($results as $v){
            $udept[$v['udeptname']] += $v['money'];
            $mon = substr($v['applydt'], 0, 7);
            $month[$mon]['money'] += $v['money'];
            $month[$mon]['children'][$v['udeptname']] += $v['money'];
            $money += $v['money'];
        }
        //print_r($udept);die;
        $this->money = $money;
        $this->month = $month;
        $this->udept = $udept;
        $this->page_con = $page_con;
    }
    
    function delFinreceipt(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowDel('finreceipt', $id,$admin);
    }
    
    function voidReimbursement(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowVoid('fininform', $id,$admin);
    }
    
    function delReimbursement(){
        $admin = $this->get_ajax_menu();
        $id = (int)  htmlentities($this->spArgs('id'));
        $this->flowDel('fininform', $id,$admin);
    }
    
    function payroll(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_payroll = spClass('m_payroll');
        $con = ' 1 = 1';
        $month = htmlentities($this->spArgs('month'));
        $name = htmlspecialchars($this->spArgs('name'));
        if($month){
            $con .= ' and month = '.$month;
            $page_con['month'] = $month;
        }else{
            $month = date('Ym',time());
            $con .= ' and month ='.$month;
            $page_con['month'] = $month;
        }

        $bumen = htmlspecialchars($this->spArgs('bumen'));
        if(!empty($bumen)){
            $con .= ' and bumen ="'.$bumen.'"';
            $page_con['bumen'] = $bumen;
        }

        if($name){
            $con .= ' and uname like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $m_payroll->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($con,'month desc,uid asc');
        $this->results = $results;
        $this->pager = $m_payroll->spPager()->getPager();
        $this->page_con = $page_con;

        $m_department = spClass('m_department');
        $dep = $m_department->findAll();
        $this->dep = $dep;
    }
    
    function addpayroll(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_admin = spClass('m_admin');
        $user = $m_admin->findAll('dir < 6 and id != 1');
        $this->user = $user;
    }
    
    function savePayroll(){
        $result = $this->get_menu();
        $data = $this->spArgs('gongz');
        $month = $this->spArgs('month');
        $m_payroll = spClass('m_payroll');
        $con['month'] = $month;
        $payroll = $m_payroll->find($con);
        if($payroll){
            $this->msg_json(0,'当月单已添加');
        }
        $m_payroll->query("BEGIN");
        $m_admin = spClass('m_admin');
        foreach($data as $k => $v){
            $tmp_data = array();
            $adm = $m_admin->find('id='.$k);
            if(empty($adm)){
                $m_payroll->query("ROLLBACK");
                $this->msg_json(0,$v['uname'].'未找到信息');
            }
            $tmp_data['uid'] = $k;
            $tmp_data['status'] = 1;
            $tmp_data['month'] = $month;
            $tmp_data['uname'] = $adm['name'];
            $tmp_data['bumen'] = $adm['departmentname'];
            $tmp_data['positionname'] = empty($adm['positionname'])?'实习':$adm['positionname'];
            $tmp_data['gonghao'] = $adm['number'];
            $tmp_data['jiben'] = $v['jiben'] * 1;
            $tmp_data['ticheng'] = $v['ticheng'] *1;
            $tmp_data['quanqin'] = $v['quanqin'] *1;
            $tmp_data['jiangjin'] = $v['jiangjin']*1;
            $tmp_data['buzhu'] = $v['buzhu'];
            $tmp_data['chuqin'] = $v['chuqin'];
            $tmp_data['chufa'] = $v['chufa']*1;
            $tmp_data['qingjia'] = $v['qingjia']*1;
            $tmp_data['jixiao'] = $v['jixiao'] * 1;
            $tmp_data['total'] = ($v['jiben']*1 + $v['ticheng']*1 + $v['quanqin'] * 1 + $v['jiangjin'] * 1 - $v['chufa'] * 1 - $v['qingjia'] * 1 + $v['buzhu'] * 1  + $v['jixiao'] * 1);
            $add = $m_payroll->create($tmp_data);
            if($add == false){
                $m_payroll->query("ROLLBACK");
                $this->msg_json(0,$adm['name'].'工质添加失败');
            }
        }
        $m_payroll->query('COMMIT');
        $this->msg_json(0,'添加成功');
    }

    function dcPayRoll(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_payroll = spClass('m_payroll');
        $con = ' 1 = 1';
        $month = htmlentities($this->spArgs('month'));
        if($month){
        }else{
            $month = date('Ym',time());
        }
        $con .= ' and month = '.$month;
        $bumen = htmlspecialchars($this->spArgs('bumen'));
        if(!empty($bumen)){
            $con .= ' and bumne ="'.$bumen.'"';
        }
        $results = $m_payroll->findAll($con,'month desc,uid asc');
        /*'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'*/
        require_once APP_PATH.'/PHPExcel.php';
        $objPHPExcel=new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('http://semoa.sem98.com')
              ->setLastModifiedBy('http://semoa.sem98.com')
              ->setTitle('Office 2007 XLSX Document')
              ->setSubject('Office 2007 XLSX Document')
              ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
              ->setKeywords('office 2007 openxml php')
              ->setCategory('Result file');
        $i = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,'员工')
                    ->setCellValue('B'.$i,'基本工资')
                    ->setCellValue('C'.$i,'提成')
                    ->setCellValue('D'.$i,'全勤')
                    ->setCellValue('E'.$i,'餐补')
                    ->setCellValue('F'.$i,'车补')
                    ->setCellValue('G'.$i,'奖金')
                    ->setCellValue('H'.$i,'处罚')
                    ->setCellValue('I'.$i,'请假')
                    ->setCellValue('J'.$i,'实发工资')
                    ->setCellValue('K'.$i,'签字');
                    
        $i = 2;
        foreach($results as $k => $v){
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,$v['uname'])
                    ->setCellValue('B'.$i,$v['jiben'])
                    ->setCellValue('C'.$i,$v['ticheng'])
                    ->setCellValue('D'.$i,$v['quanqin'])
                    ->setCellValue('E'.$i,$v['canbu'])
                    ->setCellValue('F'.$i,$v['chebu'])
                    ->setCellValue('G'.$i,$v['jiangjin'])
                    ->setCellValue('H'.$i,$v['chufa'])
                    ->setCellValue('I'.$i,$v['qingjia'])
                    ->setCellValue('J'.$i,$v['total'])
                    ->setCellValue('K'.$i,'');
        $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('工资表');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->setActiveSheetIndex(0);
        $filename=urlencode($month.'工资表');

        /*
        *生成xlsx文件*/
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**工资表*/
     function dyPayRoll(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_payroll = spClass('m_payroll');
       $con = ' 1 = 1';
        $month = htmlentities($this->spArgs('month'));
        if($month){
        }else{
            $month = date('Ym',time());
        }
        $con .= ' and month = '.$month;
        $bumen = htmlspecialchars($this->spArgs('bumen'));
        $bumen = urldecode($bumen);
        if(!empty($bumen)){
            $con .= ' and bumen ="'.$bumen.'"';
            $this->bumen = $bumen;
        }
        $this->month = $month;
        $results = $m_payroll->findAll($con,'month desc,uid asc');
        $this->results = $results;
    }
    
    //公司资金
    function money(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_money_obj = spClass('m_money_obj');
        $m_money_log = spClass('m_money_log');
        $results = $m_money_obj->findBy('id',1);
        $con = 'pid = 1 ';
        $type = (int)htmlentities($this->spArgs('type'));
        if($type < 0){
            $con .= ' and type < 0';
        }elseif($type > 0){
            $con .= ' and type > 0';
        }
        $page_con['type'] = $type;

        $results['log'] = $m_money_log->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'dt desc');

        $this->results = $results;
        $this->pager = $m_money_log->spPager()->getPager();
        $this->page_con = $page_con;
    }

    
    //奖金管理
    function bonus(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $model = spClass('m_department');
        $con = 'summoney > 0';
        $name = htmlspecialchars($this->spArgs('name'));
        if(!empty($name)){
            $con .= ' and department like "%'.$name.'%"';
            $page_con['name'] = $name;
        }
        $results = $model->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'money desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function bonuslog(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $id = (int)htmlentities($this->spArgs('id'));
        $m_money_obj = spClass('m_department');
        $m_money_log = spClass('m_department_bill');
        $results = $m_money_obj->findBy('id',$id);
        $con = 'did = '.$id;
        $results['log'] = $m_money_log->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'adddt desc');
        $this->results = $results;
        $this->pager = $m_money_log->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function usbonus(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_money_obj = spClass('m_department');
        $m_department_bill = spClass('m_department_bill');
        $results = $m_money_obj->findBy('id',$admin['departmentid']);
        $con = 'did = '.$admin['departmentid'];
        $bill = $m_department_bill->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'adddt desc');
        $this->results = $results;
        $this->pager = $m_department_bill->spPager()->getPager();
        $this->page_con = $page_con;
        $this->bill = $bill;
    }
    
    function saveBonuslog(){
        $admin = $this->get_ajax_menu();
        $id = (int)$this->spArgs('id');
     
        $data['money'] = htmlentities($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $data['type'] = (int)$this->spArgs('type');
        $m_money_obj = spClass('m_department');
        $m_money_log = spClass('m_department_bill');
        if(empty($data['money'])){
            $this->msg_json(0, '请填写金额');
        }
        $data['did'] = $id;
        $data['adddt'] = date('Y-m-d H:i:s');
        $data['status'] = 4;
        $con['id'] = $id;
        $tmp = $m_money_obj->find($con);
        if(!$tmp){
            $this->msg_json(0,'信息错误');
        }else{
            $data['department'] = $tmp['department'];
        }

        $m_money_log->query('START TRANSACTION');
        $ad = $m_money_log->create($data);
        if($ad){
            if($data['type'] == 1){
                $money = abs($data['money']);
                $up2 = $m_money_obj->incrField($con,'summoney',$money);
            }else{
                $money = abs($data['money']);
                $up2 = $m_money_obj->incrField($con,'money',$money);
            }
            
            
            if($up2 == false){
                $m_money_log->query('ROLLBACK');
                $this->msg_json(0, '操作失败1');
            }else{
                $m_money_log->query('COMMIT');
                $this->msg_json(1, '操作成功',$data);
            }
        }else{
            $m_money_log->query('ROLLBACK');
            $this->msg_json(0, '操作失败2');
        }
    }
    
    //罚款
    function gruel(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_money_obj = spClass('m_money_obj');
        $m_money_log = spClass('m_money_log');
        $results = $m_money_obj->findBy('id',2);
        $type = (int)  htmlentities($this->spArgs('type'));
        $con = 'st = 0 and pid = 2';
        if(!empty($type)){
            $con .= ' and type = '.$type;
            $page_con['type'] = $type;
        }
        $results['log'] = $m_money_log->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'dt desc');
        $this->results = $results;
        $this->pager = $m_money_log->spPager()->getPager();
        $this->page_con = $page_con;
        
    }
    
    function saveGruel(){
        $admin = $this->get_ajax_menu();
        $data['uid'] = (int)$this->spArgs('uid');
        $data['type'] = (int)$this->spArgs('type');
        $data['money'] = htmlentities($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $m_money_obj = spClass('m_money_obj');
        $m_money_log = spClass('m_money_log');
        $user = spClass('m_admin')->find(array('id'=>$data['uid']));
        if(empty($user)&&$data['type']==1){
            $this->msg_json(0, '请选择处罚人');
        }else{
            $data['uname'] = $user['name'];
        }
        if(empty($data['money'])){
            $this->msg_json(0, '请填写金额');
        }
        $data['pid'] = 2;
        $data['dt'] = date('Y-m-d H:i:s');
        $m_money_log->query('START TRANSACTION');
        $ad = $m_money_log->create($data);
        if($ad){
            $money = $data['money'];
            $up = $m_money_obj->upmoney(2,$money,$data['type']);
            if($up == false){
                $m_money_log->query('ROLLBACK');
                $this->msg_json(0, '操作失败');
            }else{
                $data['id'] = $ad;
                $m_money_log->query('COMMIT');
                $this->msg_json(1, '操作成功',$data);
            }
        }else{
            $this->msg_json(0, '操作失败');
        }
    }

    //押金管理
    function deposit(){
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
        $m_money_obj = spClass('m_money_obj');
        $m_money_log = spClass('m_money_log');
        $results = $m_money_obj->findBy('id',3);
        $type = (int)  htmlentities($this->spArgs('type'));
        $con = 'pid = 3';
        if(!empty($type)){
            $con .= ' and type = '.$type;
            $page_con['type'] = $type;
        }
        $results['log'] = $m_money_log->spPager($this->spArgs("page", 1), PAGE_NUM)->findAll($con,'dt desc');
        $this->results = $results;
        $this->pager = $m_money_log->spPager()->getPager();
        $this->page_con = $page_con;
        
    }
    
    function saveDeposit(){
        $admin = $this->get_ajax_menu();
        $data['uid'] = (int)$this->spArgs('uid');
        $data['type'] = (int)$this->spArgs('type');
        $data['money'] = htmlentities($this->spArgs('money'));
        $data['explain'] = htmlspecialchars($this->spArgs('explain'));
        $m_money_obj = spClass('m_money_obj');
        $m_money_log = spClass('m_money_log');
        $user = spClass('m_admin')->find(array('id'=>$data['uid']));
        if(empty($user)){
            $this->msg_json(0, '请选择相关人员');
        }else{
            $data['uname'] = $user['name'];
        }
        if(empty($data['money'])){
            $this->msg_json(0, '请填写金额');
        }
        $data['pid'] = 3;
        $data['dt'] = date('Y-m-d H:i:s');
        $m_money_log->query('START TRANSACTION');
        $ad = $m_money_log->create($data);
        if($ad){
            $money = $data['money'];
            $up = $m_money_obj->upmoney(3,$money,$data['type']);
            if($up == false){
                $m_money_log->query('ROLLBACK');
                $this->msg_json(0, '操作失败');
            }else{
                $data['id'] = $ad;
                $m_money_log->query('COMMIT');
                $this->msg_json(1, '操作成功',$data);
            }
        }else{
            $this->msg_json(0, '操作失败');
        }
    }
    
}   
