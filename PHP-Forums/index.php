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
		<?php include path.'assets/nav.php';?>
		<?php
			if(Session::exists('complete')){
				echo "<div class='alert alert-success'>".Session::flash('complete')."</div><br/>";
			}
			if(Session::exists('error')){
				echo "<div class='alert alert-danger'>".Session::flash('error')."</div><br/>";
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
		<?php include path.'assets/foot.php';?>
	</body>
</html>