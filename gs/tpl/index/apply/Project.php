<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>项目详情</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/apply.css" />
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="content" style="width: 800px;">
            <div class="ptitle">项目详情</div>
            <div class="info">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <table class="table01">
                    <tbody>
                        <tr>
                            <td class="tit01" style="width:150px;">项目编号：</td>
                            <td><?php echo $result['number'] ?></td>
                            <td class="tit01" style="width:150px;">项目类型：</td>
                            <td><?php echo $result['type'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01" style="width:150px;">项目名称：</td>
                            <td colspan="3"><?php echo $result['title'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">负责人：</td>
                            <td><?php echo $result['chargename'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">项目金额：</td>
                            <td><?php echo $result['money'] . '万元' ?></td>
                            <td class="tit01">工程工期：</td>
                            <td><?php echo $result['duration'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">预计开始时间：</td>
                            <td><?php echo $result['start'] ?></td>
                            <td class="tit01">结束时间：</td>
                            <td><?php echo $result['end'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">项目简介：</td>
                            <td colspan="3"><?php echo $result['summary'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">建设单位：</td>
                            <td colspan="3"><?php echo $result['company'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">联系人：</td>
                            <td><?php echo $result['name'] ?></td>
                            <td class="tit01">联系方式：</td>
                            <td><?php echo $result['phone'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01">建设单位地址：</td>
                            <td colspan="3"><?php echo $result['address'] ?></td>
                        </tr>
                        <tr>
                            <td class="tit01"> 相关文件：</td>
                            <td colspan="3">
                                <?php foreach ($result['files'] as $v) { ?>
                                    <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>
    </body>

</html>
