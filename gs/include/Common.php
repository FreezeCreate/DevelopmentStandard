<?php

/**
 * Description of Common
 *
 * @author Administrator
 */
class Common {
    
    
    
    /**
     * 设置商家经营的品牌
     * @param unknown_type $shop_id
     * @param unknown_type $brand_id
     */
    public static function shop_set_brand($shop_id, $brand_id, $shop_address) {
        //查询出商家
        $m_shop = spClass('m_shop');
        $shop = $m_shop->find(array("id" => $shop_id));
        if ($shop) {
            $ids = explode(',', $shop['brand_ids']);
            if (is_array($brand_id)) {
                $ids = array_merge($ids, $brand_id);
            } else {
                $ids[] = (int) $brand_id;
            }
            $ids = array_filter($ids);
            $ids = array_unique($ids);
            $ids = ',' . join(',', $ids) . ',';

            $m_shop_address = spClass('m_shop_address');

            foreach ($shop_address as $k => $v) {
                $sql = 'SELECT * FROM jk_shop_address WHERE id =' . $v . ' and brand_ids LIKE ",%' . $brand_id . '%,"';
                $tmp = $m_shop_address->findSql($sql);
                if (empty($tmp[0]['brand_ids'])) {
                    $tmp = $m_shop_address->find(array("id" => $v));
                    if (empty($tmp['brand_ids'])) {
                        $tmp['brand_ids'] = ',';
                    }
                    $sql = 'UPDATE jk_shop_address SET brand_ids ="' . $tmp['brand_ids'] . $brand_id . '," WHERE id =' . $v;
                    $m_shop_address->findSql($sql);
                }
            }
            // return $sql;
            //更新商家中的品牌
            return $m_shop->update(array("id" => $shop_id), array('brand_ids' => $ids));
        }
        return false;
    }

    /**
     * 设置市场中的品牌
     * @param unknown_type $market_id
     * @param unknown_type $brand_id
     */
    public static function market_set_brand($market_id, $brand_id) {
        //查询出市场
        $m_market = spClass('m_market');
        $market = $m_market->find(array("id" => $market_id));
        if ($market) {
            $ids = explode(',', $market['brand_ids']);
            if (is_array($brand_id)) {
                $ids = array_merge($ids, $brand_id);
            } else {
                $ids[] = (int) $brand_id;
            }
            $ids = array_filter($ids);
            $ids = array_unique($ids);
            $ids = ',' . join(',', $ids) . ',';

            //更新市场中的品牌
            return $m_market->update(array("id" => $market_id), array('brand_ids' => $ids));
        }
        return false;
    }

    /**
     * 设置市场中的商家
     * @param unknown_type $market_id
     * @param unknown_type $shop_id
     */
    public static function market_set_shop($market_id, $shop_id) {
        //查询出市场
        $m_market = spClass('m_market');
        $market = $m_market->find(array("id" => $market_id));
        if ($market) {
            $ids = explode(',', $market['shop_ids']);
            if (is_array($shop_id)) {
                $ids = array_merge($ids, $shop_id);
            } else {
                $ids[] = (int) $shop_id;
            }
            $ids = array_filter($ids);
            $ids = array_unique($ids);
            $ids = ',' . join(',', $ids) . ',';
            //更新市场中的商家
            return $m_market->update(array("id" => $market_id), array('shop_ids' => $ids));
        }
        return false;
    }

    /**
     * 设置市场附近的小区
     * @param unknown_type $market_id
     * @param unknown_type $community_id
     */
    public static function market_set_community($market_id, $community_id) {
        //查询出市场
        $m_market = spClass('m_market');
        $market = $m_market->find(array("id" => $market_id));
        if ($market) {
            $ids = explode(',', $market['community_ids']);
            if (is_array($community_id)) {
                $ids = array_merge($ids, $community_id);
            } else {
                $ids[] = (int) $community_id;
            }
            $ids = array_filter($ids);
            $ids = array_unique($ids);
            $ids = ',' . join(',', $ids) . ',';

            //更新市场附近的小区
            return $m_market->update(array("id" => $market_id), array('community_ids' => $ids));
        }
        return false;
    }

    /**
     * 设置当前用户所在的城市
     * @param  $plate_id 区域id
     * @return boolean
     */
    public static function set_city($city_id) {
        $model = spClass('m_pca');
        $city = $model->find(array("aid" => $city_id));
        if ($city) {
            setcookie("city_id", $city["aid"], time() + 3600 * 24 * 365, '/');
            setcookie("city_name", $city["name"], time() + 3600 * 24 * 365, '/');
            return true;
        } else {
            setcookie("city_id", 5101, time() + 3600 * 24 * 365, '/');
            setcookie("city_name", "成都", time() + 3600 * 24 * 365, '/');
        }
        return false;
    }

