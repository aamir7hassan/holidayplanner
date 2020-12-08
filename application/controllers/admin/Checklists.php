<?php

class Checklists extends CI_Controller

{
	public function __construct()
		{
			parent::__construct();
			if(isAdmin()==false){
				return redirect('login');
			}
		}
   
		public function checklisten() {
			$id=$this->session->userdata('userId');
			$des=$this->model->getData('cl_desc','all_array',$args=[]);
			$objects=$this->model->getData('cl_lists','all_array',$args=[]);
			$cl_lists=$this->model->getData('cl_lists','all_array',$args=[]);
			$this->load->view('admin/checklisten',['object'=>$objects,'des'=>$des,'cl_lists'=>$cl_lists,'title'=>'Checklisten']);
		}
        public function detail_view(){
			
			$id=$this->uri->segment(4);
			$data=$this->model->getData('cl_lists','row_array',$args=['where'=>['id'=>$id]]);
			$des=$this->model->getData('cl_desc','all_array',$args=[]);
			$this->load->view('admin/detail_view',['item'=>$data,'des'=>$des]);
			
		}
		public function filter() {
		  $type=$this->uri->segment(3);
		  if($type=="open") { 
			  $data["title"] ="Checklisten offen";
			  $des=$this->model->getData('cl_desc','all_array',$args=[]);
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>0,'locked'=>0]]);
				
				
				$vv=[];
				$query='SELECT DISTINCT sv_id,object_supervisor FROM cl_lists';
				$cl_list = $this->model->query($query,'all_array');
				foreach($cl_list as $c)
				{
					
					
					 $d=$this->model->getData('cl_lists','count_array',$args=['where'=>['sv_id'=>$c['sv_id'],'checked'=>0,'locked'=>0]]);
					 $vv[]=['count'=>$d,'c_id'=>$c['sv_id']];
					
					
					 
				}
			     
				$this->load->view('admin/open',['object'=>$dataa,'des'=>$des,'cl_list'=>$cl_list,'count'=>$vv,'title'=>$data["title"]]);
				
			}
			else if($type=="checked") {
				$data["title"] ="Checklisten abgegeben";
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>1]]);
				
				$vv=[];
				$query='SELECT DISTINCT sv_id,object_supervisor FROM cl_lists';
				$cl_list = $this->model->query($query,'all_array');
				foreach($cl_list as $c)
				{
					
					
					 $d=$this->model->getData('cl_lists','count_array',$args=['where'=>['sv_id'=>$c['sv_id'],'checked'=>1]]);
					 $vv[]=['count'=>$d,'c_id'=>$c['sv_id']];
					
					
					 
				}
				$this->load->view('admin/checked',['object'=>$dataa,'cl_list'=>$cl_list,'count'=>$vv,'title'=>$data["title"]]);   
			}
			else if($type=="locked") {
				$data["title"] ="Checklisten gesperrt";
				$dataa=$this->model->getData('cl_lists','all_array',$args=['where'=>['checked'=>0,'locked'=>1]]);
				
				$vv=[];
				$query='SELECT DISTINCT sv_id,object_supervisor FROM cl_lists';
				$cl_list = $this->model->query($query,'all_array');
				foreach($cl_list as $c)
				{
					
					
					 $d=$this->model->getData('cl_lists','count_array',$args=['where'=>['sv_id'=>$c['sv_id'],'checked'=>0,'locked'=>1]]);
					 $vv[]=['count'=>$d,'c_id'=>$c['sv_id']];
					
					
					 
				}
				$this->load->view('admin/locked',['object'=>$dataa,'cl_list'=>$cl_list,'count'=>$vv,'title'=> $data["title"]]); 
			}
			else if($type=='erstellen') {
				$data["title"]="Quartalslisten erstellen";
				$dataa=$this->model->getData('cl_status','all_array',$args=[]);
				$this->load->view('admin/checklists',['data'=>$dataa,'title'=>$data["title"]]); 
			}
		  
	  }

		public function ajax() {				
			if($this->input->post('req')=='superviosr_data_open') {
				$sv_id=$this->input->post('id');
				$data=$this->model->getData('cl_lists','all_array',$args=['where'=>['sv_id'=>$sv_id,'checked'=>0,'locked'=>0]]);
				$count=sizeof($data);
			
				$html[]="";
				$html1="";
				$Individuell='Individuell';
				$ReCheck='ReCheck';
				for($i=0; $i<$count; $i++) {
					if($data[$i]['year']>0){
						$html1='<td>'."<div class=\"avg avg_kontrolle quartal\">".$data[$i]['quarter']."Q/" . $data[$i]['year']. "</div>".'</td></tr>';
					}
					else if($data[$i]['re_check']>0) {
						$html1='<td>'."<div class=\"avg avg_kontrolle avg_red\">".$ReCheck."</div>".'</td></tr>';
					}
					else{
						$html1='<td>'."<div class=\"avg avg_kontrolle aktiv\">".$Individuell."</div>".'</td></tr>';
					}

					$res = $this->model->getData('objects','row_array',$args=['where'=>['ktr_number'=>$data[$i]['ktr_number']]]);
					$res2 = $this->model->getData('users','row_array',$args=['where'=>['id'=>$res['created_by']]]);

					$html[]='<tr><td>'.$data[$i]['ktr_number']. 
								 '</td><td>'.$data[$i]['object_name'].
								 '</td><td>'.$res2['fname'] . " " . $res2['lname'].
								 '</td><td>'.$data[$i]['object_nl']. 
								 '</td><td>'.$data[$i]['object_supervisor'].
								 '</td><td>'.$data[$i]['begin_date'].
								 '</td><td>'.$data[$i]['end_date'].'</td>'.$html1;
					
				}
				if($html) {
				  echo json_encode(['data'=>$html]);die;
				}
			}

			if($this->input->post('req')=='superviosr_data_checked')
			{
				$sv_id=$this->input->post('id');
				$data=$this->model->getData('cl_lists','all_array',$args=['where'=>['sv_id'=>$sv_id,'checked'=>1]]);
				$count=sizeof($data);
			
					$html[]="";
				$html1="";
				$Individuell='Individuell';
				$ReCheck='ReCheck';
			
				for($i=0; $i<$count; $i++)
				{
					if($data[$i]['year']>0){
					$html1='<td>'."<div class=\"avg avg_kontrolle quartal\">".$data[$i]['quarter']."Q/" . $data[$i]['year']. "</div>".'</td>';
				}
				else if($data[$i]['re_check']>0) {
					$html1='<td>'."<div class=\"avg avg_kontrolle avg_red\">".$ReCheck."</div>".'</td>';
				}
				else{
					$html1='<td>'."<div class=\"avg avg_kontrolle aktiv\">".$Individuell."</div>".'</td>';
				}
					$html2='<td>'.$data[$i]['avg'].'</td></tr>';
					$html[]='<tr><td>'.$data[$i]['ktr_number']. 
								'</td><td>'.$data[$i]['object_name'].'</td><td>'.$data[$i]['object_nl']. 
								'</td><td>' . $data[$i]['object_supervisor'].
								'</td><td>' .$data[$i]['begin_date'].
								'</td><td>' .$data[$i]['end_date'].'</td>'.$html1.$html2;
                                							
								 
					
					
				}
				
				if($html)
				
				{
				  echo json_encode(['data'=>$html]);die;
				}
				
				
			}
			if($this->input->post('req')=='superviosr_data_locked')
			{
				$sv_id=$this->input->post('id');
				$data=$this->model->getData('cl_lists','all_array',$args=['where'=>['sv_id'=>$sv_id,'checked'=>0,'locked'=>1]]);
				$count=sizeof($data);
			
					$html[]="";
				$html1="";
				$Individuell='Individuell';
				$ReCheck='ReCheck';
				for($i=0; $i<$count; $i++)
				{
					if($data[$i]['year']>0){
					$html1='<td>'."<div class=\"avg avg_kontrolle quartal\">".$data[$i]['quarter']."Q/" . $data[$i]['year']. "</div>".'</td></tr>';
				}
				else if($data[$i]['re_check']>0) {
					$html1='<td>'."<div class=\"avg avg_kontrolle avg_red\">".$ReCheck."</div>".'</td>';
				}
				else{
					$html1='<td>'."<div class=\"avg avg_kontrolle aktiv\">".$Individuell."</div>".'</td>';
				}
			
					$html[]='<tr><td>'.$data[$i]['ktr_number']. 
								'</td><td>'.$data[$i]['object_name'].'</td><td>'.$data[$i]['object_nl']. 
								'</td><td>' . $data[$i]['object_supervisor'].
								'</td><td>' .$data[$i]['begin_date'].
								'</td><td>' .$data[$i]['end_date'].'</td>'.$html1;
                                							
								 
					
					
				}
				
				if($html)
				{
				  echo json_encode(['data'=>$html]);die;
				}
				
				
			}
			if($this->input->post('req')=='checked_data')
			{
				$id=$this->input->post('id');
				$res=$this->model->getData('cl_lists','all_array',$args=[]);
				if($res){
					echo json_encode(['data'=>$res]);die;
				}
				else{
					echo json_encode('0');die;
				}
				
			}
			 if($this->input->post('req')=='checklist')
				 
			 {  
			 
			   
			   // $today = date("d.m.Y H:i:s"); 
				$staff=$this->input->post('text');
				$notes=$this->input->post('note');
				$id=$this->input->post('id');
				$des=$this->model->getData('cl_desc','all_array',$args=[]);
				$radiovalue=$this->input->post('radio');
				 foreach($radiovalue as $key => $data)
				 
				 {
					 
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
				
				 $rating=implode("",$rating);
				 
				 $admin_id=$this->session->userdata["userId"];
				 $users=$this->model->getData('users','row_array',$args=['where'=>['id'=>$admin_id]]);
				  //REMOVED FROM YOU
				
				 $object['notes']=$notes;
				 $object['staff']=$staff;
				 $object['checked']='1';
				 $object['rating']=$rating;
				  $object['created_by']= $users['role'];
				 // $object['date_created']=$today;
				  $res=$this->model->updateData('cl_lists',$object,$args=['where'=>['id'=>$id]]);
				 if($res) {echo json_decode('1');die;}
			 }
			
			if($this->input->post('req')=='update_quarter')	{ 
			
        $today = date("d.m.Y H:i:s"); 	
				$id=$this->input->post('id');
				$data=$this->model->getData('cl_status','row_array',$args=['where'=>['quarter'=>$id]]);
				$quater_id=$data['id'];
				if($id!=1)
				{
				$lockquater=$id-1;
				$ldata=$this->model->getData('cl_status','row_array',$args=['where'=>['quarter'=>$lockquater]]);
				$lqua =$ldata["quarter"];
			    $lyear=$ldata["year"];
				}
				else if($id==1)
				{
				 $lockquater=4;	
				 $ldata=$this->model->getData('cl_status','row_array',$args=['where'=>['quarter'=>$lockquater]]);
				$lqua =$ldata["quarter"];
			    $lyear=$ldata["year"];
					
				}
			  $qua =$data["quarter"];
			  $year=$data["year"];
				if($qua==1) {
					$qqbegin_date='01.01.'.$year.'';
					$qqend_date='31.03.'.$year.'';
				}
				else if($qua==2) {
					$qqbegin_date='01.04.'.$year.'';
					$qqend_date='30.06.'.$year.'';
				}
				else if($qua==3) {
					$qqbegin_date='01.07.'.$year.'';
					$qqend_date='30.09.'.$year.'';
				}
				else if($qua==4) {
					$qqbegin_date='01.10.'.$year.'';
					$qqend_date='31.12.'.$year.'';
				}
				//lock quater
				if($lqua==1) {
					$lqbegin_date='01.01.'.$lyear.'';
					$lqend_date='31.03.'.$lyear.'';
				}
				else if($lqua==2) {
					$lqbegin_date='01.04.'.$lyear.'';
					$lqend_date='30.06.'.$lyear.'';
				}
				else if($lqua==3) {
					$lqbegin_date='01.07.'.$lyear.'';
					$lqend_date='30.09.'.$lyear.'';
				}
				else if($lqua==4) {
					$lqbegin_date='01.10.'.$lyear.'';
					$lqend_date='31.12.'.$year.'';
				}
			


/*				 $object=$this->model->getData('cl_lists','all_array',$args=[]);
                     if($object){						  
						 foreach($object as $ob)	{
							//$begin_date=strtotime(date('d.m.Y',strtotime($ob['begin_date'])));
							
							//$end_date=strtotime(date('d.m.Y',strtotime($ob['end_date'])));
							//$qbegin_date =strtotime(date('d.m.Y',strtotime($lqbegin_date)));
							//$qend_date =strtotime(date('d.m.Y',strtotime($lqend_date)));
//if((($qbegin_date<=$begin_date)&&($qend_date>=$begin_date)&&($qend_date>=$end_date)&&($qend_date>=$begin_date)&&($qbegin_date<=$end_date))|| (($qbegin_date<=$begin_date)&&($qend_date>=0 )&&( $begin_date<=$qend_date) ))
     // {
	                          
								$id=$ob['id'];
		
                $lobject['locked']=1;
           			$created=1;  

								//$res=$this->model->updateData('cl_lists',$lobject,$args=['where'=>['id'=>$id,'created_by'=>$created]]);
							}
						 }*/

						$res=$this->model->updateData('cl_lists',['locked'=>'1'],$args=['where'=>['created_by'=>'1', 'checked'=>'0', 'locked'=>'0']]);	//<= schnelle Methode, um alle vom Admin generierten ungeprüften Quartalslisten zu sperren

						$object=$this->model->getData('objects','all_array',$args=[]);						
						 foreach($object as $ob)	{
							$begin_date=strtotime(date('d.m.Y',strtotime($ob['begin_date'])));
							$end_date=strtotime(date('d.m.Y',strtotime($ob['end_date'])));
							$qbegin_date =strtotime(date('d.m.Y',strtotime($qqbegin_date)));
							$qend_date =strtotime(date('d.m.Y',strtotime($qqend_date)));
							//if((($qbegin_date<=$begin_date)&&($qend_date>=$begin_date)&&($qend_date>=$end_date)&&($qend_date>=$begin_date)&&($qbegin_date<=$end_date))|| (($qbegin_date<=$begin_date)&&($qend_date>=0 )&&( $begin_date<=$qend_date) ))
							 if($end_date>$qend_date || $ob['end_date'] == '')
							 {
								$ob_id=$ob['id'];
			           $objects=$this->model->getData('objects','row_array',$args=['where'=>['id'=>$ob_id]]);
								 $supervisor_id=$objects['object_supervisor'];
								 $created_by=$objects['created_by'];
								 $object_nl_id=$objects['object_nl'];
								 $object_s=$this->model->getData('users','row_array',$args=['where'=>['id'=>$supervisor_id]]);
								 $users=$this->model->getData('users','row_array',$args=['where'=>['id'=>$created_by]]);
								 $object_name=$this->model->getData('object_nl','row_array',$args=['where'=>['id'=>$object_nl_id]]);
								 $object_nl_name=$object_name['nl_name'];
								 $objectt['ktr_number']=$objects['ktr_number'];	
								 $objectt['object_nl']=$object_nl_name;
								 $objectt['begin_date']=$objects['begin_date'];
								 $objectt['end_date']=$objects['end_date'];
								 $objectt['quarter']=$qua;
				         $objectt['year']=$year;
								 $objectt['created_by']=1;
								 $objectt['sv_id']=$supervisor_id;
								 $objectt['date_created']=$today;
								 $objectt['object_name']=$objects['object_name'];
								 $objectt['object_supervisor']=$object_s['lname'];
								 
				         $res=$this->model->insertData('cl_lists',$objectt);
        			}
							
						 }		 
					// }
						 
			
				$ress=$this->model->updateData('cl_status',['status'=>'1'],$args=['where'=>['id'=>$quater_id]]);	
				if($ress) {echo json_decode('1');die;}
			}
		}///end of ajax
		
		
		
}  // end class
