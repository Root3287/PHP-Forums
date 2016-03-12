<?php
require 'inc/init.php';
$router = new Router();

$router->add('/', function(){
	if(file_exists('pages/install/install.php')){ 
		Redirect::to('/install');
	}else{
		require 'pages/index.php';
	}
});
$router->add('/install(.*)', function(){require 'pages/install/install.php';});

$router->add('/admin', function(){require 'pages/admin/index.php';});
$router->add('/admin/cat', function(){require 'pages/admin/cat.php';});
$router->add('/admin/addCat', function(){require 'pages/admin/addCat.php';});
$router->add('/admin/editCat(.*)', function(){require 'pages/admin/editCat.php';});
$router->add('/admin/group', function(){require 'pages/admin/group.php';});
$router->add('/admin/login', function(){require 'pages/admin/login.php';});
$router->add('/admin/settings', function(){require 'pages/admin/settings.php';});

$router->add('/forums/create/(.*)', function($cat){require 'pages/forums/create.php';});
$router->add('/forums/view/(.*)/(.*)', function($cat, $post_id){require 'pages/forums/view.php';});
$router->add('/forums/reply/(.*)/(.*)', function($cat, $post_id){require 'pages/forums/reply.php';});
$router->add('/forums/cat/(.*)', function($cat){require 'pages/forums/cat.php';});
$router->add('/forums', function(){Redirect::to('/forums/cat/');});
$router->add('/forums/', function(){Redirect::to('/forums/cat/');});

$router->add('/mod(.*)', function(){require 'pages/mod/index.php';});
$router->add('/user(.*)', function(){require 'pages/user/index.php';});
$router->add('/login', function(){require 'pages/login.php';});
$router->add('/logout', function(){require 'pages/logout.php';});
$router->add('/profile', function(){require 'pages/profile.php';});
$router->add('/register', function(){require 'pages/register.php';});
$router->add('/404(.*)',function(){require 'pages/404.php';});
$router->run();