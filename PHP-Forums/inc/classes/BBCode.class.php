<?php
class BBCode{
	public static function make($text){
		$source = array(
		'/\[b\](.+?)\[\/b\]/i' => '<strong>$1</strong>',
		'/\[i\](.+?)\[\/i\]/i'=> '<em>$1</em>',
		'/\[u\](.+?)\[\/u\]/i'=>'<u>$1</u>',
		'/\[img\](.+?)\[\/img\]/i'=>'<img src="$1">',
		'/\[br\]' => '<br/>/i',
		'/\[p\](.+?)\[\/p\]/i' => '<p>$1</p>',
		
		);
		return preg_replace(array_key($source), array_values($source), $text);
	}
}