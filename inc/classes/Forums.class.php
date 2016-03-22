<?php
class Forums{
	private $_db;
	
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	/**
	 * @return array
	 */
	public function getForums($id = null){
		$where = ($id)? array('id', '=', $id) : array('1','=','1');
		return $this->_db->get('cat', $where)->results();
	}

	/**
	 * @param  int
	 * @return array
	 */
	public function getForumsSettings($forums = null){
		$where = ($forums)? ['cat_id', '=', escape($forums)]: ['1','=','1'];
		return $this->_db->get('forums_settings', $where)->results();
	}

	/**
	 * @return array
	 */
	public function getSubforums($forums_id = null){
		$where = ($forums_id)? ['parent', '=', escape($forums_id)]: ['Subcat', '=', 'true'];
		return $this->_db->get('cat', ['Subcat', '=', 'true'])->results();
	}
	/**
	 * get a post
	 * @param  int 	  $cat category id for everything in that category   
	 * @param  int    $id  post id for everything for that post
	 * @return array       the sql query results
	 */
	public function getPost($cat = null, $id = null){
		if(!$cat){ //Do we want every post
			return $this->_db->get('post', ['1','=','1'])->results();
		}else{
			if(!$id){ // Do we want every post in that category
				return $this->_db->get('post', ['cat_id','=',escape($cat)])->results();
			}else{
				return $this->_db->query("SELECT * FROM `post` WHERE cat_id = ".escape($cat)." AND id=".escape($id))->results();
			}
		}
	}
	/**
	 * get the reply of a user
	 * @param  int    $op orignal post id
	 * @return array      return a sql query results
	 */
	public function getReply($op = null){
		$where =($op)? "AND orignal_post = $op": "";
		return $this->_db->query("SELECT * FROM `post` WHERE `reply`=? $where", ['true'])->results();
	}

	/**
	 * Create a post
	 * @param  array  $fields what to insert
	 * @return null           continue on
	 */
	public function createPost($fields = array()){
		if(!$this->_db->insert('post', $fields)){
			throw new Exception('There was an error inserting the data to the database.');
		}
	}
	/**
	 * create a reply
	 * @param  array  $fields inserts
	 * @return null           throw exeception
	 */
	public function createReply($fields = array()){
		if(!$this->_db->insert('reply', $fields)){
			throw new Exception('There was an error inserting the data to the database.');
		}
	}
	/**
	 * create a category
	 * @param  array  $fields inserts
	 * @return null           throws an exception
	 */
	public function createCat($fields = array()){
		if(!$this->_db->insert('cat', $fields)){
			throw new Exception('Cannot insert cat!');
		}
	}
}