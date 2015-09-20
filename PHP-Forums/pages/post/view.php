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
		<div class="col-md-9">
			<h1><?php echo  $post->post_title; ?></h1>
			<!-- USER FIRST POST -->
			<div class="panel panel-primary">
				<div class="panel-heading">
				<?php echo $post->post_title;?>
				<?php if($user->isLoggedIn()){?><a class="btn btn-xs btn-default" href="reply.php?c=<?php echo Input::get('c')?>&p=<?php echo Input::get('p');?>">Reply</a><?php }?>
				</div>
				<div class="panel-body">
				<div class="col-md-3"><?php echo $author->data()->username;?></div>
				<div class="col-md-6"><?php echo BBCode::make($post->post_cont);?></div>
				</div>
			</div>
			<!-- REPLY -->
			<?php foreach ($forums->getReply(escape(Input::get('p'))) as $reply){ $author_reply = new User($reply->user_id); $author_reply=$author_reply->data();?>
				<div class="panel panel-info">
					<div class="panel-heading">
					<?php echo $reply->title?>
					<?php if($user->isLoggedIn()){?><a class="btn btn-xs btn-default" href="reply.php?c=<?php echo Input::get('c')?>&p=<?php echo Input::get('p');?>">Reply</a><?php }?>
					</div>
					<div class="panel-body">
						<div class="col-md-3"><?php echo $author_reply->username;?></div>
						<div class="col-md-9"><?php echo BBCode::make($reply->content);?></div>
					</div>
				</div>
			<?php }?>
		</div>
		<div class="col-md-3">
			<h1>Other Categories</h1>
			<?php $forums->listCat(true, path)?>
		</div>
		<?php include path.'assets/foot.php';?>
	</body>
</html>