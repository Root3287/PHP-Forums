<?php
define('path', '../../');
require path.'inc/init.php';
$forums = new Forums();
$user = new User();
?>
<html>
	<head>
		<?php include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
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
				<?php if($user->isLoggedIn() && Input::exists('get') && Input::get('cat')){?>
				<a class="btn btn-default" href="create.php?c=<?php echo Input::get('cat')?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> New Post</a>
				<?php }?>
				<?php $forums->listCat(true, path);?>
			</div>
		</div>
		<?php include path.'assets/foot.php'?>
	</body>
</html>