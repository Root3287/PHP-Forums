<?php
class Category{
	private $_db, $_category, $_data, $_parent = null;
	public function __construct($cat = null){
		$this->_db = DB::getInstance();
		if($cat){
			$this->_category = $cat;
			$this->_data = $this->_db->get("category", ["id", "=", $cat])->first();
			$this->_parent = $this->_data->parent;
		}
	}
	public function isParent(){
		return ($this->_parent != null || self::getChildren()->count() > 0)? true:false;
	}	
	public function getChildren(){
		return $this->_db->get("category", ["parent", "=", $this->_category]);
	}
	public function data(){
		return $this->_data;
	}

	public static function getCategorybyUID($cuid){
		$q = DB::getInstance()->get("category", ["unique_id", "=", $cuid]);
		if($q->count()){
			return new Category($q->first()->id);
		}
		return false;
	}
	public static function getCategory(){
		return DB::getInstance()->get("category", ["1", "=", "1"]);
	}
	public static function getParents(){
		return DB::getInstance()->get("category", ["parent", "IS", null]);
	}
	public static function getHomepage(){
		return DB::getInstance()->get("category", ["homepage","=","1"]);
	}
}
?>