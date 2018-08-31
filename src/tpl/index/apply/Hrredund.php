<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
</head>
<body>
<div class="MainHtml">
    <div class="framemain">
        <div class="FrameTableTitl">离职申请</div>
        <table class="FrameTableCont">
            <tr>
                <td class="FrameGroupName">申请时间：</td>
                <td><?php echo $result['applydt'] ?></td>
                <td class="FrameGroupName">申请人：</td>
                <td><?php echo $result['uname'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName">部门：</td>
                <td><?php echo $result['dname'] ?></td>
                <td class="FrameGroupName">职位：</td>
                <td><?php echo $result['position'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName">入职日期：</td>
                <td><?php echo $result['entrydt'] ?></td>
                <td class="FrameGroupName">离职日期：</td>
                <td><?php echo $result['leavedt'];?></td>
            </tr>
            <tr>
                <td class="FrameGroupName">离职类型：</td>
                <td><?php echo $result['type'] ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="FrameGroupName"> 离职原因：</td>
                <td colspan="3"><?php echo $result['cause'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName"> 说明：</td>
                <td colspan="3"><?php echo $result['explain'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName"> 相关文件：</td>
                <td colspan="3">
                    <?php foreach ($result['files'] as $v) { ?>
                    <div class="download"><a class="download-a FileItemNam colorBlu" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a>
                        <?php } ?>
                </td>
            </tr>
        </table>
        <div class="top20">
            <p class="taskjl">处理记录</p>
            <table class="table borderTr">
                <thead>
                <tr class="tablebg"><th>序号</th><th>操作人</th><th>操作状态</th><th>说明</th><th>时间</th></tr>
                </thead>
                <tbody class="textCenter hover">
                <?php
                foreach($log as $log_k => $log_v){
                    echo '<tr><td>'.($log_k + 1).'</td><td>'.$log_v['checkname'].'</td><td>'.$log_v['statusname'].'</td><td>'.$log_v['explain'].'</td><td>'.$log_v['optdt'].'</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
