<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/details.css"/>
</head>
<body>
<div class="MainHtml">
    <div class="framemain">
        <div class="FrameTableTitl">打卡异常</div>
        <table class="FrameTableCont">
            <tr>
                <td class="FrameGroupName">异常类型：</td>
                <td><?php echo $result['type'] ?></td>
                <td class="FrameGroupName">申请时间：</td>
                <td><?php echo $result['applydt'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName">申请人：</td>
                <td><?php echo $result['uname'] ?></td>
                <td class="FrameGroupName">部门：</td>
                <td><?php echo $result['dname'] ?></td>
            </tr>
            <tr>
                <td class="FrameGroupName">异常日期：</td>
                <td><?php echo $result['date'] ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="FrameGroupName"> 说明：</td>
                <td colspan="3"><?php echo $result['explain'] ?></td>
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
