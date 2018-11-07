<?php
require_once TPL_DIR . '/layout/con_header.php';
?>
<style type="text/css">.dep td {
        line-height: 30px;
        background: #83b266 !important;
        border-left: 0 !important;
        border-right: 0 !important;
        color: #fff !important;
        cursor: pointer;
    }

    .deps {
        display: none;
    }</style>
</head>
<body>
    <div class="MainHtml">
        <div class="HtmlNav">
<!--            <input class="input radius" type="text" placeholder="申请人" />
            <span class="btn btn-sm btn-primary mg-r-6">搜索</span>
            <span class="btn btn-sm btn-primary mg-r-6 reset">重置</span>-->
            <span class="btn btn-sm btn-primary mg-r-6" onclick="Refresh()">刷新</span>
            <!--<span class="btn btn-sm btn-primary pdX20 float-right NewPop" data-url="<?php echo spUrl('applyFill', 'addwork') ?>"data-title="新增奖惩处罚">+ 新增新增奖惩</span>-->
        </div>
        <div class="top20"></div>
        <table class="table borderTr textCenter">
            <thead>
                <tr>
                    <td>名称</td>
                    <td>开始时间</td>
                    <td>结束时间</td>
                    <td>取值类型</td>
                    <td>排序</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody class="hover">
                <?php foreach($results as $k=>$v){?>
                <tr class="men<?php echo $v['id']?> dep1">
                    <td style="text-align:left;" class="data-name" title="上班"><?php echo $v['name']?></td>
                    <td class="data-stime" title="<?php echo $v['stime']?>"><?php echo $v['stime']?></td>
                    <td class="data-etime" title="<?php echo $v['etime']?>"><?php echo $v['etime']?></td>
                    <td class="data-qtype" title="<?php echo $v['qtype']?>">
                        <a class="color-pary">
                            <?php echo $v['qtype']==0?'最小值':'最大值'?>
                        </a></td>
                    <td class="data-sort" title="<?php echo $v['sort']?>"><?php echo $v['sort']?></td>
                    <td style="text-align:left;">
                        <a class="btn btn-info edit-t NewPop" itemid="<?php echo $v['id']?>" data-url="<?php echo spUrl('applyFill', 'bjwork', array('id' => $v['id'])) ?>"data-title="编辑参数"onclick="call(this)">
                            编辑
                        </a></td>
                </tr>
                <?php foreach($v['children'] as $k1=>$v1){?>
                <tr class="men<?php echo $v1['id']?> dep1">
                    <td style="text-align:left;" class="data-name" title="<?php echo $v1['name']?>"> &nbsp;&nbsp;&nbsp;&nbsp;𠃊 <?php echo $v1['name']?></td>
                    <td class="data-stime" title="<?php echo $v1['stime']?>"><?php echo $v1['stime']?></td>
                    <td class="data-etime" title="<?php echo $v1['etime']?>"><?php echo $v1['etime']?></td>
                    <td class="data-qtype" title="<?php echo $v1['qtype']?>">
                        <a class="color-pary">
                            <?php echo $v1['qtype']==0?'最小值':'最大值'?>
                        </a></td>
                    <td class="data-sort" title="<?php echo $v1['sort']?>"><?php echo $v1['sort']?></td>
                    <td style="text-align:left;">
                        <a class="btn btn-info edit-t NewPop" itemid="<?php echo $v1['id']?>" data-url="<?php echo spUrl('applyFill', 'bjwork', array('id' => $v1['id'])) ?>"data-title="编辑参数"onclick="call(this)">
                            编辑
                        </a></td>
                </tr>
                <?php }?>
                <?php }?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script type="text/javascript">
    $('.dep').click(function() {
        var id = $(this).attr('data-id');
        $('.dep' + id).toggle();
    });
    var obj = {};
    function call(e) {
        var that = $(e).parent().parent();
        obj.names = that.children('.data-name').attr('title')
        obj.stime = that.children('.data-stime').attr('title')
        obj.etime = that.children('.data-etime').attr('title')
        obj.sort = that.children('.data-sort').attr('title')
        obj.qtype = that.children('.data-qtype').attr('title')
        obj.id = that.children('.data-id').attr('title')
    }
    function chan() {
        parent.window.Call.bjcs(obj)
    }
</script>
