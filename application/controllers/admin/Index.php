<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public function __construct() {
		ini_set('display_errors', 1);
		parent::__construct();
		$this->load->model('admin/madmin');
		$this->obj = new stdClass();
	}
	// private function outputJson($response)
	// {
	// 	header('Content-Type: application/json');
	// 	echo json_encode($response);
	// 	exit;
	// }
	public function index() {
		if ($this->input->post()) {
			/* Set the validation rules */
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->_load_login_view();
			} else {
				$email = $this->input->post('email', true);
				$password = $this->input->post('password', true);
				$userdata = $this->madmin->user_check($email, $password); 

                //echo $this->db->last_query(); 
				if (empty($userdata)) {
					$this->session->set_flashdata('error_msg', 'Invalid credential');
					$this->_load_login_view();
				} else {					
					if($userdata['status'] == 0){
						$this->session->set_flashdata('error_msg','Your account is pending');
						$this->_load_login_view();
					}else{
						$udata['login_status'] = 1;
						$udata['date_of_lastlogin'] = date('Y-m-d H:i:s');
						$condition = array('id'=>$userdata['id']);
						$this->madmin->update($condition,$udata);
						$this->session->set_userdata('admin', $userdata);
						//exit();
						redirect('admin/dashboard','refresh');
					}
				}	
			}
		} else {
			//$this->is_logged_in()
			if($this->admin){
				redirect('admin/dashboard','refresh');	
			}else{
				$this->_load_login_view();	
			}
		}
	}
	
	public function _load_login_view() {
		$data = array();
		$this->load->view('admin/login', $data);
	}

	public function getUserList(){
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			$admin = $this->session->userdata('admin');
			$returnArray = [];
			if($admin){
				$this->db->where_in('role_id', $postData['role'] );
				$this->db->where('status', 1 );
				$this->obj = $this->db->get('users')->result();
				if($this->obj){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'No data found'), 'result' => array('data' => $this->obj));
				}
			}
		}  else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * Common function to manage status
	 * */
	public function changeStatus(){
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($this->admin){
				$isUpdate = $this->common_model->update($postData['table'], ['status' => $postData['status']], [$postData['indexKey'] => $postData['id']]);
				//echo $this->db->last_query();
				if($isUpdate){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Request successfully done'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to perform request'), 'result' => array('data' => $this->obj));
				}
			}
		}  else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}


}
