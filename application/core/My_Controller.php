<?php 
	class My_Controller extends CI_Controller 
	{
		function __construct() {
			
			parent::__construct();
			$this->load->helper('cookie');
			$cookie = array(
				'name'	=> 'uri',
				'value'	=> urlencode(uri_string()),
				'expire'=> '600', // 10 min, after 10 mins cookie will be deleted.
			); 
			$this->input->set_cookie($cookie);
		}
	}
?>