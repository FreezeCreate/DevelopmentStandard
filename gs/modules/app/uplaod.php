<?php

/**
 * Description of uplaodimage
 *
 * @author Administrator
 */
class uplaod extends AppController {

    //上传签名专用
    function uploadqm() {
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: POST,GET');
        header('Access-Control-Max-Age: 1000');
        
        $this->logResult("post:" . json_encode($_POST) . "\n get:" . json_encode($_GET) . "\n files:" . json_encode($_FILES));
        $user = $this->islogin();
        $data = array("code" => 1, "msg" => "", "src" => "");
        //         $fileElementName = $_GET['name'];
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
            
            $rd = Common::randCode(6, 1);
            
            $file_name = time() . $rd . $file_ext;
            
            $targetFile = APP_PATH . "/tmp/" . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);
            
            import(APP_PATH . "/include/imgresize.php");
            $_img = new imgresize($targetFile, $targetFile);
            $_img->thumb(100, 50);
            $_img->out();
            
            $con = array("id" => $admin['id']);
            $_path = "/tmp/" . basename($targetFile);
            $row = array(
                "qianming" => Common::copy_upload($_path, "qianming/".date('Ymd'))
            );
            
            $re2 = spClass('m_admin')->update($con, $row);
            if ($re && $re2) {
                $data["msg"] = "上传成功！";
                $data["status"] = 1;
                $data["src"] = $row["qianming"];
                $_SESSION['admin']["qianming"] = $row["qianming"];
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }
    
    function uploadimage() {
        $this->logResult("post:" . json_encode($_POST) . "\n get:" . json_encode($_GET) . "\n files:" . json_encode($_FILES));
        $img = $this->spArgs('image');
        $image = Common::base64_image_content($img, 'tmp');
        if ($image) {
            $this->returnSuccess('上传成功', array('url' => URL.$image));
        } else {
            $this->returnError('上传失败');
        }
    }
//     function uploadFile() {
//         header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
//         header('Access-Control-Allow-Methods: POST,GET');
//         header('Access-Control-Max-Age: 1000');
        
//         $user = $this->islogin();
//         $data = array("code" => 1, "msg" => "", "src" => "");
//         $fileElementName = $this->spArgs('name');
//         if (!empty($_FILES[$fileElementName]['error'])) {
//             switch ($_FILES[$fileElementName]['error']) {
//                 case '1':
//                     $data["msg"] = '文件太大，无法上传！';
//                     break;
//                 case '2':
//                     $data["msg"] = '文件大小超出了表单的限制！';
//                     break;
//                 case '3':
//                     $data["msg"] = '文件上传不完整！';
//                     break;
//                 case '4':
//                     $data["msg"] = '没有选择文件！';
//                     break;
//                 case '6':
//                     $data["msg"] = '临时文件夹丢失！';
//                     break;
//                 case '7':
//                     $data["msg"] = '图片保存失败！';
//                     break;
//                 case '8':
//                     $data["msg"] = '文件上传意外终止！';
//                     break;
//                 case '999':
//                 default:
//                     $data["msg"] = '没有错误！';
//             }
//         } elseif (empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
//             $data["msg"] = '请选择要上传的文件！';
//         } else {
//             $tempFile = $_FILES[$fileElementName]['tmp_name'];
//             $file_name = $_FILES[$fileElementName]['name'];
//             $pt = strrpos($file_name, ".");
//             $file_ext = substr($file_name, $pt, strlen($file_name) - $pt);
//             $file_ext = $file_ext == 'downloading' ? 'jpg' : $file_ext;
//             $data_f['filename'] = $file_name;
//             $data_f['fileext'] = substr($file_name, $pt + 1, strlen($file_name) - $pt - 1);
//             $data_f['filetype'] = $_FILES[$fileElementName]['type'];
//             $data_f['filesize'] = $_FILES[$fileElementName]['size'];
//             if ($data_f['filesize'] > 1024 * 1024) {
//                 $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize'] / 1024 / 1024) . ' MB';
//             } else if ($data_f['filesize'] > 1024) {
//                 $data_f['filesizecn'] = sprintf("%.2f", $data_f['filesize'] / 1024) . ' KB';
//             } else {
//                 $data_f['filesizecn'] = $data_f['filesize'] . ' Byte';
//             }
//             $data_f['optid'] = $user['id'];
//             $data_f['optname'] = $user['name'];
//             $data_f['cid'] = $user['cid'];
//             $data_f['time'] = time();
//             $data_f['ip'] = Common::getIp();
//             //判断文件格式
//             if (in_array($file_ext, array('.php', '.pl', '.cgi', '.asp', '.aspx', '.jsp', '.php5', '.php4', '.php3', '.shtm', '.shtml'))) {
//                 $data["msg"] = '系统禁止上传该类型的文件！';
//                 echo json_encode($data);
//                 exit;
//             }
            
//             function mk_dir() {
//                 $dir = date('ymd', time());
//                 if (is_dir(APP_PATH . '/uploads/file/' . $dir)) {
                    
//                     return $dir;
//                 } else {
//                     mkdir(APP_PATH . '/uploads/file/' . $dir, 0777, true);
//                     chmod(APP_PATH . '/uploads/file/' . $dir, 0777);
//                     return $dir;
//                 }
//             }
            
//             import(APP_PATH . "/include/Common.php");
//             $rd = Common::randCode(6, 1);
//             $dir = mk_dir();
//             $file_name = time() . $rd . $file_ext;
//             $targetFile = APP_PATH . "/uploads/file/" . $dir . '/' . $file_name;
//             $re = move_uploaded_file($tempFile, $targetFile);
//             if ($re) {
//                 //app方法
//                 //                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
//                 //                $data_f['id'] = spClass('m_file')->create($data_f);
//                 //                $data["msg"] = "上传成功！";
//                 //                $data["code"] = 0;
//                 //                $data["id"] = $data_f['id'];
//                 //                $data["filename"] = $data_f['filename'];
                
//                 $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
//                 $data_f['id'] = spClass('m_file')->create($data_f);
//                 $data["msg"] = "上传成功！";
//                 $data["status"] = 1;
//                 $data["data"] = array('id'=>$data_f['id'],'filename'=>$data_f['filename']);
//             } else {
//                 $data["msg"] = "上传失败！";
//             }
//         }
// //         dump($data);die;
//         echo json_encode($data);
//         exit;
//     }
    
