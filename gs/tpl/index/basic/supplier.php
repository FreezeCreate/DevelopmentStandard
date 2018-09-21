<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                <ul class="TablesHeadNav">
                    <li class="TablesHeadItem <?php echo empty($page_con['status'])?'active':''?>">
                        <a href="<?php echo spUrl($c,$a)?>">全部</a>
                    </li>
                    <li class="TablesHeadItem <?php echo $page_con['status']==2?'active':''?>">
                        <a href="<?php echo spUrl($c,$a,array('status'=>2))?>">合格供应商</a>
                    </li>
                    <li class="TablesHeadItem <?php echo $page_con['status']==1?'active':''?>">
                        <a href="<?php echo spUrl($c,$a,array('status'=>1))?>">不合格供应商</a>
                    </li>
                </ul>
                <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name']?>" placeholder="关键字"/>
                <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c,'addSupplier')?>" data-title="新增供应商"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if($results){?>
            <div class="top20">
                <table class="Table">
                    <thead>
                        <tr>
                            <th width="50">序号</th>
                            <th>供应商名称</th>
                            <th>地区</th>
                            <th>主要供货产品</th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody class="textCenter TabBg">
                        <?php foreach($results as $k=>$v){?>
                        <tr class="Results<?php echo $v['id']?>">
                            <td><?php echo $k+1;?></td>
                            <td><?php echo $v['company']?></td>
                            <td><?php echo $v['address']?></td>
                            <td><?php echo $v['goodstype']?></td>
                            <td><?php echo $v['name']?></td>
                            <td><?php echo $v['phone']?></td>
                            <td><?php echo $v['explain']?></td>
                            <td>
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop" data-url="<?php echo spUrl($c,'supplierInfo',array('id'=>$v['id']))?>" data-title="供应商详情"><a >详情</a></li>
                                        <li class="menu-item read"><a  onclick="del(<?php echo $v['id']?>)">删除</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <?php }else{?>
            <div class="noMsg">
                <div class="noMsgCont">
                    <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                    <span>抱歉！暂时没有数据</span>
                </div>
            </div>
            <?php }?>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
            
        </div>
    </div>
</body>
</html>


<script>
    
    function del(id) {
        Confirm('确定删除？', function(e) {
            if (e) {
                $.get('<?php echo spUrl('basic', 'delSupplier') ?>', {id: id}, function(re) {
                    $('.Results'+id).remove();
                }, 'json');
            }
        })

    }
</script>
