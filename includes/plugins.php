<?php

if ($plugin_dir = opendir(PLUGIN_PATH)) {	
	$blacklist = array('.', '..');
	while (false !== ($plugin = readdir($plugin_dir))) {
		if (!in_array($plugin, $blacklist)) {
			
			if (file_exists(PLUGIN_PATH . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'index.php'))
				include (PLUGIN_PATH . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'index.php');
				
		}
	}
}