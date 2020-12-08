<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Supervisors extends CI_Controller
	{
		private $path = "admin/supervisors/";
		public function __construct()
		{
			parent::__construct();
			if(isAdmin()==false){
				return redirect('login');
			}
		}

		public function index() {
			$data['title'] = "Bereichsleiter";
			$data['supervisors'] = $items = $this->model->getData('users','all_array',$args=['where'=>['role'=>'2']]);
			$this->load->view($this->path .'index',$data);
		}

		public function add()
		{
			$data['title'] = 'Bereichsleiter hinzuf&uuml;gen';
			$this->load->view($this->path . 'add',$data);
		}

		public function ajax() {

		} // end ajax
	} // end class Dashboard
?>