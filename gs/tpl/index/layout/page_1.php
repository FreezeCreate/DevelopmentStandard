<?php if ($pager) { ?>
    <?php
    if (!isset($page_con)) {
        $page_con = array();
    }
    ?>
    <div class="row">
    <div class="col-sm-12">
        <div class="pull-left">
            <div id="datatable1_info" class="dataTables_info">共有<?php echo $pager['total_count']; ?>条，共有<?php echo $pager['total_page']; ?>页（每页<?php echo $pager['page_size']; ?>条数据）</div>
        </div>
        <div class="pull-right">
            <div id="datatable1_paginate" class="dataTables_paginate paging_bs_full">
                <ul class="pagination">
    <!--在当前页不是第一页的时候，显示前页和上一页-->
    <?php if ($pager['current_page'] != $pager['first_page']) { ?>
    <li class="">
        <a id="datatable1_first" class="paginate_button first" tabindex="0" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['first_page']), $page_con)) ?>">首页</a>
    </li>
    <li class="">
        <a id="datatable1_first" class="paginate_button first" tabindex="0" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['prev_page']), $page_con)) ?>">上一页</a>
    </li>
    <?php }else{?>
    <li class="disabled">
        <a id="datatable1_first" class="paginate_button first" tabindex="0">首页</a>
    </li>
    <li class="disabled">
        <a id="datatable1_first" class="paginate_button first" tabindex="0">上一页</a>
    </li>
    <?php }?>
    <!--开始循环页码，同时如果循环到当前页则不显示链接-->
    <?php foreach ($pager['all_pages'] as $thepage) { ?>
        <?php if ($thepage != $pager['current_page']) { ?>
    <li><a tabindex="0" href="<?php echo spUrl($c, $a, array_merge(array('page' => $thepage), $page_con)) ?>"><?php echo $thepage; ?></a></li>
        <?php } else { ?>
            <li class="active"><a tabindex="0"><?php echo $thepage; ?></a></li>
        <?php } ?>
    <?php } ?>
    <!--在当前页不是最后一页的时候，显示下一页和后页-->
    <?php if ($pager['current_page'] != $pager['last_page']) { ?>
        <li><a id="datatable1_next" class="paginate_button next" tabindex="0" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['next_page']), $page_con)) ?>">下一页</a></li>
        <li><a id="datatable1_last" class="paginate_button last" tabindex="0" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['last_page']), $page_con)) ?>">末页</a></li>
    <?php }else{ ?>
        <li class="disabled"><a id="datatable1_next" class="paginate_button next" tabindex="0">下一页</a></li>
        <li class="disabled"><a id="datatable1_last" class="paginate_button last" tabindex="0">末页</a></li>
    <?php }?>
        </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php } ?>