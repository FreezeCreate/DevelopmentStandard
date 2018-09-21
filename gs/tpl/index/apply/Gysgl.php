<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">供应商管理报表</span><span class="Close"></span></div>
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
                                    <td class="textRight">供应商名称</td>
                                    <td class="pdX10  textLeft" colspan="3">
                                        <?php echo $result['name'] ?>
                                    </td>
                                    <td class="textRight">主要供货产品</td>
                                    <td class="pdX10  textLeft" colspan="4">
                                        <?php echo $result['produce'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="70">序号</th><th>考评内容</th><th>满分</th><th>实得分</th>
                                    <th>考核人</th><th>总送货次数</th><th>合格次数</th><th>不合格次数</th><th>评分等级</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter TabInp add">
                                <tr>
                                    <td>1</td>
                                    <td>供货质量</td>
                                    <td>60</td>
                                    <td class="colorRed totalVal"><?php echo $result['zhiliang'][1] ?></td>
                                    <td class="colorGre"><?php echo $result['zhiliang'][2] ?></td>
                                    <td class="totalVal"><?php echo $result['zhiliang'][3] ?></td>
                                    <td class="totalVal"><?php echo $result['zhiliang'][4] ?></td>
                                    <td class="totalVal"><?php echo $result['zhiliang'][5] ?></td>
                                    <td class=""><?php echo $result['zhiliang'][6] ?></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>服务</td>
                                    <td>5</td>
                                    <td class="colorRed totalVal"><?php echo $result['fuwu'][1] ?></td>
                                    <td class="colorGre"><?php echo $result['fuwu'][2] ?></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>投诉回复</td>
                                    <td>5</td>
                                    <td class="colorRed totalVal"><?php echo $result['tousu'][1] ?></td>
                                    <td class="colorGre"><?php echo $result['tousu'][2] ?></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>交货期</td>
                                    <td>20</td>
                                    <td class="colorRed totalVal"><?php echo $result['jiaohuo'][1] ?></td>
                                    <td class="colorGre"><?php echo $result['jiaohuo'][2] ?></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>价格</td>
                                    <td>10</td>
                                    <td class="colorRed totalVal"><?php echo $result['jiage'][1] ?></td>
                                    <td class="colorGre"><?php echo $result['jiage'][2] ?></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class="totalVal"></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="totalMneu">
                                    <td></td><td>总计</td><td>100</td><td class="colorRed"><?php echo $result['sum'] ?></td><td></td>
                                    <td></td><td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">综合考评：</td>
                                    <td colspan="7" class="pdX10"><div style="height:80px;"><?php echo $result['kaopin'] ?></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2">采购：</td><td class="pdX10" colspan="3"><?php echo $result['cg'] ?></td>
                                    <td>日期：</td><td colspan="3"class="textLeft"><?php echo $result['cgdt'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">质量负责人：</td><td class="pdX10" colspan="3"><?php echo $result['zl'] ?></td>
                                    <td>日期：</td><td colspan="3"class="textLeft"><?php echo $result['zldt'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clear" style="height:30px;"></div>
                        <div class="pdX10 textLeft">
                            <span class="">评分标准：</span>
                        </div>
                        <table class="Table textCenter TabBg">
                            <tbody>
                                <tr>
                                    <td>1</td><td>供货质量（60分）</td><td>优（55-60分）</td><td>良（50-55分）</td><td>中（45-50分）</td><td>差（45分以下）</td>
                                </tr>
                                <tr>
                                    <td>2</td><td>服    务（5分）</td><td>优（4.5-5分）</td><td>良（4-4.5分）</td><td>中（3-4分）</td><td>差（3分以下）</td>
                                </tr>
                                <tr>
                                    <td>3</td><td>投诉回复（5分）</td><td>优（4.5-5分）</td><td>良（4-4.5分）</td><td>中（3-4分）</td><td>差（3分以下）</td>
                                </tr>
                                <tr>
                                    <td>4</td><td>交货期（20分）</td><td>优（18-20分）</td><td>良（15-18分）</td><td>中（12-15分）</td><td>差（12分以下）</td>
                                </tr>
                                <tr>
                                    <td>5</td><td>价格（10分）</td><td>优（9-10分）</td><td>良（8-9分）</td><td>中（7-8分）</td><td>差（7分以下）</td>
                                </tr>
                                <tr>
                                    <td>说明：</td><td colspan="5" class="pdX10 textLeft">得分90分或以上可以保持合格供应商资格，90分以下取消合格供应商资格。</td>
                                </tr>
                            </tbody>
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
<script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript">
                $(function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    window.onresize = function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                    };
                });
</script>
</html>
