<?php
include ('functions.php');

# Get Markdown class
use \Michelf\Markdown;
	
$action = $_REQUEST['action'];
$path = '..' . DIRECTORY_SEPARATOR . $_REQUEST['path'];
$template = $_REQUEST['template'];

switch ($action) {
	case 'html':
	
		if(isset($_REQUEST['path']) && file_exists($path)) {
			$text = file_get_contents($path);
			$html = Markdown::defaultTransform($text);
			$name = basename(str_replace('.md', '', $path));
		}
		else {
			$text = urldecode($_REQUEST['source']);
			$html = Markdown::defaultTransform($text);
			preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $html, $headings);
			if(is_array($headings[0])) {
				$title = $headings[0];
				if(is_array($title))
					$name = strip_tags($title[0]);
			}
			else {
				$name = _t('readme');
			}
		}
		
		$layout = file_get_contents('templates' . DIRECTORY_SEPARATOR . $template .'.html');
		
		$search = array('[TITLE]', '[CONTENT]');
		$replace = array($name, $html);
		$output = str_replace($search, $replace, $layout);
	
		header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
		header('Content-type: text/html; charset=utf-8');
		header('Content-disposition: attachment; filename='. $name .'.html');
		
		echo $output;
		
		break;
	
	case 'md':
		
		if(isset($_REQUEST['path']) && file_exists($path)) {
			$text = file_get_contents($path);
			$name = basename(str_replace('.md', '', $path));
		}
		else {
			$text = urldecode($_REQUEST['source']);
			$name = 'readme';
		}
		
		header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
		header('Content-disposition: attachment; filename='. $name .'.md');
		header('Content-type: text/md');
		
		echo '#'. $name .'
'. $text;
	
		break;
				
	case 'folder_html':
	
		if(isset($_REQUEST['path']) && file_exists($path)) {
			
			$folder_name = basename($path);
			
			if(!file_exists($_REQUEST['path']))
			$temp = $folder_name;
			else
			$temp = $folder_name . '_' . uniqid();
			
			$assets_url = DOC_URL . DIRECTORY_SEPARATOR . 'assets'. DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;
			
			mkdir($temp, 0777, true);
			
			$files = glob($path . DIRECTORY_SEPARATOR .'*.{md}', GLOB_BRACE);
			$list = '';
			foreach($files as $file) {
				
				$name = basename(str_replace('.md', '', $file));
				if($name == 'readme')
					continue;
				$list .= sprintf('<li><a href="../%2$s/%1$s.htm"><i class="glyphicon glyphicon-file"></i> %1$s</a></li>', $name, $folder_name);
				
			}
			foreach($files as $file) {
				
				$text = file_get_contents($file);
				$html = Markdown::defaultTransform($text);
				$name = basename(str_replace('.md', '', $file));
				if($name == 'readme')
					$name = 'index';
				
				$layout = file_get_contents('templates' . DIRECTORY_SEPARATOR . $template .'_folder.html');
				
				$search = array('[TITLE]', '[CONTENT]', '[FOLDER_TITLE]', '[LIST]', '../fonts/');
				$replace = array($name, $html, $folder_name, $list, $assets_url);
				$output = str_replace($search, $replace, $layout);
				
				$newFile = $temp . DIRECTORY_SEPARATOR . $name . '.htm';
				
				file_put_contents($newFile,$output);
				
			}
			
			$files = glob($temp . DIRECTORY_SEPARATOR .'*.{htm}', GLOB_BRACE);
			$zipname = $folder_name .'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);
			foreach ($files as $file) {
			  $zip->addFile($file);
			}
			$zip->close();
			
			header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='. $zipname);
			readfile($zipname);
			
			doc_delete($temp);
			doc_delete($zipname);
			
		}
		else {
			
		}
	
		break;
		
	case 'folder_md':
	
		if(isset($_REQUEST['path']) && file_exists($path)) {
			
			$folder_name = basename($path);
			
			if(!file_exists($_REQUEST['path']))
			$temp = $folder_name;
			else
			$temp = $folder_name . '_' . uniqid();
			
			mkdir($temp, 0777, true);
			
			$files = glob($path . DIRECTORY_SEPARATOR .'*.{md}', GLOB_BRACE);
			$list = '';
			foreach($files as $file) {
				
				$text = file_get_contents($file);
				$name = basename(str_replace('.md', '', $file));
				$output = '#'. $name .'
'. $text;
				
				$newFile = $temp . DIRECTORY_SEPARATOR . $name . '.md';
				
				file_put_contents($newFile,$output);
				
			}
			
			$files = glob($temp . DIRECTORY_SEPARATOR .'*.{md}', GLOB_BRACE);
			$zipname = $folder_name .'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);
			foreach ($files as $file) {
			  $zip->addFile($file);
			}
			$zip->close();
			
			header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='. $zipname);
			readfile($zipname);
			
			doc_delete($temp);
			doc_delete($zipname);
			
		}
		else {
			
		}
	
		break;
				
	default:
		
		hook('download_'. $action, array('action' => $action, 'path' => $path, 'template' => $template));
		
}
die();