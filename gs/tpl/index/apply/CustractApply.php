<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>客户信息</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">客户信息</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">客户签约合同申请</div>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">编号：</td>
                                <td><?php echo $sale['number']; ?></td>
                                <td class="FrameGroupName">申请时间：</td>
                                <td><?php echo $result['applydt']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">申请人：</td>
                                <td><?php echo $ygong['name'] ?></td>
                                <td class="FrameGroupName">部门：</td>
                                <td><?php echo $ygong['shopname'].$ygong['departmentname']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">预计金额：</td>
                                <td><?php echo $sale['money'] ?></td>
                                <td class='FrameGroupName'></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 备注说明：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </table>
                      <div class="FrameListTable">
                            <p class="FrameListTableTit">处理记录</p>
                            <table class="FrameListTableItem">
                                <thead>
                                    <tr>
                                        <td class="tit01">序号</td>
                                        <td class="tit01">操作人</td>
                                        <td class="tit01">操作状态</td>
                                        <td class="tit01">说明</td>
                                        <td class="tit01">时间</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $bill['uname'] ?></td>
                                        <td>提交</td>
                                        <td></td>
                                        <td><?php echo $bill['applydt'] ?></td>
                                    </tr>
                                    <?php foreach ($log as $k => $v) { ?>
                                        <tr>
                                            <td><?php echo $k + 2; ?></td>
                                            <td><?php echo $v['checkname']; ?></td>
                                            <td><?php echo $v['statusname']; ?></td>
                                            <td>
                                                <?php echo $v['explain']; ?>
                                                <?php foreach ($v['files'] as $v1) { ?>
                                                <div class="download"><a class="download-a" href="javascript:void(0)" style="color: #007aff;" itemid="<?php echo $v1['id'] ?>" title="点击下载"><?php echo $v1['filename'] ?></a>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $v['optdt']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                        <div class="FrameListTable">
                            <p class="FrameListTableTit">审核处理</p>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table  class="FrameTableCont">
                                <thead>
                                    <tr>
                                        <td class="FrameGroupName">状态：</td>
                                        <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="FrameGroupName">处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">说明：</td>
                                        <td><textarea class="FrameGroupInput" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">相关文件 ：</td>
                                        <td>
                                            <ul class="FileBox">
                                                <?php foreach ($result['files'] as $v) { ?>
                                                    <li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="DelFile">删除</span></li>
                                                <?php } ?>
                                            </ul>
                                            <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                            <span class="addFile">+添加文件</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="Btn Btn-info" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight)
            }
        })
    </script>
</html>
<script>



    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "/apply/saveCheck",
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
</script>