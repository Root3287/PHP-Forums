<?php $user = new User(); $forums= new Forums(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
		<div class="col-md-3"><?php include 'pages/admin/nav.php';?></div>
		<div class="col-md-9">
			<div class="row"><a class="btn btn-md btn-default" href="/admin/addCat"><span class="glyphicon glyphicon-plus"></span></a></div><br/>
			<?php foreach ($forums->listParentCat() as $parent):?>
			<div class="row">
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<a class="white" href="/admin/editCat?c=<?php echo $parent['id']?>"><?php echo $parent['name']?></a>
					</div>
					<div class='panel-body'>
					<?php foreach ($forums->listChildCat($parent['id']) as $child):?>
						<a href='/admin/editCat?c=<?php echo $child['id']?>'><?php echo $child['name']?></a><br/>
					<?php endforeach;?>
					</div>
				</div>
			</div>
			<?php endforeach;?>
		</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
	</body>
</html>