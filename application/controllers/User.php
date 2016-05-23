<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __contruct(){
		parent::__contruct();
		//$this->load->helper('url');
		$this->load->library('upload');
		$this->load->model('Upload_model');
	}
	
	public function index(){
		
		//load library and models
		$this->load->library('upload');
		$this->load->model('Upload_model');
		$user_id = 0;
		$user_id = $this->input->get('id', true);

		//initialize variable and array
		$userDataArr = array();
		
		
		
		//set rules for registration form
			$this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|max_length[10]');
			$this->form_validation->set_rules('last_name','Last Name','trim|required|min_length[1]|max_length[100]');
		if(empty($user_id)){
			$this->form_validation->set_rules('user_name','User Name','trim|required|min_length[1]|max_length[100]|valid_email');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[8]|max_length[16]');
		}	
			$this->form_validation->set_rules('phone','Phone Number','trim|required|numeric|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('general','General','required');
		if(empty($user_id)){
			if (empty($_FILES['photo']['name']))
			{
				$this->form_validation->set_rules('photo','Upload Image','required');
			}
		}	
		//value set in UserDataArr
		$userDataArr['data']['first_name'] 	 = 	$this->input->post('first_name',true);
		$userDataArr['data']['last_name'] 	 = 	$this->input->post('last_name',true);
		if(empty($user_id)){
			$userDataArr['data']['user_name']    = 	$this->input->post('user_name',true);
			$userDataArr['data']['password']     = 	$this->input->post('password',true);
		}	
		$userDataArr['data']['phone'] 	 	 = 	$this->input->post('phone',true);
		$userDataArr['data']['general']      = 	$this->input->post('general',true);
		//$userDataArr['data']['avatar']       = 	$this->input->post('photo',true);
		$user_id = $this->input->get('id', true);
		//check validation
		if(isset($user_id) && !empty($user_id)){
			$user_data_array = $this->Users_model->fetch_user_data_orderbyId($user_id);
			if(isset($user_data_array) && !empty($user_data_array)){
				$userArr['data']['id']			 =	$user_data_array[0]->id;
				$userArr['data']['first_name'] 	 = 	$user_data_array[0]->first_name;
				$userArr['data']['last_name'] 	 = 	$user_data_array[0]->last_name;
				$userArr['data']['user_name']    = 	$user_data_array[0]->user_name;
				$userArr['data']['password']     = 	$user_data_array[0]->password;
				$userArr['data']['phone'] 	 	 = 	$user_data_array[0]->phone;
				$userArr['data']['general']      = 	$user_data_array[0]->general;
				$userArr['data']['photo']        = 	$user_data_array[0]->avatar;
			}		
		}
		$this->load->view('header');
		if($this->form_validation->run()==false){
			if(isset($user_id) && !empty($user_id)){
				$this->load->view('user/registration',$userArr);
			}else{
				$this->load->view('user/registration',$userDataArr);
			}	
		}else{
				if (!empty($_FILES['photo']['name']))
				{	
					//ho "test";exit;
					//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
					$config['upload_path'] = '/var/www/html/test1/upload/';
					// set the filter image types
					$config['allowed_types'] = 'gif|jpg|png';
					$this->upload->initialize($config);
					$uploadimage_data = $this->Upload_model->do_upload($config,'photo');
				}	
				//print_r($uploadimage_data);exit;
			     if(isset($uploadimage_data['error']) && !empty($uploadimage_data['error']) && !empty($_FILES['photo']['name'])){
					$this->session->set_flashdata('message',$uploadimage_data['error']);
					 if(isset($user_id) && !empty($user_id)){
						$this->load->view('user/registration',$userArr);
					 }else{
						 $this->load->view('user/registration',$userDataArr);
					 }
				 }else{
					 
					if(isset($user_id) && !empty($user_id)){
						if (!empty($_FILES['photo']['name']))
						{
							$this->Upload_model->delete_image($user_data_array[0]->avatar);
						}	
					}
					if (!empty($_FILES['photo']['name']))
					{ 
						$userDataArr['data']['avatar']        = 	$uploadimage_data['photo']['file_name'];
					}	
					if(empty($user_id)){
						$userDataArr['data']['password']     =   do_hash($userDataArr['data']['password'], 'md5');
					}	
				if(isset($user_id) && !empty($user_id)){
					
					if($this->Users_model->user_update($user_id,$userDataArr['data'])){
						$this->session->set_flashdata('message','User Information is Updated sucessfully');
					}else{
						$this->session->set_flashdata('message','User Information is Updated fail');
					}
				}else{	
					if($this->Users_model->user_insert($userDataArr['data'])){
						$this->session->set_flashdata('message','User Information is added sucessfully');
					}else{
						$this->session->set_flashdata('message','User Information is added fail');
					}
				}	
					$userDataArr['data']['first_name'] 	 = 	'';
					$userDataArr['data']['last_name'] 	 = 	'';
					$userDataArr['data']['user_name']    = 	'';
					$userDataArr['data']['password']     = 	'';
					$userDataArr['data']['phone'] 	 	 = 	'';
					$userDataArr['data']['general']      = 	'';
					$userDataArr['data']['photo']        = 	'';
					 $userDataArr['data']['id']        = 	'';
					//$this->load->view('user/manage_user',$userDataArr);   
					 redirect('/user/manage_user/', 'refresh');
				}
		  }
		$this->load->view('footer');

	}
	public function manage_user(){
		$this->load->library('pagination');
		$config = array();
		$config["base_url"] = base_url() . "user/manage_user";
		$total_row = $this->Users_model->user_record_count();
		$config["total_rows"] = $total_row;
		$config["per_page"] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		$this->pagination->initialize($config);
		
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3)) ;
		}
		else{
			$page = 1;
		}
		$page = ($page*$config["per_page"])-$config["per_page"];
		$data["results"] = $this->Users_model->fetch_user_data($config['per_page'],$page);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		// View data according to array.
		$this->load->view('header');
		$this->load->view('user/manage_user',$data);
		$this->load->view('footer');
	 }
	 public function delete_user($user_id){
		 $this->load->model('Upload_model');
			$id = $this->input->get('id', true);
		 	if(!isset($id) && empty($id)){
			}	
			if(isset($id) && !empty($id)){
			$user_data_array = $this->Users_model->fetch_user_data_orderbyId($id);
			//print_r($user_data_array);	
			if(isset($user_data_array) && !empty($user_data_array)){
				$this->Upload_model->delete_image($user_data_array[0]->avatar);
				$this->Users_model->user_delete($id);
				$this->session->set_flashdata('message','User Information is deleted sucessfully');
				redirect('/user/manage_user/', 'refresh');
			}	
		 }else{
				$this->session->set_flashdata('message','User Information is deleted fail');
			}	
	}
	 public function deleteall(){
		  $this->load->model('Upload_model');
		  $chk_ids =array();
		 $chk_ids = $this->input->post('data[user_ids]');
		 foreach($chk_ids as $id){
			 $user_data_array = $this->Users_model->fetch_user_data_orderbyId($id);
			 $this->Upload_model->delete_image($user_data_array[0]->avatar);
			 $this->Users_model->user_delete($id);
			 
		 }
		 $this->session->set_flashdata('message','User Information is deleted sucessfully');
		 echo "sucess";
		 exit;
	 }	 
	
	
		
}