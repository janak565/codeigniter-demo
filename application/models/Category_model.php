<?php
class Category_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	function drop_category_tree($parent = 0, $spacing = '', $user_tree_array = ''){
		if (!is_array($user_tree_array))
    		$user_tree_array = array();
		$this->db->where('parent',$parent);
		$this->db->order_by("cid", "asc");
		$category_query = $this->db->get('category');
		if($category_query->num_rows() > 0){
			foreach($category_query->result() as  $row){	
      			$user_tree_array[] = array("id" => $row->cid, "name" => $spacing . $row->name);
      			$user_tree_array = $this->drop_category_tree($row->cid, $spacing . '&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
    		}
  		}
  		return $user_tree_array;	
    }
	
	function tree_category($parent = 0, $user_tree_array = ''){
		  if (!is_array($user_tree_array))
			$user_tree_array = array();

		  //$sql = "SELECT `cid`, `name`, `parent` FROM `category` WHERE 1 AND `parent` = $parent ORDER BY cid ASC";
		  //$query = mysql_query($sql);
			$this->db->where('parent',$parent);
			$this->db->order_by("cid", "asc");
			$category_query = $this->db->get('category');
		//print_r($category_query);
		  //if (mysql_num_rows($query) > 0) {
		  if($category_query->num_rows() > 0){	  
			 $user_tree_array[] = "<ul style='list-style: none;'>";
			//while ($row = mysql_fetch_object($query)) {
			  foreach($category_query->result() as  $row){
			  $user_tree_array[] = "<li>". "|-".$row->name."</li>";
			  $user_tree_array = $this->tree_category($row->cid, $user_tree_array);
			}
			$user_tree_array[] = "</ul>";
		  }
		  return $user_tree_array;
	}	

}
?>