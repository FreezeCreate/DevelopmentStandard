
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
<script>
    var Use;
    $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                Use = data;
//              alert(Use);
    }, 'json');
        </script>
</head>
<body>
    <div class="MainHtml">
        <form action="" method="" id="check_form" onsubmit="return false;">
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
            <div class="framemain">
            <div class="FrameTableTitl">请假申请</div>
            <table class="FrameTableCont">
            	<tr>
                    <td class="FrameGroupName">请假人 ：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" name="uname" id="" value="<?php echo $user['cname']?>" readonly="readonly"/>
                    </td>
               </tr>
                <tr>
                    <td class="FrameGroupName">请假类型 ：</td>
                    <td colspan="3">
                    	<select name="type"class="input">
                            <option <?php echo $result['type']==='事假'?'selected=""':''; ?> value="事假">事假</option>
                            <option <?php echo $result['type']==='病假'?'selected=""':''; ?> value="病假">病假</option>
                            <option <?php echo $result['type']==='年假'?'selected=""':''; ?> value="年假">年假</option>
                        </select>
                    </td>
                </tr>
            	<tr>
                    <td class="FrameGroupName">开始时间 ：</td>
                    <td>
                        <input class="input dates" type="text" name="start"  value="<?php echo empty($result['start'])?'':$result['start']; ?>" readonly="readonly"/>
                    </td>
                    <td class="FrameGroupName">结束时间 ：</td>
                    <td>
                        <input class="input dates" type="text" name="end" value="<?php echo empty($result['end'])?'':$result['end'] ?>" readonly="readonly"/>
                    </td>
               </tr>
            	<tr>
                    <td class="FrameGroupName">请假说明 ：</td>
                    <td colspan="3">
                    	<textarea name="explain" class="input"><?php echo $result['explain'] ?></textarea>
                    </td>
              </tr>
            </table>
        </div>
        <div class="frameFoot">
            <span class="btn btn-success pdX20 mg-r-30" onclick="do_sub()">确定</span>
            <span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
        </div>
        </form>
    </div>
</body>
</html>

<script type="text/javascript">
    jeDate({
        dateCell:".dates",
        format:"YYYY-MM-DD",
        isinitVal:false,
        isTime:true, //isClear:false,
        minDate:"2014-09-19 00:00:00",
        okfun:function(val){/*alert(val)*/}
    })
    $('.addFile').click(function() {
        $(this).prev().click()
    })



    function do_sub() {
        //var formData = new FormData($("#upload")[0]);
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "addreast"); ?>",
            data: $('#check_form').serialize(),
            //data: formData,
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.code == 0) {
                    Alert(data.msg, function(){
                        parent.window.closHtml();
                        Refresh();
                    });
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>