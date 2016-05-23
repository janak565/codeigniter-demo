<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __contruct(){
		parent::__contruct();
		
	}
	
	public function drop_categories(){
		$this->load->model('Category_model');
		$categories_list['category'] = $this->Category_model->drop_category_tree();
		$categories_list['tree_category'] = $this->Category_model->tree_category();
		$this->load->view('category/dropdown',$categories_list);
	}
	public function tree_categories(){
		$this->load->model('Category_model');
		$categories_list['category'] = $this->Category_model->drop_category_tree();
		$categories_list['tree_category'] = $this->Category_model->tree_category();
		//print_r($this->Category_model->tree_category());
		$this->load->view('category/dropdown',$categories_list);
	}
}
?>