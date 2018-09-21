<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="textRight">
                    <!--<span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>-->
                    <span class="Btn Btn-blue" onclick="printdiv('print')"><i class="icon-print"></i>打印</span>
                </div>
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="top20" id="print">
                        <h3 style="text-align:center; font-size: 18px; line-height: 60px;"><?php echo $result['title'] ?></h3>
                        <h3 style="font-size: 16px; line-height: 50px;"><?php echo $result['number'] ?></h3>
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th width="100">产品名称</th><th><input type="text" readonly="true" name="name" value="<?php echo $result['name'] ?>" /></th>
                                    <th>型号规格</th><th><input type="text" readonly="true" name="format" value="<?php echo $result['format'] ?>" /></th>
                                    <th>数量</th><th><input style="width: 70px;" readonly="true" name="num" type="text" value="<?php echo $result['num'] ?>" />台</th>
                                </tr>
                                <tr>
                                    <th>检验日期</th><th><input type="text" readonly="true" name="dt" value="<?php echo $result['dt'] ?>" /></th>
                                    <th>产品编号</th><th><input type="text" readonly="true" name="pnumber" value="<?php echo $result['pnumber'] ?>" /></th>
                                    <th>检验员</th>
                                    <th>
                                        <div class="UpgrapImg">
                                            <img class="" src="<?php echo empty($result['sign']) ?'': $result['sign']; ?>"/>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>检验项目</th><th>检验设备</th><th colspan="2">内容及要求</th><th>检验记录</th><th>检验结论</th>
                                </tr>
                            </thead>
                            <tbody class="TabInp">
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>防护等级</td><td>物体试具</td><td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">达到防护等级IP30。用直径2.5+0.05mm直的硬钢丝，钢丝应不能进入壳内。</td>
                                        <td>
                                            <label><span class="radio <?php echo $result['jilu']['q1']==1?'active':''?>">可</span><input type="radio" <?php echo $result['jilu']['q1']==1?'checked=""':''?> name="jilu[q1]"class="None"value="1" /></label>
                                            <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q1']==0?'active':''?>">否</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q1']==0?'checked=""':''?> name="jilu[q1]"class="None"value="0" /></label>
                                            进入柜体
                                        </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q1']?></td>
                                        <td><?php echo $mode['w1']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e1']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q1'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==1?'checked=""':''?> name="jielun[q1]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==0?'checked=""':''?> name="jielun[q1]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>开关器件和元件的组合</td>
                                    <td>目测</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        1.内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合GB/T4025(IEC 60073)规定
                                        不包括保护导体端子，应位于成套设备的基础上方至少0.2m,并且端子的位置应使电缆易于与其连接。
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==1?'checked=""':''?> name="jilu[q2]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==0?'checked=""':''?> name="jilu[q2]"class="None"value="0" /></label>
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q2']?></td>
                                        <td><?php echo $mode['w2']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e2']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q2'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==1?'checked=""':''?> name="jielun[q2]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==0?'checked=""':''?> name="jielun[q2]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>内部电路和连接、外接导线端子</td><td>目测</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==1?'checked=""':''?> name="jilu[q3]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==0?'checked=""':''?> name="jilu[q3]"class="None"value="0" /></label>
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q3']?></td>
                                        <td><?php echo $mode['w3']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e3']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q3'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==1?'checked=""':''?> name="jielun[q3]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==0?'checked=""':''?> name="jielun[q3]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                       <td>布线、操作性能和功能</td><td>目测、电源车</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==1?'checked=""':''?> name="jilu[q4]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==0?'checked=""':''?> name="jilu[q4]"class="None"value="0" /></label>
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q4']?></td>
                                        <td><?php echo $mode['w4']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e4']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q4'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==1?'checked=""':''?> name="jielun[q4]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==0?'checked=""':''?> name="jielun[q4]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>电气间隙</td><td>游标卡尺</td> 
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        电气间隙：检验部位：相与相之间≥5.5mm
                                    </td>
                                    <td>
                                        最小值<input type="text"class="smallInp" readonly="true" name="jilu[q5]" value="<?php echo $result['jilu']['q5'];?>" />mm
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q5']?></td>
                                        <td><?php echo $mode['w5']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e5']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q5'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==1?'checked=""':''?>name="jielun[q5]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==0?'checked=""':''?>name="jielun[q5]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>绝缘电阻的验证</td><td>游标卡尺</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        爬电距离：检验部位:相与相之间≥10mm
                                    </td>
                                    <td>
                                        最小值<input type="text"class="smallInp" readonly="true" name="jilu[q6]" value="<?php echo $result['jilu']['q6'];?>" />mm
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q6']?></td>
                                        <td><?php echo $mode['w6']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e6']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q6'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==1?'checked=""':''?>name="jielun[q6]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==0?'checked=""':''?>name="jielun[q6]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>爬电距离</td><td>绝缘电阻表</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        相对地标称电压的绝缘电阻应＞500MΩ
                                    </td>
                                    <td>
                                        ＞<input type="text"class="smallInp" readonly="true" name="jilu[q7]" value="<?php echo $result['jilu']['q7'];?>" />MΩ
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q7']?></td>
                                        <td><?php echo $mode['w7']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e7']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q7'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==1?'checked=""':''?>name="jielun[q7]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==0?'checked=""':''?>name="jielun[q7]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>电击防护和保护电路完整性</td><td>接地电阻测试仪</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        允许值应≤100mΩ，测试电流10-25A，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤100mΩ（取样点不小于3点）
                                    </td>
                                    <td>
                                        <p>测量<input type="text"class="smallInp" readonly="true" name="jilu[q8-1]" value="<?php echo $result['jilu']['q8-1'];?>" />点</p>
                                        <p>最大<input type="text"class="smallInp" readonly="true" name="jilu[q8-2]" value="<?php echo $result['jilu']['q8-2'];?>" />mΩ</p>
                                        <p>通电电流<input type="text"class="smallInp" readonly="true" name="jilu[q8-3]" value="<?php echo $result['jilu']['q8-3'];?>" />A</p>
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q8']?></td>
                                        <td><?php echo $mode['w8']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e8']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q8'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==1?'checked=""':''?> name="jielun[q8]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==0?'checked=""':''?> name="jielun[q8]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>介电性能</td><td>耐压测试仪</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        试压时间1S，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（1890V）；非主电路供电的辅助回路与地之间（1890V）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（2835V）
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==1?'active':''?>">有</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==1?'checked=""':''?> name="jilu[q9]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==0?'active':''?>">无</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==0?'checked=""':''?> name="jilu[q9]"class="None"value="0" /></label>
                                        击穿或放电现象
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q9']?></td>
                                        <td><?php echo $mode['w9']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e9']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q9'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==1?'checked=""':''?> name="jielun[q9]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==0?'checked=""':''?> name="jielun[q9]"class="None"value="1" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if(empty($mode)){?>
                                        <td>机械操作</td><td>手动</td>
                                    <td colspan="2" style="text-align:left;padding: 10px 10px 30px 10px;">
                                        可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为5次是否良好
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==1?'checked=""':''?> name="jilu[q10]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==0?'checked=""':''?> name="jilu[q10]"class="None"value="0" /></label>
                                    </td>
                                    <?php }else{?>
                                        <td><?php echo $mode['q10']?></td>
                                        <td><?php echo $mode['w10']?></td>
                                        <td colspan="2" style="text-align:left;height: 80px;"><?php echo $mode['e10']?></td>
                                        <td>
                                            <?php echo $result['jilu']['q10'];?>
                                        </td>
                                    <?php }?>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q10']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q10']==1?'checked=""':''?> name="jielun[q10]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q10']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q10']==0?'checked=""':''?> name="jielun[q10]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>检验依据及结论</td>
                                    <td colspan="5"class="pdX10 textLeft">
                                        依据GB/T7251.12-2013
                                        <i class="w-100"></i>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q11']==1?'active':''?>">合格，准予加施</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q11']==1?'checked=""':''?> name="jielun[q11]"class="None"value="1" /></label>
                                        <i class="w-100"></i>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q11']==2?'active':''?>">不合格，返工至合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q11']==2?'checked=""':''?> name="jielun[q11]"class="None"value="2" /></label>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </form>
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
                                    <td><?php echo $v['checkname']; ?></td>
                                    <td><?php echo $v['statusname']; ?></td>
                                    <td>
                                        <?php echo $v['explain']; ?>
                                        <?php foreach ($v['files'] as $v1) { ?>
                                            <div class="download"><a class="download-a" href="javascript:void(0)" style="color: #007aff;" itemid="<?php echo $v1['id'] ?>" title="点击下载"><?php echo $v1['filename'] ?></a>
                                            <?php } ?>
                                    </td>
                                    <td><?php echo $v['optdt']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                </form>
                <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                    <div class="FrameListTable">
                        <p class="FrameListTableTit">审核处理</p>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table  class="FrameTableCont">
                                <thead>
                                    <tr>
                                        <td class="FrameGroupName">状态：</td>
                                        <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="FrameGroupName">处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName"><span style="color:red;">*</span> 处理人签字：</td>
                                        <td>
                                            <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                                <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                                <input type="hidden" name="qianming" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                            </div>
                                            <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">说明：</td>
                                        <td><textarea class="FrameGroupInput" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td class="FrameGroupName">相关文件 ：</td>
                                        <td>
                                            <ul class="FileBox">

                                            </ul>
                                            <input class="None addFileVal fileToUpload" id="fileToUpload1" name="fileToUpload1" type="file" name="" id="" value="" />
                                            <span class="addFile">+添加文件</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="Btn Btn-blue" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                <?php } ?>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
            
        </div>
    </div>

</body>
<script type="text/javascript">
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
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('apply', "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
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


