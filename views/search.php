<?php
	$string = hook('filter_search', $_REQUEST['q']);
?>
<div class="clearfix">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <h1 class="search-title"><i class="glyphicon glyphicon-search"></i> <?php echo _t('Search'); ?> <blockquote style="display: inline-block;"><?php echo $string; ?></blockquote></h1>
        <hr />
        <ul class="found-results" data-search="<?php echo $string; ?>">
        	<li class="searching"><img src="<?php path(); ?>/assets/img/loading.gif" width="38" height="30"/><br /> <?php echo _t('Searching for'); ?> <i><?php echo $string; ?></i>...</li>
        </ul>
	</div>
    <div class="col-md-1"></div>
</div>