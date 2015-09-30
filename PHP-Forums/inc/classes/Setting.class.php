<?php
/*
* Timothy Gibbons
* Copyright (c) Timothy Gibbons 2015, All Rights Reserved; 
* License: MIT
*/
class Setting{
	public static function get($key){
		$db = DB::getInstance();
		if($key){
			$return = $db->get('settings',array('name', '=', $key))->results();
			$return = htmlspecialchars($return[0]->value);
			return $return;
		}
	}
	public static function show($key){
		echo self::get($key);
	}
}
