<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>考勤记录</title>
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
                            <input type="text" class="FrameDatGroup" name="start" id="begin" value="<?php echo $page_con['start']?>"/>
                            ~
                            <input type="text" class="FrameDatGroup" name="end" id="end" value="<?php echo $page_con['end']?>"/>
                            <input type="text" class="TablesSerchInput" name="name" value="<?php echo $page_con['name'] ?>" placeholder="姓名/部门"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <input type='file' id='fileToUpload' name='fileToUpload' style='display:none' name='waylist' onchange='hqWayList()'/>
                    <button type="button" class="TablesAddBtn addbtn hqWay">导入</button>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $v['departmentname'] ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['dkdt'] ?></td>
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

        $('.hqWay').click(function(){
            $('#fileToUpload').click();
        });

        function hqWayList(){
            $.ajaxFileUpload({
                url: '<?php echo spUrl($c, "hqWayList"); ?>',
                secureuri: false,
                fileElementId: 'fileToUpload',
                dataType: 'json',
                data: {name: 'fileToUpload', id: 'fileToUpload'},
                success: function (data) {
                    if(data.status == 1){
                        Alert(data.msg);
                    }
                },
                error: function (data, status, e) {
                    $("#uploading").hide();
                    Alert(e);
                }
            });
            return false;
        }
    </script>
</section>
</body>
</html>


