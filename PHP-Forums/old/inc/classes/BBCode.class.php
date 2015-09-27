<?php
class BBCode{
	public static function make($text){
		$source = array(
		'@\[b\](.*?)\[\/b\]@i' => '<strong>$1</strong>',
		'@\[i\](.*?)\[\/i\]@i'=> '<em>$1</em>',
		'@\[u\](.*?)\[\/u\]@i'=>'<u>$1</u>',
		'@\[img\](.*?)\[\/img\]@i'=>'<img src="$1">',
		'@\[br\]@i' => '<br/>',
		'@\[p\](.*?)\[\/p\]@i' => '<p>$1</p>',
		'@\[link=(.*?)\](.*?)\[\/link\]@i' => '<a href="$1">$2</a>'
		);
		$text = stripslashes($text);
		$text = preg_replace(array_keys($source), array_values($source),$text);
		$text = nl2br($text);
		return $text;
	}
}