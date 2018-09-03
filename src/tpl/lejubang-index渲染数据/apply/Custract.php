<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>合同管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">合同信息</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">合同信息</div>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">合同编号</td>
                                <td colspan="3"> <?php echo $result['hnumber']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">项目编号</td>
                                <td>
                                    <?php echo $result['number']; ?>
                                </td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 签订时间</td>
                                <td><?php echo $result['signdt']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">签订人</td>
                                <td id='aname'>
                                    <?php echo $admin['name'];?>
                                </td>
                                <td class="FrameGroupName">客户</td>
                                <td id='custname'>
                                    <?php echo  $result['custname'];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 合同总金额</td>
                                <td><?php echo $result['money']; ?>元</td>
                                <td class="FrameGroupName"><span style='color:red'>*</span>提成%</td>
                                <td><?php echo $result['unit'] *100; ?>%</td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">开始时间</td>
                                <td><?php echo empty($result['startdt']) ? '' : $result['startdt'] ?></td>
                                <td class="FrameGroupName">结束时间</td>
                                <td><?php echo empty($result['enddt']) ? '': $result['enddt'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注</td>
                                <td colspan="3"><?php echo $result['explain']; ?></td>
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
                                    <?php foreach ($log as $k => $v) { ?>
                                        <tr>
                                            <td><?php echo $k + 1; ?></td>
                                            <td><?php echo $v['optname']; ?></td>
                                            <td><?php echo $v['stname']; ?></td>
                                            <td><?php echo $v['explain']; ?></td>
                                            <td><?php echo $v['dt']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
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

    $('input[name="status"]').click(function() {
        $('.st-next').addClass('hidden');
        if ($(this).val() == 3) {
            $('.st-next').removeClass('hidden');
        }
    });

    function do_subcheck() {
       // loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveContract"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    //loading('none');
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                   // loading('none');
                }

            }
        });
    }
</script>