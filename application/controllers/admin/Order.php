<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	public function __construct() {
		parent::__construct();
	$this->load->model('mcommon');
	$this->load->model('common_model');	
	}
	public function index()
	{
		$this->checkAdminAuth();
		$this->data = [];
		
		$join = array(
						'users'=>'orders.user_id = users.user_id'
					 );
		//$where = 'orders.order_status=1';
		$this->data['details'] = $this->mcommon->orderlist('orders',$where,$join,'INNER');
		$this->data['page'] = 'admin/order/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
		$this->data['details'] = $this->common_model->select_row('order', ['order_id'=> $id], 'order.*');
		}
		$this->data['page'] = 'admin/order/add';
		$this->load_view($this->data);
	}


	public function view($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
		$join = array(
						'users'=>'orders.user_id = users.user_id',
					 );
		$where = 'orders.order_id='.$id;
		$this->data['details'] = $this->mcommon->orderlist('orders',$where,$join,'INNER');	
		}
		$this->data['page'] = 'admin/order/view';
		$this->load_view($this->data);
	}

	public function edit($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
		$join = array(
						'users'=>'orders.user_id = users.user_id',
					 );
		$where = 'orders.order_id='.$id;
		$this->data['details'] = $this->mcommon->orderlist('orders',$where,$join,'INNER');	
		}
		$this->data['page'] = 'admin/order/edit';
		$this->load_view($this->data);
	}

	public function reassigning($id = null)
	{
		$this->checkAdminAuth();
		if($id != null){
		$join = array(
						'users'=>'orders.user_id = users.user_id',
					 );
		$where = 'orders.order_id='.$id;
		$this->data['details'] = $this->mcommon->orderlist('orders',$where,$join,'INNER');	
		}
		$this->data['page'] = 'admin/order/reassigning';
		$this->load_view($this->data);
	}

	public function ordersave()
	{
		
		$this->checkAdminAuth();
		$postData = $this->input->post();
		$this->data = [];
		$this->data['order_status'] = $postData['status'];
		if($this->common_model->update('orders', $this->data,['order_id'=> $postData['order_id']])){
			$this->session->set_flashdata('success', 'Order updated successfully');
			redirect('admin/order/edit/'.$postData['order_id'], 'refresh');
		}else{
			$this->session->set_flashdata('error', 'Unable to update order');
			redirect('admin/order/edit/'.$postData['order_id'], 'refresh');	
		}	
	}

	public function savereassign()
	{
		$this->checkAdminAuth();
		$postData = $this->input->post();
		$this->data = [];
		$this->data['user_id'] = $postData['vendor'];
		$this->data['order_id'] = $postData['order_id'];
		$this->data['delivery_status'] = $postData['status'];
		//print_r($this->data); die;
		if($this->common_model->add('assign_delivery', $this->data)){
				$this->session->set_flashdata('success', 'Reassign added successfully');
				redirect('admin/order/reassigning/'.$postData['order_id'], 'refresh');
		}else{
				$this->session->set_flashdata('error', 'Unable to add Reassign');
				redirect('admin/order/reassigning/'.$postData['order_id'], 'refresh');
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