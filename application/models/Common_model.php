<?php
class Common_model extends CI_Model
{

	/**
	 * Responsable for auto load the database
	 * @return void
	 */
	public function __construct()
	{
		$this->load->database();
	}
	function add($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	public function updates($table, $where = array(), $data = array())
	{
		$this->db->where($where);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	function update($table, $data, $condition = null)
	{
		if (isset($condition)) {
			foreach ($condition as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		$this->db->update($table, $data);
		//echo $this->db->last_query();exit;
		return true;
	}
	
	function update1($table, $data, $condition = null)
	{
		if (isset($condition)) {
			foreach ($condition as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update($table, $data);
		//echo $this->db->last_query();exit;
		return true;
	}
	
	
	// public function get($table, $what = null, $condition = null, $limit_start = null, $limit_end = null, $group = null, $condition1 = null, $order_in = null, $order_by = 'DESC', $join = null, $join_type = null)
	// {
	// 	if (isset($what)) {
	// 		foreach ($what as $key => $value) {
	// 			$this->db->select($value);
	// 		}
	// 	} else {
	// 		$this->db->select('*');
	// 	}

	// 	$this->db->from($table);
	// 	if (isset($condition)) {
	// 		foreach ($condition as $key => $value) {
	// 			$this->db->where($key, $value);
	// 		}
	// 	}
	// 	if (isset($condition1)) {
	// 		$this->db->where($condition1);
	// 	}
	// 	if (isset($join)) {
	// 		foreach ($join as $key => $value) {
	// 			$this->db->join($key, $value, $join_type[$key]);
	// 		}
	// 	}
	// 	if ($limit_start != null) {
	// 		$this->db->limit($limit_start, $limit_end);
	// 	}
	// 	if ($group != null) {
	// 		$this->db->group_by($group);
	// 	}

	// 	if ($order_in != null) {
	// 		$this->db->order_by($order_in, $order_by);
	// 	}
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();exit;
	// 	return $query->result_array();
	// }
	public function get($table, $what = null, $condition = null, $limit_start = null, $limit_end = null, $group = null, $condition1 = null, $order_in = null, $order_by = 'DESC', $join = null, $join_type = null,$response = null)
	{
		if (isset($what)) {
			foreach ($what as $key => $value) {
				$this->db->select($value);
			}
		} else {
			$this->db->select('*');
		}

		$this->db->from($table);
		if (isset($condition)) {
			foreach ($condition as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		if (isset($condition1)) {
			$this->db->where($condition1);
		}
		if (isset($join)) {
			foreach ($join as $key => $value) {
				$this->db->join($key, $value, $join_type);
			}
		}
		if ($limit_start != null) {
			$this->db->limit($limit_start, $limit_end);
		}
		if ($group != null) {
			$this->db->group_by($group);
		}

		if ($order_in != null) {
			$this->db->order_by($order_in, $order_by);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if ($response == 'result') {
			return $query->result();
		} 
		elseif($response == 'row') {
			return $query->row();
		}
		else{
			return $query->result_array();
		}
		
	}
	function count($table, $condition = null, $limit_start = null, $limit_end = null)
	{
		$this->db->select('*');
		$this->db->from($table);
		if (isset($condition)) {
			foreach ($condition as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		if ($limit_start != null) {
			$this->db->limit($limit_start, $limit_end);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	function delete($table, $condition = null)
	{
		if (isset($condition)) {
			foreach ($condition as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->delete($table);
		return true;
	}
	function get_time_diff( $start,$end)
	{
		$uts['start'] = strtotime( $start );
		$uts['end'] = strtotime( $end );
		
		if( $uts['start']!==-1 && $uts['end']!==-1 )
		{
			if($uts['end'] >= $uts['start'] )
			{
				$diff = $uts['end'] - $uts['start'];
				//if( $year=intval((floor($diff/(365*86400)))) )
				//	 $diff = $diff % (365*86400);
				//if( $months=intval((floor($diff/(30*86400)))) )
				//	 $diff = $diff % (30*86400);
				
				//if( $days=intval((floor($diff/86400))) )
				//	 $diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )
					 $diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )
					 $diff = $diff % 60;

				$diff = intval( $diff );
				
				//$start= array('years'=>$year,'months'=>$months,'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) ;
				//$start= array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) ;
				//print_r($start);
				
				if(isset($days) && $days>0)
				{
					return $days.' Day(s)';
				}
				elseif($hours>0)
				{
					return $hours.' Hour(s)';
				}
				elseif($minutes>0)
				{
					return $minutes.' Minute(s)';
				}
				elseif($diff>0)
				{
					return $diff.' Seconds';
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
				return false;
		}
	}
	public function fetchUserDetails($user_id)
	{
		$ArrayReturn = array();
		if (isset($user_id) && !empty($user_id)) {
			$userDetails = $this->db->query("SELECT user.id,user.username,user.user_type_id,user.user_designation_id,user_type.type_name,user_designation.designation_name
										  FROM user LEFT JOIN user_type ON user_type.id=user.user_type_id LEFT JOIN user_designation ON user_designation.id=user.user_designation_id WHERE user.id=" . $user_id)->result_array();

			if (!empty($userDetails)) {
				$ArrayReturn['user_id'] = $user_id;
				$ArrayReturn['username'] = isset($userDetails[0]['username']) ? $userDetails[0]['username'] : '';
				$ArrayReturn['first_name'] = '';
				$ArrayReturn['middle_name'] = '';
				$ArrayReturn['last_name'] = '';
				$ArrayReturn['email'] = '';
				$ArrayReturn['phone'] = '';
				$ArrayReturn['alternate_phone'] = '';
				$ArrayReturn['emergency_phone'] = '';
				$ArrayReturn['skype_id'] = '';
				$ArrayReturn['address'] = '';
				$ArrayReturn['permanent_address'] = '';
				$ArrayReturn['salary'] = '';
				$ArrayReturn['user_image'] = base_url() . 'fresh_assets/images/avatar-mini-3.jpg';

				if ($userDetails[0]['user_designation_id'] == 9) {
					$clientsTable = $this->db->query("SELECT clients.first_name,clients.middle_name,clients.last_name,clients.email,clients.phone,clients.skype_id,clients.image,clients.address FROM clients WHERE user_id=" . $user_id)->result_array();
					if (!empty($clientsTable)) {
						$ArrayReturn['first_name'] = isset($clientsTable[0]['first_name']) ? $clientsTable[0]['first_name'] : '';
						$ArrayReturn['middle_name'] = isset($clientsTable[0]['middle_name']) ? $clientsTable[0]['middle_name'] : '';
						$ArrayReturn['last_name'] = isset($clientsTable[0]['last_name']) ? $clientsTable[0]['last_name'] : '';
						$ArrayReturn['email'] = isset($clientsTable[0]['email']) ? $clientsTable[0]['email'] : '';
						$ArrayReturn['phone'] = isset($user_detailsTable[0]['phone']) ? $user_detailsTable[0]['phone'] : '';
						$ArrayReturn['alternate_phone'] = '';
						$ArrayReturn['emergency_phone'] = '';
						$ArrayReturn['skype_id'] = isset($clientsTable[0]['skype_id']) ? $clientsTable[0]['skype_id'] : '';
						$ArrayReturn['address'] = isset($clientsTable[0]['address']) ? strip_tags($clientsTable[0]['address']) : '';
						$ArrayReturn['permanent_address'] = '';
						$ArrayReturn['salary'] = '';

						$ArrayReturn['user_image'] = isset($clientsTable[0]['image']) && $clientsTable[0]['image'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/profile_image/' . $clientsTable[0]['image']) ? base_url() . 'profile_image/thumbs/' . $clientsTable[0]['image'] : base_url() . 'fresh_assets/images/avatar-mini-3.jpg';
					}
				} else {
					$user_detailsTable = $this->db->query("SELECT user_details.first_name,user_details.middle_name,user_details.last_name,user_details.email,user_details.skype_id,user_details.image,user_details.mobile_no,user_details.altername_no,user_details.emergency_no,user_details.address,user_details.permanent_address,user_details.salary FROM user_details WHERE userId=" . $user_id)->result_array();

					if (!empty($user_detailsTable)) {
						$ArrayReturn['first_name'] = isset($user_detailsTable[0]['first_name']) ? $user_detailsTable[0]['first_name'] : '';
						$ArrayReturn['middle_name'] = isset($user_detailsTable[0]['middle_name']) ? $user_detailsTable[0]['middle_name'] : '';
						$ArrayReturn['last_name'] = isset($user_detailsTable[0]['last_name']) ? $user_detailsTable[0]['last_name'] : '';
						$ArrayReturn['email'] = isset($user_detailsTable[0]['email']) ? $user_detailsTable[0]['email'] : '';
						$ArrayReturn['phone'] = isset($user_detailsTable[0]['mobile_no']) ? $user_detailsTable[0]['mobile_no'] : '';
						$ArrayReturn['alternate_phone'] = isset($user_detailsTable[0]['altername_no']) ? $user_detailsTable[0]['altername_no'] : '';
						$ArrayReturn['emergency_phone'] = isset($user_detailsTable[0]['emergency_no']) ? $user_detailsTable[0]['emergency_no'] : '';
						$ArrayReturn['skype_id'] = isset($user_detailsTable[0]['skype_id']) ? $user_detailsTable[0]['skype_id'] : '';
						$ArrayReturn['address'] = isset($user_detailsTable[0]['address']) ? strip_tags($user_detailsTable[0]['address']) : '';
						$ArrayReturn['permanent_address'] = isset($user_detailsTable[0]['permanent_address']) ? strip_tags($user_detailsTable[0]['permanent_address']) : '';
						$ArrayReturn['salary'] = isset($user_detailsTable[0]['salary']) ? $user_detailsTable[0]['salary'] : '';

						$ArrayReturn['user_image'] = isset($user_detailsTable[0]['image']) && $user_detailsTable[0]['image'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/profile_image/' . $user_detailsTable[0]['image']) ? base_url() . 'profile_image/thumbs/' . $user_detailsTable[0]['image'] : base_url() . 'fresh_assets/images/avatar-mini-3.jpg';
					}
				}

				$ArrayReturn['user_type'] = isset($userDetails[0]['type_name']) ? $userDetails[0]['type_name'] : '';
				$ArrayReturn['user_designation_id'] = isset($userDetails[0]['user_designation_id']) ? $userDetails[0]['user_designation_id'] : '';
				$ArrayReturn['user_designation'] = isset($userDetails[0]['designation_name']) ? $userDetails[0]['designation_name'] : '';

				$memberTabPermissionArr = array(1, 3, 7, 11, 12);
				if (in_array($userDetails[0]['user_designation_id'], $memberTabPermissionArr)) {
					$ArrayReturn['memberTabAppear'] = 'Y';
				} else {
					$ArrayReturn['memberTabAppear'] = 'N';
				}

				$ArrayReturn = array_map('strval', $ArrayReturn);
			}
		}
		return $ArrayReturn;
	}
	
	public function uploadImage($field,$DIR)
	{
		$return = false;
		if(!empty($_FILES[$field]['name']))
		{
			$allowed =  array('gif','png' ,'jpg','jpeg','JPG','JPEG','PNG','GIF');
			$ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
			if(in_array($ext,$allowed))
			{
				$filename=time().rand(0,99)."_".$field.".".$ext;
				move_uploaded_file($_FILES[$field]['tmp_name'],$DIR.$filename);
				
				$return = $filename;
			}
		}
		return $return;
	}
	
	public function mail($companyName='',$email_from='',$email_to='',$subject,$message,$IsSMTP=true)
	{
		if(!empty($email_to))
		{
			if($IsSMTP)
			{
				$config['protocol']     = 'smtp';
				$config['smtp_host']    = '';
				$config['smtp_port']    = '465';
				$config['smtp_user']    = '';
				$config['smtp_pass']    = '';
				$config['charset']      = 'utf-8';
				$config['newline']      = "\r\n";
				$config['mailtype']     = 'html'; // or html
				$config['validation']   = TRUE; // bool whether to validate email or not 
			}
			else
			{
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
			}
			
			$this->email->initialize($config);
			$this->email->from($email_from, $companyName);
			
			$this->email->to($email_to);
			$this->email->cc('santu.dutta@met-technologies.com');
			$this->email->subject($subject);
			$this->email->message($message);
			return $this->email->send();
		}
		else
		{
			return false;
		}
	}

	/**
	 *  Function By chayan
	 */
	public function select_row($table = '', $where = array(), $select = '', $join = array())
	{
		if (empty($select)) {
			$this->db->select('*');
		} else {
			$this->db->select($select);
		}
		if (!empty($join)) {
			foreach ($join['table'] as $key => $j) {
				$this->db->join($join['table'][$key], $join['on'][$key], $join['type'][$key]);
			}
		}
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get($table)->row();
		return $result;
	}
	public function select($from, $where = array(), $select = '', $order_by = '', $mode = '', $join = array(), $limit = '', $offset = 0, $group_by = '', $order_by2 = '')
	{
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($from);
		if (!empty($join)) {
			foreach ($join as $qry) {
				$this->db->join($qry['table'], $qry['on'], $qry['type']);
			}
		}
		if (!empty($where)) {
			$this->db->where($where);
		}
		
		if (!empty($group_by)) {
			$this->db->group_by($group_by);
		}
		if ($order_by && $mode) {
			$this->db->order_by($order_by, $mode);
		} else {
			$this->db->order_by($order_by);
		}
		// only for dispatched incident listing
		if($order_by2){
			$this->db->order_by($order_by2, $mode);
		}
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		//echo $this->db->last_query();
		return $this->db->get()->result();
	}
	public function select2($from, $where = array(), $select = '', $order_by = '', $mode = '', $join = array(), $limit = '', $offset = 0, $group_by = '')
	{
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($from);
		if (!empty($join)) {
			foreach ($join as $qry) {
				$this->db->join($qry['table'], $qry['on'], $qry['type']);
			}
		}
		if (!empty($where)) {
			if(array_key_exists('fetchStatus', $where)){
				if($where['fetchStatus'] == 'self'){
					$this->db->where('i.company_user_id = i.created_by');
				}else{
					$this->db->where('i.company_user_id != i.created_by');
				}
				unset($where['fetchStatus']);
			}
			$this->db->where($where);
		}
		if (!empty($group_by)) {
			$this->db->group_by($group_by);
		}
		if ($order_by && $mode) {
			$this->db->order_by($order_by, $mode);
		} else {
			$this->db->order_by($order_by);
		}
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		echo $this->db->last_query();exit;
		return $this->db->get()->result();
	}
	public function getStateDetails($ids)
	{
		$this->db->select('state_id, state_name, country_id');
		$this->db->where_in('state_id', $ids);
		return $this->db->get('state_master')->result_array();
	}

	//by chayan
	public function batch_insert($table, $dataArray)
	{
		$this->db->insert_batch($table,  $dataArray);
		return true;
	}
	public function batch_update($table, $data, $condition)
	{
		$this->db->update_batch($table, $data, $condition);
		// echo $this->db->last_query();

		return 1;
	}


	public function getDetails($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		return $query->result_array();
	}

	public function getNumRows($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query(); exit();
		$res = array();

		return $query->num_rows();
	}
	public function getRow($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query(); exit();
		return $query->row_array();
	}
	public function getViewDetails($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query(); exit();
		return $query->row();
	}
	public function checkUser($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		return $query->row_array();
	}

	public function getFullDetails($table)
	{
		$query = $this->db->get($table);
		return $query->result_array();
	}
	public function joinQuery($data, $condition = null, $return_type, $order_by = null, $order_type = 'ASC')
	{
		//pr($data,0);
		if (array_key_exists('select', $data) && $data['select'] != "") {
			$this->db->select($data['select']);
		} else {
			$this->db->select('*');
		}
		$this->db->from($data['first_table']);

		if (array_key_exists('second_table', $data) && array_key_exists('dependency1', $data) && array_key_exists('join_type1', $data)) {
			if ($data['second_table'] != "" && $data['dependency1'] != "" && $data['join_type1'] != "") {
				$this->db->join($data['second_table'], $data['dependency1'], $data['join_type1']);
			}
		}
		if (array_key_exists('third_table', $data) && array_key_exists('dependency2', $data) && array_key_exists('join_type2', $data)) {
			if ($data['third_table'] != "" && $data['dependency2'] != "" && $data['join_type2'] != "") {
				$this->db->join($data['third_table'], $data['dependency2'], $data['join_type2']);
			}
		}
		if (array_key_exists('forth_table', $data) && array_key_exists('dependency3', $data) && array_key_exists('join_type3', $data)) {
			if ($data['forth_table'] != "" && $data['dependency3'] != "" && $data['join_type3'] != "") {
				$this->db->join($data['forth_table'], $data['dependency3'], $data['join_type3']);
			}
		}
		if (array_key_exists('fifth_table', $data) && array_key_exists('dependency4', $data) && array_key_exists('join_type4', $data)) {
			if ($data['fifth_table'] != "" && $data['dependency4'] != "" && $data['join_type4'] != "") {
				$this->db->join($data['fifth_table'], $data['dependency4'], $data['join_type4']);
			}
		}
		if (array_key_exists('sixth_table', $data) && array_key_exists('dependency5', $data) && array_key_exists('join_type5', $data)) {
			if ($data['sixth_table'] != "" && $data['dependency5'] != "" && $data['join_type5'] != "") {
				$this->db->join($data['sixth_table'], $data['dependency5'], $data['join_type5']);
			}
		}
		if (array_key_exists('seventh_table', $data) && array_key_exists('dependency6', $data) && array_key_exists('join_type6', $data)) {
			if ($data['seventh_table'] != "" && $data['dependency6'] != "" && $data['join_type6'] != "") {
				$this->db->join($data['seventh_table'], $data['dependency6'], $data['join_type6']);
			}
		}
		if (array_key_exists('eighth_table', $data) && array_key_exists('dependency7', $data) && array_key_exists('join_type7', $data)) {
			if ($data['eighth_table'] != "" && $data['dependency7'] != "" && $data['join_type7'] != "") {
				$this->db->join($data['eighth_table'], $data['dependency7'], $data['join_type7']);
			}
		}
		if (array_key_exists('ninth_table', $data) && array_key_exists('dependency8', $data) && array_key_exists('join_type8', $data)) {
			if ($data['ninth_table'] != "" && $data['dependency8'] != "" && $data['join_type8'] != "") {
				$this->db->join($data['ninth_table'], $data['dependency8'], $data['join_type8']);
			}
		}
		$this->db->where($condition);
		$this->db->order_by($order_by, $order_type);
		//ORDER BY `menu_rank` ASC
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			if ($return_type == 'result') {
				return $query->result_array();
			} elseif ($return_type == 'row') {
				return $query->row_array();
			}
		} else {
			return false;
		}
	}
	
	public function check_already_exist($table = '', $where = array(), $select = '')
	{
		if (empty($select)) {
			$this->db->select('*');
		} else {
			$this->db->select($select);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get($table);
		if ($result->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function check_email_exist($email,$company_id,$role_id){

		$admin=$this->session->userdata('admin');
		//print_r($admin);die;
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('role_id', $role_id);
        //$this->db->where('company_id !=', $company_id);
        $this->db->where('company_id !=', $admin['company_id']);
        $this->db->where('id !=', $admin['id']);
       
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $num = $query->num_rows();
        //echo "hi".$num;exit;
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }
	
}
