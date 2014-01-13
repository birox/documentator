<!DOCTYPE html>
<html>
    <head>
        <title><?php title(); ?></title>
        <link rel="icon" type="image/png" href="<?php echo(defined('DOC_LOGO') && DOC_LOGO != '')? DOC_LOGO : get_path() .'/assets/img/logo.png'; ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php hook('head'); css().js(); ?>
    </head>
    <body>
    	<?php if(defined('DOC_URL')): ?>
    	<nav class="navbar navbar-default" role="navigation">
          <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="<?php path(); ?>" data-toggle="tooltip-right" title="<?php echo DOC_NAME; ?>"><?php logo(); ?></a>
        
            <div class="navbar-form navbar-left search-docs">
                <div class="input-group">
                    <input id="sitewide-search" type="text" class="form-control" placeholder="<?php echo _t('Search for documentation'); ?>">
                        <span class="input-group-btn">
                        <a id="sitewide-search-submit" class="btn btn-default" href="javascript:void(0)"><i class="glyphicon glyphicon-search"></i></a>
                        </span>
                </div><!-- /input-group -->
            </div>
			
            <?php include (dirname(__FILE__) . DIRECTORY_SEPARATOR .'menu.php'); ?>
            
        </nav>
		<?php endif; ?>