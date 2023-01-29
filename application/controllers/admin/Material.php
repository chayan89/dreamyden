<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends MY_Controller {

	public function __construct() {
		parent::__construct();
		ini_set('display_errors', 1);
	}
	public function index()
	{
		$this->checkAdminAuth();
		
		$this->data['page'] = 'admin/material/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('materials', ['material_id'=> $id], 'materials.*');
		}
		$this->data['page'] = 'admin/material/add';
		$this->load_view($this->data);
	}

	//Add_edit function for category
	public function materialSave()
	{
		$this->checkAdminAuth();
		$this->form_validation->set_rules('name','Material name','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			$postData = $this->input->post();
			$categoryName = $this->input->post('name');
			$this->data = [];
			$this->data['material_name'] = $categoryName;
			if(empty($postData['material_id'])){
				$isData = $this->common_model->select_row('materials', ['LOWER(material_name)'=> strtolower($categoryName)], 'material_id');
			
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Material already exists');
					redirect('admin/material/add', 'refresh');
				}
			}
			// if($_FILES['image']['name']){
			// 	$filename = $_FILES['image']['name'];
			// 	$allowed =  array('gif', 'png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF');
			// 	$ext = pathinfo($filename, PATHINFO_EXTENSION);

			// 	if (in_array($ext, $allowed)) {
			// 		$image_file = time().'_'.strtolower(str_replace(' ', '~', $categoryName))."." . $ext;
			// 		$imgPath = getcwd()."/uploads/material/".$image_file;
			// 		if(move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)){
			// 			$this->data['material_image'] = $image_file;
			// 		}
			// 	}
			// }
			if(empty($postData['material_id'])){
				if($this->common_model->add('materials', $this->data)){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Material added successfully');
					redirect('admin/material', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to add material');
					redirect('admin/material/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('materials', $this->data,['material_id'=> $postData['material_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Material updated successfully');
					redirect('admin/material', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update Material');
					redirect('admin/material/edit/'.$postData['material_id'], 'refresh');
				}
			}
		}
	}
	public function get()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['source'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['source'] === 'WEB'){
				$where = array('materials.status !='=> 3);
			}else{
				$where = array('materials.status'=> 1);
			}
			$select = 'materials.*';
			$this->obj = $this->common_model->select('materials', $where, $select, 'materials.material_name', 'ASC');
			//echo $this->db->last_query(); die;

			if($postData['source'] === 'WEB'){
				$this->data['materials'] = $this->obj;
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