<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">获证产品档案</span><span class="Close"></span></div>
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
                                    <th>序号</th><th>证书编号</th><th>产品名称</th><th style="width:200px;">型号规格</th><th>发证日期</th>
                                    <th>证书截止日期</th><th>报告编号</th><th>工厂检查报告</th><th>标志印刷编号</th><th>截止日期</th>
                                </tr>
                            </thead>
                            <tbody class="add textCenter">
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td><?php echo $k+1;?></td>
                                    <td class="textLeft"><?php echo $v['number']?></td>
                                    <td class="textLeft"><?php echo $v['name']?></td>
                                    <td class="textLeft"><?php echo $v['format']?></td>
                                    <td class="textLeft"><?php echo $v['fzdt']?></td>
                                    <td class="textLeft"><?php echo $v['zsenddt']?></td>
                                    <td class="textLeft"><?php echo $v['bgnumber']?></td>
                                    <?php if($k==0){?>
                                    <td class="row textLeft" rowspan="<?php echo count($result['children'])?>"><?php echo $result['jcbg']?></td>
                                    <?php }?>
                                    <td class="textLeft"><?php echo $v['bznumber']?></td>
                                    <td class="textLeft"><?php echo $v['enddt']?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <div class="End top20 pdX20">
                            <div class="EndItem">
                                <p><span class="w-100">检查人/日期：</span></p>
                                <div class="UpgrapImg">
                                    <img class="" src="<?php echo $result['uname']; ?>"/>
                                </div>
                            </div>
                        </div>
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
