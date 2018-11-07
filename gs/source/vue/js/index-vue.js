var right = new Vue({
    el: '#right',
    data: {
        url: dataURL + '/app.php/service/saveJsonProduct',
        token,
        type: 3,
        mid: 1,
        oid: 0,
        tit: [
            ['技术要求：', '测试结果：', '判断：', '备注：'],
            ['技术要求：', '测试结果：', '判断：', '备注：'],
            ['检验设备：', '内容及要求：', '检验记录：', '检验结论：'],
            ['操作要点：', '质量情况：', '操作者/检验员：', '日期：'],
            ['检验设备：', '内容及要求：', '检验记录：', '检验结论：'],
        ],
        headname: [//content||name
            [
                {name: 'name', content: '产品名称：'},
                {name: 'prodt', content: '生产日期：',class: 'DateTime',readonly: 'readonly'},
                {name: 'sign', content: '检验员：'},
                {name: 'format', content: '型号规格：'},
                {name: 'pnumber', content: '产品编号：'},
                {name: 'dt', content: '检验日期：',class: 'DateTime',readonly: 'readonly'},
            ],
            [
                {name: 'name', content: '产品名称：'},
                {name: 'prodt', content: '生产日期：',class: 'DateTime',readonly: 'readonly'},
                {name: 'sign', content: '检验员：'},
                {name: 'format', content: '型号规格：'},
                {name: 'pnumber', content: '产品编号：'},
                {name: 'dt', content: '检验日期：',class: 'DateTime',readonly: 'readonly'},
            ],
            [
                {name: 'name', content: '产品名称：'},
                {name: 'format', content: '型号规格/A：'},
                {name: 'num', content: '检验数量/台：'},
                {name: 'dt', content: '检验日期：',class: 'DateTime',readonly: 'readonly'},
                {name: 'pnumber', content: '产品编号：'},
                {name: 'sign', content: '检验员：'},
            ],
            [
                {name: 'name', content: '产品名称：'},
                {name: 'format', content: '型号：'},
                {name: 'pnumber', content: '产品编号：'},
            ],
            [
                {name: 'name', content: '产品名称：'},
                {name: 'format', content: '型号规格/A：'},
                {name: 'num', content: '检验数量/台：'},
                {name: 'dt', content: '检验日期：',class: 'DateTime',readonly: 'readonly'},
                {name: 'pnumber', content: '产品编号：'},
                {name: 'sign', content: '检验员：'},
            ],
        ],
        items: [
            [//第一个模板
                {
                    class: '一般检查',
                    list: [
                        {title: '检查成套设备，包括检查连接线', status: 'q1', info: 'w1', content: 'e1'},
                        {title: '1.对机械操作元件、连锁、锁扣等部件的有效性进行检查', status: 'q2', info: 'w2', content: 'e2'},
                        {title: '2.检查导线、电器的布置、安装是否正确', status: 'q3', info: 'w3', content: 'e3'},
                        {title: '3.检查连接，特别是螺丝连接是否良好', status: 'q4', info: 'w4', content: 'e4'},
                        {title: '4.成套设备与技术数据、标志、电路图、接线图、资料是否相符', status: 'q5', info: 'w5', content: 'e5'},
                        {title: '5.电气间隙≥10mm', status: 'q6', info: 'w6', content: 'e6'},
                        {title: '6.爬电距离≥14mm', status: 'q7', info: 'w7', content: 'e7'},
                    ]
                },
                {class: '绝缘电阻的验证', list: [
                        {title: '相对地标称电压的绝缘电阻应＞ 1000Ω/V', status: 'q8', info: 'w8', content: 'e8'},
                    ]},
                {class: '介电强度试验', list: [
                        {title: '施加交流正弦波50Hz电压2500V施加时间1s，施加部位如下：', status: 'q9', info: 'w9', content: 'e9'},
                        {title: '成套设备的所有电部件与裸露导电部件之间', status: 'q10', info: 'w10', content: 'e10'},
                        {title: '每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其他极之间', status: 'q11', info: 'w11', content: 'e11'},
                        {title: '绝缘材料制造的外壳和手柄上覆盖全金属箔，在金属箔之上与带电部件以及裸导电部件之间施电压，但其值为3750V', status: 'q12', info: 'w12', content: 'e12'},
                        {title: '不与主回路相连的辅助回路试验电压见下表', tableLst: [{name: 'Ui≤12', content: '250V(250V)'}, {name: '12≤Ui≤60', content: '500V(500V)'}, {name: '60≤Ui', content: '100+2Ui,最小150V'}], status: 'q13', info: 'w13', content: 'e13'},
                    ]},
                {class: '保护电路的延续性验证', list: [
                        {title: '是否有保护电路连续性措施', status: 'q14', info: 'w14', content: 'e14'},
                        {title: '仪表门对主接地≤100mΩ', status: 'q15', info: 'w15', content: 'e15'},
                        {title: '主断路器框架对主接地≤100mΩ', status: 'q16', info: 'w16', content: 'e16'},
                        {title: '分支断路器/熔断器框架对主接地≤100mΩ', status: 'q17', info: 'w17', content: 'e17'},
                        {title: '端子排支架对主接地≤100mΩ', status: 'q18', info: 'w18', content: 'e18'},
                        {title: '互感器对主接地≤100mΩ', status: 'q19', info: 'w19', content: 'e19'},
                    ]},
                {class: '通电操作及机械操作试验', list: [
                        {title: '检查装置接线正确无误后，在辅助电路分别通以额定电压的85%、110％，各操作 5 次，应符合要求', status: 'q20', info: 'w20', content: 'e20'},
                        {title: '对主开关操作手柄，操作 5 次，机构应动作可靠，正常', status: 'q21', info: 'w21', content: 'e21'},
                    ]},
                {class: '防护等级', list: [
                        {title: '进行直观检查以保证规定的防护等级 IP30 ', status: 'q22', info: 'w22', content: 'e22'},
                    ]},
                {class: '工频过电压保护试验', list: [
                        {title: '将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除', status: 'q23', info: 'w23', content: 'e23'},
                    ]},
                {class: '缺相保护', list: [
                        {title: '试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。', status: 'q24', info: 'w24', content: 'e24'},
                    ]},
            ],
            [//第二个模板
                {
                    class: '防护等级',
                    list: [
                        {title: '防护等级应达到 IP44，工厂生产工艺和产品结构应符合相关要求。', status: 'q1', info: 'w1', content: 'e1'},
                    ],
                },
                {
                    class: '开关器件和元件的组合',
                    list: [
                        {title: 'a)内装元器件符合相关标准，安装和标志应符合GB/T4205规定和按照制造商说明书安装，元器件的相关参数应符合该产品相关电路的参数。', status: 'q2', info: 'w2', content: 'e2'},
                        {title: 'b)接线端子（不包括保护导体端子）安装离成套基础面上方至少200mm并易于连接。', status: 'q3', info: 'w3', content: 'e3'},
                        {title: 'c)指示灯和按钮颜色符合GB/T4025(IEC 60073)规定', status: 'q4', info: 'w4', content: 'e4'},
                        {title: 'd)各类连接,接触（螺钉）符合要求。', status: 'q5', info: 'w5', content: 'e5'},
                    ],
                },
                {
                    class: '内部电路和连接、电气间隙与爬电距离',
                    list: [
                        {title: '检查成套设备,包括检查连接线', status: 'q6', info: 'w6', content: 'e6'},
                        {title: '1.对机械操作元件、联锁、锁扣等部件的有效性进行检查', status: 'q7', info: 'w7', content: 'e7'},
                        {title: '2.检查导线、电器的布置、安装是否正确', status: 'q8', info: 'w8', content: 'e8'},
                        {title: '3.检查连接，特别是螺钉连接是否接触良好', status: 'q9', info: 'w9', content: 'e9'},
                        {title: '4.成套设备与技术数据、标志、电路图、接线图、资料是否相符', status: 'q10', info: 'w10', content: 'e10'},
                        {title: '5.电气间隙≥10mm', status: 'q11', info: 'w11', content: 'e11'},
                        {title: '6.爬电距离≥14mm', status: 'q12', info: 'w12', content: 'e12'},
                    ],
                },
                {
                    class: '绝缘电阻的验证',
                    list: [
                        {title: '相对地标称电压的绝缘电阻应＞1000Ω/V', status: 'q13', info: 'w13', content: 'e13'},
                    ],
                },
                {
                    class: '外接导线端子',
                    list: [
                        {title: '端子的类型及标识符合设计要求。', status: 'q14', info: 'w14', content: 'e14'},
                    ],
                },
                {
                    class: '介电强度试验',
                    list: [
                        {title: '施加交流正弦波 50Hz 电压 2500V 施压时间 1s,施压部位如下: 结论:不可有击穿或闪络现象。', status: 'q15', info: 'w15', content: 'e15'},
                        {title: '1.成套设备的所有带电部件与裸露导电部件之间;', status: 'q16', info: 'w16', content: 'e16'},
                        {title: '2.每极和为此试验被连接到成套设备相应连接的裸露导电部件上的所有其它极之间;', status: 'q17', info: 'w17', content: 'e17'},
                        {title: '3.绝缘材料制造的外壳和手柄上覆盖金属箔,在金属箔上与带电部件以及裸导电部件之间施电压,但其值为 3750V。', status: 'q18', info: 'w18', content: 'e18'},
                    ],
                },
                {
                    class: '保护电路的连续性验证',
                    list: [
                        {title: '是否有保护电路连续性措施', status: 'q19', info: 'w19', content: 'e19'},
                        {title: '仪表门对主接地≤100mΩ', status: 'q20', info: 'w20', content: 'e20'},
                        {title: '主断路器框架对主接地≤100mΩ', status: 'q21', info: 'w21', content: 'e21'},
                        {title: '分支断路器/熔断器安装支架对主接地≤100mΩ', status: 'q22', info: 'w22', content: 'e22'},
                        {title: '端子排支架对主接地≤100mΩ', status: 'q23', info: 'w23', content: 'e23'},
                        {title: '互感器安装支架对主接地≤100mΩ', status: 'q24', info: 'w24', content: 'e24'},
                    ],
                },
                {
                    class: '通电操作及机械操作试验',
                    list: [
                        {title: '检查装置接线正确无误后，在辅助电路分别通以额定电压的 85%、110％，各操作 5 次，应符合要求', status: 'q25', info: 'w25', content: 'e25'},
                        {title: '对主开关操作手柄，操作 5 次，机构应动作可靠，正常。', status: 'q26', info: 'w26', content: 'e26'},
                    ],
                },
                {
                    class: '工频过电压保护试验',
                    list: [
                        {title: '将电容器拆除，装置接上电源，并将电容器投切开关闭合，调整电源电压 1.1 至 1.2 倍额定电压时，装置应在 1min 内将电容器切除。', status: 'q27', info: 'w27', content: 'e27'},
                    ],
                },
                {
                    class: '缺相保护',
                    list: [
                        {title: '试验前将电容器切除，给装置接上电源，并将电容器投切开关闭合，然后将主电路或支路的任一相断开。', status: 'q28', info: 'w28', content: 'e28'},
                    ],
                },
                {
                    class: '布线、操作性能和功能',
                    list: [
                        {title: '成套设备的铭牌参数，标识符合标准要求，检查布线符合设计资料要求，通电操作试验符合设计原理要求。检查元器件以及通信器件符合所选现场总线协议或其他数字通信协议的要求，应满足与上位机实现“遥调，遥测，遥控，遥信”等功能。', status: 'q29', info: 'w29', content: 'e29'},
                    ],
                },
            ],
            [//第三个模板
                {
                    class: '防护等级',
                    list: [
                        {title: '物体试具', content: '达到防护等级 IP30。用直径 2.5 +0.05 mm 直的硬钢丝，钢丝应不能进入壳内。', status: 'w1', info: {name: 'q1', content: '可进入柜体'}},
                    ],
                },
                {
                    class: '开关器件和元件的组合,内部电路和连接、外接导线端子',
                    list: [
                        {title: '目测、卷尺', content: '内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合GB/T4025(IEC60073)规定,检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。', status: 'w2', info: {name: 'q2', content: '符合'}},
                    ],
                },
                {
                    class: '布线、操作性能和功能',
                    list: [
                        {title: '目测、电源车', content: '对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。', status: 'w3', info: {name: 'q3', content: '符合'}},
                    ],
                },
                {
                    class: '电气间隙',
                    list: [
                        {title: '游标卡尺', content: '电气间隙：检验部位：相与相之间≥5.5mm', status: 'w4', infor: [{tit: '最小值', name: 'q4', unit: 'mm'}]},
                    ],
                },
                {
                    class: '爬电距离',
                    list: [
                        {title: '游标卡尺', content: '爬电距离：检验部位:相与相之间≥10mm', status: 'w5', infor: [{tit: '最小值', name: 'q5', unit: 'mm'}]},
                    ],
                },
                {
                    class: '绝缘电阻的验证',
                    list: [
                        {title: '绝缘电阻表', content: '相对地标称电压的绝缘电阻应＞1000Ω/V', status: 'w6', infor: [{tit: '>', name: 'q6', unit: 'Ω/V'}]},
                    ],
                },
                {
                    class: '电击防护和保护电路完整性',
                    list: [
                        {title: '接地电阻测试仪', content: '允许值应≤100mΩ，测试电流≥10A，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤100mΩ', status: 'w7', infor: [
                                {tit: '测量', name: 'q7', unit: '点'},
                                {tit: '最大', name: 'q7', unit: 'mΩ'},
                                {tit: '通电电流', name: 'q7', unit: 'A'}
                            ]},
                    ],
                },
                {
                    class: '介电性能',
                    list: [
                        {title: '耐压测试仪', content: '试压时间 1S，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（1890V）；非主电路供电的辅助回路与地之间（1890V）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（2835V）', status: 'w8', info: {name: 'q8', content: '有击穿或放电现象'}},
                    ],
                },
                {
                    class: '机械操作',
                    list: [
                        {title: '手动', content: '可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为 5 次是否良好', status: 'w9', info: {name: 'q9', content: '符合'}},
                    ],
                },
            ],
            [//第四个模板
                {
                    class: '元器件安装',
                    list: [
                        {
                            title: [
                                '箱(柜)体尺寸、结构与订单相符，外观无损',
                                '元器件型号、规格与材料单相符，安装位置正确',
                                '元件代号标识正确、齐全',
                                '方便客户进出线',
                                '机械操作灵活，多极开关同期性好，联锁可靠',
                                '接地连续性的标识检查',
                            ], user: 'w1', status: 'e1', info: {name: 'q1', content: '合格'}},
                    ],
                },
                {
                    class: '一次线安装',
                    list: [
                        {title: [
                                '线径选择适当',
                                '布线符合图纸及工艺要求',
                                '相序排列正确，标识清楚',
                                '紧固件松紧适度',
                            ], user: 'w2', status: 'e2', info: {name: 'q2', content: '合格'}},
                    ],
                },
                {
                    class: '二次线安装',
                    list: [
                        {title: [
                                '布线符合图纸及工艺要求',
                                '线耳压接牢靠',
                                '线号齐全，方向正确且与图纸一致',
                                '紧固件松紧适度',
                            ], user: 'w3', status: 'e3', info: {name: 'q3', content: '合格'}},
                    ],
                },
                {
                    class: '电气间隙和爬电距离',
                    list: [
                        {title: [
                                '电气间隙符合标准要求≥5.5mm',
                                '爬电距离符合标准要求≥6.3mm',
                            ], user: 'w4', status: 'e4', infor: [
                                {name: 'q4', tit: '电气间隙≥', unit: 'mm'},
                                {name: 'q4', tit: '爬电距离≥', unit: 'mm'}
                            ]},
                    ],
                },
                {
                    class: '电气性能检查',
                    list: [
                        {title: [
                                '一次回路、二次回路能承受规定的工频耐压值',
                                '必要时验证保护电路的电连续性',
                                '测量回路、计量回路的仪表，指示准确且与主回',
                                '控制回路各元件动作程序正确，指示对应',
                                '电气联锁可靠',
                                '具有保护功能的元件，其功能可靠',
                            ], user: 'w5', status: 'e5', info: {name: 'q5', content: '合格'}},
                    ],
                },
                {
                    class: '产品一致性检查',
                    list: [
                        {title: [
                                '产品结构是否与型式试验报告一致',
                                '产品铭牌及标志、主要技术参数是否与型式试验报告一致',
                                '主断路器/铜排/绝缘件是否与型式试验报告一致',
                                '电流互感器是否与型式试验报告一致',
                            ], user: 'w6', status: 'e6', info: {name: 'q6', content: '合格'}},
                    ],
                },
            ],
            [//第五个模板
                {
                    class: '防护等级',
                    list: [
                        {title: '物体试具、目测', content: '防护等级应达到 IP20C', status: 'w1', info: {name: 'q1', content: '可进入柜体或接触带电金属部件'}},
                    ],
                },
                {
                    class: '开关器件和元件的组合,内部电路和连接、外接导线端子',
                    list: [
                        {title: '目测、卷尺', content: '内装元件的安装和标识应符合成套设备制造商的说明书，指示灯和按钮颜色符合 GB/T4025(IEC60073)规定，检查端子的数量、类型和标识应符合成套设备制造商的说明书，检查连接，螺钉和螺栓的连接在任意的基座上能有正确的松紧度。端子的位置应高于地面 200mm，并使线缆易于其连接。', status: 'w2', info: {name: 'q2', content: '符合'}},
                    ],
                },
                {
                    class: '布线、操作性能和功能',
                    list: [
                        {title: '目测、电源车', content: '对机械操作元件、联锁、锁扣等部件的有效性进行检查；检查导线和电缆的布置是否正确；检查连接是否接触良好；检查成套设备与制造厂提供的电路，接线图和技术数据是否相符，以及铭牌和标志是否符合要求；（需要时）通电操作试验，按设备的电气原理图要求进行摸动作试验，试验结果应符合设计要求。', status: 'w3', info: {name: 'q3', content: '符合'}},
                    ],
                },
                {
                    class: '电气间隙',
                    list: [
                        {title: '游标卡尺', content: '电气间隙：检验部位：相与相之间≥5.5mm', status: 'w4', infor: [{name: 'q4', tit: '最小值', unit: 'mm'}]},
                    ],
                },
                {
                    class: '爬电距离',
                    list: [
                        {title: '游标卡尺', content: '爬电距离：检验部位:相与相之间≥6.3mm', status: 'w5', infor: [{name: 'q5', tit: '最小值', unit: 'mm'}]},
                    ],
                },
                {
                    class: '绝缘电阻的验证',
                    list: [
                        {title: '绝缘电阻表', content: '相对地标称电压的绝缘电阻应＞1000Ω/V', status: 'w6', infor: [{name: 'q6', tit: '>', unit: 'Ω/V'}]},
                    ],
                },
                {
                    class: '电击防护和保护电路完整性',
                    list: [
                        {title: '接地电阻测试仪', content: '允许值应≤100mΩ，测试电流≥10A，测量在进线保护导体的端子成套设备相应的裸露导电部件之间电阻值均应≤100mΩ', status: 'w7', infor: [
                                {name: 'q7', tit: '测量', unit: '点'},
                                {name: 'q7', tit: '最大', unit: 'mΩ'},
                                {name: 'q7', tit: '通电电流', unit: 'A'}
                            ]},
                    ],
                },
                {
                    class: '介电性能',
                    list: [
                        {title: '耐压测试仪', content: '试压时间 1S，施压部位及值如下:主电路相间、相对地及与主回路直接相连接的辅助回路与地之间（1890V）；非主电路供电的辅助回路与地之间（1890V）；（适用时）带电部分和用金属箔包裹的整个绝缘手柄之间（2835V）', status: 'w8', info: {name: 'q8', content: '有击穿或放电现象'}},
                    ],
                },
                {
                    class: '机械操作',
                    list: [
                        {title: '手动', content: '可移式部件的机械操作，包括所有的插入式联销，在成套设备安装好后，验证机械操作是否良好，操作循环次数应为 5 次是否良好', status: 'w9', info: {name: 'q9', content: '符合'}},
                    ],
                },
            ],
        ],
        inputtext: [
            {
                q1: '', q2: '', q3: '', q4: '', q5: '', q6: '', q7: '', q8: '', q9: '', q10: '', q11: '', q12: '', q13: '', q14: '', q15: '', q16: '', q17: '', q18: '', q19: '', q20: '', q21: '', q22: '', q23: '', q24: '',
                w1: '', w2: '', w3: '', w4: '', w5: '', w6: '', w7: '', w8: '', w9: '', w10: '', w11: '', w12: '', w13: '', w14: '', w15: '', w16: '', w17: '', w18: '', w19: '', w20: '', w21: '', w22: '', w23: '', w24: '',
                e1: '', e2: '', e3: '', e4: '', e5: '', e6: '', e7: '', e8: '', e9: '', e10: '', e11: '', e12: '', e13: '', e14: '', e15: '', e16: '', e17: '', e18: '', e19: '', e20: '', e21: '', e22: '', e23: '', e24: '',
            },
            {
                q1: '', q2: '', q3: '', q4: '', q5: '', q6: '', q7: '', q8: '', q9: '', q10: '', q11: '', q12: '', q13: '', q14: '', q15: '', q16: '', q17: '', q18: '', q19: '', q20: '', q21: '', q22: '', q23: '', q24: '', q25: '', q26: '', q27: '', q28: '',
                w1: '', w2: '', w3: '', w4: '', w5: '', w6: '', w7: '', w8: '', w9: '', w10: '', w11: '', w12: '', w13: '', w14: '', w15: '', w16: '', w17: '', w18: '', w19: '', w20: '', w21: '', w22: '', w23: '', w24: '', w25: '', w26: '', w27: '', w28: '',
                e1: '', e2: '', e3: '', e4: '', e5: '', e6: '', e7: '', e8: '', e9: '', e10: '', e11: '', e12: '', e13: '', e14: '', e15: '', e16: '', e17: '', e18: '', e19: '', e20: '', e21: '', e22: '', e23: '', e24: '', e25: '', e26: '', e27: '', e28: '',
            },
            {
                q1: '', q2: '', q3: '', q4: [''], q5: [''], q6: [''], q7: ['', '', ''], q8: '', q9: '',
                w1: '', w2: '', w3: '', w4: '', w5: '', w6: '', w7: '', w8: '', w9: '',
            },
            {
                q1: '', q2: '', q3: '', q4: ['', ''], q5: '', q6: '',
                w1: '', w2: '', w3: '', w4: '', w5: '', w6: '',
                e1: '', e2: '', e3: '', e4: '', e5: '', e6: '',
            },
            {
                q1: '', q2: '', q3: '', q4: [''], q5: [''], q6: [''], q7: ['', '', ''], q8: '', q9: '',
                w1: '', w2: '', w3: '', w4: '', w5: '', w6: '', w7: '', w8: '', w9: '',
            },
        ],
    },
    methods: {
        submit() {
            var isAxios = true, canShow = true;
            $('input').each(function (i, e) {
                var that = $(e);
                if (that.hasClass('None')) {
                    var k = 0;
                    that.parent().parent().children().each(function (i, e) {
                        var _that = $(e);
                        if (_that.children().hasClass('active')) {
                            k++;
                        }
                    })
                    if (k == 0) {
                        canShow = false;
                        isAxios = false;
                        Toast('请判断' + that.parent().parent().prev().html(), 1500);
                    }
                }
                if (!that.val().length > 0 && canShow) {
                    Toast(that.parent().prev().html() + '不能为空', 1500);
                    that.click().focus().blur();
                    that.addClass('danger');
                    setTimeout(() => {
                        that.removeClass('danger');
                    }, 2500);
                    isAxios = false;
                    return false;
                }
            });
            if (isAxios) {
                Toast('正在上传...', 1500);
                var url=this.url;
                var params = this.inputtext[this.type - 1];
                params.token = this.token;
                params.type = this.type;
                params.mid = this.mid;
                params.oid = this.oid;
                $.ajax({
                    type: 'POST',
                    url,
                    data: params,
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 0) {
                            if (window.AndroidJs&&window.AndroidJs.showDialog) {
                                AndroidJs.showDialog(data.msg);
                            } else {
                                test('0');
                            }
                        } else {
                            if (window.AndroidJs&&window.AndroidJs.showToast) {
                                AndroidJs.showToast(data.msg);
                            } else {
                                test('1');
                            }
                        }
                    },
                    error: function(err){
                        if (window.AndroidJs&&window.AndroidJs.showToast) {
                            AndroidJs.showToast(err);
                        } else {
                            test('1');
                        }
                    }
                });
                // axios.defaults.headers.post['Content-Type'] = application/json;charse=UTF-8'application/x-www-form-urlencoded';
                // axios({
                //     method: 'post',
                //     headers: {
                //         'Content-type': 'application/json;charse=UTF-8'
                //     },
                //     data: params,
                //     url,
                // }).then(function (response) {
                //     Toast(response.data.msg, 1500);
                //     if (response.data.code == 0) {
                //         if (window.AndroidJs&&window.AndroidJs.showDialog) {
                //             AndroidJs.showDialog(response.data.msg);
                //         } else {
                //             test('0');
                //         }
                //     } else {
                //         if (window.AndroidJs&&window.AndroidJs.showToast) {
                //             AndroidJs.showToast(response.data.msg);
                //         } else {
                //             test('1');
                //         }
                //     }
                // }).catch(function (error) {
                //     Toast('失败'+this, 1500);
                //     console.log(this);
                //     console.log(error);
                //     if (window.AndroidJs&&window.AndroidJs.showToast) {
                //         AndroidJs.showToast(error);
                //     } else {
                //         test('1');
                //     }
                // });
            }
        },
    },
    // model: {
    //     prop: 'checked',
    //     event: 'change'
    // },
    // props: {
    //     // this allows using the `value` prop for a different purpose
    //     value: String,
    //     // use `checked` as the prop which take the place of `value`
    //     checked: {
    //       type: Number,
    //       default: 0
    //     }
    // },
    mounted() {
        // console.log(this.type=parseInt(Math.random()*4)+1);
        this.type = getRequest().type;
        this.mid = getRequest().mid;
    },
});