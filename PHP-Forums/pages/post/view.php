<?php
define('path', '../../');
require path.'inc/init.php';

if(!Input::exists('get')){
	session::flash('error', 'There was no valid page! You have been taken back to the homepage!');
	Redirect::to(path.'index.php');
}

$cat = Input::get('c');
$post = Input::get('p');
