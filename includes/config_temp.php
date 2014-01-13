<?php 
	//----------------------------------------------------------------------------------//	
	//								COMPULSORY SETTINGS
	//----------------------------------------------------------------------------------//
	
	/*  Set the URL to your Documentator installation (without the trailing slash) */
	define('DOC_URL', '');
	define('DOC_PATH', '');
	
	/*  Set access credentials  */
	define('DOC_USER', ''); //Access Username
	define('DOC_PASS', ''); //Access Password: MD5 encrypted
	
	
	//----------------------------------------------------------------------------------//	
	//								  OPTIONAL SETTINGS
	//----------------------------------------------------------------------------------//	
	
	/*  Set documents main folder in the app (without the trailing slash)  */
	define('DOC_FOLDER', ''); //Documents folder: permission 777
	
	/*  Set logo  */
	define('DOC_LOGO', '');
	
	/*  Set Documenter App name  */
	define('DOC_NAME', '');
	
	/*  Set Documenter App name  */
	define('DOC_DESC', '');
	
	/* Set Included assets CSS files */
	define("DOC_CSS", serialize (
		array (
			"bootstrap.min",
			"style"
		)
	));
	
	/* Set Included assets JS files */
	define("DOC_JS", serialize (
		array (
			"jquery-1.10.2.min",
			"bootstrap.min",
			"jquery.cookie.min",
			"rangyinputs-jquery-1.1.2.min",
			"scripts",
			"editor"
		)
	));
		
	/*  Set Language  */
	define('DOC_LANG', '');
	
	/*  Allow download  */
	define('DOC_DOWNLOAD', '');
	
	/*  Plugins setup  */
	define('PLUGIN_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'plugins');
	define('PLUGIN_FOLDER', 'plugins');
	
	//----------------------------------------------------------------------------------//
?>