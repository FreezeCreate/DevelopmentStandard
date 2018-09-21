<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<style>
    .TabInp textarea { padding: 0; text-indent: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">顾客反馈处理</span><span class="Close"></span></div>
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
                            <tbody class="TabBg TabInp">
                                <tr>
                                    <td width="200" class="textCenter TabBgBlue">顾客名称</td>
                                    <td class="pdX10"><?php echo $result['name'] ?></td>
                                    <td width="200" class="textCenter TabBgBlue">反馈时间</td>
                                    <td class="pdX10"><?php echo $result['fkdt'] ?></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">产品名称</td>
                                    <td class="pdX10"><?php echo $result['cpname'] ?></td>
                                    <td class="textCenter TabBgBlue">订单号</td>
                                    <td class="pdX10"><?php echo $result['onumber'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>投诉内容（简略）：</p>
                                        <div class="pdX20"><?php echo $result['content'] ?></div>
                                        <div class="over pdX20">
                                            <div class="float-right" style="line-height:50px;">接获人： 
                                                <div class="UpgrapImg float-right">
                                                    <img class="" src="<?php echo $result['cname'] ?>"/>
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>原因分析：</p>
                                        <div class="pdX20"><?php echo $result['case'] ?></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                责任部门： 
                                                <?php echo $result['cdep'] ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>投诉最终解决处理方案：</p>
                                        <div class="pdX20"><?php echo $result['jiejue'] ?></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                负责部门： 
                                                <?php echo $result['jdep'] ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pdX20"colspan="4">
                                        是否需要采取纠正、预防、巩固措施？
                                        <i class="w-100"></i>
                                        <label><span class="radio <?php echo $result['cstype']>0?'active':''?>">是</span><input type="radio" value="" name="need"class="None"/></label>
                                        <i class="w-50"></i>
                                        <label><span class="radio <?php echo empty($result['cstype'])?'active':''?>">否</span><input type="radio" value="" name="need"class="None"/></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>
                                            <label><span class="radio <?php echo $result['cstype']==1?'active':''?>">纠正</span><input type="radio" value="1" name="cstype"class="None" /></label>
                                            <label><span class="radio <?php echo $result['cstype']==2?'active':''?>">预防</span><input type="radio" value="2" name="cstype"class="None" /></label>
                                            <label><span class="radio <?php echo $result['cstype']==3?'active':''?>">巩固</span><input type="radio" value="3" name="cstype"class="None" /></label>
                                            措施：
                                        </p>
                                        <div class="pdX20"><?php echo $result['cuoshi'] ?></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                <label>
                                                    责任部门： 
                                                    <?php echo $result['csdep'] ?>
                                                </label>
                                                <label>
                                                    质量负责人： 
                                                    <?php echo $result['csname'] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"class="pdX20">
                                        <p>顾客意见和验证跟踪：</p>
                                        <div class="pdX20"><?php echo $result['csname'] ?></div>
                                        <div class="over pdX20">
                                            <div class="float-right">
                                                <label style="display:inline-block; float: left;line-height: 50px;">
                                                    记录人： 
                                                    <div class="UpgrapImg float-right">
                                                        <img class="" src="<?php echo $result['jluser'] ?>"/>
                                                        
                                                    </div>
                                                </label>
                                                <label style="display:inline-block; float: left; line-height: 50px;">
                                                    验证人： 
                                                    <div class="UpgrapImg float-right">
                                                        <img class="" src="<?php echo $result['yyuser'] ?>"/>
                                                        
                                                    </div>
                                                </label>
                                                <label style="display:inline-block; float: left; line-height: 50px;">
                                                    验证时间： 
                                                    <?php echo $result['yydt'] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">附件</td>
                                    <td colspan="3">
                                        <ul class="FileBox">
                                            <?php foreach ($result['files'] as $v) { ?>
                                                <li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span><input type="hidden" name="files[]" value="<?php echo $v['id'] ?>"/><span class="DelFile">删除</span></li>
                                            <?php } ?>
                                        </ul>
                                    </td>
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

</html>
