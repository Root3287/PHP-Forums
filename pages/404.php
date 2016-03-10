<?php 
$user = new User();
$quote = array(
	"There is no spoon!",
	"A glitch in the matrix!",
	"Fact not found!",
	"This is not the webpage you are looking for... Move on!",
	"Nothing to see here",
	"Can't touch this",
	
);
$n = rand(0,count($quote)-1);
?>
<html>
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
			<div class="row">
				<div class="jumbotron">
					<h1>404</h1>
					<h3><?php echo $quote[$n]?></h3>
					<a onClick="window.history.back()" class="btn btn-md btn-default">Go Back</a><a href="/" class="btn btn-primary btn-md">Go Home</a>
				</div>
			</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>