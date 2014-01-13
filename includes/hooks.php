<?php

#
# Hook filter_search: add filters to search string
# output methods: return

#
hook('filter_search', NULL, function($text) { 

	$search = array('search/', '%20');
	$replace = array('', ' ');
	$text = str_replace($search, $replace, $text);
	return $text;

});

#
# Hook footer_right: output content to footer right side area
# output methods: echo, print OR printf
#
hook('footer_right', null, function() {
	printf(
	'%s <a href="http://documentator.org">Documentator</a>',
	_t('Powered by'));
});

#
# Hook footer_left: output content to footer left side area
# output methods: echo, print OR printf
#
hook('footer_left', null, function() {});

#
# Hook before_login: get info before user logs in
# receive vars: $vars['username'] & $vars['password']
#
hook('before_login', null, function($vars) {});

#
# Hook login_success: get info after successfull login
# receive vars: $vars['username'], $vars['password'], $vars['ip'], $vars['time'] (ref: PHP getdate())
#
hook('login_success', null, function($vars) {});

#
# Hook login_fail: get info after failed login
# receive vars: $vars['username'], $vars['password'], $vars['ip'], $vars['time'] (ref: PHP getdate())
#
hook('login_fail', null, function($vars) {});

#
# Hook do_login: temporary login using the global config
# receive vars: $vars['username'], $vars['password']
#
hook('do_login', null, function($vars) {
	
	$username = $vars['username'];
	$password = $vars['password'];

	$pass = md5($password);
	
	if ((DOC_USER == $username) && (DOC_PASS == $pass)) {
		// Password is correct!
		// Get the user-agent string of the user.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		// XSS protection as we might print this value
		$username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
													"", 
													$username);
		$_SESSION['username'] = $username;
		$_SESSION['login_string'] = hash('sha512', 
				  $pass . $user_browser);
		// Login successful.
		return true;
	} else {
		
		return false;
		
	}
	
});

#
# Hook home_top: output content before home structure
# output methods: echo, print OR printf
#
hook('home_top', null, function() {});

#
# Hook home_bottom: output content before home structure
# output methods: echo, print OR printf
#
hook('home_bottom', null, function() {});

#
# Hook home_title: output content before home structure (title area)
# output methods: return
#
hook('home_title', null, function() {
	
	$output = sprintf('
		<h1>%s</h1>
		<hr />
		<div class="doc-description">%s</div>
	',
	DOC_NAME, DOC_DESC);
	
	return $output;
	
});

#
# Hook head: output in <head></head>
# to be used for meta tags, SEO purposes, NOT for printing scripts & styles, use 'js' and 'css' hooks for that
# output methods: echo, print OR printf
#
hook('head', null, function($vars) {});

#
# Hook before_content: output before content
# output methods: echo, print OR printf
#
hook('before_content', null, function() {});

#
# Hook after_content: output before content
# output methods: echo, print OR printf
#
hook('after_content', null, function() {});

#
# Hook js: register plugin's js files
# value to pass to each callback: string $scripts
# output methods: return array()
# user plugin_url(__FILE__): return array(plugin_url(__FILE__) .'/assets/scripts.js', plugin_url(__FILE__) .'/assets/scripts2.js');
#
hook('js', null, function() {});

#
# Hook css: register plugin's css files
# value to pass to each callback: string $styles
# output methods: return array()
# user plugin_url(__FILE__): return array(plugin_url(__FILE__) .'/assets/styles.css', plugin_url(__FILE__) .'/assets/styles2.css');
#
hook('css', null, function() {});

#
# Hook translate: declare plugin's translate .ini files folder 
# value to pass to each callback: string $translate
# output methods: return array()
# user plugin_path(__FILE__): return array(plugin_path(__FILE__) .'/translate');
#
hook('translate', null, function() {});

#
# Hook user_file_download_menu: output a li link in the download menu (for loggedin user)
# output methods: echo, print OR printf
#
hook('user_file_download_menu', null, function() {});

#
# Hook user_folder_download_menu: output a li link in the download menu (for loggedin user)
# output methods: echo, print OR printf
#
hook('user_folder_download_menu', null, function() {});

