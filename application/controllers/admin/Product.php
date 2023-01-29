<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	public function index()
	{
		$this->checkAdminAuth();
		$this->data['page'] = 'admin/product/index';
		$this->data['details'] = 'admin/product/index';
		$this->load_view($this->data);
	}

	/**
	 * Load product add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
			$this->data['details'] = $this->common_model->select_row('products', ['product_id'=> $id], 'products.*');
		}
		$this->data['product_types'] = $this->common_model->select('product_types', ['status'=> 1], '*', 'product_type_id', 'ASC');
		$this->data['page'] = 'admin/product/add';
		$this->load_view($this->data);
	}

	//Add_edit function for product
	public function productSave()
	{ 
		$this->checkAdminAuth();
		$postData = $this->input->post();
		$this->form_validation->set_rules('product_name','Product name','trim|required');
	    $this->form_validation->set_rules('product_type','Product type is required','trim|required'); 
	    $this->form_validation->set_rules('price','Price','trim|required');
	    $this->form_validation->set_rules('product_size','Size is required','trim|required');
	   
	    if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Please fill all required fields');
			$this->add();
		}
		else{
			if(empty($postData['product_suk'])){
				$isData = $this->common_model->select_row('products', ['LOWER(product_suk_id)'=> strtolower($postData['product_suk'])], 'product_id');
				if(!empty($isData)){
					$this->session->set_flashdata('error', 'Product  is already exists');
					redirect('admin/product', 'refresh');
				}
			}

			$isData = $this->common_model->select_row('products', ['LOWER(product_name)'=> strtolower($postData['product_name'])], 'product_id');
			if(!empty($isData)){
				$this->session->set_flashdata('error', 'Product name is already exists');
				redirect('admin/product', 'refresh');
			}
			
			$this->data= array(
				'product_type_id'	=> $this->input->post('product_type'),
				'product_name'	=> $this->input->post('product_name'),
				'product_suk_id'	=> $this->input->post('product_suk'),
				'description'	=> $this->input->post('description'),
				'price'	=> $this->input->post('price'),
				'product_size'	=> $this->input->post('product_size'),
				'description'	=> $this->input->post('description')
			);
			//1=>Blanket, 2=>Pillow
			if($this->input->post('product_type') == 1){
				$this->data['material'] =  $this->input->post('material');
			}else{
				$this->data['product_style'] =  $this->input->post('product_style');
			}
			if(!empty($this->input->post('printing_option'))){
				$this->data['printing_option'] =  $this->input->post('printing_option');
			}

			if($_FILES['image']['name']){
				$filename = $_FILES['image']['name'];
				$allowed =  array('gif', 'png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if (in_array($ext, $allowed)) {
					$image_file = time().'_'.strtolower(str_replace(' ', '~', $productName))."." . $ext;
					$imgPath = getcwd()."/uploads/product/".$image_file;
					if(move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)){
						$this->data['product_image'] = $image_file;
					}
				}
			}
			
			if(empty($postData['product_id'])){
				if($this->common_model->add('products', $this->data)){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'Product added successfully');
					redirect('admin/product', 'refresh');
				}else{
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('error', 'Unable to adde Product');
					redirect('admin/product/add', 'refresh');
				}
			}else{
				//print_r($this->data); die;
				if($this->common_model->update('products', $this->data,['product_id'=> $postData['product_id']])){
					//echo $this->db->last_query(); die;
					$this->session->set_flashdata('success', 'product updated successfully');
					redirect('admin/product/edit/'.$postData['product_id'], 'refresh');
				}else{
					$this->session->set_flashdata('error', 'Unable to update product');
					redirect('admin/product/edit/'.$postData['product_id'], 'refresh');
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
				$where = array('products.status !='=> 3);
			}else{
				$where = array('products.status'=> 1);
			}
			
			$select = 'products.*, ps.size, IF((products.product_image IS NULL OR products.product_image = ""), "", CONCAT("'.base_url().'uploads/product/",products.product_image)) as product_image,';
			// if(isset($postData['u_id']) && !empty($postData['u_id'])){
			// 	$where['pl.user_id'] = $postData['u_id'];
			// 	$this->join[] = ['table' => 'product_likes pl', 'on' => 'pl.product_id = products.product_id', 'type' => 'left'];
			// 	$select .=", pl.like_status";
			// }
			$this->join[] = ['table' => 'attribute_sizes ps', 'on' => 'ps.attribute_size_id = products.product_size', 'type' => 'left'];
			$this->obj = $this->common_model->select('products', $where, $select, 'products.product_id', 'DESC', $this->join);
			//echo $this->db->last_query(); die;

			if($postData['source'] === 'WEB'){
				$this->data['products'] = $this->obj;
				$html = $this->load->view('admin/ajax-view', $this->data, true);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => $html);
			}else{
				if(!empty($this->obj)){
					//make indexing on category list for a store
					if(isset($postData['store_id']) && !empty($postData['store_id'])){
						//get sotre's category
						$store_categories = $this->common_model->select('vendor_category vc', ['vc.vendor_id'=> $postData['store_id']], 'vc.*');
						$this->data = array();
						//for all items
						$this->data[] = array(
							'cat_id'=> "0",
							'cat_name'=>'All',
							'items'=> $this->obj,
						);
						if($store_categories){
							foreach($store_categories as $cat){
								$where = array(
									'products.category_id'=> $cat->category_id, 
									'products.vendor_id'=>$postData['store_id'],
									'products.status'=> 1
								);

								$cat_products = $this->common_model->select('products', $where, $select, 'products.product_id', 'DESC', $this->join);
								
								//Category name
								$category = $this->common_model->select_row('categories', ['category_id'=> $cat->category_id], 'categories.category_name');
								$this->data[] = array(
									'cat_id'=> $cat->category_id,
									'cat_name'=>$category->category_name,
									'items'=> $cat_products,
								);
							}
						}
						$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $this->data));
					}else{
						$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $this->obj));
					}
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