<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class culsys extends IndexController {
    
    /*****文化****/
    function culture(){
    	$result = $this->get_menu();
    	$this->menu = $result['menu'];
      $admin = $result['admin'];
     	$model = spClass('m_culsys');

     	$where = 'del = 0';
     	$name = htmlspecialchars($this->spArgs('name'));
     	if(!empty($name)){
     		$where .= ' and name like "%'.$name.'%"';
     	}
      
     	$results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
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
        $files = $m_file->findAll('id in ('.$fids.')');
        $this->files = $files;
      }
      $this->results = $results;
      $this->pager = $model->spPager()->getPager();
      $this->page_con = $page_con;
  }


  function system(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
      $admin = $result['admin'];
      $model = spClass('m_culsys');

      $where = 'del = 0';
      $name = htmlspecialchars($this->spArgs('name'));
      if(!empty($name)){
        $where .= ' and name like "%'.$name.'%"';
      }
      
      $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
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
        $files = $m_file->findAll('id in ('.$fids.')');
        $this->files = $files;
      }
      $this->results = $results;
      $this->pager = $model->spPager()->getPager();
      $this->page_con = $page_con;
  }

  function management(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
      $admin = $result['admin'];
      $model = spClass('m_culsys');

      $where = 'del = 0';
      $name = htmlspecialchars($this->spArgs('name'));
      if(!empty($name)){
        $where .= ' and name like "%'.$name.'%"';
      }
      
      $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
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
        $files = $m_file->findAll('id in ('.$fids.')');
        $this->files = $files;
      }
      $this->results = $results;
      $this->pager = $model->spPager()->getPager();
      $this->page_con = $page_con;
  }
    
}