#
# Hook public_file_download_menu: output a li link in the download menu (for public)
# output methods: echo, print OR printf
#
hook('public_file_download_menu', null, function() {});

#
# Hook public_folder_download_menu: output a li link in the download menu (for public)
# output methods: echo, print OR printf
#
hook('public_folder_download_menu', null, function() {});

#
# Hook editor_file_menu: output a li link in the editor file menu
# output methods: echo, print OR printf
#
hook('editor_file_menu', null, function() {});

#
# Hook download_[your_type]: build a hook with prefix download_ in the plugin to output content
# output methods: echo, print OR printf
# do an ajax call to the download url with these vars: &action=[your_type]'+ path +'&template='+ template +'&source='+ source and construct a hook like mentioned, it will trigger your hook when ajax download call is triggered
# see toPDF plugin example for more details
#
hook('download_*', null, function() {});

#
# Hook page_[page_url]: load a page
# output methods: echo, print OR printf
# place your page content inside a function and call it using the hook
# in order to work this hook also requires registering your_url in the pages_url hook
#
hook('page_*', null, function() {});

#
# Hook pages_url: register the urls for pages
# output methods: return array()
# function receivers a array param register urls like so: $pages[] = array('terms','privacy'); return $pages;
# see credits plugin for more
#
hook('pages_url', null, function($pages) {});

#
# Hook user_menu: add a menu item to loggedin users
# output methods: echo, print OR printf
# example to output in hook function: <li><a href="#">Menu item</a></li>
#
hook('user_menu', null, function() {});

#
# Hook public_menu: add a menu item to public users
# output methods: echo, print OR printf
# example to output in hook function: <li><a href="#">Menu item</a></li>
#
hook('public_menu', null, function() {});

#
# Hook read_menu: outputs content to all read documents sidebar
# output methods: echo, print OR printf
#
hook('read_menu', null, function() {});

#
# Hook read_breadcrum: outputs content to all read documents above title
# output methods: echo, print OR printf
#
hook('read_breadcrum', null, function() {});

#
# Hook save_existing: process existing file save request
# output methods: return a status ('success' or 'error')
# received vars: [file] and [source]
#
hook('save_existing', null, function($vars) {
	
	$fname = '..' . DIRECTORY_SEPARATOR . $vars['file'];
	$fhandle = fopen($fname,"r");
	$content = urldecode($vars['source']);
	$fhandle = fopen($fname,"w");
	fwrite($fhandle,$content);
	fclose($fhandle);
	return 'success';
	
});

#
# Hook saved_existing: hook on save existing file process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [source], [ip] and [time] > reffer to php's getdate() for time
#
hook('saved_existing', null, function($vars) {});

#
# Hook save_new: process existing file save request
# output methods: return a array('status' => 'success' or 'error', 'message' => '', 'url' => '');
# received vars: [file], [source] and [folder]
#
hook('save_new', null, function($vars) {
	
	$name = $vars['name'];
	$source = urldecode($vars['source']);
	$folder = '..' . DIRECTORY_SEPARATOR . DOC_FOLDER . DIRECTORY_SEPARATOR . $vars['folder'];
	if(!file_exists($folder))
		mkdir($folder, 0777, true);
	
	$fullpath = $folder . DIRECTORY_SEPARATOR . $name . '.md';
	
	if(file_exists($fullpath)) {
		return array('status' => 'error', 'message' => _t('File already exists Choose a new name'), 'url' => '');
	}
	else {
		if(file_put_contents($fullpath,$source)!=false){
			$url = DOC_URL . DIRECTORY_SEPARATOR . 'create' . DIRECTORY_SEPARATOR . $vars['folder'] . DIRECTORY_SEPARATOR . $name;
			return array('status' => 'success', 'message' => _t('File created Updating the page'), 'url' => $url);
		}
		else {
			return array('status' => 'error', 'message' => _t('Error creating the file, try later'), 'url' => '');
		}
	}
	
});

#
# Hook saved_new: hook on save new file process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [source] [folder], [ip] and [time] > reffer to php's getdate() for time
#
hook('saved_new', null, function($vars) {});

