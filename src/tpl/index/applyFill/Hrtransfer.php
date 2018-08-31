
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="/source/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>

<!--<script src="<?php /*echo SOURCE_PATH; */?>/js/data.js" type="text/javascript" charset="utf-8"></script>-->
    <script>
        var Use;
        var Dep;
        var Pos1;
        $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
                Use = data;
        }, 'json');
        $.get('<?php echo spUrl('main', "getDepartment");?>', {id: 5}, function(data){
            Dep = data;
        }, 'json');
        $.get('<?php echo spUrl('main', "getPosition");?>', {id: 5}, function(data){
            Pos1 = data;
        }, 'json');
    </script>
</head>
<body>
    <div class="MainHtml">
        <form action="" method="" id="check_form" onsubmit="return false;" enctype="multipart/form-data">
        <div class="framemain">
            <div class="FrameTableTitl">人事调动</div>
            <table class="FrameTableCont">
            	<tr>
                    <td class="FrameGroupName">调动人员 ：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" name="tranuname" value="" readonly="readonly"/>
                        <input class="input text2" type="hidden" name="tranuid" value="" />
                        <!--<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</span>-->
                        <span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'one', '.text1', '.text2', this)">选择</span>
                    </td>
                </tr>
            	<tr>
                    <td class="FrameGroupName">调动后部门 ：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" name="eudept" readonly="readonly"/>
                        <input class="input text2" type="hidden" name="eudeptid"  />
                        <!--<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span>-->
                        <span class="btn btn-success btn-sm" onclick="ChousPerson(Dep, 'one', '.text1', '.text2', this)">选择</span>
                    </td>
                </tr>
                <tr>
                    <td class="FrameGroupName">调动后部职位：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" name="eposition" readonly="readonly"/>
                        <input class="input text2" type="hidden" name="epositionid"  />
                        <!--<span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span>-->
                        <span class="btn btn-success btn-sm" onclick="ChousPerson(Pos1, 'one', '.text1', '.text2', this)">选择</span>
                    </td>
                </tr>
                <tr>
                    <td class="FrameGroupName">调动类型 ：</td>
                    <td colspan="3">
                    	<select name="type" class="input">
                    		<option value="平调">平调</option>
                    		<option value="晋升">晋升</option>
                    		<option value="降职">降职</option>
                    	</select>
                    </td>
                </tr>
                <tr>
                    <td class="FrameGroupName"><i class="colorRed">*</i>调动说明 ：</td>
                    <td colspan="3">
                        <textarea rows="10" name="explain" class="input"></textarea>
                    </td>
                </tr>
                <tr>
					<td class="FrameGroupName">相关文件 ：</td>
					<td colspan="3">
						<ul class="FileBox"></ul>
						<input class="None addFileVal" type="file" name="files" id="files" value="" />
						<span class="addFile">+添加文件</span>
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

    $('.addFile').click(function() {
        $(this).prev().click()
    })

    $(document).on('change', '.addFileVal', function() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
            secureuri: false,
            fileElementId: 'files',
            dataType: 'json',
            data: {name: 'files', id: 'files'},
            success: function(data, status) {
                console.log(data)
                if (data.status == 1) {
                    $('#files').parent().children('.FileBox').append(
                        '<li class="FileItem"><span class="FileItemNam">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>'
                    )
                    $('#files').val('');
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    });
    $(document).on('click', '.DelFile', function(){
        var that = this;
        Confirm('确定删除？', function(e){
            if(e){
                $(that).parent().remove()
            }
        })
    })

    function do_sub() {
        //var formData = new FormData($("#upload")[0]);
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "adddiaod"); ?>",
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