<?php

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require '..' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

# Get Markdown class
use \Michelf\Markdown;

$type = $_REQUEST['type'];
$source = urldecode($_REQUEST['source']);
switch ($action) {
	case 'string':
		$html = Markdown::defaultTransform($source);
		break;
	case 'path':
		$html = get_content($source);
		break;
}
echo json_encode(array('status' => 'success', 'content' => Markdown::defaultTransform($source)));