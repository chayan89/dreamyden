<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log extends MY_Controller {

	public function __construct() {
		parent::__construct();
	$this->load->model('mcommon');
	$this->load->model('common_model');	
	}
	public function index()
	{
		$this->checkAdminAuth();
		$this->data = [];
		$this->data['details'] = $this->mcommon->getRows('activity_log',$condition=array('status= '=>1));
		$this->data['page'] = 'admin/activity_log/index';
		$this->load_view($this->data);
	}

	/**
	 * Load category add view
	 */
	public function add($id = null)
	{
		$this->checkAdminAuth();
		$this->data['page'] = 'admin/activity_log/add';
		$this->load_view($this->data);
	}

	public function activitylog_save()
	{
		$this->isJSON(file_get_contents('php://input'));
        $postData = $this->extract_json(file_get_contents('php://input'));
		$this->data['order_id'] = $postData['order_id'];
		$this->data['activity'] = $postData['activity'];
		$this->data['activity_date'] = date('Y-m-d H:i:s');
		$this->data['status']	  = 1;			
	     $activity=$this->common_model->add('activity_log', $this->data);
	     if($activity) {
         $this->response = array('status' => array('error_code' => 0, 'message' => 'Status Changed Successfully'), 'result' => array('data' => $this->data));
		 } else {
         $this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to Parse Request Data'), 'result' => array('data' => $this->data));
        }

        $this->outputJson($this->response);
	   
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
		$this->data['page'] = 'admin/activity_log/view';
		$this->load_view($this->data);
	}

}