    /**
     * 设置用户登录状态
     * @param type $userid 
     */
    public static function set_login_status($userid) {
        $m_user_deputy = spClass("m_user_deputy");
        $con = array("id" => $userid);
        //$m_basket = spClass('m_basket');
        //$sql = 'select count(*) as count from jk_basket where user_id ='.$user['id'];
        //$count = $m_basket->findSql($sql);
        //$_SESSION['user']['basket'] = $count[0]['count'];
        $data = array(
            "is_login" => 1,
            "last_log_ip" => Common::getIp(),
            "last_log_time" => time()
        );
        $r = $m_user_deputy->update($con, $data);
    }

    public static function get_area_by_ip() {
        $ip = Common::getIp();
        if ($ip == "127.0.0.1") {
            $ip = "175.152.169.222";
        }
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
        $re = file_get_contents($url);
        $re = json_decode($re, true);
        if ($re && $re["data"]["region_id"] && $re["data"]["city_id"]) {
            $r = array(
                "pid" => $re["data"]["region_id"],
                "cid" => $re["data"]["city_id"]
            );
            return $r;
        } else {
            return false;
        }
    }

    /**
     * 复制临时文件到正式文件夹
     * @param unknown_type $tmp_filename
     * @return string
     */
    public static function copy_upload($tmp_filename, $folder = "") {
        $new_url = $folder ? UPLOAD_PATH . '/' . $folder . "/" . basename($tmp_filename) : UPLOAD_PATH . '/' . basename($tmp_filename);
        //$new_url = UPLOAD_PATH . '/' . basename($tmp_filename);
        if (!is_dir(APP_PATH . UPLOAD_PATH . '/' . $folder . "/")) {
            mkdir(APP_PATH . UPLOAD_PATH . '/' . $folder . "/");
            chmod(APP_PATH . UPLOAD_PATH . '/' . $folder . "/", 0777);
        }
        $re = rename(APP_PATH . $tmp_filename, APP_PATH . $new_url);
        return $re ? $new_url : '';
    }

    /**
     * 生成指定位数的字母随机码
     * @param unknown_type $length
     * @param unknown_type $isNum
     * @return string
     */
    public static function randCode($length = 4, $isNum = '') {
        $randCode = '';
        if ($isNum) {
            $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $charsLen = count($chars) - 1;
            for ($i = 0; $i < $length; $i++) {
                $randCode.=$chars[mt_rand(0, $charsLen)];
            }
        } else {
            for ($i = 0; $i < $length; $i++) {
                $randCode.=chr(mt_rand(97, 122));
            }
        }
        return $randCode;
    }

