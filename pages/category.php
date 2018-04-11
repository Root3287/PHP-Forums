<?php
$user = new User();
if($cuid){
	$cuid = escape($cuid);
	$category = Category::getCategorybyUID($cuid);
	if(!$category){
		Redirect::to(404);
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'assets/head.php';?>
	</head>
	<body>
		<?php include 'assets/nav.php';?>
		<div class="container-fluid mt-5">

			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/">Home</a></li>
			    <li class="breadcrumb-item <?php if(!$cuid):?>active<?php endif;?>"><?php if($cuid): ?><a href="/category/"><?php endif;?>Category <?php if($cuid):?></a><?php endif; ?></li>
			   
			    <?php if($cuid): ?>
			    <li class="breadcrumb-item active" aria-current="page"><?php echo $category->data()->name; ?></li>
				<?php endif; ?>
			  </ol>
			</nav>

		<?php if(!$cuid): ?>

			<div class="card-columns">
				<?php foreach(Category::getParents()->results() as $category): $cat = new Category($category->id); ?>
				<div class="card border-dark">
					<div class="card-body">
						<h4 class="card-title text-center"><?php echo $cat->data()->name; ?></h4>
						<h4 class="card-subtitle mb-2 text-muted"><?php echo $cat->data()->description; ?></h4>
					</div>
					<ul class="list-group list-group-flush">
						<?php foreach ($cat->getChildren()->results() as $children): $child = new Category($children->id);?>
    					<li class="list-group-item">
    						<h5 class="card-title">
    							<a href="/category/<?php echo $child->data()->unique_id; ?>" class="card-link">
    								<?php echo $child->data()->name; ?>
    							</a>
    						</h5>
    						<h5 class="card-subtitle mb-2 text-muted"><?php echo $child->data()->description; ?></h5>
    					</li>
    					<?php endforeach; ?>
  					</ul>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php else:?>
		<?php if($user->isLoggedIn()): ?>
		<div class="float-right mb-4">
			<a href="/new/post/<?php echo $category->data()->unique_id; ?>/" class="btn btn-md btn-outline-primary">New Post</a>
		</div>
		<?php endif; ?>
		<!-- <div class="table-responsive-s"> -->
		<table class="table mt-5 table-hover table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach(Post::getPostinCategory($category->data()->id)->results() as $cat): $post = new Post($cat->id); ?>
					<tr>
						<td><a href="/post/<?php echo $post->data()->unique_id; ?>/"><?php echo $post->data()->title; ?></a></td>
						<td><?php $u = new User($post->data()->author); echo $u->data()->username; ?></td>
						<td><?php if($post->hasEdited()){echo "Last Edited: ";}else{echo "Posted: ";}echo $post->getTime();?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php include 'assets/foot.php';?>
	</body>
</html>