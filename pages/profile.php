<?php
if(!$username = Input::get('u')){
	redirect::to('/404');//MAke 404
}
$user = new User();
$user2 = new User(Input::get('u'));
if(!$user2->exists()){
	Redirect::to('/404'); // Make 404
}
?>
<html>
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
			<div class="row">
				<div class="jumbotron">
					<h1>
						<img class="img-circle" src="<?php echo $user2->getAvatarURL('96')?>">
						<?php echo $user2->data()->username?>
					</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-primary">
						<div class="panel-heading">
							More Information
						</div>
						<div class="panel-body">
							<?php if($user2->data()->private != 1):?>
								<h4><u>Signature</u></h4>
								<p><?php echo $user2->data()->signature ?></p>
								<h4><u>Email</u></h4>
								<p><?php echo $user2->data()->email?></p>
								<h4><u>Joined Date</u></h4>
								<p><?php echo $user2->data()->joined?></p>
								<h4><u>Number of posts</u></h4>
								<p></p>
							<?php else:?>
							<h3>This is a private profile</h3>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>