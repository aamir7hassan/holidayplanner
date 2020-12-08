<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			//print isKalk();
			
			if(isKalk()==false){
				return redirect('login');
			}
		}
		
		public function index() {
			$data["title"]="Objekte";
			$data["objects"]=$this->model->getData("objects","all_array",$args=[]);
              
			   $q1='select * from users where role=2 order by lname';
			   $data["supervisors"] = $this->model->query($q1,'all_array');
			   $q='select * from object_nl order by nl_name';
			   $data["object_nl"] = $this->model->query($q,'all_array');
              
			$this->load->view('kalk/index',$data); 
		}
		
		public function ajax() {
			if($this->input->post('req') == 'add_objekt') {
				$post=$this->input->post();
				if($post['begin_date']!=""){
					//$begin_date=date('Y-m-d',strtotime($post['begin_date']));
					$begin_date=date('d.m.Y',strtotime($post['begin_date']));
					$post['begin_date']=$begin_date;
				}
				if($post["end_date"]!=""){
					//$end_date=date('Y-m-d',strtotime($post['end_date']));
					$end_date=date('d.m.Y',strtotime($post['end_date']));
					$post['end_date']=$end_date;
				}

				$data=array(
				  "ktr_number"=>$post["ktr_number"],
					"object_name"=>$post["object_name"],
					"object_nl"=>$post["object_nl"],
					"object_supervisor"=>$post["object_supervisor"],
					"begin_date"=>$post["begin_date"],
					"end_date"=>$post["end_date"],
					"created_by"=>$this->session->userdata["userId"],
					"date_created"=> date('Y-m-d H:i:s')
				);
			   

				$res=$this->model->insertData("objects",$data);
				if($res){
					_flashPop($res,'Objekt','Objekt Added Successfully!');
					redirect("kalk");
				}else{
					_flashPop($res,'Objekt','Objekt Added Successfully!');
					redirect("kalk");
				}
               }
               if($this->input->post('req') == 'edit_objekt') {
				$post=$this->input->post();
				$id=$post['id'];
				$data=array(
				    "ktr_number"=>$post["ktr_number"],
					"object_name"=>$post["object_name"],
					"object_nl"=>$post["object_nl"],
					"object_supervisor"=>$post["object_supervisor"],
					"begin_date"=>$post["begin_date"],
					"end_date"=>$post["end_date"],
				);
				$res = $this->model->updateData('objects',$data,$args=['where'=>['id'=>$id]]);
				if($res)
				{
					echo json_encode('1');die;
				}
				else
				{
					echo json_encode('0');die;
				}
               }
               if($this->input->post('req') == 'delete_objekt') {
				$id = $this->input->post('id');
				$res = $this->model->deleteData('objects',['id'=>$id]);
				if($res)
				{
					echo json_encode('1');die;
				}
				else
				{
					echo json_encode('0');die;
				}
               }
               if($this->input->post('req') == 'get_objekt') {
				$id = $this->input->post('id');
				$res = $this->model->getData('objects','row_array',$args=['where'=>['id'=>$id]]);
				if($res['end_date']=="")
				{
				 $res['begin_date']=date('m/d/Y',strtotime($res['begin_date']));
				$res['end_date']="00-00-0000";
				
				echo json_encode($res);die;	
				}
				else{
				$res['begin_date']=date('m/d/Y',strtotime($res['begin_date']));
				$res['end_date']=date('m/d/Y',strtotime($res['end_date']));
				echo json_encode($res);die;	
				}				
				
			}
		} // ajax
	} // end class