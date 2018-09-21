<?php 
if($_SESSION['flow_set']){
    $flow_set = $_SESSION['flow_set'];
}else{
    $flow_set = spClass('m_flow_set')->findAll();
    $_SESSION['flow_set'] = $flow_set;
}
?>
<script>
    function fill_apply(mid, id) {
        var tit;
        var src;
        var t;
        t = id>0?'编辑':'新增';
        switch (mid)
        {
            <?php foreach($flow_set as $k=>$v){?>
            case <?php echo $v['id']?>:
                tit = t+'<?php echo $v['name']?>';
                src = '/applyFill/<?php echo $v['model']?>?id=' + id;
                break;
            <?php }?>
            case 90:
                tit = '新增客户';
                src = '/applyFill/Potential?id=' + id;
                break;
            case 998:
                tit = '案例管理';
                src = '/applyFill/CaseBase?id=' + id;
                break;   
            default:
                return false;
        }
        parent.window.newHtml(src,tit);
    }
    function check_apply(mid, id) {
        var tit;
        var src;
        switch (mid)
        {
            <?php foreach($flow_set as $k=>$v){?>
            case <?php echo $v['id']?>:
                tit = '<?php echo $v['name']?>';
                src = '/apply/<?php echo $v['model']?>?mid='+mid+'&id=' + id;
                break;
            <?php }?>
            default:
                return false;
        }
        parent.window.newHtml(src,tit);
    }
</script>

