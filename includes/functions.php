<?php
session_start();
# Get Configuration if setup
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR .'config.php'))
	require (dirname(__FILE__) . DIRECTORY_SEPARATOR .'config.php');

# Require hooks
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR .'config.php'))
	require (dirname(__FILE__) . DIRECTORY_SEPARATOR .'hooks.php');	

# Require plugins
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR .'config.php'))
	require (dirname(__FILE__) . DIRECTORY_SEPARATOR .'plugins.php');	

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require (DOC_PATH . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php');
});

# Get Markdown class
use \Michelf\Markdown;

#
# Documentator Path: return
#
function get_path() {
	if(defined('DOC_URL')) {
		return DOC_URL;
	}
	else {
		return curPageURL();
	}
}

#
# Documentator Path: echo
#
function path() {
	if(defined('DOC_URL')) {
		
		echo DOC_URL;
		
	}
	else {
		
		echo curPageURL();
		 
	}
}

#
# Documentator CSS files: printf
#
function css() {
	if(defined('DOC_CSS')) {
		
		$styles = unserialize (DOC_CSS);
		
		foreach($styles as $style) {
			printf('<link rel="stylesheet" href="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'css'. DIRECTORY_SEPARATOR .'%s.css">', get_path(), $style);
		}
		
	}
	else {
		printf('<link rel="stylesheet" href="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'css'. DIRECTORY_SEPARATOR .'bootstrap.min.css">', get_path());
		printf('<link rel="stylesheet" href="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'css'. DIRECTORY_SEPARATOR .'style.css">', get_path());
	}
	$plugs = hook('css', array());
	//echo print_r($plugs, true);
	if(is_array($plugs)) {
		foreach($plugs as $plug) {
			foreach($plug as $style)
				printf('<link rel="stylesheet" href="%s">', $style);
		}
	}
	
}

#
# Documentator CSS files: printf
#
function js() {
	if(defined('DOC_JS')) {
		
		$scripts = unserialize (DOC_JS);
		
		foreach($scripts as $script) {
			printf('<script type="text/javascript" src="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'js'. DIRECTORY_SEPARATOR .'%s.js"></script>', get_path(), $script);
		}
		
	}
	else {
		printf('<script type="text/javascript" src="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'js'. DIRECTORY_SEPARATOR .'jquery-1.10.2.min.js"></script>', get_path());
		printf('<script type="text/javascript" src="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'js'. DIRECTORY_SEPARATOR .'bootstrap.min.js"></script>', get_path());
		printf('<script type="text/javascript" src="%s'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR .'js'. DIRECTORY_SEPARATOR .'scripts.js"></script>', get_path());
	}
	$plugs = hook('js', array());
	if(is_array($plugs)) {
		foreach($plugs as $plug) {
			foreach($plug as $script)
				printf('<script type="text/javascript" src="%s"></script>', $script);
		}
	}
}

#
# Documentator title: return
#
function get_title($path = null) {
	if(defined('DOC_NAME')) {

		if((DOC_URL . DIRECTORY_SEPARATOR == curPageURL()) && !$path)
			return DOC_NAME;
			
		else {
			/* OLD GET TITLE FROM H tags
			$html = get_content($path);
			if($html) {
				preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $html, $headings);
				if(is_array($headings[0])) {
					$title = $headings[0];
					if(is_array($title))
						$title = strip_tags($title[0]);
				}
				else {
					$title = DOC_NAME;
				}
				return $title;
			}
			else {
				return DOC_NAME;
			}*/
			$uri = str_replace(DOC_URL, '', curPageURL());
			if($path)
				return basename($path, ".md");
			else
				return basename(str_replace('%20', ' ', $uri));
			
		}
			
		
	}
	else {
		return _t('Install Documentator');
	}
}

#
# Documentator title: echo
#
function title() {
	if(defined('DOC_NAME')) {
		
		if(DOC_URL . DIRECTORY_SEPARATOR == curPageURL())
			echo DOC_NAME;
			
		else {
			/* OLD GET TITLE FROM H tags
			$html = get_content();
			if($html) {
				preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $html, $headings);
				if(is_array($headings[0])) {
					$title = $headings[0];
					if(is_array($title))
						$title = strip_tags($title[0]);
				}
				else {
					$title = DOC_NAME;
				}
				echo $title;
			}
			else {
				echo DOC_NAME;
			}*/
			$uri = str_replace(DOC_URL, '', curPageURL());
			echo basename(str_replace('%20', ' ', $uri));
			
		}
		
	}
	else {
		echo _t('Install Documentator');
	}
}

#
# Documentator content: return
#
function get_content($path = null) {

	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		//die($uri .'---'. $_SERVER['REQUEST_URI']);
		if(!$path)
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
			
		if(file_exists($path)) {
			$text = file_get_contents($path);
			$html = Markdown::defaultTransform($text);
			return $html;
		}
		elseif(doc_folder() == true) {
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .'readme.md';
			if(file_exists($path)) {
				$text = file_get_contents($path);
				$html = Markdown::defaultTransform($text);
				return $html;
			}
			else {
				return '<i class="glyphicon glyphicon-chevron-left"></i> '. _t('Navigate trough documentation');
			}
		}
		else {
			return null;
		}
	
	}
}

#
# Documentator content: echo
#
function content() {
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
		if(file_exists($path)) {
			$text = file_get_contents($path);
			$html = Markdown::defaultTransform($text);
			echo $html;
		}
		elseif(doc_folder() == true) {
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .'readme.md';
			if(file_exists($path)) {
				$text = file_get_contents($path);
				$html = Markdown::defaultTransform($text);
				echo $html;
			}
			else {
				echo '<i class="glyphicon glyphicon-chevron-left"></i> '. _t('Navigate trough documentation');
			}
		}
		else {
			echo null;
		}
	
	}
}

#
# Documentator md: return
#
function get_md($path = null) {
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		if(!$path)
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
			
		if(file_exists($path)) {
			$text = file_get_contents($path);
			return $text;
		}
		else {
			return null;
		}
	
	}
}

#
# Documentator content: echo
#
function md() {
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
		if(file_exists($path)) {
			$text = file_get_contents($path);
			echo $text;
		}
		else {
			echo null;
		}
	
	}
}

#
# Documentator index: echo
#
function index() {
	if(defined('DOC_URL')) {
		
		$pages = hook('pages_url', array());
		
		if(DOC_URL . DIRECTORY_SEPARATOR == curPageURL())
			echo build_index();
			
		elseif($_GET['create'] == 1 && login_check() == true)
			include ('views/create.php');
			
		elseif($_GET['create'] == 1 && login_check() == false)
			include ('views/login.php');
			
		elseif($_GET['login'] == 1 && login_check() == false)
			include ('views/login.php');
			
		elseif($_GET['login'] == 1 && login_check() == true)
			echo build_index();
			
		elseif($_GET['bookmarks'] == 1)
			include ('views/bookmarks.php');
			
		elseif($_GET['search'] == 1)
			include ('views/search.php');
			
		elseif(in_array_r($_GET['page'], $pages))
			hook('page_'. $_GET['page']);
			
		else
			include ('views/read.php');
	
	}
	else {
		include ('views/installer.php');
	}
}

#
# Documentator curPageURL: return
#
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

#
# Documentator build_index: printf
#
function build_index() {
	hook('home_top');
	echo '<div class="clearfix">';
	$count = count(glob(DOC_FOLDER . DIRECTORY_SEPARATOR . '*'));
	
	if($count > 0) {
		if ($handle = opendir(DOC_FOLDER)) {	
		$blacklist = array('.', '..');
		$x = 0;
		$count = $count - 1;
			$list .= '<div class="clearfix index-folders">';
			
			while ($files[] = readdir($handle));
				sort($files);
				closedir($handle);
			
			foreach ($files as $file) {
				if (!in_array($file, $blacklist)) {
					$folder = DOC_FOLDER . DIRECTORY_SEPARATOR . $file;
					if(is_dir($folder) == true && $folder != DOC_FOLDER . DIRECTORY_SEPARATOR) {
						
						$list .= sprintf(
							'<div class="col-sm-3 col-md-3">
								<h4><a href="%s"><i class="glyphicon glyphicon-folder-open"></i> %s</a></h4>
								%s
							</div>',
							DOC_URL . DIRECTORY_SEPARATOR . $file, $file, get_file_list($file, 5)
						);
						
						if ($x % 4 == 3)
							$list .= '<div style="clear:both"></div>';
							
						$x++;
					}
					else {
						continue;
					}
					
				}
			}
			
			$list .= '</div>';
		}
		
		printf(
			'<div class="clearfix">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					%s
					%s
				</div>
				<div class="col-md-1"></div>
			</div>',
			hook('home_title'), $list
		);
	}
	else {
		
		printf(
			'<div class="clearfix">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					%s
					<p>%s</p>
				</div>
				<div class="col-md-1"></div>
			</div>',
			hook('home_title'), _t('There are no files written yet')
		);
		
	}
	
	$bookmarks = list_bookmarked(20);
	if($bookmarks != false) {
		printf(
			'<div class="clearfix">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<hr />
					<h3 class="btn-bookmarked"><a href="%s"><i class="glyphicon glyphicon-fire"></i> %s</a></h3>
					%s
				</div>
				<div class="col-md-1"></div>
			</div>',
			DOC_URL . DIRECTORY_SEPARATOR . 'bookmarks', _t('Your latest bookmarks'), $bookmarks
		);
	}
	echo '</div>';
	hook('home_bottom');
}

#
# Documentator translate: return
#
function _t($string) {
	
	if(defined('DOC_LANG')) {
		$translate = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'translate' . DIRECTORY_SEPARATOR . DOC_LANG . '.ini', true);
		
		$plugs = hook('translate', array());
		
		if(is_array($plugs)) {
			foreach($plugs as $plug)
				if(file_exists($plug . DIRECTORY_SEPARATOR . DOC_LANG . '.ini'))
					$translate = array_merge($translate, parse_ini_file($plug . DIRECTORY_SEPARATOR . DOC_LANG . '.ini', true));
		}
	}
	else {
		$translate = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'translate' . DIRECTORY_SEPARATOR . 'en.ini', true);
	}
		
	if (array_key_exists($string, $translate))
		return $translate[$string];
	else
		return $string;
	
}

