<?php

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<?php include 'assets/head.php';?>
	</head>
	<body>
		<?php include 'assets/nav.php';?>
		<div class="container-fluid mt-4">
			<?php if(Session::exists("alert-success")): ?>
				<div class="alert alert-success"><?php echo Session::flash("alert-success") ?></div>
			<?php endif; ?>
			
			<div class="jumbotron">
				<h1 class="text-center">Forums</h1>
			</div>


			<!-- This is all the news / Recent post -->
			<h1>Category Title</h1>
			<div class="card-columns">
				<?php
				foreach (Category::getHomepage()->results() as $c) {
					foreach (Post::getPostinCategory($c->id)->results() as $p) {
						$p_ = new Post($p->id);
				?>
				<div class="card">
					<div class="card-body">
						<h2 class="card-title text-center"><?php echo $p->title; ?></h2>
						<h4 class="card-subtitle text-muted text-center">
							<?php $u = new User($p->author); 
							echo $u->data()->username; ?>
						</h6>
						<p class="card-text"><?php echo substr($p->content, 0, 500);?></p>
						<a href="/post/<?php echo $p->unique_id;?>/" class="card-link">View</a>
					</div>
					<div class="card-footer"><small class="text-muted"><?php if($p_->hasEdited()){?>Edited: <?php }else{ ?>Posted: <?php } ?><?php echo  $p_->getTime();?></small></div>
				</div>
				<?php
					}
				}
				?>
			</div>
		</div>

		<?php include 'assets/foot.php';?>
	</body>
</html>