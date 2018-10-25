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
                <form id="check_form">
                    <input type="hidden" name="id" value="<?php echo $result['id'];?>"/>
                    <div class="top20">
                        <table class="Table TabInp textCenter">
                            <thead>
                                <tr>
                                    <th colspan="6">例行检验参数设置</th>
                                </tr>
                                <tr>
                                    <th>分类</th>
                                    <th class="textLeft" colspan="<?php echo ($type==3||$type==5)?'2':''?>">
                                        <select name="type" class="FrameGroupInput">
                                            <option value="">请选择</option>
                                            <?php foreach($GLOBALS['DYCT_TYPE'] as $k=>$v){?>
                                            <option <?php echo $type==$k?'selected=""':''?> value="<?php echo $k?>"><?php echo $v?></option>
                                            <?php }?>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th>产品名</th>
                                    <th class="textLeft" colspan="<?php echo ($type==3||$type==5)?'2':''?>">
                                        <input type="text"  class="FrameGroupInput" name="name" value="<?php echo $result['name']?>" placeholder="产品名">
                                    </th>
                                </tr>
                                <tr class="<?php echo $type?'':'None'?>">
                                    <th>检验项目</th>
                                    <?php if($type==3||$type==5){?>
                                    <th>检验设备</th>
                                    <?php }?>
                                    <th>参数设置</th>
                                </tr>
                            </thead>
                            <?php $k=0;?>
                            <tbody class="TabInp">
                                <!--GGJ低压无偿柜参数start-->
                                <?php if($type==1){?>
                                <tr>
                                    <td rowspan="7">一般检查</td>
                                    <td>检查成套设备,包括检查连接线：</td>
                                </tr>
                                <tr>
                                    <td>1.对机械操作元件、联锁、锁扣等部件的有效性进行检查；</td>
                                </tr>
                                <tr>
                                    <td>2.检查导线、电器的布置、安装是否正确；</td>
                                </tr>
                                <tr>
                                    <td>3.检查连接，特别是螺钉连接是否接触良好；</td>
                                </tr>
                                <tr>
                                    <td>4.成套设备与技术数据、标志、电路图、接线图、资料是否相符</td>
                                </tr>
                                <tr>
                                    <td>5.电气间隙≥<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="10mm"></td>
                                </tr>
                                <tr>
                                    <td>6.爬电距离≥<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="14mm"></td>
                                </tr>
                                <tr>
                                    <td>绝 缘 电 阻的验证</td>
                                    <td>相对地标称电压的绝缘电阻应＞<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1000Ω/V"></td>
                                </tr>
                                <tr>
                                    <td rowspan="5">介电强度试验</td>
                                    <td>施加交流正弦波50Hz电压<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="2500V">施压时间<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1s">,施压部位如下:结论:不可有击穿或闪络现象。</td>
                                </tr>
                                <tr>
                                    <td>1.成套设备的所有带电部件与裸露导电部件之间;</td>
                                </tr>
                                <tr>
                                    <td>2.每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其它极之间;</td>
                                </tr>
                                <tr>
                                    <td>3.绝缘材料制造的外壳和手柄上覆盖金属箔,在金属箔上与带电部件以及裸导电部件之间施电压,但其值为<input class="FrameGroupInput" type="text" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="3750V"></td>
                                </tr>
                                <tr>
                                    <td>4.不与主回路相连的的辅助回路试验电压见下表
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
                                </tr>
                                <tr>
                                    <td rowspan="7">保护电路的连续性验证</td>
                                </tr>
                                <tr>
                                    <td>是否有保护电路连续性措施</td>
                                </tr>
                                <tr>
                                    <td>仪表门对主接地≤<input class="FrameGroupInput" type="text" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="100Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>主断路器框架对主接地≤<input class="FrameGroupInput" type="text" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="100Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>分支断路器/熔断器框架对主接地≤<input class="FrameGroupInput" type="text" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="100Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>端子排支架对主接地≤<input class="FrameGroupInput" type="text" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="100Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>互感器对主接地≤<input class="FrameGroupInput" type="text" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="100Ω/V"></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">通电操作及机械操作试验</td>
                                </tr>
                                <tr>
                                    <td>检查装置接线正确无误后，在辅助电路分别通以额定电压的85%、110％，各操作 <input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" type="text" placeholder="5"> 次，应符合要求</td>
                                </tr>
                                <tr>
                                    <td>对主开关操作手柄，操作 <input type="text" class="FrameGroupInput" name="parameter[]" type="text" value="<?php echo $result['parameter'][$k++]?>" placeholder="5"> 次，机构应动作可靠，正常。</td>
                                </tr>
                                <tr>
                                    <td>防护等级</td>
                                    <td>进行直观检查以保证规定的防护等级<input type="text" class="FrameGroupInput" name="parameter[]" type="text" value="<?php echo $result['parameter'][$k++]?>" placeholder="IP30"></td>
                                </tr>
                                <tr>
                                    <td>工频过电压保护试验</td>
                                    <td>将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除</td>
                                </tr>
                                <tr>
                                    <td>缺相保护</td>
                                    <td>试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        结论:该产品经检验合格符合 <input type="text" class="FrameGroupInput" name="parameter[]" type="text" value="<?php echo $result['parameter'][$k++]?>" placeholder="GB/T15576-2008"> 检验要求
                                    </td>
                                </tr>
                                <!--GGJ低压无偿柜参数end-->
                                <!--JP电容柜参数start-->
                                <?php }else if($type==2){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td>防护等级应达到<input type="text" placeholder="IP44" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>">，工厂生产工艺和产品结构应符合相关要求。</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">开关器件和元件的组合</td>
                                    <td>a)内装元器件符合相关标准，安装和标志应符合GB/T4205规定和按照制造商说明书安装，元器件的相关参数应符合该产品相关电路的参数。</td>
                                </tr>
                                <tr>
                                    <td>b)接线端子（不包括保护导体端子）安装离成套基础面上方至少200mm并易于连接。</td>
                                </tr>
                                <tr>
                                    <td>c)指示灯和按钮颜色符合GB/T4025(IEC 60073)规定。</td>
                                </tr>
                                <tr>
                                    <td>d)各类连接,接触（螺钉）符合要求。</td>
                                </tr>
                                <tr>
                                    <td rowspan="7">内部电路和连接、电气间隙与爬电距离</td>
                                    <td>检查成套设备,包括检查连接线：</td>
                                </tr>
                                <tr>
                                    <td>1.对机械操作元件、联锁、锁扣等部件的有效性进行检查；</td>
                                </tr>
                                <tr>
                                    <td>2.检查导线、电器的布置、安装是否正确；</td>
                                </tr>
                                <tr>
                                    <td>3.检查连接，特别是螺钉连接是否接触良好；</td>
                                </tr>
                                <tr>
                                    <td>4.成套设备与技术数据、标志、电路图、接线图、资料是否相符</td>
                                </tr>
                                <tr>
                                    <td>5.电气间隙≥<input type="text" class="FrameGroupInput" placeholder="10mm" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>"></td>
                                </tr>
                                <tr>
                                    <td>6.爬电距离≥<input type="text" class="FrameGroupInput" placeholder="14mm" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>"></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td>相对地标称电压的绝缘电阻应><input type="text" placeholder="1000Ω/V" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" class="FrameGroupInput"></td>
                                </tr>
                                <tr>
                                    <td>外接导线端子</td>
                                    <td>端子的类型及标识符合设计要求。</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">介电强度试验</td>
                                    <td>施加交流正弦波 50Hz 电压<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="2500V">施压时间 <input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1s">,施压部位如下: 结论:不可有击穿或闪络现象。</td>
                                </tr>
                                <tr>
                                    <td>1.成套设备的所有带电部件与裸露导电部件之间;</td>
                                </tr>
                                <tr>
                                    <td>2.每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其它极之间;</td>
                                </tr>
                                <tr>
                                    <td>3.绝缘材料制造的外壳和手柄上覆盖金属箔,在金属箔上与带电部件以及裸导电部件之间施电压,但其值为 <input type="text" class="FrameGroupInput" name="parameter[]"  value="<?php echo $result['parameter'][$k++]?>" placeholder="3750V">。</td>
                                </tr>
                                <tr>
                                    <td rowspan="6">保护电路的连续性验证</td>
                                    <td>是否有保护电路连续性措施</td>
                                </tr>
                                <tr>
                                    <td>仪表门对主接地≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td>主断路器框架对主接地≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td>分支断路器/熔断器安装支架对主接地≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td>端子排支架对主接地≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td>互感器安装支架对主接地≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">通电操作及机械操作试验</td>
                                    <td>检查装置接线正确无误后，在辅助电路分别通以额定电压的 85%、110％，各操作<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5">次，应符合要求</td>
                                </tr>
                                <tr>
                                    <td>对主开关操作手柄，操作<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5">次，机构应动作可靠，正常。</td>
                                </tr>
                                <tr>
                                    <td>工频过电压保护试验</td>
                                    <td>将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除。</td>
                                </tr>
                                <tr>
                                    <td>缺相保护</td>
                                    <td>试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。</td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td>成套设备的铭牌参数，标识符合标准要求，检查布线符合设计资料要求，通电操作试验符合设计原理要求。检查元器件以及通信器件符合所选现场总线协议或其他数字通信协议的要求，应满足与上位机实现“遥调，遥测，遥控，遥信”等功能。</td>
                                </tr>
                                <tr>
                                    <td colspan="2">结论:该产品经检验合格符合 GB/T15576-2008 GB/T7251.12-2013 GB/T7251.8-2005 检验要求</td>
                                </tr>
                                <!--JP电容柜参数end-->
                                <!--XL-21参数start-->
                                <?php }else if($type==3){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td>物体试具</td>
                                    <td>达到防护等级 <input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="IP30">。用直径 <input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="2.5+0.05 mm">直的硬钢丝，钢丝应不能进入壳内。</td>
                                </tr>
                                <tr>
                                    <td>开关器件和元件的组合</td>
                                    <td rowspan="2">目测、卷尺</td>
                                    <td>内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合 GB/T4025(IEC60073)规定</td>
                                </tr>
                                <tr>
                                    <td>内部电路和连接、外接导线端子</td>
                                    <td>检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。</td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td>目测、电源车</td>
                                    <td>对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求</td>
                                </tr>
                                <tr>
                                    <td>电气间隙</td>
                                    <td rowspan="2">游标卡尺</td>
                                    <td>电气间隙：检验部位：相与相之间≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5.5mm"></td>
                                </tr>
                                <tr>
                                    <td>爬电距离</td>
                                    <td>爬电距离：检验部位：相与相之间≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5.5mm"></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td>绝缘电阻表</td>
                                    <td>相对地标称电压的绝缘电阻应><input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1000Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>电击防护和保护电路完整性</td>
                                    <td>接地电阻测试仪</td>
                                    <td>允许值应≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ">，测试电流≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="10A">，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤<input type="text" class="FrameGroupInput" name="parameter[]" placeholder="100mΩ" value="<?php echo $result['parameter'][$k++]?>"></td>
                                </tr>
                                <tr>
                                    <td>介电性能</td>
                                    <td>耐压测试仪</td>
                                    <td>试压时间<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder=" 1S">，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1890V">）；非主电路供电的辅助回路与地之间（1890V）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="2835V">）</td>
                                </tr>
                                <tr>
                                    <td>机械操作</td>
                                    <td>手动</td>
                                    <td>可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder=" 5 ">次是否良好</td>
                                </tr>
                                <tr>
                                    <td colspan="3">检验依据及结论:依据 GB/T7251.3-2017 
                                        <label><span class="radio ">合格</span><input type="radio" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" class="None" value="1"></label>
                                        ，准予加施 C 3C  标志出厂； 
                                        <label><span class="radio ">不合格</span><input type="radio" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" class="None" value="0"></label>，返工至合格
                                    </td>
                                </tr>
                                <!--XL-21参数end-->
                                <!--XM电气装配工序流程卡参数start-->
                                <?php }else if($type==4){?>
                                <tr>
                                    <td rowspan="6">元器件安装</td>
                                    <td>箱(柜)体尺寸、结构与订单相符，外观无损</td>
                                </tr>
                                <tr>
                                    <td>元器件型号、规格与材料单相符，安装位置正确</td>
                                </tr>
                                <tr>
                                    <td>元件代号标识正确、齐全</td>
                                </tr>
                                <tr>
                                    <td>方便客户进出线</td>
                                </tr>
                                <tr>
                                    <td>机械操作灵活，多极开关同期性好，联锁可靠</td>
                                </tr>
                                <tr>
                                    <td>接地连续性的标识检查</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">一次线安装</td>
                                    <td>线径选择适当</td>
                                </tr>
                                <tr>
                                    <td>布线符合图纸及工艺要求</td>
                                </tr>
                                <tr>
                                    <td>相序排列正确，标识清楚</td>
                                </tr>
                                <tr>
                                    <td>紧固件松紧适度</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">二次线安装</td>
                                    <td>布线符合图纸及工艺要求</td>
                                </tr>
                                <tr>
                                    <td>线耳压接牢靠</td>
                                </tr>
                                <tr>
                                    <td>线号齐全，方向正确且与图纸一致</td>
                                </tr>
                                <tr>
                                    <td>紧固件松紧适度</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">电气间隙和爬电距离</td>
                                    <td>电气间隙符合标准要求≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5.5mm"></td>
                                </tr>
                                <tr>
                                    <td>爬电距离符合标准要求≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="6.3mm"></td>
                                </tr>
                                <tr>
                                    <td rowspan="6">电气性能检查</td>
                                    <td>一次回路、二次回路能承受规定的工频耐压值</td>
                                </tr>
                                <tr>
                                    <td>必要时验证保护电路的电连续性</td>
                                </tr>
                                <tr>
                                    <td>测量回路、计量回路的仪表，指示准确且与主回</td>
                                </tr>
                                <tr>
                                    <td>控制回路各元件动作程序正确，指示对应</td>
                                </tr>
                                <tr>
                                    <td>电气联锁可靠</td>
                                </tr>
                                <tr>
                                    <td>具有保护功能的元件，其功能可靠</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">产品一致性检查</td>
                                    <td>产品结构是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td>产品铭牌及标志、主要技术参数是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td>主断路器/铜排/绝缘件是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td>电流互感器是否与型式试验报告一致</td>
                                </tr>
                                <tr>
                                    <td colspan="2">注：“质量结果”栏处，“√”表示合格，“X”表示不合格，“/”表示无此项。</td>
                                </tr>
                                <!--XM电气装配工序流程卡参数end-->
                                <!--XM例行确认检查参数start-->
                                <?php }else if($type==5){?>
                                <tr>
                                    <td>防护等级</td>
                                    <td>物体试具、目测</td>
                                    <td>防护等级应达到<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="IP20C"></td>
                                </tr>
                                <tr>
                                    <td>开关器件和元件的组合</td>
                                    <td rowspan="2">目测、卷尺</td>
                                    <td>内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合 GB/T4025(IEC60073)规定</td>
                                </tr>
                                <tr>
                                    <td>内部电路和连接、外接导线端子</td>
                                    <td>检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。</td>
                                </tr>
                                <tr>
                                    <td>布线、操作性能和功能</td>
                                    <td>目测、电源车</td>
                                    <td>对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。</td>
                                </tr>
                                <tr>
                                    <td>电气间隙</td>
                                    <td rowspan="2">游标卡尺</td>
                                    <td>电气间隙：检验部位：相与相之间≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="5.5mm"></td>
                                </tr>
                                <tr>
                                    <td>爬电距离</td>
                                    <td>爬电距离：检验部位:相与相之间≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="6.3mm"></td>
                                </tr>
                                <tr>
                                    <td>绝缘电阻的验证</td>
                                    <td>绝缘电阻表</td>
                                    <td>相对地标称电压的绝缘电阻应><input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1000Ω/V"></td>
                                </tr>
                                <tr>
                                    <td>电击防护和保护电路完整性</td>
                                    <td>接地电阻测试仪</td>
                                    <td>允许值应≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100">，测试电流≥<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="10A">，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="100mΩ"></td>
                                </tr>
                                <tr>
                                    <td>介电性能</td>
                                    <td>耐压测试仪</td>
                                    <td>试压时间<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1S">，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1890V">）；非主电路供电的辅助回路与地之间（<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="1890V">）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（<input type="text" class="FrameGroupInput" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" placeholder="2835V">）</td>
                                </tr>
                                <tr>
                                    <td>机械操作</td>
                                    <td>手动</td>
                                    <td>可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为 5 次是否良好</td>
                                </tr>
                                <tr>
                                    <td colspan="3">检验依据及结论:依据 GB/T7251.3-2017 
                                        <label><span class="radio ">合格</span><input type="radio" name="parameter[]" value="<?php echo $result['parameter'][$k++];?>" class="None"></label>
                                        ，准予加施 C 3C  标志出厂； 
                                        <label><span class="radio ">不合格</span><input type="radio" name="parameter[]" value="<?php echo $result['parameter'][$k++]?>" class="None" value="0"></label>，返工至合格
                                    </td>
                                </tr>
                                <?php }?>
                                <!--XM例行确认检查参数end-->
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
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        
        $('select[name="type"').change(function(){
            var type = $(this).val();
            window.location.href = '<?php echo spUrl($c,$a,array('id'=>$result['id']))?>'+'?type='+type;
        });


    });
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveDyctparm'); ?>",
            data:$('#check_form').serialize(),
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