    /**
     * 生成单个数字不重复出现N次的随机数
     * @param type $length  长度
     * @param type $isNum   是否为数字
     * @param type $repeat  单个字符不连续重复的次数
     */
    public static function randCodeNoRepeat($length = 4, $isNum = '', $repeat = 3) {
        do {
            $randArr = array();
            if ($isNum) {
                $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "9");
                $charsLen = count($chars) - 1;
                $randArr[] = $chars[mt_rand(0, $charsLen)];

                $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
                $charsLen = count($chars) - 1;
                for ($i = 0; $i < $length - 1; $i++) {
                    $randArr[] = $chars[mt_rand(0, $charsLen)];
                }
            } else {
                for ($i = 0; $i < $length; $i++) {
                    $randArr[] = chr(mt_rand(97, 122));
                }
            }
            $rand = implode("", $randArr);

            $con = true; //默认存在
            foreach ($randArr as $key => $value) {
                $needle = '';
                for ($i = 1; $i <= $repeat; $i++) {
                    $needle .= $value;
                }
                if (strpos($rand, $needle) === true) {
                    $con = true;
                    break;
                } else {
                    $con = false;
                }
            }
        } while ($con);
        return $rand;
    }

    /**
     * 获取客户端ip
     * @return Ambigous <string, unknown>
     */
    public static function getIp() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } elseif (isset($_SERVER ['REMOTE_ADDR']) && $_SERVER ['REMOTE_ADDR'] && strcasecmp($_SERVER ['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER ['REMOTE_ADDR'];
        } else {
            $ip = "unknown";
        }
        return $ip;
    }

    /**
     * 关注 。。。
     * @param int $userid
     * @param string $follow_id 1,2,3,4....
     * @param int $follow_type
     * @return boolean 
     */
    public static function follow($userid, $follow_id, $follow_type) {
        $m_follow = spClass("m_follow");
        $follow_id = explode(",", $follow_id);
        if ($follow_id) {
            foreach ($follow_id as $key => $value) {
                if ($value) {
                    $data = array("userid" => $userid, "follow_id" => $value, "follow_type" => $follow_type);
                    $r = $m_follow->find($data);
                    if (!$r) {
                        $m_follow->create($data);
                    }
                }
            }
        }
        return true;
    }

    /**
     * 获取我经营的品牌
     * @param type $shopid 
     */
    public static function get_my_brand($shopid) {
        $m_shop = spClass("m_shop");
        $shop = $m_shop->find(array('id' => $shopid));
        //var_dump($shop);
        if (empty($shop['brand_ids']))
            return '';

        $sql = 'select * from jk_brand where id in(' . trim($shop['brand_ids'], ',') . ')';

        return $m_shop->findSql($sql);
    }

    /**
     * 获取我的店铺地址
     * @param type $shopid 
     */
    public static function get_my_shop_address($shopid) {
        $m_shop_address = spClass("m_shop_address");

        $sql = 'select a.*,b.name province,c.name city,d.name area from jk_shop_address as a
    			left join jk_pca as b on a.province=b.aid
    			left join jk_pca as c on a.city=c.aid
    			left join jk_pca as d on a.area=d.aid
    			where a.shop_id="' . $shopid . '"
    			';

        return $m_shop_address->findSql($sql);
    }

    /**
     * 发送消息
     * @param type $userid
     * @param type $to_userid
     * @param type $con 
     */
    public static function send_message($userid, $to_userid, $con, $type = '3') {
        if (empty($to_userid) || $userid == $to_userid) {
            return FALSE;  //不能给系统发送消息 （收件人为空不能发送） 不能给自己发消息
        }
        $model = spClass("m_message");
        $data = array(
            "userid" => $userid,
            "to_userid" => $to_userid,
            "content" => $con,
            "status" => 0,
            "add_time" => time(),
            "type" => $type,
            "title" => '欢迎您注册，成为我们的会员',
            "user_type" => 0,
            "image" => ''
        );
        $re = $model->create($data);
        return $re;
    }

    /**
     *
     * @param type $community_name
     * @param type $province
     * @param type $city
     * @param type $area
     * @return int  id
     */
    public static function create_community($community_name, $province, $city, $area) {
        $model = spClass("m_community");
        $data = array(
            "name" => $community_name,
            "province" => $province,
            "city" => $city,
            "area" => $area,
            "add_ip" => Common::getIp(),
            "add_time" => time()
        );
        $re = $model->find($data);
        if ($re) {
            return $re["id"];
        }
        $re = $model->create($data);
        return $re;
    }

    public static function randId($type, $not_rand, $tel_code, $is_repeat = 0) {
        if ($type == 1 || $type == 2) {
            $num = 5;
        } elseif ($type == 3) {
            $num = 3;
        } else {
            $num = 8;
        }
        $rand = rand(1, str_repeat(9, $num));
        preg_match('/(\d)\1{2}/', $rand, $matchs);
        if ($matchs) {
            $rand = Common::randId($type, $not_rand, $tel_code, 1);
        }
        if ($is_repeat == 1) {//只取随机数
            return $rand;
        }

        if ($type == 1 || $type == 2) {
            $rand_code = '8' . sprintf('%05d', $rand);
            $rand = $tel_code . $rand_code;
        } elseif ($type == 3) {
            $rand_code = '9' . sprintf('%03d', $rand);
            $rand = $tel_code . $rand_code;
        } else {
            $rand_code = sprintf('%08d', $rand);
            $rand = $tel_code . $rand_code;
        }

        if (in_array($rand, $not_rand)) {
            $rand = Common::randId($type, $not_rand, $tel_code);
        }

        if (is_array($rand)) {
            return $rand;
        }

        return array('usercode' => $rand, 'rand_code' => $rand_code);
    }

    /**
     * 根据用户的ip获取省份城市id
     * @return multitype:unknown string
     */
    public static function get_area() {
        $ip = Common::getIp();
        $ip = ($ip == '127.0.0.1' ? '118.114.77.34' : $ip);
        $position = Common::get_request('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
        $position = json_decode($position, true);
        if ($position['code'] == 0) {
            $city = str_replace('市', '', $position['data']['city']);
            //查询城市id
            $m_pca = spClass('m_pca');
            $result = $m_pca->find('name="' . $city . '" and aid>100 and aid<10000');
            $pids = explode(',', trim($result['pids'], ','));
            return array('province' => $pids[0], 'city' => $pids[1], 'tel_code' => $result['tel_code']);
        }
        return false;
    }

    /**
     * curl GET请求
     * @param unknown $url
     * @return mixed
     * $result = $this->get_request('http://ip.taobao.com/service/getIpInfo.php?ip=118.114.77.34');
     */
    public static function get_request($url) {
        $ch = curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * 查询是否有上级
     * 
     */
    public static function master($id) {
        
    }

    /**
     * 查询是否全部上级
     * 
     */
    public static function masters($id) {
        $m_user = spClass('m_user');
        $tmp = $m_user->find(array('id' => $id));
        if (!empty($tmp['master'])) {
            $_SESSION['masters'] .= ',' . $tmp['master'];
            Common::masters($tmp['master']);
        } else {
            return $_SESSION['masters'];
        }
    }

    public static function hqdaoruRow($filename, $encode = 'utf-8') {
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
        unlink($filename);
        return $excelData;
    }

    //计算本周、本月、本季度开始结束时间
    public static function getsedt($type) {
        $result = array();
        $result['now'] = date("Ymd", strtotime("now"));
        $result['n'] = date('n');
        $result['w'] = date("w");
        $result['t'] = date("t");
        if($type=='lw'){//上周
            $result['start'] = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1 - 7, date("Y"));
            $result['end'] = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7 - 7, date("Y"));
        }else if($type=='tw'){//本周
            $result['start'] = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
            $result['end'] = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));
        }else if($type=='lm'){//上月
            $result['start'] = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
            $result['end'] = mktime(23, 59, 59, date("m"), 0, date("Y"));
        }else if($type=='tm'){//本月
            $result['start'] = mktime(0, 0, 0, date("m"), 1, date("Y"));
            $result['end'] = mktime(23, 59, 59, date("m"), date("t"), date("Y"));
        }else if($type=='ls'){//上季度
            $season = ceil((date('n')) / 3) - 1; //上季度是第几季度
            $result['start'] = mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
            $result['end'] = mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
        }else if($type=='ts'){//本季度
            $season = ceil((date('n')) / 3); //当月是第几季度
            $result['start'] = mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
            $result['end'] = mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
        }
        return $result;
    }
    
    /**
     * 数据导出 
     * @param array $title   标题行名称 
     * @param array $data   导出数据 
     * @param string $fileName 文件名 
     * @param string $savePath 保存路径 
     * @param $type   是否下载  false--保存   true--下载 
     * @return string   返回文件全路径 
     * @throws PHPExcel_Exception 
     * @throws PHPExcel_Reader_Exception 
     */
    public static function exportExcel($title = array(), $data = array(), $indexKey = array(), $fileName = '', $savePath = './', $isDown = true) {
        require_once 'PHPExcel/IOFactory.php';
        include('PHPExcel.php');
        $obj = new PHPExcel();
        //横向单元格标识  
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $obj->getActiveSheet(0)->setTitle($fileName);   //设置sheet名称  
        $_row = 1;   //设置纵向单元格标识  
        if ($title) {
//        $_cnt = count($title);  
//        $obj->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格  
//        $obj->setActiveSheetIndex(0)->setCellValue('A'.$_row, '数据导出：'.date('Y-m-d H:i:s'));  //设置合并后的单元格内容  
//        $_row++;
            $i = 0;
            foreach ($title AS $v) {   //设置列标题  
                $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i] . $_row, $v);
                $i++;
            }
            $_row++;
        }

        //填写数据  
        if ($data) {
            $i = 0;
            foreach ($data AS $_v) {
                $j = 0;
                foreach ($indexKey AS $_cell) {
                    $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + $_row), $_v[$_cell]);
                    $j++;
                }
                $i++;
            }
        }

        //文件名处理  
        if (!$fileName) {
            $fileName = uniqid(time(), true);
        }
        $objWrite = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
        if ($isDown) {   //网页下载  
            ob_get_clean();
            ob_clean();
            header('pragma:public');
            header("Content-Disposition:attachment;filename=$fileName.xls");
            $objWrite->save('php://output');
            exit;
        }

        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码  
        $_savePath = $savePath . $_fileName . '.xlsx';
        $objWrite->save($_savePath);

        return $savePath . $fileName . '.xlsx';
    }
    
    
    
    
    /**
     * 以下为app接口增加方法
     */
    
    public static function ajaxReturn($data, $type) {
        if (empty($type))
            $type = 'json';
            if (strtoupper($type) == 'JSON') {
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data));
            } elseif (strtoupper($type) == 'XML') {
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            } elseif (strtoupper($type) == 'EVAL') {
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            } else {
                // TODO 增加其它格式
            }
    }
    
    /*  base64格式编码转换为图片并保存对应文件夹 */
    
    public static function base64_image_content($base64_image_content, $folder = "") {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = 'uploads/' . $folder . "/";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file);
                chmod($new_file, 0777);
            }
            $new_file = $new_file . time() . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return '/' . $new_file;
            } else {
                return false;
            }
        } else {
            $new_file = 'uploads/' . $folder . "/";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file);
                chmod($new_file, 0777);
            }
            $new_file = $new_file . time() . ".jpg";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return '/' . $new_file;
            } else {
                return false;
            }
        }
    }
    

}

?>
