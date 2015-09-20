<?php
define('path', '../../');
require path.'inc/init.php';
$forums = new Forums();
$user = new User();

if(Input::exists('get')){
	if(!$forums->getCat(escape(Input::get('c')))){
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
					$forums->createPost(array(
						'post_title' => escape(Input::get('title')),
						'cat_id' => escape(Input::get('c')),
						'post_cont' => escape(Input::get('content')),
						'post_date' => date('Y-m-d- H:i:s'),
						'post_user' => $user->data()->id,
					));
					session::flash('complete', 'You posted your post!');
					Redirect::to(path);
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
				<div class="row">
					<div class="col-xs-offset-3">
					<div class="form-group">
						<input type="button" onclick="formatText('b')" class="btn btn-md btn-default" value="Bold">
						<input type="button" onclick="formatText('i')" class="btn btn-md btn-default" value="Italic">
						<input type="button" onclick="formatText('u')" class="btn btn-md btn-default" value="Underline">
						<input type="button" onclick="formatText('br')" class="btn btn-md btn-default" value="Break">
						<input type="button" onclick="formatText('img')" class="btn btn-md btn-default" value="Image">
						<input type="button" onclick="formatText('link')" class="btn btn-md btn-default" value="link"><br/>
					</div>
					</div>
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript">
		function formatText(tag) {
		   var Field = document.getElementById('content');
		   var val = Field.value;
		   var selected_txt = val.substring(Field.selectionStart, Field.selectionEnd);
		   var before_txt = val.substring(0, Field.selectionStart);
		   var after_txt = val.substring(Field.selectionEnd, val.length);
			if(tag == "br"){Field.value += '[br]'}else if(tag == "img"){Field.value += '[img] [/img]'}else if(tag == 'link'){Field.value += '[link= ] [/link]'}else{
			  Field.value += '[' + tag + ']' + '[/' + tag + ']';
			}
		}
		</script>
	</body>
</html>