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
		<div class="container">
			<?php
				if(Session::exists('complete')){
					echo "<div class='alert alert-success'>".Session::flash('complete')."</div><br/>";
				}
				if(Session::exists('error')){
					echo "<div class='alert alert-danger'>".Session::flash('error')."</div><br/>";
				}
				
				if($user->isLoggedIn()){
					
				}else{
					echo '<div class="alert alert-info">You need to <a class="alert-link" href="pages/login/index.php">login</a> or <a class="alert-link" href="pages/register">sign up</a> to get the full features of this page</div>';
				}
			?>
			<div class="jumbotron">
				<h1><?php Setting::show('front-title')?></h1><br/>
				<h3><?php Setting::show('motd')?></h3>
			</div>
			<div class="col-md-9">
			<?php 
			$forums->listCat(false, '');
			?>
			</div>
		</div>
		<?php include path.'assets/foot.php';?>
	</body>
</html>