    function uploadFile() {
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: POST,GET');
        header('Access-Control-Max-Age: 1000');
        
        $this->logResult("post:" . json_encode($_POST) . "\n get:" . json_encode($_GET) . "\n files:" . json_encode($_FILES));
        $user = $this->islogin();
        $data = array("code" => 1, "msg" => "", "src" => "");
//         $fileElementName = $_GET['name'];
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
                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
                $data_f['id'] = spClass('m_file')->create($data_f);
                $data["msg"] = "上传成功！";
                $data["code"] = 0;
                $data["id"] = $data_f['id'];
                $data["filename"] = $data_f['filename'];
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }
    
    function uploadFile1() {
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: POST,GET');
        header('Access-Control-Max-Age: 1000');
        
        $this->logResult("post:" . json_encode($_POST) . "\n get:" . json_encode($_GET) . "\n files:" . json_encode($_FILES));
        $user = $this->islogin();
        $data = array("code" => 1, "msg" => "", "src" => "");
        
        $fileElementName = $this->spArgs['name'];
//         $fileElementName = array_keys($_FILES)[0];
//         dump($_FILES[$fileElementName]);die;
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
                $data_f['filepath'] = "/uploads/file/" . $dir . '/' . $file_name;
                $data_f['id'] = spClass('m_file')->create($data_f);
                $data["msg"] = "上传成功！";
                $data["code"] = 0;
                $data["id"] = $data_f['id'];
                $data["filename"] = $data_f['filename'];
                
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

    function uploadVideo() {
        $this->logResult("post:" . json_encode($_POST) . "\n get:" . json_encode($_GET) . "\n files:" . json_encode($_FILES));
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
            if (!in_array($file_ext, array('.mp4'))) {
                $data["msg"] = '系统仅允许上传mp4格式的视频文件！';
                echo json_encode($data);
                exit;
            }

            function mk_dir() {
                $dir = date('ymd', time());
                if (is_dir(APP_PATH . '/uploads/video/' . $dir)) {
                    return $dir;
                } else {
                    mkdir(APP_PATH . '/uploads/video/' . $dir, 0777, true);
                    chmod(APP_PATH . '/uploads/video/' . $dir, 0777);
                    return $dir;
                }
            }
            import(APP_PATH . "/include/Common.php");
            $rd = Common::randCode(6, 1);
            $dir = mk_dir();
            $file_name = time() . $rd . $file_ext;
            $targetFile = APP_PATH . "/uploads/video/" . $dir . '/' . $file_name;
            $re = move_uploaded_file($tempFile, $targetFile);
            if ($re) {
                $data_f['filepath'] = "/uploads/video/" . $dir . '/' . $file_name;
                $data_f['id'] = spClass('m_file')->create($data_f);
                $data["msg"] = "上传成功！";
                $data["code"] = 0;
                $data["id"] = $data_f['id'];
                $data["url"] = $data_f['filepath'];
                $data["filename"] = $data_f['filename'];
            } else {
                $data["msg"] = "上传失败！";
            }
        }
        echo json_encode($data);
        exit;
    }

    //上传头像
    function uploadhead() {
        $user = $this->islogin();
        $img = $this->spArgs('image');
        $targetFile = Common::base64_image_content($img, "head/" . date('Ymd'));
        $this->logResult("image:" . $img . "\n targetFile:" . $targetFile);
        $con = array("id" => $user['id']);
        $row = array(
            "head" => $targetFile
        );
        $re2 = spClass('m_user')->update($con, $row);
        if ($re2) {
            $row['head'] = URL.$row['head'];
            $this->returnSuccess('上传成功',$row);
        } else {
            $this->returnError('上传失败');
        }
    }

    //上传背景图
    function uploadback() {
        $user = $this->islogin();
        $img = $this->spArgs('image');
        $targetFile = Common::base64_image_content($img, "background/" . date('Ymd'));
        $this->logResult("image:" . $img . "\n targetFile:" . $targetFile);
        $con = array("id" => $user['id']);
        $row = array(
            "background" => $targetFile
        );
        $re2 = spClass('m_user')->update($con, $row);
        if ($re2) {
            $row['background'] = URL.$row['background'];
            $this->returnSuccess('上传成功',$row);
        } else {
            $this->returnError('上传失败');
        }
    }

}



?>
