<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $response = array();
	protected $data = array();
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->admin = $this->session->userdata('admin_user');
		$this->user_details = $this->session->userdata('front_user');
	}
	protected function checkAdminAuth() {
		if (!$this->admin) {
			redirect('admin', 'refresh');
		}
		//return true;
	}
	protected function checkAuth() {
		if (!$this->user_details) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * @request user_id
	 * Check user existence
	 */
	protected function auth($u_id) {
		if(!$this->common_model->select_row('users', ['user_id'=> $u_id, 'role_id !='=> 0, 'status'=> 1], 'user_id')){
			$this->response = array('status' => array('error_code' => 1, 'message' => 'Unauthenticated request'), 'result' => array('data' => $this->obj));
			$this->outputJson($this->response);
		}
		//return true;
	}

	/**
	 * Load front application view
	 */
	protected function load_front_view($dataArray){
		$this->data = [];
		$this->data = $dataArray;
		$this->data['content']    = $dataArray['page'];
		//$this->data['details']	  = $dataArray['details'];
        $this->load->view('front/layout/index', $this->data);
	}
	 /**
	  * Load application admin view
	  */
	protected function load_view($dataArray){
		$this->data = [];
		$this->data = $dataArray;
		$this->data['content']    = $dataArray['page'];
		//$this->data['details']	  = $dataArray['details'];
        $this->load->view('admin/layouts/index', $this->data);
	}
	
	/*
		** upload csv
	*/
	protected function readCSV($csvFile){
		$file_handle = fopen($csvFile, 'r');
		while (!feof($file_handle) ) {
		$data = fgetcsv($file_handle, 100000);

		$line_of_text[] = $data;
		}
		fclose($file_handle);
		return $line_of_text;
	}


	protected function is_logged_in_user() {
		return $this->session->userdata('front_end_user') ? 1 : 0;
	}
	protected function redirect_guest_user() {
		if (!$this->session->userdata('front_end_user')) {
			redirect('index', 'refresh');
		}
	}
	protected function getmenuPermission()
	{
		//pr($_SESSION);

		$role_id = $this->session->admin['role_id'];
		$getMenuList = array();
		$menuList = array();
		if($role_id){
			$where['menu_master.status']     =   1; 
			$where['user_permission.role_id']   =   $role_id;  
	        $selectarr = array('menu_master.url_action','menu_master.menu_name','user_permission.*');
	        $joinarr['menu_master']     =   'menu_master.menu_id = user_permission.menu_id';
	        $getMenuList        =  $this->common_model->get('user_permission',$selectarr, $where,null,null,null,null,null,null,$joinarr,null,'result');
			//pr($getMenuList);
			if(!empty($getMenuList)){
				foreach($getMenuList as $list){
					$menuList[] = $list->url_action;
				}
			}
		}
		return $menuList;
	}
	public function isJSON($string)
	{
		$valid = is_string($string) && is_array(json_decode($string, true)) ? true : false;
		if (!$valid) {
			$response['status']		=	0;
			$response['message']		=	'BAD REQUEST';
			$response['code']	=	'401';

			echo json_encode($response);
			exit;
		}
	}
	public function extract_json($key)
	{
		return json_decode($key, true);
	}

	public function outputJson($response)
	{
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}

	public function show_query(){
		echo $this->db->last_query(); die;
	}
}
