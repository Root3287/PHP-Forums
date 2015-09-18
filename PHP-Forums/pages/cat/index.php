<?php 
define('path','../../');
require path.'inc/init.php';
if(Input::exists('get')){
	$cat = (Input::get('cat') !=null)? Input::get('cat'): null;
	$parent = (Input::get('parent') !=null)? Input::get('parent'): null;
}
?>