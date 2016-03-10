<?php
$user = new User();
$forums = new Forums();
?>
<html>
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
			<?php
				if(Session::exists('complete')){
					echo "<div class='alert alert-success'>".Session::flash('complete')."</div><br/>";
				}
				if(Session::exists('error')){
					echo "<div class='alert alert-danger'>".Session::flash('error')."</div><br/>";
				}
				
				if($user->isLoggedIn()){
					
				}else{
					echo '<div class="alert alert-info">You need to <a class="alert-link" href="/login">login</a> or <a class="alert-link" href="/register">sign up</a> to get the full features of this page</div>';
				}
			?>
			<div class="jumbotron">
				<h1><?php Setting::show('title')?></h1><br/>
				<h3><?php Setting::show('motd')?></h3>
			</div>
			<div class="col-md-9">
			<?php 
			if(!$forums->getCat()){echo '<div class="alert alert-info">There is no categoies at this time please contact an administrator!</div>';}else{
					foreach ($forums->listParentCat() as $parent){
						echo "<div class='panel panel-primary'><div class='panel-heading'>{$parent['name']}</div><div class='panel-body'>";
						foreach ($forums->listChildCat($parent['id']) as $child){
							echo "<a href='/forums/cat/{$child['id']}'>{$child['name']}</a><br/>";
						}
						echo "</div></div>";
					}
				}
			?>
			</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>