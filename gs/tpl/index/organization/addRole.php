<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>职位管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/style.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/index.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
    </head>
<body>
    <!--
                    作者：895635200@qq.com
                    时间：2017-08-11
                    描述：主内容区域
    -->
		<div class="ContentBox">
			<div class="Tables">
				<div class="TablesHead">
					<ul class="TablesHeadNav">
						<li class="TablesHeadItem active" style="padding:3px">
						<a><?php echo isset($id) ? '编辑' : '添加'; ?>角色</a>
						</li>
						<li class="TablesHeadItem" >
							<a class="btn btn-primary" href="<?php echo spUrl($c, 'role') ?>"> 返 回 </a>
						</li>
					</ul>
				</div>
        <!-- DATA TABLES -->
            <div class="TablesBody top20">
            <form id="submit_form" class="form-horizontal" role="form" onsubmit="return false">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0; ?>">
                <table style="text-align:left;">
					<tr>
						<td width="200px">角色名称：</td>
						<td>	
                        <input type="text" name="name" class="form-control TablesSerchInput" placeholder="角色名称" value="<?php echo isset($result["name"]) ? $result["name"] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td colspan="2">  
							<label class="checkbox-inline">
								<input type="checkbox" id="allcheck" value=""> 全选
							</label>
						 </td>
					</tr>

                <?php foreach ($results as $k => $v) { ?>
                   <tr>
						<td>
                        <label title="全选" class="col-label"><input type="checkbox" class="allcheck check hidden" name="auth[]" value="<?php echo $v['id'] ?>" <?php echo in_array($v['id'], $result['promission']) ? 'checked=""' : '' ?>><?php echo $v['title'] ?></label>
                        </td>
							<td>
                            <?php foreach ($v['children'] as $k1 => $v1) { ?>
								
                                    <input class="<?php echo count($v1['children'])>0?'allcheck1':''?> check check<?php echo $v['id'] ?>" type="checkbox" name="auth[]" value="<?php echo $v1['id'] ?>" <?php echo in_array($v1['id'], $result['promission']) ? 'checked=""' : '' ?>> <?php echo $v1['title'] ?>
								
								
                            <?php foreach ($v1['children'] as $k2 => $v2) { ?>
								
                                    <input class="check check<?php echo $v['id'] ?> check<?php echo $v1['id'] ?>" type="checkbox" name="auth[]" value="<?php echo $v2['id'] ?>" <?php echo in_array($v2['id'], $result['promission']) ? 'checked=""' : '' ?>> <?php echo $v2['title'] ?>
								
                            <?php } ?>
								
                            <?php } ?>
							</td>	
                   </tr>
                <?php } ?>
                <tr>
                    <td colspan="2">
                        <button class="but but-primary TablesSerchSubmit" style="border:0px"  onclick="do_submit()">保 存</button>
                       <button class="but but-gray TablesSerchSubmit" style="border:0px"> <a href="<?php echo spUrl($c, 'role') ?>">取 消</a></button>
                    </td>
				</tr>
				</table>
            </form>
        </div>
        <!-- /DATA TABLES -->
    </div>
</section>
<!--/PAGE -->

<!-- /JAVASCRIPTS -->
</body>
</html>

<script>
    function do_submit() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveRole"); ?>",
            data: $('#submit_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                alert("数据提交失败！");
            },
            success: function(data) {
                alert(data.msg);
                if (data.status == 1) {
                    history.go(-1);
                }
            }
        });
    }
    ;

    $('#allcheck').click(function() {
        if (this.checked) {
            $(".check").each(function() {
                this.checked = true;
            });
        } else {
            $(".check").each(function() {
                this.checked = false;
            });
        }
    });

    $('.allcheck').click(function() {
        var id = $(this).val();
        if (this.checked) {
            $(".check" + id).each(function() {
                this.checked = true;
            });
        } else {
            $(".check" + id).each(function() {
                this.checked = false;
            });
        }
    });

    $('.allcheck1').click(function() {
        var id = $(this).val();
        if (this.checked) {
            $(".check" + id).each(function() {
                this.checked = true;
            });
        } else {
            $(".check" + id).each(function() {
                this.checked = false;
            });
        }
    });
    
    $('.check').click(function(){
        var allcheck = document.getElementsByClassName('allcheck');
        var allcheck1 = document.getElementsByClassName('allcheck1');
        for(var i = 0;i<allcheck1.length;i++){
            var id = $('.allcheck1').eq(i).val();
            if($(".check" + id+':checked').length>0){
                allcheck1[i].checked = true;
            }else{
                allcheck1[i].checked = false;
            };
        }
        for(var i = 0;i<allcheck.length;i++){
            var id = $('.allcheck').eq(i).val();
            if($(".check" + id+':checked').length>0){
                allcheck[i].checked = true;
            }else{
                allcheck[i].checked = false;
            };
        }
    });

</script>
