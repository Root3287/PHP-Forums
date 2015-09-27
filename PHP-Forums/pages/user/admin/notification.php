<?php 
if(Input::exists()){
	if(token::check(Input::get('token'))){
		$val = new Validation();
		$validation = $val->check($_POST, array(
			'message'=>array(
				'required'=>true,
			),
		));
		if($validation->passed()){
			foreach($db->get('users', array('1','=','1'))->results() as $userAcc){
				try{Notifaction::createMessage(Input::get('message'), $userAcc->id); Session::flash('complete', 'You sent a mass message!');Redirect::to('');}catch (Exception $e){}
			}
		}
	}
}
?>
<form action="?page=notification" method="post">
 	<textarea rows="20" cols="20" name="message" id="message"></textarea>
 	<input type="hidden" name="token" value="<?php echo Token::generate()?>">
 	<div class="form-group">
 		<input class="btn btn-primary" type="submit" value="Submit">
 	</div>
</form>