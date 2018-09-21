<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">培训记录</span><span class="Close"></span></div>
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
                                    <td class="textRight">培训时间</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <?php echo $result['date']?>
                                    </td>
                                    <td class="textRight">讲师</td>
                                    <td class="pdX10  textLeft" colspan="2">
                                        <?php echo $result['lector']?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>主题</th><th colspan="4"class="textLeft pdX10"><?php echo $result['theme']?></th>
                                </tr>
                                <tr>
                                    <th>姓名</th><th>部门</th><th>签到</th><th>考核方式</th><th>考核结果</th>
                                </tr>
                            </thead>
                            <tbody class="add textCenter">
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td class=""><?php echo $v['name']?></td>
                                    <td class=""><?php echo $v['dep']?></td>
                                    <td class=""><?php echo $v['diandao']?></td>
                                    <td class=""><?php echo $v['type']?></td>
                                    <td class=""><?php echo $v['result']?></td>
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
