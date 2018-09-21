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
                        <div class="FrameTableTitl">资料详情</div>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">客户名称：</td>
                                <td><?php echo $result['name'] ?></td>
                                <td class="FrameGroupName">来源：</td>
                                <td><?php echo $GLOBALS['CUST_LAIYUAN'][$result['laiyuan']] ?></td>
                            </tr><tr>
                                <td class="FrameGroupName">客户单位：</td>
                                <td colspan='3'><?php echo $result['unitname'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">客户类型</td>
                                <td><?php echo $GLOBALS['CUST_TYPE'][$result['type']]; ?></td>
                                <td class="FrameGroupName">职位：</td>
                                <td><?php echo $GLOBALS['CUST_POSIT'][$result['position']] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">联系手机：</td>
                                <td><?php echo $result['mobile'] ?></td>
                                <td class="FrameGroupName">联系电话：</td>
                                <td><?php echo $result['tel'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 邮箱：</td>
                                <td colspan="3"><?php echo $result['email'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 地址：</td>
                                <td colspan="3"><?php echo $result['address'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 交通路线：</td>
                                <td colspan="3"><?php echo $result['routeline'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">备注：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">状态：</td>
                                <td><?php echo $GLOBALS['CUST_STATUS'][$result['status']] ?></td>
                                <td class="FrameGroupName">是否标★：</td>
                                <td><?php echo 1 == $result['isstat'] ? '是' : '否' ?></td>
                            </tr>
                            <tr>
                                <td class='FrameGroupName'>客户状态变更</td>
                                <td colspan='3'>
                                    <?php if ($result['uid'] == $admin['id']) { ?>
                                        <a href='javascript:void(0)' class='Btn upstatus' data-bind='2' data-id='<?php echo $result['id']; ?>'>转入跟进客户</a> 
                                            <?php if (1 == 2) { ?><a href='javascript:void(0)' class='Btn upstatus' data-bind='3' data-id='<?php echo $result['id']; ?>'>转入签约客户</a><?php } ?>
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
<script type="text/javascript">
    $(function() {
        $('.upstatus').click(function() {
            var id = $(this).attr('data-id');
            var bid = $(this).attr('data-bind');
            if (bid == 2) {
                var ti = '确定该客户转入跟进客户吗？';
            }
            if (bid == 3) {
                var ti = '确定该客户转入签约客户吗？'
            }
            Confirm(ti, function(e) {
                if (e) {
                    $.get("<?php echo spUrl($c, "upCustomer"); ?>", {id: id, bid: bid}, function(data) {
                        Alert(data.msg, function() {
                            if (data.status == 1) {
                                 
                                Refresh();
                            }
                        });
                    }, 'json');
                }
            });
        })
    })
</script>