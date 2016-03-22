<?php
$user =new User();
$forums = new Forums();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php require 'inc/templates/nav.php';?>
		<div class="container">
		<?php if(Session::exists('error')):?>
			<div class="alert alert-danger"><?php echo Session::flash('error')?></div>
		<?php endif;?>
		<?php if(Session::exists('complete')):?>
			<div class="alert alert-success"><?php echo Session::flash('complete')?></div>
		<?php endif;?>

			<div class="col-md-9">
				<?php 
				if($cat){
					if($cat !=null){
						echo "<h1>Posts</h1><a href=\"/forums/create/$cat\">Create Post</a>";
				?>
				<table class='table table-striped table-hover'>
					<thead>
						<tr>
							<th>ID #</th>
							<th>Name</th>
							<th>User</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($forums->getPost(escape($cat)) as $post){
							if($post->reply =="false"){
							$author = new User($post->post_user);
						?>
						
						<tr>
							<td><a href="/forums/view/<?php echo $post->cat_id;?>/<?php echo $post->id;?>"><?php echo $post->id?></a></td>
							<td><a href="/forums/view/<?php echo $post->cat_id;?>/<?php echo $post->id;?>"><?php echo $post->post_title?></a></td>
							<td><?php echo $author->data()->username?></td>
							</a>
						</tr>
						<?php
						}
						}
						?>
					</tbody>
				</table>
				<?php
				 	}else{
				 		Redirect::to('/forums');
				 	}
				}else{
					echo "<h1>Categories</h1>";
					foreach ($forums->getForums() as $parent){
						if($parent->Subcat == "false"){
							echo "<div class='panel panel-primary'><div class='panel-heading'>{$parent->name}</div><div class='panel-body'>";
							foreach ($forums->getSubforums($parent->id) as $child){
								echo "<a href='/forums/cat/{$child->id}'>{$child->name}</a><br/>";
							}
							echo "</div></div>";
						}
					}

				}?>
			</div>
			<div class="col-md-3">
				<?php if($user->isLoggedIn() && Input::exists('get') && $cat){?><br/>
				<a class="btn btn-default" href="create.php?c=<?php echo $cat?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> New Post</a><br/>
				<?php }?>
				<h1>Other Categories</h1>
				<?php foreach ($forums->getForums() as $parent){
						if($parent->Subcat == "false"){
							echo "<div class='well'><strong>{$parent->name}</strong><br>";
							foreach ($forums->getSubforums($parent->id) as $child){
								echo "<a href='/forums/cat/{$child->id}'>{$child->name}</a><br/>";
							}
							echo "";
						}
					}
?>
			</div>
		</div>
		<?php require 'inc/templates/foot.php';?>
	</body>
</html>