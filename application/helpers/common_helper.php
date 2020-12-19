<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function send_mail($params){
      $params['config']=emailSettings();
      sendEmail($params);
      return 1;
   }
   function emailSettings(){
      $config['protocol']    = 'smtp';
       $config['smtp_host']    = '';
       $config['smtp_port']    = '465';
       $config['smtp_user']    = '';
       $config['smtp_pass']    = '';
       $config['charset']    = 'utf-8';
       $config['newline']    = "\r\n";
       $config['mailtype'] = 'html'; // or html
       $config['validation'] = TRUE; // bool whether to validate email or not
       return $config;
   }
   function sendEmail($params){
    $obj =get_object();
    $obj->load->library('email');
    $obj->email->initialize($params['config']);
    $obj->email->from($params['from_email'], $params['name']);
    $obj->email->to($params['to']);
    $obj->email->subject($params['subject']);
    $obj->email->message($params['message']);
    $obj->email->set_crlf( "\r\n" );
    return $obj->email->send();
}


    function get_object(){
      $obj =& get_instance();
      return $obj;
    }

    //getRow
    function getRow($table, $condition){
        $obj =& get_instance();
        $obj->db->where($condition);
        $query=$obj->db->get($table);
        return $query->row_array();
    } 
    /*
      author: SREELA
      date: 21-9-2019
    */
    if (!function_exists('pr')) {
        function pr($arr,$e=1) {
            if(is_array($arr)) {
                echo "<pre>";
                print_r($arr);
                echo "</pre>";
            } else {
                echo "<br>Not an array...<br>";
                echo "<pre>";
                var_dump($arr);
                echo "</pre>";
            }
            if($e==1)
                exit();
            else
                echo "<br>";
        }
    }   
}