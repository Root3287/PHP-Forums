<?php 
define('path','../../');
require path.'inc/init.php';
$forums = new Forums();
$user = new User();

if(Input::exists('get')){
	$cat = (Input::get('cat') ==null)? null:Input::get('cat');
	$parent = (Input::get('parent') ==null)? null:Input::get('parent');
}else{
	$cat = null;
	$parent = null;
}
?>
<html>
<head><?php include path.'assets/head.php';?></head>
<body>
<?php include path.'assets/nav.php';?>
<?php if($parent !=null && $cat == null){$cat = $parent;}

if($cat ==null && $parent ==null){
	$forums->listCat(path);
}

if($cat !=null && $parent == null){
	foreach ($forums->getCat($cat)->results() as $cat){
		if(!$cat->parent){
			echo "<h1>{$cat->name}</h1>";
			foreach ($forums->listChildCat($cat->id) as $child){
				echo "<a href='?cat={$child['id']}&parent={$cat->id}'>{$child['name']}</a>";
			}
		}
	}
}
if($cat !=null && $parent !=null){
	echo "<a href='".path."pages/post/create.php?cat={$cat}'>Create post</a>";
	foreach ($forums->getCat($parent)->results() as $parent){
		echo "<h2><a href='?cat={$parent->id}'>{$parent->name}</a></h2>";
	}
	foreach ($forums->getCat($cat)->results() as $cat){
		echo "<h1>{$cat->name}</h1>";
	}
	$forums->listPost();
}
?>
</body>
</html>