<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { text-align: left; text-indent: 0; padding: 0;}
    /* .FrameGroupInput{width:50px !important;} */
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">详情</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th colspan="6"><?php echo empty($result['title']) ? '无' : $result['title']; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="2">订单</th>
                                    <th colspan="4"><?php echo $orders['name'];?></th>
                                </tr>
                                <tr>
                                    <th colspan="2">产品模板</th>
                                    <th colspan="4"><?php echo $pro['name'];?></th>
                                </tr>
                                <tr>
                                    <th colspan="2">文件编号</th>
                                    <th colspan="4"><?php echo $result['number'] ?></th>
                                </tr>
                                <?php if($type==3||$type==5){?>
                                <tr>
                                    <th width="100">产品名称</th><th><?php echo $result['name'] ?></th>
                                    <th>型号规格</th><th><?php echo $result['format'] ?></th>
                                    <th>数量</th><th><?php echo $result['num'] ?>台</th>
                                </tr>
                                <tr>
                                    <th>检验日期</th><th><?php echo $result['dt'] ?></th>
                                    <th>产品编号</th><th><?php echo $result['pnumber'] ?></th>
                                    <th>检验员</th>
                                    <th>
                                        <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="sign" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                        </div>
                                        <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                    </th>
                                </tr>
                                <?php }?>
                                <?php if($type==1||$type==2){?>
                                <tr>
                                    <th width="100">产品名称</th><th><?php echo $result['name'] ?></th>
                                    <th>生产日期</th><th><?php echo $result['dt'] ?></th>
                                    <th>检验员</th>
                                    <th>
                                        <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="sign" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>型号规格</th><th><?php echo $result['format'] ?></th>
                                    <th>产品编号</th><th><?php echo $result['pnumber'] ?></th>
                                    <th>检验日期</th><th><?php echo $result['dt'] ?></th>
                                </tr>
                                <?php }?>
                                <?php if($type==4){?>
                                <tr>
                                    <th width="100">产品名称</th><th><?php echo $result['name'] ?></th>
                                    <th>型号规格</th><th><?php echo $result['format'] ?></th>
                                    <th>产品编号</th><th><?php echo $result['pnumber'] ?></th>
                                </tr>
                                <?php }?>
                                <tr>
                                    <?php if($type==4){?>
                                    <th>工序名称</th>
                                    <th colspan="2">操作要点</th>
                                    <th>质量情况</th>
                                    <th>操作者/检验员</th>
                                    <th>日期</th>
                                    <?php }?>
                                    <?php if($type!=4){?>
                                    <th>检验项目</th>
                                    <?php }?>
                                    <?php if($type==1||$type==2){?>
                                    <th colspan="2">技术要求</th>
                                    <?php }?>
                                    <?php if($type==3||$type==5){?>
                                    <th>检验设备</th>
                                    <th colspan="2">内容及要求</th>
                                    <th>检验记录</th>
                                    <th>检验结论</th>
                                    <?php }?>
                                    <?php if($type==1||$type==2){?>
                                    <th>测试结果</th>
                                    <th>判断</th>
                                    <th>备注</th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody class="TabInp">
                                <!--GGJ低压无偿柜参数start-->
                                <?php if($type==1){?>
                                <tr>
                                    <td rowspan="7">一般检查</td>
                                    <td colspan="2">检查成套设备,包括检查连接线：</td>
                                    <td><?php echo $result['jilu'][q1];?></td>
                                    <td><?php echo $result['jielun'][w1];?></td>
                                    <td><?php echo $result['info'][e1];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">1.对机械操作元件、联锁、锁扣等部件的有效性进行检查；</td>
                                    <td><?php echo $result['jilu'][q2];?></td>
                                    <td><?php echo $result['jielun'][w2];?></td>
                                    <td><?php echo $result['info'][e2];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">2.检查导线、电器的布置、安装是否正确；</td>
                                    <td><?php echo $result['jilu'][q3];?></td>
                                    <td><?php echo $result['jielun'][w3];?></td>
                                    <td><?php echo $result['info'][e3];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">3.检查连接，特别是螺钉连接是否接触良好；</td>
                                    <td><?php echo $result['jilu'][q4];?></td>
                                    <td><?php echo $result['jielun'][w4];?></td>
                                    <td><?php echo $result['info'][e4];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">4.成套设备与技术数据、标志、电路图、接线图、资料是否相符</td>
                                    <td><?php echo $result['jilu'][q5];?></td>
                                    <td><?php echo $result['jielun'][w5];?></td>
                                    <td><?php echo $result['info'][e5];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">5.电气间隙≥<?php echo json_decode($that_paras['parameter'])[0]?></td>
                                    <td><?php echo $result['jilu'][q6];?></td>
                                    <td><?php echo $result['jielun'][w6];?></td>
                                    <td><?php echo $result['info'][e6];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">6.爬电距离≥<?php echo json_decode($that_paras['parameter'])[1]?></td>
                                    <td><?php echo $result['jilu'][q7];?></td>
                                    <td><?php echo $result['jielun'][w7];?></td>
                                    <td><?php echo $result['info'][e7];?></td>
                                </tr>
                                <tr>
                                    <td>绝 缘 电 阻的验证</td>
                                    <td colspan="2">相对地标称电压的绝缘电阻应><?php echo json_decode($that_paras['parameter'])[2]?></td>
                                    <td><?php echo $result['jilu'][q8];?></td>
                                    <td><?php echo $result['jielun'][w8];?></td>
                                    <td><?php echo $result['info'][e8];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="5">介电强度试验</td>
                                    <td colspan="2">施加交流正弦波50Hz电压<?php echo json_decode($that_paras['parameter'])[3]?>施压时间<?php echo json_decode($that_paras['parameter'])[4]?>,施压部位如下:结论:不可有击穿或闪络现象。</td>
                                    <td><?php echo $result['jilu'][q9];?></td>
                                    <td><?php echo $result['jielun'][w9];?></td>
                                    <td><?php echo $result['info'][e9];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">1.成套设备的所有带电部件与裸露导电部件之间;</td>
                                    <td><?php echo $result['jilu'][q10];?></td>
                                    <td><?php echo $result['jielun'][w10];?></td>
                                    <td><?php echo $result['info'][e10];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">2.每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其它极之间;</td>
                                    <td><?php echo $result['jilu'][q11];?></td>
                                    <td><?php echo $result['jielun'][w11];?></td>
                                    <td><?php echo $result['info'][e11];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">3.绝缘材料制造的外壳和手柄上覆盖金属箔,在金属箔上与带电部件以及裸导电部件之间施电压,但其值为<?php echo json_decode($that_paras['parameter'])[5]?></td>
                                    <td><?php echo $result['jilu'][q12];?></td>
                                    <td><?php echo $result['jielun'][w12];?></td>
                                    <td><?php echo $result['info'][e12];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">4.不与主回路相连的的辅助回路试验电压见下表
                                        <table class="Table">
                                            <tr>
                                                <td>额定绝缘电压</td>
                                                <td>试验电压（*）</td>
                                            </tr>
                                            <tr>
                                                <td>Ui≤12</td>
                                                <td>250V(250V)</td>
                                            </tr>
                                            <tr>
                                                <td>12&lt;Ui≤60</td>
                                                <td>500V(500V)</td>
                                            </tr>
                                            <tr>
                                                <td>60&lt;Ui</td>
                                                <td>1000+2Ui,最小1500V</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><?php echo $result['jilu'][q13];?></td>
                                    <td><?php echo $result['jielun'][w13];?></td>
                                    <td><?php echo $result['info'][e13];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="7">保护电路的连续性验证</td>
                                </tr>
                                <tr>
                                    <td colspan="2">是否有保护电路连续性措施</td>
                                    <td><?php echo $result['jilu'][q14];?></td>
                                    <td><?php echo $result['jielun'][w14];?></td>
                                    <td><?php echo $result['info'][e14];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">仪表门对主接地≤<?php echo json_decode($that_paras['parameter'])[6]?></td>
                                    <td><?php echo $result['jilu'][q15];?></td>
                                    <td><?php echo $result['jielun'][w15];?></td>
                                    <td><?php echo $result['info'][e15];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">主断路器框架对主接地≤<?php echo json_decode($that_paras['parameter'])[7]?></td>
                                    <td><?php echo $result['jilu'][q16];?></td>
                                    <td><?php echo $result['jielun'][w16];?></td>
                                    <td><?php echo $result['info'][e16];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">分支断路器/熔断器框架对主接地≤<?php echo json_decode($that_paras['parameter'])[8]?></td>
                                    <td><?php echo $result['jilu'][q17];?></td>
                                    <td><?php echo $result['jielun'][w17];?></td>
                                    <td><?php echo $result['info'][e17];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">端子排支架对主接地≤<?php echo json_decode($that_paras['parameter'])[9]?></td>
                                    <td><?php echo $result['jilu'][q18];?></td>
                                    <td><?php echo $result['jielun'][w18];?></td>
                                    <td><?php echo $result['info'][e18];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">互感器对主接地≤<?php echo json_decode($that_paras['parameter'])[10]?></td>
                                    <td><?php echo $result['jilu'][q19];?></td>
                                    <td><?php echo $result['jielun'][w19];?></td>
                                    <td><?php echo $result['info'][e19];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">通电操作及机械操作试验</td>
                                </tr>
                                <tr>
                                    <td colspan="2">检查装置接线正确无误后，在辅助电路分别通以额定电压的85%、110％，各操作 <?php echo json_decode($that_paras['parameter'])[11]?> 次，应符合要求</td>
                                    <td><?php echo $result['jilu'][q20];?></td>
                                    <td><?php echo $result['jielun'][w20];?></td>
                                    <td><?php echo $result['info'][e20];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">对主开关操作手柄，操作 <?php echo json_decode($that_paras['parameter'])[12]?> 次，机构应动作可靠，正常。</td>
                                    <td><?php echo $result['jilu'][q21];?></td>
                                    <td><?php echo $result['jielun'][w21];?></td>
                                    <td><?php echo $result['info'][e21];?></td>
                                </tr>
                                <tr>
                                    <td>防护等级</td>
                                    <td colspan="2">进行直观检查以保证规定的防护等级<?php echo json_decode($that_paras['parameter'])[13]?></td>
                                    <td><?php echo $result['jilu'][q22];?></td>
                                    <td><?php echo $result['jielun'][w22];?></td>
                                    <td><?php echo $result['info'][e22];?></td>
                                </tr>
                                <tr>
                                    <td>工频过电压保护试验</td>
                                    <td colspan="2">将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除</td>
                                    <td><?php echo $result['jilu'][q23];?></td>
                                    <td><?php echo $result['jielun'][w23];?></td>
                                    <td><?php echo $result['info'][e23];?></td>
                                </tr>
                                <tr>
                                    <td>缺相保护</td>
                                    <td colspan="2">试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。</td>
                                    <td><?php echo $result['jilu'][q24];?></td>
                                    <td><?php echo $result['jielun'][w24];?></td>
                                    <td><?php echo $result['info'][e24];?></td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        结论:该产品经检验合格符合 <?php echo json_decode($that_paras['parameter'])[14]?> 检验要求
                                    </td>
                                </tr>
                                <!--GGJ低压无偿柜参数end-->
                                <!--JP电容柜参数start-->
                                <?php }else if($type==2){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td colspan="2">防护等级应达到<?php echo json_decode($that_paras['parameter'])[0]?>，工厂生产工艺和产品结构应符合相关要求。</td>
                                    <td><?php echo $result['jilu'][q1];?></td>
                                    <td><?php echo $result['jielun'][w1];?></td>
                                    <td><?php echo $result['info'][e1];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="4">开关器件和元件的组合</td>
                                    <td colspan="2">a)内装元器件符合相关标准，安装和标志应符合GB/T4205规定和按照制造商说明书安装，元器件的相关参数应符合该产品相关电路的参数。</td>
                                    <td><?php echo $result['jilu'][q2];?></td>
                                    <td><?php echo $result['jielun'][w2];?></td>
                                    <td><?php echo $result['info'][e2];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">b)接线端子（不包括保护导体端子）安装离成套基础面上方至少200mm并易于连接。</td>
                                    <td><?php echo $result['jilu'][q3];?></td>
                                    <td><?php echo $result['jielun'][w3];?></td>
                                    <td><?php echo $result['info'][e3];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">c)指示灯和按钮颜色符合GB/T4025(IEC 60073)规定。</td>
                                    <td><?php echo $result['jilu'][q4];?></td>
                                    <td><?php echo $result['jielun'][w4];?></td>
                                    <td><?php echo $result['info'][e4];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">d)各类连接,接触（螺钉）符合要求。</td>
                                    <td><?php echo $result['jilu'][q5];?></td>
                                    <td><?php echo $result['jielun'][w5];?></td>
                                    <td><?php echo $result['info'][e5];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="7">内部电路和连接、电气间隙与爬电距离</td>
                                    <td colspan="2">检查成套设备,包括检查连接线：</td>
                                    <td><?php echo $result['jilu'][q6];?></td>
                                    <td><?php echo $result['jielun'][w6];?></td>
                                    <td><?php echo $result['info'][e6];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">1.对机械操作元件、联锁、锁扣等部件的有效性进行检查；</td>
                                    <td><?php echo $result['jilu'][q7];?></td>
                                    <td><?php echo $result['jielun'][w7];?></td>
                                    <td><?php echo $result['info'][e7];?></td>
                                </tr>
                                <tr>
                                    <td  colspan="2">2.检查导线、电器的布置、安装是否正确；</td>
                                    <td><?php echo $result['jilu'][q8];?></td>
                                    <td><?php echo $result['jielun'][w8];?></td>
                                    <td><?php echo $result['info'][e8];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">3.检查连接，特别是螺钉连接是否接触良好；</td>
                                    <td><?php echo $result['jilu'][q9];?></td>
                                    <td><?php echo $result['jielun'][w9];?></td>
                                    <td><?php echo $result['info'][e9];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">4.成套设备与技术数据、标志、电路图、接线图、资料是否相符</td>
                                    <td><?php echo $result['jilu'][q10];?></td>
                                    <td><?php echo $result['jielun'][w10];?></td>
                                    <td><?php echo $result['info'][e10];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">5.电气间隙≥<?php echo json_decode($that_paras['parameter'])[1]?></td>
                                    <td><?php echo $result['jilu'][q11];?></td>
                                    <td><?php echo $result['jielun'][w11];?></td>
                                    <td><?php echo $result['info'][e11];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">6.爬电距离≥<?php echo json_decode($that_paras['parameter'])[2]?></td>
                                    <td><?php echo $result['jilu'][q12];?></td>
                                    <td><?php echo $result['jielun'][w12];?></td>
                                    <td><?php echo $result['info'][e12];?></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td colspan="2">相对地标称电压的绝缘电阻应><?php echo json_decode($that_paras['parameter'])[3]?></td>
                                    <td><?php echo $result['jilu'][q13];?></td>
                                    <td><?php echo $result['jielun'][w13];?></td>
                                    <td><?php echo $result['info'][e13];?></td>
                                </tr>
                                <tr>
                                    <td>外接导线端子</td>
                                    <td colspan="2">端子的类型及标识符合设计要求。</td>
                                    <td><?php echo $result['jilu'][q14];?></td>
                                    <td><?php echo $result['jielun'][w14];?></td>
                                    <td><?php echo $result['info'][e14];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="4">介电强度试验</td>
                                    <td colspan="2">施加交流正弦波 50Hz 电压<?php echo json_decode($that_paras['parameter'])[4]?>施压时间1s,施压部位如下: 结论:不可有击穿或闪络现象。</td>
                                    <td><?php echo $result['jilu'][q15];?></td>
                                    <td><?php echo $result['jielun'][w15];?></td>
                                    <td><?php echo $result['info'][e15];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">1.成套设备的所有带电部件与裸露导电部件之间;</td>
                                    <td><?php echo $result['jilu'][q16];?></td>
                                    <td><?php echo $result['jielun'][w16];?></td>
                                    <td><?php echo $result['info'][e16];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">2.每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其它极之间;</td>
                                    <td><?php echo $result['jilu'][q17];?></td>
                                    <td><?php echo $result['jielun'][w17];?></td>
                                    <td><?php echo $result['info'][e17];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">3.绝缘材料制造的外壳和手柄上覆盖金属箔,在金属箔上与带电部件以及裸导电部件之间施电压,但其值为<?php echo json_decode($that_paras['parameter'])[5]?>。</td>
                                    <td><?php echo $result['jilu'][q18];?></td>
                                    <td><?php echo $result['jielun'][w18];?></td>
                                    <td><?php echo $result['info'][e18];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="6">保护电路的连续性验证</td>
                                    <td colspan="2">是否有保护电路连续性措施</td>
                                    <td><?php echo $result['jilu'][q19];?></td>
                                    <td><?php echo $result['jielun'][w19];?></td>
                                    <td><?php echo $result['info'][e19];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">仪表门对主接地≤<?php echo json_decode($that_paras['parameter'])[6]?></td>
                                    <td><?php echo $result['jilu'][q20];?></td>
                                    <td><?php echo $result['jielun'][w20];?></td>
                                    <td><?php echo $result['info'][e20];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">主断路器框架对主接地≤<?php echo json_decode($that_paras['parameter'])[7]?></td>
                                    <td><?php echo $result['jilu'][q21];?></td>
                                    <td><?php echo $result['jielun'][w21];?></td>
                                    <td><?php echo $result['info'][e21];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">分支断路器/熔断器安装支架对主接地≤<?php echo json_decode($that_paras['parameter'])[8]?></td>
                                    <td><?php echo $result['jilu'][q22];?></td>
                                    <td><?php echo $result['jielun'][w22];?></td>
                                    <td><?php echo $result['info'][e22];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">端子排支架对主接地≤<?php echo json_decode($that_paras['parameter'])[9]?></td>
                                    <td><?php echo $result['jilu'][q23];?></td>
                                    <td><?php echo $result['jielun'][w23];?></td>
                                    <td><?php echo $result['info'][e23];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">互感器安装支架对主接地≤<?php echo json_decode($that_paras['parameter'])[10]?></td>
                                    <td><?php echo $result['jilu'][q24];?></td>
                                    <td><?php echo $result['jielun'][w24];?></td>
                                    <td><?php echo $result['info'][e24];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">通电操作及机械操作试验</td>
                                    <td colspan="2">检查装置接线正确无误后，在辅助电路分别通以额定电压的 85%、110％，各操作<?php echo json_decode($that_paras['parameter'])[11]?>次，应符合要求</td>
                                    <td><?php echo $result['jilu'][q25];?></td>
                                    <td><?php echo $result['jielun'][w25];?></td>
                                    <td><?php echo $result['info'][e25];?></td>
                                </tr>
                                <tr>
                                    <td  colspan="2">对主开关操作手柄，操作<?php echo json_decode($that_paras['parameter'])[12]?>次，机构应动作可靠，正常。</td>
                                    <td><?php echo $result['jilu'][q26];?></td>
                                    <td><?php echo $result['jielun'][w26];?></td>
                                    <td><?php echo $result['info'][e26];?></td>
                                </tr>
                                <tr>
                                    <td>工频过电压保护试验</td>
                                    <td colspan="2">将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除。</td>
                                    <td><?php echo $result['jilu'][q27];?></td>
                                    <td><?php echo $result['jielun'][w27];?></td>
                                    <td><?php echo $result['info'][e27];?></td>
                                </tr>
                                <tr>
                                    <td>缺相保护</td>
                                    <td colspan="2">试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。</td>
                                    <td><?php echo $result['jilu'][q28];?></td>
                                    <td><?php echo $result['jielun'][w28];?></td>
                                    <td><?php echo $result['info'][e28];?></td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td colspan="2">成套设备的铭牌参数，标识符合标准要求，检查布线符合设计资料要求，通电操作试验符合设计原理要求。检查元器件以及通信器件符合所选现场总线协议或其他数字通信协议的要求，应满足与上位机实现“遥调，遥测，遥控，遥信”等功能。</td>
                                    <td><?php echo $result['jilu'][q29];?></td>
                                    <td><?php echo $result['jielun'][w29];?></td>
                                    <td><?php echo $result['info'][e29];?></td>
                                </tr>
                                <tr>
                                    <td colspan="6">结论:该产品经检验合格符合 <?php echo json_decode($that_paras['parameter'])[13]?> 检验要求</td>
                                </tr>
                                <!--JP电容柜参数end-->
                                <!--XL-21参数start-->
                                <?php }else if($type==3){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td>物体试具</td>
                                    <td colspan="2">达到防护等级<?php echo json_decode($that_paras['parameter'])[0]?>。用直径<?php echo json_decode($that_paras['parameter'])[1]?>直的硬钢丝，钢丝应不能进入壳内。</td>
                                    
                                    <td><label><span class="radio <?php if ($result['jilu'][q1] == 1) echo 'active'?>" >可</span><input type="radio" name="q1" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q1] == 0) echo 'active'?>">否</span><input type="radio" name="" class="None" value="0"></label>进入柜体</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w1] == 1) echo 'active'?>" >合格</span><input type="radio" name="w1" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w1] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>开关器件和元件的组合</td>
                                    <td rowspan="2">目测、卷尺</td>
                                    <td colspan="2">内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合 GB/T4025(IEC60073)规定</td>
                                    <td rowspan="2"><label><span class="radio <?php if ($result['jilu'][q2] == 1) echo 'active'?>">符合</span><input type="radio" name="q2" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q2] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td rowspan="2"><label><span class="radio <?php if ($result['jielun'][w2] == 1) echo 'active'?>">合格</span><input type="radio" name="w2" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w2] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>内部电路和连接、外接导线端子</td>
                                    <td colspan="2">检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。</td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td>目测、电源车</td>
                                    <td colspan="2">对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q3] == 1) echo 'active'?>">符合</span><input type="radio" name="q3" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q3] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w3] == 1) echo 'active'?>">合格</span><input type="radio" name="w3" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w3] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>电气间隙</td>
                                    <td rowspan="2">游标卡尺</td>
                                    <td colspan="2">电气间隙：检验部位：相与相之间≥<?php echo json_decode($that_paras['parameter'])[2]?></td>
                                    <td>最小值<?php echo $result['jilu'][q4];?>
                                    <td><label><span class="radio <?php if ($result['jielun'][q4] == 1) echo 'active'?>">合格</span><input type="radio" name="w4" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q4] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>爬电距离</td>
                                    <td colspan="2">爬电距离：检验部位：相与相之间≥<?php echo json_decode($that_paras['parameter'])[3]?></td>
                                    <td>最小值<?php echo $result['jilu'][q5]?></td>
                                    <td><label><span class="radio <?php if ($result['jielun'][q5] == 1) echo 'active'?>">合格</span><input type="radio" name="w5" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q5] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td>绝缘电阻表</td>
                                    <td colspan="2">相对地标称电压的绝缘电阻应><?php echo json_decode($that_paras['parameter'])[4]?></td>
                                    <td>><?php echo $result['jilu'][q6]?>Ω/V</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][q6] == 1) echo 'active'?>">合格</span><input type="radio" name="w6" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q6] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>电击防护和保护电路完整性</td>
                                    <td>接地电阻测试仪</td>
                                    <td colspan="2">允许值应≤<?php echo json_decode($that_paras['parameter'])[5]?>，测试电流≥<?php echo json_decode($that_paras['parameter'])[6]?>，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤<?php echo json_decode($that_paras['parameter'])[7]?></td>
                                    <td>
                                        <p>测量<?php echo $result['jilu'][q7][0];?>点</p>
                                        <p>最大<?php echo $result['jilu'][q7][1]?>mΩ</p>
                                        <p>通电电流<?php echo $result['jilu'][q7][2]?>A</p>
                                    </td>
                                    <td><label><span class="radio <?php if ($result['jielun'][q7] == 1) echo 'active'?>">合格</span><input type="radio" name="w7" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q7] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>介电性能</td>
                                    <td>耐压测试仪</td>
                                    <td colspan="2">试压时间<?php echo json_decode($that_paras['parameter'])[8]?>，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（<?php echo json_decode($that_paras['parameter'])[9]?>）；非主电路供电的辅助回路与地之间（<?php echo json_decode($that_paras['parameter'])[10]?>）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（<?php echo json_decode($that_paras['parameter'])[11]?>）</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q8] == 1) echo 'active'?>">有</span><input type="radio" name="q8" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q8] == 0) echo 'active'?>">无</span><input type="radio" name="" class="None" value="0"></label>击穿或放电现象</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][q8] == 1) echo 'active'?>">合格</span><input type="radio" name="w8" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q8] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>机械操作</td>
                                    <td>手动</td>
                                    <td colspan="2">可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为<?php echo json_decode($that_paras['parameter'])[12]?>次是否良好</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q9] == 1) echo 'active'?>">符合</span><input type="radio" name="q9" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q9] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td><label><span class="radio <?php if ($result['jielun'][q9] == 1) echo 'active'?>">合格</span><input type="radio" name="w9" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][q9] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="6">检验依据及结论:依据 <?php echo json_decode($that_paras['parameter'])[13]?>
                                        <label><span class="radio <?php if (json_decode($that_paras['parameter'])[13] == 1) echo 'active';?>">合格</span><input type="radio" name="q10" class="None" value="1"></label>
                                        ，准予加施 C 3C  标志出厂； 
                                        <label><span class="radio <?php if (json_decode($that_paras['parameter'])[13] == 0) echo 'active';?>">不合格</span><input type="radio" name="w10" class="None" value="0"></label>，返工至合格
                                    </td>
                                </tr>
                                <!--XL-21参数end-->
                                <!--XM电气装配工序流程卡参数start-->
                                <?php }else if($type==4){?>
                                <tr>
                                    <td rowspan="6">元器件安装</td>
                                    <td colspan="2">箱(柜)体尺寸、结构与订单相符，外观无损</td>
                                    <td rowspan="6"><label><span class="radio <?php if ($result['jilu'][q1] == 1) echo 'active'?>">合格</span><input type="radio" name="q1" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q1] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td rowspan="6"><?php echo $result['jielun'][w1];?></td>
                                    <td rowspan="6"><?php echo $result['info'][e1]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">元器件型号、规格与材料单相符，安装位置正确</td>
                                </tr>
                                <tr>
                                    <td colspan="2">元件代号标识正确、齐全</td>
                                </tr>
                                <tr>
                                    <td colspan="2">方便客户进出线</td>
                                </tr>
                                <tr>
                                    <td colspan="2">机械操作灵活，多极开关同期性好，联锁可靠</td>
                                </tr>
                                <tr>
                                    <td colspan="2">接地连续性的标识检查</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">一次线安装</td>
                                    <td colspan="2">线径选择适当</td>
                                    <td rowspan="4"><label><span class="radio <?php if ($result['jilu'][q2] == 1) echo 'active'?>">合格</span><input type="radio" name="q2" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q2] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td rowspan="4"><?php echo $result['jielun'][w2]?></td>
                                    <td rowspan="4"><?php echo $result['info'][e2]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">布线符合图纸及工艺要求</td>
                                </tr>
                                <tr>
                                    <td colspan="2">相序排列正确，标识清楚</td>
                                </tr>
                                <tr>
                                    <td colspan="2">紧固件松紧适度</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">二次线安装</td>
                                    <td colspan="2">布线符合图纸及工艺要求</td>
                                    <td rowspan="4"><label><span class="radio <?php if ($result['jilu'][q3] == 1) echo 'active'?>">合格</span><input type="radio" name="q3" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q3] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td rowspan="4"><?php echo $result['jielun'][w3]?></td>
                                    <td rowspan="4"><?php echo $result['info'][e3]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">线耳压接牢靠</td>
                                </tr>
                                <tr>
                                    <td colspan="2">线号齐全，方向正确且与图纸一致</td>
                                </tr>
                                <tr>
                                    <td colspan="2">紧固件松紧适度</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">电气间隙和爬电距离</td>
                                    <td colspan="2">电气间隙符合标准要求≥<?php echo json_decode($that_paras['parameter'])[0]?></td>
                                    <td>最小值<?php echo $result['jilu'][q4][0]?>mm</td>
                                    <td rowspan="2"><?php echo $result['jielun'][w4]?></td>
                                    <td rowspan="2"><?php echo $result['info'][e4]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">爬电距离符合标准要求≥<?php echo json_decode($that_paras['parameter'])[1]?></td>
                                    <td>最小值<?php echo $result['jilu'][q4][1]?>mm</td>
                                </tr>
                                <tr>
                                    <td rowspan="6">电气性能检查</td>
                                    <td colspan="2">一次回路、二次回路能承受规定的工频耐压值</td>
                                    <td rowspan="6"><label><span class="radio <?php if ($result['jilu'][q5] == 1) echo 'active'?>">合格</span><input type="radio" name="q5" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q5] == 0) echo 'active'?>">不合格</span><input type="radio" name="q5" class="None" value="0"></label></td>
                                    <td rowspan="6"><?php echo $result['jielun'][w5]?></td>
                                    <td rowspan="6"><?php echo $result['info'][e5]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">必要时验证保护电路的电连续性</td>
                                </tr>
                                <tr>
                                    <td colspan="2">测量回路、计量回路的仪表，指示准确且与主回</td>
                                </tr>
                                <tr>
                                    <td colspan="2">控制回路各元件动作程序正确，指示对应</td>
                                </tr>
                                <tr>
                                    <td colspan="2">电气联锁可靠</td>
                                </tr>
                                <tr>
                                    <td colspan="2">具有保护功能的元件，其功能可靠</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">产品一致性检查</td>
                                    <td colspan="2">产品结构是否与型式试验报告一致</td>
                                    <td rowspan="4"><label><span class="radio <?php if ($result['jilu'][q6] == 1) echo 'active'?>">合格</span><input type="radio" name="q6" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q6] == 0) echo 'active'?>">不合格</span><input type="radio" name="q6" class="None" value="0"></label></td>
                                    <td rowspan="4"><?php echo $result['jielun'][w6]?></td>
                                    <td rowspan="4"><?php echo $result['info'][e6]?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">产品铭牌及标志、主要技术参数是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td colspan="2">主断路器/铜排/绝缘件是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td colspan="2">电流互感器是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td colspan="6">注：“质量结果”栏处，“√”表示合格，“X”表示不合格，“/”表示无此项。</td>
                                </tr>
                                <!--XM电气装配工序流程卡参数end-->
                                <!--XM例行确认检查参数start-->
                                <?php }else if($type==5){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td>物体试具、目测</td>
                                    <td colspan="2">防护等级应达到<?php echo json_decode($that_paras['parameter'])[0]?></td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q1] == 1) echo 'active'?>">可</span><input type="radio" name="q1" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q1] == 0) echo 'active'?>">否</span><input type="radio" name="q1" class="None" value="0"></label>进入柜体或接触带电金属部件</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w1] == 1) echo 'active'?>">合格</span><input type="radio" name="w1" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w1] == 0) echo 'active'?>">不合格</span><input type="radio" name="w1" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>开关器件和元件的组合</td>
                                    <td rowspan="2">目测、卷尺</td>
                                    <td colspan="2">内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合 GB/T4025(IEC60073)规定</td>
                                    <td rowspan="2"><label><span class="radio <?php if ($result['jilu'][q2] == 1) echo 'active'?>">符合</span><input type="radio" name="q2" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q2] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td rowspan="2"><label><span class="radio <?php if ($result['jielun'][w2] == 1) echo 'active'?>">合格</span><input type="radio" name="w2" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w2] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>内部电路和连接、外接导线端子</td>
                                    <td colspan="2">检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。</td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td>目测、电源车</td>
                                    <td colspan="2">对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q3] == 1) echo 'active'?>">符合</span><input type="radio" name="q3" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q3] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w3] == 1) echo 'active'?>">合格</span><input type="radio" name="w3" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w3] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>电气间隙</td>
                                    <td rowspan="2">游标卡尺</td>
                                    <td colspan="2">电气间隙：检验部位：相与相之间≥<?php echo json_decode($that_paras['parameter'])[1]?></td>
                                    <td>最小值<?php echo $result['jilu'][q4];?>mm</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w4] == 1) echo 'active'?>">合格</span><input type="radio" name="w4" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w4] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>爬电距离</td>
                                    <td colspan="2">爬电距离：检验部位:相与相之间≥<?php echo json_decode($that_paras['parameter'])[2]?></td>
                                    <td>最小值<?php echo $result[q5];?>mm</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w5] == 1) echo 'active'?>">合格</span><input type="radio" name="w5" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w5] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td>绝缘电阻表</td>
                                    <td colspan="2">相对地标称电压的绝缘电阻应><?php echo json_decode($that_paras['parameter'])[3]?></td>
                                    <td>><?php echo $result['jilu'][q6]?>Ω/V</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w6] == 1) echo 'active'?>">合格</span><input type="radio" name="w6" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w6] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>电击防护和保护电路完整性</td>
                                    <td>接地电阻测试仪</td>
                                    <td colspan="2">允许值应≤<?php echo json_decode($that_paras['parameter'])[4]?>，测试电流≥<?php echo json_decode($that_paras['parameter'])[5]?>，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤<?php echo json_decode($that_paras['parameter'])[6]?></td>
                                    <td>
                                        <p>测量<?php echo $result['jilu'][q7][0]?>电</p>
                                        <p>最大<?php echo $result['jilu'][q7][1]?>mΩ</p>
                                        <p>通电电流<?php echo $result['jilu'][q7][2]?>A</p>
                                    </td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w7] == 1) echo 'active'?>">合格</span><input type="radio" name="w7" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w7] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>介电性能</td>
                                    <td>耐压测试仪</td>
                                    <td colspan="2">试压时间<?php echo json_decode($that_paras['parameter'])[7]?>，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（<?php echo json_decode($that_paras['parameter'])[8]?>）；非主电路供电的辅助回路与地之间（<?php echo json_decode($that_paras['parameter'])[9]?>）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（<?php echo json_decode($that_paras['parameter'])[10]?>）</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q8] == 1) echo 'active'?>">有</span><input type="radio" name="q8" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q8] == 0) echo 'active'?>">无</span><input type="radio" name="" class="None" value="0"></label>击穿或放电现象</td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w8] == 1) echo 'active'?>">合格</span><input type="radio" name="w8" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w8] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>机械操作</td>
                                    <td>手动</td>
                                    <td colspan="2">可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为 <?php echo json_decode($that_paras['parameter'])[11]?> 次是否良好</td>
                                    <td><label><span class="radio <?php if ($result['jilu'][q9] == 1) echo 'active'?>">符合</span><input type="radio" name="q9" class="None" value="1"></label><label><span class="radio <?php if ($result['jilu'][q9] == 0) echo 'active'?>">不符合</span><input type="radio" name="" class="None" value="0"></label></td>
                                    <td><label><span class="radio <?php if ($result['jielun'][w9] == 1) echo 'active'?>">合格</span><input type="radio" name="w9" class="None" value="1"></label><label><span class="radio <?php if ($result['jielun'][w9] == 0) echo 'active'?>">不合格</span><input type="radio" name="" class="None" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="6">检验依据及结论:依据 <?php echo json_decode($that_paras['parameter'])[12]?>
                                        <label><span class="radio <?php if (json_decode($that_paras['parameter'])[13] == 1) echo 'active';?>">合格</span><input type="radio" name="q10" class="None" value="1"></label>
                                        ，准予加施 C 3C  标志出厂； 
                                        <label><span class="radio <?php if (json_decode($that_paras['parameter'])[13] == 0) echo 'active';?>">不合格</span><input type="radio" name="w10" class="None" value="0"></label>，返工至合格
                                    </td>
                                </tr>
                                <?php }?>
                                <!--XM例行确认检查参数end-->
                            </tbody>
                            
                        </table>
                    </div>
                </form>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <!--  <span class="Succ" onclick="do_sub()">保存</span>-->
        </div>
    </div>

