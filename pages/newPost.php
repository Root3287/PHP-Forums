<?php
$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to(404);
}
$msg = "";
if(Input::exists()){
	if(Token::check(Input::get("token"))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			"title"=>[
				"required" => true,
			],
			"content"=>[
				"required" => true,
			],
		]);
		if($validate->passed()){
			$cat = Category::getCategorybyUID($cuid);
			$id = Hash::unique_length(16);
			if(DB::getInstance()->insert('posts', [
				"unique_id" => $id,
				"title" => escape(Input::get("title")),
				"content" => Input::get("content"),
				"author" => $user->data()->id,
				"date" => date("Y-m-d H:i:s"),
				"category" => $cat->data()->id,
			])){
				Redirect::to("/post/{$id}/");
			}else{
				$msg.= "failed to insert";
			}
		}else{
			foreach ($validate->errors() as $error) {
				$msg.=$error."<br>";
			}
		}
	}else{
		$msg.= "Bad token";
	}
	Session::flash("alert-danger", $msg);
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'assets/head.php';?>
	<link rel="stylesheet" href="/assets/summernote/css/summernote-bs4.css">
	<script src="/assets/summernote/js/summernote-bs4.min.js"></script>
</head>
<body>
	<?php include 'assets/nav.php';?>
	<div class="container-fluid mt-4">
		<?php if(Session::exists("alert-danger")): ?>
		<div class="alert alert-danger">
			<?php echo Session::flash("alert-danger"); ?>
		</div>
		<?php endif; ?>
		<h1>New Post</h1>
		<form action="" method="POST">
			<div class="form-group"><label for="title">Title:</label><input type="text" name="title" id="title" class="form-control"></div>
			<div class="form-group"><label for="content">Content:</label><textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea></div>
			<div class="form-group"><input type="submit" value="Submit" class="btn btn-md btn-primary"></div>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		</form>	
	</div>
	<?php include 'assets/foot.php';?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#content').summernote({
				height: 300,
				toolbar: [
        			['style', ['style']],
        			['font', ['bold', 'italic', 'underline', 'clear']],
			        // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
			        ['fontname', ['fontname']],
			        ['fontsize', ['fontsize']],
			        ['color', ['color']],
			        ['para', ['ul', 'ol', 'paragraph']],
			        ['height', ['height']],
			        ['table', ['table']],
			        ['insert', ['link', 'picture', 'hr']],
			        ['view', ['fullscreen'/*, 'codeview' */]],   // remove codeview button 
			        ['help', ['help']]
      			],
			});
		});
	</script>
</body>
</html>