#
# Documentator logo: printf
#
function logo() {
	
	if(defined('DOC_LOGO') && DOC_LOGO != '') {
		printf('<img id="doc-logo" src="%s" />', DOC_LOGO);
	}
	else {
		printf('<img id="doc-logo" src="%s/assets/img/logo.png" />', get_path());
	}
	
}

#
# Documentator url_exists: return
#
function url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}

#
# Documentator url_exists: return
#
function get_file_list($folder, $limit = null) {
	$path = DOC_FOLDER . DIRECTORY_SEPARATOR . $folder;
	$count = count(glob($path . DIRECTORY_SEPARATOR . '*'));
	if($count > 0) {
		if ($handle = opendir($path)) {	
			$blacklist = array('.', '..');
			$x = 1;
			$list = '<ul class="file-list">';
			while ($files[] = readdir($handle));
				sort($files);
				closedir($handle);
				
			foreach ($files as $file) {
				if (!in_array($file, $blacklist)) {
					
					$file_path = $path . DIRECTORY_SEPARATOR . $file;
					if(is_dir($file_path))
						continue;
					if(get_file_extension($file) != 'md')
						continue;
					if($file == 'readme.md')
						continue;
					
					$extension = substr(strrchr($file,'.'),1);
					$name = rtrim(basename($file), '.md');
					$url = DOC_URL . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $name;
					$url = str_replace(' ', '%20', $url);
					
					$selected = '';
					if($url == curPageURL())
						$selected = 'class="selected"';
						
					if($limit && $x <= $limit)	
						$list .= sprintf('<li><a href="%s" %s><i class="glyphicon glyphicon-file"></i> %s</a></li>', $url, $selected, get_title($file_path));
					elseif($limit && $x == ($limit + 1))
						$list .= sprintf('<li><a href="%s">%s <i class="glyphicon glyphicon-arrow-right"></i></a></li>', DOC_URL . DIRECTORY_SEPARATOR . $folder, _t('and more'));
					elseif($limit && $x > $limit)
						$list .= '';
					else
						$list .= sprintf('<li><a href="%s" %s><i class="glyphicon glyphicon-file"></i> %s</a></li>', $url, $selected, get_title($file_path));
						
					$x++;
					
				}
			}
			$list .= '</ul>';
			
			return $list;
		}
	}
	else {
		return null;
	}
}

