<?php

/**
 * Created by PhpStorm.
 * User: IndexController
 * Date: 2017/8/17
 * Time: 14:05
 */
class aaa extends AppController {

    function qq() {
//        $m_flow_course = spClass('m_flow_course');
//        $result = $m_flow_course->ressAll();
//        echo json_encode($result);
        $user = spClass('m_user')->find(array('username'=>'123456qq'));
        Common::getBasic($user);
    }

    function index() {
        echo json_encode(array(7=>'一周内',10=>'10天内',15=>'15天内',30=>'30天内'));die;
        header("Content-type:application/json;charset=utf-8");
        $url = "http://ljb:9898/app.php/passport/login";
        $param = array(
            //注册字段
            "username" => "test001",
            "password" => "xxxx",
            'data' => json_encode(array('ss' => 'asdasd'))
        );
        $data = json_encode($param);
        list($return_code, $return_content) = $this->http_post_data($url, $data); //return_code是http状态码
        print_r($return_content);
        exit;
    }

    function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json; charset=utf-8",
            "Content-Length: " . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);

        //echo Common::base64_image_content('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAUCAYAAAD/Rn+7AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpmZDgyZmNlMy01ODY3LWU0NDQtYjg1Yi1lMzAzOTM0ZTg2M2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NEE3QkNBRjI1NEVFMTFFOEJENUZBMDk4NDhBMDEzODYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NEE3QkNBRjE1NEVFMTFFOEJENUZBMDk4NDhBMDEzODYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOmM1OWQ3MzUyLWRkZTAtZmY0NC04OTk3LTdhNTY0OTNkNDVjNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpmZDgyZmNlMy01ODY3LWU0NDQtYjg1Yi1lMzAzOTM0ZTg2M2EiLz4gPC9y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','logo');
    }

    function word2pdf($lastfnamedoc, $lastfnamepdf) {
        $word = new COM("Word.Application") or die("Could not initialise Object.");
        $word->Visible = 0;
        $word->DisplayAlerts = 0;
        $word->Documents->Open($lastfnamedoc);
        $word->ActiveDocument->ExportAsFixedFormat($lastfnamepdf, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
        $word->Quit(false);
    }

}
