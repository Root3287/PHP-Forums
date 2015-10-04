<div class="row"><a class="btn btn-md btn-default" href="addCat.php"><span class="glyphicon glyphicon-plus"></span></a></div>
<?php foreach ($forums->listParentCat() as $parent):?>
<div class="row">
<div class='panel panel-warning'>
	<div class='panel-heading'>
		<a href="editCat.php?c=<?php echo $parent['id']?>"><?php echo $parent['name']?></a>
	</div>
	<div class='panel-body'>
	<?php
	foreach ($forums->listChildCat($parent['id']) as $child):
	?>
		<a href='editCat.php?c=<?php echo $child['id']?>'><?php echo $child['name']?></a><br/>
	<?php endforeach;?>
	</div>
</div>
</div>
<?php endforeach;?>