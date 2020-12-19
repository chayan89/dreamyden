<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {
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
	 * products = [], u_id
	 * *placeOrder ==> deliveryCharge
	*/
	public function deliveryCharge()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			// if($postData['u_id'] ==""){
			// 	$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
			// 	$this->outputJson($this->response);
			// }
			// $this->auth($postData['u_id']);
			$p_qty = count($postData['products']);
			$charges = $this->common_model->select('delivery_charges', ['status'=> 1]);
			$d_charge = 10;	// default
			if(!empty($charges)){
				foreach($charges as $value){
					$amt = explode('-', $value->item_quantity);
					if(count($amt)>1){
						if($p_qty>=$amt[0] && $p_qty<=$amt[1]){
							$d_charge = round($value->amount, 2);
							break;
						}
					}else{
						if($p_qty>$amt[0]){
							$d_charge = round($value->amount, 2);
							break;
						}
					}
				}
			}
            
            $this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => (object)['delivery_fee'=> $d_charge]));
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}
	/**
	 * @request params 
	 * products = [], u_id, total_amount, delivery_fee
	*/
	public function payment()
	{
		ini_set('display_errors', 1);
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['delivery_fee'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Delivery fee is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['address_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Delivery address is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['total_amount'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Total amount is required'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			
			//Stripe payment start----------------------------------
			// require_once(FCPATH.'vendor/stripe/stripe-php/init.php');

			// \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
			// //\Stripe\Stripe::setClientId(\STRIPE_PUBLISHABLE);
			// try {
			// 	$charge = \Stripe\Charge::create([
			// 		'amount' => ($postData['total_amount']+$postData['delivery_fee']),
			// 		'currency' => 'usd',
			// 		'description' => 'Product Charge',
			// 		'source' => $token,
			// 	  ]);
			// } catch (\Stripe\Exception\OAuth\OAuthErrorException $e) {
			// 	exit('Error: ' . $e->getMessage());
			// }
            /**
             * 1-> scheduled, 2->new, 3->ordered
            */
            $this->data = array(
				'user_id'=> $postData['u_id'],
				'vendor_id'=> $postData['store_id'],
                'order_date'=> date('Y-m-d H:i:s a'),
                'delivery_date'=> isset($postDate['delivery_date'])?$postDate['delivery_date']:date('Y-m-d'),
                'delivery_time'=> $postData['delivery_time'],
                'total_amount'=> $postData['total_amount'],
                'delivery_fee'=> $postData['delivery_fee'],
                'payment_status'=> 'success',
				'order_status'=> 2,	//2=> new
				'address_id'=> $postData['address_id'],
				'request_log'=> file_get_contents('php://input'),
            );
            if($order_id = $this->common_model->add('orders', $this->data)){
				$this->data = [];				
				$this->join = [];
				$this->join[] = ['table' => 'categories c', 'on' => 'c.category_id = products.category_id', 'type' => 'left'];
                foreach($postData['products'] as $item){
					//get item/product info and store in below
					$product_details = $this->common_model->select('products', ['products.product_id'=> $item['product_id']], 'products.*, c.category_name', 'product_id', 'DESC', $this->join);
					$this->data [] = array(
                        'order_id'  => $order_id,
                        'product_id'  => $item['product_id'],
                        'product_name'  => $product_details[0]->product_name,
                        'category_name'  => $product_details[0]->category_name,
                        'price'  => $product_details[0]->price,
                        'quantity' => $item['quantity'],
                        'vendor_id'=> $product_details[0]->vendor_id
                    );
                }
                if($this->data){
					$this->common_model->batch_insert('order_details', $this->data);
					
					//assign delivery boy to this order
					$this->db->where('vendor_id', $postData['store_id']);
					$this->db->order_by('rand()');
					$this->db->limit(1);
					$query = $this->db->get('delivery_vendor');
					$delivery_details = $query->result();
					//print_r($delivery_details);
					if($delivery_details){
						$delivery_boy = $delivery_details[0]->user_id;
					}else{
						$delivery_boy = 1;	//0 assign for admin
					}
					$this->data= array(
						'user_id'	=> $delivery_boy,
						'order_id'	=> $order_id,
						'delivery_status'	=> null,
					);
					$this->common_model->add('assign_delivery', $this->data);

                }
                $this->response = array('status' => array('error_code' => 0, 'message' => 'Payment successfully received'), 'result' => array('data' => (object)['trans_id'=> '1234567890']));

            }else{
                $this->response = array('status' => array('error_code' => 0, 'message' => 'Unable to process payment request'), 'result' => array('data' => $this->obj));
            }
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}

	/** For Delivery
	 * @request params 
	 * u_id, order_type, access_type:3=>delivery boy, 1=>customer
	*/
	public function getOrderedList()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		if (!empty($postData)) {
			ini_set('display_errors', 1);
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST1'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['access_type'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST2'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);
			$where = []; 
			if($postData['access_type'] == 3){
				$where = array(
					'ad.user_id'=> $postData['u_id'],
				);
				//except decline delivery
				$where['ad.delivery_status !=']= 2;
				$this->join[] = ['table' => 'assign_delivery ad', 'on' => 'ad.order_id = o.order_id', 'type' => 'left'];
			}

			//if request from customer end
			if($postData['access_type'] == 1){
				$where['o.user_id']= $postData['u_id'];

				if(isset($postData['upcoming'])){
					if($postData['upcoming'] == 1){
						$where['o.order_status !='] = 3;
					}else{
						$where['o.order_status'] = 3;
					}
				}
			}
			if(isset($postData['order_type']) && !empty($postData['order_type'])){
				$where['order_status'] = $postData['order_type'];
			}
			if(isset($postData['order_id']) && !empty($postData['order_id'])){
				$where['o.order_id'] = $postData['order_id'];
				//to get order details
			}
			//print_r($where);
			$select = 'o.*, u.fname, u.lname, IF(vd.vendor_image IS NULL, "", CONCAT("'.base_url().'uploads/vendor/",vd.vendor_image)) as vendor_image, vd.vendor_name, vd.address vendor_address, u2.mobile vendor_mobile, count(od.quantity) item_quantity, ca.name address, ca.email address_email, ca.phone address_phone, ca.pin address_pin';
			//get delivery status
			if($postData['access_type'] == 3){
				$select .=', ad.delivery_status';
			}
			$this->join[] = ['table' => 'order_details od', 'on' => 'od.order_id = o.order_id', 'type' => 'left'];
			$this->join[] = ['table' => 'users u', 'on' => 'u.user_id = o.user_id', 'type' => 'left'];
			$this->join[] = ['table' => 'customer_address ca', 'on' => 'ca.id = o.address_id', 'type' => 'left'];
			$this->join[] = ['table' => 'vendor_details vd', 'on' => 'vd.vendor_id = o.vendor_id', 'type' => 'left'];
			$this->join[] = ['table' => 'users u2', 'on' => 'u2.user_id = vd.user_id', 'type' => 'left'];

			$this->obj = $this->common_model->select('orders o', $where, $select, 'o.order_id', 'DESC', $this->join, '', '', 'od.order_id');
			//echo $this->db->last_query(); die;
			if(isset($postData['order_id']) && !empty($postData['order_id'])){
				$select = 'order_details.*, IF(p.product_image IS NULL, "", CONCAT("'.base_url().'uploads/product/",p.product_image)) as product_image,';
				$this->join = [];
				$this->join[] = ['table' => 'products p', 'on' => 'p.product_id = order_details.product_id', 'type' => 'left'];
				$list = $this->common_model->select('order_details', ['order_details.order_id'=>$postData['order_id']], $select, 'order_details.product_name', 'ASC', $this->join);
				if($this->obj){
					$this->obj[0]->list = $list;
					$this->obj[0]->product_count = count($list);
				}
			}
                $this->response = array('status' => array('error_code' => 0, 'message' => 'success'), 'result' => array('data' => $this->obj));

            }else{
                $this->response = array('status' => array('error_code' => 0, 'message' => 'BAD REQUEST3'), 'result' => array('data' => $this->obj));
            }
		$this->outputJson($this->response);
	}
	/** By Delivery boy
	 * @request params 
	 * u_id,order_id,accept(1-for accept,2-for decline)
	*/
	public function acceptSchedule()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		//print_r($postData);
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['order_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['accept'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);

			/**
			 * If order is accepted by the delivery
			 * then order status should update to scheduled
			 * Order_status 1->scheduled, 2->new,3->deliveded;4->not-delivered,
			 * Delivery accept=>1, 2=>decline
			 * 
			*/
			$this->data = array(
				'delivery_status' => $postData['accept'],
			);
			if($postData['accept'] == 1){
				$message = "Order accept successfully.";
				$this->common_model->update('orders', ['order_status' => 1], ['order_id'=> $postData['order_id']]);
			}else{
				$message = "Order decline successfully.";
				//$this->data['feedback'] = isset($postData['feedback'])?$postData['feedback']:null;
			}
			
			if($this->common_model->update('assign_delivery', $this->data, ['user_id' => $postData['u_id'], 'order_id'=> $postData['order_id']])){
				$this->response = array('status' => array('error_code' => 0, 'message' => $message), 'result' => array('data' => $this->obj));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to process password'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/** By Delivery boy
	 * @request params 
	 * u_id, order_id , delivery (3-for delivered, 4- for not available, 5-picked up, 6-on the way ), feedback
	*/
	public function updateOrder()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		//print_r($postData);
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['order_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['delivery'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);

			/**
			 * If order is accepted by the delivery
			 * 1-for delivered, 2- for not available, 3-for assign, 4- for not available, 5-picked up, 6-on the way
			 * Order status #3 = delivered #4 = cancelled
			*/
			$message = "Success";
			$this->data = array(
				'delivery_status' => $postData['delivery'],
			);
			if($postData['delivery'] == 1){
				$message = "Order delivered successfully.";
				$order_status = 3;
			}else if($postData['delivery'] == 2){
				$message = "Order not delivered.";
				$order_status = 4;
				$this->data['feedback'] = isset($postData['feedback'])?$postData['feedback']:null;
			}
			
			if($this->common_model->update('assign_delivery', $this->data, ['user_id' => $postData['u_id'], 'order_id'=> $postData['order_id']])){
				//if successfully delivered then update order as well
				if($postData['delivery'] == 1){
					$this->common_model->update('orders', ['order_status' => 3], ['order_id'=> $postData['order_id']]);
				}
				$this->response = array('status' => array('error_code' => 0, 'message' => $message), 'result' => array('data' => $this->obj));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Failed to process password'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}

		$this->outputJson($this->response);
	}
	/**
	 * @request params 
	 * u_id, subscription_id
	*/
	public function saveMembership()
	{
		$this->isJSON(file_get_contents('php://input'));
		$postData = $this->extract_json(file_get_contents('php://input'));
		//print_r($postData);
		ini_set('display_errors', 1);
		if (!empty($postData)) {
			if($postData['u_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			if($postData['subscription_id'] ==""){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$this->auth($postData['u_id']);

			$subscriptionDetails = $this->common_model->select_row('subscription', ['subscription_id'=> $postData['subscription_id']]);
			if(!$subscriptionDetails){
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Incomplete request'), 'result' => array('data' => $this->obj));
				$this->outputJson($this->response);
			}
			$today = date('Y-m-d H:i:s a');
			if(strtolower($subscriptionDetails->subscription_type) == "monthly"){
				$date = date('Y-m-d H:i:s a', strtotime($todat.' +1 month'));
			}else{
				$date = date('Y-m-d H:i:s a', strtotime($todat.' +1 year'));
			}
			$this->data = array(
					'user_id'	=> $postData['u_id'],
					'subscription_id'=> $postData['subscription_id'],
					'subscription_type'=> $subscriptionDetails->subscription_type,
					'subscription_date'=> $today,
					'renew_date'=> $date
				);

			if($this->common_model->add('customer_membership', $this->data)){
				//update membership status
				$this->common_model->update('users', ['membership_status'=> 1],['user_id'=> $postData['u_id']]);
				$this->response = array('status' => array('error_code' => 0, 'message' => 'Success'), 'result' => array('data' => $this->data));
			}else{
				$this->response = array('status' => array('error_code' => 1, 'message' => 'Unable to process subscription process'), 'result' => array('data' => $this->obj));
			}
		}
		else {
			$this->response = array('status' => array('error_code' => 1, 'message' => 'BAD REQUEST'), 'result' => array('data' => $this->obj));
		}
		$this->outputJson($this->response);
	}

	//test stripe integration
	public function test_stripe()
	{
		ini_set('display_errors', 1);
		require_once(FCPATH.'vendor/stripe/stripe-php/init.php');

		\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
		//\Stripe\Stripe::setClientId(\STRIPE_PUBLISHABLE);
		try {
            $customer =  \Stripe\Customer::create(array(
                "email"     => 'a@mail.com',
                "name"      => 'test',
                'address'   => [
                    'line1'         => 'kolkata',
                    'postal_code'   => '2000',
                    'city'          => 'Sydney',
                    'state'         => 'NSW',
                    'country'       => 'AU',
                ],
			));
        } catch (\Stripe\Exception\OAuth\OAuthErrorException $e) {
			exit('Error: ' . $e->getMessage());
		}
	}
}