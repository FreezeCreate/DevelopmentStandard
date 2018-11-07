<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>合同管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="Frame">
			<div class="FrameTit"><span class="FrameTitName">合同管理</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
					<div class="FrameTableTitl">合同管理</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">合同编号</td>
                                <td colspan="3"><?php echo $hnumber;?>
                                <input type='hidden' value='<?php echo $hnumber;?>' name='hnumber'/>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">项目编号</td>
                                <td>
                                    <input class="FrameGroupInput" type="text" name="number" value="<?php echo $result['number']; ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/>
                                     <?php if(empty($result)){?><a class="btn btn-sm btn-primary selectN">查询</a><?php } ?>
                                </td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 签订时间</td>
                                <td><input class="FrameGroupInput" type="text" readonly="true" id="date" name="signdt" value="<?php echo $result['signdt']; ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">签订人</td>
                                <td id='aname'>
                                    <?php echo $adm['name'];?>
                                </td>
                                <td class="FrameGroupName">客户</td>
                                <td id='custname'>
                                    <?php echo  $result['custname'];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 合同总金额</td>
                                <td><input class="FrameGroupInput" type="text" name="money" value="<?php echo $result['money']; ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/> 元</td>
                                <td class="FrameGroupName"><span style='color:red'>*</span>提成%</td>
                                <td><input class="FrameGroupInput" type="text" name="unit" value="<?php echo $result['unit'] *100; ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/>%</td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">开始时间</td>
                                <td><input class="FrameGroupInput FrameDatGroup" type="text" readonly="true" id="start" name="startdt" value="<?php echo empty($result['startdt']) ? '' : $result['startdt'] ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/></td>
                                <td class="FrameGroupName">结束时间</td>
                                <td><input class="FrameGroupInput FrameDatGroup" type="text" readonly="true" id="end" name="enddt" value="<?php echo empty($result['enddt']) ? '': $result['enddt'] ?>"  <?php if(!empty($result)){?>disabled<?php } ?>/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain']; ?></textarea></td>
                            </tr> 
                            <tr>
                                <td class="FrameGroupName">合同款划拨金</td>
                                <td><input class="FrameGroupInput" type="text" name="moneys" value="" /> 元</td>
                                <td class="FrameGroupName">划拨时间</td>
                                <td> <input class="FrameGroupInput FrameDatGroup"  type="text" readonly="true" id="adddt1" name="haddt1" value=""/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">合同款划拨记录</td>
                                <td colspan='3' style='padding:0px'>
                                    <?php if(!empty($cbill)){ ?>
                                       <table width="100%">
                                        <tr>
                                            <td>记录人</td>
                                            <td>金额</td>
                                            <td>时间</td>
                                        </tr>

                                    <?php foreach($cbill as $k => $v){ ?>
                                        <tr>
                                           <td><?php echo $v['uname'];?></td>
                                           <td><?php echo $v['money']*1;?>元</td>
                                            <td><?php echo $v['adddt'];?></td>
                                        </tr>
                                    <?php }?>
                                        </table>
                                         <?php }else{ ?>
                                    <dl><p>还未录入拨款信息</p></dl>
                                    <?php } ?>
                           
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">相关文件</td>
                                <td colspan="3">
                                    <?php foreach ($result['files'] as $v) { ?>
                                        <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="del">删除</span></div>
                                    <?php } ?>
									<ul class="FileBox"></ul>
									<input type="file" class="None addFileVal fileToUpload"    name="fileToUpload" id="fileToUpload" />
									<span class="addFile" onclick="$('#fileToUpload').click()">+添加文件</span>
								
								</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
		 <div class="FrameTableFoot">
		<a class="but but-primary" onclick="do_sub()"><span class="Btn Big">提交</span></a>
		</div>
	</div>
        <!--<div class="upBox upBouxStyle" id="Users" style="width: 450px;margin-left: -225px;">
            <div class="upBox-t">
                <h3>请选择...</h3>
                <a class="close"><i class="icon-del"></i></a>
            </div>
            <div class="upBox-s">
                <input id="up-search01" type="text" placeholder="职位/姓名">
            </div>
            <div class="upBox-c" style="height: 100%;">
                <ul class="all-li">

                </ul>
                <ul class="th-li">
                    <li><a></a></li>
                </ul>
            </div>
            <div class="upBox-f">
                <button type="button" class="but but-primary" id="getUser">确定</button>
                <button type="button" class="but but-red" onclick="refresh()">刷新</button>
            </div>
        </div>-->

    </body>

</html>

<script>
            $(function(){
            $('.FrameBox').height($(window).height()-$('.FrameTit')[0].offsetHeight-$('.FrameTableFoot')[0].offsetHeight)
            window.onresize = function() {
               $('.FrameBox').height($(window).height()-$('.FrameTit')[0].offsetHeight-$('.FrameTableFoot')[0].offsetHeight)
            }});
    jeDate({
        dateCell: "#date", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#start", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    jeDate({
        dateCell: "#end", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });

    jeDate({
        dateCell: "#adddt1", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });

    $(function() {
        $(document).on('change', '.fileToUpload', function() {
            loading();
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: 'fileToUpload',
                dataType: 'json',
                data: {name: 'fileToUpload', id: 'fileToUpload'},
                error: function(data, status, e) {
                    loading('none');
                    alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam">' + data.data.filename + '</span><span class="DelFile">删除</span><input type="hidden" id="file" name="files[]" value="' + data.data.id + '"/></li>';
                        $('.FileBox').html(txt);
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
        $('.selectN').click(function(){
            var number = $('#check_form input[name="number"]').val();
            if(number != ''){
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "<?php echo spUrl('main', "selectSale"); ?>",
                    data: {number:number},
                    dataType: "json",
                    async: false,
                    error: function(request) {
                        loading('none');
                        alert('提交失败');
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            $('#aname').html(data.data.optname);
                            $('#custname').html(data.data.custname);
                        } else {
                            alert(data.msg);
                        }

                    }
                });
            }else{  
                alert('请输入要查询的合同编号');
            }
        });
        
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCustract"); ?>",
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
                     
                    Refresh();
                    Alert(data.msg);
                    parent.window.closHtml();
                } else {
                    alert(data.msg);
                    loading('none');
                }

            }
        });
    }

    

    function getUsers() {
        $.get('<?php echo spUrl('main', 'getUsers') ?>', {}, function(data) {
            if (data.status == 1) {
                var results = new Array();
                $.each(data.data, function(i, v) {
                    results.push('<li><a><i class="icon-company"></i> ' + v.shopname + '</a><ul>');
                    $.each(v.children, function(i1, v1) {
                        results.push('<li><a><i class="icon-branch"></i> ' + v1.department + '</a><ul>');
                        $.each(v1.children, function(i2, v2) {
                            var positionname = v2.positionname ? v2.positionname : '无';
                            results.push('<li><a lang="' + v2.id + '" title="' + v2.name + '"><i class="icon-user"></i> ' + v2.name + '（' + positionname + '）</a></li>');
                        });
                        results.push('</ul></li>');
                    });
                    results.push('</ul></li>');
                });
                $('#Users .upBox-c .all-li').html(results.join(''));
                loading('none');
            } else {
                loading('none');
                alert(data.msg);
            }
        }, 'json');
    }

    function refresh() {
        loading();
        getUsers();
    }
</script>