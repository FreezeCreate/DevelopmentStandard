<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
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
                    <div class="top20">
                        <table class="Table TabInp ">
                            <thead class="TabBgBlue">
                                <tr class="">
                                    <th class="textRight" style="border: 0;">领用人</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input  type="text" readonly="true" value="<?php echo $admin['name']?>" /></th>
                                    <th class=" textRight" style="border: 0;">领用部门</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input  type="text" readonly="true" value="<?php echo $admin['dname']?>" /></th>
                                    <th class=" textRight" style="border: 0;">领用时间</th>
                                    <th width="16.6%"class="pdX10 textLeft" style="border: 0;"><input class="dt" name="dt" readonly="true" type="text" value="<?php echo $result['dt']?$result['dt']:date('Y年m月d日')?>" /></th>
                                </tr>
                                <tr class="">
                                    <th class="textCenter">订单</th>
                                    <th class="pdX10 textLeft" colspan="5">
                                        <select name="oid" class="FrameGroupInput">
                                            <option value="">请选择</option>
                                            <?php foreach($orders as $k=>$v){?>
                                            <option <?php echo $result['oid']==$v['id']?'selected=""':''?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                            <?php }?>
                                        </select>
                                    </th>
                                </tr>
                                <tr class="">
                                    <th class="textCenter">编号</th>
                                    <th class="pdX10" colspan="5"><input class="textLeft" name="number" type="text" value="<?php echo $result['number']?>" /></th>
                                </tr>
                            </thead>
                            <tbody class="add textCenter">
                                <?php for($i=0;$i<=(count($result['children'])/5);$i++){?>
                                <tr>
                                    <td class="textCenter TabBgBlue">品名</td>
                                    <td><input type="text" name="name[]" value="<?php echo $result['children'][$i*5]['name']?>" /></td>
                                    <td><input type="text" name="name[]" value="<?php echo $result['children'][$i*5+1]['name']?>" /></td>
                                    <td><input type="text" name="name[]" value="<?php echo $result['children'][$i*5+2]['name']?>" /></td>
                                    <td><input type="text" name="name[]" value="<?php echo $result['children'][$i*5+3]['name']?>" /></td>
                                    <td><input type="text" name="name[]" value="<?php echo $result['children'][$i*5+4]['name']?>" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">数量</td>
                                    <td><input type="text" name="num[]" value="<?php echo $result['children'][$i*5]['num']?>" /></td>
                                    <td><input type="text" name="num[]" value="<?php echo $result['children'][$i*5+1]['num']?>" /></td>
                                    <td><input type="text" name="num[]" value="<?php echo $result['children'][$i*5+2]['num']?>" /></td>
                                    <td><input type="text" name="num[]" value="<?php echo $result['children'][$i*5+3]['num']?>" /></td>
                                    <td><input type="text" name="num[]" value="<?php echo $result['children'][$i*5+4]['num']?>" /></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td class="textCenter TabBgBlue">品名</td>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="name[]" value="" /></td>
                                    <td><input type="text" name="name[]" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">数量</td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                    <td><input type="text" name="num[]" value="" /></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td><td class="textCenter"><span class="TabAdd"></span></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">领用事由</td>
                                    <td colspan="5" class="pdX10">
                                        <textarea name="explain"><?php echo $result['explain']?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textCenter TabBgBlue">注意事项</td>
                                    <td colspan="5" class="pdX10">
                                        <p>1、填写此表的要求：领用人必须认真填写此表，物资品名必须写全称、数量必须写大写、事由必须写清楚，特别是领用礼品需详细说明原因、送与何单位、何人及联系电话等事项，否则拒绝审批。</p>
                                        <p>2、本表只适用于公司各部门内部所需物资的领用申请，否则视为无效。</p>

                                    </td>
                                </tr>
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
        dateCell: ".dt", //isinitVal:true,
        format: "YYYY年MM月DD日",
        isTime: false, //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    })
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        };
        $('.TabAdd').click(function() {
            $('.add').append(
                    '<tr><td class="textCenter TabBgBlue">品名</td><td><input type="text" name="name[]" value="" /></td><td><input type="text" name="name[]" value="" /></td>'
                      +'<td><input type="text" name="name[]" value="" /></td><td><input type="text" name="name[]" value="" /></td><td><input type="text" name="name[]" value="" /></td></tr>'
                      +'<tr><td class="textCenter TabBgBlue">数量</td><td><input type="text" name="num[]" value="" /></td><td><input type="text" name="num[]" value="" /></td>'
                      +'<td><input type="text" name="num[]" value="" /></td><td><input type="text" name="num[]" value="" /></td><td><input type="text" name="num[]" value="" /></td></tr>'
                    )
        });
    });

    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'saveDraw'); ?>",
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


