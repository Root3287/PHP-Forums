<?php 
$user = new User();
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			'username' => ['required'=> true,],
			'password'=>['required'=>true,],
		]);
		if($validate->passed()){
			if($user->admLogin(escape(Input::get('username')), escape(Input::get('password')))){
				Redirect::to('/admin');
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="col-md-offset-3 col-md-6">
			<h1>AdminCP Login</h1>
			<form action="" method="POST">
				<div class="form-group">
					<input class="form-control" type="text" name="username" value="<?php echo $user->data()->username;?>">
				</div>
				<div class="form-group"><input type="password" class="form-control" name="password"></div>
				<div class="form-group"><input type="hidden" name="token" value="<?php echo Token::generate();?>"><input type="submit" class="btn btn-primary" value="Login"></div>
			</form>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>