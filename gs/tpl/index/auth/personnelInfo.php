<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">员工详情</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">编号</td>
                                <td><?php echo $result['number'] ?></td>
                                <td class="FrameGroupName" rowspan="2">头像</td>
                                <td rowspan="2">
                                    <img class="userImg userhead" src="<?php echo empty($result['head']) ? SOURCE_PATH . '/images/head.png' : $result['head']; ?>"/>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">姓名</td>
                                <td><?php echo $result['name'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">部门</td>
                                <td><?php echo $result['dname'] ?></td>
                                <td class="FrameGroupName">职位</td>
                                <td><?php echo $result['pname'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">直属上级</td>
                                <td><?php echo $result['sname'] ?></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 手机号</td>
                                <td><?php echo $result['phone'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">登录账号</td>
                                <td><?php echo $result['username'] ?></td>
                                <td class="FrameGroupName">性别</td>
                                <td><?php echo $result['sex']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 员工状态</td>
                                <td><?php echo $GLOBALS['USER_DIR'][$v['dir']]?></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 入职日期</td>
                                <td><?php echo $result['workdate'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">邮箱</td>
                                <td><?php echo $result['email'] ?></td>
                                <td class="FrameGroupName">QQ</td>
                                <td><?php echo $result['QQ'] ?></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
    });
</script>

