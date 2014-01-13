<div class="clearfix">
<?php
	$path = str_replace('create/', '', $_GET['path']);
	
	if($path != '' && $path != 'create') {
		$full_path = DOC_FOLDER . DIRECTORY_SEPARATOR . $path . '.md';
		$md = get_md($full_path);
		$html = get_content($full_path);
	}
	include ('editor.php');
	include ('preview.php');
?>
</div>