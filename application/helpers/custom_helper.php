<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('test_input'))
	{
		function test_input($data) {
		  	$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}
	}

	if(!function_exists('isAdmin'))
	{
		function isAdmin() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('role') && $ci->session->userdata('role')=='admin') {
				return true;
			}
		}
	}

	if(!function_exists('isSupervisor'))
	{
		function isSupervisor() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('role') && $ci->session->userdata('role')=='supervisor') {
				return true;
			}
		}
	}
	
	if(!function_exists('isManager'))
	{
		function isManager() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('role') && $ci->session->userdata('role')=='manager') {
				return true;
			}
		}
	}
	
	if(!function_exists('isObjectManager'))
	{
		function isObjectManager() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('role') && $ci->session->userdata('role')=='objektmanager') {
				return true;
			}
		}
	}

	if(!function_exists('isKalk'))
	{
		function isKalk() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('role') && $ci->session->userdata('role')=='kalk') {
				return true;
			}
		}
	}

	if(!function_exists('getCount'))
	{
		function getCount($table,$where) {
			$ci =& get_instance(); //get main CodeIgniter object
			$res = $ci->model->getData($table,'count_array',$args=[$where]);
			return $res;
		}
	}


	if(!function_exists('get_userId'))
	{
		function get_userId() {
			$ci =& get_instance(); //get main CodeIgniter object
			if($ci->session->has_userdata('userId')) {
				return $ci->session->userdata('userId');
			}
		}
	}

	if(!function_exists('_flash'))
	{
		function _flash($success,$successMsg,$failureMsg)
		{
			$ci =& get_instance();
			if($success) {
				$ci->session->set_flashdata('data',$successMsg);
				$ci->session->set_flashdata('class','alert-success');
			} else {
				$ci->session->set_flashdata('data',$failureMsg);
				$ci->session->set_flashdata('class','alert-danger');
			}
		}
	}

	if(!function_exists('_flashPop'))
	{
		function _flashPop($success,$successMsg,$failureMsg)
		{
			$ci =& get_instance();
			if($success) {
				$ci->session->set_flashdata('data',$successMsg);
				$ci->session->set_flashdata('class','success');
			} else {
				$ci->session->set_flashdata('data',$failureMsg);
				$ci->session->set_flashdata('class','error');
			}
		}
	}

	if(!function_exists('send_mail'))
	{
		function send_mail($to,$from,$subject,$msg) {
			$ci =& get_instance(); //get main CodeIgniter object
			$ci->load->library('email');
			$config=array(
				'charset'=>'utf-8',
				'wordwrap'=> TRUE,
				'mailtype' => 'html'
			);
			$ci->email->initialize($config);
			$ci->email->to($to);
			$ci->email->from($from, "Zehm VS");
			$ci->email->subject($subject);
			$ci->email->message($msg);
			return $ci->email->send();
		} 
	}	
	
	if(!function_exists('email_sender'))
	{
		function email_sender() {
			$ci =& get_instance(); //get main CodeIgniter object
			$res = $ci->model->getData('notification','row_array',$args=['where'=>['approved_request'=>'0','new_request'=>'0']]);
			//return $res['admin'];
			$sender = "no-replay@zehm-vs.org";
			return $sender;
		} 
	}
	
?>
