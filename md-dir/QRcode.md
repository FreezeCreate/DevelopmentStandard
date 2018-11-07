# SpeedPHP/PHP集成QRcode

PHPQRcode下载包文件[仓库地址](http://phpqrcode.sourceforge.net/ "仓库地址")

> PHP QR Code is open source (LGPL) library for generating QR Code, 2-dimensional barcode. Based on libqrencode C library, provides API for creating QR Code barcode images (PNG, JPEG thanks to GD2). Implemented purely in PHP, with no external dependencies (except GD2 if needed).

**集成方法 && Guider**
简单的[使用方式](https://github.com/FreeSpider/QRCode/blob/master/src/qrcode.php "使用方式")
项目中的集成方式:
`

    function qrCodeSet($id, $text, $dir = '/uploads/qrimg/') 
	{
        $admin = $this->islogin();
        $this->emptyNotice($id, '请指定相应的设备生成二维码');

        include "phpqrcode/qrlib.php";
        //param set
        $qr_name = time() . mt_rand(1000, 9999) . '.jpg';
        $now_path = strtotime(date("Y-m-d", time())) . '/';
        //dir set
        $this->dirCreate('.' . $dir);
        $this->dirCreate('.' . $dir . $now_path);
        //图片的生成和入库
        $path_name = '.' . $dir . $now_path . $qr_name;	//二维码实际生成地址
        $real_dir = $dir . $now_path . $qr_name;	//入库地址
        $enc = QRencode::factory(QR_ECLEVEL_L, 10, 3);
        $enc->encodePNG($text, $path_name, $saveandprint = false);

        $res = spClass('m_equipment')->update(array('id' => $id), array('qrimg' => $real_dir));
        $this->emptyNotice($res, '二维码生成失败,请重试');
    }
`