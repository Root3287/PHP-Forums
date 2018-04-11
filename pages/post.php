<?php
$post = Post::getPostbyUID(escape($postID));
$post_author = new User($post->data()->author);
$reply = Reply::getReplysbyPUID($postID);
$category = new Category($post->data()->category);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'assets/head.php';?>
	</head>
	<body>
		<?php include 'assets/nav.php';?>
		<div class="container-fluid mt-4">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/">Home</a></li>
			    <li class="breadcrumb-item" aria-current="page"><a href="/category/">Category</a></li>
			    <li class="breadcrumb-item" aria-current="page"><a href="/category/<?php echo $category->data()->unique_id; ?>"><?php echo $category->data()->name; ?></a></li>
			    <li class="breadcrumb-item active"><?php echo $post->data()->title; ?></li>
			  </ol>
			</nav>

			<h1><?php echo $post->data()->title;?></h1>

			<div class="row">
				<!--<div class="col-md-3"></div>-->
				<div class="col-md-12">
					
					<div class="card border-primary my-3">
						<div class="card-header"><?php echo $post->data()->title; ?></div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-9">
									<?php
									echo $post->data()->content;
									?>
								</div>
								<div class="col-md-3 text-center">
									<h3><?php echo $post_author->data()->username;?> <span class="badge rounded badge-danger">Rank</span></h3>
									<img class="img-fluid rounded-top" src="<?php echo $post_author->getAvatarURL(200);?>" alt="">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="text-right">
								<?php if($post->hasEdited()){echo "Last Edited: ";}else{echo "Posted: ";}echo $post->getTime();?>
							</div>
						</div>
					</div>

				<?php
				foreach($reply as $r){
					$rD = new Reply($r->id);
					$r_author = new User($rD->data()->author);
				?>
				<div class="card my-3" id="<?php echo $rD->data()->unique_id; ?>">
					<div class="card-header"><?php echo $rD->data()->title;?></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-9">
								<?php
								echo $rD->data()->content;
								?>
							</div>
							<div class="col-md-3 text-center">
								<h3><?php echo $r_author->data()->username;?> <span class="badge rounded badge-danger">Rank</span></h3>
								<img class="img-fluid rounded-top" src="<?php echo $r_author->getAvatarURL(200);?>" alt="">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
							<?php if($rD->hasEdited()){echo "Last Edited: ";}else{echo "Posted: ";}echo $rD->getTime();?>
						</div>
					</div>
				</div>
				<?php }?>
				<?php if($user->isLoggedIn()): ?><a href="/new/reply/<?php echo $post->data()->unique_id; ?>/" class="btn btn-outline-primary btn-md float-right">Reply</a><?php endif; ?>
				</div>
			</div>
		</div>
		<?php include 'assets/foot.php';?>
	</body>
</html>