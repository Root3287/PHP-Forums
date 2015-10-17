<?php
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$val = new Validation();
			$validate = $val->check($_POST, array(
				'title' => array(
					'required'=>true,
					'max'=>'64',
				),
				'motd' => array(
					'max'=>'128',
				),
				'theme' => array(
					'required'=>true,
				),
			));
			
			if($validate->passed()){
				$debug = (Input::get('debug') == 'on')? 'On':'Off';
				if(Setting::update('title', Input::get('title')) && Setting::update('motd', Input::get('motd')) && Setting::update('bootstrap-theme', Input::get('theme')) && Setting::update('debug', $debug)){
					Session::flash('complete', 'You have updated the site!');
					Redirect::to('?page=settings');
				}else{
					//Session::flash('error', 'Something wrong updating this site!');
					//Redirect::to('?page=settings');
				}
			}
		}else{
			die('Not exists');
		}
	}
?>
<form action="?page=settings" method="post">
	<div class="form-group">
		<h3 data-toggle="tooltip" data-placement="right" title="This set the navigation bar, and the jumbotron title" >Forum Title</h3>
		<input type="text" class="form-control" name="title" value="<?php Setting::show('title')?>">
	</div>
	<div class="form-group">
		<h3 data-toggle="tooltip" data-placement="right" title="Just a little breif message about the server and what is current status is" >Message of the Day (MOTD)</h3>
		<input type="text" class="form-control" name="motd" value="<?php Setting::show('motd')?>">
	</div>
	<div class="form-group">
		<h3 data-toggle="tooltip" data-placement="right" title="How the website will look" >Bootstrap Theme</h3>
		<select name="theme">
			<option <?php if(Setting::get('bootstrap-theme') == 'bootstrap'):?>selected="selected"<?php endif;?> value="bootstrap">Bootstrap (Orignal)</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'cerulean'):?>selected="selected"<?php endif;?> value="cerulean">Cerulean</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'cosmo'):?>selected="selected"<?php endif;?> 	value="cosmo">Cosmo</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'cyborg'):?>selected="selected"<?php endif;?> 	value="cyborg">Cyborg</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'darkley'):?>selected="selected"<?php endif;?> 	value="darkley">Darkly</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'flatly'):?>selected="selected"<?php endif;?> 	value="flatly">Flatly</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'journal'):?>selected="selected"<?php endif;?> 	value="journal">Journal</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'lumen'):?>selected="selected"<?php endif;?> 	value="lumen">Lumen</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'paper'):?>selected="selected"<?php endif;?> 	value="paper">Paper</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'readable'):?>selected="selected"<?php endif;?> value="readable">Readable</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'sandstone'):?>selected="selected"<?php endif;?> value="sandstone">Sandstone</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'simplex'):?>selected="selected"<?php endif;?> 	value="simplex">Simplex</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'slate'):?>selected="selected"<?php endif;?> 	value="slate">Slate</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'spacelab'):?>selected="selected"<?php endif;?> value="spacelab">Spacelab</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'superhero'):?>selected="selected"<?php endif;?> value="superhero">Superhero</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'united'):?>selected="selected"<?php endif;?> 	value="united">United</option>
			<option <?php if(Setting::get('bootstrap-theme') == 'yeti'):?>selected="selected"<?php endif;?> 	value="yeti">Yeti</option>
		</select>
	</div>
	<div class="checkbox">
    		<input name="debug" id="debug" type="checkbox" <?php if(Setting::get('debug') != 'Off'){echo 'checked';}?>>
    		<label for="debug">
    		Debug mode (Not Recommended)
    		</label><br>
	</div>
	<div class="form-group">
		<input type="hidden" name="token" value="<?php echo Token::generate()?>">
		<input class="btn btn-md btn-primary" type="submit" value="update">	
	</div>
</form>
<script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>