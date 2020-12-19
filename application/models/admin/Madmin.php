<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madmin extends CI_Model {

	public function user_check($email, $password) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(array('email' => $email, 'password' => sha1($password)));
        $query = $this->db->get();
        //echo $this->db->last_query();exit();
        return $query->row_array();
    }

    public function update($condition,$data){
        $this->db->where($condition);
        $this->db->update('users',$data);
        return 1;
    }
}