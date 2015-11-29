<?php
$uri =$_SERVER['REQUEST_URI'];
$uri = explode('/', $uri);

$project_folder_name = "forums"; // Define where the project is stored...
$pages_folder_name = "pages/"; // Define where all the sub-pages are...

foreach ($uri as $uri_key => $uri_value){
	if($uri_value == $project_folder_name || $uri_value == ""){
		$offset = $uri_key;
	}
}

$limit = count($uri)-$offset;
$exists = false;

require_once 'inc/pages.php';

// CHeck to see if page exists
if($limit == 2){
	if(in_array($uri[$offset+1], $pages)){	// Check first 'folder'
		$exists = true;
	}else{
		if(array_key_exists($uri[$offset+1], $pages)){
			$exists = true;
			$key = true;
		}
	}
}else if($limit>2){
	if(in_array($uri[$offset+1], $pages)){	// Check first 'folder'
		$exists = true;
	}else{
		if(array_key_exists($uri[$offset+1], $pages)){
			$exists = true;
			$key = true;
		}
	}
	
	if($exists == true || !empty($uri[$offset+2])){ // Check 'second' folder
		if(in_array($uri[$offset+2], $pages[$uri[$offset+1]])){
			$exists = true;
			$key = true;
		}else{
			$exists = false;
		}
	}
	
	if(isset($uri[$offset+2][0]) && $uri[$offset+2][0] == "?"){ // get pram for GET
		$exists = true;
		$prams = true;
	}
}else{
	if(!empty($uri[$offset+3])){
		$prams = $uri[$offset+3];
	}
}

// Render page
require_once 'inc/init.php';

if($limit == 2 || empty($uri[$offset+2])){
	if(!isset($key)){
		if(!empty($uri[$offset+1])){
			require $pages_folder_name.$uri[$offset+1].'.php';
		}else{
			require $pages_folder_name.'index.php';
		}
	}
}else{
	if(!isset($key)){
		require $pages_folder_name.$uri[$offset+1].'.php';
	}else{
		if(!isset($prams)){
			require $pages_folder_name.$uri[$offset+1].'/'.$uri[$offset+2].'.php';
		}else{
			require $pages_folder_name.$uri[$offset+1].'/index.php';
		}
	}
}