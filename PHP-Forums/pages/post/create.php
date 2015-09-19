<?php
define('path', '../../');
require path.'inc/init.php';
$forums = new Forums();
$user = new User();

if(Input::exists('get')){
	if(!$forums->getCat(escape(Input::get('c')))->count()){
		die();//Redirect::to(path.'404.php') // TODO MAKE 404
	}
}else{
	die();//Redirect::to(path.'404.php'); //TODO: MAKE 404
}

if(!$user->isLoggedIn()){
	Session::flash('error', 'It seems you are not logged in!');
	Redirect::to(path.'index.php');
}

if(Input::exists() && Input::get('Submit')){
	if(Token::check(Input::get('token'))){
		$val = new Validation();
		$validate = $val->check($_POST, array(
			'title' => array(
					'required' => true,
			),
			'content' => array(
					'required' => true,
			)
		));
		if($validate->passed()){
			try{
				$forums->createPost(array(
					'post_title' => escape(Input::get('title')),
					'cat_id' => escape(Input::get('c')),
					'post_cont' => escape(Input::get('content')),
					'post_date' => date('Y-m-d- H:i:s'),
					'post_user' => $user->getGroupId(),
				));
			}catch (Exception $e){
				die($e->getMessage());
			}
		}else{
			echo 'val not passed';
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
		<?php if(Input::exists()){
			if(Input::get('preview')){
			echo BBcode::make(escape(Input::get('content')));
		}}?>
		<form action="" method="post">
			<input type="text" name="title"><br>
			<input type="button" onclick="formatText('b')" value="Bold">
			<input type="button" onclick="formatText('i')" value="Italic">
			<input type="button" onclick="formatText('u')" value="Underline">
			<input type="button" onclick="formatText('br')" value="Break">
			<input type="button" onclick="formatText('img')" value="Image">
			<input type="button" onclick="formatText('link')" value="link"><br/>
			<textarea name="content" id="content" rows="21" cols="50"></textarea><br/>
			<input type="hidden" name="token" value="<?php echo Token::generate()?>"><input name="submit" type="submit" value="Submit"><input name="preview" type="submit" value="Preview">
		</form>
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