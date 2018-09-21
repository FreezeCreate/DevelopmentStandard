<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
<style>
    .TabInp textarea { text-align: left; text-indent: 0; padding: 0;}
</style>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <!--                <div class="textRight">
                                    <span class="Btn Btn-grey"><i class="icon-back"></i>返回上一级</span>
                                    <span class="Btn Btn-blue"><i class="icon-print"></i>打印</span>
                                </div>-->
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <input type="hidden" name="type" value="<?php echo $type;?>"/>
                    <div class="top20">
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th>订单</th>
                                    <th colspan="2" class="textLeft">
                                        <select name="oid" class="FrameGroupInput">
                                            <option value="">请选择</option>
                                            <?php foreach($orders as $k=>$v){?>
                                            <option <?php echo $result['oid']==$v['id']?'selected=""':''?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                            <?php }?>
                                        </select>
                                    </th>
                                    <th>表格模板</th>
                                    <th colspan="2" class="textLeft">
                                        <select name="mid" class="FrameGroupInput">
                                            <option value="-1">默认模板</option>
                                            <?php foreach($examples as $k=>$v){?>
                                            <option <?php echo $mid==$v['id']?'selected=""':''?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                            <?php }?>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6"><input type="text" name="title" value="<?php echo empty($result['title'])?$t:$result['title'] ?>" /></th>
                                </tr>
                                <tr>
                                    <th width="100">文件编号</th><th colspan="7" class="textLeft"><input type="text" name="number" value="<?php echo $result['number'] ?>" /></th>
                                </tr>
                                <tr>
                                    <th width="100">产品名称</th><th><input type="text" name="name" value="<?php echo $result['name'] ?>" /></th>
                                    <th>型号规格</th><th><input type="text" name="format" value="<?php echo $result['format'] ?>" /></th>
                                    <th>数量</th><th><input style="width: 70px;" name="num" type="text" value="<?php echo $result['num'] ?>" />台</th>
                                </tr>
                                <tr>
                                    <th>检验日期</th><th><input type="text" id="dt" name="dt" value="<?php echo $result['dt'] ?>" /></th>
                                    <th>产品编号</th><th><input type="text" name="pnumber" value="<?php echo $result['pnumber'] ?>" /></th>
                                    <th>检验员</th>
                                    <th>
                                        <div class="UpgrapImg" onclick="$('#fileToUploadQm').click();">
                                            <img class="" src="<?php echo empty($admin['qianming']) ? SOURCE_PATH . '/images/qianming.png' : $admin['qianming']; ?>"/>
                                            <input type="hidden" name="sign" value="<?php echo empty($admin['qianming']) ? '' : $admin['qianming']; ?>"/>
                                        </div>
                                        <input type="file" class="None UpgrapVal" name="fileToUploadQm" id="fileToUploadQm" onchange="ajaxFileUpload()"/>
                                    </th>
                                </tr>
                                <tr>
                                    <th>检验项目</th><th>检验设备</th><th colspan="2">内容及要求</th><th>检验记录</th><th>检验结论</th>
                                </tr>
                            </thead>
                            <tbody class="TabInp">
                                <tr>
                                    <td><?php echo empty($mid)?'防护等级':$mode['q1']?></td>
                                    <td><?php echo empty($mid)?'物体试具':$mode['w1']?></td>
                                    <td colspan="2"><?php echo empty($mid)?'达到防护等级IP30。用直径2.5+0.05mm直的硬钢丝，钢丝应不能进入壳内。':$mode['e1']?></td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo $result['jilu']['q1']==1?'active':''?>">可</span><input type="radio" <?php echo $result['jilu']['q1']==1?'checked=""':''?> name="jilu[q1]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q1']==0?'active':''?>">否</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q1']==0?'checked=""':''?> name="jilu[q1]"class="None"value="0" /></label>
                                        进入柜体
                                        <?php }else{?>
                                        <input type="text" name="jilu[q1]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q1']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==1?'checked=""':''?> name="jielun[q1]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q1']==0?'checked=""':''?> name="jielun[q1]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'开关器件和元件的组合':$mode['q2']?></td>
                                    <td><?php echo empty($mid)?'目测':$mode['w2']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'1.内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合GB/T4025(IEC 60073)规定
                                        不包括保护导体端子，应位于成套设备的基础上方至少0.2m,并且端子的位置应使电缆易于与其连接。':$mode['e2']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==1?'checked=""':''?> name="jilu[q2]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q2']==0?'checked=""':''?> name="jilu[q2]"class="None"value="0" /></label>
                                        <?php }else{?>
                                        <input type="text" name="jilu[q2]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q2']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==1?'checked=""':''?> name="jielun[q2]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q2']==0?'checked=""':''?> name="jielun[q2]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'内部电路和连接、外接导线端子':$mode['q3']?></td>
                                    <td><?php echo empty($mid)?'目测':$mode['w3']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。':$mode['e3']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==1?'checked=""':''?> name="jilu[q3]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q3']==0?'checked=""':''?> name="jilu[q3]"class="None"value="0" /></label>
                                        <?php }else{?>
                                        <input type="text" name="jilu[q3]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q3']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==1?'checked=""':''?> name="jielun[q3]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q3']==0?'checked=""':''?> name="jielun[q3]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'布线、操作性能和功能':$mode['q4']?></td>
                                    <td><?php echo empty($mid)?'目测、电源车':$mode['w4']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。':$mode['e4']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==1?'checked=""':''?> name="jilu[q4]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q4']==0?'checked=""':''?> name="jilu[q4]"class="None"value="0" /></label>
                                        <?php }else{?>
                                        <input type="text" name="jilu[q4]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q4']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==1?'checked=""':''?> name="jielun[q4]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q4']==0?'checked=""':''?> name="jielun[q4]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'电气间隙':$mode['q5']?></td>
                                    <td><?php echo empty($mid)?'游标卡尺':$mode['w5']?></td> 
                                    <td colspan="2">
                                        <?php echo empty($mid)?'电气间隙：检验部位：相与相之间≥5.5mm':$mode['e5']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        最小值<input type="text"class="smallInp" name="jilu[q5]" value="<?php echo $result['jilu']['q5'];?>" />mm
                                        <?php }else{?>
                                        <input type="text" name="jilu[q5]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q5']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==1?'checked=""':''?>name="jielun[q5]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q5']==0?'checked=""':''?>name="jielun[q5]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'绝缘电阻的验证':$mode['q6']?></td>
                                    <td><?php echo empty($mid)?'游标卡尺':$mode['w6']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'爬电距离：检验部位:相与相之间≥10mm':$mode['e6']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        最小值<input type="text"class="smallInp" name="jilu[q6]" value="<?php echo $result['jilu']['q6'];?>" />mm
                                        <?php }else{?>
                                        <input type="text" name="jilu[q6]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q6']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==1?'checked=""':''?>name="jielun[q6]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q6']==0?'checked=""':''?>name="jielun[q6]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'爬电距离':$mode['q7']?></td>
                                    <td><?php echo empty($mid)?'绝缘电阻表':$mode['w7']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'相对地标称电压的绝缘电阻应＞500MΩ':$mode['e7']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        ＞<input type="text"class="smallInp" name="jilu[q7]" value="<?php echo $result['jilu']['q7'];?>" />MΩ
                                        <?php }else{?>
                                        <input type="text" name="jilu[q7]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q7']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==1?'checked=""':''?>name="jielun[q7]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q7']==0?'checked=""':''?>name="jielun[q7]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'电击防护和保护电路完整性':$mode['q8']?></td>
                                    <td><?php echo empty($mid)?'接地电阻测试仪':$mode['w8']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'允许值应≤100mΩ，测试电流10-25A，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤100mΩ（取样点不小于3点）':$mode['e8']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <p>测量<input type="text"class="smallInp" name="jilu[q8-1]" value="<?php echo $result['jilu']['q8-1'];?>" />点</p>
                                        <p>最大<input type="text"class="smallInp" name="jilu[q8-2]" value="<?php echo $result['jilu']['q8-2'];?>" />mΩ</p>
                                        <p>通电电流<input type="text"class="smallInp" name="jilu[q8-3]" value="<?php echo $result['jilu']['q8-3'];?>" />A</p>
                                        <?php }else{?>
                                        <input type="text" name="jilu[q8]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q8']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==1?'checked=""':''?> name="jielun[q8]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q8']==0?'checked=""':''?> name="jielun[q8]"class="None"value="0" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'介电性能':$mode['q9']?></td>
                                    <td><?php echo empty($mid)?'耐压测试仪':$mode['w9']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'试压时间1S，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（1890V）；非主电路供电的辅助回路与地之间（1890V）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（2835V）':$mode['e9']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==1?'active':''?>">有</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==1?'checked=""':''?> name="jilu[q9]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==0?'active':''?>">无</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q9']==0?'checked=""':''?> name="jilu[q9]"class="None"value="0" /></label>
                                        击穿或放电现象
                                        <?php }else{?>
                                        <input type="text" name="jilu[q9]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q9']:''?>"/>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==1?'active':''?>">合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==1?'checked=""':''?> name="jielun[q9]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==0?'active':''?>">不合格</span><input type="radio" <?php echo !empty($result['jielun'])&&$result['jielun']['q9']==0?'checked=""':''?> name="jielun[q9]"class="None"value="1" /></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo empty($mid)?'机械操作':$mode['q10']?></td>
                                    <td><?php echo empty($mid)?'手动':$mode['w10']?></td>
                                    <td colspan="2">
                                        <?php echo empty($mid)?'可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为5次是否良好':$mode['e10']?>
                                    </td>
                                    <td>
                                        <?php if(empty($mid)){?>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==1?'active':''?>">符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==1?'checked=""':''?> name="jilu[q10]"class="None"value="1" /></label>
                                        <label><span class="radio <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==0?'active':''?>">不符合</span><input type="radio" <?php echo !empty($result['jilu'])&&$result['jilu']['q10']==0?'checked=""':''?> name="jilu[q10]"class="None"value="0" /></label>
                                        <?php }else{?>
                                        <input type="text" name="jilu[q10]" value="<?php echo !empty($result['jilu'])?$result['jilu']['q10']:''?>"/>
                                        <?php }?>
                                    </td>
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
                <div style="height: 50px;"></div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">保存</span>
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
        
        $('select[name="mid"').change(function(){
            var mid = $(this).val();
            window.location.href = '<?php echo spUrl($c,$a,array('id'=>$result['id'],'type'=>$type))?>'+'?mid='+mid;
        });


    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveDyctlog'); ?>",
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


