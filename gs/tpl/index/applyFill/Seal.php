<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>添加印章</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
                        <script>
            var Use;
//            var Pos;
//            var Dep;
            $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                    Use = {}
                    Use.status = 2;
                    Use.data = data.data[0].children;
            }, 'json');
            //职位
//            $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
            //部门
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');
        </script>
    </head>
    <body>
        <div class="Frame">
			<div class="FrameTit"><span class="FrameTitName">添加印章</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    	<div class="FrameTableTitl">添加印章</div>
						<table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 印章名称：</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 印章类型：</td>
                                <td>
                                    <select class="FrameGroupInput" name="type">
                                        <option value="">请选择...</option>
                                        <?php foreach ($GLOBALS['SEAL_TYPE'] as $v) { ?>
                                            <option <?php echo $v === $result['type'] ? 'selected=""' : '' ?> value="<?php echo $v ?>"><?php echo $v ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 保管人</td>
                                <td colspan="3">
                                    <input type="text" class="FrameGroupInput disabled get-upBox uname" readonly="readonly"  data-bind="Users" name="uname" value="<?php echo $result['uname'] ?>"/>
                                    <input type="hidden" id="uid" class="uid" name="uid" value="<?php echo $result['uid'] ?>"/>
                                        <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">电子章图片</td>
                                <td colspan="3">
                                    <input type="file" class="scimage" style="display:none;" name="fileToUpload2" id="fileToUpload2"/>
                                    <div class="upimg" onclick="$('#fileToUpload2').click()"><img  width="100px" height="100px" src="<?php echo empty($result['image'])?SOURCE_PATH.'/images/liaotshi_78.png':$result['image']; ?>"/><input type="hidden" name="image" value="<?php echo empty($result['image'])?'':$result['image']; ?>"/></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">说明</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
			<div class="FrameTableFoot">
				<a class="but but-primary" ><span class="Btn Big" onclick="do_sub()"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
			</div>
      </div>
 </body>

</html>

<script>

    $(function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        };
    $(document).on('change', '.scimage', function() {
        loading();
        var name = $(this).attr('name');
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "upload"); ?>',
            secureuri: false,
            fileElementId: name,
            dataType: 'json',
            data: {name: name, id: name},
            error: function(data, status, e) {
                loading('none');
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    var src = '/tmp/' + data.src;
                    $('#' + name).next('.upimg').children('img').attr('src', src);
                    $('#' + name).next('.upimg').children('input').val(src);
                    loading('none');
                } else {
                    $('#' + name).val('');
                    loading('none');
                    alert(data.msg);
                }
            },
        });
        return false;
    });

        $(document).on('click', '.upBox .upBox-c ul li a', function() {
            $(this).parent('li').children('ul').toggle();
        });
        $(document).on('click', '#Users .upBox-c .all-li li ul li ul li a', function() {
            $('#Users .upBox-c ul li a').removeClass('active');
            $(this).addClass('active');
        });
        $(document).on('click', '#Users .upBox-c .th-li li a', function() {
            $('#Users .upBox-c ul li a').removeClass('active');
            $(this).addClass('active');
        });
        $(document).on('keyup', '#up-search01', function() {
            var seatxt = $(this).val();
            if (seatxt != '') {
                var sea = $('#Users .upBox-c .all-li li ul li ul li a:contains("' + seatxt + '")');
                var txt = '';
                for (var i = 0; i < sea.length; i++) {
                    txt += '<li>' + sea.eq(i).parent('li').html() + '</li>';
                }
                $('#Users .upBox-c .all-li ul li a').removeClass('active');
                $('#Users .upBox-c .th-li').html(txt);
                $('#Users .upBox-c .all-li').hide();
                $('#Users .upBox-c .th-li').show();
            } else {
                $('#Users .upBox-c .all-li ul li a').removeClass('active');
                $('#Users .upBox-c .th-li').hide();
                $('#Users .upBox-c .all-li').show();
            }
        });

        $('#getUser').click(function() {
        var id = $('#Users .PersonList ul li.active').attr('data-id');
        var name = $('#Users .PersonList  ul li.active').attr('data-val');
            $('#uid').val(id);
            $('#uname').val(name);
            $('.close').click();
        });

       
    });

	
	


    function refresh() {
        //loading();
        getUsers();
    }

    function do_sub() {
        //loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveSeal"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
               // loading('none');
                alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    //loading('none');
                     
                    Refresh();
                } else {
                    alert(data.msg);
                   // loading('none');
                }

            }
        });
    }
	$('.close').click(function(){
		$('.PersonBox').animate({'top': '-500px'},300,function(){
			$('.Person').hide()
		})
	})


	
	
</script>