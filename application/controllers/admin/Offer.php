<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends MY_Controller {

	public function __construct() {
		parent::__construct();
	$this->load->model('mcommon');
	$this->load->model('common_model');	
	}
	public function index()
	{
		ini_set('display_errors', 1);
		$this->checkAdminAuth();
		$this->data = [];
		$join = array(
						'vendor_details'=>'offer.vender_id = vendor_details.vendor_id',
						'products'=>'offer.product_id = products.product_id'
					 );
		$where = 'offer.status=1';
		$this->data['details'] = $this->mcommon->vendorlist('offer',$where,$join,'INNER');
		$this->data['page'] = 'admin/offer/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
		$this->data['details'] = $this->common_model->select_row('offer', ['offer_id'=> $id], 'offer.*');
		}
		$this->data['page'] = 'admin/offer/add';
		$this->load_view($this->data);
	}

	//Add_edit function for delivery boy
	public function offersave()
	{
		$this->checkAdminAuth();
		$postData = $this->input->post();
		$this->data = [];
		$this->data['vender_id'] = $postData['vendor'];
		$this->data['minimum_amount'] = $postData['minimum_amount'];
		$this->data['maximum_amount'] = $postData['maximum_amount'];
		$this->data['percentage'] = $postData['persantage'];
		$this->data['status']	  = 1;
        
		if(empty($postData['offer_id'])){

           //Use for same vender and product
		    $condition = ' `vender_id` = "'.$postData['vendor'].'"';	
			//$condition .= ' And `product_id` = "'.$postData['product_id'].'" ';	
			$is_exist = $this->mcommon->getRow('offer',$condition);		
			//echo $this->db->last_query();exit();		
			// if(!empty($is_exist)){
			// 	$this->session->set_flashdata('error_msg','Record already exist.');
			// 	redirect('admin/offer/add', 'refresh');		
			// } else {
			if($this->common_model->add('offer', $this->data)){
				$this->session->set_flashdata('success', 'offer added successfully');
				redirect('admin/offer/add', 'refresh');
			} else {
			$this->session->set_flashdata('success', 'Unable to added successfully');
			redirect('admin/offer/add', 'refresh');	
			}
		   //}
		} else {
			if($this->common_model->update('offer', $this->data,['offer_id'=> $postData['offer_id']])){
				$this->session->set_flashdata('success', 'Offer updated successfully');
				redirect('admin/offer/add/'.$postData['offer_id'], 'refresh');
			}else{
				$this->session->set_flashdata('error', 'Unable to update offer');
				redirect('admin/offer/add/'.$postData['offer_id'], 'refresh');
			}
		}
	}

	/*
		** Bulk data upload
	*/
	//upload bulk/csv tools
	public function csvUpload()
	{
		$filename = $_FILES['image']['name'];
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
							'role_id'=> 3,
							'fname'=> $data[0],
							'lname'=> $data[1],
							'email'=> $data[2],
							'mobile'=> $data[3],
							'password'=> MD5($data[4]),
							'address'=> $data[5]
						);
					}
				}
			}
			if($this->data){
				$this->common_model->batch_insert('users', $this->data);
				$this->response=array('status'=>array('error_code'=>0,'message'=>'Data uuccessfully uploaded '),'result'=>array('data'=>$this->obj));
			}
		}else{
			$this->response=array('status'=>array('error_code'=>1,'message'=>'Upload only csv files'),'result'=>array('data'=>$this->obj));
		}
		$this->outputJson($this->response);
	}

	public function get_product() {
		     $vendor_id=$_POST['product_id']; 
	        $query_cont = $this->mcommon->getRows('products',$condition=array('vendor_id'=>$vendor_id,'status'=>1));
	        $option = '';
	        $option.='<option value="">Select Product</option>';
            foreach ($query_cont as  $value) { 
			 $option .= '<option value="'.$value['product_id'].'">'.$value['product_name'].'</option>';
	        }
	        echo $option ;

      }
}