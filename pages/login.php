<?php
$user = new User();
if($user->isLoggedIn()){
	Redirect::to("/");
}
if (Input::exists()) {
	if(Token::check(Input::get("token"))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			"username" => [
				"required" => true,
			],
			"password" => [
				"required" => true,
			],
		]);

		if($validate->passed()){
			if($user->login(escape(Input::get('username')), escape(Input::get('password')), (Input::get('remember')? true:false))){
				Session::flash("alert-success", "You have been logged in!");
				Redirect::to("/");
			}else{
				Session::flash("alert-danger", "Unknown username/password!");
			}
		}else{
			$msg = "";
			foreach ($validate->errors() as $error) {
				$msg .= $error . "<br>";
			}

			Session::flash("alert-danger", $msg);
		}
	}else{
		die("Bad token");
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
		<div class="container-fluid">
			<?php if(Session::exists("alert-danger")){?>
				<div class="alert alert-danger">
					<?php echo Session::flash("alert-danger"); ?>
				</div>
			<?php } ?>
			<h1>Login</h1>
			<form action="" method="post" autocomplete="off">
				<div class="form-group"><label for="username">Username:</label><input type="text" name="username" id="username" class="form-control" value="<?php echo escape(Input::get("username"));?>"></div>
				<div class="form-group"><label for="password">Password:</label><input type="password" name="password" id="password" class="form-control"></div>
				<div class="form-check">
					<label for="remember" class="form-check-label">
						<input id="remember" name="remember" class="form-check-input" type="checkbox" >
						Remember Me
					</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<a href="/register/" class="form-control btn btn-md btn-danger">Register</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" value="Login" class="form-control btn btn-md btn-primary">
						</div>
					</div>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			</form>
		</div>
		<?php include 'assets/foot.php';?>
	</body>
</html>