<?php
$forums = new Forums();
$user = new User();
?>
<html>
	<head>
		<?php include 'assets/head.php';?>
	</head>
	<body>
		<?php include 'assets/nav.php';?>
		<div class="container">
			<div class="col-md-9">
				<?php 
				if(Input::exists('get')){
					if(Input::get('cat') !=null){
						$cat = $forums->getCat(Input::get('cat'));
						echo "<h1>Posts</h1>";
				 		$forums->listPost(Input::get('cat'), path);
				 	}else{
				 		echo "<h1>Categories</h1>";
				 		$forums->listCat(false, path);
				 	}
				}else{
					echo "<h1>Categories</h1>";
					$forums->listCat(false, path);
				}?>
			</div>
			<div class="col-md-3">
				<?php if($user->isLoggedIn() && Input::exists('get') && Input::get('cat')){?><br/>
				<a class="btn btn-default" href="create.php?c=<?php echo Input::get('cat')?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> New Post</a><br/>
				<?php }?>
				<h1>Other Categories</h1>
				<?php $forums->listCat(true, path);?>
			</div>
		</div>
		<?php include 'assets/foot.php'?>
	</body>
</html>