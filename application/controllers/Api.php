<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api extends CI_Controller
{
  var $arr;
  var $obj;

  function __construct()
  {
    parent::__construct();
    //$this->load->library('PushNotification');
    $this->load->model('mapi');
    $this->arr = array();
    $this->obj = new stdClass();
    $this->http_methods = array('POST', 'GET', 'PUT', 'DELETE');
    $this->logo = base_url() . 'public/images/logo_new.jpg';
    //$this->load->library('notification');
  }

  private function displayOutput($response)
  {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($response);
    exit(0);
  }
    private function checkHttpMethods($http_method_type)
  {
    if ($_SERVER['REQUEST_METHOD'] == $http_method_type) {
      return 1;
    }
  }
    public function SaveData(){
      
        $response   = array();
        $input_data = array();
         if ($this->checkHttpMethods($this->http_methods[0])) {
            if (!empty($this->input->post())) {
                $ap = $this->input->post();

              ///company and campaign data
              $campaign_no=$ap['campaign_generated_no'];
              //getting campaign and company info
              $table="campaign_master";
              $condition['campaign_generated_no']=$campaign_no;
              $campaign_row=$this->mapi->getRow($table,$condition);
              //echo $this->db->last_query();
              //print_r($campaign_row);
              if(empty($campaign_row))
              {
                  $response['status']['error_code'] = 1;
                  $response['status']['message']    = 'Invalid campaign';     
                  $this->displayOutput($response);
              }

              $company_id=$campaign_row['company_id'];
              $campaign_id=$campaign_row['campaign_id'];
              
                
              $input_data['title']            = $ap['d_title'];
          		$input_data['name']             = $ap['d_fname'];
          		$input_data['lname']            = $ap['d_lname'];
          		$input_data['email_id']         = $ap['d_email'];
          		$input_data['phone']            = $ap['d_mobile'];
          		$input_data['state']            = $ap['d_state'];
          		$input_data['domain_website']   = $ap['d_site'];
          		$input_data['requirement']      = $ap['d_interest'];
          		$input_data['source']           = $ap['d_ref'];
          		//$input_data['post_date']        = date('Y-m-d');

              $input_data['company_id']           = $company_id;
              $input_data['campaign_id']          = $campaign_id;

          		$id = $this->db->insert('new_project',$input_data);
          		if($id){
          		    $response['status']['error_code']            = 0;
			        $response['status']['message']               = 'Successful';
          		}
          		else{
    			  $response['status']['error_code'] = 1;
    			  $response['status']['message']    = 'Sorry! data save is unsuccessful.';
    			}
            }
			else {
                $response['status']['error_code'] = 1;
                $response['status']['message']    = 'Please fill up all required field';        
            }
        } 
        else {
            $response['status']['error_code'] = 1;
            $response['status']['message']    = 'Wrong http method type.';
              //$response['response']   = $this->obj;      
        }
        $this->displayOutput($response);
    }

}