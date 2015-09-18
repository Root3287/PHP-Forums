<?php
define('path', '../../');
require path.'inc/init.php';

$user = new User();

if(!$user->isLoggedIn()){
	Session::flash('error', 'It seems you are not logged in!');
	Redirect::to(path.'index.php');
}
?>
<html>
	<head>
	</head>
	<body>
		<form action="" method="post">
		</form>
	</body>
</html>