<?php
class Upload_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	
	function do_upload($config,$image){
		$this->load->library('upload',$config);
		if(!($this->upload->do_upload($_FILE))){
			return $error = array('error'=>$this->upload->display_error());
		else{
			return  $data = array('upload_image'=>$this->upload->data());
		}
	}

	function delete_image($file_name){
		if(isset($file_name) && !empty($file_name)){
			if(file_exits('upload/'.$file_name)){
				unlink('upload/'.$file_name)
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
?>	