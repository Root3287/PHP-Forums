<?php
class Forums{
	private $_db;
	public function __construct(){
		$this->_db= db::getInstance();
	}
	public function getPost($cat = null, $post = null){
		if($cat == null && $post == null){ return $this->_db->get('post', array('1','=','1'));}
		$post = ($post !=null)? $this->_db->query("SELECT * FROM `post` WHERE `id`={$post} AND `cat_id`={$cat}")->results():$this->_db->get('post', array('cat_id', '=',$cat));
		return $post;
	}
	public function listPost($group_id) {
		
	}
	public function listParentCat($group_id = null) {
		$cats = $this->_db->query('SELECT * FROM cat WHERE parent IS NULL')->results();
		$return = array();
		$i= 0;
		foreach($cats as $cat){
			$return[$i]['id'] = $cat->id;
			$return[$i]['parent'] = null;
			$return[$i]['name'] = $cat->name;
			$return[$i]['desc'] = $cat->description;
			$i++;
		}
		return $return;
	}
	public function listChildCat($parent){
		$qcat = $this->_db->query("SELECT * FROM cat WHERE parent IS NOT NULL AND parent = {$parent}")->results();
		$return = array();
		$i = 0;
		foreach($qcat as $scat){
			$return[$i]['id'] = $scat->id;
			$return[$i]['parent'] = $scat->parent;
			$return[$i]['name'] = $scat->name;
			$return[$i]['desc'] = $scat->description;
			$i++;
		}
		return $return;
	}
	public function listCat($path){
		foreach ($this->listParentCat() as $parent){
			echo "<h1><a href='{$path}pages/cat/?cat={$parent['id']}'>{$parent['name']}</h1>";
			foreach ($this->listChildCat($parent['id']) as $child){
				echo "<a href='{$path}pages/cat/?cat={$child['id']}&parent={$parent['id']}'>{$child['name']}</a><br/>";
			}
		}
	}
	public function createPost($fields = array()){
		if($this->_db->insert('posts', $fields)){
			throw new Exception('There was an error inserting the data to the database.');
		}
	}
}