<?php
class Forums2{
	private $_db;
	
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	/**
	 * @return array
	 */
	public function getForums(){
		$where = ($id)? array('id', '=', $id): array('1','=','1');
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
}