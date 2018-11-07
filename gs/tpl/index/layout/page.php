<?php if ($pager) { ?>
    <?php
    if (!isset($page_con)) {
        $page_con = array();
    }
    ?>
    <div class="Pages textRight top20">
        <ul>
            <!--在当前页不是第一页的时候，显示前页和上一页-->
            <?php if ($pager['current_page'] != $pager['first_page']) { ?>
                <li class="PagesItem prev"><a href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['prev_page']), $page_con)) ?>">上一页</a></li>
            <?php } else { ?>
                <li class="PagesItem prev"><a>上一页</a></li>
            <?php } ?>
            <!--开始循环页码，同时如果循环到当前页则不显示链接-->
            <?php foreach ($pager['all_pages'] as $thepage) { ?>
                <?php if ($thepage != $pager['current_page']) { ?>
                    <li class="PagesItem"><a href="<?php echo spUrl($c, $a, array_merge(array('page' => $thepage), $page_con)) ?>"><?php echo $thepage; ?></a></li>
                <?php } else { ?>
                    <li class="PagesItem active"><a><?php echo $thepage; ?></a></li>
                <?php } ?>
            <?php } ?>
            <!--在当前页不是最后一页的时候，显示下一页和后页-->
            <?php if ($pager['current_page'] != $pager['last_page']) { ?>
                <li class="PagesItem next"><a href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['next_page']), $page_con)) ?>">下一页</a></li>
            <?php } else { ?>
                <li class="PagesItem next"><a>下一页</a></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
