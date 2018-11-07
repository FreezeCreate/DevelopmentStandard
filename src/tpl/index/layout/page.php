<?php if ($pager) { ?>
    <?php
    if (!isset($page_con)) {
        $page_con = array();
    }
    ?>
<div class="top20 textCenter">
    <ul class="grpBtn">
        <?php if ($pager['current_page'] != $pager['first_page']) { ?>
        <li class="pageItem"><a class="pageA" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['first_page']), $page_con)) ?>"><<</a></li>
        <li class="pageItem"><a class="pageA" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['prev_page']), $page_con)) ?>"><</a></li>
        <?php }else{?>
        <li class="pageItem off "><a class="pageA"><<</a></li>
        <li class="pageItem off "><a class="pageA"><</a></li>
        <?php }?>
        <li class="pageItem ">
        	<div class="pageBox list-menu">
	            第<?php echo $pager['current_page']; ?>页/共<?php echo $pager['total_page']; ?>页
	            <ul class="menu">
	                <?php for ($thepage=$pager['first_page'];$thepage<=$pager['last_page'];$thepage++) { ?>
	                <?php if ($thepage != $pager['current_page']) { ?>
	                <li class="menu-item"><a href="<?php echo spUrl($c, $a, array_merge(array('page' => $thepage), $page_con)) ?>">第<?php echo $thepage; ?>页</a></li>
	                <?php }else{?>
	                <li class="menu-item"><a>第<?php echo $thepage; ?>页</a></li>
	                <?php }?>
	                <?php }?>
	            </ul>
            </div>
        </li>
        <?php if ($pager['current_page'] != $pager['last_page']) { ?>
        <li class="pageItem"><a class="pageA" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['next_page']), $page_con)) ?>">></a></li>
        <li class="pageItem"><a class="pageA" href="<?php echo spUrl($c, $a, array_merge(array('page' => $pager['last_page']), $page_con)) ?>">>></a></li>
        <?php }else{ ?>
        <li class="pageItem off "><a class="pageA">></a></li>
        <li class="pageItem off "><a class="pageA">>></a></li>
        <?php }?>
    </ul>
</div>

<?php }?>
