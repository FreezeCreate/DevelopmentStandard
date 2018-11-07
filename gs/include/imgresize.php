<?php
/**
 * 
 * 使用方法：
 * $_path = 'D:/test1.png';
 * $_img = new Image($_path);//$_path为图片文件的路径
 * $_img->thumb(150, 100);
 * $_img->out();
 * 
 * 
 */



//图像处理类
class imgresize {

    private $file;    //原图片地址
    private $file2;    //保存新图片地址
    private $width;   //图片长度
    private $height;   //图片长度
    private $type;    //图片类型
    private $img;    //原图的资源句柄
    private $new;    //新图的资源句柄

    //构造方法，初始化

    public function __construct($src_file, $dst_file) {
        $this->file = $src_file;
        $this->file2 = $dst_file;
        
        list($this->width, $this->height, $this->type) = getimagesize($this->file);
        $this->img = $this->getFromImg($this->file, $this->type);
        //$this->img = imagecreatefromjpeg($_file); //调用前转化图片格式为jpg
    }

    //缩略图(固定长高容器，图像等比例，扩容填充，裁剪)[固定了大小，不失真，不变形]
    public function thumb($new_width = 0, $new_height = 0) {
        if (empty($new_width) && empty($new_height)) {
            $new_width = $this->width;
            $new_height = $this->height;
        }
        if (!is_numeric($new_width) || !is_numeric($new_height)) {
            $new_width = $this->width;
            $new_height = $this->height;
        }

        //创建一个容器
        $_n_w = $new_width;
        $_n_h = $new_height;

        //创建裁剪点
        $_cut_width = 0;
        $_cut_height = 0;

        if ($this->width < $this->height) {
            
            $new_width = $this->width * $new_height / $this->height;
        } else {
            $new_height = $this->height * $new_width / $this->width;
        }

        if ($new_width < $_n_w) { //如果新高度小于新容器高度
            $r = $_n_w / $new_width; //按长度求出等比例因子
            $new_width *= $r; //扩展填充后的长度
            $new_height *= $r; //扩展填充后的高度
            $_cut_height = ($new_height - $_n_h); /// 2; //求出裁剪点的高度
        }

        if ($new_height < $_n_h) { //如果新高度小于容器高度
            $r = $_n_h / $new_height; //按高度求出等比例因子
            $new_width *= $r; //扩展填充后的长度
            $new_height *= $r; //扩展填充后的高度
            $_cut_width = ($new_width - $_n_w);// / 2; //求出裁剪点的长度
        }
        $this->new = imagecreatetruecolor($_n_w, $_n_h);
        
        $_cut_height = floor($_cut_height);
        $_cut_width = floor($_cut_width);
        $new_width = floor($new_width);
        $new_height = floor($new_height);
        imagecopyresampled($this->new, $this->img, 0, 0, $_cut_width, $_cut_height, $new_width, $new_height, $this->width, $this->height);
    }

    
    //加载图片，各种类型，返回图片的资源句柄
    private function getFromImg($_file, $_type) {
        switch ($_type) {
            case 1 :
                $img = imagecreatefromgif($_file);
                break;
            case 2 :
                $img = imagecreatefromjpeg($_file);
                break;
            case 3 :
                $img = imagecreatefrompng($_file);
                break;
            default:
                Tool::alertBack('警告：此图片类型本系统不支持！');
        }
        return $img;
    }

    //图像输出
    public function out() {
        imagejpeg($this->new, $this->file2, 90);   //保存新图片
        imagedestroy($this->img);
        imagedestroy($this->new);
    }

}