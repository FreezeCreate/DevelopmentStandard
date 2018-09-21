<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>月打卡记录明细</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <select class="TablesSerchInput" name="month">
                                <?php for($i=0;$i<12;$i++){?>
                                <option <?php echo date('Y-m',strtotime('-'.$i.'month'))==$page_con['month']?'selected=""':'';?> value="<?php echo date('Y-m',strtotime('-'.$i.'month'))?>"><?php echo date('Ym',strtotime('-'.$i.'month'))?></option>
                                <?php }?>
                            </select>
                            <select name='uid' class="TablesSerchInput">
                                <?php foreach($admins as $k => $v){ ?>
                                <optgroup label='<?php echo $v['name'];?>'>
                                <?php foreach($v['list'] as $k2 => $v2){?>
                                <option <?php if($v2['id'] == $page_con['uid']){?>selected=''<?php } ?> value='<?php echo $v2['id'];?>'><?php echo $v2['name'];?></option>
                                <?php } ?>
                                </optgroup>
                                <?php } ?>
                            </select>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
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
                        <table>
                            <thead>
                                <tr>
                                    <td>部门</td>
                                    <td>姓名</td>
                                    <td>打卡时间</td>
                                    <td>添加时间</td>
                                    <td>IP</td>
                                    <td>打卡地址</td>
                                    <td>图片</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $user['departmentname'] ?></td>
                                        <td><?php echo $user['name'] ?></td>
                                        <td><?php echo $v['dkdt'] ?></td>
                                        <td><?php echo $v['optdt'] ?></td>
                                        <td><?php echo $v['ip'] ?></td>
                                        <td><a style="color:#007aff;" onclick='getAddress(<?php echo $v['lng'].','.$v['lat'].',"'.$v['address'].'"'?>)' title="点击查看详情"><?php echo $v['address'] ?></a></td>
                                        <td>
                                            <?php foreach($v['images'] as $v1){?>
                                            <img onclick="getMap('<?php echo $v1?>','查看大图')" class="tabimg" style="height: 40px;" src="<?php echo $v1?>"/>
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
</html>



