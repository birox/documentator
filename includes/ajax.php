<?php
	include ('functions.php');
		
	
	$action = $_REQUEST['action'];
	
	switch ($action) {
		case 'login':
		
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			hook('before_login', array($username, $password));
			
			$do_login = hook('do_login', array('username' => $username, 'password' => $password));
			
			if ($do_login == true) {
				
				// Login success 
				hook('login_success', array('username' => $username, 'password' => $password, 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => 'success', 'message' => _t('Logged in Refreshing')));
			} else {
				
				// Login failed 
				hook('login_fail', array('username' => $username, 'password' => $password, 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => 'error', 'message' => _t('Login failed')));
			}
			
			break;
		
		case 'savemd':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error'));
			}
			else {
				
				$response = hook('save_existing', array('file' => $_POST['file'], 'source' => $_POST['source']));
				
				if($response == 'success')
					hook('saved_existing', array('file' => $_POST['file'], 'source' => $_POST['source'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response));
			}
			
			break;
			
		case 'savenewmd':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error', 'message' => _t('You must be logged in to perform this action')));
			}
			else {
				
				$response = hook('save_new', array('name' => $_POST['name'], 'source' => $_POST['source'], 'folder' => $_POST['folder']));
				
				if($response['status'] == 'success')
					hook('saved_new', array('name' => $_POST['name'], 'source' => $_POST['source'], 'folder' => $_POST['folder'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response['status'], 'message' => $response['message'], 'url' => $response['url']));
				
			}
			
			break;
			
		case 'savefilename':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error', 'message' => _t('You must be logged in to perform this action')));
			}
			else {
				
				$response = hook('save_name', array('file' => $_POST['file'], 'name' => $_POST['name'], 'page' => $_POST['page']));
				
				if($response['status'] == 'success')
					hook('saved_name', array('file' => $_POST['file'], 'name' => $_POST['name'], 'page' => $_POST['page'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response['status'], 'message' => $response['message'], 'url' => $response['url']));
				
			}
		
			break;
			
		case 'deletefile':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error', 'message' => _t('You must be logged in to perform this action')));
			}
			else {
				
				$response = hook('delete_file', array('file' => $_POST['file'], 'page' => $_POST['page']));
				
				if($response['status'] == 'success')
					hook('deleted_file', array('file' => $_POST['file'], 'page' => $_POST['page'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response['status'], 'message' => $response['message'], 'url' => $response['url']));
			}
		
			break;
			
		case 'savefoldername':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error', 'message' => _t('You must be logged in to perform this action')));
			}
			else {
				
				$response = hook('save_folder_name', array('file' => $_POST['file'], 'name' => $_POST['name']));
				
				if($response['status'] == 'success')
					hook('saved_folder_name', array('file' => $_POST['file'], 'name' => $_POST['name'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response['status'], 'message' => $response['message'], 'url' => $response['url']));
				
			}
		
			break;
			
		case 'deletefolder':
		
			if(login_check() == false){
				echo json_encode(array('status' => 'error', 'message' => _t('You must be logged in to perform this action')));
			}
			else {
				
				$response = hook('delete_folder', array('file' => $_POST['file']));
				
				if($response['status'] == 'success')
					hook('deleted_folder', array('file' => $_POST['file'], 'ip' => $_SERVER['REMOTE_ADDR'], 'time' => getdate()));
				
				echo json_encode(array('status' => $response['status'], 'message' => $response['message'], 'url' => $response['url']));
			}
		
			break;
			
		case 'search':
		
			$folder = '..' . DIRECTORY_SEPARATOR . DOC_FOLDER;		
			echo urldecode(doc_find($_REQUEST['q'], $folder));
			break;
			
		case 'install':
			
			$config = '<?php
';
			
			$defines = $_POST;
			
			foreach($defines as $key => $define) {
				
				if($key == 'action')
					continue;
					
				if($key == 'DOC_PASS')
					$define = md5($define);
					
				if($key == 'DOC_URL')
					$define = rtrim($define,DIRECTORY_SEPARATOR);
					
				if($key == 'DOC_FOLDER') {
					$folder = $defines['DOC_PATH'] . DIRECTORY_SEPARATOR . $define;
					if(!file_exists($folder))
						mkdir($folder, 0777, true);
				}
				
				$config .= sprintf(
								"define('%s', '%s');
"
								, $key, $define);
				
			}
			
			$config .= '
define("DOC_CSS", serialize (
	array (
		"bootstrap.min",
		"style"
	)
));

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
define(\'PLUGIN_PATH\', DOC_PATH . DIRECTORY_SEPARATOR . \'plugins\');
define(\'PLUGIN_FOLDER\', \'plugins\');';
						
			$fullpath = $defines['DOC_PATH'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'config.php';
				
			if(file_exists($fullpath)) {
				echo json_encode(array('status' => 'error', 'message' => _t('Config file already exists')));
			}
			else {
				if(file_put_contents($fullpath,$config)!=false){
					$url = $defines['DOC_URL'] . DIRECTORY_SEPARATOR . 'login';
					echo json_encode(array('status' => 'success', 'message' => _t('Configuration saved Were going home loading'), 'url' => $url));
				}
				else {
					echo json_encode(array('status' => 'error', 'message' => _t('Error creating configuration file try later')));
				}
			}
		
			break;
			
		default:
		
			hook('ajax_'. $action, $_REQUEST);
			
	}