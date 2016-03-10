<?php
$forums = new Forums();
$user = new User();
if(!$forums->getCat(escape($cat))){
	Redirect::to('/404'); // TODO MAKE 404
}

if(!$user->isLoggedIn()){
	Session::flash('error', 'It seems you are not logged in!');
	Redirect::to(path.'index.php');
}

if(Input::exists()){
	if(Input::get('Submit')){
		if(Token::check(Input::get('token'))){
			$val = new Validation();
			$validate = $val->check($_POST, array(
				'title' => array(
						'required' => true,
				),
				'content' => array(
						'required' => true,
				),
			));
			if($validate->passed()){
				try{
					$forums->createPost(array(
						'post_title' => escape(Input::get('title')),
						'cat_id' => escape($cat),
						'post_cont' => Input::get('content'),
						'post_date' => date('Y-m-d- H:i:s'),
						'post_user' => $user->data()->id,
					));
					$db= DB::getInstance();
					$post = $db->get('post',array('1','=','1'))->count();
					$post = $post;
					session::flash('complete', 'You posted your post!');
					Redirect::to("/forums/view/".escape($cat)."/".$post);		
				}catch (Exception $e){
					die($e->getMessage());
				}
			}else{
			}
		}else{
		}
	}
}
?>
<html>
	<head>
	<?php Include 'inc/templates/head.php';?>
	</head>
	<body>
		<?php include 'inc/templates/nav.php';?>
		<div class="container">
		<div class="row">
		<div class="col-md-9">
			<h1>New Post</h1>
			<form action="" method="post">
				<div class="form-group">
					<input name="title" type="text" placeholder="Title" class="form-control input-lg">
				</div>
				<div class="form-group">
					<textarea placeholder="Content" name="content" id="content" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<input type="hidden" name="token" value="<?php echo Token::generate()?>">
					<br/>
					<input class="btn btn-lg btn-block btn-primary" name="Submit" type="submit" value="Submit">
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<h1>Other Categories</h1>
			<?php foreach ($forums->listParentCat() as $parent){
						echo "<div class='well'><b>{$parent['name']}</b><br>";
						foreach ($forums->listChildCat($parent['id']) as $child){
							echo "<a href='/forums/cat/{$child['id']}'>{$child['name']}</a><br/>";
						}
						echo "</div>";
					}?>
		</div>
		</div>
		</div>
		<?php include 'inc/templates/foot.php';?>
		<script type="text/javascript" src="/assets/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
			CKEDITOR.replace('content');
		</script>
	</body>
</html>