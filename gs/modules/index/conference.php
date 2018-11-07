<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class conference extends IndexController {
    
    function index(){
    	$result = $this->get_menu();
    	$this->menu = $result['menu'];
        $admin = $result['admin'];
       	$model = spClass('m_conference');
       	$where = 'type = 1';
       	$start = htmlspecialchars($this->spArgs('start'));
       	if(!empty($start)){
            $where .= ' and statdt >='.date('YmdHis',strtotime($start));
            $page_con['start'] = $start;
       	}
        $end = htmlspecialchars($this->spArgs('end'));
        if(!empty($end)){
          $where .= ' and enddt >='.date('YmdHis',strtotime($end));
            $page_con['end'] = $end;
        }
        $name = htmlspecialchars($this->spArgs('name'));
        if(!empty($end)){
          $where .= ' and name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }

       	$results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'statdt desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }

    function strategic(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
        $admin = $result['admin'];
        $model = spClass('m_conference');
        $where = 'type = 100 and del = 0';
        $start = htmlspecialchars($this->spArgs('start'));
        if(!empty($start)){
          $where .= ' and statdt >='.date('YmdHis',strtotime($start));
            $page_con['start'] = $start;
        }
        $end = htmlspecialchars($this->spArgs('end'));
        if(!empty($end)){
          $where .= ' and enddt >='.date('YmdHis',strtotime($end));
            $page_con['end'] = $end;
        }
        $name = htmlspecialchars($this->spArgs('name'));
        if(!empty($end)){
          $where .= ' and name like "%'.$name.'%"';
            $page_con['name'] = $name;
        }

        $results = $model->spPager($this->spArgs('page', 1), PAGE_NUM)->findAll($where,'statdt desc,id desc');
        $this->results = $results;
        $this->pager = $model->spPager()->getPager();
        $this->page_con = $page_con;
    }


    function mRoom(){
      $result = $this->get_menu();
      $this->menu = $result['menu'];
      $admin = $result['admin'];
      $model = spClass('m_conf_room');
      $result = $model->findAll();
      $this->results = $result;
      $m_shop = spClass('m_shop');
      $shop = $m_shop->findAll();
      $this->shop_count = count($shop);
      if(count($shop) == 1){
        foreach($shop as $k => $v){
          $tmp = $v;
        }
        $this->shop = $tmp;
      }else{
        $this->shop = $shop;
      }
      
    }




    function addUpRoom(){
      $admin = $this->get_ajax_menu();
      $m_conf_room = spClass('m_conf_room');
      $id = (int)htmlentities($this->spArgs('id'));
      $name = htmlspecialchars($this->spArgs('name'));
      $shopid = (int)htmlentities($this->spArgs('shopid'));
      $m_shop = spClass('m_shop');

      if(empty($name)){
          $this->msg_json(0,'请输入会议室名称');
      }else{
          $data['name'] = $name;
      }
      if(empty($shopid)){
          $this->msg_json(0,'请选择所属公司');
      }else{
          $shop = $m_shop->find('id='.$shopid);
          if(empty($shop)){
            $this->msg_json(0,'未找到公司信息');
        }
        $data['shopid'] = $shop['id'];
        $data['shopname'] = $shop['shopname'];
      }
      $data['optname'] = $admin['name'];
      $data['optdt'] = date('Y-m-d H:i:s',time());

      if($id){
        $con['id'] = $id;
        $tmp = $m_conf_room->find($con);
        if($tmp){
          $where = 'id <> '.$id.' and shopid ='.$shopid.' and name = "'.$name.'"';
          $tmp = $m_conf_room->find($where);
          if($tmp){
            $this->msg_json(0,'该公司已有该会议室信息');
          }else{
            $up = $m_conf_room->update($con,$data);
            if($up){
              $this->msg_json(1,'更新成功');
            }else{
              $this->msg_json(0,'更新失败');
            }
          }
        }else{
          $this->msg_json(0,'未找到会议信息');
        }
      }else{
      
        $con['name'] = $name;
        $con['shopid'] = $data;
        $tmp = $m_conf_room ->find($con);
        if($tmp){
          $this->msg_json(0,'该公司已有该会议室信息');
        }else{

          $add = $m_conf_room->create($data);
          if($add){
            $this->msg_json(1,'添加成功');
          }else{
            $this->msg_json(0,'添加失败');
          }
        }
      }
    }

    function delRoom(){
      $admin = $this->get_ajax_menu();
      $id = (int)$this->spArgs('id');
      if(empty($id)){
        $this->msg_json(0,'信息错误');
       }
       $con['id'] = $id;
       $del = spClass('m_conf_room')->delete($con);
        if($del){
          $this->msg_json(1,'删除完成');
        }else{
          $this->msg_json(0,'删除失败');
        }
    }

    function delConf(){
       $admin = $this->get_ajax_menu();
       $id = (int)$this->spArgs('id');
       if(empty($id)){
        $this->msg_json(0,'信息错误');
       }
       $con['id'] = $id;
       $del = spClass('m_conference')->delete($con);
      if($del){
        $this->msg_json(1,'删除完成');
      }else{
        $this->msg_json(0,'删除失败');
      }
    }

    function delConf2(){
       $admin = $this->get_ajax_menu();
       $id = (int)$this->spArgs('id');
       $cause = htmlspecialchars($this->spArgs('cause'));
       if(empty($cause)){
        $this->msg_json(0,'填写删除原因');
       }else{
        $data['delContent'] = $cause;
       }
       if(empty($id)){
        $this->msg_json(0,'信息错误');
       }
       $con['id'] = $id;
       $data['del'] = 1;
       $data['optname'] = $admin['name'];
       $data['optdt'] = date('Y-m-d H:i:s'); 
       $del = spClass('m_conference')->update($con,$data);
      if($del){
        $this->msg_json(1,'删除完成');
      }else{
        $this->msg_json(0,'删除失败');
      }
    }
  
}
