<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			if(isManager()==false){
				return redirect('login');
			}
		}
		
		public function index() {
			return redirect('manager/antrag-auf-mehrarbeit/unchecked'); 
		}
		
		public function antrag_auf_mehrarbeit($type) {
			$data['title'] = "Antrag auf Mehrarbeit";
			$uid = get_userId();
			if($type=="checked") {
				$data['managers'] = [];
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['manager_check'=>'1','manager_id'=>$uid]]);
				$this->load->view('manager/list_antrag_auf_mehrarbeit',$data);
			} elseif($type=="unchecked") {
				$data['managers']=[];
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['manager_check'=>'0','manager_id'=>$uid]]);
				$this->load->view('manager/list_antrag_auf_mehrarbeit',$data);
			}  else {
				// show detail here
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$type]]);
				if($chk==null) {
					_flashPop(false,'','Invalid id , try again');
					return redirct('manager/antrag-auf-mehrarbeit/checked');
				} else {
					$data['title'] = "Antrag auf Mehrarbeit Details";
					$data['item'] = $chk;
					$this->load->view('manager/antrag_auf_mehrarbeit_detail',$data);
				}
			}
		}
		
		public function ajax() {
			if($this->input->post('req') == 'mark_checked') {
				$id = $this->input->post('id');
				$chk = $this->model->getData('application_overtime','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo json_encode('Invalid id, try again by refreshing page');die;
					return redirect('manager/index');
				} else {
					$res = $this->model->updateData('application_overtime',['manager_check'=>'1','manager_checked_at'=>date('Y-m-d H:i:s')],$args=['where'=>['id'=>$id]]);
					echo $res?json_encode('1'):json_encode('Error, try again y refreshing page');die;
				}
			}
		} // ajax
	} // end class