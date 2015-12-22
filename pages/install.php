<?php
require '../inc/init.php';
if(!Input::exists('get')){
	$step = 'home';
}else{
	$step = Input::get('step');
}

if($step == 'dbstart'){
	$dbHelper = new DBHelper();
}

if(Input::exists()){
	$val= new Validation();
	if($step == 'settings'){
		$mysql_val = $val->check($_POST, array(
				'host'=>array(
						'required'=>true,
				),
				'port'=>array(
						'required'=>true,
				),
				'database'=>array(
						'required'=>true,
				),
				'mysql_user'=>array(
						'required'=>true,
				),
				'mysql_pass'=>array(
						
				),
				'token_name'=>array(
					'required'=>true,
				),
				'cookie_name'=>array(
					'required'=>true,
				),
				'session_name'=>array(
					'required'=>true,
				),
		));
		if($mysql_val->passed()){
			$pre_conf = 
			'<?php'.PHP_EOL.
			'$GLOBALS[\'config\'] = array('.PHP_EOL.
			'	"config"=>array("name" => "Forums"),'.PHP_EOL.
			'	"mysql" => array('.PHP_EOL.
			'		"host" => "'.escape(Input::get('host')).'",'.PHP_EOL.
			'		"user" => "'.escape(Input::get('mysql_user')).'",'.PHP_EOL.
			'		"password" => "'.escape(Input::get('mysql_pass')).'",'.PHP_EOL.
			'		"db" => "'.escape(Input::get('database')).'",'.PHP_EOL.
			'		"port" => "'.escape(Input::get('port')).'",'.PHP_EOL.
			'	),'.PHP_EOL.
			'	"remember" => array('.PHP_EOL.
			'		"expiry" => 604800,'.PHP_EOL.
			'	),'.PHP_EOL.
			'	"session" => array ('.PHP_EOL.
			'		"token_name" => "'.escape(Input::get('token_name')).'",'.PHP_EOL.
			'		"cookie_name"=>"'.escape(Input::get('cookie_name')).'",'.PHP_EOL.
			'		"session_name"=>"'.escape(Input::get('session_name')).'"'.PHP_EOL.
			'	),'.PHP_EOL.
			');'.PHP_EOL;
			if(is_writable('../inc/init.php')){
				$config = file_get_contents('../inc/init.php');
				$config = substr($config, 5);
				
				$file = fopen('../inc/init.php', 'w');
				fwrite($file, $pre_conf.$config);
				fclose($file);
				Redirect::to('?step=dbstart');
			}else{
				$config = file_get_contents('../inc/init.php');
				$config = substr($config, 5);
				session::flash('code', $pre_conf.$config);
			}
		}
	}
	
	if($step == "admin"){
		$reg_val = $val->check($_POST, array(
				'name' => array(
						'required' => true,
				),
				'username' => array(
						'required' => true,
						'min' => 2,
						'max' => 50,
						'unique' => 'users'
				),
				'email'=> array(
						'required'=> true,
						'unique' => 'users',
				),
				'password' => array(
						'required' => true,
						'min' => 8
				),
				'password_conf' => array(
						'required' => true,
						'matches'=> 'password'
				)
		));
		if(!$reg_val->passed()){
				
		}else{
			$user = new User();
				
			$salt = hash::salt(32);
				
			$password = hash::make(escape(Input::get('password')) , $salt);
				
			try{
				$user->create(array(
						'username' => escape(Input::get('username')),
						'password'=> Hash::make(escape(Input::get('password')), $salt),
						'salt' => $salt,
						'name'=> escape(Input::get('name')),
						'joined'=> date('Y-m-d- H:i:s'),
						'group'=> 1,
						'email'=> escape(Input::get('email')),
				));
				session::flash('complete', 'You set up the forums! Log back in and go to AdminCP to delete the install file!');
				Redirect::to('../index.php');
			}catch (Exception $e){
				die($e->getMessage());
			}
		}
	}
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>PHP-Forums &bull; Install</title> 
		<meta name="author" content="Timothy Gibbons">
		<meta name="copyright" content="Copyright (C) Timothy Gibbons 2015;">
		<meta name="description" content="Forums">
		<meta name="keywords" content="Forums">
		<meta charset="UTF-8">
		<link rel="stylesheet" href="<?php echo '../assets/css/cosmo.css';?>">
		<!-- Latest compiled and minified JavaScript -->
		<script src="<?php echo '../assets/js/jquery.js';?>"></script>
		<script src="<?php echo '../assets/js/bootstrap.js';?>"></script>
	</head>
	<body>
		<div class="container">
		<h1>Install</h1>
		<?php switch ($step){
			case 'home':
		?>
			
			<p>Welcome to the installation! Click Next to continue</p>
			<a class="btn btn-lg btn-primary" href="?step=settings">Next</a>
		<?php break; ?>
		<?php case "settings":?>
			<?php if(Input::exists()){if(!$mysql_val->passed()){?><div class="alert alert-danger"><?php foreach ($mysql_val->errors() as $error){echo $error.'<br/>';}?></div><?php }}?>
			<h3>Forums Settings</h3>
			<form action="?step=settings" method="post">
				<h5>Mysql Settings</h5>
				<div class="form-group">
					<input type="text" class="form-control" name="host" placeholder="Host: 127.0.0.1" value="<?php echo Input::get('host')?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="port" placeholder="Port: 3306" value="<?php echo Input::get('port')?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="database" placeholder="database: forums" value="<?php echo Input::get('database')?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="mysql_user" placeholder="User: root" value="<?php echo Input::get('mysql_user')?>">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="mysql_pass" placeholder="password: ">
				</div>
				
				<h5>Session Settings</h5>
				<div class="form-group">
					<input type="text" class="form-control" name="token_name" placeholder="Token Name" value="<?php echo Input::get('token_name')?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="cookie_name" placeholder="Cookie Name " value="<?php echo Input::get('cookie_name')?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="session_name" placeholder="Session Name " value="<?php echo Input::get('session_name')?>">
				</div>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
		<?php break;?>
		<?php case 'setting_error':?>
		<div class="alert alert-danger">Please copy and replace your inc/init.php with the new code! The server can not write to the file at the moment! Without the changes to the inc/init file the forums will not work!</div>
		<div class="well"><?php echo Session::flash('code')?></div>
		<a href="?step=admin" class="btn btn-primary">Next</a>
		<?php break;?>
		<?php case 'dbstart':?>
			<div class="alert alert-primary"><?php $dbHelper->startTables();?></div>
			<a class="btn btn-lg btn-primary" href="?step=admin">Next</a>
		<?php break;?>
		<?php case "admin":?>
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				<h3>Admin Register</h3>
				<form action="" method="post">
					<div class="form-group">
						<input name="name" value="<?php echo Input::get('name');?>" placeholder="Name" type="text" class="form-control input-lg">
					</div>
					<div class="form-group">
						<input name="username" value="<?php echo Input::get('username');?>" placeholder="username" type="text" class="form-control input-lg">
					</div>
					<div class="form-group">
						<input name="email" value="<?php echo Input::get('email');?>" placeholder="email" type="email" class="form-control input-lg">
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<input name="password" value="<?php echo Input::get('password');?>" placeholder="Password" type="password" class="form-control input-lg">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<input name="password_conf" placeholder="Confirm Password" type="password" class="form-control input-lg">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" class="btn btn-lg btn-block btn-primary" value="Register">
								<input type="hidden" name="token" value="<?php echo Token::generate();?>"/>
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php break;?>
		<?php
		}?>
		</div>
		<?php include '../assets/foot.php';?>
	</body>
</html>