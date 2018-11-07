<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>工作日报</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>

        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
						<ul class="TablesHeadNav">
							<li class="TablesHeadItem <?php echo $page_con['type']==1?'active':''?>">
								<a href="<?php echo spUrl($c,$a,array('type'=>1))?>" class="">我的日报</a>
							</li>
							<li class="TablesHeadItem <?php echo $page_con['type']==2?'active':''?>">
								<a href="<?php echo spUrl($c,$a,array('type'=>2))?>" class="">下属日报</a>
							</li>
						</ul>
                    <div class="TablesSerch">
                <form action="<?php echo spUrl($c,$a,array('type'=>$page_con['type']))?>" method="get">
                <label class="form-group">
                    <input type="text" class=" FrameDatGroup notenter " name="start" id="begin" placeholder="开始时间" value="<?php echo $page_con['start'] ?>"/>
                    ~
                    <input type="text" class="FrameDatGroup notenter" name="end" id="end" placeholder="结束时间" value="<?php echo $page_con['end'] ?>"/>
                </label>
                 <label class="form-group">
                    我的下属：<select class="form-control TablesSerchInput" name="uid">
                        <option value='0'>全部</option>
                        <?php foreach ($admins as $k => $v) { ?>
                            <option value="<?php echo $v['id']; ?>" <?php if ($page_con['uid'] == $v['id']) {
                            echo 'selected';
                        } ?> ><?php echo $v['name']; ?></option>
                        <?php } ?>
                    </select>
                </label>
                <label class="form-group">
                   <input type="text" class="input-text TablesSerchInput" name="name" value="<?php echo $page_con['name']?>" placeholder="输入关键字"/>
                </label>
                    <button class="Btn Btn-primary">查询</button>
                    <span class="Btn Btn-info TablesSerchReset">重置</span>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                </form>
            </div>
               <?php if($stype == 1){ ?>
                <div class="TablesAddBtn" onclick="fill_apply(8)">＋ 添 加</div>

                <?php }else{ ?>
               <div class="TablesAddBtn" onclick="fill_apply(41)"> ＋ 申请补填</div>
                <?php } ?>
			</div>
				<?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
           <div class="TablesBody top20">
            <table class="table table-info table-hover">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>人员</th>
                        <th>日报类型</th>
                        <th>日期</th>
                        <th>电话量</th>
                        <th>意向客户</th>
                        <th>心得</th>
                        <th>填写时间</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $v) { ?>
                        <tr class="Results<?php echo $v['id'] ?> <?php echo $v['isread']==1?'isread':''?>">
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['uname'] ?></td>
                            <td><?php echo $v['type'] ?></td>
                            <td><?php echo $v['date'] ?></td>
                            <td><?php echo !isset($v['phone'])?'':'<span style="color:green;">'.$v['phone'].'个</span>/'.$v['yjphone'].'个' ?></td>
                            <td><?php echo !isset($v['yixiang'])?'':'<span style="color:green;">'.$v['yixiang'].'个</span>/'.$v['yjyixiang'].'个' ?></td>
                            <td><?php echo empty($v['zongjie'])?$v['content']:$v['zongjie']; ?></td>
                            <td><?php echo $v['adddt'] ?></td>
                            <td class="colorGre">
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                      <ul class="menu">
                                         <li class="menu-item">
                                     <a onclick="check_apply(8, <?php echo $v['id'] ?>)">详情</a></li>
                                     </ul>
                                     </div>
                             
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php require_once TPL_DIR . '/layout/page.php'; ?>
        </div>
	  <?php } ?>
    </div>
</div>	
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
    <script type="text/javascript">
        jeDate({
            dateCell: "#begin", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        })
        jeDate({
            dateCell: "#end", //isinitVal:true,
            format: "YYYY-MM-DD",
            isTime: false, //isClear:false,
            //minDate: "2015-10-19 00:00:00",
            //maxDate: "2016-11-8 00:00:00"
        })
        function del_form() {
           // loading();
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "delCarms"); ?>",
                data: $('#Delete_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    //loading('none');
                    alert('提交失败');
                },
                success: function(data) {
                    if (data.status == 1) {
                        $('.Results' + data.data).remove();
                        $('#Delete_upBox .close').click();
                        table_sort();
                       // loading('none');
                    } else {
                        //loading('none');
                        alert(data.msg);
                    }

                }
            });
        }
    </script>

</body>
</html>





