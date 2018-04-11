<?php
require 'inc/init.php';

$router = new Router();

$router->add('/', function (){
	if(file_exists('pages/install/install.php') || !isset($GLOBALS['config'])){
		Redirect::to('/install');
	}else{
		$user = new User();
		require "pages/index.php";
	}
	return true;
});
$router->add('/install(.*)', function(){
	if(file_exists('pages/install/install.php')){
		require 'pages/install/install.php';
	}else{
		Redirect::to('/');
	}
	return true;
});

$router->add('/logout', function(){
	$user = new User();
	if($user->hasPermission("Admin")){
		$aUser = new AdminUser();
		$aUser->logout();
	}
	$user->logout();
	Session::flash("alert-success", "You have been logged out!");
	Redirect::to("/");
});

$router->add('/post/(.*)/(.*)', function($postID){
	require "pages/post.php";
	return true;
});

$router->add('/404', function(){
	require 'pages/errors/404.php';
	return true;
});

$router->add('/register/(.*)', function(){
	require 'pages/register.php';
	return true;
});
$router->add('/login/(.*)', function(){
	require 'pages/login.php';
	return true;
});

$router->add('/category/(.*)', function($cuid){
	require 'pages/category.php';
	return true;
});

$router->add('/new/post/(.*)/', function($cuid){
	require 'pages/newPost.php';
	return true;
});

$router->add('/new/reply/(.*)/', function($puid){
	require 'pages/newReply.php';
	return true;
});
if(!$router->run()){
	Redirect::to(404);
}