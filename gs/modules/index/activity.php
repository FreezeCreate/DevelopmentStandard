<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class activity extends IndexController {
    
    /*****公司活动管理****/
    function inside(){
    	$result = $this->get_menu();
    	$this->menu = $result['menu'];
        $admin = $result['admin'];
       	$m_activity = spClass('m_activity');

       	$where = 'del = 0';
       	$name = htmlspecialchars($this->spArgs('name'));
       	if(!empty($name)){
       		$where .= ' and name like "%'.$name.'%"';
       	}
        
       	$results = $m_activity->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
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
        $this->pager = $m_activity->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function welfare(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
      $admin = $result['admin'];
      $m_activity = spClass('m_activity_w');
      $where = 'del = 0';
      $name = htmlspecialchars($this->spArgs('name'));
      if(!empty($name)){
        $where .= ' and name like "%'.$name.'%"';
      }
      $results = $m_activity->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
      $this->results = $results;
      $this->pager = $m_activity->spPager()->getPager();
      $this->page_con = $page_con;
    }

     function insides(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
        $admin = $result['admin'];
        $m_activity = spClass('m_activity');

        $where = 'del = 0';
        $name = htmlspecialchars($this->spArgs('name'));
        if(!empty($name)){
          $where .= ' and name like "%'.$name.'%"';
        }
        
        $results = $m_activity->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
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
        $this->pager = $m_activity->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function welfares(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
      $admin = $result['admin'];
      $m_activity = spClass('m_activity_w');
      $where = 'del = 0';
      $name = htmlspecialchars($this->spArgs('name'));
      if(!empty($name)){
        $where .= ' and name like "%'.$name.'%"';
      }
      $results = $m_activity->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,$order);
      $this->results = $results;
      $this->pager = $m_activity->spPager()->getPager();
      $this->page_con = $page_con;
    }
    
    function delInside(){
        $admin = $this->get_ajax_menu();
        $model = spClass('m_activity');
        $id = htmlentities($this->spArgs('id'));
        $re = $model->update(array('id'=>$id),array('del'=>1));
    }
}
