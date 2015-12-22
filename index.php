<?php
define('path', '');

require 'inc/init.php';

$router = new Router();
$router->add('/', function(){if(file_exists('pages/install.php')){ require 'pages/install.php';}else{require 'pages/index.php';}});
$router->add('/admin(.*)', function(){require 'pages/admin/index.php';});
$router->add('/forums(.*)', function(){require 'pages/forums/index.php';});
$router->add('/mod(.*)', function(){require 'pages/mod/index.php';});
$router->add('/user(.*)', function(){require 'pages/user/index.php';});
$router->add('/login', function(){require 'pages/login.php';});
$router->add('/logout', function(){require 'pages/logout.php';});
$router->add('/profile', function(){require 'pages/profile.php';});
$router->add('/register', function(){require 'pages/register.php';});
$router->add('/404(.*)',function(){require 'pages/404.php';});
$router->run();