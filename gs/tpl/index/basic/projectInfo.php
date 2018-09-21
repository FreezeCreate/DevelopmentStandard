<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">产品详情</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp totalItem">
                            <thead>
                                <tr class="colorGre">
                                    <th>名称</th><th class="textLeft pdX10"><input type="text" name="name" value="<?php echo $result['name']?>"/></th>
                                    <th>规格</th><th class="textLeft pdX10"><input type="text" name="format" value="<?php echo $result['format']?>"/></th>
                                    <th>单位</th><th class="textLeft pdX10"><input type="text" name="unit" value="<?php echo $result['unit']?>"/></th>
                                    <th>成套价</th><th class="textLeft pdX10"><input type="text" name="price" value="<?php echo $result['price']?>"/></th>
                                </tr>
                                <tr class="colorGre">
                                    <th colspan="8">所需元器件</th>
                                </tr>
                                <tr>
                                    <th>序号</th><th>名称</th><th>型号规格</th><th>单位</th><th>数量</th><th>单价</th><th>小计</th><th></th>
                                </tr>
                            </thead>
                            <tbody class="TabBg textCenter add">
                                <?php foreach ($result['mater'] as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k+1;?></td>
                                        <td class="ChousCs" data-id=""><?php echo $v['name']?></td>
                                        <td class="Chousxh"><?php echo $v['format']?></td>
                                        <td class="Chousdw"><?php echo $v['unit']?></td>
                                        <td class="Choussl total num"><?php echo $v['num']?></td>
                                        <td class="Chousdj total price"><?php echo $v['price']?></td>
                                        <td class="Chousxj total val"><?php echo $v['money']?></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="textCenter totalMneu"><td>合计</td><td class="hjdx"></td><td></td><td></td><td class="total"></td><td></td><td class="total all"><?php echo $result['total']?></td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
                <div style="height: 50px;"></div>
            </div>
            <div class="ChousCS cs">
                <div class="ChousSerch cs">
                    <input class="ChousSerchItem cs" type="text" name="" id="" />
                    <div class="ChousBox top20 cs">
                        <div class="ChousBoxTit cs">
                            <span class="cs">名称</span><span class="cs">规格</span><span class="cs">单位</span><span class="cs">单价</span>
                        </div>
                        <div class="ChousBoxScroll cs">
                            <table class="cs ids">
                                <thead>

                                </thead>
                                <tbody>
                                    <?php foreach ($mater as $v) { ?>
                                        <tr class="cs tr"data-id="<?php echo $v['id'] ?>">
                                            <td class="cs"><?php echo $v['name'] ?></td>
                                            <td class="cs"><?php echo $v['format'] ?></td>
                                            <td class="cs"><?php echo $v['unit'] ?></td>
                                            <td class="cs"><?php echo $v['price'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="FrameTableFoot">
        </div>
    </div>

</body>
<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
    });
    
</script>
</html>


