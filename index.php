<?php 
include ('includes'. DIRECTORY_SEPARATOR .'functions.php');
include ('views'. DIRECTORY_SEPARATOR .'header.php');
hook('before_content');
index();
hook('after_content');
include ('views'. DIRECTORY_SEPARATOR .'footer.php');