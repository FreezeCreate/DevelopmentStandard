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
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <table class="table01">
                        <tbody>
                            <tr>
                                <td><span style="color:red;">*</span>月份</td>
                                <td>
                                    <?php if(empty($result['month'])){ ?>
                                    <select class="form-control"  name='month'>
                                        <?php for($i=0;$i<10;$i++){ ?>
                                        <option value= '<?php echo date('Ym',strtotime('+'.$i.' month'));?>'><?php echo date('Ym',strtotime('+'.$i.' month'));?></option>
                                        <?php  } ?>
                                    </select> 
                                    <?php }else{ echo $result['month']; } ?>
                                </td>
                                <td><span style="color:red;">*</span>目标绩效</td>
                                <td ><input class="form-control" type="text" name="money" value="<?php echo $result['money'];?>" readonly="readonly" /></td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td colspan="3" ><textarea class='form-control' value='' name='content'><?php echo $result['content'];?></textarea></td>
                            </tr>
                            <?php foreach($depnames as $k => $v){ ?>
                            <tr>
                                <td>部门成员</td>
                                <td><?php echo $v['name'];?><input type='hidden' id='assigns<?php echo $v['id'];?>' value='<?php echo $v['name'];?>' name='assigns[<?php echo $v['id'];?>][name]'/></td>
                                <td>分配绩效</td>
                                <td><input class="form-control fpmoney" type='text' id='aMoney<?php echo $v['id'];?>' value='<?php echo $result['assigns'][$v['id']]['money'];?>' name='assigns[<?php echo $v['id'];?>][money]'</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="center">
                        <a class="but but-primary" onclick="do_sub()"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear" style="height: 80px;"></div>
        <div id="loading" class="loading"><img src="<?php echo SOURCE_PATH; ?>/images/icons/loading04.gif"/></div>
        <div class="mark"></div>
    </body>

</html>

<script>

    $(function() {
        
        $('.fpmoney').keyup(function(){
            var fpmoney = 0;
            $('.fpmoney').each(function(){
                var mo = $(this).val();
                if(isNaN(mo) || mo <= 0){
                    $(this).val('');
                }
                fpmoney += $(this).val() * 1;
            })
            $('input[name="money"]').val(fpmoney);      
        });
    });

    function do_sub() {
        loading();
        var fpmoney = 0;
        var tmp = 0;
        $('.fpmoney').each(function(){
            var mo = $(this).val();
            if(isNaN(mo) || mo <= 0){
                tmp = 1;
            }
            fpmoney += $(this).val() * 1;

        })
        $('input[name="money"]').val(fpmoney);

        if(tmp == 1){
            alert('有员工未设置绩效');
            loading('none');
        }else{
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "saveQuota"); ?>",
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
    }
</script>