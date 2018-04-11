<?php
class Post{
	private $_db, $_data;
	public function __construct($post = null){
		$this->_db = DB::getInstance();
		if($post){
			$this->_data = $this->_db->get("posts", ["id", "=", $post])->first();
		}
	}

	public static function getPostinCategory($category){
		return DB::getInstance()->get("posts", ["category", "=", $category]);
	}

	public static function getPostbyUID($uid){
		return new Post(DB::getInstance()->get("posts", ["unique_id", "=", $uid])->first()->id);
	}

	public function data(){
		return $this->_data;
	}

	public function getTime(){
		if($this->_data->last_edit){
			return $this->_data->last_edit;
		}
		return $this->_data->date;
	}

	public function hasEdited(){
		if($this->_data->last_edit){
			return true;
		}
		return false;
	}
}
?>