<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminuser extends MY_Controller {

	public function __construct() {
		parent::__construct();
	$this->load->model('mcommon');
	$this->load->model('common_model');
			
	}
	public function index()
	{
		$this->checkAdminAuth();
        $id=$this->admin->user_id;
		if($id!=0){
			$this->data = [];
			$this->data['details'] = $this->mcommon->getRow('users',['user_id'=>$id]);		
		}
		$this->data['page'] = 'admin/user/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category edit view
	 */
	public function edit()
	{
		$this->checkAdminAuth();
		$id=$this->admin->user_id;
		if($id!=0){
			$this->data = [];
			$this->data['details'] = $this->mcommon->getRow('users',['user_id'=>$id]);		
		}
		$this->data['page'] = 'admin/user/add';
		$this->load_view($this->data);
	}

	public function usersave(){
		if($this->input->post()){
			$id=$this->input->post('user_id');
			$this->form_validation->set_rules('first_name','First Name','required');
			$this->form_validation->set_rules('last_name','Last Name','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('mobile','Mobile','required');
			$this->form_validation->set_rules('address','Address','required');
			if($this->form_validation->run()==FALSE){
				$data['details']=$this->mcommon->getRow('users',['user_id'=>$id]);
				$this->load_view($data);
			}else{	
			    $image=$_FILES["image"]["tmp_name"];
			    if($image) {
			$udata['profile_image']=$_FILES["image"]["name"];	
                $config[ 'upload_path' ]   = './public/admin/img';
				$config[ 'allowed_types' ] = 'gif|jpg|png|jpeg';
				//$config['min_width']       = '1300px';
		        //$config['min_height']      = '490px';
				//$config['max_width']  	   = '1366px';
				//$config['max_height']  	   = '494px';
				$this->load->library( 'upload', $config );
				$this->upload->initialize($config);
				$this->upload->do_upload('image');
				if ( $this->upload->do_upload( 'image' ) ) 
				{					
				$blogdata['image'] = $this->upload->data()['file_name'];					
				} else{
				$this->session->set_flashdata('error_msg','Error with the image Or Zize Must width="1366px" and height="494px".');
				redirect('admin/user/edit');		
				}
			    }
			$udata['fname']=$this->input->post('first_name');
			$udata['lname']=$this->input->post('last_name');
			$udata['email']=$this->input->post('email');
			$udata['mobile']=$this->input->post('mobile');
			$udata['address']=$this->input->post('address');   
			$condition=array('user_id'=>$id);   
			$this->mcommon->update('users',$condition,$udata);
			$this->session->set_flashdata('success_msg','User updated successfully');
			redirect('admin/user/edit');
			}
		}else{
			$this->load_view();
		}
	}

	public function changepassword()
	{
		$this->checkAdminAuth();
		$id=$this->admin->user_id;
		if($id!=0){
			$this->data = [];
			$this->data['details'] = $this->mcommon->getRow('users',['user_id'=>$id]);		
		}
		$this->data['page'] = 'admin/user/resetpass';
		$this->load_view($this->data);
	}

	public function savechangepassword()
	{	
	   if($this->input->post()){
			$id=$this->input->post('user_id');
			$this->form_validation->set_rules('new_password','New Password','required');
			$this->form_validation->set_rules('conform_password','Confirm Password','required');
			if($this->form_validation->run()==FALSE){
			redirect('admin/user/changepassword');
			}else{
			$new_password=$this->input->post('new_password');
			$conform_password=$this->input->post('conform_password');
			if($new_password!=$conform_password){
			$this->session->set_flashdata('error_msg','User Confirm Password Not match');	
			}else {
			$condition=array('user_id'=>$id);	
			$udata['password']=md5($this->input->post('new_password'));
			$this->mcommon->update('users',$condition,$udata);
			$this->session->set_flashdata('success_msg','User Password successfully Changed');	
			}	
			//
			}
		 }else{
		 //
		 }
	    redirect('admin/user/changepassword');	
	}

	public function setting()
	{
		$this->checkAdminAuth();
		$id=$this->admin->user_id;
		if($id!=0){
			$this->data = [];
			$this->data['details'] = $this->mcommon->getRow('site_settings',['status'=>1]);		
		}
		$this->data['page'] = 'admin/user/setting';
		$this->load_view($this->data);
	}

	public function update_setting()
	{
		//print_r($this->input->post()); die;
       if($this->input->post()){
		$id=$this->input->post('id');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('phone','Phone','required');
		$this->form_validation->set_rules('address','Address','required');
		if($this->form_validation->run()==FALSE){
		redirect('admin/user/setting');
		} else {

		       $image=$_FILES["image"]["tmp_name"];
			    if($image) {
	    $udata['image']=$_FILES["image"]["name"];	
                $config[ 'upload_path' ]   = './public/admin/img';
				$config[ 'allowed_types' ] = 'gif|jpg|png|jpeg';
				//$config['min_width']       = '1300px';
		        //$config['min_height']      = '490px';
				//$config['max_width']  	   = '1366px';
				//$config['max_height']  	   = '494px';
				$this->load->library( 'upload', $config );
				$this->upload->initialize($config);
				$this->upload->do_upload('image');
				if ( $this->upload->do_upload( 'image' ) ) 
				{					
				$blogdata['image'] = $this->upload->data()['file_name'];					
				} else{
				$this->session->set_flashdata('error_msg','Error with the image Or Zize Must width="1366px" and height="494px".');	
				}
			    }

		$condition=array('id'=>$id);	
		$udata['name']=$this->input->post('name');
		$udata['email']=$this->input->post('email');
		$udata['phone']=$this->input->post('phone');
		$udata['address']=$this->input->post('address');
		$this->mcommon->update('site_settings',$condition,$udata);
		$this->session->set_flashdata('success_msg','Setting successfully Changed');
		}	
		//
	 }
     redirect('admin/user/setting');

	}

	public function forgetpassword()
	{
		$this->load->view('admin/user/forgot_password');
	}

	//Forgot Password
	public function send_password(){
		 if($this->input->post('email')){
			$email 		=	$this->input->post('email');
			$condition 	= 	array('email'=>$email);
			$res 		= 	$this->mcommon->getRow('users',$condition);

			if(empty($res)){				
				$this->session->set_flashdata('error_msg', "Email does not exist.");	
			}else{

				$params['name']		=	$res['fname'];
				$params['to']		=	$res['email'];
				$params['subject'] 	=	'Pink Delivery - Forgot Password';
				$link 				=	base_url('admin/adminuser/new_password/?ack='.base64_encode($res['email'])); 
				$mail_temp 			= 	file_get_contents('./global/mail/forgotpassword.html');
				//$mail_temp			=	str_replace("{web_url}", SITEURL, $mail_temp); 
				$mail_temp			=	str_replace("{web_logo}", LOGOURL, $mail_temp);
				$mail_temp			=	str_replace("{user_name}", $params['name'], $mail_temp);
				$mail_temp			=	str_replace("{link}", $link, $mail_temp);
				//$mail_temp			=	str_replace("{current_year}", CURRENT_YEAR, $mail_temp);						
				$params['message']	=	$mail_temp;																

				//echo $mail_temp;exit();
				//@mail_config($params);
				if(send_mail($params)){	
				 $this->session->set_flashdata('success_msg', "Password reset link sent to your email.");
				} else{
				$this->session->set_flashdata('error_msg', "Please enter your email.");	
				}																						
			}
		  }else{			
			$this->session->set_flashdata('error_msg', "Please enter your email.");																					
		}	
	
	 redirect(base_url('admin/user/forgot-password'));
		
	}

  //front pass.
  public function new_password()
  {
   $data['ack']=$_GET['ack'];	
   $this->load->view('admin/user/change_password', $data);
  }

  public function savepassword()
  {   
  	  $ack=$this->input->post('token');
      $new_password=$this->input->post('new_password');
      $conform_password=$this->input->post('conform_password');
      if($new_password!=$conform_password){
      $this->session->set_flashdata('error_msg','User Confirm Password Not match'); 
      }else {
      $condition=array('email'=>base64_decode($ack)); 
      $udata['password']=md5($this->input->post('new_password'));
      $this->mcommon->update('users',$condition,$udata);
      $this->session->set_flashdata('success_msg','User Password successfully Changed');  
      } 
     
    redirect('admin/adminuser/new_password/?ack='.$ack);  
  }









}