#
# Documentator get_menu: return
#
function get_menu($path = null) {
	
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		if(!$path) {
			if(doc_file() == true)
				$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
			elseif(doc_folder == true)
				$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR);
		}
		
		if(file_exists($path)) {
			if(doc_file() == true) {
				$relative_path = ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
				$directory = dirname($relative_path);
			}
			else {
				$directory = ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR);
			}
			$name = basename($directory);
			return '<h4><i class="glyphicon glyphicon-folder-open"></i>  '. $name .'</h4>'. get_file_list($directory);
		}
		else {
			return null;
		}
	
	}
	
}

#
# Documentator menu: echo
#
function menu() {
	
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		if(doc_file() == true)
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
		elseif(doc_folder == true)
			$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR);
			
		if(file_exists($path)) {
			if(doc_file() == true) {
				$relative_path = ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
				$directory = dirname($relative_path);
			}
			else {
				$directory = ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR);
			}
			$name = basename($directory);
			echo '<h4><i class="glyphicon glyphicon-folder-open"></i>  '. $name .'</h4>'. get_file_list($directory);
		}
		else {
			echo null;
		}
	
	}
	
}

#
# Documentator start secure session
#
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

#
# Documentator login_check
#
function login_check() {
    // Check if all session variables are set 
    if (isset( $_SESSION['username'], $_SESSION['login_string'])) {
 
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if (defined('DOC_USER')) {
			$login_check = hash('sha512', DOC_PASS . $user_browser);

			if ($login_check == $login_string) {
				// Logged In!!!! 
				return true;
			} else {
				// Not logged in 
				return false;
			}
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

#
# Documentator esc_url
#
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

#
# Documentator get file extension
#
function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}

#
# Documentator delete file or if folder provided all files inside + the folder
#
function doc_delete($path) {
	if (is_dir($path) === true)
	{
		$files = array_diff(scandir($path), array('.', '..'));

		foreach ($files as $file)
		{
			doc_delete(realpath($path) . '/' . $file);
		}

		return rmdir($path);
	}

	else if (is_file($path) === true)
	{
		return unlink($path);
	}

	return false;
}

#
# Documentator check if current page is a md file
#
function doc_file() {
	
	if(DOC_URL . DIRECTORY_SEPARATOR == curPageURL())
		return false;
			
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR) .'.md';
		if(is_file($path) === true) {
			return true;
		}
		else {
			return false;
		}
	
	}
	else {
		return false;
	}
	
}

