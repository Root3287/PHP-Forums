<?php
define('path', '../../');
require path.'inc/init.php';
$forums = new Forums();
$user = new User();

if(Input::exists('get')){
	if(!$forums->getPost(escape(Input::get('c')),escape(Input::get('p')))){
		die();//Redirect::to(path.'404.php') // TODO MAKE 404
	}
}else{
	die();//Redirect::to(path.'404.php'); //TODO: MAKE 404
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
					$forums->createReply(array(
						'title' => escape(Input::get('title')),
						'post_id' => escape(Input::get('p')),
						'content' => Input::get('content'),
						'date' => date('Y-m-d- H:i:s'),
						'user_id' => $user->data()->id,
					));
					Notifaction::createMessage($user->data()->username.' posted a reply on your page', $forums->getPost2(Input::get('p'))->post_user);
					session::flash('complete', 'You posted your reply!');
					Redirect::to('view.php?c='.Input::get('c').'&p='.Input::get('p'));
				}catch (Exception $e){
					die($e->getMessage());
				}
			}else{
				echo 'val not passed';
			}
		}else{
			die('token failed');
		}
	}else{
		die('submit');
	}
}
?>
<html>
	<head>
	<?php Include path.'assets/head.php';?>
	</head>
	<body>
		<?php include path.'assets/nav.php';?>
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
					<input class="btn btn-lg btn-block btn-primary" name="Submit" type="submit" value="Submit">
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<h1>Other Categories</h1>
			<?php $forums->listCat(true, path)?>
		</div>
		<?php include path.'assets/foot.php';?>
		<script type="text/javascript" src="<?php echo path?>assets/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
		$(CKEDITOR.replace('content'));
		</script>
	</body>
</html>