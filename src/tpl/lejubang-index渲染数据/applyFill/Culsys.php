<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>通知公告</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/kindeditor-min.js"></script>
        <script charset="utf-8" src="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/lang/zh_CN.js"></script>
                <script>
            var Use;
//            var Pos;
//            var Dep;
/*            $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                    Use = {}
                    Use.status = 2;
                    Use.data = data.data[0].children;
            }, 'json');*/
            //职位
/*           $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
                   Dep = data;
           }, 'json');*/
            //部门
           $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
                   Pos = data;
           }, 'json');
        </script>
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">文化制度</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameTableTitl">新增文化制度</div>
                    <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName" style="width: 150px;"><span style="color:red;">*</span> 主题</td>
                                <td colspan="3"><input class="FrameGroupInput" style="width: 80%;" type="text" name="name" value="<?php echo $result['name'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 类型</td>
                                <td>
                                    <select class="FrameGroupInput" id="type" name="type">
                                    <?php foreach($GLOBALS['CULSYS_TYPE'] as $k => $v ){ ?>
                                        <option <?php echo $result['type']==$k?'selected=""':''; ?> value="<?php echo $k;?>"><?php echo $v;?></option>
                                    <?php  } ?>
                                    </select>
                                </td>
                                <td class="FrameGroupName">制定时间</td>
                                <td><input class="FrameGroupInput" type="text" readonly="true" id="date" name="zddt" value="<?php echo empty($result['zddt'])?date('Y-m-d'):$result['zddt'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">指定职位可见</td>
                                <td colspan="3">
                                    <input class="FrameGroupInput recename" readonly="readonly"   style="width: 72%;"  type="text" name="recename" value="<?php echo $result['recename'] ?>" placeholder="不选默认为所有职位"/>
                                     <input type="hidden" class="uid" name="receid" value="<?php echo $result['receid'] ?>"/>
                                    <a style="height: 12px" class="Btn Big btn-primary get-upBox"  onclick="ChousPerson(Pos, 'd', '.recename', '.uid', this)" data-bind="Position">选择</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">内容</td>
                                <td colspan="3"><textarea class="FrameGroupInput" name="content"><?php echo $result['content'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
          <div class="FrameTableFoot">
        <a class="but but-primary" onclick="do_sub()"><span class="Btn Big"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
        </div>
    </div>
  </body>

</html>

<script>
           $(function() {

                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
        }});


    KindEditor.ready(function(K) {
        K.create('textarea[name="content"]', {
            width: 500,
            autoHeightMode: true,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            afterCreate: function() {
            },
            afterBlur: function() {
                this.sync()
            },
        });
    });

    jeDate({
        dateCell: "#date", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });


   

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCulsys"); ?>",
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
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }



        KindEditor.ready(function(K) {
        K.create('textarea[name="content"]', {
            width: 500,
            autoHeightMode: true,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            afterCreate: function() {
            },
            afterBlur: function() {
                this.sync()
            },
        });
    });
</script>