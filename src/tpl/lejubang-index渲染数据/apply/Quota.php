<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>部门绩效设置</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/apply.css" />
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="content" style="width: 800px;">
            <div class="ptitle">部门绩效设置</div>
            <div class="info">
                    <table class="table01">
                        <tbody>
                            <tr>
                                <td><span style="color:red;">*</span>月份</td>
                                <td><?php  echo $result['month']; ?></td>
                                <td><span style="color:red;">*</span>目标绩效</td>
                                <td><?php echo $result['money'];?></td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td colspan="3" ><?php echo $result['content'];?></textarea>
                            </tr>
                            <tr>
                                <td>部门成员</td>
                                <td>分配绩效</td>
                                <td>完成绩效</td>
                                <td>完成度</td>
                            </tr>
                            <?php foreach($depnames as $k => $v){ ?>
                            <tr>
                                <td><?php echo $v['name'];?></td>
                                <td><?php echo $result['assigns'][$v['id']]['money'];?></td>
                                <td><?php echo $result['assigns'][$v['id']]['ymoney'];?></td>
                                <td><?php echo round($result['assigns'][$v['id']]['ymoney']/$result['assigns'][$v['id']]['money'],2) * 100;?>%</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                        <div class="tit">审核处理</div>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table class="table01">
                                <tbody>
                                    <tr>
                                        <td class="tit01">状态：</td>
                                        <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
                                    <tr>
                                        <td>处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>说明：</td>
                                        <td><textarea class="form-control" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="but but-primary" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    <?php } ?>
            </div>
        </div>
        <div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>
    </body>

</html>

<script>
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>