<?php

class Checklisten extends CI_Controller

{
	public function __construct()
		{
			parent::__construct();
			if(isSupervisor()==false) {
				return redirect('login');
			}
		}

/*
		public function index() {
			$id=$this->session->userdata('userId');
			
			$des=$this->model->getData('cl_desc','all_array',$args=[]);
			$objects=$this->model->getData('cl_lists','all_array',$args=['where'=>['sv_id'=>$id]]);
			$objectss=$this->model->getData('objects','all_array',$args=['where'=>['object_supervisor'=>$id]]);
			
			$cl_lists=$this->model->getData('cl_lists','all_array',$args=[]);
			$this->load->view('supervisor/checklisten',['object'=>$objects,'des'=>$des,'cl_lists'=>$cl_lists,'objectss'=>$objectss]);			
}*/

		public function detail_view() {
			$id=$this->uri->segment(4);
			$data=$this->model->getData('cl_lists','row_array',$args=['where'=>['id'=>$id]]);
			$des=$this->model->getData('cl_desc','all_array',$args=[]);
			$this->load->view('admin/detail_view',['item'=>$data,'des'=>$des]);
		}

		public function filter() {
			$id=$this->session->userdata('userId');
			$objectss=$this->model->getData('objects','all_array',$args=['where'=>['object_supervisor'=>$id],'order'=>['col'=>'object_name','type'=>'asc']]);
			$om = $items = $this->model->getData('users','all_array',$args=['where'=>['role'=>'5']]);

			$type=$this->uri->segment(3);
		  if ($type=="open") {
			  $data["title"] ="Checklisten offen";
			  $des=$this->model->getData('cl_desc','all_array',$args=[]);
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>0,'locked'=>0,'sv_id'=>$id]]);
				$this->load->view('supervisor/open',['object'=>$dataa,'des'=>$des,'objectss'=>$objectss, 'om'=>$om,'title'=>$data["title"]]);
		  }
		 	else if ($type=="checked") {
			  $data["title"] ="Checklisten abgegeben";
			  $des=$this->model->getData('cl_desc','all_array',$args=[]);
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>1,'sv_id'=>$id]]);
				$this->load->view('supervisor/checked',['object'=>$dataa,'des'=>$des,'objectss'=>$objectss, 'om'=>$om,'title'=>$data["title"]]);   
		 	}
			else if ($type=="locked") {
				$data["title"] ="Checklisten gesperrt";
			  $des=$this->model->getData('cl_desc','all_array',$args=[]);
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>0,'locked'=>1,'sv_id'=>$id]]);
				$this->load->view('supervisor/locked',['object'=>$dataa,'des'=>$des,'objectss'=>$objectss, 'om'=>$om,'title'=> $data["title"]]); 
		  }
		}
		
		public function ajax() {
			if($this->input->post('req')=='delete_obj') {
				$id=$this->input->post('id');
				$res=$this->model->deleteData("cl_lists",["id"=>$id]);
				if($res) {
					echo json_encode('1');die;
				}
			}
             if($this->input->post('req')=='checkdata')
			 {    
		          $arr=[];
				  $i=0;
				  $radiovalue=$this->input->post('radio');
				  foreach($radiovalue as $key=>$data)
				  {
					 $arr[$i++]=$data;
				  }
				  if($arr)
				  {
					  echo json_encode(['arr'=>$arr]);die;
					  
				  }else{echo json_encode('0');die;}
				 
				 
			 }
			if($this->input->post('req')=='add_checklist') {
					$id=$this->input->post('id');
					$today = date("d.m.Y H:i:s");
					$data=$this->model->getData('objects','row_array',$args=['where'=>['id'=>$id]]);
					$nl_id=$data['object_nl'];
					$object_nl=$this->model->getData('object_nl','row_array',$args=['where'=>['id'=>$nl_id]]);
					$supervisor_id=$data['object_supervisor'];
					$objects=$this->model->getData('users','row_array',$args=['where'=>['id'=>$supervisor_id]]);
					$value=['object_name'=>$data['object_name'],'ktr_number'=>$data['ktr_number'],'object_nl'=>$object_nl['nl_name'],'begin_date'=>$data['begin_date'],'end_date'=>$data['end_date'],
					'created_by'=>'2','object_supervisor'=>$objects['lname'],'sv_id'=>$data['object_supervisor'],'date_created'=>$today,/*'check_date'=>'0000-00-00'*/
				];
			
				$res = $this->model->insertData('cl_lists',$value);
				if($res) {
					echo json_encode('1');die;
				}
			}

			if($this->input->post('req')=='checked_data') {
				$id=$this->input->post('id');
				
				$res=$this->model->getData('cl_lists','all_array',$args=[]);
				if($res){
					echo json_encode(['data'=>$res]);die;
				}
				else{
					echo json_encode('0');die;
				}				
			}

			if($this->input->post('req')=='recheck_list') {
  			$today = date("d.m.Y H:i:s");
				$id=$this->input->post('id');
				$data=$this->model->getData('cl_lists','row_array',$args=['where'=>['id'=>$id]]);
				$supervisor_id=$data['object_supervisor'];
				$objects=$this->model->getData('users','row_array',$args=['where'=>['id'=>$supervisor_id]]);
				$value=['object_name'=>$data['object_name'],'ktr_number'=>$data['ktr_number'],'object_nl'=>$data['object_nl'],'begin_date'=>$data['begin_date'],'end_date'=>$data['end_date'],'re_check'=>$id,
				'created_by'=>'2','object_supervisor'=>$data['object_supervisor'],'sv_id'=>$data['sv_id'],'date_created'=>$today];
				$res = $this->model->insertData('cl_lists',$value); 
			
				if($res){echo json_encode('1');die;}
			}

			 if($this->input->post('req')=='checklist')
			 {   
		            
		    $today = date("d.m.Y H:i:s");
				$staff=$this->input->post('text');
				$notes=$this->input->post('note');
				$id=$this->input->post('id');
				$des=$this->model->getData('cl_desc','all_array',$args=[]);
				
				 $radiovalue=$this->input->post('radio');
				 $check5=false;
				 foreach($radiovalue as $key => $data)
				 
				 {  
					if($data!="on" ){
					foreach($des as $val)
					{
						if($val['id']==$key)
						{
							$cat=$val['cat'];
							$rang=$val['rang'];
							$value=$data;
							$rating[]=$cat.','.$rang.','.$data.';';
							
						}
						
					}
					} 
				 }
				
				
				$rating=implode("",$rating);
				 $des=$this->model->getData('cl_desc','all_array',$args=[]);
					
					$sum=0;
					$c=0;
					foreach($des as $d){
														
					$rat=explode(';',$rating);
					$count=count($rat);
					for($i=0; $i<$count; $i++)
					{
				    $rat1=explode((","),$rat[$i]);
					
                    $cat=$d['cat'];
                    $rang=$d['rang'];
				    if($cat==$rat1[0] && $rang==$rat1[1])
					{
					   $c++;
					   $rat2=$rat1[2];
					   $sum=$sum+$rat2;
															  
					}
				}
					}
				$avg=$sum/$c;
				$total_avg= number_format($avg, 2);
				
				 $objects=$this->model->getData('cl_lists','row_array',$args=['where'=>['id'=>$id]]);
				 $supervisor_id=$objects['sv_id'];
				 
				 $users=$this->model->getData('users','row_array',$args=['where'=>['id'=>$supervisor_id]]);
				 $object['notes']=$notes;
				 $object['staff']=$staff;
				 $object['checked']='1';
				 $object['rating']=$rating;
				 $object['avg']=$total_avg;
				 $object['check_date']=$today;
				//  $object['created_by']= $users['role'];
				 // $object['date_created']=$today;
				  $res=$this->model->updateData('cl_lists',$object,$args=['where'=>['id'=>$id]]);
				 if($res)
				 {
					 echo json_decode('1');die;
				 } 
			 }
		}
}