</body>
<script type="text/javascript">
    jeDate({
        dateCell: "#dt", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadqm"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadQm',
            dataType: 'json',
            data: {name: 'fileToUploadQm', id: 'fileToUploadQm'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.UpgrapImg img').attr('src', data.src);
                    $('.UpgrapImg input').val(data.src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.addFile').click(function() {
            $(this).prev().click();
        });
        $(document).on('change', '.fileToUpload', function() {
            var name = $(this).attr('name');
            $.ajaxFileUpload({
                url: '<?php echo spUrl("uplaodimage", "uploadFile"); ?>',
                secureuri: false,
                fileElementId: name,
                dataType: 'json',
                data: {name: name, id: name},
                error: function(data, status, e) {
                    Alert(e);
                },
                success: function(data, status) {
                    if (data.status == 1) {
                        var txt = '<li class="FileItem"><span class="FileItemNam download" itemid="' + data.data.id + '">' + data.data.filename + '</span><input type="hidden" name="files[]" value="' + data.data.id + '"/><span class="DelFile">删除</span></li>';
                        $('#' + name).parent().children('.FileBox').append(txt);
                        $('#' + name).val('');
                    } else {
                        $('#' + name).val('');
                        Alert(data.msg);
                    }
                },
            });
            return false;
        });
        


    });
    function do_sub() {
        loading();
        var data= $('#check_form').serialize();
        console.log(data);
        $.ajax({
            cache: false,
            type: "POST",
            //url: "<?php echo spUrl($c, 'saveDyctlog'); ?>",
            url: "/app.php/service/saveProductCheck",
            data,
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                //if (data.status == 1) {
            	if (data.code == 0) {
                    loading('none');
                     
                    Refresh();
                } else {
                    Alert(data.msg);
                    loading('none');
                }
            }
        });
    }
</script>
</html>