#
# Documentator check if current page is a md folder
#
function doc_folder() {
	
	if(DOC_URL . DIRECTORY_SEPARATOR == curPageURL())
		return false;
			
	if(defined('DOC_FOLDER')) {
		
		$uri = str_replace(DOC_URL, '', curPageURL());
		
		$path = DOC_FOLDER . DIRECTORY_SEPARATOR . ltrim(str_replace('%20', ' ', $uri), DIRECTORY_SEPARATOR);
		if(is_dir($path) === true) {
			return true;
		}
		else {
			return false;
		}
	
	}
	else {
		return false;
	}
	
}

#
# Documentator check if selected page is bookmarked
#
function doc_bookmarked($url) {
	
	$bookmarks = json_decode($_COOKIE['doc_bookmarks'], true);
	
	if(is_array($bookmarks)) {		
		if(in_array_r($url, $bookmarks)) {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

#
# Documentator recursive array check
#
function in_array_r($needle, $haystack, $strict = false) {
	if(is_array($haystack)) {
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
				return true;
			}
		}
	}

    return false;
}

#
# Documentator bookmarks list
#
function list_bookmarked($limit = null) {
	
	$bookmarks = json_decode($_COOKIE['doc_bookmarks'], true);
	
	if(is_array($bookmarks)) {		
		$x = 1;
		$list = '<ul class="file-list bookmarks-list clearfix">';
			
		foreach ($bookmarks as $bookmark) {
							
			if($limit && $x <= $limit)	
				$list .= sprintf('<li><a href="%s"><i class="glyphicon glyphicon-file"></i> %s</a></li>', $bookmark['url'], $bookmark['title']);
			elseif($limit && $x == ($limit + 1))
				$list .= sprintf('<li><a href="%s">%s <i class="glyphicon glyphicon-arrow-right"></i></a></li>', DOC_URL . DIRECTORY_SEPARATOR . 'bookmarks', _t('and more'));
			elseif($limit && $x > $limit)
				$list .= '';
			else
				$list .= sprintf('<li><a href="%s"><i class="glyphicon glyphicon-file"></i> %s</a></li>', $bookmark['url'], $bookmark['title']);
				
			$x++;
		}
		$list .= '</ul>';
		
		return $list;
	}
	else {
		return false;
	}
}

#
# Search and find files that contain specified string
#
function doc_find($string, $dir) {
	$file_type=finfo_open(FILEINFO_MIME_TYPE);
 
	if(trim($string)!="" && $dir_h=opendir($dir)) {
		$files=Array();
		$sub_files=Array();
		
		while($file=readdir($dir_h)) {
			
			$processed = array();
						
			if($file!="." && $file!=".." && $file[0]!='.') {
				if(is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
					$sub_files = doc_find($string, $dir . DIRECTORY_SEPARATOR . $file);
				}
				else {
					if(substr(finfo_file($file_type, $dir . DIRECTORY_SEPARATOR . $file), 0,4)=='text') {					
						$lines=file($dir . DIRECTORY_SEPARATOR . $file);
						for($i=0;$i<count($lines);$i++) {
							
						$check = $dir . DIRECTORY_SEPARATOR . $file;
						if(in_array_r($check, $processed))
							continue;

							
 							if(strstr($lines[$i], $string)) {

								$search = array(DOC_FOLDER . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, '..');
								$replace = array('', '', '');
								$directory = str_replace($search, $replace, $dir);
								$page = str_replace('.md', '', $file);
								
								printf(
									'<li>
										<a href="%s" class="found-file">%s</a> <a href="%s" class="found-folder"><i class="glyphicon glyphicon-folder-open"></i> %s</a>
										<div class="found-context">%s</div>
										<small><span class="label label-primary">%s</span> %s</small>
									</li>',
									DOC_URL . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $page,
									$page,
									DOC_URL . DIRECTORY_SEPARATOR . $directory,
									$directory,
									$lines[$i],
									_t('exact match'),
									_t('row') .' '. ($i+1)
								);
								
								array_push($processed, $dir . DIRECTORY_SEPARATOR . $file);
								
							}
							
							$row_array=explode(" ", trim($lines[$i]));	
 
							for($n=0;$n<count($row_array); $n++) {
 
								$temp=strip_tags($row_array[$n]);
								$current_word=preg_replace("/[\s,+.-]+/", "", $temp); /* remove ,.+- characters. */
 
								$c = "none";
								if(strcmp(trim($current_word), trim($string)) == 0) {
									$c = '<span class="label label-primary">'. _t('exact match') .'</span>';
								}
								elseif(strcmp(trim(strtolower($current_word)), trim(strtolower($string))) == 0) {				
									$c = '<span class="label label-default">'. _t('non-exact match') .'</span>';
								}
								elseif(strstr(trim($current_word),trim($string))) {
									$c = '<span class="label label-primary">'. _t('exact match in a string') .'</span>';
								}
								elseif(strstr(trim(strtolower($current_word)),trim(strtolower($string)))) {
									$c = '<span class="label label-default">'. _t('non-exact in a string') .'</span>';
								}
 
								if($c<>"none") {
									//echo "<em>\"".$current_word."\"</em> found: ".$dir."/<b>".$file."</b>, row ".($i+1)." word #".($n+1). " [".$c."]<br>";
									
									$search = array(DOC_FOLDER . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, '..');
									$replace = array('', '', '');
									$directory = str_replace($search, $replace, $dir);
									$page = str_replace('.md', '', $file);
									
									printf(
										'<li>
											<a href="%s" class="found-file">%s</a> <a href="%s" class="found-folder"><i class="glyphicon glyphicon-folder-open"></i> %s</a>
											<div class="found-context">%s</div>
											<small>%s %s</small>
										</li>',
										DOC_URL . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $page,
										$page,
										DOC_URL . DIRECTORY_SEPARATOR . $directory,
										$directory,
										$lines[$i],
										$c,
										_t('row') .' '. ($i+1) .' '. _t('word') .' #'. ($n+1)
									);
									
									array_push($processed, $dir . DIRECTORY_SEPARATOR . $file);
									
								}
								
							}
						}
					}
				}
			}
		}
		closedir($dir_h);
		
	}
	else {
		echo "no search string and/or not a valid directory.";
	}
}		

/**
 * Attach (or remove) multiple callbacks to a hook and trigger those callbacks when that hook is called.
 *
 * @param string $hook name
 * @param mixed $value the optional value to pass to each callback
 * @param mixed $callback the method or function to call - FALSE to remove all callbacks for hook
 */
function hook($event, $value = NULL, $callback = NULL)
{
    static $events;

    // Adding or removing a callback?
    if($callback !== NULL)
    {
        if($callback)
        {
            $events[$event][] = $callback;
        }
        else
        {
            unset($events[$event]);
        }
    }
    elseif(isset($events[$event])) // Fire a callback
    {
        foreach($events[$event] as $function)
        {
            $value = call_user_func($function, $value);
        }
        return $value;
    }
}

#
# Returns the url of current plugin
#
function plugin_url($path) {
	return DOC_URL . DIRECTORY_SEPARATOR . PLUGIN_FOLDER . DIRECTORY_SEPARATOR . basename(dirname ( $path ));
}

#
# Returns the path of current plugin
#
function plugin_path($path) {
	return PLUGIN_PATH . DIRECTORY_SEPARATOR . basename(dirname ( $path ));
}

function doc_install() {
	
	
	
}






































