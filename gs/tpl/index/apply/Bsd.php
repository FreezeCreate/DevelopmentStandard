<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">报损单</span><span class="Close"></span></div>
        <div class="FrameBox">
            <form action="" method="" id="check_form" onsubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                <div class="FrameCont">
                    <div class="textRight">
                        <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                        <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                    </div>
                    <div class="FrameTable" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title'] ?></h3>
                        <h3 style="font-size: 16px; line-height: 60px;"><?php echo $result['number'] ?></h3>
                        <table class="Table TabBg TabInp">
                            <thead>
                                <tr>
                                    <td class="textRight">申请部门</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <?php echo $result['dep'] ?>
                                    </td>
                                    <td class="textRight">日期</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <?php echo $result['dt'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="100">序号</th><th style="width:250px;">项目</th><th width="100">数量</th><th>单价</th>
                                    <th>金额</th><th>存放地点</th><th>备注</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter TabInp add">
                                <?php foreach ($result['children'] as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['num'] > 0 ? $v['num'] : '' ?></td>
                                        <td><?php echo $v['price'] > 0 ? $v['price'] : '' ?></td>
                                        <td><?php echo $v['money'] > 0 ? $v['money'] : '' ?></td>
                                        <td><?php echo $v['address'] ?></td>
                                        <td><?php echo $v['explain'] ?></td>
                                    </tr>
                                    <?php $num += $v['num'];
                                    $money += $v['money'];
                                } ?>
                            </tbody>
                            <tfoot class="textCenter">
                                <tr>
                                    <td class="textCenter" colspan="2">合计：</td>
                                    <td class="pdX10  textCenter"><?php echo $num; ?></td>
                                    <td class="pdX10  textLeft"></td>
                                    <td class="pdX10  textCenter"><?php echo $money; ?></td>
                                    <td class="pdX10  textLeft"></td>
                                    <td class="pdX10  textLeft"></td>
                                </tr>
                                <tr>
                                    <td class="">申请人：</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <div class="UpgrapImg">
                                            <img class="" src="<?php echo $result['uname']; ?>"/>
                                        </div>
                                    </td>
                                    <td class="">报损原因：</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <?php echo $result['case'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">部门经理：</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <div class="UpgrapImg">
                                            <!--<img class="" src="<?php echo $result['uname']; ?>"/>-->
                                        </div>
                                    </td>
                                    <td class="">成本会计：</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <div class="UpgrapImg">
                                            <!--<img class="" src="<?php echo $result['uname']; ?>"/>-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">财务经理：</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <div class="UpgrapImg">
                                            <!--<img class="" src="<?php echo $result['uname']; ?>"/>-->
                                        </div>
                                    </td>
                                    <td class="">执行总经理：</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <div class="UpgrapImg">
                                            <!--<img class="" src="<?php echo $result['uname']; ?>"/>-->
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="FrameTableFoot">
        </div>
    </div>
</body>
<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
<!--日期插件-->
<script type="text/javascript">
                $(function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    window.onresize = function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    };
                });
</script>
</html>
