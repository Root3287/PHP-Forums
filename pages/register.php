<?php
$user = new User();
if($user->isLoggedIn()){
	Redirect::to("/");
}

if(Input::exists()){
	if(Token::check(Input::get("token"))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			"username" =>[
				"required" => true,
				"unique" => "users",
				"min" => 3,
				"max" => 50,
				"spaces" => false,
			],
			"email" => [
				"required" => true,
				"min" => 5,
				"unique" => "users",
				"spaces" => false,
			],
			"name"=>[
				"required" => true,
			],
			"password" => [
				"required" => true,
				"min"=>8,
				"matches"=>"confirm_password",
			],
			"confirm_password"=>[
				"required" => true,
				"matches" => "password",
			],
		]);

		$msg = "Failed creating user! <br><br>";
		if($validate->passed()){
			$salt = Hash::salt(32);
			$password = Hash::make(escape(Input::get('password')), $salt);
			try{
			$user->create([
				"username" => escape(Input::get('username')),
				"password" => $password,
				"salt" => $salt,
				"name" => escape(Input::get('name')),
				"email" => escape(Input::get('email')),
				"group" => 1,
				"joined" => date("Y-m-d H:i:s"),
			]);
			Session::flash("alert-success", "You have completely registered");
			Redirect::to("/");
			}catch(Exception $e){
				$msg.= $e->getMessage();
				Session::flash("alert-danger", $msg);
			}
		}else{
			foreach ($validate->errors() as $error) {
				$msg .= $error . "<br>";
			}

			Session::flash("alert-danger", $msg);
		}
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

			<?php if(Session::exists("alert-danger")){?>
				<div class="alert alert-danger">
					<?php echo Session::flash("alert-danger"); ?>
				</div>
			<?php } ?>
			<h1>Registration</h1>
			<form action="" method="POST" autocomplete="off">
				<div class="form-group"><label for="username">Username:</label><input id="username" name="username" type="text" class="form-control" value="<?php echo escape(Input::get("username"));?>"></div>
				<div class="form-group"><label for="email">Email:</label><input id="email" name="email" type="email" class="form-control" value="<?php echo escape(Input::get("email"));?>"></div>
				<div class="form-group"><label for="name">Name:</label><input id="name" name="name" type="text" class="form-control" value="<?php echo escape(Input::get("name"));?>"></div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group"><label for="password">Password:</label><input id="password" name="password" type="password" class="form-control"></div>
					</div>
					<div class="col-md-6">
						<div class="form-group"><label for="confirm_password">Confirm Password</label><input id="confirm_password" name="confirm_password" type="password" class="form-control"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group"><a href="/login/" class="form-control btn btn-md btn-danger">Login</a></div>
					</div>
					<div class="col-md-6">
						<div class="form-group"><input type="submit" value="Register" class="btn btn-md btn-primary form-control"></div>
					</div>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate();?>">
			</form>
		</div>
		<?php include 'assets/foot.php';?>
	</body>
</html>