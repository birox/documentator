<?php 
$uri = str_replace(DOC_URL, '', curPageURL());
if(get_content()): ?>
    <div class="clearfix read">
        <div class="col-sm-3 col-md-2 read-menu">
        	<?php menu(); hook('read_menu'); ?>
        </div>
        <div class="col-sm-9 col-md-10 read-content">
        	<div class="read-loader"><img src="<?php path(); ?>/assets/img/loading.gif" width="38" height="30"/></div>
            <div class="md-content">
            	<?php hook('read_breadcrum'); ?>
            	<h1><?php title(); ?></h1>
                <hr />
				<?php content(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="glyphicon glyphicon-ban-circle error404"></i> <?php echo _t('404 error Page not found'); ?></h1>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(login_check() == true || DOC_DOWNLOAD == 'yes'): ?>
<?php echo(doc_file() == true)? '<input type="hidden" id="md-file" value="'. DOC_FOLDER . str_replace('%20', ' ', $uri) . '.md" />' : ''; ?>
<?php echo(doc_folder() == true)? '<input type="hidden" id="md-folder" value="'. DOC_FOLDER . str_replace('%20', ' ', $uri) . '" />' : ''; ?>
<!--Download file (html) modal-->
<div class="modal fade" id="fileDownload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-download"></i> <?php echo _t('Download html file'); ?></h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-info editor-saving4"></div>
        <form role="form">
          <div class="form-group">
            <label for="save-folder"><?php echo _t('Select template'); ?></label>
            <select class="form-control" name="template" id="template">
                <option value="github"><?php echo _t('Default github style'); ?></option>
                <?php
                    $count = count(glob('includes' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '*'));
    
                    if($count > 0) {
                        if ($handle = opendir('includes' . DIRECTORY_SEPARATOR . 'templates')) {	
                            $blacklist = array('.', '..');
                            while (false !== ($file = readdir($handle))) {
                                if (!in_array($file, $blacklist)) {
									if(preg_match("/_folder/i", $file))
										continue;
										
									$name = basename(str_replace('.html', '', $file));
									
									if($name == 'github')
										continue;
									
                                	printf('<option value="%1$s">%1$s</option>', $name);
                                }
                            }
                        }
                    }
                ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
        <button id="download-html-file" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Download'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Download folder (html) modal-->
<div class="modal fade" id="folderDownload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-download"></i> <?php echo _t('Download current folder'); ?></h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-info editor-saving4"></div>
        <form role="form">
          <div class="form-group">
            <label for="save-folder"><?php echo _t('Select template'); ?></label>
            <select class="form-control" name="template" id="folder-template">
                <option value="github"><?php echo _t('Default github style'); ?></option>
                <?php
                    $count = count(glob('includes' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '*'));
    
                    if($count > 0) {
                        if ($handle = opendir('includes' . DIRECTORY_SEPARATOR . 'templates')) {	
                            $blacklist = array('.', '..');
                            while (false !== ($file = readdir($handle))) {
                                if (!in_array($file, $blacklist)) {
									if(!preg_match("/_folder/i", $file))
										continue;
									
									$name = basename(str_replace('_folder.html', '', $file));
									
									if($name == 'github')
										continue;
									
                                	printf('<option value="%1$s">%1$s</option>', $name);
                                }
                            }
                        }
                    }
                ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
        <button id="download-html-folder" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Download'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<?php if(login_check() == true): ?>
    <!--Change file name modal-->
    <div class="modal fade" id="fileName">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="glyphicon glyphicon-floppy-disk"></i> <?php echo _t('Change file name'); ?></h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info editor-saving3"></div>
            <form role="form">
              <div class="form-group">
                <input type="text" class="form-control" name="new-file-name" id="new-file-name" value="<?php echo basename(str_replace('%20', ' ', $uri)); ?>" placeholder="<?php echo _t('Type new file name'); ?>">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
            <button id="save-new-name" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Save'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!--Delete file modal-->
    <div class="modal fade" id="fileDelete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="glyphicon glyphicon-remove-sign"></i> <?php echo _t('Delete current file'); ?></h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info editor-saving4"></div>
            <?php echo _t('Are you sure you want to delete this file This action is permanent'); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
            <button id="delete-file" type="button" class="btn btn-danger" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Yes delete'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

	 <!--Change folder name modal-->
    <div class="modal fade" id="folderName">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="glyphicon glyphicon-floppy-disk"></i> <?php echo _t('Change folder name'); ?></h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info editor-saving5"></div>
            <form role="form">
              <div class="form-group">
              	<input type="hidden" id="no-name" value="<?php echo _t('Error: file name cannot be empty'); ?>" />
                <input type="text" class="form-control" name="new-folder-name" id="new-folder-name" value="<?php echo basename(str_replace('%20', ' ', $uri)); ?>" placeholder="<?php echo _t('Type new folder name'); ?>">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
            <button id="save-folder-name" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Save'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!--Delete file modal-->
    <div class="modal fade" id="folderDelete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="glyphicon glyphicon-remove-sign"></i> <?php echo _t('Delete current folder'); ?></h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info editor-saving6"></div>
            <?php echo _t('Are you sure you want to delete this folder This action is permanent'); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
            <button id="delete-folder" type="button" class="btn btn-danger" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Yes delete'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php endif; ?>
<?php endif; ?>