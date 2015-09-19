<?php
define('path' , '');
require path.'inc/init.php';
$user = new User();
$forums = new Forums();
?>
<html>
	<head>
		<?php include path.'assets/head.php';?>
	</head>
	<body>
		<?php
			if(Session::exists('complete')){
				echo Session::flash('complete').'<br/>';
			}
			if(Session::exists('error')){
				echo session::flash('error').'<br/>';
			}
			
			if($user->isLoggedIn()){
				echo 'Welcome back '.$user->data()->username.' <a href="pages/logout/index.php">logout</a>';
				echo '<br/> Post new topic';
			}else{
				echo 'You need to <a href="pages/login/index.php">login</a> or <a href="pages/register">sign up</a> to get the full features of this page';
			}
			
		?>
		<?php 
		$forums->listCat(path);
		?>
	</body>
</html>