<?php

class Dashboard extends CI_Controller

{
	public function __construct()
		{
			parent::__construct();
			if(isSupervisor()==false) {
				return redirect('login');
			}
		}

		public function index()
		{
			$data['title'] = "Bereichsleiter Dashboard";
			$sess_id=get_userId();
			 	$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";
			$res = $this->model->query($q,'all_array');
			$data['attendance'] = $res;
			$data["categories"]=$this->model->getData("categories","all_array",$args=["where"=>["is_active"=>"1"],'order'=>['col'=>'order','type'=>'ASC']]);
			$data["data_set"]=array();
			$n=count($data["categories"]);
			for($i=1;$i<=$n;$i++)
			{
				array_push($data["data_set"],"0.0");
			}
			$data['data_max']="0";
			if(!empty($_POST["staffid"]))
			{
				$staff_id=$_POST["staffid"];
				$r= $this->model->getData("staff",'row_array',$args=["where"=>["id"=>$staff_id]]);
				$date=explode("/",$_POST["date"]);
				$date_m=$date[0];
				$date_y=$date[1];
				$rid= $this->model->getData("holiday_ent",'row_array',$args=["where"=>["staff_id"=>$staff_id,'year'=>$date_y]]);
				$data["data_max"]=$rid["holiday_ent"];
				$res = $this->model->getData("attendance",'row_array',$args=["where"=>["staff_id"=>$staff_id,'year'=>$date_y]]);
				$data["data_set"]=array();
				foreach($data["categories"] as $cat)
				{
					$pt=$res["pattern"];
					$pt1=explode(",",$pt);
					$i=0;
					if(!empty($pt))
					{
						foreach($pt1 as $pat)
						{
							$pattern=explode(" ",$pat);
							if($pattern[3]==$cat["id"] && $pattern[1]==$date_m && $pattern[2]==$date_y) {
								++$i;
							}
						}
					}
					array_push($data["data_set"],$i);
				}
			} else {

				$rid= $this->model->getData("staff",'row_array',$args=["select top 1"=>["*"]]);
				$date_m=date('m');
				$date_y=date('Y');
				$r= $this->model->getData("holiday_ent",'row_array',$args=["where"=>["staff_id"=>$rid['id'],'year'=>$date_y]]);
				$data["data_max"]=$r["holiday_ent"];
				$res = $this->model->getData("attendance",'row_array',$args=["where"=>["staff_id"=>$rid['id'],'year'=>$date_y]]);
				$data["data_set"]=array();
				foreach($data["categories"] as $cat)
				{
					$pt=$res["pattern"];
					$pt1=explode(",",$pt);
					$i=0;
					if(!empty($pt))
					{
					foreach($pt1 as $pat)
					{
						$pattern=explode(" ",$pat);
						if($pattern[3]==$cat["id"] && $pattern[1]==$date_m && $pattern[2]==$date_y)
						{
							++$i;
						}
					}
					}
					array_push($data["data_set"],$i);
				}
			}
			$data['staff'] = $this->model->getData('staff','all_array',$args=['where'=>['supervisor'=>get_userId()],'select'=>['id','fname','lname']]);

			$this->load->view("supervisor/index",$data);

		}
		
		 
		
