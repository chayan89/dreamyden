<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->logo = base_url('public/admin/img/dashboard_logo.png');
	}
	public function index()
	{
		die('welcome');
	}

	/**
	 * @request params 
	 * f_name, l_name, email, mobileno, password, d_udid
	 */
	public function registration()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['f_name'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'First name is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['l_name'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Last name is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['email'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['mobileno'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Mobile no is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['password'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Password is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['d_udid'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Device not found'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$where = array('email'=> $postData['email'], 'status !='=> 3);			
			$userData = $this->common_model->select_row('users', $where, 'users.*');
			if(!empty($userData)){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is already exists'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}

			//mobile number validation
			$where = array('mobile'=> $postData['mobileno'], 'status !='=> 3);
			$userData = $this->common_model->select_row('users', $where, 'users.*');
			if(!empty($userData)){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Mobile no is already exists'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			
			$this->data = array(
				'role_id'=> 1,	//Role Id 1 referred to Customer
				'fname'	=> $postData['f_name'],
				'lname'	=> $postData['l_name'],
				'mobile'	=> $postData['mobileno'],
				'email'	=> $postData['email'],
				'password'	=> MD5($postData['password']),
				'device_id'	=> $postData['d_udid'],
			);
			if($user_id = $this->common_model->add('users', $this->data)){
				$this->data = array('u_id' => $user_id);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Registration successfully done'), 'result' => array('data' => (object)$this->data));
			}
			else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to register'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request params 
	 * email, password,
	 * Response object data
	 */
	public function login()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['source'] =="" || $postData['email'] == "" || $postData['password'] == ""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$where = array('email'=> $postData['email'], 'password'=> MD5($postData['password']));
			if($postData['source'] != 'WEB'){
				//check udid
				// if($postData['d_udid'] ==""){
				// 	$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				// 	$this->outputJson($this->response);
				// }
				$where['role_id !=']	=	0;
			}
			$userData = $this->common_model->select_row('users', $where, 'users.*');
			if(!empty($userData)){
				if($userData->status == 2){
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Account is disabled by the admin'), 'result' => array('data' => $this->obj));
					$this->outputJson($this->response);
				}
				if($postData['source'] === 'WEB'){
					$this->session->set_userdata('admin_user', $userData);					
				}else{
					//update device_id
					$this->common_model->update($postData['table'], ['device_id' => $postData['d_udid']], ['user_id' => $userData->user_id]);
				}

				$this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => (object)$userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to authenticated'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	/**
	 * @request params 
	 * u_id, f_name, l_name, email, mobileno, profileimage, d_udid
	 * 24/09
	 */
	public function updateProfile()
	{
		$postData = $this->input->post();
		if (!empty($postData)) {
			if($postData['f_name'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'First name is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['l_name'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Last name is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['email'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['mobileno'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Mobile no is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}

			$this->auth($postData['u_id']);

			$this->data = array(
				'fname'	=> $postData['f_name'],
				'lname'	=> $postData['l_name'],
				'mobile'	=> $postData['mobileno'],
				'email'	=> $postData['email'],
			);
			if($_FILES['profileimage']['name']){
				$filename = $_FILES['profileimage']['name'];
				$allowed =  array('gif', 'png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
				if (in_array($ext, $allowed)) {
					$image_file = time().'_'.$postData['u_id']."." . $ext;
					$imgPath = getcwd()."/uploads/user/".$image_file;
					if(move_uploaded_file($_FILES['profileimage']['tmp_name'], $imgPath)){
						$this->data['profile_image'] = $image_file;
					}else{
						$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to update information'), 'result' => array('data' => $this->obj));
						$this->outputJson($this->response);
					}
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Please choose image file only'), 'result' => array('data' => $this->obj));
					$this->outputJson($this->response);
				}
			}
			// else{
			// 	$this->response = array('status' => array('error_code' => 1, 'message' => 'Profile image is required'), 'result' => array('data' => $this->obj));
			// 	$this->outputJson($this->response);
			// }

			if($this->common_model->update('users', $this->data, ['user_id'=> $postData['u_id']])){
				$select = 'users.*, IF(profile_image IS NULL, "", CONCAT("'.base_url().'uploads/user/",profile_image)) as profile_image';
				$this->data = $this->common_model->select_row('users', ['user_id'=> $postData['u_id']], $select);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Information successfully update'), 'result' => array('data' => $this->data));
			}
			else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to update information'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	public function updateDubid()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['d_udid'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Device not found'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			if($this->common_model->update('users', ['device_id' => $postData['d_udid']], ['user_id' => $postData['u_id']])){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Token updated successfully'), 'result' => array('data' => $userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to update token'), 'result' => array('data' => $userData));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	/**
	 * Set presence status
	 * @request u_id, status
	*/
	public function setPresenceStatus()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['status'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			if($this->common_model->update('users', ['presence_status' => $postData['status']], ['user_id' => $postData['u_id']])){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Status updated successfully'), 'result' => array('data' => $userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to update status'), 'result' => array('data' => $userData));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * get presence status
	 * @request u_id
	*/
	public function getPresenceStatus()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			if($this->arr = $this->common_model->select_row('users', ['user_id' => $postData['u_id']], 'users.presence_status')){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $this->arr));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	public function getProfile()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$select = 'users.*, IF(users.profile_image IS NULL, "", CONCAT("'.base_url().'uploads/user/",users.profile_image)) as profile_image,';
			if( $this->obj = $this->common_model->select_row('users', ['user_id' => $postData['u_id'], 'role_id !='=>0], $select)){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' =>  $this->obj));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to authenticate user'), 'result' => array('data' =>  $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}
	/**
	 * @request email
	 * 24/09
	 */
	public function forgotPassword()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['email'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}

			if(! $this->common_model->select_row('users', ['email'=> $postData['email'], 'status'=> 1, 'role_id !='=> 0], 'users.user_id')){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to find email'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$otp =	rand(1111, 9999);
			$siteData = $this->common_model->select_row('site_settings', ['id'=> 1], 'site_settings.*');
			$params['name']         =    $siteData->name?$siteData->name:'Pink Delivery';
			$params['to']           =    $postData['email']; //'chayan.samanta@met-technologies.com';//
			$params['subject']      =   'Forgot password OTP';
			$params['user_name']    =    $postData['email'];
			$params['from_email']   =	$siteData->email?$siteData->email:'info@pinkdelivery.com';
			$mail_temp              =    file_get_contents('./global/mail/forgotpassword_template.html');
			$mail_temp  =  str_replace("{web_name}",$siteData->name?$siteData->name:'Pink Delivery',$mail_temp);
			$mail_temp  =  str_replace("{web_logo}",$this->logo,$mail_temp);
			$mail_temp  =  str_replace("{user_name}",$params['user_name'],$mail_temp);
			$mail_temp  =  str_replace("{otp}", $otp, $mail_temp);
			$mail_temp  =  str_replace("{current_year}", date('Y'), $mail_temp);
			$params['message']      =    $mail_temp;
			//echo $mail_temp;die;
			if(send_mail($params)){
				$this->common_model->update('users', ['_token'=> $otp], ['email'=> $postData['email'], 'status'=> 1]);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Password recovery mail send to your email'), 'result' => array('data' =>  (object)['otp'=> $otp]));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to proceed your request'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}
	/**
	 * @request email, otp, password
	 * 24/09
	*/
	public function resetPassword()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['email'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['password'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Password is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['otp'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'OTP is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}

			if(!$user = $this->common_model->select_row('users', ['email'=> $postData['email'], 'status'=> 1, '_token'=> $postData['otp']], 'users.user_id')){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to authenticate'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			//echo $mail_temp;die;
			if($this->common_model->update('users', ['password'=> MD5($postData['password']), '_token'=> null], ['user_id'=> $user->user_id])){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Password updated successfully'), 'result' => array('data' =>  $this->obj));
			}else{
				$this->common_model->update('users', ['_token'=> $postData['otp']], ['email'=> $postData['email'], 'status'=> 1, '_token'=> $postData['otp']]);
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to updated your password'), 'result' => array('data' =>  $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}

	/**
	 * @request lat, long, address, u_id
	 */
	public function saveMyLocation()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);

			$this->data= array(
				'user_id'=> $postData['u_id'],
				'lat'=> $postData['lat'],
				'lng'=> $postData['long'],
				'address'=> $postData['gaddress'],
			);
			$userData = $this->common_model->select_row('customer_details', ['user_id'=> $postData['u_id'], 'status !='=> 3], 'customer_details.*');
			if(empty($userData)){
				$isSuccess = $this->common_model->add('customer_details', $this->data);
			}else{
				$isSuccess = $this->common_model->update('customer_details', $this->data, ['user_id'=> $postData['u_id']]);
			}
			
			if($isSuccess){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed'), 'result' => array('data' => $userData));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request product_id, like, u_id
	 */
	public function favProduct()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['product_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);

			$this->data= array(
				'user_id'=> $postData['u_id'],
				'product_id'=> $postData['product_id'],
				'like_status'=> $postData['like'],
			);
			$userData = $this->common_model->select_row('product_likes', ['user_id'=> $postData['u_id'], 'product_id'=> $postData['product_id']], 'product_likes.*');
			if(empty($userData)){
				$isSuccess = $this->common_model->add('product_likes', $this->data);
			}else{
				$isSuccess = $this->common_model->update('product_likes', $this->data, ['user_id'=> $postData['u_id'], 'product_id'=> $postData['product_id']]);
			}
			//echo $this->db->last_query();
			if($isSuccess){
				$this->response = array('status' => array('error_code' => 0, 'message' => $postData['like']==1?'Like Successfully':'Dislike Successfully'), 'result' => array('data' => $this->obj));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request access_type,
	 * response object
	*/
	public function getMembershipList()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['access_type'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			
			$this->data = $this->common_model->select('users', ['membership_status'=> 1, 'status'=>1], 'users.*', 'user_id', 'DESC');
			if($this->data){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => $this->data));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'No address found'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request access_type, u_id
	 * response object
	*/
	public function getUserMembershipList()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['access_type'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			$this->data = $this->common_model->select('customer_membership cm', ['cm.user_id'=> $postData['u_id']],'cm.*', 'cm.subscription_date', 'ASC');
			if($this->data){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => $this->data));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'No address found'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request u_id,
	 * response object
	*/
	public function getAddress()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			
			$this->auth($postData['u_id']);
			$this->data = $this->common_model->select('customer_address', ['user_id'=> $postData['u_id'], 'status'=>1], 'customer_address.*', 'id', 'DESC');
			if($this->data){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => $this->data));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'No address found'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request u_id, name, email, phone,pin, city, state
	 * @address_id for update
	*/
	public function addAddress()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['name'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Name is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['email'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Email is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['phone'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Phone is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$this->data = array(
					'user_id'=> $postData['u_id'],
					'name'=> $postData['name'],
					'email'=> $postData['email'],
					'phone'=> $postData['phone'],
					'pin'=> $postData['pin'],
					'city'=> $postData['city'],
					'state'=> $postData['state'],
				);
			if(!isset($postData['address_id']) && empty($postData['address_id'])){
				if($this->common_model->add('customer_address', $this->data)){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Address added successfully'), 'result' => array('data' => $userData));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to add address'), 'result' => array('data' => $userData));
				}
			}else{
				$this->data['updated_at'] = date('Y-m-d H:i:s');
				if($this->common_model->update('customer_address', $this->data, ['id'=> $postData['address_id']])){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Address updated successfully'), 'result' => array('data' => $userData));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to update address'), 'result' => array('data' => $userData));
				}
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 *@address_id for update
	*/
	public function deleteAddress()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			
			if($postData['address_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$this->data = array(
					'status'=> 3,
				);
			$this->data['updated_at'] = date('Y-m-d H:i:s');
			if($this->common_model->update('customer_address', $this->data, ['id'=> $postData['address_id']])){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Address deleted successfully'), 'result' => array('data' => $userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to deleted address'), 'result' => array('data' => $userData));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}
	/**
	 * @request oldPassword, newPassword, u_id
	*/
	public function changePassword()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['oldPassword'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Old password is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['newPassword'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'New password is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			if(!$this->common_model->select_row('users', ['user_id'=> $postData['u_id'], 'password'=> MD5($postData['oldPassword'])], 'users.user_id')){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Current password not matched'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($this->common_model->update('users', ['password' => MD5($postData['newPassword'])], ['user_id' => $postData['u_id']])){
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Password changed successfully'), 'result' => array('data' => $userData));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to update password'), 'result' => array('data' => $userData));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * Logout API
	 */
	public function logout()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['source'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['source'] === 'WEB'){
				$this->session->unset_userdata('admin_user');					
			}
			// else{

			// }

			$this->response = array('status' => array('error_code' => 0, 'message' => 'Logout successfully'), 'result' => array('data' => $userData));
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}


	/**
	 * Wishlist section
	 * @request u_id, product_id
	*/
	public function addWishlist()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['product_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Product is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$this->data = array(
					'user_id'=> $postData['u_id'],
					'product_id'=> $postData['product_id']
				);
				$isData = $this->common_model->select_row('wishlist_items', $this->data);
				if(empty($isData)){
					$isSaved = $this->common_model->add('wishlist_items', $this->data);
				}else{
					$isSaved = true;
				}
				//if(!isset($postData['address_id']) && empty($postData['address_id'])){
				if($isSaved){
					$this->obj = $this->common_model->select('wishlist_items', ['user_id'=> $postData['u_id']], 'wishlist_items.*', 'wishlist_items.id', 'DESC');
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Add items to wishlist successfully'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to add wishlist'), 'result' => array('data' => $this->obj));
				}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request u_id
	*/
	public function getWishlist()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$this->data = array(
					'user_id'=> $postData['u_id']
				);
				$this->join[] = ['table' => 'products p', 'on' => 'p.product_id = wishlist_items.product_id', 'type' => 'left'];
				$obj = $this->common_model->select('wishlist_items', ['user_id'=> $postData['u_id']], 'wishlist_items.*, p.vendor_id', 'wishlist_items.id', 'DESC', $this->join);
				ini_set('display_errors', 1);
				if($obj){
					$temp_arr = [];
					foreach($obj as $value){
						$this->join = array();
						$select = 'products.*, c.category_name, vd.vendor_name, IF(products.product_image IS NULL, "", CONCAT("'.base_url().'uploads/product/",products.product_image)) as product_image';
						$this->join[] = ['table' => 'categories c', 'on' => 'c.category_id = products.category_id', 'type' => 'left'];
						$this->join[] = ['table' => 'vendor_details vd', 'on' => 'vd.vendor_id = products.vendor_id', 'type' => 'left'];
						$temp = $this->common_model->select('products', ['products.product_id'=> $value->product_id], $select, 'products.product_id', 'DESC', $this->join);
			
						if(array_key_exists($value->vendor_id, $temp_arr)){
							$temp_arr[$value->vendor_id]['list'][] = $temp[0];
						}else{
							$temp_arr[$value->vendor_id]['vendor_id'] = $value->vendor_id;
							$temp_arr[$value->vendor_id]['vendor_name'] = $temp[0]->vendor_name;
							$temp_arr[$value->vendor_id]['list'][] = $temp[0];
						}
						
					}
					$this->obj = [];
					if($temp_arr){
						foreach($temp_arr as $value){
							$this->obj[] = $value;
						}
					}
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Successfully'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'No data found'), 'result' => array('data' =>$this->obj));
				}
			// }else{
			// 	$this->data['updated_at'] = date('Y-m-d H:i:s');
			// 	if($this->common_model->update('customer_address', $this->data, ['id'=> $postData['address_id']])){
			// 		$this->response = array('status' => array('error_code' => 0, 'message' => 'Address updated successfully'), 'result' => array('data' => $userData));
			// 	}else{
			// 		$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to update address'), 'result' => array('data' => $userData));
			// 	}
			// }
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

	/**
	 * Wishlist item removesection
	 * @request u_id, product_id
	*/
	public function removeWishlistItem()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['product_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Product is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$this->data = array(
					'user_id'=> $postData['u_id'],
					'product_id'=> $postData['product_id']
				);
				$this->db->where($this->data);
				$isDeleted = $this->db->delete('wishlist_items');
				//if(!isset($postData['address_id']) && empty($postData['address_id'])){
				if($isDeleted){
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Deleted item from wishlist successfully done'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to Deleted item from wishlist'), 'result' => array('data' => $this->obj));
				}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}

		/**
	 * Search product from category or product
	 * @request search_key
	*/
	public function productSearch()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['search_key'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Search key is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->data = array(
					'user_id'=> $postData['u_id'],
					'product_id'=> $postData['product_id']
				);
				$isData = $this->common_model->select_row('wishlist_items', $this->data);
				if(empty($isData)){
					$isSaved = $this->common_model->add('wishlist_items', $this->data);
				}else{
					$isSaved = true;
				}
				//if(!isset($postData['address_id']) && empty($postData['address_id'])){
				if($isSaved){
					$this->obj = $this->common_model->select('wishlist_items', ['user_id'=> $postData['u_id']], 'wishlist_items.*', 'wishlist_items.id', 'DESC');
					$this->response = array('status' => array('error_code' => 0, 'message' => 'Add items to wishlist successfully'), 'result' => array('data' => $this->obj));
				}else{
					$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to add wishlist'), 'result' => array('data' => $this->obj));
				}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
}