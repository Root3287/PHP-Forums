<?php
define('path', '../../');
require path.'inc/init.php';
$user= new User();
$forums = new Forums();
if(!Input::exists('get')){
	session::flash('error', 'There was no valid page! You have been taken back to the homepage!');
	Redirect::to(path.'index.php');
}

$post = $forums->getPost(Input::get('c'), Input::get('p'));
$post = $post[0];
$author = new User($post->post_user);
?>
<html>
	<head>
		<?php include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
		<?php if(Session::exists('error')):?>
			<div class="alert alert-danger"><?php echo Session::flash('error')?></div>
		<?php endif;?>
		<?php if(Session::exists('complete')):?>
			<div class="alert alert-success"><?php echo Session::flash('complete')?></div>
		<?php endif;?>
		<div class="container">
		<div class="row">
			<div class="col-md-9">
				<h1><?php echo  $post->post_title; ?></h1>
				<!-- USER FIRST POST -->
				<div class="panel panel-primary">
					<div class="panel-heading">
					<?php echo $post->post_title;?>
					<?php if($user->isLoggedIn()){?><a class="btn btn-xs btn-default" href="reply.php?c=<?php echo Input::get('c')?>&p=<?php echo Input::get('p');?>">Reply</a><?php }?>
					</div>
					<div class="panel-body">
					<div class="row">
					<div class="col-md-3">
						<?php echo "<img src='".$author->getAvatarURL(64)."'  class='img-circle'><br/>".$author->data()->username;?>
						<?php if($user->hasPermission('Mod')):?>
							<div class="dropdown">
			  					<button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				   				 	<span class="glyphicon glyphicon-th"></span>
			  					</button>
							  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <li><a href="#">Action</a></li>
							    <li><a href="#">Another action</a></li>
							    <li><a href="#">Something else here</a></li>
							    <li><a href="#">Separated link</a></li>
							  </ul>
							</div>
						<?php endif;?>
					</div>
					<div class="col-md-6"><?php echo $post->post_cont?></div>
					</div>
					<div class="row">
						<hr>
					</div>
					<div class="row">
						<div class="container">
						<?php echo $author->data()->signature?>
						</div>
					</div>
					</div>
				</div>
				<!-- REPLY -->
				<?php foreach ($forums->getReply(escape(Input::get('p'))) as $reply){ $author_reply = new User($reply->user_id);?>
					<div class="panel panel-info">
						<div class="panel-heading">
						<?php echo $reply->title?>
						<?php if($user->isLoggedIn()){?><a class="btn btn-xs btn-default" href="reply.php?c=<?php echo Input::get('c')?>&p=<?php echo Input::get('p');?>">Reply</a><?php }?>
						</div>
						<div class="panel-body">
							<div class="row">
							<div class="col-md-3"><?php echo "<img src='{$author_reply->getAvatarURL(64)}' class='img-circle'><br/>".$author_reply->data()->username;?></div>
							<div class="col-md-9"><?php echo $reply->content?></div>
							</div>
							<div class="row">
								<hr>
					</div>
					<div class="row">
						<div class="container">
						<?php echo $author_reply->data()->signature?>
						</div>
					</div>
						</div>
					</div>
				<?php }?>
			</div>
			<div class="col-md-3">
				<h1>Other Categories</h1>
				<?php $forums->listCat(true, path)?>
			</div>
		</div>
		</div>
		<?php include path.'assets/foot.php';?>
	</body>
</html>