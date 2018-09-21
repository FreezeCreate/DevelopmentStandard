<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
    .Table td, .Table th { min-width: 10px;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">年度培训计划</span><span class="Close"></span></div>
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
                                    <th rowspan="2">序号</th><th rowspan="2">部门</th><th rowspan="2">培训课程内容</th><th rowspan="2">参加对象</th>
                                    <th colspan="2">培训方式</th><th colspan="12">计 划 实 施 月 份</th><th rowspan="2" style="width:80px;">备注</th>
                                </tr>
                                <tr>
                                    <th>内训</th><th>外训</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th>
                                    <th>8</th><th>9</th><th>10</th><th>11</th><th>12</th>
                                </tr>
                            </thead>
                            <tbody class="TabBg TabInp textCenter add">
                                <?php foreach($result['children'] as $k=>$v){?>
                                <tr>
                                    <td><?php echo $k+1;?></td>
                                    <td><?php echo $v['dep']?></td>
                                    <td><?php echo $v['content']?></td>
                                    <td><?php echo $v['duixiang']?></td>
                                    <td><label><span class="radio no <?php echo $v['type']=='内训'?'active':''?>"></span><input type="radio"class="None"value="内训"name="type[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['type']=='外训'?'active':''?>"></span><input type="radio"class="None"value="外训"name="type[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='1'?'active':''?>"></span><input type="radio"class="None"value="1"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='2'?'active':''?>"></span><input type="radio"class="None"value="2"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='3'?'active':''?>"></span><input type="radio"class="None"value="3"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='4'?'active':''?>"></span><input type="radio"class="None"value="4"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='5'?'active':''?>"></span><input type="radio"class="None"value="5"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='6'?'active':''?>"></span><input type="radio"class="None"value="6"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='7'?'active':''?>"></span><input type="radio"class="None"value="7"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='8'?'active':''?>"></span><input type="radio"class="None"value="8"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='9'?'active':''?>"></span><input type="radio"class="None"value="9"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='10'?'active':''?>"></span><input type="radio"class="None"value="10"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='11'?'active':''?>"></span><input type="radio"class="None"value="11"name="month[]" /></label></td>
                                    <td><label><span class="radio no <?php echo $v['month']=='12'?'active':''?>"></span><input type="radio"class="None"value="12"name="month[]" /></label></td>
                                    <td><?php echo $v['explain']?></td>
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