#
# Hook save_name: process existing file name save/change
# output methods: return a array('status' => 'success' or 'error', 'message' => '', 'url' => '');
# received vars: [file], [name] and [page]
#
hook('save_name', null, function($vars) {
	
	$oldname = '..' . DIRECTORY_SEPARATOR . $vars['file'];
		
	$basename = basename($oldname);
	$newname = str_replace($basename, $vars['name'] .'.md', $oldname);
	
	rename($oldname, $newname);
	
	$search = array('..' . DIRECTORY_SEPARATOR, DOC_FOLDER . DIRECTORY_SEPARATOR, '.md');
	$replace = array('', '', '');
	
	if($vars['page'] == 'create')
		$url = DOC_URL . DIRECTORY_SEPARATOR . 'create' . DIRECTORY_SEPARATOR . str_replace($search, $replace, $newname);
	else
		$url = DOC_URL . DIRECTORY_SEPARATOR . str_replace($search, $replace, $newname);
	
	return array('status' => 'success', 'message' => _t('File name changed Updating the page'), 'url' => $url);

	
});

#
# Hook saved_name: hook on save/update file name process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [name], [page], [ip] and [time] > reffer to php's getdate() for time
#
hook('saved_name', null, function($vars) {});

#
# Hook delete_file: process existing file delete request
# output methods: return a array('status' => 'success' or 'error', 'message' => '', 'url' => '');
# received vars: [file] and [page]
#
hook('delete_file', null, function($vars) {
	
	if($vars['page'] == 'create') {
		doc_delete('..' . DIRECTORY_SEPARATOR . $vars['file']);
		$url = DOC_URL . DIRECTORY_SEPARATOR . 'create';
	}
	else {
		doc_delete('..' . DIRECTORY_SEPARATOR . $vars['file']);
		$url = DOC_URL;
	}
	
	return array('status' => 'success', 'message' => _t('File deleted Updating the page'), 'url' => $url);

	
});

#
# Hook deleted_file: hook on delete file process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [page], [ip] and [time] > reffer to php's getdate() for time
#
hook('deleted_file', null, function($vars) {});

#
# Hook save_folder_name: process existing folder name save/update request
# output methods: return a array('status' => 'success' or 'error', 'message' => '', 'url' => '');
# received vars: [file] and [name]
#
hook('save_folder_name', null, function($vars) {
	
	$oldname = '..' . DIRECTORY_SEPARATOR . $vars['file'];
					
	$basename = basename($oldname);
	$newname = str_replace($basename, $vars['name'], $oldname);
	
	rename($oldname, $newname);
	
	$search = array('..' . DIRECTORY_SEPARATOR, DOC_FOLDER . DIRECTORY_SEPARATOR);
	$replace = array('', '');
	$url = DOC_URL . DIRECTORY_SEPARATOR . str_replace($search, $replace, $newname);
	
	return array('status' => 'success', 'message' => _t('Folder name changed Updating the page'), 'url' => $url);

	
});

#
# Hook deleted_file: hook on save/update folder name process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [name], [ip] and [time] > reffer to php's getdate() for time
#
hook('deleted_file', null, function($vars) {});

#
# Hook delete_folder: process existing folder delete request (including all files inside)
# output methods: return a array('status' => 'success' or 'error', 'message' => '', 'url' => '');
# received vars: [file]
#
hook('delete_folder', null, function($vars) {
	
	doc_delete('..' . DIRECTORY_SEPARATOR . $vars['file']);
	$url = DOC_URL;
	
	return array('status' => 'success', 'message' => _t('Folder deleted Updating the page'), 'url' => $url);

	
});

#
# Hook deleted_folder: hook on delete folder process has status success
# output methods: DO NOT OUTPUT this hook is a notifier just process incoming informations
# received vars: [file], [ip] and [time] > reffer to php's getdate() for time
#
hook('deleted_folder', null, function($vars) {});

#
# Hook ajax_[your_action]: build a hook with prefix ajax_ in the plugin to use the builtin ajax functionalities
# output methods: echo, print, printf, return, sprintf
# do an ajax call to the ajax url with these vars: &action=[your_action]&'+ $_REQUEST (post/get) and construct a hook like mentioned, it will trigger your hook when ajax call is triggered
# received vars: [$_REQUEST] - will receive all vars that are sent trough the ajax call
#
hook('ajax_*', null, function($vars) {});