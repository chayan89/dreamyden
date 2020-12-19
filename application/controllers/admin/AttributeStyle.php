<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AttributeStyle extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	public function index()
	{
		$this->checkAdminAuth();
		
		$this->data['page'] = 'admin/attrubute_style/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		ini_set('display_errors', 1);
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('attribute_styles', ['attribute_style_id'=> $id], 'attribute_styles.*');
		}
		$this->data['types'] = $this->common_model->select('product_types', ['status'=> 1], '*');
		$this->data['page'] = 'admin/attrubute_style/add';
		$this->load_view($this->data);
	}

	//Add_edit function for Style
	public function styleSave()
	{
		$this->checkAdminAuth();
		//print_r($this->input->post()); die;
		$this->form_validation->set_rules('style','Style is required','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			$postData = $this->input->post();
			$style = $this->input->post('style');
			$this->data = [];
			$this->data['style'] = $style;
			if(empty($postData['attribute_style_id'])){
				$isData = $this->common_model->select_row('attribute_styles', ['LOWER(style)'=> strtolower($style)], 'attribute_style_id');
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Style already exists');
					redirect('admin/attribute-style/add', 'refresh');
				}
			}
			if(empty($postData['attribute_style_id'])){
				if($this->common_model->add('attribute_styles', $this->data)){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Style added successfully');
					redirect('admin/attribute-style', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to add Style');
					redirect('admin/attribute-style/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('attribute_styles', $this->data,['attribute_style_id'=> $postData['attribute_style_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Style updated successfully');
					redirect('admin/attribute-style', 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update Style');
					redirect('admin/attribute-style/edit/'.$postData['attribute_style_id'], 'refresh');
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
				$where = array('attribute_styles.status !='=> 3);
			}else{
				$where = array('attribute_styles.status'=> 1);
			}

			$select = 'attribute_styles.*';
			$this->obj = $this->common_model->select('attribute_styles', $where, $select, 'attribute_styles.attribute_style_id', 'DESC');
			//echo $this->db->last_query(); die;

			if($postData['source'] === 'WEB'){
				$this->data['styles'] = $this->obj;
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