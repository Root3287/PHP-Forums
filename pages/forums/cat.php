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
							$author = new User($post->post_user);
						?>
						<tr>
							<td><?php echo $post->id?></td>
							<td><?php echo $post->post_title?></td>
							<td><?php echo $author->data()->username?></td>
						</tr>
						<?php
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
					foreach ($forums->getForums() as $forums){
						echo "<div class='panel panel-primary'><div class='panel-heading'>{$forums['name']}</div><div class='panel-body'>";
						foreach ($forums->getSubforums($forums['id']) as $subforums){
							echo "<a href='/forums/cat/{$subforums['id']}'>{$subforms['name']}</a><br/>";
						}
						echo "</div></div>";
					}
				}?>
			</div>
			<div class="col-md-3">
				<?php if($user->isLoggedIn() && Input::exists('get') && $cat){?><br/>
				<a class="btn btn-default" href="create.php?c=<?php echo $cat?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> New Post</a><br/>
				<?php }?>
				<h1>Other Categories</h1>
				<?php foreach ($forums->getForums() as $forums){
						echo "<div class='panel panel-primary'><div class='panel-heading'>{$forums['name']}</div><div class='panel-body'>";
						foreach ($forums->getSubforums($forums['id']) as $subforums){
							echo "<a href='/forums/cat/{$subforums['id']}'>{$subforms['name']}</a><br/>";
						}
						echo "</div></div>";
					}?>
			</div>
		</div>
		<?php require 'inc/templates/foot.php';?>
	</body>
</html>