<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	public function index()
	{
		$this->checkAdminAuth();
		$this->data['page'] = 'admin/cms/index';
		$this->load_view($this->data);
	}

	/**
	 * Load product add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('cms', ['cms_id'=> $id], 'cms.*');
		}
		$this->data['page'] = 'admin/cms/add';
		$this->load_view($this->data);
	}

	//Add_edit function for cms
	public function cmsSave()
	{ 
		$this->checkAdminAuth();
		$postData = $this->input->post();
		$this->form_validation->set_rules('page','Page','trim|required');
	    $this->form_validation->set_rules('title','Title','trim|required'); 
	    $this->form_validation->set_rules('description','Description','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			if(empty($postData['cms_id'])){
				$isData = $this->common_model->select_row('cms', ['LOWER(page)'=> strtolower($postData['page'])], 'cms_id');
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Page CMS is already exists');
					redirect('admin/cms', 'refresh');
				}
			}
			$this->data= array(
				'page'	=> $this->input->post('page'),
				'page_slug'	=> strtolower(str_replace(" ", "-", $this->input->post('page'))),
				'title'	=> $this->input->post('title'),
				'description'	=> $this->input->post('description'),
			);

			if($_FILES['image']['name']){
				$filename = $_FILES['image']['name'];
				$allowed =  array('gif', 'png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if (in_array($ext, $allowed)) {
					$image_file = time().'_'."." . $ext;
					$imgPath = getcwd()."/uploads/cms/".$image_file;
					if(move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)){
						$this->data['image'] = $image_file;
					}
				}
			}
			
			if(empty($postData['cms_id'])){
				if($this->common_model->add('cms', $this->data)){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'CMS data added successfully');
					redirect('admin/cms', 'refresh');
				}else{
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('error', 'Unable to adde CMS data');
					redirect('admin/cms/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('cms', $this->data,['cms_id'=> $postData['cms_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'CMS data updated successfully');
					redirect('admin/cms/edit/'.$postData['cms_id'], 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update CMS data');
					redirect('admin/cms/edit/'.$postData['cms_id'], 'refresh');
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
				$where = array('cms.status !='=> 3);
			}else{
				$where = array('cms.status'=> 1);
			}
			
			$this->obj = $this->common_model->select('cms', $where, '*', 'cms.cms_id', 'DESC');
			if($postData['source'] === 'WEB'){
				$this->data['cms_data'] = $this->obj;
				$html = $this->load->view('admin/ajax-view', $this->data, true);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => $html);
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	/*
		** Bulk data upload
	*/
	//upload bulk/csv tools
	public function csvUpload()
	{
		$filename = $_FILES['image']['name'];
		$vendor = $this->input->post('vendor');
		$category = $this->input->post('category');

		$allowed =  array('csv');
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if (in_array($ext, $allowed)) {
			$image_file = time().'_'.$filename;
			$imgPath = getcwd()."/uploads/".$image_file;
			if(file_exists($imgPath)){
				unlink($imgPath);
			}
			move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);

			$csvData = $this->readCSV($imgPath);
			// echo '<pre>';
			// print_r($csvData); die;
			$this->data = [];
			for($i=1; $i< count($csvData); $i++){
				if($data = $csvData[$i]){
					if (!$this->common_model->select_row('users', array("email" => $data[2]), 'user_id')) {
					$this->data[] = array(
										'product_suk_id'	=> $data[0],
										'product_name'	=> $data[1],
										'price'	=>$data[2],
										'description'	=> $data[3],
										'vendor_id'		=> $vendor,
										'category_id'		=> $category,
									);
					}
				}
			}
			if($this->data){
				$this->common_model->batch_insert('products', $this->data);
				$this->response=array('status'=>array('error_code'=>0,'message'=>'Data uuccessfully uploaded '),'result'=>array('data'=>$this->obj));
			}
		}else{
			$this->response=array('status'=>array('error_code'=>1,'message'=>'Upload only csv files'),'result'=>array('data'=>$this->obj));
		}
		$this->outputJson($this->response);
	}
}