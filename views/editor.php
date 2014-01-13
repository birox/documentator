<div class="col-md-6 create-editor">
	<div class="navbar navbar-default navbar-editor">
    	<div class="nav navbar-form navbar-left">
            <div class="btn-group">
                <a id="edit-save" href="javascript:void(0)" class="btn btn-xs btn-default <?php echo($md == '')? 'disabled' : ''; ?>" data-toggle="tooltip" title="<?php echo _t('Save'); ?>"><i class="glyphicon glyphicon-floppy-disk"></i></a>
                
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    	<?php if($md != ''): ?>
                        <li><a id="edit-save_1" href="javascript:void(0)"><?php echo _t('Save'); ?></a></li>
                        <?php endif; ?>
                        <li><a id="edit-saveas" href="javascript:void(0)"><?php echo _t('Save as'); ?></a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a id="edit-html-download" href="javascript:void(0)"><span class="label label-primary">HTML</span> <?php echo _t('Download'); ?></a></li>
                        <li><a id="edit-md-download" href="javascript:void(0)"><span class="label label-info">MD</span> <?php echo _t('Download'); ?></a></li>
                        <?php hook('editor_file_menu'); ?>                        
                        <?php if($md != ''): ?>
                        <li role="presentation" class="divider"></li>
                        <li><a id="edit-name" href="javascript:void(0)"><?php echo _t('File name'); ?></a></li>
                        <li><a id="edit-delete" href="javascript:void(0)"><?php echo _t('Delete file'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <span class="label label-default editor-saving">
            	<input type="hidden" id="no-text" value="<?php echo _t('Error: no content'); ?>" />
                <input type="hidden" id="no-folder" value="<?php echo _t('Error: no folder selected'); ?>" />
                <input type="hidden" id="no-name" value="<?php echo _t('Error: file name cannot be empty'); ?>" />
            	<input type="hidden" id="saving-text" value="<?php echo _t('Saving'); ?>" />
                <input type="hidden" id="downloading-text" value="<?php echo _t('Downloading'); ?>" />
                <input type="hidden" id="error-text" value="<?php echo _t('Error: try again'); ?>" />
                <input type="hidden" id="saved-text" value="<?php echo _t('File saved'); ?>" />
                <span class="output-text"></span>
            </span> |
            <a id="edit-bold" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Bold'); ?>"><i class="glyphicon glyphicon-bold"></i></a>
            <a id="edit-italic" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Italic'); ?>"><i class="glyphicon glyphicon-italic"></i></a>
            <a id="edit-quote" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Quote'); ?>"><i class="glyphicon glyphicon-comment"></i></a>
            <a id="edit-code" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Code'); ?>"><i class="glyphicon glyphicon-barcode"></i></a>
            <div class="btn-group">
                <a id="edit-h1" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Heading'); ?>"><i class="glyphicon glyphicon-header"></i></a>
                
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a id="edit-h1_1" href="javascript:void(0)">H1</a></li>
                        <li><a id="edit-h2" href="javascript:void(0)">H2</a></li>
                        <li><a id="edit-h3" href="javascript:void(0)">H3</a></li>
                        <li><a id="edit-h4" href="javascript:void(0)">H4</a></li>
                        <li><a id="edit-h5" href="javascript:void(0)">H5</a></li>
                    </ul>
                </div>
            </div> | 
            <a id="edit-link" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Link'); ?>"><i class="glyphicon glyphicon-link"></i></a>
            <a id="edit-image" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Image'); ?>"><i class="glyphicon glyphicon-picture"></i></a>
            <a id="edit-ulist" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Unordered list'); ?>"><i class="glyphicon glyphicon-th-list"></i></a>
            <a id="edit-olist" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Ordered list'); ?>"><i class="glyphicon glyphicon-list"></i></a>
            <a id="edit-rule" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Horizontal rule'); ?>"><i class="glyphicon glyphicon-minus"></i></a>
            <a id="edit-date" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Insert date'); ?>"><i class="glyphicon glyphicon-time"></i></a>
        </div>
        <div class="nav navbar-form navbar-right">
          <a id="edit-info" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Markdown cheat sheet'); ?>"><i class="glyphicon glyphicon-info-sign"></i></a>
          <a id="edit-reload" href="javascript:void(0)" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?php echo _t('Refresh the preview'); ?>" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><i class="glyphicon glyphicon-refresh"></i></a>
        </div>
    </div>
	<textarea id="md-editor" class="form-control md-editor"><?php echo $md; ?></textarea>
    <input type="hidden" id="md-file" value="<?php echo $full_path; ?>" />
</div>

<!--Link Editor modal-->
<div class="modal fade" id="insertLink">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-link"></i> <?php echo _t('Insert Link'); ?></h4>
      </div>
      <div class="modal-body">
        <p>
        	<input type="text" id="insert-url" class="form-control" placeholder="<?php echo _t('type URL'); ?>" />
        	<input type="hidden" id="selectedTitle" value="" />
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
        <button id="insert-link" type="button" class="btn btn-primary"><?php echo _t('Insert'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Image Editor modal-->
<div class="modal fade" id="insertImage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-picture"></i> <?php echo _t('Insert Image'); ?></h4>
      </div>
      <div class="modal-body">
        <p>
        	<input type="text" id="insert-image-url" class="form-control" placeholder="<?php echo _t('type URL'); ?>" />
        	<input type="hidden" id="selectedImageTitle" value="" />
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
        <button id="insert-image" type="button" class="btn btn-primary"><?php echo _t('Insert'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Save as modal-->
<div class="modal fade" id="saveAs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-floppy-disk"></i> <?php echo _t('Save file'); ?></h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-info editor-saving2"></div>
        <form role="form">
          <div class="form-group">
            <label for="save-folder"><?php echo _t('Select folder'); ?></label>
            <select class="form-control" name="save-folder" id="save-folder">
                <option value="new"><?php echo _t('New folder'); ?></option>
                <?php
                    $count = count(glob(DOC_FOLDER . DIRECTORY_SEPARATOR . '*'));
    
                    if($count > 0) {
                        if ($handle = opendir(DOC_FOLDER)) {	
                            $blacklist = array('.', '..');
                            while (false !== ($file = readdir($handle))) {
                                if (!in_array($file, $blacklist)) {
                                    $folder = DOC_FOLDER . DIRECTORY_SEPARATOR . $file;
                                    if(is_dir($folder) == true) {
                                        printf('<option value="%1$s">%1$s</option>', $file);
                                    }
                                }
                            }
                        }
                    }
                ?>
            </select>
          </div>
          <div class="form-group folder-name">
            <input type="text" class="form-control" name="save-fldr-name" id="save-fldr-name" placeholder="<?php echo _t('Folder name'); ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="save-file-name" id="save-file-name" placeholder="<?php echo _t('File name'); ?>">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
        <button id="save-md" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Save'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
            <input type="text" class="form-control" name="new-file-name" id="new-file-name" value="<?php echo basename(str_replace('.md', '', $full_path)); ?>" placeholder="<?php echo _t('Type new file name'); ?>">
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

<!--Download file (pdf) modal-->
<div class="modal fade" id="filePdfDownload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-download"></i> <?php echo _t('Download pdf file'); ?></h4>
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
        <button id="download-pdf-file" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Download'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Markdown cheat sheet-->
<div class="modal fade" id="MarkdownSheet">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i> <?php echo _t('Markdown cheat sheet'); ?></h4>
      </div>
      <div class="table" style="margin:0">
			<pre style="margin:0">
# Header 1 #
## Header 2 ##
### Header 3 ###             (Hashes on right are optional)
#### Header 4 ####
##### Header 5 #####

## Markdown plus h2 with a custom ID ##         {#id-goes-here}
[Link back to H2](#id-goes-here)

This is a paragraph, which is text surrounded by whitespace. Paragraphs can be on one 
line (or many), and can drone on for hours.  

Here is a Markdown link to [Warped](http://warpedvisions.org), and a literal . 
Now some SimpleLinks, like one to [google] (automagically links to are-you-
feeling-lucky), a [wiki: test] link to a Wikipedia page, and a link to 
[foldoc: CPU]s at foldoc.  

Now some inline markup like _italics_,  **bold**, and `code()`. Note that underscores in 
words are ignored in Markdown Extra.

![picture alt](/images/photo.jpeg "Title is optional")     

> Blockquotes are like quoted text in email replies
>> And, they can be nested

* Bullet lists are easy too
- Another one
+ Another one

1. A numbered list
2. Which is numbered
3. With periods and a space

And now some code:

    // Code is just text indented a bit
    which(is_easy) to_remember();

~~~

// Markdown extra adds un-indented code blocks too

if (this_is_more_code == true && !indented) {
    // tild wrapped code blocks, also not indented
}

~~~

Text with  
two trailing spaces  
(on the right)  
can be used  
for things like poems  

### Horizontal rules

* * * *
****
--------------------------

<div class="custom-class" markdown="1">
This is a div wrapping some Markdown plus.  Without the DIV attribute, it ignores the 
block. 
</div>

## Markdown plus tables ##

| Header | Header | Right  |
| ------ | ------ | -----: |
|  Cell  |  Cell  |   $10  |
|  Cell  |  Cell  |   $20  |

* Outer pipes on tables are optional
* Colon used for alignment (right versus left)

## Markdown plus definition lists ##

Bottled water
: $ 1.25
: $ 1.55 (Large)

Milk
Pop
: $ 1.75

* Multiple definitions and terms are possible
* Definitions can include multiple paragraphs too

*[ABBR]: Markdown plus abbreviations (produces an <abbr> tag)
            </pre>
      </div>
      <div class="modal-body">
      	<?php echo _t('Find out more about Markdown plain text formatting syntax on the authors website'); ?> <a href="http://daringfireball.net/projects/markdown/" target="_blank"><?php echo _t('HERE'); ?></a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->