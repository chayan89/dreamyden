<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AttributeSize extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	public function index()
	{
		$this->checkAdminAuth();
		
		$this->data['page'] = 'admin/attrubute_size/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('attribute_sizes', ['attribute_size_id'=> $id], 'attribute_sizes.*');
		}
		$this->data['types'] = $this->common_model->select('product_types', ['status'=> 1], '*');
		$this->data['page'] = 'admin/attrubute_size/add';
		$this->load_view($this->data);
	}

	//Add_edit function for category
	public function sizeSave()
	{
		$this->checkAdminAuth();
		//print_r($this->input->post()); die;
		$this->form_validation->set_rules('size','Size is required','trim|required');
		$this->form_validation->set_rules('product_type_id','Product type is required','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			$postData = $this->input->post();
			$size = $this->input->post('size');
			$product_type_id = $this->input->post('product_type_id');
			$this->data = [];
			$this->data['size'] = $size;
			$this->data['product_type_id'] = $product_type_id;
			if(empty($postData['product_type_id'])){
				$isData = $this->common_model->select_row('attribute_sizes', ['LOWER(size)'=> strtolower($size), 'product_type_id'=> $product_type_id], 'attribute_size_id');
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Size already exists');
					redirect('admin/attribute-size/add', 'refresh');
				}
			}
			if(empty($postData['attribute_size_id'])){
				if($this->common_model->add('attribute_sizes', $this->data)){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Size added successfully');
					redirect('admin/attribute-size', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to add Size');
					redirect('admin/attribute-size/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('attribute_sizes', $this->data,['attribute_size_id'=> $postData['attribute_size_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Size updated successfully');
					redirect('admin/attribute-size', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update Size');
					redirect('admin/attribute-size/edit/'.$postData['attribute_size_id'], 'refresh');
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
				$where = array('attribute_sizes.status !='=> 3);
			}else{
				$where = array('attribute_sizes.status'=> 1);
			}
			if(isset($postData['product_type_id'])){
				$where['attribute_sizes.product_type_id']= $postData['product_type_id'];
			}
			$select = 'attribute_sizes.*, pt.product_type_name';
			$this->join[] = ['table' => 'product_types pt', 'on' => 'pt.product_type_id = attribute_sizes.product_type_id', 'type' => 'left'];
			$this->obj = $this->common_model->select('attribute_sizes', $where, $select, 'attribute_sizes.attribute_size_id', 'DESC', $this->join);
			//echo $this->db->last_query(); die;

			if($postData['source'] === 'WEB'){
				$this->data['sizes'] = $this->obj;
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