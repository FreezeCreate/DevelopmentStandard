<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>潜在项目</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/apply.css" />
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="content" style="width: 800px;">
            <div class="ptitle">潜在项目</div>
            <div class="info">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <table class="table01">
                        <tbody>
                            <tr>
                                <td class="tit01" style="width:150px;">项目名称：</td>
                                <td><?php echo $result['name'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">时间：</td>
                                <td><?php echo $result['time'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">上网地址：</td>
                                <td><?php echo empty($result['href'])?'':'<a target="_blank" href="'.$result['href'].'">'.$result['href'].'</a>' ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">招标公告编号：</td>
                                <td><?php echo $result['plNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">招标文件编号：</td>
                                <td><?php echo $result['fileNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">项目业主：</td>
                                <td><?php echo $result['owner'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">预计合同金额：</td>
                                <td><?php echo empty($result['money'])?'':$result['money'].'万元' ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">投标时间：</td>
                                <td><?php echo $result['bidtime'] ?></td>
                            <tr>
                                <td class="tit01">投标要求摘要：</td>
                                <td><?php echo $result['require'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01"> 备注：</td>
                                <td><?php echo $result['remark'] ?></td>
                            </tr>
                            <tr>
                                <td class="tit01"> 相关文件：</td>
                                <td>
                                    <?php foreach($result['files'] as $v){?>
                                    <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id']?>"><?php echo $v['filename']?></a>
                                    <?php }?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="title01">处理记录</div>
                    <table class="table02">
                        <tbody>
                            <tr>
                                <td class="tit01">序号</td>
                                <td class="tit01">处理人</td>
                                <td class="tit01">处理状态</td>
                                <td class="tit01">说明</td>
                                <td class="tit01">时间</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><?php echo $result['uname'] ?></td>
                                <td>提交</td>
                                <td></td>
                                <td><?php echo $result['applydt'] ?></td>
                            </tr>
                            <?php foreach ($log as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $k + 2; ?></td>
                                    <td><?php echo $v['checkname']; ?></td>
                                    <td><?php echo $v['statusname']; ?></td>
                                    <td><?php echo $v['explain']; ?></td>
                                    <td><?php echo $v['optdt']; ?></td>
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
                                    <tr class="st-next hidden">
                                        <td><span style="color:red;">*</span> 转到：</td>
                                        <td>
                                            <select class="form-control">
                                                <option>投标结果管理</option>
                                            </select>
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
    
    $('input[name="status"]').click(function(){
        if($(this).val()==3){
            $('.st-next').removeClass('hidden');
        }else{
            $('.st-next').addClass('hidden');
        }
    });
    
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
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>