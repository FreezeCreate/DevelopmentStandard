<h2 class="ico-guanli">管理</h2>
<?php if($_SESSION['emp']['effective'] == 1){?>
<a href="<?php echo spUrl("employees", "index"); ?>" <?php echo ($c=='employees' && $a=='index')?'class="cur"':''; ?>>个人中心</a>
<a href="<?php echo spUrl("employees", "set_market"); ?>" <?php echo ($c=='employees' && ($a=='set_market' || $a=='edit_market_new'))?'class="cur"':''; ?>>市场管理</a>
<a href="<?php echo spUrl("employees", "set_addr"); ?>" <?php echo ($c=='employees' && ($a=='set_addr' || $a=='add_addr' || $a=='edit_addr'))?'class="cur"':''; ?>>店铺管理</a>
<a href="<?php echo spUrl("employees", "archives"); ?>" <?php echo ($c=='employees' && ($a=='archives' || $a=='edit_archives'))?'class="cur"':''; ?>>店铺档案</a>

<?php if($_SESSION['emp']['code'] == 'joku028000' || $_SESSION['emp']['code'] == '28123456' ) {?><a href="<?php echo spUrl("employees", "set_card"); ?>" <?php echo ($c=='employees' && ($a=='set_card' || $a=='add_card' || $a=='edit_card'))?'class="cur"':''; ?>>名片管理</a><?php } ?>
<a href="<?php echo spUrl("employees", "set_brand"); ?>" <?php echo ($c=='employees' && ($a=='set_brand' || $a=='add_brand' || $a=='edit_brand'))?'class="cur"':''; ?>>品牌管理</a>
<a href="<?php echo spUrl("employees", "news"); ?>" <?php echo ($c=='employees' && ($a=='news' || $a=='add_news' || $a=='edit_news'))?'class="cur"':''; ?>>消息管理</a>
<a href="<?php echo spUrl("employees", "set_jianzhis"); ?>" <?php echo ($c=='employees' && ($a=='jnews' || $a=='jadd_news' || $a=='edit_news2'  || $a=='set_jianzhis'  || $a=='edit_jianzhi'  || $a=='add_jian'))?'class="cur"':''; ?>>兼职人员管理</a>
<?PHP }ELSE{?>
<a href="<?php echo spUrl("employees", "index2"); ?>" <?php echo ($c=='employees' && $a=='index2')?'class="cur"':''; ?>>个人中心</a>
<a href="<?php echo spUrl("employees", "news"); ?>" <?php echo ($c=='employees' && ($a=='news' || $a=='add_news' || $a=='edit_news'))?'class="cur"':''; ?>>消息管理</a>
<a href="<?php echo spUrl("employees", "set_brand"); ?>" <?php echo ($c=='employees' && ($a=='set_brand' || $a=='add_brand' || $a=='edit_brand'))?'class="cur"':''; ?>>品牌管理</a>
<a href="<?php echo spUrl("employees", "set_market"); ?>" <?php echo ($c=='employees' && ($a=='set_market' || $a=='edit_market_new'))?'class="cur"':''; ?>>市场信息管理</a>
<?PHP } ?>
<a href="<?php echo spUrl("employees", "password"); ?>" <?php echo ($c=='employees'&&$a=='password')?'class="cur"':''; ?>>修改密码</a>


