<?php require_once TPL_DIR . '/layout/header.php'; ?>
<style type="text/css">
.operate2{width:260px;}
.operate2 table{width: 100%}
.operate2 table th{width: 33%}
</style>
<section id="content">
    <?php require_once TPL_DIR . '/layout/left.php'; ?>
    <div id="main" class="main">
        <div class="left-bg"></div>
        <div class="right-bg"></div>
        <div class="left-bottom-bg"></div>
        <div class="right-bottom-bg"></div>
        <div class="main-title">
            <h3>部门绩效</h3>
            <div class="tool">
                <a class="btn btn-primary" onclick="fill_apply(38)"> 新 增</a>
            </div>
        </div>
        <div class="content">
            <div class="clear" style="height: 20px;"></div>
            <table class="table table-info table-hover" id="userlst">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>月份</th>
                        <th>完成绩效</th>
                        <th>总绩效</th>
                        <th>完成度</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k+1;?></td>
                            <td><?php echo $v['month'];?></td>
                            <td><?php echo $v['wmoney'];?></td>
                            <td><?php echo $v['money'];?></td>
                            <td><?php echo round(($v['wmoney'] / $v['money']),2)*100; ?>%</td>
                            <td><?php echo $v['content'];?></td>
                            <td>
                                <a class="getOper" itemid="<?php echo $v['id'] ?>">操作 ∨</a>
                                <div class="operate" itemid="">
                                    <ul>
                                        <?php if($v['status'] < 3){?>
                                            <li><a onclick="fill_apply(38,<?php echo $v['id'] ?>)">编辑</a></li>
                                        <?php } ?>
                                        <li><a onclick="check_apply(38,<?php echo $v['id'] ?>)">详情</a></li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php require_once TPL_DIR . '/layout/page.php'; ?>
        </div>
    </div>
</section>
</body>

</html>

<script type="text/javascript">
    
    function del_form(id){
        if (confirm('确定删除该案例信息?')) {
            $.post("<?php echo spUrl($c, "delCase"); ?>",{id:id}, function(data) {
                if (data.status == 1) {
                    alert(data.msg);
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
            }, 'json');
        }
    }

    $(function(){
        $('.upQuota').click(function(){
            var id = $('.upQuota').attr('itemid');
            if(id > 0){

            }
            $('#eid').val(id);
            $('#genjin').show();
        });
    })

    function do_add(){
        if(confirm('已确定部门绩效，并审核过后将不可修改!')){
            loading();
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "addQuota"); ?>",
                data: $('#quota_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    loading('none');
                    alert('提交失败');
                },
                success: function(data) {
                    if (data.status == 1) {
                        loading('none');
                        alert(data.msg);
                        $('#genjin .close').click();
                    } else {
                        loading('none');
                        alert(data.msg);
                    }

                }
            });
        }
    }

</script>
