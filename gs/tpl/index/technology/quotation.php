<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js" type="text/javascript" charset="utf-8"></script>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                    <ul class="TablesHeadNav">
                        <li class="TablesHeadItem <?php echo empty($page_con['status'])?'active':'';?>"><a href="<?php echo spUrl($c,$a)?>">全部</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==2?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>2))?>">待编辑</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==1?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>1))?>">待审核</a></li>
                        <li class="TablesHeadItem <?php echo $page_con['status']==3?'active':'';?>"><a href="<?php echo spUrl($c,$a,array('status'=>3))?>">审核通过</a></li>
                    </ul>
                    <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name'] ?>" placeholder="关键字"/>
                    <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                    <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                    <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                    <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c, 'editQuotation') ?>" data-title="新增报价单"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if ($results) { ?>
                <div class="top20">
                    <table class="Table">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>订单名称</th>
                                <th>联系人</th>
                                <th>电话</th>
                                <th>报价员</th>
                                <th>报价</th>
                                <th>报价状态</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="textCenter TabBg">
                            <?php foreach ($results as $k => $v) { ?>
                                <tr class="Results<?php echo $v['id'] ?>">
                                    <td><a class="menu-item NewPop" data-url="<?php echo spUrl('sell', 'ordersInfo', array('id' => $v['oid'])) ?>" data-title="订单详情"><?php echo $v['onumber']; ?></a></td>
                                    <td><?php echo $v['oname']; ?></td>
                                    <td><?php echo $v['contact'] ?></td>
                                    <td><?php echo $v['tel'] ?></td>
                                    <td><?php echo $v['uname'] ?></td>
                                    <td><?php echo $v['money'] ?></td>
                                    <td><?php echo $GLOBALS['QUO_STATUS'][$v['status']] ?></td>
                                    <td>
                                        <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'quotationInfo', array('id' => $v['id'])) ?>" data-title="报价单详情"><a >详情</a></li>
                                                <li class="menu-item NewPop" data-url="<?php echo spUrl($c, 'editQuotation', array('id' => $v['id'])) ?>" data-title="编辑报价单"><a >编辑</a></li>
                                                <li class="menu-item InPop daoru" data-BoxId="daoru" data-id="<?php echo $v['id']?>"><a >导入报价单</a></li>
                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="noMsg">
                    <div class="noMsgCont">
                        <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                        <span>抱歉！暂时没有数据</span>
                    </div>
                </div>
            <?php } ?>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>

        </div>
    </div>
    <div class="Tan" id="daoru">
        <div class="TanBox">
            <div class="TanBoxTit">导入报价单 <span class="close OtPop" data-BoxId="daoru"></span></div>
            <div class="TanBoxCont">
                <form action="" method="" id="daoru_form" onsubmit="return false">
                    <div class="FrameTable">
                        <table class="FrameTableCont">
                            <tr>
                                <td>文件</td>
                                <td><input type="file" id="fileToUpload" name="fileToUpload"/></td>
                                <td><a style="color:#007aff;" href="/uploads/template/quotation.xlsx">查看模板文件</a></td>
                            </tr>
                        </table>
                        <div class="TanBtn">
                            <input id="id" type="hidden" name="id" value=""/>
                            <span class="Btn Big Btn-green" onclick="do_daoru()">确定</span>
                            <span class="Btn Big Btn-blue OtPop"data-BoxId="daoru">取消</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $('.daoru').click(function(){
        $id = $(this).attr('data-id');
        $('#id').val($id);
    });
    function do_daoru() {
        loading();
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadExcel"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            error: function(data, status, e) {
                loading('none');
                Alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "<?php echo spUrl($c, "importExcel"); ?>",
                        data: {filename: data.src,id:$('#id').val()},
                        dataType: "json",
                        async: false,
                        error: function(request) {
                            loading('none');
                            Alert("数据提交失败！");
                        },
                        success: function(data) {
                            loading('none');
                            if (data.status == 1) {
                                Alert(data.msg,function(){
                                    window.location.reload();
                                });
                            }else{
                                Alert(data.msg);
                            }
                        }
                    });
                } else {
                    loading('none');
                    Alert(data.msg);
                }
            },
        });
        return false;
    }
</script>


