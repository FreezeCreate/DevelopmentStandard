
<?php require_once TPL_DIR . '/layout/con_header.php'; ?>

<script src="<?php echo SOURCE_PATH; ?>/js/data.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div class="MainHtml">
        <div class="framemain">
            <div class="FrameTableTitl">添加部门</div>
            <table class="FrameTableCont">
                <tr>
                    <td class="FrameGroupName"><i class="colorRed">*</i>部门名称 ：</td>
                    <td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
                </tr>
                <tr>
                    <td class="FrameGroupName"><i class="colorRed">*</i>负责人 ：</td>
                    <td colspan="3">
                        <input class="input long text1" type="text" readonly="readonly" />
                        <input class="input text2" type="hidden"  />
                        <span class="btn btn-success btn-sm" onclick="ChousPerson(Use, 'two', '.text1', '.text2', this)">选择</span>
                    </td>
                </tr>
                <tr>
                    <td class="FrameGroupName">电话 ：</td>
                    <td colspan="3"><input class="input long" type="text" name="" id="" value="" /></td>
                </tr>
                <tr>
                    <td class="FrameGroupName">备注 ：</td>
                    <td colspan="3">
                        <textarea rows="10" class="input"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="frameFoot">
            <span class="btn btn-success pdX20 mg-r-30">确定</span>
            <span class="btn btn-info pdX20"onclick="parent.window.closHtml()">取消</span>
        </div>
    </div>
</body>
</html>
