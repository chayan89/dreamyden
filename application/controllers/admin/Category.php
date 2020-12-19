<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	public function index()
	{
		$this->checkAdminAuth();
		
		$this->data['page'] = 'admin/category/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('categories', ['category_id'=> $id], 'categories.*');
		}
		$this->data['page'] = 'admin/category/add';
		$this->load_view($this->data);
	}

	//Add_edit function for category
	public function categorySave()
	{
		$this->checkAdminAuth();
		$this->form_validation->set_rules('name','Category name','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			$postData = $this->input->post();
			$categoryName = $this->input->post('name');
			$this->data = [];
			$this->data['category_name'] = $categoryName;
			if(empty($postData['category_id'])){
				$isData = $this->common_model->select_row('categories', ['LOWER(category_name)'=> strtolower($categoryName)], 'category_id');
			
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Category already exists');
					redirect('admin/category/add', 'refresh');
				}
			}
			if($_FILES['image']['name']){
				$filename = $_FILES['image']['name'];
				$allowed =  array('gif', 'png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if (in_array($ext, $allowed)) {
					$image_file = time().'_'.strtolower(str_replace(' ', '~', $categoryName))."." . $ext;
					$imgPath = getcwd()."/uploads/category/".$image_file;
					if(move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)){
						$this->data['category_image'] = $image_file;
					}
				}
			}
			if(empty($postData['category_id'])){
				if($this->common_model->add('categories', $this->data)){
					$this->session->set_flashdata('success', 'Category added successfully');
					redirect('admin/category', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to add category');
					redirect('admin/category/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('categories', $this->data,['category_id'=> $postData['category_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Category updated successfully');
					redirect('admin/category', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update category');
					redirect('admin/category/edit/'.$postData['category_id'], 'refresh');
				}
			}
		}
	}
	public function get()
	{
		ini_set('display_errors', 1);
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['source'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['source'] === 'WEB'){
				$where = array('categories.status !='=> 3);
			}else{
				$where = array('categories.status'=> 1);
			}
			$select = 'categories.*, IF(categories.category_image IS NULL, "", CONCAT("'.base_url().'uploads/category/",categories.category_image)) as category_image,';
			$this->obj = $this->common_model->select('categories', $where, $select, 'categories.category_id', 'DESC');
			//echo $this->db->last_query(); die;

			if($postData['source'] === 'WEB'){
				$this->data['categories'] = $this->obj;
				$html = $this->load->view('admin/ajax-view', $this->data, true);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => $html);
			}else{
				if(!empty($this->obj)){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 0, 'message' => 'No data found'), 'result' => array('data' => $this->obj));
				}
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
}