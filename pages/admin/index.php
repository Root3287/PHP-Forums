<?php
$user= new User();
if(!$user->isAdmLoggedIn() || !$user->data()->group == 3){
	Redirect::to('/admin/login');
}
if(file_exists('pages/install/install.php')){
	rename('pages/install/install.php', 'pages/install/install-disable.php');
}
?>
<html>
	<head>
		<?php require 'inc/templates/head.php';?>
	</head>
	<body>
		<?php require 'inc/templates/nav.php';?>
		<div class="container">
			<?php if(Session::exists('complete')):?>
			<div class="alert alert-success"><?php echo Session::flash('complete')?></div>
			<?php endif;?>
			<?php if(Session::exists('error')):?>
			<div class="alert alert-danger"><?php echo Session::flash('error')?></div>
			<?php endif;?>
			<div class="col-md-3">
				<?php include 'pages/admin/nav.php';?>
			</div>
			<div class="col-md-9">
				<div class="jumbotron">
					<h1>AdminCP</h1>
				</div>
			</div>
		</div>
		<?php require 'inc/templates/foot.php';?>
	</body>
</html>