		public function Antrag_auf_Mehrarbeit($type)
		{
			$data['title'] = "Antrag auf Mehrarbeit";
			$uid = get_userId();
			if($type=="pending") {
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['user_id'=>$uid,'approved'=>'0'],'order'=>['col'=>'id','type'=>'desc']]);
				$this->load->view('supervisor/list_antrag_auf_mehrarbeit',$data);
			} elseif($type=='rejected') {
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['user_id'=>$uid,'approved'=>'2'],'order'=>['col'=>'id','type'=>'desc']]);
				$this->load->view('supervisor/list_antrag_auf_mehrarbeit',$data);
			} elseif($type=='approved') {
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['user_id'=>$uid,'approved'=>'1'],'order'=>['col'=>'id','type'=>'desc']]);
				$this->load->view('supervisor/list_antrag_auf_mehrarbeit',$data);
			} else {
				// show detail here
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$type]]);
				if($chk==null) {
					_flashPop(false,'','Invalid id , try again');
					return redirct('supervisor/antrag-auf-mehrarbeit/checked');
				} else {
					$data['title'] = 'Antrag auf Mehrarbeit';
					$data['item'] = $chk;
					$this->load->view('supervisor/antrag_auf_mehrarbeit_detail',$data);
				}
			}
		}
		
		public function add_antrag_auf_mehrarbeit() {
			$data['title'] = "submit formular";
			$this->load->view('supervisor/formular',$data);
		}
		
		public function processFormular() {
			$post = $this->input->post();
			
			if(isset($post['check_box']))
			{
				$check_box="1";
			}
			else if(isset($post['check_box'])=="")
			{
				$check_box="0";
			}

			$arr = array(
				'user_id'	=> get_userId(),
				'object'	=> test_input($post['objekt']),
				'employee_name' => test_input($post['employee']),
				'time_from'		=> test_input($post['zeitfenster_von']),
				'time_untill'	=> test_input($post['zeitfenster_bis']),
				'no_of_hours'	=> str_replace(",", ".", test_input($post['hours'])),		//ersetzt alle , durch . von den Bereichsleitern bei der Stundeneingabe im Antrag für Mehrarbeit
				'justification'	=> test_input($post['message']),
				'place'			=> test_input($post['place']),
				'applicants_name' => $this->session->userdata('fname')." ".$this->session->userdata('lname'),
				'date_created' => date('Y-m-d H:i:s'),
				'check_box'=>$check_box
			);
			$res = $this->model->insertData('application_overtime',$arr);
			$arr['id'] =  $this->db->insert_id();
			$from = email_sender();
			$subject = "[Antrag auf Mehrarbeit | Eingang] " . test_input($post['employee']) . ", " . test_input($post['objekt']) . "   (" . $this->session->userdata('fname')." ".$this->session->userdata('lname') . ")";
			// send email to Admin . 
			$arr['status'] = "admin";
			$mesg = $this->load->view('email_temp',$arr,true);
			// get all admins that have permission to receive new forular request in notirifcation table
			$admins = $this->model->getData('notification','all_array',$args=['where'=>['new_request'=>'1']]) ;
			$adminEmails = array_column($admins,'admin');
			foreach($adminEmails as $mail=>$mails) {
				if(!empty($mails) || !empty($from)) {
					send_mail($mails,$from,$subject,$mesg);
				}
			}	
			// send meail to USER
			$tos = $this->session->userdata('email');
			$arr['status'] = "user";
			$mesg = $this->load->view('email_temp',$arr,true);
			if(!empty($tos) || !empty($from)) {
				send_mail($tos,$from,$subject,$mesg);
			}
			_flashPop($res,'Antrag erfolgreich &uuml;bertragen!','Error in submitting formular, try again');
			return redirect('supervisor/antrag-auf-mehrarbeit/pending');
			
		}
		
		public function public_holidays()
		{
			$data['title'] = 'Ferien & Feiertage';
			$data['states'] = $this->model->getData('states','all_array',$args=['']);
			$svs = $this->model->getData('sv_holidays','row_array',$args=['where'=>['sv_id'=>get_userId()]]);
			$data['sv_holidays'] = $svs;
			$data['items'] = $this->model->getData('public_holidays','all_array',$args=['']);
			$this->load->view('supervisor/public_holidays',$data);
		}

		public function list_staff()
		{
			$data['title'] = "Mitarbeiter";
			//$staff=$this->model->getData("staff","all_array",$arg=['where'=>["supervisor"=>get_userId()]]);
			$q = "select s.*,s.id as sid, a.*,e.holiday_ent  , a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id
			inner join holiday_ent as e on e.staff_id=s.id where s.supervisor=". get_userId()." && e.year=". date('Y') ."&& a.year=".date('Y');

			$res = $this->model->query($q,'all_array');
			$data['staff'] = $res;
			$this->load->view("supervisor/staff/index",$data);
		}

		public function add_staff()
		{
			$data["title"]="Mitarbeiter hinzufügen";
			$this->load->view("supervisor/staff/add",$data);
		}
		
		/*** 
			
			Start attendance function 
		
		***/
		public function attendance()
		{
			$weekends=array();
			$cyear = date('Y');
			//var_dump("hahahahah");die;
			if(!empty($_POST["s_date"]))
			{
				$date=date("1");
				$week="";
				$month_end=date("t",strtotime($_POST["s_date"]));
				$date_m=date("m",strtotime($_POST["s_date"]));
				$date_y=date("Y",strtotime($_POST["s_date"]));
				for($i=$date;$i<=$month_end;$i++)
				{
					$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
					if($weekDay == 6 || $weekDay == 7)
					{
						$week=date("d m Y",strtotime($i."-".$date_m."-".$date_y));
						array_push($weekends,$week);
					}
				}
				$data["weekends"]=$weekends;
				$cyear = $date_y;
			} else {
				$date=date("1");
				$week="";
				$month_end=date("t");
				$date_m=date("m");
				$date_y=date("Y");
				for($i=$date;$i<=$month_end;$i++)
				{
					$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
					if($weekDay == 6 || $weekDay == 7)
					{
						$week=date("d m Y",strtotime($i."-".$date_m."-".$date_y));
						array_push($weekends,$week);
					}
				}
				$data["weekends"]=$weekends;
			}
			if(!empty($_POST["s_date"]))
			{
				$data["s_date"]=$_POST["s_date"];
			} else	{
				$data["s_date"]=date("d-M-Y");
			}
			$data['title'] = "Urlaubsplaner";
			$sess_id=get_userId();
			//var_dump($cyear);
			$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' && a.year=$cyear";
			//var_dump($q);exit;
			if(!empty($_POST["dept"])){
				$cyear=date("Y");
				$dept=$_POST["dept"];
				if($dept=="1")
				{
					$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' && a.year=$cyear order by lname";
				} else {
				 $q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' AND s.department='$dept' && a.year=$cyear order by lname";
			 	}
			}elseif(isset($_POST["dept"]) && $_POST["dept"]==""){
				$cyear=date("Y");
				$dept=$_POST["dept"];
				if($dept=="1")
				{
					$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' && a.year=$cyear order by lname";
				} else {
				 $q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' AND s.department='$dept' && a.year=$cyear order by lname";
			 	}
			}	else {
				$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' && a.year=$cyear order by lname";
				$tes = $this->model->query($q,'all_array');
				if(count($tes)==0) {
					$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' order by lname";
				}
			}
			$data['staff'] = $this->model->query($q,'all_array');
					//var_dump($q);exit;
			$q = "select s.*,s.department as dept from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";
			$data['dept'] = $this->model->query($q,'all_array');
			$data['categories'] = $this->model->getData('categories','all_array',$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);
			$qs = "select * from public_holidays where  month(start_date) = $date_m OR month(end_date) = $date_m";
			
			$qres = $this->model->query($qs,'all_array');
			$data['public_holidays'] = $qres;
			$data['sv_holidays'] = $this->model->getData('sv_holidays','row_array',$args=['where'=>['sv_id'=>$sess_id]]);
			$data['settings'] = $this->model->getData('settings','row_array',$args=[]);
			$data["dept_sel"]=isset($_POST["dept"])?$_POST["dept"]:"0";
			$this->load->view("supervisor/staff/attend",$data);
		} 
		
		/*** 
		
			end attendance function
		
		***/


		public function pdf()

		{

			$weekends=array();

			if(!empty($_POST["s_date"]))

			{

			$date=date("1");

			$week="";

			$month_end=date("t",strtotime($_POST["s_date"]));

			$date_m=date("m",strtotime($_POST["s_date"]));

			$date_y=date("Y",strtotime($_POST["s_date"]));

			for($i=$date;$i<=$month_end;$i++)

            {

             	$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));

				if($weekDay == 5 || $weekDay == 6)

				{

					$week=date("d m Y",strtotime($i."-".$date_m."-".$date_y));

				}

				array_push($weekends,$week);

			}

			$data["weekends"]=$weekends;

			}else

			{

			$date=date("1");

			$week="";

			$month_end=date("t");

			$date_m=date("m");

			$date_y=date("Y");

			for($i=$date;$i<=$month_end;$i++)

            {

             	$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));

				if($weekDay == 6 || $weekDay == 7)

				{

					$week=date("d m Y",strtotime($i."-".$date_m."-".$date_y));

					array_push($weekends,$week);

				}

			}

			$data["weekends"]=$weekends;

			}

			if(!empty($_POST["s_date"]))

			{

			$data["s_date"]=$_POST["s_date"];

			}else

			{$data["s_date"]="";}

			$data['title'] = "Urlaubsplaner";

			$sess_id=get_userId();

			 $q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";

			if(!empty($_POST["dept"]))

			{

			$dept=$_POST["dept"];

			if($dept=="1")

			{

			$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";

			}else

			{

			 $q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' AND s.department='$dept'";

			 }

			}

			else{

			$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";

			}

			require_once APPPATH.'/third_party/pdf/vendor/autoload.php';

            $data['staff'] = $this->model->query($q,'all_array');

            $data['categories'] = $this->model->getData('categories','all_array',$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);

			$data['settings'] = $this->model->getData('settings','row_array',$args=['select'=>['weekend_color']]);

      $html = $this->load->view("supervisor/staff/pdfview",$data,true);



			$mpdf = new \Mpdf\Mpdf();

			$mpdf->WriteHtml($html);

			$mpdf->Output();

		}



		public function delete_staff()

		{

			if(!empty($this->input->post()))

			{

				$id=$this->input->post("id");

				$res=$this->model->deleteData("staff",["id"=>$id]);
				$res1=$this->model->deleteData('holiday_ent',['staff_id'=>$id]);
				if($res)

				{

					echo json_encode($res);

				}

			}

		}

		public function edit_staff($id)

		{
			$data['title'] = "Mitarbeiter bearbeiten";
			$data["staff"]=$this->model->getData("staff","row_array",$arg=["where"=>["id"=>$id]]);
			$data['holiday'] = $this->model->getData('holiday_ent','row_array',$args=['where'=>['staff_id'=>$id,'year'=>date('Y')]]);
			$this->load->view("supervisor/staff/update",$data);

		}

		public function update_staff()
		{
			$email = $this->input->post('email');
			$id = $this->input->post('id');
			$year = $this->input->post('year');
			$check = $this->model->getData('staff','count_array',$args=['where'=>['email'=>$email,'id!='=>$id,'email!='=>""]]);
			//var_dump($check);die;
			if($check==0) {
				$data=array(
					'fname'=>$_POST['firstname'],
					'lname'=>$_POST['lastname'],
					'email'=>$_POST['email'],
					'phone'=>$_POST['per_phone'],
					'department'=>$_POST['dept'],
				);
				$res=$this->model->updateData("staff",$data,$args=["where"=>["id"=>$_POST['id']]]);
				if($res)
				{
					_flashPop(true,'Mitarbeiter erfolgreich aktualisiert','');
					redirect('supervisor/list-staff');
				}else	{
					_flashPop(false,'','Fehler bei der Aktualisierung');
					redirect('supervisor/list-staff');
				}
			} else {
				_flashPop(false,'','E-Mail existiert bereits');
				return redirect('supervisor/list-staff');
			}

		} // end update_staff

		public function create()
		{
			$email = $this->input->post('email');
			$chk=0;
			if($email!="") {
				$chk = $this->model->getData('staff','count_array',$args=['where'=>['email'=>$email]]);
			}
			$year = date("Y",strtotime("0 year"));
			$plus_year = date("Y",strtotime("+10 year"));
			if($chk==0) {
				$data=array(
					'fname'=>$_POST['firstname'],
					'lname'=>$_POST['lastname'],
					'email'=>$_POST['email'],
					'phone'=>$_POST['per_phone'],
					'department'=>$_POST['dept'],
					'supervisor'=>$_SESSION["userId"],
					'date_created'=>date("Y-m-d H:i:s"),
				);
				$res=$this->model->insert_id("staff",$data);
				$data=array("staff_id"=>$res,'year'=>date('Y'));
				$r=$this->model->insertData("attendance",$data);
				for($i=$year;$i<=$plus_year;$i++){
						$checkY = $this->model->getData('holiday_ent','count_array',$args=['where'=>['year'=>$i,'staff_id'=>$res]]);
					if($checkY==0) {
						$arr = array(
							'staff_id'		=> $res,
							'holiday_ent'	=> $_POST['holiday_ent'],
							'year'				=> $i,
						);
						$this->model->insertData('holiday_ent',$arr);
					} else {
						$this->model->updateData('holiday_ent',['holiday_ent'=>$_POST['holiday_ent']],$args=['where'=>['year'=>$i,'staff_id'=>$res]]);
					}
				}
				if($res && $r) {
					//_flashPop(true,'Mitarbeiter erfolgreich hinzugefügt','');
					redirect('supervisor/list-staff');
				} else	{
					//_flashPop(false,'','Error in creating staff,try again');
					redirect('supervisor/list-staff');
				}
			} else {
				//_flashPop(false,'','Email already exists,try different email');
				redirect('supervisor/list-staff');
			}

		} // end create

		public function print_report()
		{
			$chk_date=date("Y",strtotime($this->input->post("start_date")));
			$setting= $this->model->getData('settings','row_array',$args=['select'=>['weekend_color']]);
		  	$user_ids=array();

			$staff=$this->model->getData("staff","all_array",$args=['where'=>['supervisor'=>get_userId()]]);

			$categories=$this->model->getData("categories","all_array",$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);

			$attend=$this->model->getData("attendance","all_array",$args=["where"=>["year"=>$chk_date]]);

		if(!empty($_POST["staff_all"]) && $_POST["staff_all"]=="1")

		{

			foreach($staff as $key=>$val)

			{

				array_push($user_ids,$val["id"]);

			}

		}else

		{

			foreach($_POST as $key=>$val)

			{

				if(strpos($key,"staff_")!==false)

				{

					array_push($user_ids,$val);

				}

			}

		}

			$html="";

			$date=date("t");
			$cols=(int)$date;
			if($cols==30)
			$cols=$cols+2;
		    else if($cols==31)
		    	$cols=$cols+1;
		    else if($cols==29)
		    	$cols=$cols+3;
			$monthyear = date('M Y');

			$monthYEAR = date('m Y');
			$html=$html.'<!DOCTYPE html>';
			$html=$html.'<html>';
			$html=$html.'<head>';

			$html=$html.'

			<style>
th{

			border-bottom:1px solid;

			border-top:1px solid;

			padding:1px;

			}

			td{

				padding-top:5px;

				padding-bottom:2px;

				border:1px solid;

			}
				.parent {
				  position:relative;
				  width:24px;
				  }
				  .left {
				  position: absolute;
				  top: -7.5px;
				  width:12px;
				  background-color:#ccc;
				  }
				  .right{
				  	top:-7.5px;
				  position:absolute;
				  width:12px;
				  left:12px;
				  background-color:#ccc
				  }
						@media print {
					 .hidden-print {
					   display: none !important;
					 }
					}

			</style>

			';
			$sup_name=$this->session->userdata("fname")." ".$this->session->userdata("lname");
			$html=$html.'</head>';
			$html=$html."<body>";
			$html=$html.'<p style="text-align:right;margin-right:20px;"><i>Supervisor:</i><strong>'.$sup_name.'</strong></p>';
			$html=$html."<table>";

			$html=$html."<thead>";

			$html=$html."<tr>";
			$html=$html.'<th colspan="'.$cols.'" style="text-align:center;">'.$monthyear.'</th>';

			$html=$html."</tr>";

			$html=$html."<tr>";

			$date=date("d",strtotime($this->input->post("start_date")));

			$month_end=date("d",strtotime($this->input->post("end_date")));

			$html=$html.'<th colspan="2">Staff Name</th>';
			$date_m=date("m",strtotime($this->input->post("start_date")));
			$date_y=date("Y",strtotime($this->input->post("start_date")));
			for($i=$date;$i<=$month_end;$i++)
			{
				$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
                if($weekDay == 6 || $weekDay == 7)
                {
                    $color=$setting["weekend_color"];
                } else {
                    $color="#fff";
                }
                $d = $i;
                $day = date("w",strtotime($d."-".$date_m."-".$date_y));
                if($day==6) {
                    $days = "SA";
                } elseif($day==0) {
                    $days = "SO";
                } elseif($day==1) {
                  	$days = "MO";
                } elseif($day==2) {
                    $days = "DI";
               	} elseif($day==3) {
                    $days = "MI";
                } elseif($day==4) {
                    $days = "DO";
                } elseif($day==5) {
                    $days = "FR";
                }
				$html=$html.'<th style="text-align:center;background-color:'.$color.';">'.$i.'<br>'.$days.'</th>';

			}

			$html=$html."</tr>";

			$html=$html."</thead>";

			$html=$html."<tbody>";

			foreach($user_ids as $uId)

			{

				$skey=array_search($uId,array_column($staff,"id"));

				$akey=array_search($uId,array_column($attend,"staff_id"));

				$html=$html."<tr>";

				$html=$html.'<td colspan="2">'.$staff[$skey]["fname"]." ".$staff[$skey]["lname"].'</td>';

				$ptrn=$attend[$akey]["pattern"];

				$ptn=explode(",",$ptrn);

				for($i=$date;$i<=$month_end;$i++)

				{

					$html=$html.'<td>';

					$html=$html.'<div class="parent">';

					foreach($ptn as $pt)

					{

						if(!empty($pt))

						{

							$pattern=explode(" ",$pt);

							$ckey=array_search($pattern[3],array_column($categories,"id"));

							$color=$categories[$ckey]["color"];

							if($i==$pattern[0] && $pattern[1]==date("m",strtotime($this->input->post("start_date"))) && $pattern[2]== date("Y",strtotime($this->input->post("start_date"))))

							{

								if($pattern[4]=="0")

								{

									$html=$html.'<div style="background-color:'.$color.'" class="left half">&nbsp;&nbsp;&nbsp;&nbsp;</div>';

								}

								else if($pattern[4]=="1")

								{

									$html=$html.'  <div style="background-color:'.$color.'"  class="right half">&nbsp;&nbsp;&nbsp;&nbsp;</div>';

								}

							}

						}

					}

					$html=$html.'</div>';

					$html=$html.'</td>';

				}

				$html=$html."</tr>";

			}

			$html=$html."</tbody>";

			$html=$html."</table>";
			$html=$html."</body>";
			$html=$html."</html>";
			$data['html']=$html;
			$print=$this->load->view("print_temp",$data,true);
			require APPPATH.'third_party/html2pdf/vendor/autoload.php';
			$file=file_get_contents(APPPATH.'third_party/html2pdf/vendor/autoload.php');

			$html2pdf = new Spipu\Html2Pdf\Html2Pdf('L','A4');
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($print);
			$html2pdf->output();

		}
		public function print_ctrl()
		{
			$chk_date=date("Y",strtotime($this->input->post("start_date")));
		  	$user_ids=array();

			$staff=$this->model->getData("staff","all_array",$args=['where'=>['supervisor'=>get_userId()]]);

			$categories=$this->model->getData("categories","all_array",$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);

			$attend=$this->model->getData("attendance","all_array",$args=["where"=>["year"=>$chk_date]]);

		if(!empty($_POST["staff_all"]) && $_POST["staff_all"]=="1")

		{

			foreach($staff as $key=>$val)

			{

				array_push($user_ids,$val["id"]);

			}

		}else

		{

			foreach($_POST as $key=>$val)

			{

				if(strpos($key,"staff_")!==false)

				{

					array_push($user_ids,$val);

				}

			}

		}

			$html="";

			$date=date("t");
			$cols=(int)$date;
			if($cols==30)
			$cols=$cols+2;
		    else if($cols==31)
		    	$cols=$cols+1;
		    else if($cols==29)
		    	$cols=$cols+3;

			$monthyear = date('M Y');

			$monthYEAR = date('m Y');
			$html=$html.'<!DOCTYPE html>';
			$html=$html.'<html>';
			$html=$html.'<head>';

			$html=$html.'

			<style>

			th{

			border-bottom:1px solid;

			border-top:1px solid;

			padding:5px;

			}

			td{

				padding-top:5px;

				padding-bottom:5px;

				border:1px solid;

			}

							.parent {
  position:relative;
  width:30px;
  }
  .left {
  position: absolute;
  top: -10px;
  width:15px;
  background-color:#ccc;
  }
  .right{
  	top:-10px;
  position:absolute;
  width:15px;
  left:15px;
  background-color:#ccc
  }
				@media print {
					 .hidden-print {
					   display: none !important;
					 }
					}

			</style>

			';
			$html=$html.'</head>';
			$html=$html."<body>";
			$html=$html."<table>";

			$html=$html."<thead>";

			$html=$html."<tr>";
			$sup_name=$this->session->userdata("fname")." ".$this->session->userdata("lname");;
			$html=$html.'<th colspan="'.$cols.'" style="text-align:center;">'.$monthyear."&nbsp;&nbsp;-&nbsp;&nbsp;".$sup_name.'</th>';

			$html=$html."</tr>";

			$html=$html."<tr>";

			$date=date("d",strtotime($this->input->post("start_date")));

			$month_end=date("d",strtotime($this->input->post("end_date")));

			$html=$html.'<th colspan="2">Staff Name</th>';

			for($i=$date;$i<=$month_end;$i++)

			{

				$html=$html.'<th>'.date("$i").'</th>';

			}

			$html=$html."</tr>";

			$html=$html."</thead>";

			$html=$html."<tbody>";

			foreach($user_ids as $uId)

			{

				$skey=array_search($uId,array_column($staff,"id"));

				$akey=array_search($uId,array_column($attend,"staff_id"));

				$html=$html."<tr>";

				$html=$html.'<td colspan="2">'.$staff[$skey]["fname"]." ".$staff[$skey]["lname"].'</td>';

				$ptrn=$attend[$akey]["pattern"];

				$ptn=explode(",",$ptrn);

				for($i=$date;$i<=$month_end;$i++)

				{

					$html=$html.'<td>';

					$html=$html.'<div class="parent">';

					foreach($ptn as $pt)

					{

						if(!empty($pt))

						{

							$pattern=explode(" ",$pt);

							$ckey=array_search($pattern[3],array_column($categories,"id"));

							$color=$categories[$ckey]["color"];

							if($i==$pattern[0] && $pattern[1]==date("m",strtotime($this->input->post("start_date"))) && $pattern[2]== date("Y",strtotime($this->input->post("start_date"))))

							{

								if($pattern[4]=="0")

								{

									$html=$html.'<div style="background-color:'.$color.'" class="left half">&nbsp;&nbsp;&nbsp;&nbsp;</div>';

								}

								else if($pattern[4]=="1")

								{

									$html=$html.'  <div style="background-color:'.$color.'"  class="right half">&nbsp;&nbsp;&nbsp;&nbsp;</div>';

								}

							}

						}

					}

					$html=$html.'</div>';

					$html=$html.'</td>';

				}

				$html=$html."</tr>";

			}

			$html=$html."</tbody>";

			$html=$html."</table>";
			$html=$html."</body>";
			$html=$html."</html>";
			echo $html;
			echo "<br><h5 class='hidden-print' style='text-align:center'>Press CTRL+P to Print Report</h5><br>";

			echo '<div class="hidden-print" style="text-align:center"><a href="'.base_url('supervisor/attendance').'">Go Back</a></div>';
		}
		public function ajax()
		{
			
			if($this->input->post('req')=='setStatus')

			{

				$id = $this->input->post('id');

				$this->model->updateData('categories',['status'=>'1'],$args=['where'=>['id'=>$id]]);

				$this->model->updateData('categories',['status'=>'0'],$args=['where'=>['id!='=>$id]]);

				$cats = $this->model->getData('categories','all_array',$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);

				$data=[];

				$data[]="<button type='button' class='btn btn-danger' data-cid='0' id='erase'>ENTF</button>";

				foreach($cats as $val){
					if($val['status']=="1"){
						$font = "bolder";$class="selected";
					} else {
						$font="";$class="";
					}
					$data[].='<button type="button" data-cid="'.$val['id'].'" class="btn btnclr '.$class.'" data-color="'.$val['color'].'" style="background-color:'.$val['color'].';font-weight:'.$font.';color:#000">'.ucwords($val['name']).'</button>';

				}
				echo json_encode($data);die;
			} // end setStatus

			if($this->input->post('req')=='mark_attendance')
			{
				$clr="";
				$post = $this->input->post();
				$erase = test_input($post['erase']);
				if(isset($post['clr'])){
					$clr = test_input($post['clr']);
				}
				$uid = test_input($post['uid']);
				$cid = test_input($post['cid']);
				$input = test_input($post['input']);
				$pattern = test_input($post['pattern']);
				$fpattern = $pattern." ".$cid." ".$input;
				$exp = explode(' ',$pattern);
				$year = $exp[2];
				$in = substr($fpattern,0,2);
				if($erase=="1") {
					// echo "delete it <br>";
					//$res = $this->model->getData('categories','row_array',$args=['where'=>['color'=>$clr],'select'=>['id']]);
					//$idd = $res['id'];
					$idd = $clr;
					$srch = $pattern." ".$idd." ".$input;
					$res = $this->model->getData('attendance','row_array',$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
					$str = $res['pattern'];
					$arr = explode(",",$str);
					$del = array_search($srch,$arr,true);
					// var_dump($srch);
					// var_dump($arr);
					// var_Dump("del element ".$del);
					if($del!==false) {
						unset($arr[$del]);
						$fStr = implode(',',$arr);
						$this->model->updateData('attendance',['pattern'=>$fStr],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
						echo json_encode(array("status"=>true));
					}else{
						echo json_encode(array("status"=>false));
					}
					exit;
				}
					// update
					$day = $exp[0];
					$month = $exp[1];
					$cat = $cid;
					$res = $this->model->getData('attendance','row_array',$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
					$str = $res['pattern'];
					if(!empty($str)) {
					$expD = explode(',',$str); // 1 05 2019 1 1
						$fPat = explode(' ',$fpattern);
						$fDate = $fPat[0]; $fMonth = $fPat[1]; $fYear = $fPat[2]; $fCat = $fPat[3]; $fSt = $fPat[4];
						if(!in_array($fpattern,$expD)) {
								$arr =[];
								foreach($expD as $k=>$v) {
									$dbarr = explode(' ',$v);
									$aDate = $dbarr[0];  $aMonth = $dbarr[1]; $aYear = $dbarr[2]; $aCat = $dbarr[3];
									if($aDate==$fDate && $aMonth==$fMonth && $aYear==$fYear) {
										array_push($arr,$v);
									}
								}

								if(count($arr)>0) {
									foreach($arr as $key=>$val) { // this loop only runs 2 times, never > than 2 times
										if($val==$fpattern) {
											continue; // or die;
										}	else {
											$dbarr = explode(' ',$val);
											$aDate = $dbarr[0];  $aMonth = $dbarr[1]; $aYear = $dbarr[2]; $aCat = $dbarr[3]; $aSt = $dbarr[4];
											if(substr($val,0,2)==$in && $aMonth==$fMonth && $aYear==$fYear && $aCat==$fCat) {
												if($aSt==$fSt){
													echo "continue 1 ";
													continue;
												} else {
													$paten = $str.",".$fpattern;
													echo "me";
													$this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);die;
												}
											} else {
												if(substr($val,0,2)==$in && $aMonth==$fMonth && $aYear==$fYear) {
												echo "1 ";
													if($aSt!=$fSt) {
														echo "2 ";
														//continue;
														$delE = $aDate." ".$aMonth." ".$aYear." ".$aCat." ".$input;
														$key = array_search($delE, $expD);
														var_dump($fpattern);
														var_dump("del this ".$delE);
														var_dump($expD);
														if (false !== $key) {
																unset($expD[$key]);
														} else {
															//continue;
															//echo "continue";
														}
														if(count($expD)>0) {
															echo "oo ";
															$fStr = implode(',',$expD);
															$paten = $fStr.",".$fpattern;
														} else {
															echo "ppp ";
																$paten = $fpattern;
														}
														var_dump($paten);
														$this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
													} else {
														echo "3 <br>";
														$delE = $aDate." ".$aMonth." ".$aYear." ".$aCat." ".$input;
														$key = array_search($delE, $expD);
														if (false !== $key) {
																unset($expD[$key]);
														}
														if(count($expD)>0) {
															$fStr = implode(',',$expD);
															$paten = $fStr.",".$fpattern;
														} else {
																$paten = $fpattern;
														}
														$this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);die;
													}
												} else {
													echo "4 ";
													$paten = $str.",".$fpattern;
													$this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
												}
											}
										}
									}
								} else {
									echo "6";
									$paten = $str.",".$fpattern;
									$this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
								}
						} else {
							echo "7";
							die;
							// $paten = $str.",".$fpattern;
							// $this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);

							}
						} else {
							$chk = $this->model->getData('attendance','count_array',$args=['where'=>['year'=>$year]]);
							if($chk==0) {
								$staff = $this->model->getData('staff','all_array',$args=['select'=>['id']]);
								foreach($staff as $key=>$val) {
									$arr[] = array(
										'staff_id'	=> $val['id'],
										'year'			=> $year,
									);
								}
								$this->model->insertData('attendance',$arr,true);
								echo "8";
								$paten = $fpattern;
								//echo $paten;
								$res = $this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
								echo $res==true?"inserted":"error";
							} else {
								$paten = $fpattern;
								//echo $paten;
								$res = $this->model->updateData('attendance',['pattern'=>$paten],$args=['where'=>['staff_id'=>$uid,'year'=>$year]]);
								echo "updated";
							}

						}
			}

			if($this->input->post('req')=='chk_email') {

				$email = $this->input->post('email');
				$chk = $this->model->getData('staff','count_array',$args=['where'=>['email'=>$email]]);
				if($chk==0) {
					echo json_encode("<span class='text-success' data-email='1'>Email available</span>");die;
				} else {
					echo json_encode("<span class='text-danger' data-email='0'>Email not available,try different instead.</span>");die;
				}
			}

			if($this->input->post('req')=='chk_email_update') {
				$email = $this->input->post('email');
				$id = $this->input->post('id');
				$chk = $this->model->getData('staff','count_array',$args=['where'=>['email'=>$email,'id!='=>$id]]);
				if($chk==0) {
					echo json_encode("<span class='text-success' data-email='1'>Email available</span>");die;
				} else {
					echo json_encode("<span class='text-danger' data-email='0'>Email not available,try different instead.</span>");die;
				}
			}
				
			if($this->input->post('req')=='addHoliday') {
				$post = $this->input->post();
				$year = $post['year'];
				$sid = $post['sid'];
				$holiday = $post['holiday'];
				$checkY = $this->model->getData('holiday_ent','count_array',$args=['where'=>['year'=>$year,'staff_id'=>$sid]]);
				if($checkY==0) {
					$arr = array(
						'staff_id'		=> $sid,
						'holiday_ent'	=> $holiday,
						'year'				=> $year,
					);
					$res = $this->model->insertData('holiday_ent',$arr);
					echo $res==true?"1":"0";die;
				} else {
					$res = $this->model->updateData('holiday_ent',['holiday_ent'=>$holiday],$args=['where'=>['year'=>$year,'staff_id'=>$sid]]);
					echo $res==true?"1":"0";die;
				}
			}
				
			if($this->input->post('req')=='get_staff_holidays')
			{
				$id = $this->input->post('sid');
				$chk = $this->model->getData('holiday_ent','count_array',$args=['where'=>['staff_id'=>$id]]);
				if($chk==0) {
					echo "0";die;
				} else {
					$res = $this->model->getData('holiday_ent','all_array',$args=['where'=>['staff_id'=>$id],'order'=>['col'=>'year','type'=>'ASC']]);
					$arr=[];
					foreach($res as $key=>$val) {
						$arr[] = '<tr><td>'.$val['holiday_ent'].'</td><td>'.$val['year'].'</td><td><a href="#" data-editi="'.$val['id'].'" class="text-info editi"><span class="far fa-edit iconss"></span></a></td></tr>';
						//$arr[]='<tr><td>'.$val['holiday_ent'].'</td><td>'.$val['year'].'</td></tr>';
					}
					echo json_encode($arr);die;
				}
			} // end get_staff_holidays

			if($this->input->post('req')=='edit_holiday') {
				$id = $_POST['id'];
				$chk = $this->model->getData('holiday_ent','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo "0";die;
				} else {
					$res = $this->model->getData('holiday_ent','row_array',$args=['where'=>['id'=>$id]]);
					echo json_encode($res);die;
				}
			}
			if($this->input->post('req')=='get_staff') {
				$id = test_input($this->input->post('id'));
				$res = $this->model->getData('staff','row_array',$args=['where'=>['id'=>$id]]);
				echo json_encode($res);die;
			} // end get_staff

			if($this->input->post('req')=='save_staff') {
				$post = $this->input->post();
				$id = $post['id'];

				$chk = $this->model->getData('staff','count_array',$args=['where'=>['id'=>$id]]);
				if($chk>0) {
				$arr = array(
					'fname'			=> test_input($post['fname']),
					'lname'			=> test_input($post['lname']),
					'email'			=> test_input($post['email']),
					'department'=> test_input($post['dept']),
					'phone'			=> test_input($post['phone']),
				);

				$res = $this->model->updateData('staff',$arr,$args=['where'=>['id'=>$id]]);
				echo $res==true ? "1":json_encode('Error in updating record, try again');die;
			} else {
				echo json_encode('Invalid staff id');die;
			}

			}
			
			if($this->input->post('req')=='updateHoliday') {
				$post = $this->input->post();
				$year = $post['year']; 
				$sid = $post['sid'];
				$holiday = $post['holiday'];
				$checkY = $this->model->getData('holiday_ent','count_array',$args=['where'=>['year'=>$year,'id'=>$sid]]);
				if($checkY==0) {
					$arr = array(
						'holiday_ent'	=> $holiday,
						'year'			=> $year,
					);
					$res = $this->model->updateData('holiday_ent',$arr,$args=['where'=>['id'=>$sid]]);
					echo $res==true?"1":"0";die;
				} else {
					$res = $this->model->updateData('holiday_ent',['holiday_ent'=>$holiday],$args=['where'=>['id'=>$sid]]);
					echo $res==true?"1":"0";die;
				}
			} 
			

			if($this->input->post('req') == 'update_holiday') {
				$post = $this->input->post();
				$ids = implode(',',$post['ids']);
				$id = $post['id'];
				
				$arr = array(
					'state_ids'		=> $ids
				);
				$res = $this->model->updateData('sv_holidays',$arr,$args=['where'=>['id'=>$id]]);
				echo $res?json_encode('1'):json_encode('Error in updating record,try again');die;
			}

		} // end ajax

}  // end class
