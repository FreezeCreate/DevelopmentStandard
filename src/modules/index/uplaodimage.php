<?php

/**
 * Description of uplaodimage
 *
 * @author Administrator
 */
class uplaodimage extends IndexController {

    function upload() {
        $data = array("status" => 0, "msg" => "", "src" => "");
        $fileElementName = $this->spArgs('name');
        if (!empty($_FILES[$fileElementName]['error'])) {
            switch ($_FILES[$fileElementName]['error']) {
                case '1':
                    $data["msg"] = '文件太大，无法上传！';
                    break;
                case '2':
                    $data["msg"] = '文件大小超出了表单的限制！';
                    break;
                case '3':
                    $data["msg"] = '文件上传不完整！';
                    break;
                case '4':
                    $data["msg"] = '没有选择文件！';
                    break;
                case '6':
                    $data["msg"] = '临时文件夹丢失！';
                    break;
                case '7':
                    $data["msg"] = '图片保存失败！';
                    break;
                case '8':
                    $data["msg"] = '文件上传意外终止！';
                    break;
                case '999':
                default:
                    $data["msg"] = '没有错误！';
            }
        } elseif (empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
            $data["msg"] = '请选择要上传的文件！';
        } else {
            $tempFile = $_FILES[$fileElementName]['tmp_name'];
            $file_name = $_FILES[$fileElementName]['name'];
            $pt = strrpos($file_name, ".");
            $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);

            //判断文件格式
            if ($file_ext != ".jpg" && $file_ext != ".JPG" && $file_ext != ".jpeg" && $file_ext != ".JPEG" && $file_ext != ".png" && $file_ext != ".PNG" && $file_ext != ".gif" && $file_ext != ".GIF") {
                $data["msg"] = '图片格式错误，只能上传jpg、png、gif等格式的图片！';
                echo json_encode($data);
                exit;
            }

            import(APP_PATH . "/include/Common.php");
            $rd = Common::randCode(6, 1);

            $file_name = time() . $rd . $file_ext;

            $targetFile = APP_PATH . "/tmp/" . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);

            $w = $this->spArgs("w");
            $h = $this->spArgs("h");
            if ($w && $h) {
                import(APP_PATH . "/include/imgresize.php");
                $_img = new imgresize($targetFile, $targetFile); //$_path为图片文件的路径
                $_img->thumb($w, $h);
                $_img->out();
            }

            if ($re) {
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["src"] = $file_name;
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }

