<?php
define('path', '../../');
include path.'inc/init.php';
$user = new User();
$db = DB::getInstance();
?>
<html>
	<head>
		<?php include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
		<div class="container">
			<?php if(Session::exists('complete')){echo "<div class='alert alert-success'>".Session::flash('complete')."</div>";}?>
			<?php if(Session::exists('error')){echo "<div class='alert alert-danger'>".Session::flash('error')."</div>";}?>
			<div class="col-md-3">
				<div class="well">
					<a href="?page=change_password">Change password</a><br/>
					<a href="?page=update">Update Infomation</a><br/>
				</div>
			</div>
			<div class="col-md-9">
				<?php switch ($_GET['page']){
					default:
						echo "<div class='jumbotron'><h1>UserCP</h1><br><h3>Click on a setting to modify your settings!</h3></div>";
						break;
					case "change_password":
						include "change_password.php";
						break;
					case "update":
						include "update.php";
						break;
				}?>
			</div>
		</div>
		<?php include path.'assets/foot.php'?>
	</body>
</html>