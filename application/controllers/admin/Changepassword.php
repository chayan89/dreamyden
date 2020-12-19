<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword extends MY_Controller {


	public function __construct() {		
		parent::__construct();
		$this->redirect_guest();
		$this->load->model('admin/mchangepassword');	
		$this->load->model('mcommon');		
	}

	private function _load_view($data) {
		$this->load->view('admin/layouts/index',$data);
	}	

	public function index()
	{
	    //echo"gsjdfh";exit;
	    $admin = $this->session->userdata('admin');
		$user_id=$admin['id'];
		
		$data = array();    
	     
	    $data['content']='admin/changepassword';   
	   
	    $this->load->view('admin/layouts/index', $data);

	}


    public function changeuserpasswd(){
       
     	if($this->input->post()){
     		$redirect_page = $this->input->post('redirect_page');
            $this->form_validation->set_rules('oldpassw', 'Old Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('newpassw', 'New Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('confpassw', 'Confirm Password', 'required|matches[newpassw]');
           
      		if($this->form_validation->run() == FALSE){

            $this->index();
      		}else{
	            $admin = $this->session->userdata('admin');
		        $user_id=$admin['id'];
      			$condition=array('id'=>$user_id);
      				
	            $data['users'] = $this->mcommon->getRow('users',$condition);
	          //  print_r($data['users']);die;
	            
	             if(sha1($this->input->post('oldpassw')) == $data['users']['password']) {
	            
	              
	                $condition=array('id'=>$user_id);	
				  	
	                    $data=array(
	                    'password'						=>sha1($this->input->post( 'newpassw' ))
	                     );
	                
	                $this->mcommon->update('users',$condition,$data);

	                
	                if($redirect_page =="dashboard"){
	                	$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible" style="font-size:13px"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Default password is changed successfully. Login with your new credentials</div>');
	                	redirect('admin','refersh'); 
	                }
	                else{
	                	$this->session->set_flashdata('success_msg','Password has been changed successfully');
	                	redirect('admin/changepassword','refersh');
	                }
	                 
	            } else{
	                $this->session->set_flashdata('error_msg','Old password is not correct');
	              	if($redirect_page =="dashboard"){
	              		redirect('admin/defaultChangepassword');
              		}
              		else{
              			$this->index();	 
              		}	                
	            }
            } 
        }else{
            $this->index();	
        }
    }
}