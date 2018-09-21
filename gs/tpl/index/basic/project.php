<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<body style="min-width: 930px;">
    <div class="ContentBox">
        <div class="Tables">
            <div class="TablesHead">
                <form action="" method="get">
                <input type="text"class="FrameGroupInput radius" name="name" id="" value="<?php echo $page_con['name']?>" placeholder="关键字"/>
                <button class="Btn Btn-blue"><i class="icon-serch"></i> 查询</button>
                <span class="Btn Btn-green TablesSerchReset"><i class="icon-reset"></i> 重置</span>
                <a href=""class="Btn Btn-green"><i class="icon-refresh"></i> 刷新</a>
                <span class="Btn Btn-blue float-right NewPop" data-url="<?php echo spUrl($c,'editproject')?>" data-title="新增产品"><i class="icon-add"></i> 新增</span>
                </form>
            </div>
            <?php if($results){?>
            <div class="top20">
                <table class="Table">
                    <thead>
                        <tr>
                            <th width="50">序号</th>
                            <th>名称</th>
                            <th>规格</th>
                            <th>单位</th>
                            <th>单价</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody class="textCenter TabBg">
                        <?php foreach($results as $k=>$v){?>
                        <tr class="Results<?php echo $v['id']?>">
                            <td><?php echo $k+1;?></td>
                            <td><?php echo $v['name']?></td>
                            <td><?php echo $v['format']?></td>
                            <td><?php echo $v['unit']?></td>
                            <td><?php echo $v['total']?></td>
                            <td>
                                <div class="list-menu" style="display: inline-block;">
                                    操作  ＋
                                    <ul class="menu">
                                        <li class="menu-item NewPop" data-url="<?php echo spUrl($c,'projectInfo',array('id'=>$v['id']))?>" data-title="<?php echo $v['name']?>详情"><a >详情</a></li>
                                        <li class="menu-item NewPop" data-url="<?php echo spUrl($c,'editproject',array('id'=>$v['id']))?>" data-title="编辑<?php echo $v['name']?>"><a >编辑</a></li>
                                        <li class="menu-item read"><a onclick="del(<?php echo $v['id']?>)">删除</a></li>
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
    function del(id){
        Confirm('确定删除？',function(e){
            if(e){
                $.get('<?php echo spUrl($c,'delProject')?>',{id:id},function(re){
                    if(re.status==1){
                        $('.Results'+id).remove();
                    }else{
                        Alert(re.msg);
                    }
                },'json');
            }
        });
    }
</script>


