<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>四川翼灵动</title>
    </head>
    <style type="text/css">
        .kkuo{height: 30px;line-height: 30px;text-align: center;width: 1100px}
        .kkuo span{font-size:14px;padding: 5px 10px}
        .kkuo2{height: 40px;line-height: 40px;width: 1100px}
        .kkuo2 span{font-size:14px;padding: 5px 10px}
        table{border: 1px solid #ccc;}
        th{border: 1px solid #ccc;line-height: 30px;font-size:12px;padding: 0px 5px}
        td{font-size:12px;padding: 0px 5px;line-height: 26px;}
        tr td{border: 1px solid #ccc;}
    </style>
        <div class='kkuo' >
        <span><?php echo $bumen;?>工资发放单</span>
        <span style='float:right'>日期：<?php echo $month;?></span>
        </div>
        <table cellpadding='0' cellspacing="0" border='0' width=1100>
            <thead>
                <tr>
                    <th>月份</th>
                    <th>核算</th>
                    <th>员工</th>
                    <th>基本工资</th>
                    <th>提成</th>
                    <th>全勤</th>
                    <th>餐补</th>
                    <th>车补</th>
                    <th>奖金</th>
                    <th>处罚</th>
                    <th>请假</th>
                    <th>实发工资</th>
                    <th style="width: 150px;">签字</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $k => $v) { ?>
                    <tr class="Results<?php echo $v['id'] ?>">
                        <td><?php echo $k + 1; ?></td>
                        <td><?php echo $GLOBALS['GRANT_TYPE'][$v['status']];?></td>
                        <td><?php echo $v['uname'] ?></td>
                        <td><?php echo $v['jiben'];?></td>
                        <td><?php echo $v['ticheng'];?></td>
                        <td><?php echo $v['quanqin'];?></td>
                        <td><?php echo $v['canbu'];?></td>
                        <td><?php echo $v['chebu'];?></td>
                        <td><?php echo $v['jiangjin'];?></td>
                        <td>-<?php echo $v['chufa'];?></td>
                        <td>-<?php echo $v['qingjia'];?></td>
                        <td><?php echo $v['total'];?></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class='kkuo2'>
            <span>总经理签字：___________________</span>
            <span>发放人签字：___________________</span>
        </div>
</body>
</html>





