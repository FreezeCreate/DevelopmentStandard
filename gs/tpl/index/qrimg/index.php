<!DOCTYPE HTML>
<?php 
function download($id) {
    $m_file = spClass('m_file');
//     $id = (int) htmlspecialchars('id');
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
?>
 <html>
     <head>
     	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
        <title><?php echo $title;?></title>    
     </head>
     <body>
         <table style="width: 100%;text-align: center;">
          <tr>
            <th>序号</th>
            <th>文件</th>
          </tr>
          <?php 
            foreach ($equip_files as $k => $v){
                echo '
                      <tr>
                        <td>'.($k + 1).'</td>
                        <td><a href="'.(spUrl("main", "download", array('id' => $v['id']))).'">'.$v['filename'].'</a></td>
                      </tr>
                ';
            }
          ?>
        </table>    
    </body>
</html>
