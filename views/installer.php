<div class="clearfix">
	<div class="col-md-12 login-screen clearfix">
        <div class="col-md-1"></div>
        <div class="col-md-10">
        	<div class="panel" style="display: block">
            
            	<div class="panel-heading">
                	<h3><i class="glyphicon glyphicon-cog"></i> <?php title(); ?></h3>
                </div>
                <div class="panel-body">
                	<div class="alert alert-installer">
                    	<div class="msg"></div>
                        <input type="hidden" id="fields-missing" value="<?php echo _t('ERROR There are required fields empty'); ?>" />
                    </div>
                    <form class="clearfix installation-form" role="form">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_URL"><?php echo _t('Installation URL'); ?></label>
                        <input type="text" class="form-control required" id="DOC_URL" name="DOC_URL" placeholder="<?php echo _t('Global URL'); ?>" value="<?php echo curPageURL(); ?>"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('Leave as it is if Documentator url will remain current'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_PATH"><?php echo _t('Installation Path'); ?></label>
                        <input type="text" class="form-control required" id="DOC_PATH" name="DOC_PATH" placeholder="<?php echo _t('Installation Path'); ?>" value="<?php echo dirname(__DIR__); ?>"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('Leave as it is if Documentator path folder will remain current'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_USER"><?php echo _t('Admin username'); ?></label>
                        <input type="text" class="form-control required" id="DOC_USER" name="DOC_USER" placeholder="<?php echo _t('Type a username'); ?>"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('The username that will be used to login and manage documentation'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_PASS"><?php echo _t('Admin password'); ?></label>
                        <input type="password" class="form-control required" id="DOC_PASS" name="DOC_PASS" placeholder="<?php echo _t('Type a password'); ?>"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('The password that will be used to login and manage documentation'); ?></small>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_FOLDER"><?php echo _t('Files folder'); ?></label>
                        <input type="text" class="form-control required" id="DOC_FOLDER" name="DOC_FOLDER" placeholder="<?php echo _t('Files folder'); ?>" value="docs"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('The folder to be created and hold documentation files'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_LOGO"><?php echo _t('Logo URL'); ?></label>
                        <input type="text" class="form-control" id="DOC_LOGO" name="DOC_LOGO" placeholder="<?php echo _t('Type logo URL'); ?>"/>
                        <small><?php echo _t('Optional field'); ?> <?php echo _t('Link to your Logo if left empty the default logo will be displayed'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_NAME"><?php echo _t('Platform name'); ?></label>
                        <input type="text" class="form-control required" id="DOC_NAME" name="DOC_NAME" placeholder="<?php echo _t('Type Platform name'); ?>" value="Documentator"/>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('Ie My Business Knowledgebase Documentation'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_DESC"><?php echo _t('Platform description'); ?></label>
                        <input type="text" class="form-control" id="DOC_DESC" name="DOC_DESC" placeholder="<?php echo _t('Type Platform description'); ?>" value="Welcome to Documentator"/>
                        <small><?php echo _t('Optional field'); ?> <?php echo _t('Ie Welcome browse trough our App Documentation'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_LANG"><?php echo _t('Language'); ?></label>
                        <select class="form-control required" name="DOC_LANG" id="DOC_LANG">
                        	<?php
								$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'translate';
								if ($handle = opendir($path)) {	
									$blacklist = array('.', '..');
									while ($files[] = readdir($handle));
										sort($files);
										closedir($handle);
										
									foreach ($files as $file) {
										if (!in_array($file, $blacklist)) {
											
											$file_path = $path . DIRECTORY_SEPARATOR . $file;
											if(is_dir($file_path))
												continue;
											if(get_file_extension($file) != 'ini')
												continue;
												
											$name = explode('.', basename($file));
											$name = $name[0];
											
											printf('<option value="%1$s">%1$s</option>', $name);
												
										}
										
									}
								}
							?>
                        </select>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('Available language files in the translate folder'); ?> <a href="http://documentator.org/translate"><?php echo _t('Check translation documentation'); ?></a></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="DOC_DOWNLOAD"><?php echo _t('Download permission'); ?></label>
                        <select class="form-control required" name="DOC_DOWNLOAD" id="DOC_DOWNLOAD">
                        	<option value="yes"><?php echo _t('Yes allow'); ?></option>
                            <option value="no"><?php echo _t('No only reading rights'); ?></option>
                        </select>
                        <small><?php echo _t('Mandatory field'); ?> <?php echo _t('You can allow visitors to download your doc files as HTML or MD files'); ?></small>
                        </div>
                    </div>
                    </form>
                    <hr />
                    <a href="javascript:void(0)" class="btn btn-lg btn-primary" id="run-installer" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Run Installer'); ?></a>
                </div>
            
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>