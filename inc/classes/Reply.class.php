<?php
class Reply{
	private $_db, $_data;
	public function __construct($id = null){
		$this->_db = DB::getInstance();
		if($id){
			$this->_data = $this->_db->get("reply", ["id", "=", $id])->first();
		}
	}

	public static function getReplybyPID($id){
		return nDB::getInstance()->get("reply", ["pid", "=", $id])->results();
	}
	public static function getReplysbyPUID($uid){
		$id = Post::getPostbyUID($uid)->data()->id;
		$d = DB::getInstance()->get("reply", ["pid", "=", $id]);
		return $d->results(); 
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