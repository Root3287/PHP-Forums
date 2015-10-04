<?php
define('path', '../../');
require path.'inc/init.php';
if(!$username = Input::get('u')){
	die();//MAke 404
}
$user = new User();
$user2 = new User(Input::get('u'));
if(!$user2->exists()){
	die(); // Make 404
}
?>
<html>
	<head>
		<?php include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
		<div class="container">
			<div class="jumbotron">
				<h1>
					<img class="img-circle" src="<?php echo $user2->getAvatarURL('96')?>">
					<?php echo $user2->data()->username?>
				</h1>
			</div>
		</div>
		<?php include path.'assets/foot.php'?>
	</body>
</html>