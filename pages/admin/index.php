<?php
$user= new User();
$forums = new Forums();
if(!$user->isLoggedIn() && !$user->hasPermission('Admin')){
	session::flash('error', 'You do not have access the admin page!');
	Redirect::to('/');
}
if(file_exists(path.'install/index.php')){
	rename('pages/install.php', 'pages/install-disable.php');
}
?>
<html>
	<head>
		<?php require path.'assets/head.php';?>
		<?php if(Input::get('page') == 'cat'):?>
		<style type="text/css">
		a.white{
			color: white;
		}
		</style>
		<?php endif;?>
	</head>
	<body>
		<?php require path.'assets/nav.php';?>
		<div class="container">
			<?php if(Session::exists('complete')):?>
			<div class="alert alert-success"><?php echo Session::flash('complete')?></div>
			<?php endif;?>
			<?php if(Session::exists('error')):?>
			<div class="alert alert-danger"><?php echo Session::flash('error')?></div>
			<?php endif;?>
		<div class="col-md-3">
		<div class="well">
			<a href="?page">AdminCP Home</a><br/>
			<a href="?page=settings">Setting</a><br/>
			<a href="?page=cat">Manage Forums Group</a><br/>
			<a href="?page=notification">Send Mass Notification</a><br/>
			<a href="?page=groups">Manage Groups</a><br/>
			<a href="?page=user">Manage Users</a><br/>
			<a href="?page=error">Force an error</a>
		</div>
		</div>
		<div class="col-md-9">
			<?php 
			switch (Input::get('page')){
				default:
					echo "<div class='jumbotron'><h1>AdminCP</h1></div>";
					break;
				case 'user':
					include 'user.php';
					break;
				case 'settings':
					include 'settings.php';
					break;
				case 'phpinfo':
					break;
				case 'cat':
					include 'cat.php';
					break;
				case 'groups':
					include 'group.php';
					break;
				case 'notification':
					include 'notification.php';
					break;
			}
			if(Input::get('page') == 'error'){
				include 'error.php';
			}
			?>
		</div>
		</div>
		<?php require path.'assets/foot.php';?>
		<?php if(Input::get('page') == 'notification'):?>
		<script type="text/javascript" src="../../../assets/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">CKEDITOR.replace('message');</script>
		<?php endif;?>
	</body>
</html>