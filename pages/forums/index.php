<?php
$forums = new Forums();
$user = new User();
Redirect::to('/forums/cat/');
die();
?>
<html>
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
			<div class="col-md-9">
				<?php 
				if(Input::exists('get')){
					if(Input::get('cat') !=null){
						echo "<h1>Posts</h1><a href=\"/forums/create/\">Create Post</a>";
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
						<?php foreach($forums->getPost(escape(Input::get('cat'))) as $post){
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
					foreach ($forums->listParentCat() as $parent){
						echo "<div class='panel panel-primary'><div class='panel-heading'>{$parent['name']}</div><div class='panel-body'>";
						foreach ($forums->listChildCat($parent['id']) as $child){
							echo "<a href='/forums/?cat={$child['id']}'>{$child['name']}</a><br/>";
						}
						echo "</div></div>";
					}
				}?>
			</div>
			<div class="col-md-3">
				<?php if($user->isLoggedIn() && Input::exists('get') && Input::get('cat')){?><br/>
				<a class="btn btn-default" href="create.php?c=<?php echo Input::get('cat')?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> New Post</a><br/>
				<?php }?>
				<h1>Other Categories</h1>
				<?php foreach ($forums->listParentCat() as $parent){
						echo "<div class='panel panel-primary'><div class='panel-heading'>{$parent['name']}</div><div class='panel-body'>";
						foreach ($forums->listChildCat($parent['id']) as $child){
							echo "<a href='/forums/?cat={$child['id']}'>{$child['name']}</a><br/>";
						}
						echo "</div></div>";
					}?>
			</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>