    function uploadExcel() {
        $data = array("status" => 0, "msg" => "", "src" => "");
        $fileElementName = $this->spArgs('name');
        if (!empty($_FILES[$fileElementName]['error'])) {
            switch ($_FILES[$fileElementName]['error']) {
                case '1':
                    $data["msg"] = '文件太大，无法上传！';
                    break;
                case '2':
                    $data["msg"] = '文件大小超出了表单的限制！';
                    break;
                case '3':
                    $data["msg"] = '文件上传不完整！';
                    break;
                case '4':
                    $data["msg"] = '没有选择文件！';
                    break;
                case '6':
                    $data["msg"] = '临时文件夹丢失！';
                    break;
                case '7':
                    $data["msg"] = '图片保存失败！';
                    break;
                case '8':
                    $data["msg"] = '文件上传意外终止！';
                    break;
                case '999':
                default:
                    $data["msg"] = '没有错误！';
            }
        } elseif (empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
            $data["msg"] = '请选择要上传的文件！';
        } else {
            $tempFile = $_FILES[$fileElementName]['tmp_name'];
            $file_name = $_FILES[$fileElementName]['name'];
            $pt = strrpos($file_name, ".");
            $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);

            //判断文件格式
            if ($file_ext != ".xlsx") {
                $data["msg"] = '文件格式错误，只能上传xlsx格式的文件！';
                echo json_encode($data);
                exit;
            }
            import(APP_PATH . "/include/Common.php");
            $rd = Common::randCode(6, 1);
            $file_name = time() . $rd . $file_ext;
            $targetFile = APP_PATH . "/tmp/" . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);
            if ($re) {
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["src"] = $file_name;
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }
    function uploadFile() {
        $user = $this->islogin();
        $data = array("code" => 1, "msg" => "", "src" => "");
        $fileElementName = $this->spArgs('name');
        if (!empty($_FILES[$fileElementName]['error'])) {
            switch ($_FILES[$fileElementName]['error']) {
                case '1':
                    $data["msg"] = '文件太大，无法上传！';
                    break;
                case '2':
                    $data["msg"] = '文件大小超出了表单的限制！';
                    break;
                case '3':
                    $data["msg"] = '文件上传不完整！';
                    break;
                case '4':
                    $data["msg"] = '没有选择文件！';
                    break;
                case '6':
                    $data["msg"] = '临时文件夹丢失！';
                    break;
                case '7':
                    $data["msg"] = '图片保存失败！';
                    break;
                case '8':
                    $data["msg"] = '文件上传意外终止！';
                    break;
                case '999':
                default:
                    $data["msg"] = '没有错误！';
            }
        } elseif (empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
            $data["msg"] = '请选择要上传的文件！';
        } else {
            $tempFile = $_FILES[$fileElementName]['tmp_name'];
            $file_name = $_FILES[$fileElementName]['name'];
            $pt = strrpos($file_name, ".");
            $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);
            $file_ext = $file_ext == 'downloading' ? 'jpg' : $file_ext;
            $data_f['filename'] = $file_name;
            $data_f['fileext'] = substr($file_name, $pt + 1, strlen($file_name) - $pt - 1);
            $data_f['filetype'] = $_FILES[$fileElementName]['type'];
            $data_f['filesize'] = $_FILES[$fileElementName]['size'];
            if ($data_f['filesize'] > 1024 * 1024) {
                $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize'] / 1024 / 1024) . ' MB';
            } else if ($data_f['filesize'] > 1024) {
                $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize'] / 1024) . ' KB';
            } else {
                $data_f['filesizecn'] = $data_f['filesize'] . ' Byte';
            }
            $data_f['optid'] = $user['id'];
            $data_f['optname'] = $user['name'];
            $data_f['cid'] = $user['cid'];
            $data_f['time'] = time();
            $data_f['ip'] = Common::getIp();
            //判断文件格式
            if (in_array($file_ext, array('.php', '.pl', '.cgi', '.asp', '.aspx', '.jsp', '.php5', '.php4', '.php3', '.shtm', '.shtml'))) {
                $data["msg"] = '系统禁止上传该类型的文件！';
                echo json_encode($data);
                exit;
            }

            function mk_dir() {
                $dir = date('ymd', time());
                if (is_dir(APP_PATH . '/uploads/file/' . $dir)) {

                    return $dir;
                } else {
                    mkdir(APP_PATH . '/uploads/file/' . $dir, 0777, true);
                    chmod(APP_PATH . '/uploads/file/' . $dir, 0777);
                    return $dir;
                }
            }

            import(APP_PATH . "/include/Common.php");
            $rd = Common::randCode(6, 1);
            $dir = mk_dir();
            $file_name = time() . $rd . $file_ext;
            $targetFile = APP_PATH . "/uploads/file/" . $dir . '/' . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);
            if ($re) {
                //app方法
//                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
//                $data_f['id'] = spClass('m_file')->create($data_f);
//                $data["msg"] = "上传成功！";
//                $data["code"] = 0;
//                $data["id"] = $data_f['id'];
//                $data["filename"] = $data_f['filename'];

                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
                $data_f['id'] = spClass('m_file')->create($data_f);
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["data"] = array('id'=>$data_f['id'],'filename'=>$data_f['filename']);
            } else {
                $data["msg"] = "上传失败！";
            }
        }

        echo json_encode($data);
        exit;
    }
    function uploadFile1() {
        $data = array("status" => 0, "msg" => "", "src" => "");
        $fileElementName = $this->spArgs('name');
        if (!empty($_FILES[$fileElementName]['error'])) {
            switch ($_FILES[$fileElementName]['error']) {
                case '1':
                    $data["msg"] = '文件太大，无法上传！';
                    break;
                case '2':
                    $data["msg"] = '文件大小超出了表单的限制！';
                    break;
                case '3':
                    $data["msg"] = '文件上传不完整！';
                    break;
                case '4':
                    $data["msg"] = '没有选择文件！';
                    break;
                case '6':
                    $data["msg"] = '临时文件夹丢失！';
                    break;
                case '7':
                    $data["msg"] = '图片保存失败！';
                    break;
                case '8':
                    $data["msg"] = '文件上传意外终止！';
                    break;
                case '999':
                default:
                    $data["msg"] = '没有错误！';
            }
        } elseif (empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
            $data["msg"] = '请选择要上传的文件！';
        } else {
            $tempFile = $_FILES[$fileElementName]['tmp_name'];
            $file_name = $_FILES[$fileElementName]['name'];
            $pt = strrpos($file_name, ".");
            $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);
            $data_f['filename'] = $file_name;
            $data_f['fileext'] = substr($file_name, $pt+1, strlen($file_name) - $pt-1);
            $data_f['filetype'] = $_FILES[$fileElementName]['type'];
            $data_f['filesize'] = $_FILES[$fileElementName]['size'];

            if($data_f['filesize']>1024*1024){
                $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize']/1024/1024).' MB';
            }else if($data_f['filesize']>1024){
                $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize']/1024).' KB';
            }else{
                $data_f['filesizecn'] = $data_f['filesize'].' Byte';
            }
            $data_f['optid'] = $_SESSION['admin']['id'];
            $data_f['optname'] = $_SESSION['admin']['name'];
            $data_f['time'] = time();
            $data_f['ip'] = Common::getIp();
            //判断文件格式
            if (in_array($file_ext,array('.php','.pl','.cgi','.asp','.aspx','.jsp','.php5','.php4','.php3','.shtm','.shtml'))) {
                $data["msg"] = '系统禁止上传该类型的文件！';
                echo json_encode($data);
                exit;
            }

            function mk_dir() {
                $dir = date('ymd', time());
                if (is_dir(APP_PATH . '/uploads/file/' . $dir)) {

                    return $dir;
                } else {
                    mkdir(APP_PATH . '/uploads/file/' . $dir, 0777, true);
                    return $dir;
                }
            }

            import(APP_PATH . "/include/Common.php");
            $rd = Common::randCode(6, 1);
            $dir = mk_dir();
            $file_name = time() . $rd . $file_ext;
            $targetFile = APP_PATH . "/uploads/file/" . $dir . '/' . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);
            if ($re) {
                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
                $data_f['id'] = spClass('m_file')->create($data_f);
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["data"] = array('id'=>$data_f['id'],'filename'=>$data_f['filename']);
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        dump($data);die;
        echo json_encode($data);
        exit;
    }
    
    
    //上传头像专用
    function uploadhead() {
        $admin = $this->get_ajax_menu();
        $data = array("status" => 0, "msg" => "", "src" => "");
        $fileElementName = 'fileToUploadHead';
        if (!empty($_FILES[$fileElementName]['error'])) {
            switch ($_FILES[$fileElementName]['error']) {
                case '1':
                    $data["msg"] = '文件太大，无法上传！';
                    break;
                case '2':
                    $data["msg"] = '文件大小超出了表单的限制！';
                    break;
                case '3':
                    $data["msg"] = '文件上传不完整！';
                    break;
                case '4':
                    $data["msg"] = '没有选择文件！';
                    break;
                case '6':
                    $data["msg"] = '临时文件夹丢失！';
                    break;
                case '7':
                    $data["msg"] = '图片保存失败！';
                    break;
                case '8':
                    $data["msg"] = '文件上传意外终止！';
                    break;
                case '999':
                default:
                    $data["msg"] = '没有错误！';
            }
        } elseif (empty($_FILES['fileToUploadHead']['tmp_name']) || $_FILES['fileToUploadHead']['tmp_name'] == 'none') {
            $data["msg"] = '请选择要上传的文件！';
        } else {
            $tempFile = $_FILES['fileToUploadHead']['tmp_name'];
            $file_name = $_FILES['fileToUploadHead']['name'];
            $pt = strrpos($file_name, ".");
            $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);

            //判断文件格式
            if ($file_ext != ".jpg" && $file_ext != ".JPG" && $file_ext != ".jpeg" && $file_ext != ".JPEG" && $file_ext != ".png" && $file_ext != ".PNG" && $file_ext != ".gif" && $file_ext != ".GIF") {
                $data["msg"] = '图片格式错误，只能上传jpg、png、gif等格式的图片！';
                echo json_encode($data);
                exit;
            }

            $rd = Common::randCode(6, 1);

            $file_name = time() . $rd . $file_ext;

            $targetFile = APP_PATH . "/tmp/" . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);

            import(APP_PATH . "/include/imgresize.php");
            $_img = new imgresize($targetFile, $targetFile);
            $_img->thumb(150, 150);
            $_img->out();

            $con = array("id" => $admin['id']);
            $_path = "/tmp/" . basename($targetFile);
            $row = array(
                "head" => Common::copy_upload($_path, "head/".date('Ymd'))
            );

            $re2 = spClass('m_admin')->update($con, $row);
            if ($re && $re2) {
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["src"] = $row["head"];
                $_SESSION['admin']["head"] = $row["head"];
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }

}

?>
