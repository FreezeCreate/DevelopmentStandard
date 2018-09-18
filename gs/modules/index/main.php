<?php

/**
 * Description of main
 *
 * @author IndexController
 */
class main extends IndexController {

    function index() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
    }
    
    function myinfo() {
        $admin = $this->get_ajax_menu();
        $admin['dirname'] = $GLOBALS['USER_DIR'][$admin['dir']];
        $this->msg_json(1, '', $admin);
    }

    function bench() {
        $result = $this->get_menu();
        $this->menu = $result['menu'];
        $admin = $result['admin'];
        $this->admin = $admin;
    }

    //待办提醒
    function getProcess() {
        $type = (int) htmlentities($this->spArgs('type'));
        $admin = $this->get_ajax_menu();
        //$admin = spClass('m_admin')->find(array('id'=>57));
        if ($type == 2) {
            $result = spClass('m_flow_todos')->findAll('uid = ' . $admin['id'], 'isread asc,adddt desc', 'modelid,tid,table,title,adddt');
            $model = spClass('m_flow_set')->find(array('id' => $v['modelid']), '', 'model');
            $results[] = array(
                'title' => $v['title'],
                'dt' => $v['adddt'],
                'url' => spUrl('apply', $model['model'], array('id' => $v['tid'])),
            );
        } else {
            $result = spClass('m_flow_bill')->findAll('del = 0 and nowcheckid like "%' . $admin['id'] . '%"', 'addtime desc', 'modelid,tid,table,summary,applydt');
            foreach ($result as $k => $v) {
                $model = spClass('m_flow_set')->find(array('id' => $v['modelid']), '', 'model');
                $results[] = array(
                    'title' => $v['summary'],
                    'dt' => $v['applydt'],
                    'url' => spUrl('apply', $model['model'], array('id' => $v['tid'])),
                );
            }
        }

        echo json_encode(array('results' => $results));
        exit();
    }

    //请假外出
    function getKqinfo() {
        $type = (int) htmlentities($this->spArgs('type'));
        $admin = $this->get_ajax_menu();
        //$admin = spClass('m_admin')->find(array('id'=>57));
        if ($type == 2) {
            $results = spClass('m_kqinfo')->findAll('del = 0', 'applydt desc', 'id,uname,applydt', '10');
        } else {
            $results = spClass('m_kqgoout')->findAll('del = 0', 'applydt desc', 'id,uname,applydt', '10');
        }
        echo json_encode(array('results' => $results));
        exit();
    }

    function login() {
        $username = htmlspecialchars($this->spArgs('username'));
        $password = htmlspecialchars($this->spArgs('password'));
        $code = htmlspecialchars($this->spArgs('code'));
        if (isset($_SESSION['admin'])) {
            header('Location:' . spUrl('main', 'index'));
        }
        if ($_POST) {
            $ip = Common::getIp();
            $data = array(
                'ip' => $ip,
                'time' => date('Y-m-d H:i:s'),
            );
            if (!empty($username) && !empty($password)) {
                $_COOKIE['admin']['username'] = $username;
                $model_admin = spClass('m_admin');
                $result = $model_admin->find(array('username' => $username, 'status' => 1));
                if ($result['password'] == md5(md5($password))) {
                    $_SESSION['admin'] = $result;
                    unset($_SESSION['code']);
                    $data['name'] = $result['name'];
                    $data['remark'] = '登录成功';
                    spClass('m_login')->create($data);
                    $this->msg_json(1, '登录成功');
                } else {
                    $data['name'] = $result['name'];
                    $data['remark'] = '登录失败：' . $username;
                    spClass('m_login')->create($data);
                    $this->msg_json(0, '用户名或者密码错误');
                }
            }
        }
    }

    function editMyinfo() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $data['phone'] = htmlspecialchars($this->spArgs('phone'));
        $data['trumpet'] = htmlspecialchars($this->spArgs('trumpet'));
        $data['idCard'] = htmlspecialchars($this->spArgs('idCard'));
        $data['birthday'] = htmlspecialchars($this->spArgs('birthday'));
        $data['email'] = htmlspecialchars($this->spArgs('email'));
        $data['QQ'] = htmlspecialchars($this->spArgs('QQ'));
        if (empty($data['phone'])) {
            $this->msg_json(0, '手机号不能为空');
        }
        $up = $m_admin->update(array('id' => $admin['id']), $data);
        if ($up) {
            $this->msg_json(1, '修改成功');
        } else {
            $this->msg_json(0, '修改失败');
        }
    }

    function logout() {
        unset($_SESSION['admin']);
        $this->success('退出成功', spUrl('main', 'login'));
    }

    function edit_password() {
        $admin = $this->get_ajax_menu();
        $password = $this->spArgs('password');
        $new_password = $this->spArgs('new_password');
        $confirm_password = $this->spArgs('confirm_password');
        if (empty($password)) {
            $this->msg_json(0, "原密码不能为空！");
        }
        if (empty($new_password)) {
            $this->msg_json(0, "新密码不能为空！");
        }
        if ($new_password != $confirm_password) {
            $this->msg_json(0, "两次密码输入不一致");
        }
        $model = spClass("m_admin");
        $con = array("id" => $admin["id"]);
        $re = $model->find($con);
        if ($re) {
            if ($re["password"] != md5(md5($password))) {
                $this->msg_json(0, "原密码错误！");
            }
        }
        $data = array('password' => md5(md5($new_password)));
        $r = $model->update($con, $data);
        if ($r) {
            $this->msg_json(1, '修改成功，下次请用新密码登录');
        } else {
            $this->msg_json(0, '修改失败');
        }
    }

    /*     * **************
     * 下载文件
     * ************** */

    function download() {
        $m_file = spClass('m_file');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_file->find(array('id' => $id));
        $filename = APP_PATH . $result['filepath'];
        $file = fopen($filename, "r");
        ob_get_clean();
        ob_clean();
        header("Content-Type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . filesize($filename));
        header("Content-Disposition: attachment; filename=" . $result['filename']);
        echo fread($file, filesize($filename));
        fclose($file);
    }

    function yulan() {
        $m_file = spClass('m_file');
        $id = (int) htmlspecialchars($this->spArgs('id'));
        $result = $m_file->find(array('id' => $id));

        if ($result['fileext'] == 'doc' || $result['fileext'] == 'docx') {
            $filename = APP_PATH . $result['filepath'];
            $lastfnamepdf = APP_PATH . '/tmp/1504676991634912.pdf';
            $this->word2pdf($filename, $lastfnamepdf);
            $file = fopen($lastfnamepdf, "r"); // 打开文件
            // 输入文件标签
            Header("Content-type: application/pdf");
            //       Header("filename:" . $file_name);
            // 输出文件内容
            echo fread($file, filesize($lastfnamepdf));
            fclose($file);
        } else if ($result['fileext'] == 'xlsx') {
            $ttt = APP_PATH . $result['filepath'];
            $this->excel2($ttt, $result['id']);
        } else if ($result['fileext'] == 'xls') {
            $ttt = APP_PATH . $result['filepath'];
            $this->excel2($ttt, $result['id']);
        } else {
            $this->jump($result['filepath']);
        }
    }

    function excel2($filename, $id) {
        set_time_limit(0);
        require_once APP_PATH . '/PHPExcel/IOFactory.php';
        $fileType = PHPExcel_IOFactory::identify($filename); //文件名自动判断文件类型
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($filename);
        $savePath = APP_PATH . '/uploads/file/xls' . $id . '.html'; //这里记得将文件名包含进去
        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
        $objWriter->setSheetIndex(0); //可以将括号中的0换成需要操作的sheet索引
        $objWriter->save($savePath);
        echo "<script>window.location.href='/uploads/file/xls" . $id . ".html';</script>";
    }

    function hqdaoruRow($filename, $encode = 'utf-8') {
        header("Content-Type:text/html;charset=utf-8");
        require_once APP_PATH . '/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $sheetCount = $objPHPExcel->getSheetCount();
        $excelData = array();
        for ($i = 0; $i < $sheetCount; $i++) {
            $data = $objPHPExcel->getSheet($i)->toArray();
            foreach ($data as $k => $v) {
                $excelData[] = $v;
            }
        }

        var_dump($excelData);
    }

    function word2pdf($lastfnamedoc, $lastfnamepdf) {
        $word = new COM("Word.Application") or die("Could not initialise Object.");
        $word->Visible = 0;
        $word->DisplayAlerts = 0;
        $word->Documents->Open($lastfnamedoc);
        $word->ActiveDocument->ExportAsFixedFormat($lastfnamepdf, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
        $word->Quit(false);
    }

    /*     * ****************
     * 获取员工列表
     * **************** */

    function getUsers() {
        $admin = $this->get_ajax_menu();
        $m_company = spClass('m_company');
        $m_department = spClass('m_department');
        $m_admin = spClass('m_admin');
        if ($admin['cid'] == 1) {
            $results = $m_company->findAll('', '', 'id,name');
        } else {
            $results = $m_company->findAll(array('id' => $admin['cid']), '', 'id,name');
        }
        foreach ($results as $k => $v) {
            $results[$k]['children'] = $m_department->findAll(array('pid' => $v['id']), '', 'id,name,pid');
            foreach ($results[$k]['children'] as $k1 => $v1) {
                $results[$k]['children'][$k1]['name'] = $v1['name'];
                $results[$k]['children'][$k1]['children'] = $m_admin->findAll(array('did' => $v1['id'], 'hide' => 0), '', 'id,name,dname,pname,cname');
            }
        }
        $this->msg_json(2, '获取成功', $results);
    }

    /*     * ****************
     * 获取会员列表
     * **************** */

    function getUser() {
        $admin = $this->get_ajax_menu();
        $pid = (int) htmlspecialchars($this->spArgs('pid', 0));
        $m_user = spClass('m_user');
        $results = $m_user->findAll('pid = ' . $pid, '', 'id,name,phone');
        if ($results) {
            $this->msg_json(1, '获取成功', $results);
        } else {
            $this->msg_json(0, '暂无数据');
        }
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function getDepartment() {
        $admin = $this->get_ajax_menu();
        $m_company = spClass('m_company');
        $m_department = spClass('m_department');
        if ($admin['id'] == 1) {
            $company = $m_company->findAll();
            foreach ($company as $v) {
                $re = $m_department->findAll(array('pid' => $v['id']), '', 'id,name');
                foreach ($re as $v1) {
                    $results[] = array(
                        'id' => $v1['id'],
                        'name' => '【' . $v['name'] . '】' . $v1['name'],
                    );
                }
            }
        } else {
            $results = $m_department->findAll(array('pid' => $admin['cid']), '', 'id,name');
        }
        $this->msg_json(1, '获取成功', $results);
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function findCompany() {
        $admin = $this->get_ajax_menu();
        $m_company = spClass('m_company');
        $con = $admin['id']==1?'':'id = '.$admin['cid'];
        $company = $m_company->findAll($con);
        $this->msg_json(1, '获取成功', $company);
    }

    /*     * ****************
     * 获取部门列表
     * **************** */

    function findDepartment() {
        $admin = $this->get_ajax_menu();
        $m_department = spClass('m_department');
        $id = (int) htmlentities($this->spArgs('id'));
        $results = $m_department->findAll(array('pid' => $id));
        $this->msg_json(1, '获取成功', $results);
    }

    function findPonsenel() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $id = (int) htmlentities($this->spArgs('id'));
        $results = $m_admin->findAll(array('did' => $id));
        $this->msg_json(1, '获取成功', $results);
    }

    /*     * ****************
     * 获取职位列表
     * **************** */

    function getPosition() {
        $admin = $this->get_ajax_menu();
        $m_position = spClass('m_position');
        $results = $m_position->findAll('', '', 'id,name');
        $this->msg_json(1, '获取成功', $results);
    }

    function findCustomer() {
        $admin = $this->get_ajax_menu();
        $id = (int) htmlentities($this->spArgs('id'));
        $con = 'del = 0 and cid = '.$admin['cid'];
        if ($id) {
            $con .= ' and uid = ' . $id;
        }
        $results = spClass('m_customer')->findAll($con);
        foreach ($results as $k => $v) {
            $results[$k]['name'] = $v['company'];
        }
        $this->msg_json(1, '获取成功', $results);
    }

    function gettotal() {
        $admin = $this->get_ajax_menu();
        $m_admin = spClass('m_admin');
        $m_admin->update(array('id' => $admin['id']), array('lastonline' => date('Y-m-d H:i:s'))); //最后在线时间
        $m_flow_bill = spClass('m_flow_bill');
        $m_flow_todos = spClass('m_flow_todos');
        $newbill = $m_flow_bill->findAll('del = 0 and nowcheckid like "%,' . $admin['id'] . ',%"','','',10);
        $todos = $m_flow_todos->findAll('uid = ' . $admin['id'] . ' and isread = 0');
        $infor = spClass('m_infor')->findAll('receid = "" and del = 0 and cid = '.$admin['cid'], 'date desc,id desc', 'id,title,type,date', 5);
        $infor = empty($infor) ? array() : $infor;
        $orders = spClass('m_orders')->findAll('del = 0 and comid = '.$admin['cid'], 'adddt desc,id desc', 'id,number,name,money,cname,date', 5);
        $infor = empty($infor) ? array() : $infor;
        $total['upcoming'] = count($newbill);
        $total['todos'] = count($todos);
        $content = array();
        foreach ($newbill as $v) {
            if (!in_array('u' . $v['id'], $_SESSION['Popu'])) {
                $content[] = array('id' => $v['id'], 'title' => $v['modelname'], 'content' => $v['summary'], 'href' => spUrl('process', 'upcoming'), 'Popu' => 'u' . $v['id']);
            }
        }
        foreach ($todos as $v) {
            if (!in_array('r' . $v['id'], $_SESSION['Popu'])) {
                $content[] = array('id' => $v['id'], 'title' => $v['modelname'], 'content' => $v['title'], 'href' => spUrl('person', 'remind'), 'Popu' => 'r' . $v['id']);
            }
        }
        echo json_encode(array("total" => $total, 'content' => $content, 'infor' => $infor, 'newbill' => $newbill, 'orders' => $orders));
        foreach ($content as $v) {
            $_SESSION['Popu'][] = $v['Popu'];
        }
        exit;
    }

}

?>
