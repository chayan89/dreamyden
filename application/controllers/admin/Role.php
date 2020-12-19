<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->redirect_guest();
        $this->admin = $this->session->userdata('admin');
        
        $this->load->model('common_model');
    }
    private function outputJson($response){
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    public function index()
    {
        $data['content']        = 'admin/role/list';
        $this->load->view('admin/layouts/index', $data);
    }
    public function save()
    {
       if($this->input->post()){
          //pr($_POST);
        
            if(empty(trim($this->input->post('rId')))){     
            
                $insertArray = [
                    "role_name"                 => $this->input->post('role_name'),
                    "company_id"                => $this->input->post('company_id')                    
                ];

                $insert_id  = $this->common_model->add('roles', $insertArray);
                if($insert_id){
                    $menu_id    = $this->input->post('menu_id');
                    if(!empty($menu_id)){                       
                        foreach($menu_id as $list){
                            $instarr = array(   'role_id'   =>$insert_id,
                                                'menu_id'   =>$list
                                            );
                            $this->common_model->add('user_permission',$instarr);
                        }               
                    }
                   
                    $this->session->set_flashdata('success_msg', 'New Role Successfully Added !!!');
                    //$this->session->set_flashdata('color', '#7cff9a');
                }else{
                    $this->session->set_flashdata('error_msg', 'Unable to add role!!');
                    //$this->session->set_flashdata('color', '#ff394c');
                }
            } else {
                //echo "hdga";exit;
                $this->updateArray = [
                    "role_name"                 => $this->input->post('role_name'),                 
                    "date_of_update"            => date('Y-m-d h:i:s')
                ];
                
                if($this->common_model->update('roles',$this->updateArray, array("role_id" => $this->input->post('rId')))){
                    $menu_id    = $this->input->post('menu_id');
                    if(!empty($menu_id)){
                        $menu_list  = $this->common_model->getDetails('user_permission',array('role_id' =>$this->input->post('rId')));
                        if(!empty($menu_list)){
                            $this->db->delete('user_permission', array('role_id' => $this->input->post('rId')));                        
                        }   
                        foreach($menu_id as $list){
                            $instarr = array(   'role_id'   =>$this->input->post('rId'),
                                                'menu_id'   =>$list
                                            );
                            $this->common_model->add('user_permission',$instarr);
                        }               
                    }
                    $this->session->set_flashdata('success_msg', 'Role Successfully Updated !!!');
                    //$this->session->set_flashdata('color', '#7cff9a');
                }else{
                    $this->session->set_flashdata('error_msg', 'Unable to update role!!!');
                    //$this->session->set_flashdata('color', '#ff394c');
                }
            }
        }
        redirect('admin/role/list');
    }
    public function getRoleList(){
        
        $where = array();
        if($this->admin['role_id'] !='2'){
            $cond['roles.company_id'] =  $this->admin['company_id'];
        }
        $cond['roles.status !=']  =  3;   
        $selectarr = array('roles.*','company_master.name');
        $joinarr['company_master']     =   'roles.company_id=company_master.company_id';
         
        $dataObj            =  $this->common_model->get('roles',$selectarr, $cond,null,null,null,null,'roles.role_id','desc',$joinarr,'left','result');
        $data['details']    = $dataObj;
        //pr($data['details']);
        $html = $this->load->view('admin/role/ajax_list', $data, true);
        //print $html;
        $this->response=array('status'=>array('error_code'=>0,'message'=>'Success'),'result'=>$html);
        $this->outputJson($this->response);
    }
    public function add($id=''){
        $menu_permission_arr            = array();
        $where['status']                =   1; 
        $data['menu']                   =   $this->common_model->get('menu_master',null,$where,null,null,null,null,null,null,null,null,'result');
          
        $data['company']                =   $this->common_model->get('company_master',null, $where,null,null,null,null,'name','asc',null,null,'result');
        
        if ($id != '') {
            $where['role_id']           =   $id;
            $where['status !=']         =   3; 
            $data['role']               =   $this->common_model->get('roles',null,$where,null,null,null,null,null,null,null,null,'row');
            $where['role_id']           =   $id;
            $menu_permission            =   $this->common_model->get('user_permission',null,$where,null,null,null,null,null,null,null,null,'result');
            if(!empty($menu_permission)){
                foreach($menu_permission as $val){
                    $menu_permission_arr[] = $val->menu_id;
                }
            }
        }
        //pr($data['menu']); 
        
        $data['menu_permission'] = $menu_permission_arr;
        $data['content']        = 'admin/role/add';
        $this->load->view('admin/layouts/index', $data);

    }
    public function delete(){
        //pr($_POST);
        if($this->input->post()){
            $id = $this->input->post('id');
            $table = $this->input->post('table');

            if($this->common_model->update($table,array('status'=>'3'),array('role_id'=>$id))){
                $response['status'] =1;
                $response['message'] = "Deleted successfully done.";
            }else{
                $response['status'] =0;
                $response['message'] = "Unable to deleted.";
            }

            echo json_encode($response);
        }
    }
    
}