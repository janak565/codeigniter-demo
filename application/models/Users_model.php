<?php
class Users_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	
	function user_insert($data){
		if(isset($data) && !empty($data)){	
			//inserting in users table
			 $this->db->insert('users',$data);
			return true;
		}
		else{
			return false;
		}
	}
	
	function user_update($user_id=0,$data=array()){
		//print_r($data);exit;
		if(isset($data) && !empty($data) && !empty($user_id)){
			//echo $user_id;
			$this->db->where('id',$user_id);
			$this->db->update('users',$data);
			///echo $this->db->last_query();exit;
			return $user_id;
			
		}else{
			return false;
		}
	}
	
	function fetch_user_data($limit,$start){
		$this->db->limit($limit,$start);
		$user_query = $this->db->get('users');
		if($user_query->num_rows() > 0){
			foreach($user_query->result() as  $row){
				$data[] = $row;
			}	
			return $data;
		}
		return false;
	}
	function fetch_user_data_orderbyId($id){
		$this->db->where('id',$id);
		$user_query = $this->db->get('users');
		if($user_query->num_rows() > 0){
			foreach($user_query->result() as  $row){
				$data[] = $row;
			}	
			return $data;
		}
		return false;
	}
	function check_user_record_exits(){
		$this->db->limit($limit,$start);
		$user_query = $this->db->get('users');
		if($user_query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	
	function user_record_count(){
		return $this->db->count_all('users');
	}
	function user_delete($id){
		$this->db->where('id',$id);
		$this->db->delete('users');
	}	
}
?>
