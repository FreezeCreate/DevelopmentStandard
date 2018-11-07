<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class train extends IndexController {
    
    /*****培训记录****/
    function index(){
    	$result = $this->get_menu();
    	$this->menu = $result['menu'];
        $admin = $result['admin'];
       	$m_train = spClass('m_train');

       	$where = 'del = 0';
       	$name = htmlspecialchars($this->spArgs('name'));

        $start = htmlspecialchars($this->spArgs('start'));
        if(!empty($start)){
          $where .= ' and statdt >="'.$start.'"';
          $page_con['start'] = $start;
        }
        $end = htmlspecialchars($this->spArgs('end'));
        if(!empty($end)){
          $where .= ' and statdt <="'.$end.'"';
          $page_con['end'] = $end;
        }
       	if(!empty($name)){
       		$where .= ' and name like "%'.$name.'%"';
          $page_con['name'] = $name;
       	}
        
       	$results = $m_train->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
        $m_file = spCLass('m_file');
        $fids = '';
        foreach($results as $k => $v){
            if(!empty($v['files'])){
              $fids .= ','.$v['files'];
              $results[$k]['files'] = explode(',',$v['files']);
            }
        }
        $fids = trim($fids,',');
        if(!empty($fids)){
          $files = $m_file->findAll('id in ('.$fids.')','','id,filename');
          foreach($files as $k=>$v){
              $file[$v['id']] = $v;
          }
          $this->files = $file;
        }

        $this->results = $results;
        $this->pager = $m_train->spPager()->getPager();
        $this->page_con = $page_con;
    }
    /*****培训记录****/
    function trainRecord(){
    	$result = $this->get_menu();
    	$this->menu = $result['menu'];
        $admin = $result['admin'];
       	$m_train = spClass('m_train');

       	$where = 'del = 0';
       	$name = htmlspecialchars($this->spArgs('name'));

        $start = htmlspecialchars($this->spArgs('start'));
        if(!empty($start)){
          $where .= ' and statdt >="'.$start.'"';
          $page_con['start'] = $start;
        }
        $end = htmlspecialchars($this->spArgs('end'));
        if(!empty($end)){
          $where .= ' and statdt <="'.$end.'"';
          $page_con['end'] = $end;
        }
       	if(!empty($name)){
       		$where .= ' and name like "%'.$name.'%"';
          $page_con['name'] = $name;
       	}
        
       	$results = $m_train->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
        $m_file = spCLass('m_file');
        $fids = '';
        foreach($results as $k => $v){
            if(!empty($v['files'])){
              $fids .= ','.$v['files'];
              $results[$k]['files'] = explode(',',$v['files']);
            }
        }
        $fids = trim($fids,',');
        if(!empty($fids)){
          $files = $m_file->findAll('id in ('.$fids.')','','id,filename');
          foreach($files as $k=>$v){
              $file[$v['id']] = $v;
          }
          $this->files = $file;
        }

        $this->results = $results;
        $this->pager = $m_train->spPager()->getPager();
        $this->page_con = $page_con;
    }

   
  
}
