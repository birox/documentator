	<?php if(defined('DOC_URL')): ?>
    <div class="footer clearfix">
    	<div class="col-md-2">&copy; <?php echo date('Y'); ?> <?php echo DOC_NAME; ?></div>
        <div class="col-md-6"><?php hook('footer_left'); ?></div>
        <div class="col-md-4"><?php hook('footer_right'); ?></div>
    </div>
    <?php endif; ?>
    <input type="hidden" id="doc_path" value="<?php path(); ?>" />
    </body>
</html>