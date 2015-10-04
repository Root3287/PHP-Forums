<?php
/*
* Timothy Gibbons
* Copyright (c) Timothy Gibbons 2015, All Rights Reserved; 
* License: MIT
*/
class Forums{
	private $_db;
	public function __construct(){
		$this->_db= db::getInstance();
	}
	public function getPost($cat = null, $post = null){
		if($cat == null && $post == null){ return $this->_db->get('post', array('1','=','1'))->results();}
		if($cat != null){
			if($post !=null){
				$post_return = $this->_db->query("SELECT * FROM post WHERE `cat_id`=? AND `id`=?", array($cat, $post))->results();
			}else{
				$post_return = $this->_db->get('post', array('cat_id','=',$cat))->results();
			}
		}
		return $post_return;
	}
	public function getPost2($post){
		return $this->_db->get('post', array('id','=',$post))->first();
	}
	public function listPost($c, $path=null){
		if($c){
			echo "<table class='table table-striped table-hover'><thead><tr><th>ID #</th><th>Name</th><th>User</th></tr></thead><tbody>";
			foreach($this->getPost($c) as $post){
				$author = new User($post->post_user);
				$author = $author->data();
				echo "<tr>
				<td>
				<a href='{$path}pages/post/view.php?c={$c}&p={$post->id}'>
				{$post->id}
				</a>
				</td>
				<td>
				<a href='{$path}pages/post/view.php?c={$c}&p={$post->id}'>
				{$post->post_title}
				</a>
				</td>
				<td>{$author->username}</td>
				</tr>";
			}
			echo "</tbody></table>";
		}else{
			$this->listCat(false, $path);
		}
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
	public function listCat($minified, $path=null){
		if($minified){
			echo '<div class="well">';
			foreach ($this->listParentCat() as $parent){
				echo "<b>{$parent['name']}</b><br>";
				foreach ($this->listChildCat($parent['id']) as $child){
					echo "<a href='{$path}pages/post/?cat={$child['id']}'>{$child['name']}</a><br/>";
				}
			}
			echo '</div>';
		}else{
			foreach ($this->listParentCat() as $parent){
				echo "<div class='panel panel-primary'><div class='panel-heading'>{$parent['name']}</div><div class='panel-body'>";
				foreach ($this->listChildCat($parent['id']) as $child){
					echo "<a href='{$path}pages/post?cat={$child['id']}'>{$child['name']}</a><br/>";
				}
				echo "</div></div>";
			}
		}
	}
	public function getReply($post = null){
		$where = ($post)? "`post_id` = {$post}": "1 = 1";
		return $this->_db->query("SELECT * FROM `reply` WHERE {$where} ORDER BY id ASC;")->results();
	}
	public function getReplyLimit($limit, $offset = '0', $post = null){
		$return = ($post)? $this->_db->query("SELECT * FROM `reply` WHERE `post_id` = {$post} LIMIT {$limit} OFFSET {$offset}")
		: $this->_db->query("SELECT * FROM `reply` LIMIT {$limit} OFFSET {$offset} ORDER BY id DESC;");
		return $return;
	}
	public function getCat($id = null){
		$where = ($id)? array('id', '=', $id): array('1','=','1');
		return $this->_db->get('cat', $where)->results();
	}
	public function getCatParent($id = null){
		$id = ($id)? " AND id={$id}":'';
		return $this->_db->query('SELECT * FROM `cat` WHERE parent IS NULL'.$id)->results();
	}
	public function createPost($fields = array()){
		if(!$this->_db->insert('post', $fields)){
			throw new Exception('There was an error inserting the data to the database.');
		}
	}
	public function createReply($fields = array()){
		if(!$this->_db->insert('reply', $fields)){
			throw new Exception('There was an error inserting the data to the database.');
		}
	}
	public function createCat($fields = array()){
		if(!$this->_db->insert('cat', $fields)){
			throw new Exception('Cannot insert cat!');
		}
	}
}
