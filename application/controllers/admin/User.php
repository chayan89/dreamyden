<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->redirect_guest();
		$this->admin=$this->session->userdata('admin');
		
		$this->load->model('admin/muser');
	}
	public function index() { 
		$this->_load_list_view();
	}
	public function all_content_list(){
		$list = $this->muser->get_datatables();
        $data = array();
        $no = $_POST['start'];
		$i=1;
        foreach ($list as $person) {
            $no++;
            $row = array();
			$row[]=$i;
            $row[] = $person->name;
            $row[] = $person->email;
            $row[] = $person->company_name;
            $row[] = $person->role_name;
            $row[] = ($person->status==1?'<span style="color:green">Active</span>':'<span style="color:red">Inactive</span>');
            if ($person->role_id != 2) {
            	$edit_delete =  '<a class="cstm_view" href="'.base_url('admin/user/edit/'.$person->id).'" title="Edit"><i class="glyphicon glyphicon-edit"></i></a><a class="cstm_view" id="delete" style="padding-left:5px" href="javascript:void(0)" title="'.$person->id.'"><i class="glyphicon glyphicon-remove"></i></a>';
            }else{
            	$edit_delete = "";
            }
            $row[] = $edit_delete;
            $data[] = $row;
			$i++;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->muser->count_all(),
                        "recordsFiltered" => $this->muser->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
	}
	
	public function edit($id){
		$role_id ='';
		$menu_permission_arr 	= array();
		$data['user']=$this->muser->get_details($id);		
		
		if(empty($data['user'])){
			$this->_load_list_view();
		}else{
			$this->_load_details_view($data);
		}
	}
	
	public function update(){
		if($this->input->post()){
			$id=$this->input->post('user_id');
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('role','Role','required');
			if($this->form_validation->run()==FALSE){
				$data['user']=$this->muser->get_details($id);
				$this->_load_details_view($data);
			}else{
				$condition=array('id'=>$id);
				$company_data	= $this->common_model->getRow('users',array('id'=>$id));

				if(!empty($company_data)){
					$role_id = $company_data['role_id'];
					 $company_id= $company_data['company_id'];
				}
				$udata['name']=$this->input->post('name');
				$udata['email']=$this->input->post('email');
				$udata['role_id']=$this->input->post('role');
				$udata['status']=$this->input->post('status');
				$this->muser->update($condition,$udata);
				// if($role_id =='1'){
				// 	$cond['company_id'] 			=  $company_id;
				// 	$update_arr['name'] 			=  $this->input->post('name');
				// 	$update_arr['company_email'] 	=  $this->input->post('email');

				// 	$this->common_model->update('company_master',$update_arr,$cond);
				// }

				$this->session->set_flashdata('success_msg','User updated successfully');
				redirect('admin/user');
			}
		}else{
			$this->_load_list_view();
		}
	}
	public function add(){
		$this->_load_add_view();
	}
	public function add_content(){
		if($this->input->post()){
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('role','Role','required');
			
			if($this->form_validation->run()==FALSE){
				$this->_load_add_view();
			}else{
				/*-----------added by soma on 17-07-2020----------------------------------*/
				$udata['company_id']=$this->input->post('company_id');
				/*---------------------------------------------*/
				$udata['name']=$this->input->post('name');
				$udata['email']=$this->input->post('email');
				$udata['password']=sha1($this->input->post('password'));
				$udata['role_id']=$this->input->post('role');
				$udata['status']=$this->input->post('status');
				$this->muser->add($udata);
				
				$this->session->set_flashdata('success_msg','User added successfully');
				redirect('admin/user');
			}
		}else{
			$this->session->set_flashdata('error_msg','Please fill up all fields');
			redirect('admin/user/add');
		}
	}
	public function delete_content(){
		$condition['id']=$this->input->post('id');
		$this->muser->delete($condition);
		$response=array('status'=>1,'message'=>'Success');
		echo header('Content-Type: application/json');
		echo json_encode($response);
	}
	private function _load_list_view() {
		$data['content'] = 'admin/user/list';
		$this->load->view('admin/layouts/index', $data);
	}
	private function _load_details_view($parms){
		$data['user']=$parms['user'];	
		$cond['status']  		=  1;   
        $data['company'] 		=  $this->common_model->get('company_master',null, $cond,null,null,null,null,'name','asc',null,null,'result');
        	
		$data['roles'] = $this->muser->get_roles();
		$data['content'] = 'admin/user/detail';
		$this->load->view('admin/layouts/index', $data);
	}
	private function _load_add_view(){
		$cond['status']  		=  1;   
        $data['company'] 		=  $this->common_model->get('company_master',null, $cond,null,null,null,null,'name','asc',null,null,'result');
        
		$data['roles'] = $this->muser->get_roles();
		$data['content']='admin/user/add';
		$this->load->view('admin/layouts/index',$data);
	}
}