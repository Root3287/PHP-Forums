<?php
$forums = new Forums();
$user = new User();

if(Input::exists('get')){
	if(!$forums->getCat(escape(Input::get('c')))){
		Redirect::to('/404'); // TODO MAKE 404
	}
}else{
	Redirect::to('/404'); //TODO: MAKE 404
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
						'cat_id' => escape(Input::get('c')),
						'post_cont' => Input::get('content'),
						'post_date' => date('Y-m-d- H:i:s'),
						'post_user' => $user->data()->id,
					));
					$db= DB::getInstance();
					$post = $db->get('post',array('1','=','1'))->count();
					$post = $post;
					session::flash('complete', 'You posted your post!');
					Redirect::to("/forums/view.php?c=".Input::get('c')."&p=".$post);		
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
	<?php Include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
		<div class="container">
		<div class="row">
		<div class="col-md-9">
			<h1>New Post</h1>
			<form action="" method="post">
				<div class="form-group">
					<input name="title" type="text" placeholder="Title" class="form-control input-lg">
				</div>
				<div class="form-group">
					<textarea placeholder="Content" name="content" id="content" rows="21" cols="50" class="form-control"></textarea>
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
			<?php $forums->listCat(true, path)?>
		</div>
		</div>
		</div>
		<?php include path.'assets/foot.php';?>
		<script type="text/javascript" src="<?php echo path ?>assets/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
			CKEDITOR.replace('content');
		</script>
	</body>
</html>